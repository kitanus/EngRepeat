<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RusController extends TestController
{
    protected $dictionary;
    protected $format = "rus";

    public function __construct()
    {
        $this->dictionary = DB::table('dictionary')
            ->leftJoin('rus_to_eng', 'dictionary.id', '=', 'rus_to_eng.dictionary_id')
            ->get();
    }

    public function show()
    {
        $data = [
            "lastAnswer" => [],
            "post" => null,
            "words" => $this->dictionary,
            "format" => $this->format
        ];

        return $view = view('test', $data);
    }

    public function save(Request $request)
    {
        $data = [
            "lastAnswer" => $request->answer,
            "post" => true
        ];

        foreach ($this->dictionary as $key => $value)
        {
            $translate[$key] = $value->translate;
        }

        foreach (array_intersect($this->upperArr($translate), $this->upperArr($request->answer)) as $keyWin => $valueWin)
        {
            $this->setResult("rus_to_eng","win", $keyWin);
        }

        foreach (array_diff($this->upperArr($translate), $this->upperArr($request->answer)) as $keyLose => $valueLose)
        {
            $this->setResult("rus_to_eng","lose", $keyLose);
        }

        $data["format"] = $this->format;
        $data["words"] = $this->dictionary;

        return view('test', $data);
    }
}

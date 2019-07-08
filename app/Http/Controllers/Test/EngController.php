<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EngController extends TestController
{
    protected $dictionary;
    protected $format = "eng";

    public function __construct()
    {
        $this->dictionary = $this->reverseArr(DB::table('dictionary')
            ->leftJoin('eng_to_rus', 'dictionary.id', '=', 'eng_to_rus.dictionary_id')
            ->get(), "word", "translate");
    }

    public function show()
    {
        $data = [
            "lastAnswer" => [],
            "post" => null,
            "words" => $this->dictionary,
            "format" => $this->format
        ];

        return $view = view('layout/test', $data);
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
            $this->setResult("eng_to_rus","win", $keyWin);
        }

        foreach (array_diff($this->upperArr($translate), $this->upperArr($request->answer)) as $keyLose => $valueLose)
        {
            $this->setResult("eng_to_rus","lose", $keyLose);
        }

        $data["format"] = $this->format;
        $data["words"] = $this->dictionary;

        return view('layout/test', $data);
    }
}

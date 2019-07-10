<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\TestController;
use App\Models\RusToEng;
use Illuminate\Http\Request;

class RusController extends TestController
{
    protected $rusToEng;
    protected $format = "rus";

    public function __construct()
    {
        $this->rusToEng = RusToEng::with('dictionary')->get();
    }

    public function show()
    {

        $data = [
            "lastAnswer" => [],
            "post" => null,
            "words" => $this->rusToEng,
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

        foreach ($this->rusToEng as $key => $value)
        {
            $translate[$key] = $value->dictionary->translate;
        }

        foreach (array_intersect($this->upperArr($translate), $this->upperArr($request->answer)) as $keyWin => $valueWin)
        {
            $this->setResult((new RusToEng()),"win", $keyWin);
        }

        foreach (array_diff($this->upperArr($translate), $this->upperArr($request->answer)) as $keyLose => $valueLose)
        {
            $this->setResult((new RusToEng()),"lose", $keyLose);
        }

        $data["format"] = $this->format;
        $data["words"] = RusToEng::with('dictionary')->get();

        return view('layout/test', $data);
    }
}

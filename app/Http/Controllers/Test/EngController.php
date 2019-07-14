<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\TestController;
use App\Models\Languages\EngToRus;
use Illuminate\Http\Request;

class EngController extends TestController
{
    protected $engToRus;
    protected $format = "eng";

    public function __construct()
    {
        $this->engToRus = $this->reverseArr(EngToRus::with('dictionary')->get(), "word", "translate");
    }

    public function show()
    {
        $data = [
            "lastAnswer" => [],
            "post" => null,
            "words" => $this->engToRus,
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

        foreach ($this->engToRus as $key => $value)
        {
            $translate[$key] = $value->dictionary->translate;
        }

        foreach (array_intersect($this->upperArr($translate), $this->upperArr($request->answer)) as $keyWin => $valueWin)
        {
            $this->setResult((new EngToRus()),"win", $keyWin);
        }

        foreach (array_diff($this->upperArr($translate), $this->upperArr($request->answer)) as $keyLose => $valueLose)
        {
            $this->setResult((new EngToRus()),"lose", $keyLose);
        }

        $data["format"] = $this->format;
        $data["words"] = $this->reverseArr(EngToRus::with('dictionary')->get(), "word", "translate");

        return view('layout/test', $data);
    }
}

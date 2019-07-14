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
        $this->table = (new EngToRus());
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
            $this->translate[$key] = $value->dictionary->translate;
        }

        $this->saveResult($request);

        $data["format"] = $this->format;
        $data["words"] = $this->reverseArr(EngToRus::with('dictionary')->get(), "word", "translate");

        return view('layout/test', $data);
    }
}

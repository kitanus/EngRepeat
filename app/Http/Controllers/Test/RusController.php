<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\TestController;
use App\Models\Languages\RusToEng;
use Illuminate\Http\Request;

class RusController extends TestController
{
    protected $rusToEng;
    protected $format = "rus";

    public function __construct()
    {
        $this->rusToEng = RusToEng::with('dictionary')->get();
        $this->table = (new RusToEng());
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
            $this->translate[$key] = $value->dictionary->translate;
        }

        $this->saveResult($request);

        $data["format"] = $this->format;
        $data["words"] = RusToEng::with('dictionary')->get();

        return view('layout/test', $data);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{

    public function show($format)
    {
        $data = [
            "lastAnswer" => [],
            "post" => null,
            "format" => $format
        ];

        switch ($format)
        {
            case "rus":
                $data["words"] = DB::table('dictionary')->leftJoin('rus_to_eng', 'dictionary.id', '=', 'rus_to_eng.dictionary_id')->get();
                break;
            case "eng":
                $data["words"] = DB::table('dictionary')->leftJoin('eng_to_rus', 'dictionary.id', '=', 'eng_to_rus.dictionary_id')->get();
                foreach ($data["words"] as $key => $value)
                {
                    $mediator = $value->word;
                    $data["words"][$key]->word = $value->translate;
                    $data["words"][$key]->translate = $mediator;
                }
                break;
        }

        return $view = view('test', $data);
    }

    public function save(Request $request, $format)
    {

        $words = DB::table('dictionary')->get();
        $etr = DB::table('dictionary')->get();

        foreach($words as $key => $value)
        {
            switch ($format)
            {
                case "rus":
                    $translate[$key] = $value->translate;
                    break;
                case "eng":
                    $translate[$key] = $value->word;
                    break;
            }
        }

        foreach (array_intersect($this->upperArr($translate), $this->upperArr($request->answer)) as $keyWin => $valueWin)
        {
            switch ($format)
            {
                case "rus":
                    $store = DB::table("rus_to_eng")->get();
                    DB::table('rus_to_eng')
                        ->where('dictionary_id', $keyWin+1)
                        ->update(['win' => $store[$keyWin]->win+1]);
                    break;
                case "eng":
                    $store = DB::table("eng_to_rus")->get();
                    DB::table('eng_to_rus')
                        ->where('dictionary_id', $keyWin+1)
                        ->update(['win' => $store[$keyWin]->win+1]);
                    break;
            }
        }

        foreach (array_diff($this->upperArr($translate), $this->upperArr($request->answer)) as $keyLose => $valueLose)
        {
            switch ($format)
            {
                case "rus":
                    $store = DB::table("rus_to_eng")->get();
                    DB::table('rus_to_eng')
                        ->where('dictionary_id', $keyLose+1)
                        ->update(['lose' => $store[$keyLose]->lose+1]);
                    break;
                case "eng":
                    $store = DB::table("eng_to_rus")->get();
                    DB::table('eng_to_rus')
                        ->where('dictionary_id', $keyLose+1)
                        ->update(['lose' => $store[$keyLose]->lose+1]);
                    break;
            }
        }

        $data = [
            "words" => DB::table('dictionary')->get(),
            "lastAnswer" => $translate,
            "post" => true,
            "format" => $format
        ];

        switch ($format)
        {
            case "rus":
                $data["status"] = DB::table("rus_to_eng")->get();
                break;
            case "eng":
                $data["status"] = DB::table("eng_to_rus")->get();
                break;
        }

        return view('test', $data);
    }

    public function upperArr($arr)
    {
        foreach ($arr as $key => $value)
        {
            $arr[$key] = mb_strtoupper($value);
        }

        return $arr;
    }

}

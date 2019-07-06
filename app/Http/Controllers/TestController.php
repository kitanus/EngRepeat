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
            "format" => $format,
            "words" => $this->getFormatDictionary($format)
        ];

        return $view = view('test', $data);
    }

    public function save(Request $request, $format)
    {

        $words = DB::table('dictionary')->get();

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
            $this->setNewStatus($format, "win", $keyWin);
        }

        foreach (array_diff($this->upperArr($translate), $this->upperArr($request->answer)) as $keyLose => $valueLose)
        {
            $this->setNewStatus($format, "lose", $keyLose);
        }

        $data = [
            "lastAnswer" => $request->answer,
            "post" => true,
            "format" => $format,
            "words" => $this->getFormatDictionary($format)
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

    public function getFormatDictionary($format)
    {
        switch ($format)
        {
            case "rus":
                $dictionary = DB::table('dictionary')
                    ->leftJoin('rus_to_eng', 'dictionary.id', '=', 'rus_to_eng.dictionary_id')
                    ->get();
                break;
            case "eng":
                $dictionary = DB::table('dictionary')
                    ->leftJoin('eng_to_rus', 'dictionary.id', '=', 'eng_to_rus.dictionary_id')
                    ->get();
                foreach ($dictionary as $key => $value)
                {
                    $mediator = $value->word;
                    $dictionary[$key]->word = $value->translate;
                    $dictionary[$key]->translate = $mediator;
                }
                break;
            default:
                $dictionary = null;
        }

        return $dictionary;
    }

    public function setNewStatus($format, $kind, $index)
    {
        switch ($format)
        {
            case "rus":
                if(count(DB::table('rus_to_eng')->where("dictionary_id", $index+1)->get()) === 0)
                {
                    DB::table('rus_to_eng')->insert([
                        "win" => 0,
                        "lose" => 0,
                        "dictionary_id" => $index+1
                    ]);
                }

                $store = DB::table("rus_to_eng")->get();

                DB::table('rus_to_eng')
                    ->where('dictionary_id', $index+1)
                    ->update([$kind => ($kind == "win")?$store[$index]->win+1:$store[$index]->lose+1]);
                break;
            case "eng":
                if(count(DB::table('eng_to_rus')->where("dictionary_id", $index+1)->get()) === 0)
                {
                    DB::table('eng_to_rus')->insert([
                        "win" => 0,
                        "lose" => 0,
                        "dictionary_id" => $index+1
                    ]);
                }

                $store = DB::table("eng_to_rus")->get();

                DB::table('eng_to_rus')
                    ->where('dictionary_id', $index+1)
                    ->update([$kind => ($kind == "win")?$store[$index]->win+1:$store[$index]->lose+1]);
                break;
        }
    }
}

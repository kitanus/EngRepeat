<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckController extends Controller
{

    public $words;

    public function __construct()
    {
        $this->words = DB::table('words')->get();
    }

    public function index()
    {
        return view('check', [
            "words" => $this->words,
            "lastAnswer" => [],
            "post" => null
            ]);
    }

    public function save(Request $request)
    {

        foreach($this->words as $key => $value)
        {
            $translate[$key] = $value->translate;
        }

        foreach (array_intersect($this->upperArr($translate), $this->upperArr($request->order)) as $keyWin => $valueWin)
        {
            $final[$keyWin] = "win";
            DB::table('words')
                ->where('id', $keyWin+1)
                ->update(['win' => $this->words[$keyWin]->win+1]);
        }

        foreach (array_diff($this->upperArr($translate), $this->upperArr($request->order)) as $keyLose => $valueLose)
        {
            DB::table('words')
                ->where('id', $keyLose+1)
                ->update(['lose' => $this->words[$keyLose]->lose+1]);
        }

        return view('check', [
            "words" => DB::table('words')->get(),
            "lastAnswer" => $translate,
            "post" => true
        ]);
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

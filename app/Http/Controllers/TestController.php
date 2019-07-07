<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

abstract class TestController extends Controller
{

    abstract public function show();
    abstract public function save(Request $request);

    public function upperArr($arr)
    {
        foreach ($arr as $key => $value)
        {
            $arr[$key] = mb_strtoupper($value);
        }

        return $arr;
    }

    public function setResult($table, $kind, $index)
    {
        if(count(DB::table($table)->where("dictionary_id", $index+1)->get()) === 0)
        {
            DB::table($table)->insert([
                "win" => 0,
                "lose" => 0,
                "dictionary_id" => $index+1
            ]);
        }

        $store = DB::table($table)->get();

        DB::table($table)
            ->where('dictionary_id', $index+1)
            ->update([$kind => ($kind == "win")?$store[$index]->win+1:$store[$index]->lose+1]);
    }

    public function reverseArr($arr, $fField, $sField)
    {
        foreach ($arr as $key => $value)
        {
            $mediator = $value->word;
            $arr[$key]->$fField = $value->$sField;
            $arr[$key]->$sField = $mediator;
        }

        return $arr;
    }
}

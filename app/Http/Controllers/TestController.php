<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $tableUpdate = $table;

        if($tableUpdate->where("dictionary_id", $index+1)->count() === 0)
        {
            $tableUpdate->saveStatus(0,0,$index+1);
        }

        $store = $table->where('dictionary_id', $index+1)->get()[0];

        $table
            ->where('dictionary_id', $index+1)
            ->update([$kind => ($kind == "win")?$store->win+1:$store->lose+1]);
    }

    public function reverseArr($arr, $fField, $sField)
    {

        foreach ($arr as $key => $value)
        {
            $mediator = $value->dictionary->$fField;
            $arr[$key]->dictionary->$fField = $value->dictionary->$sField;
            $arr[$key]->dictionary->$sField = $mediator;
        }

        return $arr;
    }
}

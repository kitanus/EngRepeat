<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class TestController extends Controller
{

    protected $translate;
    protected $table;

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

    public function saveResult(Request $request)
    {
        foreach (array_intersect($this->upperArr($this->translate), $this->upperArr($request->answer)) as $keyWin => $valueWin)
        {
            $this->setResult("win", $keyWin);
        }

        foreach (array_diff($this->upperArr($this->translate), $this->upperArr($request->answer)) as $keyLose => $valueLose)
        {
            $this->setResult("lose", $keyLose);
        }
    }

    public function setResult($kind, $index)
    {
        $tableUpdate = $this->table;

        if($tableUpdate->where("dictionary_id", $index+1)->count() === 0)
        {
            $tableUpdate->saveStatus(0,0,$index+1);
        }

        $store = $this->table->where('dictionary_id', $index+1)->get()[0];

        $this->table
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

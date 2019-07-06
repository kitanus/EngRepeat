<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DictionaryController extends Controller
{
    public function show()
    {
        $dictionary = DB::table("dictionary")->get();

        return view('dictionary', [
            "dictionaries" => $dictionary
        ]);
    }

    public function new(Request $request)
    {
        $dictionary = DB::table("dictionary")->get();

        return view('dictionary', [
            "counts" => $request->count,
            "dictionaries" => $dictionary
    ]);
    }

    public function record(Request $request)
    {

        $rows = [];

        for($i=0; $i<count($request->word); $i++)
        {
            if(!is_null($request->word[$i]) && !is_null($request->translate[$i]))
            {
                $rows[$i] = [
                    "word" => $request->word[$i],
                    "translate" => $request->translate[$i]
                ];
            }
        }

        DB::table('dictionary')
            ->insert(
                $rows
            );

        $dictionary = DB::table("dictionary")->get();

        return view('dictionary', [
            "dictionaries" => $dictionary
        ]);
    }

    public function update(Request $request)
    {
        foreach($request->id as $keyId => $valueId)
        {
            DB::table('dictionary')
                ->where('id', $valueId)
                ->update([
                    'word' => $request->word[$keyId],
                    'translate' => $request->translate[$keyId]
                ]);
        }

        $dictionary = DB::table("dictionary")->get();

        return view('dictionary', [
            "dictionaries" => $dictionary
        ]);
    }
}

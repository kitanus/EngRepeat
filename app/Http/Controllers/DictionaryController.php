<?php

namespace App\Http\Controllers;

use App\Models\Dictionary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DictionaryController extends Controller
{

    protected $dictionary;

    public function __construct()
    {
        $this->dictionary = Dictionary::all();
    }

    public function show()
    {
        return view('layout/dictionary', [
            "dictionaries" => $this->dictionary
        ]);
    }

    public function new(Request $request)
    {
        return view('layout/dictionary', [
            "counts" => $request->count,
            "dictionaries" => $this->dictionary
    ]);
    }

    public function record(Request $request)
    {
        for($i=0; $i<count($request->word); $i++)
        {
            if(!is_null($request->word[$i]) && !is_null($request->translate[$i]))
            {
                $dictionary = new Dictionary();

                $dictionary->word = $request->word[$i];
                $dictionary->translate = $request->translate[$i];

                $dictionary->save();
            }
        }

        return redirect()->route('dictionary');
    }

    public function update(Request $request)
    {
        foreach($request->id as $keyId => $valueId)
        {
            $dictionary = Dictionary::find($valueId);

            $dictionary->word = $request->word[$keyId];
            $dictionary->translate = $request->translate[$keyId];

            $dictionary->save();
        }

        return redirect()->route('dictionary');
    }

    public function delete(Request $request)
    {
        Dictionary::where("id", $request->id)->delete();
        DB::table('eng_to_rus')->where("dictionary_id", $request->id)->delete();
        DB::table('rus_to_eng')->where("dictionary_id", $request->id)->delete();

        return redirect()->route('dictionary');
    }

    public function reset(Request $request)
    {
        DB::table($request->table)->truncate();

        return redirect()->route('dictionary');
    }
}

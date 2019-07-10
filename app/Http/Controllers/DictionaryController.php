<?php

namespace App\Http\Controllers;

use App\Models\Dictionary;
use App\Models\EngToRus;
use App\Models\RusToEng;
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
        EngToRus::where("id", $request->id)->delete();
        RusToEng::where("id", $request->id)->delete();

        return redirect()->route('dictionary');
    }

    public function reset(Request $request)
    {
        DB::table($request->table)->truncate();

        foreach (Dictionary::all() as $index => $value)
        {
            if(EngToRus::where("dictionary_id", $value->id)->count() === 0)
            {
                $engToRus = new EngToRus();

                $engToRus->win = 0;
                $engToRus->lose = 0;
                $engToRus->dictionary_id = $value->id;

                $engToRus->save();
            }

            if(RusToEng::where("dictionary_id", 1)->count() === 0)
            {
                $rusToEng = new EngToRus();

                $rusToEng->win = 0;
                $rusToEng->lose = 0;
                $rusToEng->dictionary_id = $value->id;

                $rusToEng->save();
            }
        }

        return redirect()->route('dictionary');
    }
}

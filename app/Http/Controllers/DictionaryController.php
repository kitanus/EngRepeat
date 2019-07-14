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
                (new Dictionary())->saveWord(
                    $request->word[$i],
                    $request->translate[$i]
                );
            }
        }

        return redirect()->route('dictionary');
    }

    public function update(Request $request)
    {
        foreach($request->id as $keyId => $valueId)
        {
            $dictionary = Dictionary::find($valueId);

            $dictionary->saveWord(
                $request->word[$keyId],
                $request->translate[$keyId]
            );
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

        return redirect()->route('dictionary');
    }
}

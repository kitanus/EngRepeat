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
}

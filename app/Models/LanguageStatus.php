<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LanguageStatus extends Model
{
    public function dictionary()
    {
        return $this->belongsTo('App\Models\Dictionary');
    }

    public function saveStatus($win, $lose, $id)
    {
        $this->win = $win;
        $this->lose = $lose;
        $this->dictionary_id = $id;

        $this->save();
    }
}

<?php

namespace App\Models\Languages;

use App\Models\LanguageStatus;

class EngToRus extends LanguageStatus
{
    protected $table = 'eng_to_rus';

    public function dictionary()
    {
        return $this->belongsTo('App\Models\Dictionary');
    }
}

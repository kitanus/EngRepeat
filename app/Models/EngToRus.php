<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EngToRus extends Model
{
    protected $table = 'eng_to_rus';

    public function dictionary()
    {
        return $this->belongsTo('App\Models\Dictionary');
    }
}

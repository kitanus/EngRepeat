<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RusToEng extends Model
{
    protected $table = 'rus_to_eng';

    public function dictionary()
    {
        return $this->belongsTo('App\Models\Dictionary');
    }
}

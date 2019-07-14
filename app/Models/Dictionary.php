<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    protected $table = 'dictionary';

    public function saveWord($word, $translate)
    {
        $this->word = $word;
        $this->translate = $translate;

        $this->save();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public $timestamps = false;

    public function vocabulary_lists(){
        return $this->hasMany('App\VocabularyList');
    }
}

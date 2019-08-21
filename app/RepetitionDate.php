<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepetitionDate extends Model
{
    public function vocabulary_list(){
	    return $this->belongsTo(VocabularyList::class);
    }
}
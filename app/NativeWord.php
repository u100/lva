<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NativeWord extends Model
{
    protected $guarded = ['id'];

    protected $fillable = ['word', 'vocabulary_list_id', 'pattern', 'native_to_foreign_status', 'word_repeating_counter', 'success'];

    protected $hidden = ['vocabulary_list_id', 'pattern', 'native_to_foreign_status', 'word_repeating_counter', 'success'];

    public function vocabulary_list(){
        return $this->belongsTo('App\VocabularyList');
    }

    public function foreign_words(){
        return $this->belongsToMany('App\ForeignWord')->withTimestamps();
    }
}

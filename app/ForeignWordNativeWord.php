<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForeignWordNativeWord extends Model
{
    protected $fillable = ['foreign_word_id', 'native_word_id'];

    protected $hidden = ['foreign_word_id', 'native_word_id'];

    protected $table = 'foreign_word_native_word';

    public function native_words(){
        return $this->belongsToMany('App\NativeWord', 'native_words')->withTimestamps();
    }

    public function foreign_words(){
        return $this->belongsToMany('App\ForeignWord', 'foreign_words')->withTimestamps();
    }
}

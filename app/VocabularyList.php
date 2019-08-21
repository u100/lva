<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VocabularyList extends Model
{
    protected $fillable = ['language_id', 'user_id', 'name', 'general_repeating_counter', 'active'];

    protected $hidden = ['user_id', 'general_repeating_counter', 'active'];

    public function user(){
	    return $this->belongsTo(User::class);
    }

    public function language(){
        return $this->belongsTo('App\Language');
    }

    public function repetition_dates(){
        return $this->hasMany(RepetitionDate::class);
    }

    public function native_words(){
        return $this->hasMany(NativeWord::class);
    }

    public function foreign_words(){
        return $this->hasMany(ForeignWord::class);
    }
}

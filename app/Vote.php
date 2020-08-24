<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'votes'
    ];  

    protected $hidden = [
        'id',  'user_id', 'answer_id'
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }
    public function answer(){
    	return $this->belongsTo('App\Answer');
    }
}

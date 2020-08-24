<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'description'
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

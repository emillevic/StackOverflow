<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title','description', 'is_closed'
    ];  

    protected $hidden = [
        'id',  'user_id' 
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }
    public function answers(){
        return $this->hasMany('App\Answer')
            // ->join('votes', 'answers.id', '=', 'votes.answer_id')
            // ->groupBy('answers.id')
            ->orderBy('is_bookmarked', 'DESC');
    }
    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function answersCount(){
    	return $this->hasMany('App\Answer')->count();
    }
}

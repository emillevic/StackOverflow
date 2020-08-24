<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use SoftDeletes;

    protected $fillable = [
       'description', 'is_bookmarked'
    ];  

    protected $hidden = [
        'id',  'user_id', 'topic_id'
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }
    public function topic(){
    	return $this->belongsTo('App\Topic')->withTrashed();
    }
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    public function votes(){
        return $this->hasMany('App\Vote');
    }
}

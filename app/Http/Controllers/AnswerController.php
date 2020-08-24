<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Answer;
use App\Vote;
use App\Comment;
use App\Topic;
use App\User;

class AnswerController extends Controller
{
    public function create(Request $request){
        $answer = new Answer;
        $answer->user_id = Auth::user()->id;
        $answer->topic_id = $request->input('topic_id');
        $answer->description = $request->input('description');
        $answer->is_bookmarked = false;

        $answer->save();

        return redirect()->route('showTopic', ['id' => $request->input('topic_id')]);

    }

    public function update(Request $request, $id){
        $answer = Answer::Where('id', $id)
                ->update(['description' => $request->input('description')]);
        return redirect()->route('showTopic', ['id' => $request->input('topic_id_edit')])->with('message', 'Resposta atualizada com sucesso!');
    }

    public function delete(Request $request){
        $comment = Comment::Where('answer_id', $request->input('answer_id'))->delete();
        $answer = Answer::Where('id', $request->input('answer_id'))->delete();
        return redirect()->back()->with('message', 'Resposta excluída com sucesso!');
    }

    public function bookmark($id){
        $answer_bookmarked = Answer::find($id)->is_bookmarked;
        if($answer_bookmarked){
            $answer = Answer::Where('id', $id)
                ->update(['is_bookmarked' => false]);
        }else{
            $answer = Answer::Where('id', $id)
                ->update(['is_bookmarked' => true]);
        }
        return redirect()->back();
    }

    public function upvote($id){
        $vote = new Vote;
        $vote->user_id = Auth::user()->id;
        $vote->answer_id = $id;
        $vote->votes = 1;
        $vote->save();

        return redirect()->back();
    }

    public function downvote($id){
        $vote = new Vote;
        $vote->user_id = Auth::user()->id;
        $vote->answer_id = $id;
        $vote->votes = -1;
        $vote->save();

        return redirect()->back();
    }
}

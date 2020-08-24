<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


use App\Topic;
use App\User;
use App\Comment;
use App\Answer;

class CommentController extends Controller
{
    public function create(Request $request){
        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->answer_id = $request->input('answer_id_modal');
        $comment->description = $request->input('description_modal');

        $comment->save();

        return redirect()->route('showTopic', ['id' => $request->input('topic_id_modal')]);
    }

    public function update(Request $request, $id){
        $comment = Comment::Where('id', $id)
                ->update(['description' => $request->input('description_edit_comment')]);
        return redirect()->route('showTopic', ['id' => $request->input('topic_id_edit_comment')])->with('message', 'Comentário atualizado com sucesso!');
    }

    public function delete(Request $request){
        $comment = Comment::Where('id', $request->input('comment_id'))->delete();
        return redirect()->back()->with('message', 'Comentário excluído com sucesso!');
    }
}

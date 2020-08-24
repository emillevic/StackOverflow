<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Topic;
use App\User;

class TopicController extends Controller
{
    public function index(){
        $search = Request('search');
        $topics = Topic::with('user')->orderBy('created_at', 'desc')->paginate(1); //Paginação de um em um para demonstração
        if (isset($search)) {
            $topics = Topic::where('title', 'LIKE', '%'.$search.'%')->orWhere('description', 'LIKE', '%'.$search.'%')->orderBy('created_at', 'desc')->paginate(1);
        }
        return view('index', ['topics' => $topics]);
    }

    public function create(Request $request){
        $topic = new Topic;
        $topic->user_id = Auth::user()->id;
        $topic->is_closed = false;
        $topic->title = $request->input('title');
        $topic->description = $request->input('description');

        $topic->save();
        return redirect()->route('index')->with('message', 'Tópico enviado!');
    }

    public function show($id){
        $topic = Topic::with('user', 'answers', 'answers.comments', 'answers.votes')->find($id);
        return view('topic', ['topic' => $topic]);
    }

    public function update(Request $request, $id){
        $topic = Topic::Where('id', $id)
                ->update(['title' =>$request->input('title'),
                    'description' => $request->input('description')]);
         return redirect()->route('showTopic', ['id' => $request->input('topic_id_edit')])->with('message', 'Tópico atualizado com sucesso!');
    }

    public function delete(Request $request){
        $topic = Topic::Where('id', $request->input('topic_id'))->delete();
        return redirect()->route('index')->with('message', 'Tópico excluído!');
    }

    public function close(Request $request){
        $topic_title = Topic::find($request->input('topic_id'))->title;
        $topic = Topic::Where('id', $request->input('topic_id'))
            ->update(['is_closed' => true,
                        'title' => $topic_title.' [fechado]']);
        return redirect()->route('showTopic', ['id' => $request->input('topic_id')])->with('message', 'Tópico fechado com sucesso!');
    }

    
}
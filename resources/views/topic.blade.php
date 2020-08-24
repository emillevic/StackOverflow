@extends('layouts.app')
@section('content')
<div class="container">
    @if (session('message'))
    <div class="row">
        <div class="w-100 alert alert-success d-flex justify-content-between align-items-center">
            {{ session('message') }}
            <button class="btn btn-outline-secondary" id="alert-button-remove">OK</button>
        </div>
    </div>
    @endif
    <div class="row justify-content-center">

        <div class="col-10 topic-area card">
            <div class="d-flex flex-column border-bottom py-3">
                <h3>{{$topic->title}}</h3>
                <div class="d-flex justify-content-between">
                    <p>perguntado por {{$topic->user->name}}, {{ date('d M Y',strtotime( $topic->created_at) )}}</p>
                    @if(Auth::check() && Auth::user()->id == $topic->user_id)
                    <div class="text-muted d-flex justify-content-center">
                        @if(!$topic->is_closed)
                        <a role="button" class="edit-topic" data-topic="{{$topic->id}}" data-title="{{$topic->title}}"
                            data-description="{{ $topic->description }}"><span class="material-icons">create</span></a>
                        @endif
                        <form action="{{Route('deleteTopic')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input value="{{$topic->id}}" name="topic_id" hidden>
                            <button class="btn btn-link p-0" type="submit"
                                onclick="if(!confirm('Deseja excluir?')) return false;"><span
                                    class="material-icons">delete</span></button>
                        </form>
                        @if(!$topic->is_closed)
                        <form action="{{Route('closeTopic')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input value="{{$topic->id}}" name="topic_id" hidden>
                            <button class="btn btn-link p-0" type="submit"
                                onclick="if(!confirm('Deseja fechar o tópico? Essa ação não poderá ser desfeita.')) return false;"><span
                                    class="material-icons">block</span></button>
                        </form>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            <div class="pt-3 topic">
                {!! $topic->description !!}
            </div>
        </div>

        <div class="col-10 mt-4">
            <div class="pb-3">
                <h5>{{$topic->answersCount()}} Resposta(s)</h5>
            </div>
            @forelse($topic->answers as $answer)
            <div class="pt-3 bg-white border p-3 mb-2 topic pt-4" id="answer_{{$answer->id}}">
                <div class="d-flex justify-content-between position-relative">
                    <div class="answer-description">
                        {!! $answer->description !!}
                    </div>
                    <div class="favorite position-absolute" style="left: -75; top: -25;">
                        
                            <a class="btn {{$answer->is_bookmarked ? 'btn-success text-white' : 'btn-outline-success'}} " @if(Auth::check() && Auth::user()->id == $topic->user_id)href="{{Route('bookmarkAnswer', $answer->id)}}" data-toggle="tooltip" data-placement="left"
                                title="Clique para adicionar/remover como favorita" @endif >
                                <span class="material-icons">
                                    done
                                </span>
                            </a>
                        
                        <div class="d-flex flex-column justify-content-center text-muted text-center">
                            <a href="{{Route('upvoteAnswer', $answer->id)}}"><span class="material-icons text-muted"> thumb_up_alt</span></a>
                            <span>{{$answer->votes()->sum('votes')}}</span>
                            <a href="{{Route('downvoteAnswer', $answer->id)}}"><span class="material-icons text-muted"> thumb_down_alt</span></a>
                        </div>
                    </div>
                    @if(Auth::check() && Auth::user()->id == $answer->user_id)
                    <div class="text-muted d-flex justify-content-center">
                        @if(!$topic->is_closed)
                        <a role="button" class="edit-answer" data-answer="{{$answer->id}}"
                            data-description="{{ $answer->description }}"><span class="material-icons">create</span></a>
                        @endif
                        <form action="{{Route('deleteAnswer')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input value="{{$answer->id}}" name="answer_id" hidden>
                            <button class="btn btn-link p-0" type="submit"
                                onclick="if(!confirm('Deseja excluir?')) return false;"><span
                                    class="material-icons">delete</span></button>
                        </form>
                    </div>
                    @endif
                </div>
                <div class="pb-3 ans-info">
                    <span class="text-muted float-right">respondida {{ date('d/M/Y',strtotime( $answer->created_at) )}},
                        por {{$answer->user->name}}</span>
                </div>
                <div>
                    <div class="mt-3 comment border-top">
                        <hr class="mt-0">
                        @foreach($answer->comments as $comment)
                        <div class="border-bottom">
                            <div class="py-3 mb-2">
                                <p class="mb-0" id="comment_{{$comment->id}}">{{$comment->description}} -
                                    <span class="text-muted">{{$comment->user->name}}
                                        @if(Auth::check() && Auth::user()->id == $comment->user_id)
                                        <div class="d-flex">
                                            @if(!$topic->is_closed)
                                            <a class="edit-comment" role="button" data-answer="{{$comment->answer_id}}"
                                                data-topic="{{$topic->id}}" data-comment="{{$comment->id}}"
                                                data-description="{{$comment->description}}"><span
                                                    class="material-icons">create</span></a>
                                            @endif
                                            <form action="{{Route('deleteComment')}}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input value="{{$comment->id}}" name="comment_id" hidden>
                                                <button class="btn btn-link p-0" type="submit"
                                                    onclick="if(!confirm('Deseja excluir?')) return false;"><span
                                                        class="material-icons">delete</span></button>
                                            </form>
                                        </div>
                                        @endif
                                    </span>
                                </p>
                                <span
                                    class="text-muted float-right com-info">{{ date('d/M/Y',strtotime( $comment->created_at) )}}</span>
                            </div>
                        </div>
                        @endforeach
                        @if(Auth::check() && !$topic->is_closed)
                        <div class="py-2">
                            <a role="button" id="{{$answer->id}}" class="text-muted p-3 add-comment" data-toggle="modal"
                                data-target="#modal-comment" data-topic="{{$topic->id}}"
                                data-answer="{{$answer->id}}">adicionar comentário</a>
                        </div>
                        @elseif($topic->is_closed)
                        <div class="text-muted p-2">
                            <p>Tópico fechado.</p>
                        </div>
                        @else
                        <div class="text-muted p-2">
                            <p>Faça login para comentar.</p>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
            @empty
            <div class="col-10 mt-4">
                <p>Nenhuma resposta ainda.</p>
            </div>
            @endforelse
        </div>
        <div class="col-10 mt-3">
            @if(Auth::check() && !$topic->is_closed)
            <form action="{{ route('createAnswer') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="topic_id" id="topic_id" value="{{$topic->id}}">
                <div class="form-group">
                    <textarea class="form-control bg-white" id="summernote" name="description" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Postar sua resposta</button>
            </form>
            @elseif($topic->is_closed)
            <div class="border-top pt-3 text-center">
                <p>Tópico fechado.</p>
            </div>
            @else
            <div class="border-top pt-3 text-center">
                <p>Faça login para responder</p>
                <a class="btn btn-warning" href="{{ route('login') }}">{{ __('Login') }}</a>
                <a class="btn btn-primary" href="{{ route('register') }}">{{ __('Register') }}</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@include('modal-comment')

@section('js')
<script>
    $(document).ready(function() {

        $('#alert-button-remove').click(function(){
            $(this).parent().fadeOut(500, function(){
                $(this).remove()
            })
        })

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $('#summernote').summernote({
            height: 200
        });
       
        
        $('.add-comment').click(function(){
            $('#modal-comment #answer_id_modal').val($(this).data('answer'))
            $('#modal-comment #topic_id_modal').val($(this).data('topic'))
        })

        $('.edit-comment').click(function(){
            $('.comment #comment_' + $(this).data('comment')).html(`<form action="/topico/responder/comentar/editar/${$(this).data('comment')}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="${$(this).data('answer')}" name="answer_id_edit_comment" id="answer_id_edit_comment">
                <input type="hidden"  value="{{$topic->id}}" name="topic_id_edit_comment" id="topic_id_edit_comment">
                <div class="form-group">
                    <textarea class="form-control" rows="2" name="description_edit_comment" id="description_comment" required>${$(this).data('description')}</textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Editar comentário</button>
                <button type="button" class="btn btn-danger btn-sm" onClick="window.location.reload();">Cancelar</button>
            </form>
            `)
        })

        $('.edit-answer').click(function(){
            $('#answer_'+ $(this).data('answer')+' .answer-description').html(`
            <form action="/topico/responder/editar/${$(this).data('answer')}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="topic_id_edit" id="topic_id_edit" value="{{$topic->id}}">
                <div class="form-group">
                    <textarea class="form-control bg-white" id="summernote-edit" name="description" required>${$(this).data('description')}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Editar sua resposta</button>
                <button type="button" class="btn btn-danger" onClick="window.location.reload();">Cancelar</button>
            </form>`)
            $('#summernote-edit').summernote({
                height: 200
            });
        })
        $('.edit-topic').click(function(){
            $('.topic-area').html(`
            <form action="/topico/editar/${$(this).data('topic')}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="topic_id_edit" id="topic_id_edit" value="{{$topic->id}}">
                <div class="form-group">
                    <input type="text" class="form-control" id="title" name="title" value="{{$topic->title}}" required>
                </div>
                <div class="form-group">
                    <textarea class="form-control bg-white" id="summernote-edit-topic" name="description" required>${$(this).data('description')}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Editar o tópico</button>
                <button type="button" class="btn btn-danger" onClick="window.location.reload();">Cancelar</button>
            </form>`)
            $('#summernote-edit-topic').summernote({
                height: 200
            });
        })

     });

    
</script>
@endsection
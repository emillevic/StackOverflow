@extends('layouts.app')

@section('content')
<div class="container card">
    @if (session('message'))
    <div class="row">
        <div class="w-100 alert alert-success d-flex justify-content-between align-items-center">
            {{ session('message') }}
            <button class="btn btn-outline-secondary" id="alert-button-remove">OK</button>
        </div>
    </div>
    @endif
    <div class="row justify-content-center border-bottom pt-4 pb-2">
        <h1>StackOverflow</h1>
    </div>
    <div class="row justify-content-center border-bottom">
        <div class="col-10 d-flex justify-content-between align-items-center">
            <h4 class="pb-3 pt-4">Listagem de Questões</h4>
            @if(Auth::check())
            <a href="{{ Route('ask') }}" class="btn btn-primary">Postar questão</a>
            @endif
        </div>
    </div>
    @if (!empty($_GET['search']))
    <h5 class="text-center pt-4">Exibindo resultados para <b>"{{$_GET['search']}}"</b></h5>
    @endif
    <div class="row justify-content-center">
        @forelse($topics as $topic)
        <div class="col-10 pb-2 border-bottom">
            <div class="d-flex flex-row pt-4">
                <div class="ans d-flex flex-column align-items-center pr-3 text-muted">
                    <span>{{$topic->answersCount()}}</span>
                    <span>resposta(s)</span>
                </div>
                <div>
                    <h5><a href="{{route('showTopic', ['id' => $topic->id])}}">{{$topic->title}}</a></h5>
                    <p class="text-justify text-dark mb-0">{!! substr(strip_tags($topic->description), 0, 150) !!}</p>
                </div>
            </div>
            <div class="float-right">
                <span class="text-muted">perguntado por {{$topic->user->name}}</span>
                <span class="text-muted">{{ date('d M Y',strtotime( $topic->created_at) )}}</span>
            </div>
        </div>
        <div class="col-12 d-flex justify-content-center pt-3">

            {{ $topics->links() }}
        </div>
        @empty
        <p>Nenhuma pergunta no sistema.</p>
        @endforelse
    </div>
</div>


@endsection

@section('js')

<script>
    $(document).ready(function() {

    $('#alert-button-remove').click(function(){
        $(this).parent().fadeOut(500, function(){
            $(this).remove()
        })
    })
})
</script>

@endsection
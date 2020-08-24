@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row py-4 border-bottom">
        <h4>Abra um tópico de discussão público</h4>
    </div>

    <div class="row">
        <div class="col-10 mt-3">
            <form action="{{ route('createTopic') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Título</label>
                    <small id="titleHelp" class="form-text text-muted">Seja específico como se estivesse perguntando a outra pessoa.</small>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Corpo</label>
                    <small id="descriptionHelp" class="form-text text-muted">Coloque informações necessárias para entender sua pergunta.</small>
                    <textarea class="form-control" id="summernote" name="description" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Postar sua pergunta</button>
            </form>
        </div>
    </div>
</div>


@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 200
        });
    });
</script>
@endsection
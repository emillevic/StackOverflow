<div class="modal fade" style="display:none;" id="modal-comment" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Adicionar Comentário</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if(Auth::check())
          <form action="{{ route('createComment') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="answer_id_modal" id="answer_id_modal">
            <input type="hidden" name="topic_id_modal" id="topic_id_modal">
            <div class="form-group">
              <textarea class="form-control" rows="3" name="description_modal" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Comentar</button>
          </form>
        @else
          <div class="text-center">
            <p>Faça login para comentar</p>
            <a class="btn btn-warning" href="{{ route('login') }}">{{ __('Login') }}</a>
            <a class="btn btn-primary" href="{{ route('register') }}">{{ __('Register') }}</a>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
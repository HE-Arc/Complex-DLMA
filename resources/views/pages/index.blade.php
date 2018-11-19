@extends('layouts.app')
<script src="{{ asset('js/index.js') }}" defer></script>
<script>
  var questionId = <?php echo $data["question"]->id ?>;
  var usernames = <?php echo $data["usernames"] ?>;
</script>

@section('content')
  <h1>Home</h1>
  <h2>Plutôt :</h2>
  <h2 style="display:inline-block">{{$data['choices'][array_keys($data['choices'])[0]]->text}}</h2>
  <h2>ou </h2>
  <h2 style="display:inline-block">{{$data['choices'][array_keys($data['choices'])[1]]->text}}</h2>



  <div id="btnShare" onclick="resetShareModal()" {{ Auth::check() ? 'data-toggle=modal data-target=#shareWithUserModal style=background-color:lightblue;' : 'style=background-color:lightgray;' }}>
    <img src="" alt="Share!" height="30" width="30" />
  </div>


  <div class="modal fade" id="shareWithUserModal" tabindex="-1" role="dialog" aria-labelledby="shareWithUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="shareWithUserModalLabel">Select a user</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <p><label for="searchUsersNickname">Search a user's nickname :</label></p>
            <input type="text" class="form-control" onkeyup="findUsers(this.value)" id="searchUsersNickname" />
          </div>

          <div class="form-group">
            <div id="usersList"></div>
          </div>
          <hr/>
          <div class="form-group">
            <div id="shareList"></div>
          </div>
        </div>

        <div class="modal-footer">
          <div class="form-group">
            <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            <button type="button" disabled id="btnShareWithUserModal" class="btn" onclick="shareQuestion()">Share question</button>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

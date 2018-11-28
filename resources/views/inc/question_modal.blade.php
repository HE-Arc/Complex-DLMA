<div class="modal cd_modalless" id="choiceSharingAnswerPopup" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="choiceSharingAnswerPopupTitle"></h5>
      </div>
      <div class="modal-body">
        <div id="choiceSharingAnswerPopupRes" style="max-height: 200px; overflow-y: auto;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" id="btnCloseChoiceSharingAnswerPopup">Ok</button>
      </div>
    </div>
  </div>
</div>

<div class="modal cd_modalless" id="shareMyChoicePopup">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="shareMyChoicePopupTitle"></h5>
      </div>
      <div class="modal-body" style="max-height: 200px; overflow-y: auto;">
        <div id="shareMyChoicePopupQuestion"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" id="btnCloseShareMyChoice">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="shareWithUserModal" tabindex="0" role="dialog" aria-labelledby="shareWithUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="shareWithUserModalLabel">Select users</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="form-group">
            
        </div>

        <div class="form-group">
          <label for="searchUsersNickname">
            Chose online users to ask for their opinion, if you are in a complex dilemma.
          </label>

          <input type="text" class="form-control" onkeyup="findUsers(this.value)" id="searchUsersNickname" autofocus />
        </div>

        <div class="form-group">
          <div id="usersList"></div>
        </div>

        <hr class="cd_hr-s1" />

        <div class="form-group">
          <div id="shareList"></div>
        </div>
      </div>

      <div class="modal-footer">
        <div class="form-group">
            <button class="btn btn-sm cd_btn-default mr-3" type="button" data-dismiss="modal">Cancel</button>
            <button id="btnShareWithUserModal" class="btn btn-sm cd_btn-default" onclick="shareQuestion()" type="button" disabled>Send</button>
        </div>
      </div>
    </div>
  </div>
</div>
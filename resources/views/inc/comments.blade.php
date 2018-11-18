<div class="row">
    <div class="col-12 cd_md-text">
        {{ $data['commentsNumber'] }} comments
        <span id="addComment" class="btn btn-sm cd_btn-default ml-5">Add comment</span>
    </div>
</div>

<hr class="cd_hr-s1" />
    
<div class="col-12">
    <div class="col-12 cd_md-text">
        
        <div id="newComment" class="col-12 col-lg-6 p-0 mb-3 d-none">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Enter your comment...">
                <div class="input-group-append ">
                    <button class="btn btn-sm cd_btn-default ml-1" type="button">Post</button>
                </div>
            </div>
        </div>

        @foreach($data['comments'] as $comment)
        <div class="card bg-light mb-3">

            <div class="card-header cd_md-text">
                {{ $comment->username }}
                <span class="text-muted cd_sm-text ml-1">
                    {{ date('d.m.Y \a\t H:i',strtotime($comment->created_at)) }}
                </span>
            </div>

            <div class="card-body cd_sm-text">
                {{ $comment->text }}
            </div>
        </div>
        @endforeach
    </div>
</div>
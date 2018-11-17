@extends('layouts.app')

@section('content')

    <div class="row text-center">
        <div class="cd_md-text font-weight-bold col-12">
            Would you rather...
        </div>
    </div>
    <div id="choicesMain" class="cd_choices-main-container row text-center">
        <div class="col-12 col-lg-6 p-3 p-lg-3">

            <div id="userChoice1" class="btn cd_btn-choice1 userChoice cd_choice-inner-container col-12 h-100 shadow">
            
                <i id="checkedChoice1" class="fas fa-check cd_checked-choice d-none"></i>

                <div class="col-12 cd_choice-text-container p-3 p-lg-5">

                    <div class="cd_choice-perc font-weight-bold col-12 d-none"></div>

                    <div class="d-none initVotes">{{ $data['choices'][0]->counter }}</div>
                    <div class="cd_choice-counter cd_md-text col-12 d-none"></div>

                    <div class="cd_lg-text font-weight-bold col-12">
                        {{ $data['choices'][0]->text }}
                    </div>

                </div>
            </div>
            
        </div>
        <div class="col-12 col-lg-6 p-3 p-lg-3">
            <div id="userChoice2" class="btn cd_btn-choice2 userChoice cd_choice-inner-container col-12 h-100 shadow">
            
                <i id="checkedChoice2" class="fas fa-check cd_checked-choice d-none"></i>
        
                <div class="col-12 cd_choice-text-container p-3 p-lg-5">

                    <div class="cd_choice-perc font-weight-bold col-12 d-none"></div>

                    <div class="d-none initVotes">{{ $data['choices'][1]->counter }}</div>
                    <div class="cd_choice-counter cd_md-text col-12 d-none"></div>

                    <div class="cd_lg-text font-weight-bold col-12">
                        {{ $data['choices'][1]->text }}
                    </div>
                </div>
            </div>
        </div>
        <div class="cd_choice-or rounded-circle col-3 col-sm-2 col-lg-1 shadow">
            OR
        </div>
    </div>

    <div class="col-12">
        <div class="col-12 cd_sm-text">
            DLMA added by <span class="font-weight-bold">{{ $data['question_user']->username }}</span>
        </div>
    </div>

    <hr class="cd_hr-s1" />

    <div class="col-12">
        <div class="col-12 cd_md-text font-weight-bold">
            Description
        </div>
        <div class="col-12 cd_sm-text">
            {{ $data['question']->description }}
        </div>
    </div>

    <hr class="cd_hr-s3 my-5" />
    
    <!-- Comments -->
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
@endsection

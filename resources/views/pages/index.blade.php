@extends('layouts.app')

<link rel="shortcut icon" sizes="114x114" href="assets/img/ficon.png">
<script src="{{ asset('js/index.js') }}"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">
{!! $data['homeController']->questionHeader($data['question']->id) !!}

@section('content')

    <div id="questionHeader"></div>
   
    <div class="row text-center">
        <div class="cd_medium-text font-weight-bold col-12">
            Would you rather...
        </div>
    </div>

    <div id="choicesMain" class="row cd_choices-main-container text-center">

        <div class="col-12 col-lg-6 p-3 p-lg-3 cd_choice-inner-choice1">
            <div id="userChoice1" class="btn cd_btn-choice1 userChoice cd_choice-inner-container col-12 h-100 shadow">

                <i id="checkedChoice1" class="fas fa-check cd_checked-choice d-none"></i>

                <div id="choice1">
                    {!! $data['homeController']->questionChoice($data['question']->choice_1_id) !!}
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 p-3 p-lg-3 cd_choice-inner-choice2">
            <div id="userChoice2" class="btn cd_btn-choice2 userChoice cd_choice-inner-container col-12 h-100 shadow">

                <i id="checkedChoice2" class="fas fa-check cd_checked-choice d-none"></i>

                <div id="choice2">
                    {!! $data['homeController']->questionChoice($data['question']->choice_2_id) !!}
                </div>
            </div>
        </div>

        <div class="cd_choice-or rounded-circle col-3 col-sm-2 col-lg-1 shadow">OR</div>

    </div>

    <div id="questionUsername">
        {!! $data['homeController']->questionUsername($data['question']->id) !!}
    </div>

    <div class="col-12 text-center text-sm-right p-0">
        <button id="btnShare" class="btn btn-md cd_btn-default mr-5" type="button" onclick="resetShareModal()" {{ Auth::check() ? 'data-toggle=modal data-target=#shareWithUserModal' : 'disabled' }}>
            <i class="fas fa-balance-scale cd_sharing-icon"></i> Ask others
        </button>

        <button id="nextQuestion" class="btn btn-lg cd_btn-default cd_btn-animated" type="button">
            <span>Next question</span>
        </button>
    </div>

    <hr class="cd_hr-s1" />

    <div id="questionDescription">
        {!! $data['homeController']->questionDescription($data['question']->id) !!}
    </div>

    <hr class="cd_hr-s3 my-5" />

    <div id="questionCommentsCounter">
        {!! $data['homeController']->questionCommentsCounter($data['question']->id) !!}
    </div>
    
    <hr class="cd_hr-s1" />
        
    <div class="col-12">
        <div class="col-12 cd_medium-text">

            <div id="newComment" class="col-12 col-lg-6 p-0 mb-3">
                <div class="input-group">
                    <input id="commentText" type="text" class="form-control" placeholder="Enter your comment...">
                    <div class="input-group-append">
                        <button id="postComment" class="btn btn-sm cd_btn-default ml-1" type="button" {{ !Auth::check() ? 'disabled' : '' }}>Post</button>
                    </div>
                </div>
            </div>
    
            <div id="questionComments">
                {!! $data['homeController']->questionComments($data['question']->id) !!}
            </div>
        </div>
    </div>

    @include('inc.ask_users_modal');

@endsection

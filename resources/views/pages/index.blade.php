@extends('layouts.app')

<script src="{{ asset('js/index.js') }}" defer></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

    <script src="{{ asset('js/home.js') }}" defer></script>
    
    @if(isset($questionID))
        <script>var questionID = {!! json_encode($questionID) !!};</script>
    @else
        <script>var questionID = null;</script>
    @endif

    <div id="questionHeader"></div>
   
    <div class="row text-center">
        <div class="cd_medium-text font-weight-bold col-12">
            Would you rather...
        </div>
    </div>

    <!-- Choices buttons -->
    <div id="choicesMain" class="row cd_choices-main-container text-center">

        <div class="cd_fade-choices">
            <div class="col-12 col-lg-6 p-3 p-lg-3 cd_choice-inner-choice1">
                <div id="userChoice1" class="btn cd_btn-choice1 userChoice cd_choice-inner-container col-12 h-100 shadow">

                    <i id="checkedChoice1" class="fas fa-check cd_checked-choice d-none"></i>

                    <div id="choice1"></div>
                </div>
            </div>

            <div class="col-12 col-lg-6 p-3 p-lg-3 cd_choice-inner-choice2">
                <div id="userChoice2" class="btn cd_btn-choice2 userChoice cd_choice-inner-container col-12 h-100 shadow">

                    <i id="checkedChoice2" class="fas fa-check cd_checked-choice d-none"></i>

                    <div id="choice2"></div>
                </div>
            </div>

            <div class="cd_choice-or rounded-circle col-3 col-sm-2 col-lg-1 shadow">OR</div>
        </div>

        <div class="cd_logo-big cd_logo-big-anim">
            <div class="cd_logo-part cd_logo-left cd_logo-big-anim-left">
                <img src="{{ asset('img/logo_left.png') }}" class="img-fluid" alt="Complex-DLMA">
            </div>
            <div class="cd_logo-part cd_logo-right cd_logo-big-anim-right">
                <img src="{{ asset('img/logo_right.png') }}" class="img-fluid" alt="Complex-DLMA">
            </div>
            <div class="cd_logo-part cd_logo-center">
                <img src="{{ asset('img/logo_center.png') }}" class="img-fluid" alt="Complex-DLMA">
            </div>
        </div>

    </div>

    <div id="questionUsername"></div>

    <div class="col-12 text-center text-sm-right p-0">
        <button id="btnShare" class="btn btn-md cd_btn-default mr-0 mr-sm-5 mt-3 mt-sm-0" type="button" onclick="resetShareModal()" {{ Auth::check() ? 'data-toggle=modal data-target=#shareWithUserModal' : '' }}>
            <i class="fas fa-balance-scale cd_sharing-icon"></i> Ask others
        </button>

        <button id="nextQuestion" class="btn btn-lg cd_btn-default cd_btn-animated mt-3 mt-sm-0" type="button">
            <span>Next question</span>
        </button>
    </div>

    <hr class="cd_hr-s1" />

    <div id="questionDescription"></div>

    <hr class="cd_hr-s3 my-5" />

    <!-- Comments -->
    <div id="questionCommentsCounter"></div>
    
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
    
            <div id="questionComments"></div>
        </div>
    </div>

    @include('inc.ask_users_modal')

@endsection

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
    
    @include('inc.comments')
@endsection

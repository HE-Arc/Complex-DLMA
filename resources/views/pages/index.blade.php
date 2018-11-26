@extends('layouts.app')
<link rel="shortcut icon" sizes="114x114" href="assets/img/ficon.png">
@section('content')
   
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
        <button id="nextQuestion" class="btn btn-lg cd_btn-default cd_btn-animated" type="button">
            <span>Next question</span>
        </button>
    </div>
    
    <hr class="cd_hr-s1" />

    <div id="questionDescription">
        {!! $data['homeController']->questionDescription($data['question']->id) !!}
    </div>
    
    <hr class="cd_hr-s3 my-5" />
    
    <div id="questionComments">
        {!! $data['homeController']->questionComments($data['question']->id) !!}
    </div>
@endsection

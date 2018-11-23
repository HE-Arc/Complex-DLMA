@extends('layouts.app')

@section('content')

    @foreach ($data as $key => $answers)
        @foreach ($answers as $answer)

        <div class="row cd_choices-main-container text-center">

            <div class="col-12 col-lg-6 p-3 p-lg-3">
                <div class="btn cd_btn-choice1 userChoice cd_choice-inner-container col-12 h-100 shadow">

                    @if ($answer['user_choice'] == 0)
                    <i id="checkedChoice1" class="fas fa-check cd_checked-choice"></i>
                    @endif

                    <div class="col-12 cd_choice-text-container p-3 p-lg-5">

                        <div class="cd_choice-perc font-weight-bold col-12">
                            {!! $answer[0]['perc'] !!}%
                        </div>

                        <div class="cd_choice-counter cd_medium-text col-12">
                            {!! $answer[0]['counter'] !!}votes
                        </div>

                        <div class="cd_choice-text cd_large-text cd_large-text-md font-weight-bold col-12">
                            {!! $answer[0]['text'] !!}
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col-12 col-lg-6 p-3 p-lg-3">
                <div class="btn cd_btn-choice2 userChoice cd_choice-inner-container col-12 h-100 shadow">

                    @if ($answer['user_choice'] == 1)
                    <i id="checkedChoice2" class="fas fa-check cd_checked-choice"></i>
                    @endif

                    <div class="col-12 cd_choice-text-container p-3 p-lg-5">
    
                        <div class="cd_choice-perc font-weight-bold col-12">
                            {!! $answer[1]['perc'] !!}%
                        </div>
    
                        <div class="cd_choice-counter cd_medium-text col-12">
                            {!! $answer[1]['counter'] !!}votes
                        </div>
    
                        <div class="cd_choice-text cd_large-text cd_large-text-md font-weight-bold col-12">
                            {!! $answer[1]['text'] !!}
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="cd_choice-or rounded-circle col-3 col-sm-2 col-lg-1 shadow">
                OR
            </div>

        </div>

        <div class="col-12 cd_medium-text">
            Answer at : {{ $key }}
        </div>

        <hr class="cd_hr-s1" />
        
        @endforeach
    @endforeach
@endsection

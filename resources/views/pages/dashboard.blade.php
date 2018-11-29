@extends('layouts.app')

@section('content')

    @if (count($data) <= 0)
        <div class="col-6 offset-3 card border-dark cd_medium-text mt-5 p-0">
            <div class="card-header cd_large-text">
                No answer found...
            </div>

            <div class="card-body">
                Oh ! It looks like you didn't answer to any complex DLMA...
                <br>
                Start right now, by going to the home page
                <div class="col-12 p-0 text-center">
                    <a class="btn cd_btn-default mt-3" href="{{ route('home') }}">Home page</a>
                </div>
            </div>
        </div>
    @else
        @foreach ($data as $key => $answers)
            @foreach ($answers as $answer)

            <div class="row cd_choices-main-container text-center">

                <div class="col-12 col-lg-6 p-3 p-lg-3 cd_choice-inner-choice1">
                    <div class="btn cd_btn-choice1 userChoice cd_choice-inner-container col-12 h-100 shadow">

                        @if ($answer['user_choice'] == 0)
                        <i id="checkedChoice1" class="fas fa-check cd_checked-choice"></i>
                        @endif

                        <div class="col-12 cd_choice-text-container p-3 p-lg-5">

                            <div class="cd_choice-perc font-weight-bold col-12">
                                {!! $answer[0]['perc'] !!}%
                            </div>

                            <div class="cd_choice-counter cd_medium-text col-12">
                                {!! $answer[0]['counter'] !!} votes
                            </div>

                            <div class="cd_choice-text cd_large-text cd_large-text-md font-weight-bold col-12">
                                {!! $answer[0]['text'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-12 col-lg-6 p-3 p-lg-3 cd_choice-inner-choice2">
                    <div class="btn cd_btn-choice2 userChoice cd_choice-inner-container col-12 h-100 shadow">

                        @if ($answer['user_choice'] == 1)
                        <i id="checkedChoice2" class="fas fa-check cd_checked-choice"></i>
                        @endif

                        <div class="col-12 cd_choice-text-container p-3 p-lg-5">
        
                            <div class="cd_choice-perc font-weight-bold col-12">
                                {!! $answer[1]['perc'] !!}%
                            </div>
        
                            <div class="cd_choice-counter cd_medium-text col-12">
                                {!! $answer[1]['counter'] !!} votes
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
                Answered at : {{ $key }}
            </div>

            <hr class="cd_hr-s1" />
            
            @endforeach
        @endforeach
    @endif        
@endsection

@extends('layouts.app')

@section('content')

    @if (count($data) <= 0)
    <div class="col-12 col-md-6 offset-0 offset-md-3 card border-dark cd_medium-text mt-5 p-0">
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
    <div class="col-12 mt-3 p-0 text-center">
        <div class="row">
            <div class="col-12 col-sm-6 text-center p-0 mb-3 mb-sm-0">
                <a class="btn cd_btn-default cd_btn-default-square-container btn-lg cd_large-text" href="{{ route('my_dlmas') }}">
                    <div class="cd_btn-default-square-content">
                        <i class="fas fa-user cd_icon-square-btn"></i>
                        <br>
                        My DLMAs
                    </div>
                </a>
            </div>

            <div class="col-12 col-sm-6 text-center p-0">
                <a class="btn cd_btn-default cd_btn-default-square-container btn-lg cd_large-text" href="{{ route('home') }}">
                    <div class="cd_btn-default-square-content">
                        <i class="fas fa-home cd_icon-square-btn"></i>
                        <br>
                        Home page
                    </div>
                </a>
            </div>
        </div>
    </div>

    <hr class="cd_hr-s3 my-3" />

    <h2 class="text-center cd_page-title">Answered DLMAs</h2>

    <hr class="cd_hr-s1 my-3" />
    
    <div class="row">
        @foreach ($data as $key => $answers)
        @foreach ($answers as $answer)

        <div class="col-12 col-lg-6">
            <div class="col-12 cd_medium-text">
                Answered at : {{ date('d.m.Y H:i',strtotime($key)) }}
            </div>

            <div class="row cd_choices-main-container-dashboard text-center">

                <div class="col-12 col-md-6 p-3 cd_choice-inner-choice1-dashboard">
                    <div class="btn cd_btn-choice1 userChoice cd_choice-inner-container col-12 h-100 shadow {{ $answer['user_choice'] != 0 ? 'cd_btn-choice-disabled' : '' }}">

                        @if ($answer['user_choice'] == 0)
                        <i id="checkedChoice1" class="fas fa-check cd_checked-choice"></i>
                        @endif

                        <div class="col-12 cd_choice-text-container p-0">

                            <div class="cd_choice-perc cd_large-text font-weight-bold col-12">
                                {!! $answer[0]['perc'] !!}%
                            </div>

                            <div class="cd_choice-counter cd_small-text col-12">
                                {!! $answer[0]['counter'] !!} votes
                            </div>

                            <div class="cd_choice-text cd_small-medium-text font-weight-bold col-12">
                                {!! $answer[0]['text'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-12 col-md-6 p-3 cd_choice-inner-choice2-dashboard">
                    <div class="btn cd_btn-choice2 userChoice cd_choice-inner-container col-12 h-100 shadow {{ $answer['user_choice'] != 1 ? 'cd_btn-choice-disabled' : '' }}">

                        @if ($answer['user_choice'] == 1)
                        <i id="checkedChoice2" class="fas fa-check cd_checked-choice"></i>
                        @endif

                        <div class="col-12 cd_choice-text-container p-3">
        
                            <div class="cd_choice-perc cd_large-text font-weight-bold col-12">
                                {!! $answer[1]['perc'] !!}%
                            </div>
        
                            <div class="cd_choice-counter cd_small-text col-12">
                                {!! $answer[1]['counter'] !!} votes
                            </div>
        
                            <div class="cd_choice-text cd_small-medium-text font-weight-bold col-12 p-0">
                                {!! $answer[1]['text'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="cd_choice-or cd_small-text cd_small-text-md rounded-circle col-2 col-sm-1 col-lg-1 shadow">
                    OR
                </div>

            </div>

            <div class="col-12">
                <div class="col-12 cd_small-text">
                    DLMA added by <span class="font-weight-bold">{{ $answer['question_username'] }}</span>
                </div>
            </div>

            <div class="col-12">
                <div class="col-12 cd_small-text">
                    @if ($answer['question_description'] == "")

                    <span class="font-weight-bold">No description provided !</span>
                        
                    @else

                    <span class="font-weight-bold">Description :</span>
                    {{ $answer['question_description'] }}

                    @endif
                </div>
            </div>

            <hr class="cd_hr-s1" />
        </div>
        
        @endforeach
        @endforeach
    </div>
    @endif        
@endsection

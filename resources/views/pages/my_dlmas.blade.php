@extends('layouts.app')

@section('content')

    @if ($questions->count() <= 0)
    <!-- Display a message to the user if no DLMA were found -->
    <div class="col-12 col-md-6 offset-0 offset-md-3 card border-dark cd_medium-text mt-5 p-0">
        <div class="card-header cd_large-text">
            No DLMA found...
        </div>

        <div class="card-body">
            Oh ! It looks like you didn't create any complex DLMA...
            <br>
            Start right now, by going to the create DLMA page or go back to the home page.
            <div class="col-12 p-0 text-center">
                <a class="btn cd_btn-default mt-3 mr-0 mr-sm-3" href="{{ route('create_dlma') }}">Create a new DLMA</a>
                <a class="btn cd_btn-default mt-3" href="{{ route('home') }}">Home page</a>
            </div>
        </div>
    </div>  
    @else
    <!-- Redirecting buttons -->
    <div class="col-12 mt-3 p-0 text-center">

        <div class="row">
            <div class="col-12 col-sm-6 text-center p-0 mb-3 mb-sm-0">
                <a class="btn cd_btn-default cd_btn-default-square-container btn-lg cd_large-text" href="{{ route('answered_dlmas') }}">
                    <div class="cd_btn-default-square-content">
                        <i class="fas fa-history cd_icon-square-btn"></i>
                        <br>
                        DLMAs History
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

    <h2 class="text-center cd_page-title">My DLMAs</h2>

    <hr class="cd_hr-s1 my-3" />
    
    <div class="row">
        <!-- All created questions -->
        @foreach ($questions as $question)

        <div class="col-12 col-lg-6">
            <div class="col-12 cd_medium-text">
                Created at : {{ $question->updated_at->format('d.m.y H:i') }}
            </div>

            <div class="row cd_choices-main-container-dashboard text-center">

                @php
                $choice1 = $question->choice1;
                $choice2 = $question->choice2;
                $totCounter = $choice1->counter + $choice2->counter;
                if ($totCounter == 0) {
                    $totCounter = 1;
                }
                @endphp

                <div class="col-12 col-md-6 p-3 cd_choice-inner-choice1-dashboard">
                    <div class="btn cd_btn-choice1 userChoice cd_choice-inner-container col-12 h-100 shadow">

                        <div class="col-12 cd_choice-text-container p-0">

                            @php
                            $choice1Perc = round($choice1->counter / $totCounter * 100, 0);
                            @endphp

                            <div class="cd_choice-perc cd_large-text font-weight-bold col-12">
                                {!! $choice1Perc !!}%
                            </div>

                            <div class="cd_choice-counter cd_small-text col-12">
                                {!! $choice1->counter !!} votes
                            </div>

                            <div class="cd_choice-text cd_small-medium-text font-weight-bold col-12">
                                {!! $choice1->text !!}
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-12 col-md-6 p-3 cd_choice-inner-choice2-dashboard">
                    <div class="btn cd_btn-choice2 userChoice cd_choice-inner-container col-12 h-100 shadow">

                        <div class="col-12 cd_choice-text-container p-3">
                            
                            @php
                            $choice2Perc = round($choice2->counter / $totCounter * 100, 0);
                            @endphp
        
                            <div class="cd_choice-perc cd_large-text font-weight-bold col-12">
                                {!! $choice2Perc !!}%
                            </div>
        
                            <div class="cd_choice-counter cd_small-text col-12">
                                {!! $choice2->counter !!} votes
                            </div>
        
                            <div class="cd_choice-text cd_small-medium-text font-weight-bold col-12 p-0">
                                {!! $choice2->text !!}
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
                    @if ($question->description == "")

                    <span class="font-weight-bold">No description provided !</span>
                        
                    @else

                    <span class="font-weight-bold">Description :</span>
                    {{ $question->description }}

                    @endif
                </div>
            </div>

            <div class="col-12">
                <div class="col-12 cd_small-text">
                    <a class="font-weight-bold" href='{{ url("/{$question->id}") }}'>DLMA's link</a>
                </div>
            </div>

            <hr class="cd_hr-s1" />
        </div>
        
        @endforeach
    </div>
    @endif        
@endsection

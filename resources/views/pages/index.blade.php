@extends('layouts.app')

@section('content')
    <div class="row text-center">
        <div class="cd_rather-title col-12">
            Would you rather...
        </div>
    </div>
    <div class="cd_choices-main-container row text-center">
        <div class="col-12 col-lg-6 p-0 p-lg-3">
            <div class="cd_choice-inner-container cd_choice1 col-12 p-3 shadow">
                <div class="col-12 cd_choice-text-container p-5">
                    <div class="cd_choice-perc col-12">
                        55%
                    </div>
                    <div class="cd_choice-counter col-12">
                        18 votes
                    </div>
                    <div class="cd_choice-sentence col-12">
                        {{$question->choice_1}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 p-0 p-lg-3">
            <div class="cd_choice-inner-container cd_choice2 col-12 p-3 shadow">
                <div class="col-12 cd_choice-text-container p-5">
                    <div class="cd_choice-perc col-12">
                        45%
                    </div>
                    <div class="cd_choice-counter col-12">
                        54 votes
                    </div>
                    <div class="cd_choice-sentence col-12">
                        {{$question->choice_2}}
                    </div>
                </div>
            </div>
        </div>
        <div class="cd_choice-or rounded-circle col-2 col-lg-1 shadow">
            OR
        </div>
    </div>
@endsection

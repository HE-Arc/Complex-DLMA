@extends('layouts.app')

@section('content')
    <div class="row text-center">
        <div class="cd_rather-title col-12">
            Would you rather...
        </div>
    </div>
    <div class="cd_choices-main-container row text-center">
        <div class="col-12 col-lg-6 p-3 p-lg-3">
            <div class="cd_choice-inner-container cd_choice1 col-12 h-100 shadow">
                <div class="col-12 cd_choice-text-container p-3 p-lg-5">
                    <div class="cd_choice-perc col-12 d-none">
                        55%
                    </div>
                    <div class="cd_choice-counter col-12 d-none">
                        {{$data['choices'][array_keys($data['choices'])[0]]->counter}} votes
                    </div>
                    <div class="cd_choice-sentence col-12">
                        {{$data['choices'][array_keys($data['choices'])[0]]->text}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 p-3 p-lg-3">
            <div class="cd_choice-inner-container cd_choice2 col-12 h-100 shadow">
                <div class="col-12 cd_choice-text-container p-3 p-lg-5">
                    <div class="cd_choice-perc col-12 d-none">
                        45%
                    </div>
                    <div class="cd_choice-counter col-12 d-none">
                        {{$data['choices'][array_keys($data['choices'])[1]]->counter}} votes
                    </div>
                    <div class="cd_choice-sentence col-12">
                        {{$data['choices'][array_keys($data['choices'])[1]]->text}}
                    </div>
                </div>
            </div>
        </div>
        <div class="cd_choice-or rounded-circle col-3 col-sm-2 col-lg-1 shadow">
            OR
        </div>
    </div>
    <h2 style="display:inline-block"></h2>
@endsection

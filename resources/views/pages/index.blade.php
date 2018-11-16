@extends('layouts.app')

@section('content')

    <div class="row text-center">
        <div class="cd_rather-title col-12">
            Would you rather...
        </div>
    </div>
    <div id="choicesMain" class="cd_choices-main-container row text-center">
        <div class="col-12 col-lg-6 p-3 p-lg-3">

            <div id="userChoice1" class="btn cd_btn-choice1 userChoice cd_choice-inner-container col-12 h-100 shadow">
            
                <i id="checkedChoice1" class="fas fa-check cd_checked-choice d-none"></i>

                <div class="col-12 cd_choice-text-container p-3 p-lg-5">

                    <div class="cd_choice-perc col-12 d-none"></div>
                    <div class="d-none initVotes">{{ $data['choices'][0]->counter }}</div>
                    <div class="cd_choice-counter col-12 d-none"></div>

                    <div class="cd_choice-sentence col-12">
                        {{ $data['choices'][0]->text }}
                    </div>

                </div>
            </div>
            
        </div>
        <div class="col-12 col-lg-6 p-3 p-lg-3">
            <div id="userChoice2" class="btn cd_btn-choice2 userChoice cd_choice-inner-container col-12 h-100 shadow">
            
                <i id="checkedChoice2" class="fas fa-check cd_checked-choice d-none"></i>
        
                <div class="col-12 cd_choice-text-container p-3 p-lg-5">

                    <div class="cd_choice-perc col-12 d-none"></div>

                    <div class="d-none initVotes">{{ $data['choices'][1]->counter }}</div>
                    <div class="cd_choice-counter col-12 d-none"></div>

                    <div class="cd_choice-sentence col-12">
                        {{ $data['choices'][1]->text }}
                    </div>
                </div>
            </div>

        </div>
        <div class="cd_choice-or rounded-circle col-3 col-sm-2 col-lg-1 shadow">
            OR
        </div>
    </div>

    <div class="container">
        @foreach($data['comments'] as $comment)
        <div class="col-sm-12 mb-3">
            <div class="panel panel-default">
                <div class="panel-heading lead">
                    {{$comment->username}} <span class="text-muted">commented on the {{date('d.m.Y \a\t H:i:s',strtotime($comment->created_at))}}</span>
                </div>
                <div class="panel-body">
                    {{$comment->text}}
                </div><!-- /panel-body -->
            </div><!-- /panel panel-default -->
        </div><!-- /col-sm -->
        @endforeach
    </div> <!--/container-->
    
    <h2 style="display:inline-block"></h2>
@endsection

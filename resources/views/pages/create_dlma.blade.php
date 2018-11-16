@extends('layouts.app')

@section('content')

    @include('flash::message')
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <h1 class="text-center cd_page-title">Create a new DLMA</h1>
    <hr class="cd_hr-s2 mb-5" />

    {!! Form::open(['route' => 'createDlma.store']) !!}

    <div class="row text-center">
      <div class="cd_rather-title col-12">
          Would you rather...
      </div>
    </div>
    <div class="cd_choices-main-container row text-center">
        <div class="col-12 col-lg-6 p-3 p-lg-3">

            <div class="btn cd_btn-choice1 userChoice cd_choice-inner-container col-12 h-100 shadow">
            
                <i class="fas fa-check cd_checked-choice d-none"></i>

                <div class="col-12 cd_choice-text-container p-3 p-lg-5">

                  <div class="form-group">
                    {!! Form::textarea('choice_1', null, [
                        'class' => 'form-control cd_form-control-choice cd_choice-sentence',
                        'wrap' => 'soft',
                        'placeholder' => 'Enter choice 1...',
                        'rows' => 3,
                        'maxlength' => '75',
                        'required' => 'required'
                    ]) !!}
                  </div>

                </div>
            </div>
            
        </div>
        <div class="col-12 col-lg-6 p-3 p-lg-3">
            <div class="btn cd_btn-choice2 userChoice cd_choice-inner-container col-12 h-100 shadow">
            
                <i class="fas fa-check cd_checked-choice d-none"></i>
        
                <div class="col-12 cd_choice-text-container p-3 p-lg-5">

                  <div class="form-group">
                    {!! Form::textarea('choice_2', null, [
                        'class' => 'form-control cd_form-control-choice cd_choice-sentence',
                        'wrap' => 'soft',
                        'placeholder' => 'Enter choice 2...',
                        'rows' => 3,
                        'maxlength' => '75',
                        'required' => 'required'
                    ]) !!}
                  </div>

                </div>
            </div>

        </div>
        <div class="cd_choice-or rounded-circle col-3 col-sm-2 col-lg-1 shadow">
            OR
        </div>
    </div>

    <hr class="cd_hr-s1" />

    <div class="form-group">
        {!! Form::label('description', 'Description, optional and used to specify a context...', [
            'class' => 'cd_form-control-description-label'
        ]) !!}
        {!! Form::textarea('description', null, [
            'class' => 'form-control cd_form-control-description',
            'wrap' => 'soft',
            'rows' => 2,
            'maxlength' => '190'
        ]) !!}
    </div>

    <div class="row text-center">
        {!! Form::submit('Submit DLMA', ['class' => 'btn btn-lg cd_btn-default offset-4 col-4 mb-5']) !!}
    </div>

    {!! Form::close() !!}

@endsection

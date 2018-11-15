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

    <h1>Create a new DLMA</h1>
    {!! Form::open(['route' => 'createDlma.store']) !!}

    <div class="row text-center">
      <div class="cd_rather-title col-12">
          Would you rather...
      </div>
    </div>
    <div id="" class="cd_choices-main-container row text-center">
        <div class="col-12 col-lg-6 p-3 p-lg-3">

            <div id="" class="btn cd_btn-choice1 userChoice cd_choice-inner-container col-12 h-100 shadow">
            
                <i id="" class="fas fa-check cd_checked-choice d-none"></i>

                <div class="col-12 cd_choice-text-container p-3 p-lg-5">

                  <div class="form-group">
                    {!! Form::textarea('choice_1', null, ['class' => 'form-control cd_form-control cd_choice-sentence',
                                                          'wrap' => 'soft',
                                                          'rows' => 3,
                                                          'maxlength' => '75',
                                                          'required' => 'required']) !!}
                  </div>

                </div>
            </div>
            
        </div>
        <div class="col-12 col-lg-6 p-3 p-lg-3">
            <div id="" class="btn cd_btn-choice2 userChoice cd_choice-inner-container col-12 h-100 shadow">
            
                <i id="" class="fas fa-check cd_checked-choice d-none"></i>
        
                <div class="col-12 cd_choice-text-container p-3 p-lg-5">

                  <div class="form-group">
                    {!! Form::textarea('choice_2', null, ['class' => 'form-control cd_form-control cd_choice-sentence',
                                                          'wrap' => 'soft',
                                                          'rows' => 3,
                                                          'maxlength' => '75',
                                                          'required' => 'required']) !!}
                  </div>

                </div>
            </div>

        </div>
        <div class="cd_choice-or rounded-circle col-3 col-sm-2 col-lg-1 shadow">
            OR
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('title', 'Title') !!}
        {!! Form::textarea('title', null, ['class' => 'form-control cd_form-control',
                                           'rows' => 2,
                                           'maxlength' => '190',
                                           'required' => 'required']) !!}
    </div>

    {!! Form::submit('Submit DLMA', ['class' => 'btn btn-info']) !!}

    {!! Form::close() !!}

@endsection

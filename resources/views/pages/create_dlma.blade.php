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

    <h2 class="text-center cd_page-title mb-5">Enter your new DLMA</h2>

    {!! Form::open(['route' => 'create_dlma.store']) !!}

    <div class="row text-center">
      <div class="cd_medium-text font-weight-bold col-12">
          Would you rather...
      </div>
    </div>
    <div class="cd_choices-main-container row text-center">
        <div class="col-12 col-lg-6 p-3 p-lg-3 cd_choice-inner-choice1">

            <div class="btn cd_btn-choice1 userChoice cd_choice-inner-container col-12 h-100 shadow">
            
                <i class="fas fa-check cd_checked-choice d-none"></i>

                <div class="col-12 cd_choice-text-container p-3 p-lg-5">

                  <div class="form-group">
                    {!! Form::textarea('choice_1', null, [
                        'class' => 'form-control cd_form-control-choice cd_large-text font-weight-bold',
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
        <div class="col-12 col-lg-6 p-3 p-lg-3 cd_choice-inner-choice2">
            <div class="btn cd_btn-choice2 userChoice cd_choice-inner-container col-12 h-100 shadow">
            
                <i class="fas fa-check cd_checked-choice d-none"></i>
        
                <div class="col-12 cd_choice-text-container p-3 p-lg-5">

                  <div class="form-group">
                    {!! Form::textarea('choice_2', null, [
                        'class' => 'form-control cd_form-control-choice cd_large-text font-weight-bold',
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
        {!! Form::label('description', '[Optional] Help others to understand the context by writing a description !', [
            'class' => 'cd_medium-text'
        ]) !!}
        {!! Form::textarea('description', null, [
            'class' => 'form-control cd_form-control-description cd_medium-text',
            'wrap' => 'soft',
            'rows' => 2,
            'maxlength' => '190'
        ]) !!}
    </div>

    <div class="col-12 text-center">
        <a href="{{ route('home') }}" class="btn btn-lg cd_btn-default mb-5 mr-5">
            Home page
        </a>
        <button type="submit" class="btn btn-lg cd_btn-default cd_btn-animated mb-5">
            <span>Submit DLMA</span>
        </button>
    </div>

    <div class="col-12 text-center">
    </div>

    {!! Form::close() !!}

@endsection

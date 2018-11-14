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

    <div class="form-group">
        {!! Form::label('title', 'Title') !!}
        {!! Form::textarea('title', null, ['class' => 'form-control',
                                           'rows' => 2,
                                           'maxlength' => '190',
                                           'required' => 'required']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('choice_1', 'Choice 1') !!}
        {!! Form::textarea('choice_1', null, ['class' => 'form-control',
                                              'rows' => 1,
                                              'maxlength' => '75',
                                              'required' => 'required']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('choice_2', 'Choice 2') !!}
        {!! Form::textarea('choice_2', null, ['class' => 'form-control',
                                              'rows' => 1,
                                              'maxlength' => '75',
                                              'required' => 'required']) !!}
    </div>

    {!! Form::submit('Submit DLMA', ['class' => 'btn btn-info']) !!}

    {!! Form::close() !!}

@endsection

@extends('layouts.app')

@section('content')
    <h1>Home</h1>
    <h2>Plutôt :</h2>
    <h2 style="display:inline-block">{{$question->choice_1}}</h2>
    <h2 style="display:inline-block"> ou </h2>
    <h2 style="display:inline-block">{{$question->choice_2}}</h2>
@endsection

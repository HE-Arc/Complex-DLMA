@extends('layouts.app')

@section('content')
    <h1>Home</h1>
    <h2>Plutôt :</h2>
    <h2 style="display:inline-block">{{$data['question']->title}}</h2>
    <h2 style="display:inline-block"> ou </h2>
    <h2 style="display:inline-block">{{$data['question']->title}}</h2>
@endsection

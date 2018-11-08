@extends('layouts.app')

@section('content')
    <h1>Home</h1>
    <h2>Plutôt :</h2>
    <h2 style="display:inline-block">{{$data['choices'][array_keys($data['choices'])[0]]->text}}</h2>
    <h2>ou </h2>
    <h2 style="display:inline-block">{{$data['choices'][array_keys($data['choices'])[1]]->text}}</h2>

@endsection

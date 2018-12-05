@extends('layouts.app')

@section('content')

        <div class="col-6 offset-3 card border-dark cd_medium-text mt-5 p-0">
            <div class="card-header cd_large-text">
                No DLMA found...
            </div>

            <div class="card-body">
                Oh ! It looks like you didn't create any complex DLMA...
                <br>
                Start right now, by going to the create DLMA page or go back to the home page.
                <div class="col-12 p-0 text-center">
                    <a class="btn cd_btn-default mt-3 mr-3" href="{{ route('create_dlma') }}">Create a new DLMA</a>
                    <a class="btn cd_btn-default mt-3" href="{{ route('home') }}">Home page</a>
                </div>
            </div>
        </div>  
@endsection

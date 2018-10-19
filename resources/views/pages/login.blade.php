@extends('layouts.app')

@section('content')
    <div class="row text-center">
        <div class="col-12 offset-0 col-md-6 offset-md-3 col-xl-4 offset-xl-4">
            <form class="form-signin">
                <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>

                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" class="form-control mb-1" placeholder="Email address" required autofocus>

                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" class="form-control mb-3" placeholder="Password" required>

                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            </form>
        </div>
    </div>
@endsection
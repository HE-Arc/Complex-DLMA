<nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-laravel">
    <div class="container">
        <a class="cd_logo navbar-brand p-0" href="{{ route('home') }}">
            <div class="cd_logo-part cd_logo-left">
                <img src="{{ asset('img/logo_left.png') }}" class="img-fluid" alt="Complex-DLMA">
            </div>
            <div class="cd_logo-part cd_logo-right">
                <img src="{{ asset('img/logo_right.png') }}" class="img-fluid" alt="Complex-DLMA">
            </div>
            <div class="cd_logo-part cd_logo-center">
                <img src="{{ asset('img/logo_center.png') }}" class="img-fluid" alt="Complex-DLMA">
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('create_dlma') }}">
                        <i class="fas fa-plus-circle mr-1"></i>
                        Create a new DLMA
                    </a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt mr-1"></i>
                            {{ __('Login') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        @if (Route::has('register'))
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus mr-1"></i>
                                {{ __('Register') }}
                            </a>
                        @endif
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->username }} <span class="caret"></span>
                            <i class="fas fa-user ml-1"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                <i class="fas fa-bars mr-1"></i>
                                {{ __('Dashboard') }}
                            </a>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt mr-1"></i>
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
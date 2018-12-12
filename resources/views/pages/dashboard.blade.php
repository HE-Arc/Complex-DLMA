@extends('layouts.app')

@section('content')

    <div class="row mt-5">

        <!-- Redirecting buttons -->
        <div class="col-12 col-sm-6 col-lg-3 text-center p-0 mb-3">
            <a class="btn cd_btn-default cd_btn-default-square-container btn-lg cd_large-text" href="{{ route('home') }}">
                <div class="cd_btn-default-square-content">
                    <i class="fas fa-home cd_icon-square-btn"></i>
                    <br>
                    Home page
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3 text-center p-0 mb-3">
            <a class="btn cd_btn-default cd_btn-default-square-container btn-lg cd_large-text" href="{{ route('create_dlma') }}">
                <div class="cd_btn-default-square-content">
                    <i class="fas fa-plus-circle cd_icon-square-btn"></i>
                    <br>
                    Create a new DLMA
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3 text-center p-0 mb-3">
            <a class="btn cd_btn-default cd_btn-default-square-container btn-lg cd_large-text" href="{{ route('my_dlmas') }}">
                <div class="cd_btn-default-square-content">
                    <i class="fas fa-user cd_icon-square-btn"></i>
                    <br>
                    My DLMAs
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3 text-center p-0 mb-3">
            <a class="btn cd_btn-default cd_btn-default-square-container btn-lg cd_large-text" href="{{ route('answered_dlmas') }}">
                <div class="cd_btn-default-square-content">
                    <i class="fas fa-history cd_icon-square-btn"></i>
                    <br>
                    DLMAs History
                </div>
            </a>
        </div>

    </div>
@endsection

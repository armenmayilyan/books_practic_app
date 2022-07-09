@extends('layouts.main_layout')
@section('title')
    Reset Password
@endsection
@section('content')
    <div class="container mt-5 d-flex justify-content-center">
        <div class="card mt-5">
            <div class="card-header ">
                Reset Password
            </div>
            <form action="{{route('password.reset')}}" method="post">
                @csrf
                <div class="card-body">
                    <input type="email" name="email" id="email" placeholder="email">
                </div>
                <div class="card-body">
                    <input type="password" name="password" placeholder="password">
                </div>
                <div class="card-body">
                    <input type="password" name="password_confirmation" placeholder="password confirmation">
                </div>
                <div class="card-body">
                    <input type="hidden" name="token" value="{{ $token }}">
                </div>
                <div class="card-body">
                    <button class="btn btn-success ">Forgot Password</button>
                </div>
            </form>


        </div>
    </div>

@endsection

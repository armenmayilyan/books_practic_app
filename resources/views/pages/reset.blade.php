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
            <form action="{{route('password.email')}}" method="post">
                @csrf
                <div class="card-body">
                    <input type="email" name="email" id="email">
                </div>
                @if(Session::has('error'))
                    <p class="alert-danger">{{session('error')}}</p>
                @endif
                <div class="card-body">
                    <button class="btn btn-success ">Forgot Password</button>
                </div>
            </form>


        </div>
    </div>

@endsection

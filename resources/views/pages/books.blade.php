@extends('layouts.main_layout')
@section('title')
    Books Page
@endsection
@section('content')

    @foreach($books as $book)
        <div class="container  mt-5 p-5">
            <div class=" shadow card mb-5">
                <img class="card-img-top" src="{{($book->image)}}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">{{$book->name}}</h5>
                    <p class="card-text">{{$book->description}}</p>
                    <p class="card-text">price ${{$book->price}}</p>
                    @if(!Auth::check())
                    @elseif($book->payments->isEmpty())
                        <a class="btn btn-outline-success" href="{{route('stripe',[$book->id])}}">Buy</a>
                    @elseif($book->payments->isNotEmpty())
                        <a class="btn btn-outline-success" href="{{route('download',$book->id)}}">download</a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@endsection

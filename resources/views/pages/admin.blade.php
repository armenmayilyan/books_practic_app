@extends('layouts.main_layout')
@section('title')
    Admin Page
@endsection
@section('content')
    <section class="mt-5">
        <div class="container mt-5">
            <table class="table mt-5 p-5 table-bordered  table-dark">
                <tbody class="text-center shadow mt-5">
                @foreach($users as $user)
                    <tr id="{{$user->id}}">
                        <td>{{$user->id}}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <form method="post" id="destroy" action="{{route('user.destroy',[$user->id])}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="deleteUser({{$user->id}})">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

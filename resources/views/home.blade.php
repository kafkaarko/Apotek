@extends('layouts.layout')

@section('content')
    <div class="jumbotron py-4 px-5">
        @if(Session::get('failed'))
            <div class="alert alert-danger">{{Session::get('failed') }}</div>
        @endif

        @if(Session::get('login'))
            <div class="alert alert-danger">{{Session::get('login')}}</div>
        @endif
            <h1 class="display-4">Selamat datang <b>{{ Auth::user()->name }}</b>!</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate repellat consectetur ipsam nihil quasi fuga soluta, deserunt, omnis perferendis voluptatem ipsa necessitatibus aperiam temporibus.</p>
    </div>
@endsection

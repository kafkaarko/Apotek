@extends('layouts.layout')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-end">
            <a href="{{ route("tambah.pembelian") }}" class="btn btn-primary">pembelian baru</a>
        </div>
    </div>
@endsection
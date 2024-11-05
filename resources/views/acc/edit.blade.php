@extends('layouts.layout')
@section('content')
    <form action="{{ route('acc.update',$akun['id']) }}" method="post" class="card p-5">
        @csrf
        @method("PATCH")
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <div class="mb-3 row">
            <label for="nama" class="col-sm-2 col-form-label">Nama :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="nama" name="name" value="{{ $akun['name'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">email : </label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ $akun['email'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">password : </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="password" name="password" value="{{ $akun['password'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="role" class="col-sm-2-col-form-label">jenis : </label>
            <div class="col-sm-10">
                <select name="role" id="name" class="form-select">
                    <option selected disabled hidden>pilih</option>
                    <option value="admin"{{ $akun['role'] == 'admin' ? 'selected' : '' }}>admin</option>
                    <option value="user"{{ $akun['role'] == 'user' ? 'selected' : '' }}>user</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">tambah data</button>
    </form>
@endsection
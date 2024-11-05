@extends('layouts.layout')

@section('content')
@if (Session::get("success"))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if (Session::get("deleted"))
    <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
@endif
    <a href="{{ route("acc.create") }}" class="btn btn.primary">Tambah Pengguna</a>
    {{-- <form action="" method="post" class="card p-5"> --}}
    <table class="table table-striped table-boarded table-hover">
        <thead>
            <tr>
                <th>no</th>
                <th>nama</th>
                <th>email</th>
                <th>role</th>
                <th class="text-center">aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1 ;
            @endphp
            @foreach ($akun as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['email'] }}</td>
                    <td>{{ $item['role'] }}</td>
                    <td class="d-flex justify-content-center">
                        <a href="{{ route('acc.edit',$item['id']) }}" class="btn btn-primary me-3">Edit</a>
                        <form action="{{ route('acc.destroy', $item['id']) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
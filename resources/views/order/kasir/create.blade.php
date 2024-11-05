@extends('layouts.layout')
@section('content')
    <div class="container mt-3">
        <form action="{{ route('kasir.order.store') }}" method="post" class="card m-auto p-5">
            @csrf
            @if ($errors->any())
            <ul class="alert alert-danger p-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        
            @if (Session::get('failed'))
                <div class="alert alert-danger">{{ Session::get('failed') }}</div>
            @endif
            <p>Penanggung Jawab: <b>{{ Auth::user()->name }}</b></p>
            <div class="mb-3 row">
                <label for="nama_customer" class="col-sm-2 col-form-label">Nama Pembelian</label>
                <div class="col-sm-10">
                    <input type="text" name="name_costumer" id="name_costumer" class="form-control">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="medicines" class="col-sm-2 col-form-label">Obat</label>
                <div class="col-sm-10">
                    <select name="medicines[]" id="medicines" class="form-select">
                        <option selected hidden disabled>Pesanan 1</option>
                        @foreach ($medicines as $item)
                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                        @endforeach
                    </select>
                    <div id="medicines-wrap"></div>
                    <br>
                    <p style="cursor: pointer" class="text-primary" id="add-select">+ Tambah Obat</p>
                </div>
            </div>
            <button type="submit" class="btn btn-block btn-lg btn-primary">Konfirmasi Pembelian</button>
        </form>
    </div>
@endsection

@push('script')
    <script>
        let no = 2;
        $("#add-select").on('click', function() {
            let html = `<br><select name="medicines[]" id="medicines" class="form-select">
            <option selected hidden disabled>Pesanan ${no}</option>
            @foreach ($medicines as $item)
            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
            @endforeach
            </select>`;
            $("#medicines-wrap").append(html);
            no++;
        });
    </script>
@endpush

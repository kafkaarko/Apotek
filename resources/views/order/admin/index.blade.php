@extends('layouts.layout')

@section('content')
    <div class="my-5 d-flex justify-content-end">
        <a href="{{ route("kasir.order.export-excel") }}" class="btn btn-primary"> Export Data (excel)</a>
    </div>
    <table class="table table-striped table-boardered table-hover">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>nama Pembeli</th>
                <th>Obat</th>   
                <th>Kasir</th>
                <th>Tanggal pembelian</th>
                <th>aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $item)
            <tr>
                <td>{{ ($orders->currentpage()-1) * $loop->index + 1 }}</td>
                <td>{{ $item['name_costumer'] }}</td>
                <td>
                    @foreach ($item['medicines'] as $medicine)
                        <ol>
                            <li>
                                {{ $medicine['name_medicine'] }} ( {{ number_format($medicine['sub_price'],0,',','.') }} : Rp. {{ number_format($medicine['sub_price'],0,',','.') }}) <small>qty {{ $medicine['qty'] }}</small>
                            </li>
                        </ol>
                    @endforeach
                </td>
                <td>{{ $item['user']['name'] }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y H:i') }}</td>
                <td>
                    <a href="{{ route('kasir.order.downlaod' , $item->id) }}" class="btn btn-secondary"> Dowload Struk</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
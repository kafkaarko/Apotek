@extends('layouts.layout')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-end">
            <a href="{{ route("kasir.order.create") }}" class="btn btn-primary">pembelian baru</a>
        </div>

        <div class="d-flex justify-content-end">
            <form action="{{ route('kasir.order.index') }}" class="d-flex" role="search" method="GET">
                <input type="date" class="form-control me-2" placeholder="Search Start Date" aria-label="Search" name="start_date" value="{{ request()->input('start_date') }}">
                <input type="date" class="form-control me-2" placeholder="Search End Date" aria-label="End Date" name="end_date" value="{{ request()->input('end_date') }}">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        </div>
    <table class="table table-striped table-boardered table-hover">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>nama Pembeli</th>
                <th>Obat</th>   
                <th>Total Bayar</th>
                <th>Kasir</th>
                <th>Tanggal pembelian</th>
                <th>aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($orders as $item)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
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
                <td>
                    RP.{{ number_format($item['total_price'],0,',','.') }}
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

    <div class="d-flex justify-content-end">
        @if ($orders->count())
            {{ $orders->links() }}
        @endif
    </div>
</div>
@endsection
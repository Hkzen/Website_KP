@extends('main')

@section('container')
<section class="p-2">
<div class="container">
    <h1>History Transaksi</h1>
    @if($transactions->isEmpty())
        <p>Tidak ada transaksi</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Produk (Jumlah)</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transactions)
                <tr>
                    <td>{{ $transactions->order_id }}</td>
                    <td>
                        @foreach(json_decode($transactions->item_details) as $product)
                            {{ $product->name }} ({{ $product->quantity }})<br>
                        @endforeach
                    </td>
                    <td>Rp {{ number_format($transactions->gross_amount, 2) }}</td>
                    <td>{{ $transactions->status }}</td>
                    <td>{{ $transactions->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
</section>
@endsection

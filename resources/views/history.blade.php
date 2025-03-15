@extends('main')

@section('container')
<section class="p-2">
    <div class="container">
        <h1>History Transaksi</h1>
        @if($transactions->isEmpty())
            <p class="text-center">Tidak ada transaksi</p>
        @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Produk (Jumlah)</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->order_id }}</td>
                            <td>
                                @foreach(json_decode($transaction->item_details) as $product)
                                    {{ $product->name }} ({{ $product->quantity }})<br>
                                @endforeach
                            </td>
                            <td>Rp {{ number_format($transaction->gross_amount, 2) }}</td>
                            <td>{{ $transaction->status }}</td>
                            <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
</section>
@endsection
@extends('main')

@section('container')
    <h1>Pembayaran</h1>
    <div id="payment-container"></div>
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.clientKey') }}">
    </script>
    <script type="text/javascript">
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                console.log("Pembayaran berhasil: ", result);
                
                // Membuat form untuk mengirim data hasil transaksi ke server
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("checkout.callback") }}'; // Pastikan ini sesuai dengan rute callback

                var token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token'; // Laravel CSRF token
                token.value = '{{ csrf_token() }}';
                form.appendChild(token);

                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'result'; // Nama input untuk menampung hasil transaksi
                input.value = JSON.stringify(result); // Kirim hasil sebagai JSON
                form.appendChild(input);

                document.body.appendChild(form);
                form.submit(); // Otomatis submit form
            },
            onPending: function(result) {
                console.log("Menunggu pembayaran: ", result);
                alert("Menunggu pembayaran Anda.");
            },
            onError: function(result) {
                console.log("Pembayaran gagal: ", result);
                alert("Pembayaran gagal!");
            }
        });
    </script>
@endsection

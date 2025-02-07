@extends('main')
@section('container')
<div class="container mt-4">
<div class="row justify-content-center">
        <div class="col-lg-4 mb-5">
            @if (session()->has('sukses'))
            <div class="alert alert-succes alert-dismissible fade show" role="alert">
                {{ session('sukses') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            @if (session()->has('loginError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('loginError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

                <main class="form-signin">
                    <h1 class="h3 mb-3 fw-normal"><strong> Login</strong></h1>
                    <form action="/login" method="POST">
                        @csrf
                        <div class="form-floating">
                            <input type="email" name="email" class="form-control @error('email') is invalid
                            @enderror" id="email" placeholder="name@explain.com" required value="{{ old('email') }}">
                            <label for="email">Email Address</label>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating">
                            <input type="password" name="password" class="form-control" id="password"
                            placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                        <button class="w-100 btn btn-lg btn-warning mt-3" type="submit">Login</button>
                    </form>
                    <small class="d-block text-center mt-3 mb-4">Belum registrasi?<a href="/register">
                    Register Sekarang !!</a></small>
                </main>
        </div>
</div>
</div>    
@endsection
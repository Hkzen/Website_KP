@extends('main')
@section('container')
<div class="container mt-4">
<div class="row justify-content-center">
    <div class="col-lg-5 mb-5">
        <main class="form-registration">
            <h1 class="h3 mb-3 fw-normal"><strong> Registrasi</strong></h1>
            <form action="/register" method="POST">
                @csrf
                <div class="form-floating">
                    <input type="text" name="name" class="form-control rounded-top @error('name') is invalid
                    @enderror" placeholder="Name" required value="{{ old('name') }}">
                    <label for="name">Name</label>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-floating">
                    <input type="text" name="username" class="form-control @error('username') is invalid
                    @enderror" placeholder="Username" required value="{{ old('username') }}">
                    <label for="username">Username</label>
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>                       
                    @enderror
                </div>
                <div class="form-floating">
                    <input type="email" name="email" class="form-control rounded-bottom @error('email') is invalid
                    @enderror" placeholder="name@example.com" required value="{{ old('email') }}">
                    <label for="floatingInput">Email Address</label>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-floating">
                    <input type="password" name="password" class="form-control rounded-bottom @error('password') is-invalid @enderror" 
                    placeholder="Password" required>
                    <label for="Password">Password</label>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button class="w-100 btn btn-lg btn-warning mt-3" type="submit">Register</button>
            </form>
            <small class="d-block text-center mt-3 mb-4">Sudah Registrasi?<a href="/login">
            Login Now !!!!!!</a></small>
        </main>
    </div>
</div>
</div>    
@endsection
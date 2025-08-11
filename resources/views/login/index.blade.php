@extends('layouts.app')

@section('content')
    <div class="container shadow rounded-3 col-lg-4 p-3 mt-5">
        {{-- dismissable alert to display error from controller: return back()->withErrors(['ip' => 'Login not allowed from this IP address.']); --}}
        @if ($errors->has('ip'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <small>{{ $errors->first('ip') }}</small>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- dismissable alert to display error --}}
        @if (session()->has('loginError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <small>{{ session('loginError') }}</small>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="justify-content-start text-center">
            <img src={{ asset('assets/undip-logo-cropped.svg') }} width="100" class="" alt="">
            <div class="d-flex flex-column my-3 gap-1">
                <h1 class="card-title display-6">E-Office Undip</h1>
                <p class="m-0">Selamat datang di Aplikasi E-Office <br> Universitas Diponegoro</p>
            </div>
        </div>

        <form action="{{ route('login.authenticate') }}" method="POST" class="d-flex flex-column mb-1">
            @csrf
            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    placeholder="name@example.com" name="email" value="{{ old('email') }}">
                <label for="email">Email address</label>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    placeholder="Password" name="password">
                <label for="password">Password</label>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary header1 ">Masuk</button>
        </form>
    </div>
@endsection

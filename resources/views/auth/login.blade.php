@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6 col-lg-5">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                {{-- Top Branding --}}
                <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #0d6efd, #0b5ed7);">
                    <div class="mb-2">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white text-primary"
                             style="width:60px;height:60px;font-weight:700;font-size:20px;">
                            AP
                        </div>
                    </div>
                    <h4 class="mb-0" style="font-weight:700;">Amad Printing & Press</h4>
                    <small class="opacity-75">POS Login Panel</small>
                </div>

                <div class="card-body p-4 p-md-5">
                    <h5 class="mb-1" style="font-weight:700;">Welcome Back</h5>
                    <p class="text-muted mb-4">Please login to continue to dashboard.</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                <input id="email"
                                       type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       name="email"
                                       value="{{ old('email') }}"
                                       placeholder="Enter your email"
                                       required autocomplete="email" autofocus>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa fa-lock"></i>
                                </span>
                                <input id="password"
                                       type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password"
                                       placeholder="Enter your password"
                                       required autocomplete="current-password">
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Remember + Forgot --}}
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a class="text-decoration-none" href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>

                        {{-- Button --}}
                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3" style="font-weight:600;">
                            Login
                        </button>

                        <div class="text-center mt-4">
                            <small class="text-muted">
                                © {{ date('Y') }} Amad Printing & Press — POS System
                            </small>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

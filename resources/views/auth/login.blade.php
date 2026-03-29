@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="auth-card">
        <div class="auth-brand auth-field" style="animation-delay: 0.02s">
            <span class="auth-brand__icon" aria-hidden="true"><i class="bi bi-kanban-fill"></i></span>
            <span class="auth-brand__text">TaskFlow</span>
        </div>
        <p class="auth-lead auth-field" style="animation-delay: 0.06s">Sign in to pick up where you left off.</p>

        <form method="POST" action="{{ route('login') }}" class="auth-form" novalidate>
            @csrf
            <div class="auth-field" style="animation-delay: 0.1s">
                <label for="login" class="auth-label">Email or username</label>
                <input type="text" class="form-control @error('login') is-invalid @enderror" id="login" name="login" value="{{ old('login') }}" required autofocus autocomplete="username" placeholder="you@company.com">
                @error('login')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="auth-field" style="animation-delay: 0.14s">
                <label for="password" class="auth-label">Password</label>
                <div class="auth-input-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                    <button type="button" class="auth-toggle-password" aria-label="Show password"><i class="bi bi-eye"></i></button>
                </div>
                @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="auth-field auth-form-check" style="animation-delay: 0.18s">
                <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label mb-0" for="remember">Remember me on this device</label>
            </div>
            <div class="auth-field mb-0" style="animation-delay: 0.22s">
                <button type="submit" class="btn btn-auth-submit">
                    <span class="btn-label">Sign in</span>
                    <span class="btn-spinner" aria-hidden="true"><i class="bi bi-arrow-repeat fs-5"></i></span>
                </button>
            </div>
        </form>

        <div class="auth-footer auth-field" style="animation-delay: 0.26s">
            Don't have an account? <a href="{{ route('register') }}">Create one</a>
        </div>
    </div>
@endsection

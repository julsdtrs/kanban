@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="auth-card">
        <div class="auth-brand auth-field" style="animation-delay: 0.02s">
            <span class="auth-brand__icon" aria-hidden="true"><i class="bi bi-kanban-fill"></i></span>
            <span class="auth-brand__text">TaskFlow</span>
        </div>
        <p class="auth-lead auth-field" style="animation-delay: 0.06s">Create an account to organize work with your team.</p>

        <form method="POST" action="{{ route('register') }}" class="auth-form" novalidate>
            @csrf
            <div class="auth-field" style="animation-delay: 0.08s">
                <label for="username" class="auth-label">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required autocomplete="username" placeholder="jane.doe">
                @error('username')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="auth-field" style="animation-delay: 0.1s">
                <label for="email" class="auth-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="you@company.com">
                @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="auth-field" style="animation-delay: 0.12s">
                <label for="display_name" class="auth-label">Display name <span class="fw-normal text-muted">(optional)</span></label>
                <input type="text" class="form-control @error('display_name') is-invalid @enderror" id="display_name" name="display_name" value="{{ old('display_name') }}" autocomplete="name" placeholder="Jane Doe">
                @error('display_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="auth-field" style="animation-delay: 0.14s">
                <label for="password" class="auth-label">Password</label>
                <div class="auth-input-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password" placeholder="At least 8 characters">
                    <button type="button" class="auth-toggle-password" aria-label="Show password"><i class="bi bi-eye"></i></button>
                </div>
                @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="auth-field" style="animation-delay: 0.16s">
                <label for="password_confirmation" class="auth-label">Confirm password</label>
                <div class="auth-input-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat password">
                    <button type="button" class="auth-toggle-password" aria-label="Show password"><i class="bi bi-eye"></i></button>
                </div>
            </div>
            <div class="auth-field mb-0" style="animation-delay: 0.2s">
                <button type="submit" class="btn btn-auth-submit">
                    <span class="btn-label">Create account</span>
                    <span class="btn-spinner" aria-hidden="true"><i class="bi bi-arrow-repeat fs-5"></i></span>
                </button>
            </div>
        </form>

        <div class="auth-footer auth-field" style="animation-delay: 0.24s">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </div>
    </div>
@endsection

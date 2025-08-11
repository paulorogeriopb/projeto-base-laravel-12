@extends('layouts.guest')

@section('content')
    <div class="card-login">
        <div class="logo-wrapper-login">
            <a href="{{ url('/') }}">
                <h1 class="title-logo">Nimbuns</h1>
            </a>
        </div>

        <h1 class="title-login">Novo Usuário</h1>
        <form method="POST" action="{{ route('register') }}" class="mt-4">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">
                    {{ __('Name') }}
                </label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    autocomplete="name" class="form-input" />
                @error('name')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mt-4 form-group">
                <label for="email" class="form-label">
                    {{ __('Email') }}
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    autocomplete="username" class="form-input" />
                @error('email')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mt-4 form-group">
                <label for="password" class="form-label">
                    {{ __('Password') }}
                </label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="form-input" />
                @error('password')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror


            </div>

            <!-- Confirm Password -->
            <div class="mt-4 form-group">
                <label for="password_confirmation" class="form-label">
                    {{ __('Confirm Password') }}
                </label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password" class="form-input" />
                @error('password_confirmation')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <!-- começo do aviso de senha -->
            @include('components.password-rules')
            <!-- fim do aviso de senha -->

            <div class="flex items-center justify-end mt-4 ">
                <a class="link-padrao" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <button type="submit" class="btn-primary-md ms-4">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
@endsection


@push('scripts')
    @vite('resources/js/password-rules.js')
@endpush

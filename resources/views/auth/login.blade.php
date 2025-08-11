@extends('layouts.guest')

@section('content')
    <div class="card-login">
        <div class="logo-wrapper-login">

            <h1 class="title-logo">Nimbuns</h1>
        </div>


        <x-alert />


        <h1 class="title-login">Área Restrita</h1>


        <form method="POST" action="{{ route('login') }}" class="mt-4">
            @csrf

            <!-- Email Address -->
            <div class="form-group-login">
                <label for="email" class="form-label">
                    {{ __('Email') }}
                </label>
                <input id="email" type="email" name="email" placeholder="{{ __('Email') }}"
                    value="{{ old('email') }}" required autofocus autocomplete="username" class="form-input">
                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group-login">
                <label for="password" class="form-label">
                    {{ __('Password') }}
                </label>
                <input id="password" type="password" name="password" placeholder="{{ __('Password') }}" required
                    autocomplete="current-password" class="form-input">
                @error('password')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="border-gray-300 rounded shadow-sm text-cor-padrao focus:ring-cor-padrao" name="remember">
                    <span class="link-padrao ms-2">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Link para recuperação de senha e botão de login -->
            <div class="btn-group-login">
                @if (Route::has('password.request'))
                    <a class="link-padrao" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <button type="submit" class="btn-primary-md">
                    {{ __('Log in') }}
                </button>
            </div>

            <div class="mt-4 text-center">
                <a class="link-padrao" href="{{ route('register') }}">
                    {{ __('create new account') }}
                </a>

            </div>

        </form>
    </div>
@endsection

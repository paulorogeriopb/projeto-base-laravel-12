@extends('layouts.guest')

@section('content')
    <!-- Session Status -->



    <div class="card-login">
        <div class="logo-wrapper-login">
            <a href="{{ url('/') }}">
                <h1 class="title-logo">Nimbuns</h1>
            </a>
        </div>

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="flex items-center justify-between mt-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <button type="submit" class="btn-primary-md">
                        {{ __('Resend Verification Email') }}
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="link-padrao">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
@endsection

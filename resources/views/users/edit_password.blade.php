@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">{{ pageTitle() }}</h2>
            {!! renderBreadcrumb() !!}
        </div>

        <div class="content-box">
            <div class="content-box-header">
                <h3 class="content-box-title">{{ __('mensagens.edit_password') }}</h3>
                <div class="content-box-btn">

                    @can('user-index')
                        <a href="{{ route('users.index') }}" class="btn-info align-icon-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                            </svg>
                            <span>Listar</span>
                        </a>
                    @endcan

                    @can('user-show')
                        <a href="{{ route('users.show', ['user' => $user->id]) }}" class="btn-info align-icon-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <span>Listar</span>
                        </a>
                    @endcan

                </div>
            </div>

            <br>

            {{-- Mostra mensagens flash (success, error, info) --}}
            <x-alert />

            <form action="{{ route('users.update_password', ['user' => $user->id]) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="password" class="form-label">Senha:</label>
                    <input type="password" name="password" id="password" placeholder="Senha do usuário"
                        class="form-input @error('password') border-red-600 focus:ring-red-500 @enderror" required>

                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror


                </div>

                <div>
                    <label for="password_confirmation" class="mt-4 form-label">Confirmar Senha:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        placeholder="Confirmar a senha" class="form-input" required>
                </div>

                <!-- começo do aviso de senha -->
                @include('components.password-rules')
                <!-- fim do aviso de senha -->


                <div class="flex justify-end mt-4">
                    <button type="submit" class="btn-success">
                        {{ __('mensagens.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/password-rules.js')
@endpush

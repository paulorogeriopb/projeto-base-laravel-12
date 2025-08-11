@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">{{ pageTitle() }}</h2>
            {!! renderBreadcrumb() !!}
        </div>

        <div class="content-box">

            @include('users._form', [
                'action' => route('users.store'),
                'method' => 'POST',
                'user' => null,
                'roles' => $roles,
                'userRoles' => [],
                'buttonText' => __('mensagens.save'),
            ])
        </div>
    </div>
@endsection

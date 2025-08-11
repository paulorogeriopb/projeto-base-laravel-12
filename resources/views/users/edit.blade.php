@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">{{ pageTitle() }}</h2>
            {!! renderBreadcrumb() !!}
        </div>

        <div class="content-box">

            @include('users._form', [
                'action' => route('users.update', $user->id),
                'method' => 'PUT',
                'user' => $user,
                'roles' => $roles,
                'userRoles' => $user->roles->pluck('name')->toArray(),
                'buttonText' => __('mensagens.update'),
            ])
        </div>
    </div>
@endsection

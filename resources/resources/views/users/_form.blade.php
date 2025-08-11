<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div>
        <label for="name" class="form-label">Nome</label>
        <input type="text" name="name" id="name" placeholder="Nome do usuário"
            value="{{ old('name', $user->name ?? '') }}"
            class="form-input @error('name') border-red-600 focus:ring-red-500 @enderror" required>
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="form-label">E-mail</label>
        <input type="email" name="email" id="email" placeholder="E-mail do usuário"
            value="{{ old('email', $user->email ?? '') }}"
            class="form-input @error('email') border-red-600 focus:ring-red-500 @enderror" required>
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="user_status_id" class="form-label">Status do Usuário</label>
        <select name="user_status_id" id="user_status_id"
            class="form-input @error('user_status_id') border-red-600 focus:ring-red-500 @enderror">
            <option value="">-- Selecione o status --</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->id }}"
                    {{ (old('user_status_id') ?? ($user->user_status_id ?? '')) == $status->id ? 'selected' : '' }}>
                    {{ $status->name }}
                </option>
            @endforeach
        </select>
        @error('user_status_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    @can('roles-user-edit')
        <div>
            <label class="form-label">Papéis</label>
            <div class="flex flex-wrap gap-4">
                @forelse ($roles as $role)
                    @if ($role != 'Super Admin' || Auth::user()->hasRole('Super Admin'))
                        <div class="flex items-center">
                            <input type="checkbox" name="roles[]" id="role_{{ Str::slug($role) }}"
                                value="{{ $role }}"
                                {{ in_array($role, old('roles', $userRoles ?? [])) ? 'checked' : '' }}
                                class="w-5 h-5 border-gray-300 rounded text-cor-padrao focus:ring-cor-padrao dark:border-gray-600">
                            <label class="ml-2 form-label" for="role_{{ Str::slug($role) }}">{{ $role }}</label>
                        </div>
                    @endif
                @empty
                    <p class="form-label">Nenhum papel disponível.</p>
                @endforelse
            </div>
            @error('roles')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    @endcan

    @if (is_null($user))
        <div>
            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" id="password" placeholder="Senha do usuário"
                class="form-input @error('password') border-red-600 focus:ring-red-500 @enderror" required>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

        </div>

        <div>
            <label for="password_confirmation" class="form-label">Confirmar Senha</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                placeholder="Confirmar a senha"
                class="form-input @error('password_confirmation') border-red-600 focus:ring-red-500 @enderror" required>
            @error('password_confirmation')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- começo do aviso de senha -->
        @include('components.password-rules')
        <!-- fim do aviso de senha -->
    @else
        {{-- Botão para alterar senha no modo de edição --}}
        @can('users-edit-password')
            <div>
                <a href="{{ route('users.edit_password', $user) }}" class="inline-flex items-center gap-2 btn-info">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 10.5V7.5a4.5 4.5 0 00-9 0v3m-1.5 0h12a1.5 1.5 0 011.5 1.5v7.5a1.5 1.5 0 01-1.5 1.5h-12a1.5 1.5 0 01-1.5-1.5v-7.5a1.5 1.5 0 011.5-1.5z" />
                    </svg>
                    <span>Alterar Senha</span>
                </a>
            </div>
        @endcan
    @endif

    <div class="flex justify-end">
        <button type="submit" class="btn-success">
            {{ $buttonText ?? __('mensagens.save') }}
        </button>
    </div>
</form>

@if (is_null($user))
    @push('scripts')
        @vite('resources/js/password-rules.js')
    @endpush
@endif

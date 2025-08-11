@props(['route', 'method' => 'POST', 'data' => null])

<form action="{{ $route }}" method="POST">
    @csrf

    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="mb-4">
        <label for="name" class="form-label">Nome do Curso:</label>
        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $data->name ?? '') }}">
        @error('name')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn-success">
        {{ $method === 'PUT' ? 'Atualizar ' : 'Criar ' }}
    </button>
</form>

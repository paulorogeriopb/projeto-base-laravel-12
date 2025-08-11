@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">{{ pageTitle() }}</h2>
            {!! renderBreadcrumb() !!}
        </div>
    </div>

    <div class="content-box">
        <div class="content-box-header">
            <h3 class="content-box-title">{{ __('mensagens.list') }}</h3>
            <div class="content-box-btn">
                @can('cursos.create')
                    <a href="{{ route('translations.create') }}" class="flex items-center space-x-1 btn-success">
                        <!-- Ícone plus-circle (Heroicons) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>Cadastrar</span>
                    </a>
                @endcan
            </div>
        </div>


        @include('components.search-forms')


        <x-alert />

        @if ($translations->isNotEmpty())
            <!-- Tabela -->
            <div class="mt-6 overflow-x-auto table-container">
                <table class="table w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 table-row-header">
                            <th class="p-3 text-left border-b table-header">ID</th>
                            <th class="p-3 text-left border-b table-header">Chave</th>
                            <th class="p-3 text-left border-b table-header">Grupo</th>
                            <th class="p-3 text-left border-b table-header">PT</th>
                            <th class="p-3 text-left border-b table-header">EN</th>
                            <th class="p-3 text-left border-b table-header">ES</th>
                            <th class="p-3 text-center border-b table-header">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="table-zebra-light">
                        @foreach ($translations as $translation)
                            <tr class="table-row-body hover:bg-gray-50">
                                <td class="p-3 border-b table-body">{{ $translation->id }}</td>
                                <td class="p-3 border-b table-body">{{ $translation->key }}</td>
                                <td class="p-3 border-b table-body">{{ $translation->group ?? '-' }}</td>
                                <td class="p-3 border-b table-body">{{ $translation->getTranslation('text', 'pt') }}</td>
                                <td class="p-3 border-b table-body">{{ $translation->getTranslation('text', 'en') }}</td>
                                <td class="p-3 border-b table-body">{{ $translation->getTranslation('text', 'es') }}</td>
                                <td class="p-3 text-center border-b table-actions">
                                    <div class="inline-flex justify-center space-x-2 table-actions-align">
                                        @can('translation-edit')
                                            <a href="{{ route('translations.edit', $translation->id) }}"
                                                class="items-center hidden space-x-1 btn-warning md:flex">
                                                <!-- Ícone Edit (Heroicons) -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                                <span>Editar</span>
                                            </a>
                                        @endcan

                                        @can('translation-destroy')
                                            <form action="{{ route('translations.destroy', $translation->id) }}" method="POST"
                                                class="items-center hidden space-x-1 form-delete btn-danger md:flex"
                                                data-id="{{ $translation->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex items-center space-x-1 delete-button">
                                                    <!-- Ícone trash (Heroicons) -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                    <span>Apagar</span>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- Mensagem de Nenhuma Tradução Encontrada -->
            <div class="flex flex-col items-center justify-center py-20 text-center text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-4 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.75 9.75h.008v.008H9.75v-.008ZM14.25 9.75h.008v.008h-.008v-.008ZM12 15.75a6.75 6.75 0 1 0 0-13.5 6.75 6.75 0 0 0 0 13.5Z" />
                </svg>
                <p class="text-lg font-medium">Nenhuma tradução encontrada.</p>
                <p class="text-sm text-gray-400">Tente ajustar os filtros de pesquisa ou adicione uma nova tradução.</p>
            </div>
        @endif

        <div class="mt-4">
            {{ $translations->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/alert-delete.js')
@endpush

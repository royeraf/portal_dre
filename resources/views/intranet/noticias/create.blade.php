<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> Noticias
    </x-slot>
    <h6 class="br-section-label">Registro</h6>

    @include('intranet.noticias._form', [
        'action'      => route('noticias.store'),
        'method'      => 'POST',
        'submitLabel' => 'Guardar',
        'noticia'     => null,
    ])
</x-app-layout>

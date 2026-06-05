<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> Noticias
    </x-slot>
    <h6 class="br-section-label">Editar</h6>

    @include('intranet.noticias._form', [
        'action'      => route('noticias.update', $noticia),
        'method'      => 'PUT',
        'submitLabel' => 'Actualizar',
        'noticia'     => $noticia,
    ])
</x-app-layout>

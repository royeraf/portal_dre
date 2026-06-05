<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> Noticias
    </x-slot>
    <div class="row">
        <div class="col">
            <table class="table table-hover small">
                <thead>
                    <tr>
                        <th class="border border-slate-500">ID</th>
                        <th class="border border-slate-500">Titulo</th>
                        <th class="border border-slate-500">Estado</th>
                        <th class="border border-slate-500">Fecha Publicacion</th>
                        <th class="border border-slate-500">Accion</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($noticias as $item)
                <tr>
                    <td class="border border-slate-500">{{ $item->id }}</td>
                    <td class="border border-slate-500">{{ $item->titulo }}</td>
                    <td class="border border-slate-500">{{ $item->activo }}</td>
                    <td class="border border-slate-500">{{ $item->fechapubli }}</td>
                    <td class="border border-slate-500">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('noticias.destroy', $item->id) }}" class="btn btn-danger btn-sm eliminar" data-titulo="{{ $item->titulo }}" title="Eliminar"><i class="fas fa-trash"></i></a>
                            <a href="{{ route('noticias.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Editar"><i class="icon ion-edit"></i></a>
                            <a href="{{ route('noticias.show', $item->id) }}" class="btn btn-primary btn-sm mostrar" title="Mostrar"><i class="fa fa-eye"></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{ $noticias->links() }}
        </div>
    </div>

    {{-- Modal de confirmación para eliminar --}}
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle text-danger"></i> Confirmar eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Seguro que deseas eliminar la noticia «<strong id="delTitulo"></strong>»?<br>
                    Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger"><i class="fas fa-trash"></i> Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para mostrar la noticia (página dentro de un iframe) --}}
    <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-eye"></i> Vista de la noticia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="showFrame" src="about:blank" style="width:100%;height:80vh;border:0;"></iframe>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Confirmación antes de eliminar
            $('.eliminar').on('click', function (e) {
                e.preventDefault();
                $('#delTitulo').text($(this).data('titulo'));
                $('#confirmDeleteBtn').attr('href', $(this).attr('href'));
                $('#confirmDeleteModal').modal('show');
            });

            // Mostrar la noticia dentro de un modal (iframe a la página show)
            $('.mostrar').on('click', function (e) {
                e.preventDefault();
                $('#showFrame').attr('src', $(this).attr('href'));
                $('#showModal').modal('show');
            });
            $('#showModal').on('hidden.bs.modal', function () {
                $('#showFrame').attr('src', 'about:blank'); // libera el contenido al cerrar
            });
        </script>
    @endpush
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> REGISTROS INFRAESTRUCTURA
    </x-slot>

            <h6 class="br-section-label">Registro</h6>
            <form action="{{ route('infraestructura.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        <label class="form-control-label" for="inputGroupFile1">IMAGEN: </label>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile1" name="imagen" required>
                                <label class="custom-file-label" for="inputGroupFile1" aria-describedby="inputGroupFileAddon">Choose image</label>
                            </div>
                        </div>
                        <div class="border rounded-lg text-center p-3">
                            <img src="//placehold.it/140?text=IMAGE" class="img-fluid" id="preview1" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <br>
                        <button class="btn btn-info">Guardar</button>
                    </div>
                </div>
            </form><br>

    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border border-slate-500">ID</th>
                        <th class="border border-slate-500">imagen</th>
                        <th class="border border-slate-500">Accion</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($registros as $item)
                <tr>
                    <td class="border border-slate-500">{{ $item->id }}</td>
                    <td class="border border-slate-500 text-center"><img width="300" class="img-fluid img-thumbnail mx-auto" src="{{asset('img/infraestructura/'.$item->imagen)}}" alt=""></td>
                    <td class="border border-slate-500">
                        <div class="btn-group">
                            <a href="{{ route('infraestructura.destroy', $item->id) }}" class="btn btn-danger btn-sm eliminar" title="Eliminar"><i class="fas fa-trash"></i></a>
                        </div>

                    </td>
                </tr>
                </tbody>
                @endforeach
            </table>
            {{ $registros->links() }}
        </div>
    </div>

</x-app-layout>

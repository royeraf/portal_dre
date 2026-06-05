<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> Noticias
    </x-slot>
    <h6 class="br-section-label">Registro</h6>
    <form action="{{ route('noticias.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row mg-b-25">
            <div class="col-lg-10">
                <div class="form-group">
                    <label class="form-control-label" for="titulo">Titulo: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" placeholder="Nombre">
                    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="form-control-label" for="iduser">ID USUARIO: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="iduser" id="iduser" value="{{ Auth::user()->id }}" readonly>
                    <x-input-error :messages="$errors->get('iduser')" class="mt-2" />
                </div>                
            </div>
        </div><!-- row -->
        <div class="row">
            <div class="col">
                <label class="form-control-label" for="descripcioncorta">DESCRIPCION CORTA <span class="tx-danger">*</span></label>
                <textarea name="descripcioncorta" id="descripcioncorta" class="form-control">{{ old('descripcioncorta') }}</textarea>
                <x-input-error :messages="$errors->get('descripcioncorta')" class="mt-2" />
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <label class="form-control-label" for="idusuario">CONTENIDO: <span class="tx-danger">*</span></label>
                <textarea rows="16" class="form-control is-valid mg-t-20" name="contenido" id="mysummernote" placeholder="Textarea (success state)">{{ old('contenido') }}</textarea>
                <x-input-error :messages="$errors->get('contenido')" class="mt-2" />
            </div><!-- col-4 -->            
        </div>
        <br>
        <div class="row">
            <div class="col">
                <label class="form-control-label" for="inputGroupFile1">IMAGEN 1: </label>
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile1" name="img1" accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp">
                        <label class="custom-file-label" for="inputGroupFile1" aria-describedby="inputGroupFileAddon">Choose image</label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('img1')" class="mt-2" />
                <div class="border rounded-lg text-center p-3">
                    <img src="//placehold.it/140?text=IMAGE" class="preview-img" id="preview1" />
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger mt-2 clear-img" style="display:none;"
                    data-input="inputGroupFile1" data-preview="preview1">
                    <i class="far fa-trash-alt"></i> Quitar imagen
                </button>
            </div>
            <div class="col">
                <label class="form-control-label" for="inputGroupFile2">IMAGEN 2: </label>
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile2" name="img2" accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp">
                        <label class="custom-file-label" for="inputGroupFile2" aria-describedby="inputGroupFileAddon">Choose image</label>
                    </div>
                </div>
                <div class="border rounded-lg text-center p-3">
                    <img src="//placehold.it/140?text=IMAGE" class="preview-img" id="preview2" />
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger mt-2 clear-img" style="display:none;"
                    data-input="inputGroupFile2" data-preview="preview2">
                    <i class="far fa-trash-alt"></i> Quitar imagen
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label class="form-control-label" for="inputGroupFile3">IMAGEN 3: </label>
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile3" name="img3" accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp">
                        <label class="custom-file-label" for="inputGroupFile3" aria-describedby="inputGroupFileAddon">Choose image</label>
                    </div>
                </div>
                <div class="border rounded-lg text-center p-3">
                    <img src="//placehold.it/140?text=IMAGE" class="preview-img" id="preview3" />
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger mt-2 clear-img" style="display:none;"
                    data-input="inputGroupFile3" data-preview="preview3">
                    <i class="far fa-trash-alt"></i> Quitar imagen
                </button>                  
            </div>
            <div class="col">
                <div class="form-group">
                    <label class="form-control-label" for="fechapubli">FECHA DE PUBLICACION: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="date" name="fechapubli" id="fechapubli" value="{{ old('fechapubli', date('Y-m-d')) }}">
                    <x-input-error :messages="$errors->get('fechapubli')" class="mt-2" />
                </div>   
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn btn-info">Guardar</button>
            </div>
        </div>
    </form>

    {{-- Modal para ver la imagen a detalle --}}
    <div class="modal fade" id="imgDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 text-center position-relative">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="position:absolute;top:8px;right:12px;z-index:2;background:#fff;border-radius:50%;width:32px;height:32px;opacity:1;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <img src="" id="imgDetailTarget" class="img-fluid" style="max-height:85vh;" alt="Vista a detalle" />
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .preview-img {
                width: 100%;
                height: 200px;
                object-fit: cover;
                border-radius: .5rem;
                cursor: pointer;
                transition: opacity .2s;
            }
            .preview-img:hover { opacity: .85; }
        </style>
    @endpush

    @push('scripts')
        <script>
            $(document).on('click', '.preview-img', function () {
                var src = $(this).attr('src');
                if (!src || src.indexOf('placehold') !== -1) return; // aún sin imagen elegida
                $('#imgDetailTarget').attr('src', src);
                $('#imgDetailModal').modal('show');
            });

            // Mostrar el botón "Quitar" al elegir una imagen
            $('.custom-file-input').on('change', function () {
                if (this.files && this.files.length) {
                    $(this).closest('.col').find('.clear-img').show();
                }
            });

            // Quitar la imagen seleccionada (por si fue por error)
            $('.clear-img').on('click', function () {
                var $input = $('#' + $(this).data('input'));
                $input.val('');                                                       // no se enviará
                $('#' + $(this).data('preview')).attr('src', '//placehold.it/140?text=IMAGE');
                $input.siblings('.custom-file-label').removeClass('selected').text('Choose image');
                $(this).hide();
            });
        </script>
    @endpush

</x-app-layout>


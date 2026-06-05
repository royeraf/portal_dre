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
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-control-label" for="fechapubli">FECHA DE PUBLICACION: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="date" name="fechapubli" id="fechapubli" value="{{ old('fechapubli', date('Y-m-d')) }}">
                    <x-input-error :messages="$errors->get('fechapubli')" class="mt-2" />
                </div>
            </div>
        </div>
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
        <h6 class="br-section-label">Imágenes</h6>
        <div class="row">
            <div class="col-md-4 mb-4">
                <label class="form-control-label" for="inputGroupFile1">IMAGEN 1: <span class="tx-danger">*</span></label>
                <div class="custom-file mb-3">
                    <input type="file" class="custom-file-input" id="inputGroupFile1" name="img1" accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp">
                    <label class="custom-file-label" for="inputGroupFile1" data-browse="Examinar">Seleccionar imagen</label>
                </div>
                <x-input-error :messages="$errors->get('img1')" class="mt-2" />
                <div class="border rounded-lg text-center p-3 preview-box">
                    <div class="preview-empty" id="empty1">
                        <i class="far fa-image preview-icon"></i>
                        <div class="preview-hint">Vista previa</div>
                    </div>
                    <img src="" class="preview-img" id="preview1" style="display:none;" />
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger mt-2 clear-img" style="display:none;"
                    data-input="inputGroupFile1" data-preview="preview1">
                    <i class="far fa-trash-alt"></i> Quitar imagen
                </button>
            </div>
            <div class="col-md-4 mb-4">
                <label class="form-control-label" for="inputGroupFile2">IMAGEN 2: </label>
                <div class="custom-file mb-3">
                    <input type="file" class="custom-file-input" id="inputGroupFile2" name="img2" accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp">
                    <label class="custom-file-label" for="inputGroupFile2" data-browse="Examinar">Seleccionar imagen</label>
                </div>
                <div class="border rounded-lg text-center p-3 preview-box">
                    <div class="preview-empty" id="empty2">
                        <i class="far fa-image preview-icon"></i>
                        <div class="preview-hint">Vista previa</div>
                    </div>
                    <img src="" class="preview-img" id="preview2" style="display:none;" />
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger mt-2 clear-img" style="display:none;"
                    data-input="inputGroupFile2" data-preview="preview2">
                    <i class="far fa-trash-alt"></i> Quitar imagen
                </button>
            </div>
            <div class="col-md-4 mb-4">
                <label class="form-control-label" for="inputGroupFile3">IMAGEN 3: </label>
                <div class="custom-file mb-3">
                    <input type="file" class="custom-file-input" id="inputGroupFile3" name="img3" accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp">
                    <label class="custom-file-label" for="inputGroupFile3" data-browse="Examinar">Seleccionar imagen</label>
                </div>
                <div class="border rounded-lg text-center p-3 preview-box">
                    <div class="preview-empty" id="empty3">
                        <i class="far fa-image preview-icon"></i>
                        <div class="preview-hint">Vista previa</div>
                    </div>
                    <img src="" class="preview-img" id="preview3" style="display:none;" />
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger mt-2 clear-img" style="display:none;"
                    data-input="inputGroupFile3" data-preview="preview3">
                    <i class="far fa-trash-alt"></i> Quitar imagen
                </button>
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
            .preview-box {
                min-height: 200px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #f8f9fb;
            }
            .preview-empty {
                color: #b8c0cc;
                cursor: pointer;
                transition: color .2s;
                user-select: none;
            }
            .preview-empty:hover { color: #8a94a6; }
            .preview-icon { font-size: 56px; line-height: 1; }
            .preview-hint {
                font-size: 13px;
                margin-top: 8px;
                letter-spacing: .3px;
            }
            .preview-img {
                width: 100%;
                height: 200px;
                object-fit: cover;
                border-radius: .5rem;
                cursor: pointer;
                transition: opacity .2s;
            }
            .preview-img:hover { opacity: .85; }

            /* File input más prolijo */
            .custom-file { height: calc(2.25rem + 2px); }
            .custom-file-input { cursor: pointer; }
            .custom-file-label {
                border-radius: .4rem;
                color: #8a94a6;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                padding-right: 6.5rem;
            }
            .custom-file-label::after {
                background-color: #17a2b8;
                color: #fff;
                border-left: 0;
                border-radius: 0 .4rem .4rem 0;
                padding: .375rem 1rem;
            }
            .custom-file-input:hover ~ .custom-file-label::after { background-color: #138496; }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Abrir el modal de detalle al hacer clic en una vista previa con imagen
            $(document).on('click', '.preview-img', function () {
                var src = $(this).attr('src');
                if (!src) return;
                $('#imgDetailTarget').attr('src', src);
                $('#imgDetailModal').modal('show');
            });

            // Al elegir una imagen: mostrarla, ocultar el estado vacío y mostrar "Quitar"
            $('.custom-file-input').on('change', function () {
                var $col = $(this).closest('.col');
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $col.find('.preview-img').attr('src', e.target.result).show();
                        $col.find('.preview-empty').hide();
                    };
                    reader.readAsDataURL(this.files[0]);
                    $col.find('.clear-img').show();
                }
            });

            // Clic en el estado vacío → abre el selector de archivo
            $('.preview-empty').on('click', function () {
                $(this).closest('.col').find('.custom-file-input').click();
            });

            // Quitar la imagen seleccionada (por si fue por error)
            $('.clear-img').on('click', function () {
                var $col = $(this).closest('.col');
                var $input = $('#' + $(this).data('input'));
                $input.val('');                                                   // no se enviará
                $col.find('.preview-img').attr('src', '').hide();
                $col.find('.preview-empty').show();
                $input.siblings('.custom-file-label').removeClass('selected').text('Seleccionar imagen');
                $(this).hide();
            });
        </script>
    @endpush

</x-app-layout>


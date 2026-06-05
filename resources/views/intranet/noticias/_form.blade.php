{{--
    Formulario reutilizable de noticias (crear / editar).
    Variables esperadas:
      $action      → URL del form
      $method      → 'POST' (crear) | 'PUT' (editar)
      $submitLabel → texto del botón
      $noticia     → modelo Noticia al editar, o null al crear
--}}
@php $noticia = $noticia ?? null; @endphp
<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

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
                <input class="form-control" type="date" name="fechapubli" id="fechapubli"
                    value="{{ old('fechapubli', optional($noticia)->fechapubli ?? date('Y-m-d')) }}">
                <x-input-error :messages="$errors->get('fechapubli')" class="mt-2" />
            </div>
        </div>
    </div>

    <div class="row mg-b-25">
        <div class="col-lg-10">
            <div class="form-group">
                <label class="form-control-label" for="titulo">Titulo: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="titulo" id="titulo" maxlength="200"
                    value="{{ old('titulo', optional($noticia)->titulo) }}" placeholder="Nombre">
                <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-control-label" for="iduser">ID USUARIO: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="iduser" id="iduser"
                    value="{{ old('iduser', optional($noticia)->iduser ?? Auth::user()->id) }}" readonly>
                <x-input-error :messages="$errors->get('iduser')" class="mt-2" />
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <label class="form-control-label" for="descripcioncorta">DESCRIPCION CORTA <span class="tx-danger">*</span></label>
            <textarea name="descripcioncorta" id="descripcioncorta" class="form-control" maxlength="200">{{ old('descripcioncorta', optional($noticia)->descripcioncorta) }}</textarea>
            <x-input-error :messages="$errors->get('descripcioncorta')" class="mt-2" />
            <br>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <label class="form-control-label" for="mysummernote">CONTENIDO: <span class="tx-danger">*</span></label>
            <textarea rows="16" class="form-control is-valid mg-t-20" name="contenido" id="mysummernote" placeholder="Contenido">{{ old('contenido', optional($noticia)->contenido) }}</textarea>
            <x-input-error :messages="$errors->get('contenido')" class="mt-2" />
        </div>
    </div>

    <br>
    <h6 class="br-section-label">Imágenes</h6>
    <div class="row">
        @foreach ([1, 2, 3] as $n)
            @php
                $imgVal = optional($noticia)->{'img'.$n};
                $imgUrl = $imgVal ? asset('img/noticias/'.$imgVal) : '';
            @endphp
            <div class="col-md-4 mb-4 img-field">
                <label class="form-control-label" for="inputGroupFile{{ $n }}">IMAGEN {{ $n }}: @if ($n === 1)<span class="tx-danger">*</span>@endif</label>
                <div class="custom-file mb-3">
                    <input type="file" class="custom-file-input" id="inputGroupFile{{ $n }}" name="img{{ $n }}"
                        accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp">
                    <label class="custom-file-label" for="inputGroupFile{{ $n }}" data-browse="Examinar">Seleccionar imagen</label>
                </div>
                @if ($n === 1)
                    <x-input-error :messages="$errors->get('img1')" class="mt-2" />
                @endif
                <div class="border rounded-lg text-center p-3 preview-box">
                    <div class="preview-empty" id="empty{{ $n }}" @if ($imgUrl) style="display:none;" @endif>
                        <i class="far fa-image preview-icon"></i>
                        <div class="preview-hint">Vista previa</div>
                    </div>
                    <img src="{{ $imgUrl }}" data-original="{{ $imgUrl }}" class="preview-img" id="preview{{ $n }}" @if (!$imgUrl) style="display:none;" @endif />
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger mt-2 clear-img" style="display:none;"
                    data-input="inputGroupFile{{ $n }}" data-preview="preview{{ $n }}">
                    <i class="far fa-trash-alt"></i> Quitar imagen
                </button>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col">
            <button class="btn btn-info">{{ $submitLabel }}</button>
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
        .preview-hint { font-size: 13px; margin-top: 8px; letter-spacing: .3px; }
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
            var $col = $(this).closest('.img-field');
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
            $(this).closest('.img-field').find('.custom-file-input').click();
        });

        // Quitar la imagen seleccionada (vuelve a la original si existe, o al estado vacío)
        $('.clear-img').on('click', function () {
            var $col = $(this).closest('.img-field');
            var $input = $('#' + $(this).data('input'));
            var $preview = $col.find('.preview-img');
            var original = $preview.data('original');
            $input.val('');
            if (original) {
                $preview.attr('src', original).show();
                $col.find('.preview-empty').hide();
            } else {
                $preview.attr('src', '').hide();
                $col.find('.preview-empty').show();
            }
            $input.siblings('.custom-file-label').removeClass('selected').text('Seleccionar imagen');
            $(this).hide();
        });
    </script>
@endpush

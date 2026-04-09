    <!-- LARGE MODAL -->
    <div id="modalpopup" class="modal fade">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">{{$popup->titulopopup}}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <?php $estado=false; ?>
                        @foreach($imagenes as $row)
                          <div class="carousel-item {{ $estado==false ? 'active' : '' }}"
                               data-img-url="{{ asset('img/popup/'.$row->imagen) }}">
                            <img class="d-block w-100" src="{{asset('img/popup/'.$row->imagen)}}" alt="First slide">
                          </div>
                        <?php $estado = true ?>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                </div>
            </div><!-- modal-body -->
            <div class="modal-footer">
                <a id="btn-ver-imagen"
                   href="{{ asset('img/popup/' . $imagenes->first()?->imagen) }}"
                   target="_blank"
                   class="btn btn-primary tx-size-xs d-inline-flex align-items-center" style="gap:6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         viewBox="0 0 24 24" style="flex-shrink:0;">
                        <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/>
                    </svg>
                    Ver imagen completa
                </a>
                <button type="button" class="btn btn-secondary tx-size-xs" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <script>
        (function () {
            var carousel = document.getElementById('carouselExampleIndicators');
            var btnVer   = document.getElementById('btn-ver-imagen');
            if (!carousel || !btnVer) return;

            carousel.addEventListener('slid.bs.carousel', function (e) {
                var activeItem = carousel.querySelector('.carousel-item.active');
                if (activeItem && activeItem.dataset.imgUrl) {
                    btnVer.href = activeItem.dataset.imgUrl;
                }
            });
        })();
    </script>

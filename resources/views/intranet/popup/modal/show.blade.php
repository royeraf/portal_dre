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
                <?= $popup->contenido ?>
                <?php 
                $image_path = public_path('img/popup/').$popup->imagen; 
                if (file_exists($image_path)){  ?>    
                    <img src="{{asset('img/popup/'.$popup->imagen)}}" class="img-fluid img-thumbnail" />
                <?php } ?>
            </div><!-- modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary tx-size-xs" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->
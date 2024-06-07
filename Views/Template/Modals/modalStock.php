<!-- Modal -->

<div class="modal fade" id="modalFormStock" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Stock</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formStock" name="formStock" class="form-horizontal">
              <input type="hidden" id="idStock" name="idStock" value="" >
             <input type="hidden" id="idProducto" name="idProducto" value=<?= $data['producto'];?>>

              <p class="text-primary">Todos los campos son obligatorios.</p>

              <div class="form-row">
               
                 <div class="form-group col-md-6">
                    <label for="listTalleid">Talle</label>
                    <select class="form-control" data-live-search="true" id="listTalleid" name="listTalleid" required >
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="listColorid">Color</label>
                    <select class="form-control" data-live-search="true" id="listColorid" name="listColorid" required >
                    </select>
                </div>
             <div class="form-group col-md-6">
                  <label for="txtCantidad">Stock</label>
                  <input type="number" class="form-control" id="txtCantidad" name="txtCantidad" required="">
                </div>
                 <div class="form-group col-md-6">
                  <label for="fotoreferencia">Foto de referencia</label>
                  <input type="number" class="form-control" id="fotoreferencia" name="fotoreferencia" required="">
                </div>
             </div>
        
              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

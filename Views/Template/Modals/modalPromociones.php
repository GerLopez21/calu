
<!-- Modal -->

<div class="modal fade" id="modalFormPromociones" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva Promoción</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formPromociones" name="formPromociones" class="form-horizontal">
              <input type="hidden" id="idpromocion" name="idpromocion" value="">
              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
              <div class="row">
                <div class="col-md-12">
                    
                    <div class="form-group">
                      <label for="listCategoria">Categorías para promoción </label>
                            <select class="form-control" data-live-search="true" id="listCategoria" name="listCategoria[]" multiple></select>
                    </div>
                     <div class="form-group">
                      <label for="listProductos">Productos para promoción </label>
                            <select class="form-control" data-live-search="true" id="listProductos" name="listProductos[]" multiple></select>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Estado <span class="required">*</span></label>
                        <select class="form-control selectpicker" id="listStatus" name="listStatus" required="">
                          <option value="1">Activo</option>
                          <option value="2">Inactivo</option>
                        </select>
                    </div>  
                       <div class="form-group">
                        <label for="exampleSelect1">Tipos de Promocion <span class="required">*</span></label>
                        <select class="form-control selectpicker" id="listTipoPromocion" name="listTipoPromocion" required="">
                          <option value="0">-</option>
                          <option value="1">2x1</option>
                          <option value="2">3x2</option>
                          <option value="3">4x3</option>
                          <option value="4">4x2</option>

                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="exampleSelect1">Combinable dentro de categoria </label>
                        <select class="form-control selectpicker" id="listCombinableCat" name="listCombinableCat" >
                          <option value="1">Activo</option>
                          <option value="2">Inactivo</option>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="exampleSelect1">Combinable variado</label>
                        <select class="form-control selectpicker" id="listCombinableVariado" name="listCombinableVariado">
                          <option value="1">Activo</option>
                          <option value="2">Inactivo</option>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="exampleSelect1">Aplicabilidad</label>
                        <select class="form-control selectpicker" id="listAplicabilidad" name="listAplicabilidad">
                          <option value="1">Sobre promedio de los productos</option>
                          <option value="2">Sobre producto menor valor</option>
                          <option value="3">Sobre producto mayor valor</option>

                        </select>
                    </div> 
                  <div id="divMontoFijo" class="form-group notblock">
                        <label class="control-label">Monto fijo de Promocion</label>
                      <input class="form-control" id="txtMontoFijo" name="txtMontoFijo" type="number" >
                  </div>
                     <div id="divPorcPromocion" class="form-group notblock">
                        <label class="control-label">Porcentaje de Promocion</label>
                      <input class="form-control" id="txtPorcentajePromocion" name="txtPorcentajePromocion" type="number" >
                  </div>
                     
                </div>
                  <div class="col-md-12">
                  <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Límite mínimo compra</label>
                      <input class="form-control" id="txtMinCompra" name="txtMinCompra" type="number">
                        </div>
                        <div class="form-group col-md-6">
                           <label class="control-label">Limite mínimo productos</label>
                        <input class="form-control" id="txtMinProductos" name="txtMinProductos" type="number" >
                        </div>
                    </div>
            
                    <div class="row">
                        <div class="form-group col-md-6">
                           <label class="control-label">Limite stock promoción</label>
                      <input class="form-control" id="txtStockPromo" name="txtStockPromo" type="number" >
                        </div>
                        <div class="form-group col-md-6">
                           <label class="control-label">Limite tipo pago</label>
                      <input class="form-control" id="txtTipoPago" name="txtTipoPago" type="number" >
                        </div>
                    </div>
            
                    <div class="row">
                        <div class="form-group col-md-6">
                         <label class="control-label">Limite fecha inicio</label>
                        <input type="date" name="txtFechaInicio" id="txtFechaInicio" class="form-control" >
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label datepicker">Limite fecha fin</label>
                            <input type="date" name="txtFechaFin" id="txtFechaFin" class="form-control" >
                        </div>
                    </div>

                  
                </div>
                                  <div class="col-md-12">

             <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>
              </div>
         
            </form>
      </div>
    </div>
  </div>
</div>
</div>
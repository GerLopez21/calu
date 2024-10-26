<!-- Modal -->
<div class="modal fade" id="modalFormPedido" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header headerUpdate">
        <h5 class="modal-title" id="titleModal">Actualizar Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formUpdatePedido" name="formUpdatePedido" class="form-horizontal">
              <input type="hidden" id="idpedido" name="idpedido" value="<?= $data['orden']['idpedido'] ?>" required="">
              <table class="table table-bordered">
                  <tbody>
                      <tr>
                          <td width="210">No. Pedido</td>
                          <td><?= $data['orden']['idpedido'] ?></td>
                      </tr>
                    
                      <tr>
                          <td>Importe total:</td>
                          <td><?= SMONEY.' '.$data['orden']['monto'] ?></td>
                      </tr>
                      <tr>
                          <td>Direccion:</td>
                          <td>
                            <input type="text" name="txtDireccion" id="txtDireccion" class="form-control" value="<?= $data['orden']['direccion_envio'] ?>" >
                        
                          </td>
                      </tr>
                      <tr>
                          <td>Ciudad:</td>
                          <td><?= $data['orden']['ciudad_cliente'] ?></td>

                      </tr>
                      <tr>
                          <td> Telefono:</td>
                          <td>
                            <input type="tel" name="txtTelefono" id="txtTelefono" class="form-control" value="<?= $data['orden']['telefono_cliente'] ?>" required="">
                        
                          </td>
                      </tr>
                        <tr>
                          <td> Email:</td>
                          <td>
                            <input type="tel" name="txtEmail" id="txtEmail" class="form-control" value="<?= $data['orden']['email_cliente'] ?>" required="">
                        
                          </td>
                      </tr>
                      <tr>
                          <td>Documento:</td>
                          <td><?= $data['orden']['dni_cliente'] ?></td>

                      </tr>
                       <tr>
                          <td>Código seguimiento:</td>
                           <td>
                            <input type="text" name="txtSeguimiento" id="txtSeguimiento" class="form-control" value="<?= $data['orden']['cod_seguimiento'] ?>">
                        
                          </td>

                      </tr>
                       <tr>
                          <td>Fecha retiro:</td>
                                <td>
                            <input type="date" name="txtRetiro" id="txtRetiro" class="form-control" value="<?= $data['orden']['fecha_retiro'] ?>">
                        
                          </td>

                      </tr>
                    
                      <tr>
                          <td>Sucursal:</td>
                          <td>
                              <select name="listSucursal" id="listSucursal" class="form-control selectpicker" data-live-search="true" required="">
                                  <?php 
                                    for ($i=0; $i < count(SUCURSALES) ; $i++) {
                                        $selected = "";
                                        if( SUCURSALES[$i] == $data['orden']['sucursal']){
                                            $selected = " selected ";
                                        }

                                   ?>
                                   <option value="<?= SUCURSALES[$i] ?>" <?= $selected ?> ><?= SUCURSALES[$i] ?></option>
                               <?php } ?>
                              </select>
                          </td>
                      </tr>
                
                      <tr>
                          <td>Envio:</td>
                          <td>
                              <select name="listEnvio" id="listEnvio" class="form-control selectpicker" data-live-search="true" required="">
                                  <?php 
                                    for ($i=0; $i < count(TIPO_ENVIO) ; $i++) {
                                        $selected = "";
                                        if( TIPO_ENVIO[$i] == $data['orden']['tipo_envio']){
                                            $selected = " selected ";
                                        }

                                   ?>
                                   <option value="<?= TIPO_ENVIO[$i] ?>" <?= $selected ?> ><?= TIPO_ENVIO[$i] ?></option>
                               <?php } ?>
                              </select>
                          </td>
                      </tr>
                      <tr>
                          <td>Tipo de pago:</td>
                          <td>
                              <select name="listPago" id="listPago" class="form-control selectpicker" data-live-search="true" required="">
                                  <?php 
                                    for ($i=0; $i < count(TIPO_PAGO) ; $i++) {
                                        $selected = "";
                                        if( TIPO_PAGO[$i] == $data['orden']['tipopago']){
                                            $selected = " selected ";
                                        }

                                   ?>
                                   <option value="<?= TIPO_PAGO[$i] ?>" <?= $selected ?> ><?= TIPO_PAGO[$i] ?></option>
                               <?php } ?>
                              </select>
                          </td>
                      </tr>
                     
                      <tr>
                          <td>Estado:</td>
                          <td>
                              <select name="listEstado" id="listEstado" class="form-control selectpicker" data-live-search="true" required="">
                                  <?php 
                                    for ($i=0; $i < count(STATUS) ; $i++) {
                                        $selected = "";
                                        if( STATUS[$i] == $data['orden']['status']){
                                            $selected = " selected ";
                                        }
                                   ?>
                                   <option value="<?= STATUS[$i] ?>" <?= $selected ?> ><?= STATUS[$i] ?></option>
                               <?php } ?>
                              </select>
                          </td>
                      </tr>
                      <?php 
                        for ($j=0; $j < count($data['detalle']);$j++){?>
                      <tr>
                        
                          <td>Producto</td>
                          <td><?=$data['detalle'][$j]['cantidad']." ".$data['detalle'][$j]['producto'] ?></td>
                         
                        </tr>
                        <?php }?>
                  </tbody>
              </table>
              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-info" type="submit" ><i class="fa fa-fw fa-lg fa-check-circle"></i><span>Actualizar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
            </div>
              
            </form>
      </div>
    </div>
  </div>
</div>
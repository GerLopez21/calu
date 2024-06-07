<?php headerAdmin($data);
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-file-text-o"></i> <?= $data['page_title'] ?></h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?= base_url(); ?>/pedidos"> Pedidos</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <?php
          if(empty($data['arrPedido'])){
        ?>
        <p>Datos no encontrados</p>
        <?php }else{
            $orden = $data['arrPedido']['orden'];
            $detalle = $data['arrPedido']['detalle'];
         ?>
        <section id="sPedido" class="invoice">
          <div class="row mb-4">
            <div class="col-6">

              <h2 class="page-header"><img src="<?= media(); ?>/tienda/images/calu.png" height="100px" ></h2>
            </div>
            <div class="col-6">
              <h5 class="text-right">Fecha: <?= $orden['fecha'] ?></h5>
            </div>
          </div>
          <div class="row invoice-info">
           
          
            <div class="col-4"><b>Orden #<?= $orden['idpedido'] ?></b><br> 
                <b>Pago: </b><?= $orden['tipopago'] ?><br>
                <b>Estado:</b> <?= $orden['status'] ?> <br>
                <b>Monto:</b> <?= SMONEY.' '. formatMoney($orden['monto']) ?><br>
                <b>Nombre:</b> <?= $orden['nombre_cliente'] ?><br>
                <b>Email:</b> <?= $orden['email_cliente'] ?>

            </div>
          </div>
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Descripción</th>
                    <th class="text-right">Precio</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-right">Importe</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                        $subtotal = 0;
                        if(count($detalle) > 0){
                            foreach ($detalle as $producto) {
                                if($producto['preciodescuento'] > 0){
                                $subtotal += $producto['cantidad'] * $producto['preciodescuento'];
                                }else{
                                $subtotal += $producto['cantidad'] * $producto['precio'];

                                }
                     ?>
                  <tr>
                    <td><?= $producto['producto']." - ".$producto['talle']." - ".$producto['color'] ?></td>
                    <?php  if($producto['preciodescuento'] > 0){ ?>

                    <td class="text-right"><?= SMONEY.' '. formatMoney($producto['preciodescuento']) ?></td>
                    <?php }else{ ?>
                   <td class="text-right"><?= SMONEY.' '. formatMoney($producto['precio']) ?></td>
                    <?php } ?>
                    <td class="text-center"><?= $producto['cantidad'] ?></td>
                    <?php  if($producto['preciodescuento'] > 0){ ?>

                    <td class="text-right"><?= SMONEY.' '. formatMoney($producto['cantidad'] * $producto['preciodescuento']) ?></td>
                    <?php }else{ ?>
                    <td class="text-right"><?= SMONEY.' '. formatMoney($producto['cantidad'] * $producto['precio']) ?></td>
                    <?php } ?>
                  </tr>
                  <?php 
                            }
                        }
                   ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Sub-Total:</th>
                        <td class="text-right"><?= SMONEY.' '. formatMoney($subtotal) ?></td>
                    </tr>
                    <!-- <tr>
                        <th colspan="3" class="text-right">Envío:</th>
                        <td class="text-right">?= SMONEY.' '. formatMoney($orden['costo_envio']) ?></td>
                    </tr> -->
                    <tr>
                        <th colspan="3" class="text-right">Total:</th>
                        <td class="text-right"><?= SMONEY.' '. formatMoney($orden['monto']) ?></td>
                    </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="row d-print-none mt-2">
            <div class="col-12 text-right"><a class="btn btn-primary" href="javascript:window.print('#sPedido');" ><i class="fa fa-print"></i> Imprimir</a></div>
          </div>
        </section>
        <?php } ?>
      </div>
    </div>
  </div>
</main>
<?php footerAdmin($data); ?>
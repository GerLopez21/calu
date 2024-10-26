<?php 
headerTienda($data);


// SDK de Mercado Pago
require './vendor/autoload.php';
$productos="";
$subtotal = 0;
$total = 0;
foreach ($_SESSION['arrCarrito'] as $producto) {
    if($producto['preciodescuento'] > 0){
        	$subtotal += $producto['preciodescuento'] * $producto['cantidad'];

    }else{
                	$subtotal += $producto['precio'] * $producto['cantidad'];

    }
	$productos = $producto['producto']."".$productos;
}
if($data['tipoenvio'] == 1){
    $envio = 'Retiro centro ($0.00)';
    $total = $subtotal;
}
if($data['tipoenvio'] == 2){
    $envio = 'Envio domicilio (Se informará monto al finalizar compra)';
    $total = $subtotal;
}
if($data['tipoenvio'] == 3){
    $envio = 'Envio correo (Se informorá monto al finalizar compra)';
    $total = $subtotal;
}
if($data['tipoenvio'] == 4){
    $envio = 'Retiro local ($0.00)';
    $total = $subtotal;
}
$total = $subtotal;


// Agrega credenciales
try {
	MercadoPago\SDK::setAccessToken($ACCESS_TOKEN);
	$preference = new MercadoPago\Preference();
$item = new MercadoPago\Item();
$item->id = $producto['idproducto'];
$item->title =  $productos;
$item->description = $producto['producto'];
$item->quantity = $producto['cantidad'];
$item->unit_price = $total;
$preference->items = array($item);
$preference->save();

    
}catch(Throwable $e){
	print_r($e);die();
	}


?>


<script
	src="https://sdk.mercadopago.com/js/v2">
</script>


<!-- Modal -->
<div class="modal fade" id="modalTerminos" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= $tituloTerminos ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        	<div class="page-content">
        		<?= $infoTerminos  ?>
        	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

 <br><br><br>
<hr>
	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="<?= base_url() ?>" class="stext-109 cl8 hov-cl1 trans-04">
				Inicio
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>
			<span class="stext-109 cl4">
				<?= $data['page_title'] ?>
			</span>
		</div>
	</div>
	<br>
	
	<div class="container">
	
		<div class="row">
		<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
				<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-l-25 m-r--38 m-lr-0-xl">
					<div>
					<h3>SELECCIONE EL TIPO DE PAGO</h3>
					<br>
					
						<div>
									<label  class="span-check-transferencia" >
									    <span style="font-family:Poppins-Medium; font-size:14px; text-align: center;"><b><input style="display:inline;" type="checkbox" class="opcionPago"  id="transferencia" name="transferencia" value="Transferencia bancaria">&nbspTRANSFERENCIA BANCARIA</b></span>
										<br>
										<span style="font-family:Poppins-Medium;display:flex;cursor:pointer;">
										    Al finalizar la compra podrás visualizar los datos de la cuenta bancaria a la que 
											debes realizar la transferencia
                                            </span>
                                            
									 

									</label>
								</div>

									<div>
								    	<label  class="span-check-acordar" >
									    <span style="font-family:Poppins-Medium; font-size:14px; text-align: center;"><b><input style="display:inline;" type="checkbox" class="opcionPago"  id="acordar" name="acordar" value="Acordar pago">&nbspACORDAR PAGO</b></span>
										<br>
										<span style="font-family:Poppins-Medium;display:flex;cursor:pointer;">
										    Al finalizar la compra nos pondremos en contacto con vos para coordinar tu pago, en este caso contas con la posibilidad de abonar a través de efectivo (SOLO VÁLIDO EN CASO
										    DE TIPO DE ENVIO RETIRO EN EL SHOWROOM Y ENVÍO A DOMICILIO DE GRAN MENDOZA O ZONA ESTE) y también tenes la posibilidad que te enviemos un link de pago para abonar con tarjeta de crédito (con recargo)
                                            </span>
                                            
									 

									</label>
									
								</div>


								<!-- <div class="cho-container">
									<label>
									<h3>Mercado  Pago    <img src="<?= media()?>/images/iso-mercadopago.png" alt="Icono de Mercado Pago" class="ml-space-sm" width="64" height="40"></h3>


											<script>
											  const mp = new MercadoPago('TEST-bfccbc2e-a952-492a-9d54-746e44af8e92', {
											    locale: 'es-AR'
											  });
										  
											  mp.checkout({
											    preference: {
											      id: '?php echo $preference->id;?>'
											    },
											    render: {
											      container: '.cho-container',
											      label: 'Pagar',
											    }
											  });
											</script>
									</label>
											
								</div> -->
					
					</div>
				</div> 
			</div>
			<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
				<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
					<h4 class="mtext-109 cl2 p-b-30">
						Resumen
					</h4>

					<div class="flex-w flex-t bor12 p-b-13">
						<div class="size-208">
							<span class="stext-110 cl2">
								Subtotal:
							</span>
						</div>

						<div class="size-209">
							<span id="subTotalCompra" class="mtext-110 cl2">
								<?= SMONEY.formatMoney($subtotal) ?>
							</span>
						</div>

						<div class="size-208">
							<span class="stext-110 cl2">
								Envío:
							</span>
						</div>

						<div class="size-209">
							<span class="stext-110 cl2">
								<?= $envio ?>
							</span>
						</div>
					</div>
					<div class="flex-w flex-t p-t-27 p-b-33">
						<div class="size-208">
							<span class="mtext-101 cl2">
								Total:
							</span>
						</div>

						<div class="size-209 p-t-1">
							<span id="totalCompra" class="mtext-110 cl2">
								<?= SMONEY.formatMoney($total) ?>
							</span>
						</div>
					</div>
					<hr>
					<div id="divConfirmarPago" class="notblock">
					<button type="submit" id="btnComprar" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">Confirmar pedido</button>
							
											</div>
	</div>
				</div>
			</div>
			

			
	</div>
</div>
<?php 
	footerTienda($data);
 ?>
	
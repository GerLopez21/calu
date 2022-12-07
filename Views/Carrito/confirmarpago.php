<?php 
headerTienda($data);

// SDK de Mercado Pago
require './vendor/autoload.php';
$productos="";
$subtotal = 0;
$total = 0;
foreach ($_SESSION['arrCarrito'] as $producto) {
	$subtotal += $producto['precio'] * $producto['cantidad'];
	//$arrProductos=array();
	//array_push($arrProductos,$producto['producto']);
	$productos = $producto['producto']."".$productos;
}
$total = $subtotal + COSTOENVIO;
$ACCESS_TOKEN='TEST-920054571392136-111417-c144e04d1b1c4a75bc8941d7b7aa2219-213297333';

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
									<label >
										<input type="radio" checked="" class="opcionPago" id="transferencia" name="transferencia" value="transferencia">
										<i class="zmdi zmdi-balance"></i>

										<span><b>Transferencia bancaria</b></span><br>
										<span>Al finalizar la compra podrás visualizar los datos de la cuenta bancaria a la que 
											debes realizar la transferencia
										</span>

									</label>
								</div>
								<b>-------------------------------------</b>
								<div>
									<label>
										<input type="radio" id="acordar" class="opcionPago" name="acordar" value="acordar">
										<i class="zmdi zmdi-comments"></i>
										<span><b>Acordar metodo de pago</b></span><br>
										<span>Al finalizar la compra nos pondremos en contacto con vos para coordinar tu pago</span>
									</label>
								</div>
								<b>-------------------------------------</b>
								<div class="cho-container">
									<label>
									<h3>Mercado  Pago    <img src="<?= media()?>/images/iso-mercadopago.png" alt="Icono de Mercado Pago" class="ml-space-sm" width="64" height="40"></h3>


											<script>
											  const mp = new MercadoPago('TEST-bfccbc2e-a952-492a-9d54-746e44af8e92', {
											    locale: 'es-AR'
											  });
										  
											  mp.checkout({
											    preference: {
											      id: '<?php echo $preference->id;?>'
											    },
											    render: {
											      container: '.cho-container',
											      label: 'Pagar',
											    }
											  });
											</script>
									</label>
											
								</div>
					
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
							<span class="mtext-110 cl2">
								<?= SMONEY.formatMoney(COSTOENVIO) ?>
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
					<button type="submit" id="btnComprar" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">Procesar pedido</button>
							
											</div>
	</div>
				</div>
			</div>
			

			
	</div>
</div>
<?php 
	footerTienda($data);
 ?>
	
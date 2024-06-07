<?php 
headerTienda($data);
$subtotal = 0;
$productos=null;
foreach ($data['productos'] as $producto) {
     if($producto['preciodescuento'] > 0){
        	$subtotal += $producto['preciodescuento'] * $producto['cantidad'];

    }else{
                	$subtotal += $producto['precio'] * $producto['cantidad'];

    }
	//$arrProductos=array();
	//array_push($arrProductos,$producto['producto']);
	$productos = $producto['producto']."".$productos;
}

?>


<!-- Modal -->


 <br><br><br>
<hr>
	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="<?= base_url() ?>" class="stext-109 cl8 hov-cl1 trans-04">
				
			</a>
			<span class="stext-109 cl4">
				Orden: <?= $data['orden'] ?>
			</span>
		</div>
	</div>
	<br>
	
	<div class="container">
	
		<div class="row">
		<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
				<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-l-25 m-r--38 m-lr-0-xl">
					<div>
					<h3>CALU MENDOZA STORE</h3>
					<br>
					
								<div>
								
									<label>
										<span><b> <i class="zmdi zmdi-hc-4x zmdi-time-interval pr-xl-5"></i>En espera de pago</b></span><br>
										<br>
										<div class="pl-10">
										<span>¡Hola! ¿Cómo estás?</span><br>
										<span><strong>Podés hacer transferencia o depósito a la siguiente cuenta: </strong></span><br>
										<span>Banco PATAGONIA </span><br>
										<span>Tipo y número de cuenta: Cuentas en Pesos 060-600049057-000</span><br>
										<span>Número de CBU: 0340060908600049057005 </span><br>
										<span> Alias de CBU: ABACO.TRINEO.JALEA <br>(IMPORTANTE: ABACO sin acento)</span><br>
										<span>Titular de la cuenta: Eyub Zacaria, Maria Lucia  </span><br>
										<span>Tipo y número de documento: DNI -40104719- </span><br>
										<span>¡Gracias por tu compra!  </span><br>
										<span>IMPORTANTE: Enviar comprobante de pago una vez abonado el pedido al correo calumendozastore@gmail.com, coloca tu nombre completo y tu número de compra! 
                                        Tenes 24hs para realizar el pago,  de lo contrario se cancela la compra. </span>    
                                        </div>
									</label>
								</div>
								<b>-------------------------------------</b>
								<div> 
										<span><b> <i class="zmdi zmdi-hc-4x zmdi-truck pr-xl-5 p-b-10"></i>Destino:</b> <?= $data['direccion']?></span><br>

						
								</div>
								<b>-------------------------------------</b>
								<div>
										<span><b> <i class="zmdi zmdi-hc-4x zmdi-check-square pr-xl-5 p-b-10"></i>Estado del pedido:</b> <?= $data['status']?></span><br>

									<label>
									    <br><br>
                                        <span><b>¿Necesitás ayuda?Comunicate con nosotros </b></span><br>

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
											      id: '<?php echo $preference->id;?>'
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
	<div class="col-12 col-md-4">
				<div class="summary-details summary-panel p-none">
				  <!--  <h4 class="mtext-109 cl2 p-b-30">
						Resumen
					</h4>-->
				    <table class="table table-scrollable">
				        <tbody>
				            <?php
                        foreach($data['productos'] as $producto){?>
				            <tr>
				                <td class="summary-img-wrap">
				                    <div class="summary-img">
				                        <div class="summary-img-thumb">
                            				 <div class="size-208"><img src="<?=$producto['imagen'] ?>" alt="<?= $producto['producto'] ?>" height="60px"></div>

				                        </div>
				                    </div>
				                </td>
				                <td>
				                    	<div class="stext-110"><?= $producto['producto']." - ".$producto['nombretalle']." - ".$producto['nombrecolor']." x ".$producto['cantidad'] ?></div>

				                </td>
				                <?php if($producto['preciodescuento'] > 0){ ?>
				                     <td class="table-price text-right" width="150px">
                                        <span class=" stext-110 cl2"><?=SMONEY.formatMoney($producto['preciodescuento'])?></span>
				                </td>
				               <?php }else{ ?>
				                <td class="table-price text-right" width="150px">
                                        <span class=" stext-110 cl2"><?=SMONEY.formatMoney($producto['precio'])?></span>
				                </td>
				              <?php  } ?>
				                
				            </tr>
				            <?php } ?>
				        </tbody>
				    </table>
					
			    <div class="table-subtotal">
			        <table class="table">
			            <tbody>
			                <tr>
			                    <td class="stext-110">Subtotal:</td>
			                    <td class="text-right stext-110 cl2"><?= SMONEY.formatMoney($subtotal) ?></td>
			                    
			                </tr>
			                <tr>
			                    <td class="mtext-101">Total:</td>
			                    <td class="text-right mtext-101 cl2"><?= SMONEY.formatMoney($subtotal) ?></td>
			                    
			                </tr>
			            </tbody>
			        </table>
			    </div>

					
				
					<hr>
				
	</div>
				</div>	
			</div>
			

			
	</div>

<?php 
	footerTienda($data);
 ?>
	
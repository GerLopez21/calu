<?php 
headerTienda($data);
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
		<div class="col-12 col-md-8">
				
		 
					<div class="status panel">
                                        <?php 
									    if($data['status'] == "Realizado"){?>
								<div class="status-icon">
								    <i class="zmdi zmdi-hc-3x zmdi-time"></i>
								</div>
								
								<?php if($data['tipoenvio'] == "Envio domicilio" || $data['tipoenvio'] == "Envio correo"){?>
								<div class="status-content">
								    
								    Estamos a la espera del pago, en cuanto este se confirme, tu pedido será remitido
						
								</div>   
								<?php } ?>
									<?php if($data['tipoenvio'] == "Retiro Centro" || $data['tipoenvio'] == "Retiro showroom"){?>
								<div class="status-content">
								    
								    Estamos a la espera del pago, en cuanto este se confirme, te avisaremos cuando podrás retirar tu pedido
						
								</div>   
								<?php } ?>
									    <?php } ?>	
					     <?php 
									    if($data['status'] == "Confirmado"){?>
								<div class="status-icon">
								    <i class="zmdi zmdi-hc-3x zmdi-truck" style="color:red"></i>
								</div>
									<?php if($data['tipoenvio'] == "Retiro Centro" || $data['tipoenvio'] == "Retiro showroom"){?>

								<div class="status-content">
								    
								    ¡Tu pedido está en camino al punto de retiro!    
						
								</div>   
									<?php } ?>
								<?php if($data['tipoenvio'] == "Envio domicilio" || $data['tipoenvio'] == "Envio correo"){?>

								<div class="status-content">
								    
								    ¡Tu pedido ya está en camino al punto de retiro!    
						
								</div>   
									<?php } ?>
									    <?php } ?>
								<?php	    if($data['status'] == "Completo"){?>
								<div class="status-icon">
								    <i class="zmdi zmdi-hc-3x zmdi-check" style="color:green"></i>
								</div>
									<?php if($data['tipoenvio'] == "Retiro Centro" || $data['tipoenvio'] == "Retiro showroom"){?>

								<div class="status-content">
								    
								    ¡Tu pedido está listo para ser retirado!    
						
								</div>   
									<?php } ?>
								<?php if($data['tipoenvio'] == "Envio correo"){?>

								<div class="status-content">
								    
								    ¡Tu pedido está en camino al punto de retiro!  
						
								</div>   
									<?php } ?>
									<?php if($data['tipoenvio'] == "Envio domicilio"){?>

								<div class="status-content">
								    
								    ¡Tu pedido ya fue entregado!    
						
								</div>   
									<?php } ?>
									    <?php } ?>
									    	 <?php   if($data['status'] == "Entregado"){?>
								<div class="status-icon">
								    <i class="zmdi zmdi-hc-3x zmdi-truck" style="color:green"></i>
								</div>
									<?php if($data['tipoenvio'] == "Retiro Centro" || $data['tipoenvio'] == "Retiro showroom"){?>

								<div class="status-content">
								    
								    ¡Tu pedido ya fue entregado!    
						
								</div>   
									<?php } ?>
								<?php if($data['tipoenvio'] == "Envio domicilio" || $data['tipoenvio'] == "Envio correo"){?>

								<div class="status-content">
								    
								    ¡Tu pedido ya fue entregado!    
						
								</div>   
									<?php } ?>
									    <?php } ?>
				    </div> 
					<div class="orderstatus panel p-0  m-bottom-none">
                            <div class="destination">
								<div class="destination-icon">
								    <i class="zmdi zmdi-hc-3x zmdi-pin" style="color:blue"></i>
								</div>
								<div class="destination-content">
								    <?php if($data['status'] == "Realizado"){ ?>
								        <h3 class="heading-small m-bottom-quarter m-top-none">En cuanto confirmemos el pago te avisaremos donde y cuando llegará tu pedido</h3> 

								 <?php   }
								 
								    if($data['status'] == "Completo" || $data['status'] == "Confirmado"){ ?>
								        
								    
								    
								    <?php if($data['tipoenvio'] == "Envio correo"){?>
								    <h3 class="heading-small m-bottom-quarter m-top-none">Retirás entre el <?= $data['fecha_retiro']; ?> y el <?= $data['fecha_retiro2']; ?></h3> 
									<h4 class="heading-small m-bottom-quarter m-top-none">Retira tu pedido en:</h4>
									
                                    <p class="m-none">Correo Argentino - Sucursal <?= $data['sucursal']; ?></p>
                                    <ul class="available-hours text-small opacity-80 m-top-quarter m-bottom-none">
                                        <li>Lunes a viernes de 08:00 a 18:00</li>
                                        <li>Sabado de 09:00 a 14:00</li>

                                    </ul>
                                    <?php } ?>
                                       <?php if($data['tipoenvio'] == "Envio domicilio"){?>
								    <h3 class="heading-small m-bottom-quarter m-top-none">Tu pedido llegará entre el <?= $data['fecha_retiro']; ?> y el <?= $data['fecha_retiro2']; ?></h3> 
									<h4 class="heading-small m-bottom-quarter m-top-none">Tu pedido llegará a tu domicilio:</h4>
								
								
                                    <?php } ?>
                                    <?php if($data['tipoenvio'] == "Retiro showroom"){?>
								    <h3 class="heading-small m-bottom-quarter m-top-none">Retirás entre el <?= $data['fecha_retiro']; ?> y el <?= $data['fecha_retiro2']; ?></h3> 
									<h4 class="heading-small m-bottom-quarter m-top-none">Retira tu pedido en:</h4>
									
                                    <p class="m-none">Showroom - Te enviamos la dirección por whatsapp, nos encontramos en Godoy Cruz, Mendoza</p>
                                    <ul class="available-hours text-small opacity-80 m-top-quarter m-bottom-none">
                                        <li>Horario a convenir por whatsapp</li>
                                     

                                    </ul>
                                    <?php } ?>
                                    <?php if($data['tipoenvio'] == "Retiro centro"){?>
								    <h3 class="heading-small m-bottom-quarter m-top-none">Retirás entre el <?= $data['fecha_retiro']; ?> y el <?= $data['fecha_retiro2']; ?></h3> 
									<h4 class="heading-small m-bottom-quarter m-top-none">Retira tu pedido en:</h4>
									
                                    <p class="m-none">Local centro - Almacen Chile - Esquina Chile y San Lorenzo</p>
                                    <ul class="available-hours text-small opacity-80 m-top-quarter m-bottom-none">
                                        <li>Lunes a viernes de 08:00 a 18:00</li>
                                        <li>Sabado de 09:00 a 14:00</li>

                                    </ul>
                                    <?php } ?>
                                    
                                    <?php } ?>
                                    <?php if($data['status'] == "Entregado"){ ?>
                                    		<h3 class="heading-small m-bottom-quarter m-top-none">Tu pedido ya fue retirado!</h3> 

                                    <?php } ?> 
                                    								   

								</div>   
 
					        </div>
				    </div> 
				    	<div class="orderstatus panel p-0">
                            <div class="destination">
								<div class="destination-icon">
								    <i class="zmdi zmdi-hc-3x zmdi-check-circle" style="color:green"></i>
								</div>
								<div class="destination-content">
								    <h3 class="heading-small m-bottom-quarter m-top-none">Pedido realizado</h3>
								    <div class="history-item-data">
								        <span><?= substr($data['fecha_compra'],0,15); ?></span>
								    </div>
								</div>   

					        </div>
					        
					         <div class="destination">

                                    <?php if($data['status'] == 'Confirmado' || $data['status'] == 'Completo' || $data['status'] == 'Entregado'){ ?>

								<div class="destination-icon">
                                            <i class="zmdi zmdi-hc-3x zmdi-check-circle" style="color:green"></i>
	                                </div>
	                                
	                                	<div class="destination-content">
								    <h3 class="heading-small m-bottom-quarter m-top-none">Pago confirmado</h3>
								<div class="history-item-data">
								        <span><?= substr($data['fecha_pago'],0,15); ?></span>
								    </div>
								        </div>   
								   <?php }else{ ?> 
								   								<div class="destination-icon">

								              <i class="zmdi zmdi-hc-2x zmdi-circle-o" ></i>
								              	                                </div>

								              	<div class="destination-content">
								                <h3 class="heading-small m-bottom-quarter m-top-none op">Pago confirmado</h3>
								
								        </div>   
								            <?php } ?>

							
							

					        </div>
					        <div class="destination">
					          <?php if($data['status'] == 'Completo' || $data['status'] == 'Entregado'){ ?>

								<div class="destination-icon">
								    <i class="zmdi zmdi-hc-3x zmdi-check-circle" style="color:green"></i>
								</div>
								<div class="destination-content">

								    <h3 class="heading-small m-bottom-quarter m-top-none">Pedido enviado</h3>
								     <div class="history-item-data">
								        <span><?= substr($data['fecha_envio'],0,15); ?></span>
								    </div>
								    <?php }else{ ?>
								    
								    <div class="destination-icon">
								    <i class="zmdi zmdi-hc-2x zmdi-circle-o"></i>
								</div>
								<div class="destination-content">

								    <h3 class="heading-small m-bottom-quarter m-top-none op">Pedido enviado</h3>
						

								    <?php } ?>
						    <?php if($data['tipoenvio'] == 'Envio domicilio' || $data['tipoenvio'] == 'Envio correo'){ ?>
					          <?php if($data['status'] == 'Completo' || $data['status'] == 'Entregado'){ ?>

								    <div class="history-item-shipping m-top-half">
								        <span class="history-item-shipping-code mtext-110">
                                                Código de seguimiento 	<?= $data['cod_seguimiento']; ?>
								        </span>
								        <a href="https://www.correoargentino.com.ar/formularios/e-commerce?id=<?= $data['cod_seguimiento'];?>" target="_blank" class="btn-ship btn-ship-secondary btn-ship-small">
								            <span class="history-item-shipping-link">Ver seguimiento detallado <b>></b></span>
								        </a>
								    </div>
								    								    <?php } ?>

								    <?php } ?>
								    <div></div>
								
								</div>   

					        </div>
					        
					        <div class="destination">
					         <?php if($data['status'] == 'Entregado'){ ?>

								<div class="destination-icon">
								    <i class="zmdi zmdi-hc-3x zmdi-check-circle" style="color:green"></i>
								</div>
								<div class="destination-content">
								    <h3 class="heading-small m-bottom-quarter m-top-none">Pedido entregado</h3>
								
								</div>   
								   <?php }else{ ?> 
                        	<div class="destination-icon">
								    <i class="zmdi zmdi-hc-2x zmdi-circle-o"></i>
								</div>
								<div class="destination-content">
								    <h3 class="heading-small m-bottom-quarter m-top-none op">Pedido entregado</h3>
								
								</div>
																    <?php } ?>

					        </div>
					        
				    </div> 
	
			</div>
	<div class="col-12 col-md-4">
				<div class="summary-details summary-panel p-none">
				  <!--  <h4 class="mtext-109 cl2 p-b-30">
						Resumen
					</h4>-->
				    <table class="table table-scrollable p-r-0 p-l-0">
				        <tbody>
				            <?php
                        foreach($data['productos'] as $producto){?>
				            <tr>
				                <td class="summary-img-wrap">
				                    <div class="summary-img">
				                        <div class="summary-img-thumb">
                            				 <div class="size-208"><img src="<?=$producto['images']['url_image'] ?>" alt="<?= $producto['producto'] ?>" height="60px" width="65px"></div>

				                        </div>
				                    </div>
				                </td>
				                <td>
				                    	<div class="stext-110"> <?= $producto['producto']." - ".$producto['talle']." - ".$producto['color'] ?></div>

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
	
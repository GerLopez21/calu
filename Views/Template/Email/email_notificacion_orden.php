<?php 

$orden = $data['pedido']['orden'];
$detalle = $data['pedido']['detalle'];
$carrito = $data['datosCarrito'];
$seguimiento = $data['urlSeguimiento'];

 ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Orden</title>
	<style type="text/css">
		p{
			font-family: arial;letter-spacing: 1px;color: #7f7f7f;font-size: 12px;
		}
		hr{border:0; border-top: 1px solid #CCC;}
		h4{font-family: arial; margin: 0;}
		table{width: 100%; max-width: 600px; margin: 10px auto; border: 1px solid #CCC; border-spacing: 0;}
		table tr td, table tr th{padding: 5px 10px;font-family: arial; font-size: 12px;}
		#detalleOrden tr td{border: 1px solid #CCC;}
		.table-active{background-color: #CCC;}
		.text-center{text-align: center;}
		.text-right{text-align: right;}

		@media screen and (max-width: 470px) {
			.logo{width: 90px;}
			p, table tr td, table tr th{font-size: 9px;}
		}
	</style>
</head>
<body>
	<div>
		<br>
		<h2>Gracias por comprar en CALU MENDOZA STORE</h2>

		<p class="text-center">Se ha generado una orden, a continuación encontrarás los datos.</p>
		<br>
		<hr>
		<br>
		<table>
			<tr>
				<td width="33.33%">
					<img class="logo" src="<?= media(); ?>/tienda/images/logo.jpg" height="80px" width="100px" alt="Logo">
				</td>
				<td width="33.33%">
					<div class="text-center">
						<h4><strong><?= NOMBRE_EMPESA ?></strong></h4>
						<p>
							<?= DIRECCION ?> <br>
							Teléfono: <?= TELEMPRESA ?> <br>
							Email: <?= EMAIL_EMPRESA ?>
						</p>
					</div>
				</td>
				<td width="33.33%">
					<div class="text-right">
						<p>
							No. Orden: <strong><?= $orden['idpedido'] ?></strong><br>
                            Fecha: <?= $orden['fecha'] ?> <br>
                        
                            Método Pago: <?= $orden['tipopago'] ?> <br>
						</p>
					</div>
				</td>				
			</tr>
		</table>
		<table>
			<tr>
		    	<td width="140">Nombre:</td>
		    	<td><?= $orden['nombre_cliente'] ?></td>
		    </tr>
		    <tr>
		    	<td>Teléfono</td>
		    	<td><?= $_SESSION['userData']['telefono'] ?></td>
		    </tr>
		   
            <tr>
		    	<td><strong> Datos de envío: </strong></td>
		    </tr>
		    <tr>
		    	<td>Dirección de envío:</td>
		    	<td><?= $orden['direccion_envio']?$orden['direccion_envio']:"-" ?></td>
		    </tr>
		    <tr>
		    	<td>Ciudad:</td>
		    	<td><?= $orden['ciudad_cliente']?$orden['ciudad_cliente']:"-" ?></td>
		    </tr>
		    <tr>
		    	<td>Código:</td>
		    	<td><?= $orden['codigo_postal']?$orden['codigo_postal']:"-" ?></td>
		    </tr>
		    <tr>
		    	<td>País:</td>
		    	<td><?= $orden['pais_cliente']?$orden['pais_cliente']:"-" ?></td>
		    </tr>
		    <tr>
		    	<td>Provincia:</td>
		    	<td><?= $orden['provincia_cliente']?$orden['provincia_cliente']:"-" ?></td>
		    </tr>
		    <tr>
		    	<td>Tipo de envío:</td>
		    	<td><?= $orden['tipoenvio']?$orden['tipoenvio']:"-" ?></td>
		    </tr>
		    <tr>
		    	<td>Seguí el estado de tu pedido desde este link:</td>
		    	<td><?= $seguimiento ?></td>
		    </tr>
		</table>
		<table>
		  <thead class="table-active">
		    <tr>
		      <th>Descripción</th>
		      <th></th>
		      <th class="text-right">Precio</th>
		      <th class="text-center">Cantidad</th>
		      <th class="text-right">Importe</th>
		    </tr>
		  </thead>
		  <tbody id="detalleOrden">
		  	<?php 
		  		if(count($carrito) > 0){
		  			$subtotal = 0;
		  			foreach ($carrito as $producto) {
		  			    if($producto['preciodescuento'] > 0){
                          $precio = formatMoney($producto['preciodescuento']);
		  			    }else{
                          $precio = formatMoney($producto['precio']);
		  			        
		  			    }
		  			     if($producto['preciodescuento'] > 0){
		  				$importe = formatMoney($producto['preciodescuento'] * $producto['cantidad']);
		  			    }else{
                          $precio = formatMoney($producto['precio']);
		  			        
		  			    }
		  			    if($producto['preciodescuento'] > 0){
		  				$subtotal += $producto['preciodescuento'] * $producto['cantidad'];
		  			    }else{
		  				$subtotal += $producto['precio'] * $producto['cantidad'];
		  			        
		  			    }
		  	 ?>
		    <tr>
		      <td><?= $producto['producto']."-".$producto['nombretalle']."-".$producto['nombrecolor'] ?>
		      				
						      <td class="text-right">	<img  src="<?=$producto['imagen']?>" height="20px" alt="Logo"></td></td>

		      <td class="text-right"><?= SMONEY.' '.$precio ?></td>
		      <td class="text-center"><?= $producto['cantidad'] ?></td>
		      <td class="text-right"><?= SMONEY.' '.$importe ?></td>
		    </tr>
			<?php }
				} ?>
		  </tbody>
		  <tfoot>
		  		<tr>
		  			<th colspan="4" class="text-right">Subtotal:</th>
		  			<td class="text-right"><?= SMONEY.' '.$subtotal ?></td>
		  		</tr>
		  		<tr>
		  			<th colspan="4" class="text-right">Envío:</th>
		  			<td class="text-right"><?= SMONEY.' '.formatMoney($orden['costo_envio']) ?></td>
		  		</tr>
		  		<tr>
		  			<th colspan="4" class="text-right">Total:</th>
		  			<td class="text-right"><?= SMONEY.' '.formatMoney($orden['monto']); ?></td>
		  		</tr>
		  </tfoot>
		</table>
		<div class="text-center">
			<p>Si tienes preguntas sobre tu pedido, <br>pongase en contacto con nombre, teléfono y Email</p>
			<h4>¡Gracias por tu compra!</h4>		
			<h4>
			    * * *
Si no hiciste esta compra o simplemente estabas probando nuestro sitio, por favor desconsiderá este e-mail.
			</h4>
		</div>
	</div>									
</body>
</html>
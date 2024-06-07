<?php 
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
		<h2>Hemos cancelado tu orden</h2>

		<p class="text-center">Tu orden ha sido cancelada</p>
		<br>
		<hr>
		<br>
			<table align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="text-align:center;">
		<tbody>
			<tr>
			    <td width="50%">
					<img class="logo" src="<?= media(); ?>/tienda/images/logo.jpg" height="80px" width="100px" alt="Logo">
				</td>
			
			</tr>
			<tr>
				<td class="text-center">
				        <p>Lamentablemente hemos tenido que cancelar tu compra por falta de pago. Cualquier cosa podes volver a hacer tu pedido por la web</p>
                        <br>
                        <p>Muchas gracias!</p>

				    				    


				</td>
			</tr>
		</tbody>
	</table>
		<div class="text-center">
			<p>Si tenes alguna duda, <br>ponete en contacto con nombre, teléfono y Email</p>
		
		</div>
	</div>									
</body>
</html>
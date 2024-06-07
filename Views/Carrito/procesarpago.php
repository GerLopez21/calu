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
	//$arrProductos=array();
	//array_push($arrProductos,$producto['producto']);
	$productos = $producto['producto']."".$productos;
}
$total = $subtotal;
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
<!--Una vez realizada tu compra y ENTREGADA O RETIRADA, la misma NO tiene cambio ni devolucion
NO SE ACEPTAN CAMBIOS DE NINGÚN TIPO
Sólo se aceptan cambios por fallas, las mismas deben ser reportadas inmediatamente (en 24hs) para realizar el cambio.
-->
<!-- Modal -->
<div class="modal fade" id="modalTerminos" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= "Terminos y Condiciones" ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        	<div class="page-content">
        		<?= "TERMINOS Y CONDICIONES: <br>1. Una vez realizada tu compra y ENTREGADA O RETIRADA, la misma NO tiene cambio ni devolución<br>2. NO SE ACEPTAN CAMBIOS DE NINGÚN TIPO
        		<br>3. Sólo se aceptan cambios por fallas, las mismas deben ser reportadas inmediatamente (en 24hs) para realizar el cambio<br>
        		Ante dudas sobre talles o modelos hacer la consulta ANTES de comprar. Se mandan medidas exactas de los modelos para no tener dudas si así se requiere."  ?>
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
					
						<div>
									<label  class="span-check-local" >
										
									<!--	<i class="zmdi zmdi-local-store"></i> -->
                                            

										<span style="font-family:Poppins-Medium; font-size:14px; text-align: center;"><b><input style="display:inline;" type="checkbox" class="opcionEnvio"  id="retirolocal" name="retirolocal" value="Retiro local">&nbspRETIRO EN LOCAL</b></span>
										<br>
										<span style="font-family:Poppins-Medium;display:flex;cursor:pointer;">Una vez realizada tu compra, contáctanos con tu nombre y número de compra, así fijamos día y horario para que pases a retirar por nuestro showroom, estamos en Godoy Cruz a unas cuadras del puente olive. La dirección se envía una vez hecha la compra.
                                            Seleccionando esta opción podes abonar también en EFECTIVO (tenes 24hs para abonar y pasar a retirar, de lo contrario se cancela la compra)

                                            </span>
									</label>
								</div>
								<br>
								<div>
									<label  class="span-check-dcilio">
									    
									<!--	<i class="zmdi zmdi-local-shipping"></i> -->
                            <span style="font-family:Poppins-Medium; font-size:14px; text-align: center;"><b><input style="display:inline;" type="checkbox" class="opcionEnvio" 
                            id="enviodomicilio" name="enviodomicilio" value="Envio domicilio">&nbsp ENVIO A DOMICILIO</b></span>
										<br>										<span style="font-family:Poppins-Medium;display:flex;cursor:pointer;">Los envíos por el Gran Mendoza y Zona este (Junín, San Martín y Rivadavia) se realizan por moto mensajería o cadetería. Una vez concretada la compra envíanos tu nombre y número de compra junto con tu domicilio (ubicación) a donde deseas recibir el pedido. Te lo cotizaremos una vez recibida la ubicación. Los precios varían dependiendo la zona. Desde $1500

										</span>
									</label>
								</div>
                                <br>
                                <div>
									<label class="span-check-centro">
								     <span style="font-family:Poppins-Medium; font-size:14px; text-align: center;"><b><input style="display:inline;" type="checkbox" class="opcionEnvio" 
                                        id="retirocentro" class="opcionEnvio display" name="retirocentro" value="Retiro centro">&nbsp RETIRO PUNTO DE ENTREGA CENTRO</b></span>
									<!--	<i class="zmdi zmdi-pin"></i> -->
										<br>
										<span style="font-family:Poppins-Medium;display:flex;cursor:pointer;"> Entregamos de lunes a sábados en la calle Chile y San Lorenzo. Es un local que nos ayuda con nuestras entregas únicamente.</span>
									</label>
								</div>
								<br>
								<div>
									<label class="span-check-correo">
									  <span style="font-family:Poppins-Medium; font-size:14px; text-align: center;"><b><input style="display:inline;" type="checkbox" class="opcionEnvio" 
                                        id="enviocorreo" class="opcionEnvio display" name="enviocorreo" value="Envio correo">&nbsp ENVIO POR CORREO ARGENTINO</b></span>
									<!--	<i class="zmdi zmdi-pin"></i> -->
										<br>
										<span style="font-family:Poppins-Medium;display:flex;cursor:pointer;">(Opción para fuera de Gran Mendoza y otras provincias). 
                                       Podes optar por envío a domicilio o a sucursal más cercana, los precios van desde los $4500 aprox. Una vez realizada la compra, envíanos tu nombre y número de compra y la opción elegida. Te vamos a dar el precio exacto a abonar (se abona en origen, si o si). Una vez abonado el monto del envío se despacha al otro día. Te enviaremos un número de seguimiento para que puedas seguir tu envío.</span>
									</label>
								</div>
					
					</div>
				</div>
				<br>
				<div id="datosFact2" class="notblock">
			
				<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-l-25 m-r--38 m-lr-0-xl">
	<form id='formDatos2'>
		<div class="panel-with-header">
			<h3 class="panel-header panel-header-sticky">DATOS DE CONTACTO</h3><br>
			<div class="form-group ">
				<div class="has-float-label">
    				<input type="email" class="form-control" id="txtEmail2" name="txtEmail2" placeholder="Email">
				</div>
   			</div>	
		

  <h3>Datos persona que retirará el pedido</h3>
  <div class="form-row">
  <div class="form-group col-md-6">
	<br>
    <input type="text" class="form-control" id="txtNombre2" name="txtNombre2" placeholder="Nombre">
    </div>	
	<div class="form-group col-md-6">
	<br>
    <input type="text" class="form-control" id="txtApellido2" name="txtApellido2" placeholder="Apellido">
    </div>
	<div class="form-group col-md-6">
    <input type="tel" class="form-control" id="txtTelefono2" name="txtTelefono2" placeholder="Telefono">
    </div>
    	<div class="form-group col-md-6">

      <input type="number" class="form-control" id="txtDni2" name="txtDni2" placeholder="DNI o CUIL">
    </div>
  </div>

  
  
</div>
<div id="optMetodoPago2">	
							<hr>					
							
							<button class="btn-check btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText2">Seleccionar metodo de pago</span></button>&nbsp;&nbsp;&nbsp;

	</div></form>
	</div>
					</div>
				<div id="datosFact" class="notblock">
			
				<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-l-25 m-r--38 m-lr-0-xl">
	<form id='formDatos'>
		<div class="panel-with-header">
			<h3 class="panel-header panel-header-sticky">DATOS DE CONTACTO</h3><br>
			<div class="form-group ">
				<div class="has-float-label">
    				<input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Email">
				</div>
   			</div>	
		
		<h3>DATOS DE FACTURACIÓN</h3>
  <div class="form-row">
	<br><br>
  	<div class="form-group col-md-6">
		<br>
      <select id="txtPais" class="form-control">
        <option selected>Argentina</option>
        <option>...</option>
      </select>
    </div>	
	<div class="form-group col-md-6">
	<br>

      <input type="number" class="form-control" id="txtDni" name="txtDni" placeholder="DNI o CUIL">
    </div>
   
  </div>
  <h5>Persona que pagará el pedido</h5>
  <div class="form-row">
  <div class="form-group col-md-6">
	<br>
    <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre">
    </div>	
	<div class="form-group col-md-6">
	<br>
    <input type="text" class="form-control" id="txtApellido" name="txtApellido" placeholder="Apellido">
    </div>
	<div class="form-group col-md-6">
    <input type="tel" class="form-control" id="txtTelefono" name="txtTelefono" placeholder="Telefono">
    </div>
  </div>
  <h5>Domicilio de la persona que pagará el pedido</h5>

  <div class="form-row">
    <div class="form-group col-md-6">
      <input type="text" class="form-control" id="txtCalle" name="txtCalle" placeholder="Calle">
    </div>
	<div class="form-group col-md-6">
      <input type="tel" class="form-control" id="txtNumero" name="txtNumero" placeholder="Numero">
    </div>
	</div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <input type="text" class="form-control" id="txtBarrio" name="txtBarrio" placeholder="Barrio(Opcional)">
    </div>
	<div class="form-group col-md-6">
      <input type="text" class="form-control" id="txtCiudad" name="txtCiudad" placeholder="Ciudad">
    </div>
	</div>
	<div class="form-row">
    <div class="form-group col-md-6">
      <input type="tel" class="form-control" id="txtCP" name="txtCP" placeholder="Codigo postal">
    </div>
	<div class="form-group col-md-6">
      <input type="text" class="form-control" id="txtProvincia" name="txtProvincia" placeholder="Provincia">
    </div>
	</div>
  
</div>
<div id="optMetodoPago">	
							<hr>					
							
							<button class="btn-check btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Seleccionar metodo de pago</span></button>&nbsp;&nbsp;&nbsp;

	</div></form>
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

				<div id="divMetodoPago" class="notblock">
						<div id="divCondiciones">
							<input type="checkbox" id="condiciones" >
							<label for="condiciones"> Aceptar </label>
							<a href="#" data-toggle="modal" data-target="#modalTerminos" > Términos y Condiciones </a>
						</div>	
				</div>
	
				</div>
			</div>
		</div>
	</div>

<?php 
	footerTienda($data);
 ?>
	
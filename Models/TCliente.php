<?php 
require_once("Libraries/Core/Mysql.php");
trait TCliente{
	private $con;
	private $intIdUsuario;
	private $strNombre;
	private $strApellido;
	private $intTelefono;
	private $strEmail;
	private $strPassword;
	private $strToken;
	private $intTipoId;
	private $intIdTransaccion;
	private $intIdProducto;
	private $intCantidad;

	public function insertCliente(string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid){
		$this->con = new Mysql();
		$this->strNombre = $nombre;
		$this->strApellido = $apellido;
		$this->intTelefono = $telefono;
		$this->strEmail = $email;
		$this->strPassword = $password;
		$this->intTipoId = $tipoid;

		$return = 0;
		$sql = "SELECT * FROM persona WHERE 
				email_user = '{$this->strEmail}' ";
		$request = $this->con->select_all($sql);

		if(empty($request))
		{
			$query_insert  = "INSERT INTO persona(nombres,apellidos,telefono,email_user,password,rolid) 
							  VALUES(?,?,?,?,?,?)";
        	$arrData = array($this->strNombre,
    						$this->strApellido,
    						$this->intTelefono,
    						$this->strEmail,
    						$this->strPassword,
    						$this->intTipoId);
        	$request_insert = $this->con->insert($query_insert,$arrData);
        	$return = $request_insert;
		}else{
			$return = "exist";
		}
        return $return;
	}

	public function insertPedido(string $idtransaccionpaypal = NULL, string $datospaypal = NULL, int $personaid, float $costo_envio, string $monto, int $tipopagoid, string $direccionenvio, string $status){
		$this->con = new Mysql();
		$query_insert  = "INSERT INTO pedido(idtransaccionpaypal,datospaypal,personaid,costo_envio,monto,tipopagoid,direccion_envio,status) 
							  VALUES(?,?,?,?,?,?,?,?)";
		$arrData = array($idtransaccionpaypal,
    						$datospaypal,
    						$personaid,
    						$costo_envio,
    						$monto,
    						$tipopagoid,
    						$direccionenvio,
    						$status
    					);
		$request_insert = $this->con->insert($query_insert,$arrData);
	    $return = $request_insert;
	    return $return;
	}
	public function insertPedidoEnvio(string $tipoenvio, string $email, int $dni, string $pais, string $nombre, int $telefono, string $direccion, string $barrio, string $ciudad,int $codigopostal, string $provincia,string $status){
		$this->con = new Mysql();
		$query_insert  = "INSERT INTO pedido(tipo_envio,email_cliente,dni_cliente,pais_cliente,nombre_cliente,telefono_cliente,
		direccion_envio,barrio_cliente,ciudad_cliente,codigo_postal,provincia_cliente,status) 
							  VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
		$arrData = array($tipoenvio,
    						$email,
    						$dni,
    						$pais,
    						$nombre,
							$telefono,
    						$direccion,
    						$barrio,
							$ciudad,
							$codigopostal,
							$provincia,
							$status
    					);
		$request_insert = $this->con->insert($query_insert,$arrData);
	    $return = $request_insert;
	    return $return;
	}
	public function insertDetalle(int $idpedido, int $productoid, float $precio, int $cantidad){
		$this->con = new Mysql();
		$query_insert  = "INSERT INTO detalle_pedido(pedidoid,productoid,precio,cantidad) 
							  VALUES(?,?,?,?)";
		$arrData = array($idpedido,
    					$productoid,
						$precio,
						$cantidad
					);
		$request_insert = $this->con->insert($query_insert,$arrData);
	    $return = $request_insert;
	    return $return;
	}
	public function selectProducto(int $idproducto){
		$this->con = new Mysql();

		$this->intIdProducto = $idproducto;
		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.precio,
						p.stock,
						p.stocktalle1,
						p.stocktalle2,
						p.stocktalle3,
						p.stocktalle4,
						p.stocktalle5,
						p.stocktalle6,
						p.stocktalle7,
						p.stocktalle8,
						p.categoriaid,
						c.nombre as categoria,
						p.status
				FROM producto p
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				WHERE idproducto = $this->intIdProducto";
		$request = $this->con->select($sql);
		return $request;

	}
	public function updatePedido(int $idpedido, int $monto = NULL,string $tipopago = NULL, string $estado){
		$this->con = new Mysql();

		$transaccion = null;	
		if($transaccion == NULL){
			$query_insert  = "UPDATE pedido SET tipopago = ?,monto = ?, status = ?  WHERE idpedido = $idpedido ";

			$arrData = array($tipopago, $monto, $estado);
		}else{
			$query_insert  = "UPDATE pedido SET referenciacobro = ?, tipopagoid = ?,status = ? WHERE idpedido = $idpedido";
			$arrData = array($transaccion,
							$tipopago,
							$estado
						);
		}
	
		$request_insert = $this->con->update($query_insert,$arrData);

		return $request_insert;
	}
	public function insertDetalleTemp(array $pedido){
		$this->intIdUsuario = $pedido['idcliente'];
		$this->intIdTransaccion = $pedido['idtransaccion'];
		$productos = $pedido['productos'];

		$this->con = new Mysql();
		$sql = "SELECT * FROM detalle_temp WHERE 
					transaccionid = '{$this->intIdTransaccion}' AND 
					personaid = $this->intIdUsuario";
		$request = $this->con->select_all($sql);

		if(empty($request)){
			foreach ($productos as $producto) {
				$query_insert  = "INSERT INTO detalle_temp(personaid,productoid,precio,cantidad,transaccionid) 
								  VALUES(?,?,?,?,?)";
	        	$arrData = array($this->intIdUsuario,
	        					$producto['idproducto'],
	    						$producto['precio'],
	    						$producto['cantidad'],
	    						$this->intIdTransaccion
	    					);
	        	$request_insert = $this->con->insert($query_insert,$arrData);
			}
		}else{
			$sqlDel = "DELETE FROM detalle_temp WHERE 
				transaccionid = '{$this->intIdTransaccion}' AND 
				personaid = $this->intIdUsuario";
			$request = $this->con->delete($sqlDel);
			foreach ($productos as $producto) {
				$query_insert  = "INSERT INTO detalle_temp(personaid,productoid,precio,cantidad,transaccionid) 
								  VALUES(?,?,?,?,?)";
	        	$arrData = array($this->intIdUsuario,
	        					$producto['idproducto'],
	    						$producto['precio'],
	    						$producto['cantidad'],
	    						$this->intIdTransaccion
	    					);
	        	$request_insert = $this->con->insert($query_insert,$arrData);
			}
		}
	}

	public function getPedido(int $idpedido){
		$this->con = new Mysql();
		$request = array();

		$sql = "SELECT p.idpedido,
							p.fecha,
							p.costo_envio,
							p.monto,
							p.tipopago,
							p.email_cliente,
							p.direccion_envio,
							p.status,
							p.tipo_envio
					FROM pedido as p
					WHERE p.idpedido =  $idpedido";
		$requestPedido = $this->con->select($sql);
		if(count($requestPedido) > 0){
			$sql_detalle = "SELECT p.idproducto,
											p.nombre as producto,
											d.precio,
											d.cantidad
									FROM detalle_pedido d
									INNER JOIN producto p
									ON d.productoid = p.idproducto
									WHERE d.pedidoid = $idpedido
									";
			$requestProductos = $this->con->select_all($sql_detalle);
			$request = array('orden' => $requestPedido,
							'detalle' => $requestProductos
							);
		}
		return $request;
	}

	public function setSuscripcion(string $nombre, string $email){
		$this->con = new Mysql();
		$sql = 	"SELECT * FROM suscripciones WHERE email = '{$email}'";
		$request = $this->con->select_all($sql);
		if(empty($request)){
			$query_insert  = "INSERT INTO suscripciones(nombre,email) 
							  VALUES(?,?)";
			$arrData = array($nombre,$email);
			$request_insert = $this->con->insert($query_insert,$arrData);
			$return = $request_insert;
		}else{
			$return = false;
		}
		return $return;
	}

	public function setContacto(string $nombre, string $email, string $mensaje, string $ip, string $dispositivo, string $useragent){
		$this->con = new Mysql();
		$nombre  	 = $nombre != "" ? $nombre : ""; 
		$email 		 = $email != "" ? $email : ""; 
		$mensaje	 = $mensaje != "" ? $mensaje : ""; 
		$ip 		 = $ip != "" ? $ip : ""; 
		$dispositivo = $dispositivo != "" ? $dispositivo : ""; 
		$useragent 	 = $useragent != "" ? $useragent : ""; 
		$query_insert  = "INSERT INTO contacto(nombre,email,mensaje,ip,dispositivo,useragent) 
						  VALUES(?,?,?,?,?,?)";
		$arrData = array($nombre,$email,$mensaje,$ip,$dispositivo,$useragent);
		$request_insert = $this->con->insert($query_insert,$arrData);
		return $request_insert;
	}
	public function getProducto(int $idproducto){
		$request =array();
		$this->con = new Mysql();
		$sql = 	"SELECT * FROM producto WHERE idproducto = $idproducto";
		$request = $this->con->select($sql);
		return $request;

	}
	public function updateProducto(int $idproducto,int $cantidad,int $talle){
		$this->intIdProducto = $idproducto;
		$this->intCantidad = $cantidad;
		$this->intTalle = $talle;
		
		$request =array();
		$this->con = new Mysql();
		$sql = 	"SELECT * FROM producto WHERE idproducto = $idproducto";
		$request = $this->con->select($sql);
		if(!empty($request)){
			$stock = $request['stock'];

			$stockActual = $stock - $cantidad;

			if($talle == '85'){
				$stockTalle = $request['stocktalle1'];
				$stockTalleActual = $stockTalle - $cantidad;
				$sql = "UPDATE producto SET stock = ?, stocktalle1 = ? WHERE idproducto = ? ";

			}
			if($talle == '90'){
				$stockTalle = $request['stocktalle2'];
				$stockTalleActual = $stockTalle - $cantidad;
				$sql = "UPDATE producto SET stock = ?, stocktalle2 = ? WHERE idproducto = ? ";

			}
			if($talle == '95'){
				$stockTalle = $request['stocktalle3'];
				$stockTalleActual = $stockTalle - $cantidad;
				$sql = "UPDATE producto SET stock = ?, stocktalle3 = ? WHERE idproducto = ? ";

			}
			if($talle == '100'){
				$stockTalle = $request['stocktalle4'];
				$stockTalleActual = $stockTalle - $cantidad;
				$sql = "UPDATE producto SET stock = ?, stocktalle4 = ? WHERE idproducto = ? ";

			}
			if($talle == '105'){
				$stockTalle = $request['stocktalle5'];
				$stockTalleActual = $stockTalle - $cantidad;
				$sql = "UPDATE producto SET stock = ?, stocktalle5 = ? WHERE idproducto = ? ";

			}
			if($talle == '110'){
				$stockTalle = $request['stocktalle6'];
				$stockTalleActual = $stockTalle - $cantidad;
				$sql = "UPDATE producto SET stock = ?, stocktalle6 = ? WHERE idproducto = ? ";

			}
			if($talle == '115'){
				$stockTalle = $request['stocktalle7'];
				$stockTalleActual = $stockTalle - $cantidad;
				$sql = "UPDATE producto SET stock = ?, stocktalle7 = ? WHERE idproducto = ? ";

			}
			if($talle == '120'){
				$stockTalle = $request['stocktalle8'];
				$stockTalleActual = $stockTalle - $cantidad;
				$sql = "UPDATE producto SET stock = ?, stocktalle8 = ? WHERE idproducto = ? ";

			}
			

			$arrData = array($stockActual, 
								$stockTalleActual,
								 $idproducto);

				$request = $this->con->update($sql,$arrData);


		}
		return $request;

	}
	
}

 ?>
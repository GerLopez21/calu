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
    private $intTalle;
    private $strColor;
    private $intProducto;

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
    public function getIdTalle(string $idTalle)
		{

		    		$this->con = new Mysql();

			//BUSCAR ROLE
			$this->intIdTalle = $idTalle;
			$sql = "SELECT idstocktalle FROM talles WHERE nombretalle = '{$this->intIdTalle}'";
			$request = $this->con->select($sql);
            $request = $request['idstocktalle'];
			return $request;
		}
		 public function getIdColor(string $color)
		{
		    		$this->con = new Mysql();

			//BUSCAR ROLE
			$this->strColor = $color;
			$sql = "SELECT idcolor FROM color WHERE nombre like '{$this->strColor}'";
            
			$request = $this->con->select($sql);
            $request = $request['idcolor'];
			return $request;
		}
	public function insertPedido(string $idtransaccionpaypal = NULL, string $datospaypal = NULL, int $personaid, float $costo_envio, string $monto, int $tipopagoid, string $direccionenvio, string $status,date $fecha_compra){
		$this->con = new Mysql();
		$query_insert  = "INSERT INTO pedido(idtransaccionpaypal,datospaypal,personaid,costo_envio,monto,tipopagoid,direccion_envio,status,fecha_compra) 
							  VALUES(?,?,?,?,?,?,?,?,?)";
		$arrData = array($idtransaccionpaypal,
    						$datospaypal,
    						$personaid,
    						$costo_envio,
    						$monto,
    						$tipopagoid,
    						$direccionenvio,
    						$status,
    						$fecha_compra
    					);
		$request_insert = $this->con->insert($query_insert,$arrData);
	    $return = $request_insert;
	    return $return;
	}
	public function insertPedidoEnvio(int $tipoenvio = null, string $email = null, $dni = null, string $pais = null, string $nombre = null, $telefono = null, string $direccion = null, string $barrio = null, string $ciudad = null, $codigopostal =null, string $provincia=null,string $status =null){

		$this->con = new Mysql();

		$query_insert  = "INSERT INTO pedido(idtipoenvio,email_cliente,dni_cliente,pais_cliente,nombre_cliente,telefono_cliente,
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
	public function insertDetalle(int $idpedido, int $productoid, float $precio, int $cantidad,string $talle=null,string $color =null){
		$this->con = new Mysql();

		if($talle != null && $color != null){
		    $query_insert  = "INSERT INTO detalle_pedido(pedidoid,productoid,precio,cantidad,talle,color) 
							  VALUES(?,?,?,?,?,?)";
							  	$arrData = array($idpedido,
    					$productoid,
						$precio,
						$cantidad,$talle,$color
					);

		}else{
		    	$query_insert  = "INSERT INTO detalle_pedido(pedidoid,productoid,precio,cantidad) 
							  VALUES(?,?,?,?)";
							  	$arrData = array($idpedido,
    					$productoid,
						$precio,
						$cantidad
					);
		}
	

	

		$request_insert = $this->con->insert($query_insert,$arrData);
	    $return = $request_insert;

	    return $return;
	}
		 public function getStockAjax($talleseleccionado,$producto)
		{
			$this->con = new Mysql();

		    $this->intTalle = $talleseleccionado;
		    $this->intProducto = $producto;

            $sql2 = "SELECT s.idstock as idstock,s.cantidad as cantidad,s.talleid as talleid,s.colorid as colorid,s.productoid as productoid,s.fotoreferencia as fotoreferencia
            ,t.nombre as nombre FROM stock s left join color t on (s.colorid = t.idcolor)
            where talleid = $talleseleccionado and productoid = $this->intProducto and cantidad > 0";
			$request2 = $this->con->select_all($sql2);

			return $request2;
		}
	public function selectProducto(int $idproducto,string $talle =null,int $color =null){
		$this->con = new Mysql();
		$this->intIdProducto = $idproducto;
		$this->intTalle = $talle;
		$this->strColor = $color;

        if($talle != null){
		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.precio,
						p.stock,
				        p.preciodescuento,
						p.categoriaid,
						c.nombre as categoria,
						p.status,
						p.obl_talle_color,
						s.talleid,
						s.colorid,
						s.cantidad
				FROM producto p
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				LEFT OUTER JOIN stock s
				ON p.idproducto = s.productoid 
				WHERE idproducto = $this->intIdProducto
				and s.talleid = $this->intTalle
				and s.colorid = $this->strColor
				and s.cantidad > 0";
        }else{

            $sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.precio,
						p.stock,
				        p.preciodescuento,
						p.categoriaid,
						c.nombre as categoria,
						p.status,
						p.obl_talle_color,
						p.stock
				FROM producto p
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				WHERE idproducto = $this->intIdProducto";
        }
		$request = $this->con->select($sql);
		return $request;

	}
	public function updatePedido(int $idpedido, int $monto = NULL,int $tipopago = NULL, string $estado){
		$this->con = new Mysql();
        
		$transaccion = null;	
		if($transaccion == NULL){
			$query_insert  = "UPDATE pedido SET tipopagoid = ?,monto = ?, status = ?  WHERE idpedido = $idpedido ";

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
							t.tipopago,
							p.email_cliente,
							p.direccion_envio,
							p.status,
							e.tipoenvio,
							p.ciudad_cliente,
							p.codigo_postal,
							p.pais_cliente,
							p.provincia_cliente,
							p.cod_seguimiento,
							p.sucursal,
							p.fecha_pago,
							p.fecha_retiro,
							p.fecha_envio,
							p.nombre_cliente
					FROM pedido as p
					LEFT outer join tipoenvios e on p.idtipoenvio = e.idtipoenvio
					LEFT outer join tipopago t on  p.tipopagoid = t.idtipopago

					WHERE p.idpedido =  $idpedido";
                    
		$requestPedido = $this->con->select($sql);
		if(count($requestPedido) > 0){
			$sql_detalle = "SELECT p.idproducto,
											p.nombre as producto,
											d.precio,
											d.cantidad,
											d.talle,
											d.color,
											p.preciodescuento
									FROM detalle_pedido d
									LEFT JOIN producto p
									ON d.productoid = p.idproducto
									WHERE d.pedidoid = $idpedido
									GROUP BY p.idproducto
									";
			$requestProductos = $this->con->select_all($sql_detalle);
			if(count($requestProductos) > 0){
					for ($c=0; $c < count($requestProductos) ; $c++) { 
						$intIdProducto = $requestProductos[$c]['idproducto'];
						$sqlImg = "SELECT img
								FROM imagen
								WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select($sqlImg);
						if(count($arrImg) > 0){
								$arrImg['url_image'] = media().'/images/uploads/'.$arrImg['img'];
							
						}
						$requestProductos[$c]['images'] = $arrImg;
					}
				}
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
		$random = rand(10,100);
		$codigo = "1COMPRA".str_replace(' ','',strtoupper($nombre)).$random;
		$query_insert  = "INSERT INTO cupones(nombre,estado,limite_cantidad_productos,limite_cantidad_usos,limite_fecha_desde,limite_fecha_hasta,tipo,minimo_compra,limite_tipo_pago,productos,categorias,fecha_carga,monto_descuento,porcentaje_descuento,envio_gratis,id_usuario_carga) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
	    $arrData = array($codigo,1,null,null,date('Y-m-d'),null,2,null,null,"todos","todas",date('Y-m-d H:m:s'),null,10,0,999);
	    $request_insert = $this->con->insert($query_insert,$arrData);
		$query_select_cat = "Select idproducto from producto where status = 1";
        $request_cat = $this->con->select_all($query_select_cat);

        foreach($request_cat as $prod){
           	$query_insert  = "INSERT INTO cupones_detalles(productoid,cuponid) VALUES(?,?)";
    	    $arrData = array($prod['idproducto'],$request_insert);
			$request_insert_prod = $this->con->insert($query_insert,$arrData);
        }
		$return = $codigo;
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
	public function updateProducto(int $idproducto,int $cantidad,int $talle=null, int $color=null){
        
		$this->intIdProducto = $idproducto;
		$this->intCantidad = $cantidad;
		$this->intTalle = $talle;
    	$this->strColor = $color;
		$request =array();
		$this->con = new Mysql();
	
		if($talle != null){
		    	  $sql = "SELECT nombretalle FROM talles where idstocktalle = $talle";
			$request = $this->con->select($sql);
			
			$nombretalle = $request['nombretalle'];
			  $sql = "SELECT nombre FROM color where idcolor = $color";
			$request = $this->con->select($sql);
			
			$nombrecolor = $request['nombre'];
		    $sql = "select cantidad as stock from stock where productoid = $this->intIdProducto and talleid = $this->intTalle and colorid = $this->strColor order by idstock desc";
    		$request = $this->con->select($sql);
            
            $stock = $request['stock'];
            $stockActualIndividual = $stock - $cantidad;

            $sql = "SELECT stock FROM producto where idproducto = $this->intIdProducto";
    		$request = $this->con->select($sql);
            $stock = $request['stock'];
            $stockActualGeneral = $stock - $cantidad;
    			

		}else{
              $sql = "SELECT stock FROM producto where idproducto = $this->intIdProducto";
    		$request = $this->con->select($sql);
            $stock = $request['stock'];
            $stockActualGeneral = $stock - $cantidad;

		}

		if(!empty($request)){
			
            if($talle != null){
                $sqlDel = "DELETE FROM stock WHERE 
				productoid = $idproducto AND 
				talleid = $talle and colorid = $color";
			$request = $this->con->delete($sqlDel);
			
			$query_insert = "INSERT INTO stock (cantidad,productoid,talleid,colorid) VALUES (?,?,?,?)";
		    $arrData = array($stockActualIndividual,$idproducto,$talle,$color);

        	$request_insert = $this->con->insert($query_insert,$arrData);
        	$return = $request_insert;
		
           $query_insert2 = "INSERT INTO movimientos_stock (tipo_movimiento,procedencia,cantidad,fecha,productoid,observacion,gral_ind) VALUES (?,?,?,?,?,?,?)";
		    $arrData2 = array("Venta","Descuento individual por venta",$cantidad,date('Y-m-d H:i:s'),$idproducto,"Talle: ".$nombretalle." Color: ".$nombrecolor."\n"." Stock individual actual ".$stockActualIndividual,0);

        	$request_insert2 = $this->con->insert($query_insert2,$arrData2);
        	$return2 = $request_insert2;
								            $sql = "UPDATE producto SET stock = ? WHERE idproducto = ? ";
                $arrData = array($stockActualGeneral, 
								 $idproducto);
								 				$request = $this->con->update($sql,$arrData);
								 				    $query_insert2 = "INSERT INTO movimientos_stock (tipo_movimiento,procedencia,cantidad,fecha,productoid,observacion,gral_ind) VALUES (?,?,?,?,?,?,?)";
		    $arrData2 = array("Venta","Descuento general por venta",$cantidad,date('Y-m-d H:i:s'),$idproducto,"Stock general actual ".$stockActualGeneral,1);

        	$request_insert2 = $this->con->insert($query_insert2,$arrData2);
        	$return2 = $request_insert2;

            }else{
               $sql = "UPDATE producto SET stock = ? WHERE idproducto = ? ";
                $arrData = array($stockActualGeneral, 
								 $idproducto);
								 				$request = $this->con->update($sql,$arrData);
			$query_insert2 = "INSERT INTO movimientos_stock (tipo_movimiento,procedencia,cantidad,fecha,productoid,observacion,gral_ind) VALUES (?,?,?,?,?,?,?)";
		    $arrData2 = array("Venta","Descuento general por venta",$cantidad,date('Y-m-d H:i:s'),$idproducto,"Stock general actual ".$stockActualGeneral,1);

        	$request_insert2 = $this->con->insert($query_insert2,$arrData2);
        	$return2 = $request_insert2;

            }
		
			

	



		}
		return $request;

	}
	
}

 ?>
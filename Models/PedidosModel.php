<?php 

	class PedidosModel extends Mysql
	{
		private $objCategoria;
		public function __construct()
		{
			parent::__construct();
		}

		public function selectPedidos($idpersona = null){
			$where = "";
			
			$sql = "
					SELECT p.idpedido,
							DATE_FORMAT(p.fecha, '%d/%m/%Y') as fecha,
							p.costo_envio,
							p.nombre_cliente,
							p.apellido_cliente,
							p.dni_cliente,
							p.telefono_cliente,
							p.monto,
							t.tipopago as tipopago,
							p.email_cliente,
							p.direccion_envio,
							p.status,
							e.tipoenvio as tipo_envio
					FROM pedido as p
				
					LEFT outer join tipoenvios e on p.idtipoenvio = e.idtipoenvio
					LEFT outer join tipopago t on  p.tipopagoid = t.idtipopago
						where p.idpedido != 272 and p.idpedido != 271 and p.idpedido != 270 and p.idpedido != 269
					and p.idpedido != 268 and p.idpedido != 267 and p.idpedido != 266 and p.idpedido != 265 
					and p.idpedido != 264  and p.idpedido != 261 and p.idpedido != 260 
					";
			$request = $this->select_all($sql);
			return $request;

		}	
        public function selectDetallesPedido($idpedido){
			$where = "";
			
			$sql = "
					SELECT p.productoid,
							p.cantidad,
							p.talle,
							p.color
					FROM detalle_pedido as p
						WHERE p.pedidoid = $idpedido;

					";
			$request = $this->select_all($sql);
			return $request;

		}	
		public function selectPedido(int $idpedido, $idpersona = NULL){
			$busqueda = "";
			if($idpersona != NULL){
				$busqueda = " AND p.personaid =".$idpersona;
			}
			$request = array();
		
		$sql = "SELECT p.idpedido,
	
							DATE_FORMAT(p.fecha, '%d/%m/%Y') as fecha,
							p.costo_envio,
							p.nombre_cliente,
							p.apellido_cliente,
							p.dni_cliente,
							p.telefono_cliente,
							p.monto,
							t.tipopago as tipopago,
							p.email_cliente,
							p.direccion_envio,
							p.status,
							e.tipoenvio as tipo_envio,
							p.cod_seguimiento,
							p.sucursal,
							p.fecha_pago,
							p.fecha_retiro
					FROM pedido as p
					LEFT outer join tipoenvios e on p.idtipoenvio = e.idtipoenvio
					LEFT outer join tipopago t on  p.tipopagoid = t.idtipopago
					WHERE p.idpedido = $idpedido;
					";

			$requestPedido = $this->select($sql);
			if(!empty($requestPedido)){
				
				$sql_detalle = "SELECT p.idproducto,
											p.nombre as producto,
											d.precio,
											d.cantidad,
											d.talle,d.color,p.preciodescuento
									FROM detalle_pedido d
									INNER JOIN producto p
									ON d.productoid = p.idproducto
									WHERE d.pedidoid = $idpedido";
				$requestProductos = $this->select_all($sql_detalle);
				$request = array(
								'orden' => $requestPedido,
								'detalle' => $requestProductos
								 );
			}
			return $request;
		}

		public function selectTransPaypal(string $idtransaccion, $idpersona = NULL){
			$busqueda = "";
			if($idpersona != NULL){
				$busqueda = " AND personaid =".$idpersona;
			}
			$objTransaccion = array();
			$sql = "SELECT datospaypal FROM pedido WHERE idtransaccionpaypal = '{$idtransaccion}' ".$busqueda;
			$requestData = $this->select($sql);
			if(!empty($requestData)){
				$objData = json_decode($requestData['datospaypal']);
				//$urlOrden = $objData->purchase_units[0]->payments->captures[0]->links[2]->href;
				$urlOrden = $objData->links[0]->href;
				$objTransaccion = CurlConnectionGet($urlOrden,"application/json",getTokenPaypal());
			}
			return $objTransaccion;
		}

		public function reembolsoPaypal(string $idtransaccion, string $observacion){
			$response = false;
			$sql = "SELECT idpedido,datospaypal FROM pedido WHERE idtransaccionpaypal = '{$idtransaccion}' ";
			$requestData = $this->select($sql);
			if(!empty($requestData)){
				$objData = json_decode($requestData['datospaypal']);
				$urlReembolso = $objData->purchase_units[0]->payments->captures[0]->links[1]->href;
				$objTransaccion = CurlConnectionPost($urlReembolso,"application/json",getTokenPaypal());
				if(isset($objTransaccion->status) and  $objTransaccion->status == "COMPLETED"){
					$idpedido = $requestData['idpedido'];
					$idtrasaccion = $objTransaccion->id;
					$status = $objTransaccion->status;
					$jsonData = json_encode($objTransaccion);
					$observacion = $observacion;
					$query_insert  = "INSERT INTO reembolso(pedidoid,
														idtransaccion,
														datosreembolso,
														observacion,
														status) 
								  	VALUES(?,?,?,?,?)";
					$arrData = array($idpedido,
	        						$idtrasaccion,
	        						$jsonData,
	        						$observacion,
	        						$status
	        					);
					$request_insert = $this->insert($query_insert,$arrData);
					if($request_insert > 0){
	        			$updatePedido  = "UPDATE pedido SET status = ? WHERE idpedido = $idpedido";
			        	$arrPedido = array("Reembolsado");
			        	$request = $this->update($updatePedido,$arrPedido);
			        	$response = true;
	        		}
				}
				return $response;
			}
		}

		public function updatePedido(int $idpedido, int $monto = NULL, $transaccion = NULL, $tipopago = NULL, string $estado = NULL, string $mail = NULL, 
		int$envio = NULL, string $direccion = NULL,$telefono = NULL,$fecha_pago = NULL,string $cod_seguimiento = NULL, $fecha_retiro = NULL, $fecha_envio = NULL){
			if($transaccion == NULL){
			    if($monto != null){
			        $query_insert  = "UPDATE pedido SET tipopagoid = ?, monto = ?, status = ?, email_cliente = ?, idtipoenvio = ?, direccion_envio = ?, telefono_cliente = ?  WHERE idpedido = $idpedido ";

    	        	$arrData = array($tipopago, $monto, $estado,$mail,$envio,$direccion,$telefono); 
			    }else{
			           $query_insert  = "UPDATE pedido SET tipopagoid = ?, status = ?, email_cliente = ?, idtipoenvio = ?, direccion_envio = ?, telefono_cliente = ?,
			           fecha_pago = ?, cod_seguimiento = ?, fecha_retiro = ?, fecha_envio = ? WHERE idpedido = $idpedido ";
    	        	$arrData = array($tipopago, $estado,$mail,$envio,$direccion,$telefono,$fecha_pago,$cod_seguimiento,$fecha_retiro,$fecha_envio); 
    	        	                  

			    }
			
			}else{
				$query_insert  = "UPDATE pedido SET referenciacobro = ?, tipopagoid = ?,status = ? WHERE idpedido = $idpedido";
	        	$arrData = array($transaccion,
	        					$tipopago,
	    						$estado
	    					);
			}
			$request_insert = $this->update($query_insert,$arrData);

        	return $request_insert;
		}
			public function selectColor(string $nombreColor)
		{
			$this->strColor = $nombreColor;
			$sql = "SELECT * FROM color WHERE nombre = '$this->strColor'";

			$request = $this->select($sql);

			return $request;
		}
			public function selectTalle(string $nombreTalle)
		{
			//BUSCAR ROLE
			$this->strTalle = $nombreTalle;
			$sql = "SELECT * FROM talles WHERE nombretalle = '$this->strTalle'";
			$request = $this->select($sql);
			return $request;
		}
		public function updateStockCancelado(int $idproducto,string $talle=null, string $color=null,int $cantidad, int $idpedido=null){

		$this->intIdProducto = $idproducto;
		$this->intCantidad = $cantidad;
		$this->intTalle = $talle;
    	$this->strColor = $color;
		$request =array();
		if($talle != null){
		    	  $sql = "SELECT nombretalle FROM talles where idstocktalle = $talle";
			$request = $this->select($sql);
			
			$nombretalle = $request['nombretalle'];
			  $sql = "SELECT nombre FROM color where idcolor = $color";
			$request = $this->select($sql);
			
			$nombrecolor = $request['nombre'];
		    $sql = "select cantidad as stock from stock where productoid = $this->intIdProducto and talleid = $this->intTalle and colorid = $this->strColor order by idstock desc";
    		$request = $this->select($sql);
		    $sql = "select cantidad as stock from stock where productoid = $this->intIdProducto and talleid = $this->intTalle and colorid = $this->strColor order by idstock desc";
    		$request = $this->select($sql);

            $stock = $request['stock'];
            $stockActualIndividual = $stock + $cantidad;

            $sql = "SELECT stock FROM producto where idproducto = $this->intIdProducto";
    		$request = $this->select($sql);
            $stock = $request['stock'];
            $stockActualGeneral = $stock + $cantidad;
    			

		}else{
              $sql = "SELECT stock FROM producto where idproducto = $this->intIdProducto";
    		$request = $this->select($sql);
            $stock = $request['stock'];
            $stockActualGeneral = $stock + $cantidad;

		}
		if(!empty($request)){
			
            if($talle != null){
                  $sqlDel = "DELETE FROM stock WHERE 
				productoid = $idproducto AND 
				talleid = $talle and colorid = $color";
			$request = $this->delete($sqlDel);
			
			$query_insert = "INSERT INTO stock (cantidad,productoid,talleid,colorid) VALUES (?,?,?,?)";
		    $arrData = array($stockActualIndividual,$idproducto,$talle,$color);

        	$request_insert = $this->insert($query_insert,$arrData);
        	$return = $request_insert;
		
								 				
								 				
				   $query_insert2 = "INSERT INTO movimientos_stock (tipo_movimiento,procedencia,cantidad,fecha,productoid,observacion,gral_ind) VALUES (?,?,?,?,?,?,?)";
		    $arrData2 = array("Cancelación","Carga individual por cancelación pedido ".$idpedido,$cantidad,date('Y-m-d H:i:s'),$idproducto,"Talle: ".$nombretalle." Color: ".$nombrecolor."\n"." Stock individual actual ".$stockActualIndividual,0);

        	$request_insert2 = $this->insert($query_insert2,$arrData2);
        	$return2 = $request_insert2;

								            $sql = "UPDATE producto SET stock = ? WHERE idproducto = ? ";
                $arrData = array($stockActualGeneral, 
								 $idproducto);
								 				$request = $this->update($sql,$arrData);
								 				  $query_insert2 = "INSERT INTO movimientos_stock (tipo_movimiento,procedencia,cantidad,fecha,productoid,observacion,gral_ind) VALUES (?,?,?,?,?,?,?)";
		    $arrData2 = array("Cancelación","Carga general por cancelación pedido ".$idpedido,$cantidad,date('Y-m-d H:i:s'),$idproducto,"Stock general actual ".$stockActualGeneral,1);

        	$request_insert2 = $this->insert($query_insert2,$arrData2);
        	$return2 = $request_insert2;

            }else{
               $sql = "UPDATE producto SET stock = ? WHERE idproducto = ? ";
                $arrData = array($stockActualGeneral, 
								 $idproducto);
								 				$request = $this->update($sql,$arrData);
								 					  $query_insert2 = "INSERT INTO movimientos_stock (tipo_movimiento,procedencia,cantidad,fecha,productoid,observacion,gral_ind) VALUES (?,?,?,?,?,?,?)";
		    $arrData2 = array("Cancelación","Carga general por cancelación pedido ".$idpedido,$cantidad,date('Y-m-d H:i:s'),$idproducto,"Stock general actual ".$stockActualGeneral,1);

        	$request_insert2 = $this->insert($query_insert2,$arrData2);
        	$return2 = $request_insert2;

            }
		
			

	



		}
		return $request;

	}

	}
 ?>
<?php 

	class PromocionesModel extends Mysql
	{
	
		public $intIdPromocion;
		public $strTitulo;
		public $intEstado;
		public $intTipoPromocion;
		public $intMinCompra;
		public $intMinProductos;
		public $intStockPromo;
		public $intTipoPago;
 
		public function __construct()
		{
			parent::__construct();
		}

		public function getPromociones()
		{
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1 ){
				$whereAdmin = " and idrol != 1 ";
			}
			//EXTRAE ROLES
			$sql = "SELECT * FROM promociones";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectPromocion(int $idPromocion)
		{
			//BUSCAR ROLE
			$this->intIdPromocion = $idPromocion;
			$sql = "SELECT * FROM promociones WHERE idpromocion = $this->intIdPromocion";
			$request = $this->select($sql);
			if($request['limite_fecha_desde'] != null){
				$request['limite_fecha_desde'] = formatearFecha($request['limite_fecha_desde']);
			}
			if($request['limite_fecha_hasta'] != null){
				$request['limite_fecha_hasta'] = formatearFecha($request['limite_fecha_hasta']);
			}
			
			return $request;
		}

		public function insertPromocion($aplicabilidad,$listProductos, $listCategorias,int $estado,int $tipoPromocion,$minCompra=null,$minProductos=null,$stockPromo=null,$tipoPago=null, $fechaInicio = null,$fechaFin = null,$combinableCat = null,$combinableVariado = null,$montoPromo = null){

			$return = "";
			$this->intEstado = $estado;
			$this->intTipoPromocion = $tipoPromocion;
			$this->intMinCompra = $minCompra;
			$this->intMinProductos = $minProductos;
			$this->intStockPromo = $stockPromo;
			$this->intTipoPago = $tipoPago;
		

            $productos = null;
            $categorias=null;
            if($listCategorias != null){

                $categorias = implode(",",$listCategorias);
            }
            if($listProductos != null){
                   $productos = implode(",",$listProductos);

            }
		  
			$idUsuario = $_SESSION['idUser'];

			if(empty($request))
			{
				$query_insert  = "INSERT INTO promociones(aplicabilidad,estado,limite_cantidad_productos,limite_cantidad_usos,limite_fecha_desde,limite_fecha_hasta,tipo,minimo_compra,limite_tipo_pago,productos,categorias,fecha_carga,combinable_categoria,combinable_variado,monto_promocion,id_usuario_carga) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
	        	$arrData = array($aplicabilidad,$this->intEstado,$this->intMinProductos,$this->intStockPromo,$fechaInicio,$fechaFin,$this->intTipoPromocion,$this->intMinCompra,$this->intTipoPago,$productos,$categorias,date('Y-m-d H:m:s'),$combinableCat,$combinableVariado,$montoPromo,$idUsuario);
	    	
				$request_insert = $this->insert($query_insert,$arrData);
			    foreach($listCategorias as $categoria){
                    $query_select_cat = "Select idproducto from producto where categoriaid = $categoria";
                    $request_cat = $this->select_all($query_select_cat);
                    foreach($request_cat as $prod){
                    	$query_insert  = "INSERT INTO promociones_detalles(productoid,promocionid) VALUES(?,?)";
                	    $arrData = array($prod['idproducto'],$request_insert);
	        	        $request_insert_prod = $this->insert($query_insert,$arrData);
                    }

                }
                foreach($listProductos as $producto){

                    	$query_insert  = "INSERT INTO promociones_detalles(productoid,promocionid) VALUES(?,?)";
                	    $arrData = array($producto,$request_insert);

	        	        $request_insert_prod = $this->insert($query_insert,$arrData);
                }

	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}	

		public function updatePromocion(int $idPromocion,$aplicabilidad,$listProductos, $listCategorias,int $estado,int $tipoPromocion,$combinableCat,$combinableVariado,$minCompra=null,$minProductos=null,$stockPromo=null,$tipoPago=null, $fechaInicio = null,$fechaFin = null,$montoPromo = null){
			$return = "";
			$this->intIdPromocion = $idPromocion;
			$this->intEstado = $estado;
			$this->intTipoPromocion = $tipoPromocion;
			$this->intMinCompra = $minCompra;
			$this->intMinProductos = $minProductos;
			$this->intStockPromo = $stockPromo;
			$this->intTipoPago = $tipoPago;
		


            $productos = null;
            $categorias=null;

			if($listCategorias != null){

                $categorias = implode(",",$listCategorias);
            }
            if($listProductos != null){
                   $productos = implode(",",$listProductos);

            }
			$idUsuario = $_SESSION['idUser'];

			// $sql = "SELECT * FROM promociones WHERE titulo = '{$this->strTitulo}' ";

			// $request = $this->select_all($sql);
		    

				$sql = "UPDATE promociones SET aplicabilidad = ?,estado = ?,limite_cantidad_productos = ?,limite_cantidad_usos = ?,limite_fecha_desde = ?,
				limite_fecha_hasta = ?,tipo = ?,minimo_compra = ?,limite_tipo_pago = ?,productos = ?,categorias = ?,combinable_categoria = ?,
				combinable_variado = ?,monto_promocion =?,fecha_modificacion = ?, id_usuario_modificacion = ?
				WHERE idpromocion = $this->intIdPromocion";
	        	$arrData = array($aplicabilidad,$this->intEstado,$this->intMinProductos,$this->intStockPromo,$fechaInicio,$fechaFin,$this->intTipoPromocion,$this->intMinCompra,$this->intTipoPago,$productos,$categorias,$combinableCat,$combinableVariado,$montoPromo,date('Y-m-d H:m:s'),$idUsuario);
			
				$request = $this->update($sql,$arrData);
		        $query  = "DELETE FROM promociones_detalles 
						WHERE promocionid = $this->intIdPromocion";
	            $request_delete = $this->delete($query);
	        
				foreach($listCategorias as $categoria){
                    $query_select_cat = "Select idproducto from producto where categoriaid = $categoria";
                    $request_cat = $this->select_all($query_select_cat);
                    foreach($request_cat as $prod){
                    	$query_insert  = "INSERT INTO promociones_detalles(productoid,promocionid) VALUES(?,?)";
                	    $arrData = array($prod['idproducto'],$this->intIdPromocion);
	        	        $request_insert_prod = $this->insert($query_insert,$arrData);
                    }

                }
                foreach($listProductos as $producto){

                    	$query_insert  = "INSERT INTO promociones_detalles(productoid,promocionid) VALUES(?,?)";
                	    $arrData = array($producto,$this->intIdPromocion);

	        	        $request_insert_prod = $this->insert($query_insert,$arrData);
                }
			
		    return $request;			
		}
		

		public function deleteRol(int $idcolor)
		{
			$this->intIdColor = $idcolor;
			$sql = "SELECT * FROM color WHERE idcolor = $this->intIdColor";
			$request = $this->select_all($sql);
			if(empty($request))
			{
                $sql = "SELECT * FROM color WHERE idcolor = $this->intIdColor";
				$arrData = array(0);
				$request = $this->update($sql,$arrData);
				if($request)
				{
					$request = 'ok';	
				}else{
					$request = 'error';
				}
			}else{
				$request = 'exist';
			}
			return $request;
		}
	}
 ?>
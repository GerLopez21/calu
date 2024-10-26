<?php 

	class DescuentosModel extends Mysql
	{
	
		public $intIdDescuento;
		public $strTitulo;
		public $intEstado;
		public $intTipoDescuento;
		public $intMinCompra;
		public $intMinProductos;
		public $intStockPromo;
		public $intTipoPago;

		public function __construct()
		{
			parent::__construct();
		}

		public function getDescuentos()
		{
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1 ){
				$whereAdmin = " and idrol != 1 ";
			}
			//EXTRAE ROLES
			$sql = "SELECT * FROM descuentos";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectDescuento(int $idDescuento)
		{
			//BUSCAR ROLE
			$this->intIdDescuento = $idDescuento;
			$sql = "SELECT * FROM descuentos WHERE iddescuento = $this->intIdDescuento";
			$request = $this->select($sql);
			// if(str_contains($request['productos'],",")){
			// 	$request['productos'] = explode(",",$request['productos']);
			// }
			// if(str_contains($request['categorias'],",")){
			// $request['categorias'] = explode(",",$request['categorias']);
			// }
			$request['limite_fecha_desde'] = formatearFecha($request['limite_fecha_desde']);
			$request['limite_fecha_hasta'] = formatearFecha($request['limite_fecha_hasta']);
			return $request;
		}

		public function insertDescuento(string $strTitulo,$listProductos, $listCategorias,int $estado,int $tipoDescuento,$minCompra=null,$minProductos=null,$stockPromo=null,$tipoPago=null, $fechaInicio = null,$fechaFin = null,$montoFijo=null,$porcDescuento=null,$envioGratis=null){

			$return = "";
			$this->strTitulo = $strTitulo;
			$this->intEstado = $estado;
			$this->intTipoDescuento = $tipoDescuento;
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
		    $sql = "SELECT * FROM descuentos WHERE titulo = '{$this->strTitulo}' ";

			$request = $this->select_all($sql);
		    $idUsuario = $_SESSION['idUser'];

			if(empty($request))
			{
				$query_insert  = "INSERT INTO descuentos(titulo,estado,limite_cantidad_productos,limite_cantidad_usos,limite_fecha_desde,limite_fecha_hasta,tipo,minimo_compra,limite_tipo_pago,productos,categorias,fecha_carga,monto_descuento,porcentaje_descuento,envio_gratis,id_usuario_carga) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
	        	$arrData = array($this->strTitulo,$this->intEstado,$this->intMinProductos,$this->intStockPromo,$fechaInicio,$fechaFin,$this->intTipoDescuento,$this->intMinCompra,$this->intTipoPago,$productos,$categorias,date('Y-m-d H:m:s'),$montoFijo,$porcDescuento,$envioGratis,$idUsuario);
				$request_insert = $this->insert($query_insert,$arrData);
				
                foreach($listCategorias as $categoria){
                    $query_select_cat = "Select idproducto from producto where categoriaid = $categoria";
                    $request_cat = $this->select_all($query_select_cat);
                    foreach($request_cat as $prod){
                    	$query_insert  = "INSERT INTO descuentos_detalles(productoid,descuentoid) VALUES(?,?)";
                	    $arrData = array($prod['idproducto'],$request_insert);
	        	        $request_insert_prod = $this->insert($query_insert,$arrData);
                    }

                }
                foreach($listProductos as $producto){

                    	$query_insert  = "INSERT INTO descuentos_detalles(productoid,descuentoid) VALUES(?,?)";
                	    $arrData = array($producto,$request_insert);

	        	        $request_insert_prod = $this->insert($query_insert,$arrData);
                }

	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}	

		public function updateDescuento(int $idDescuento,string $strTitulo,$listProductos, $listCategorias,int $estado,int $tipoDescuento,$minCompra=null,$minProductos=null,$stockPromo=null,$tipoPago=null, $fechaInicio = null,$fechaFin = null,$montoFijo=null,$porcDescuento=null,$envioGratis=null){
			$return = "";
			$this->intIdDescuento = $idDescuento;
			$this->strTitulo = $strTitulo;
			$this->intEstado = $estado;
			$this->intTipoDescuento = $tipoDescuento;
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

		    $sql = "SELECT * FROM descuentos WHERE titulo = '{$this->strTitulo}' ";
			$request = $this->select_all($sql);
		    

		
				$sql = "UPDATE descuentos SET titulo = ?, minimo_compra = ?,estado= ?,limite_cantidad_productos= ?,limite_cantidad_usos= ?,
				limite_fecha_desde= ?,limite_fecha_hasta= ?,
				tipo= ?,limite_tipo_pago= ?,categorias= ?,productos= ?,
				monto_descuento= ?,porcentaje_descuento= ?,envio_gratis= ?, fecha_modificacion = ?, id_usuario_modificacion = ?
				WHERE iddescuento = $this->intIdDescuento";
				$arrData = array($this->strTitulo,$this->intMinCompra,$this->intEstado,$this->intMinProductos,$this->intStockPromo,$fechaInicio,$fechaFin,$this->intTipoDescuento,$this->intTipoPago,$categorias,$productos,$montoFijo,$porcDescuento,$envioGratis,date('Y-m-d H:m:s'),$idUsuario);
			
				$request = $this->update($sql,$arrData);
		        $query  = "DELETE FROM descuentos_detalles 
						WHERE descuentoid = $this->intIdDescuento";
	            $request_delete = $this->delete($query);
	        
				foreach($listCategorias as $categoria){
                    $query_select_cat = "Select idproducto from producto where categoriaid = $categoria";
                    $request_cat = $this->select_all($query_select_cat);
                    foreach($request_cat as $prod){
                    	$query_insert  = "INSERT INTO descuentos_detalles(productoid,descuentoid) VALUES(?,?)";
                	    $arrData = array($prod['idproducto'],$this->intIdDescuento);
	        	        $request_insert_prod = $this->insert($query_insert,$arrData);
                    }

                }
                foreach($listProductos as $producto){

                    	$query_insert  = "INSERT INTO descuentos_detalles(productoid,descuentoid) VALUES(?,?)";
                	    $arrData = array($producto,$this->intIdDescuento);

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
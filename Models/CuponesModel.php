<?php 

	class CuponesModel extends Mysql
	{
	
		public $intIdCupon;
		public $strTitulo;
		public $intEstado;
		public $intTipoCupon;
		public $intMinCompra;
		public $intMinProductos;
		public $intStockPromo;

		public function __construct()
		{
			parent::__construct();
		}

		public function getCupones()
		{
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1 ){
				$whereAdmin = " and idrol != 1 ";
			}
			//EXTRAE ROLES
			$sql = "SELECT * FROM cupones";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectCupon(int $idcupon)
		{
			//BUSCAR ROLE
			$this->intIdCupon = $idcupon;
			$sql = "SELECT * FROM cupones WHERE idcupon = $this->intIdCupon";
			$request = $this->select($sql);
			// if(str_contains($request['productos'],",")){
			// 	$request['productos'] = explode(",",$request['productos']);
			// }
			// if(str_contains($request['categorias'],",")){
			// $request['categorias'] = explode(",",$request['categorias']);
			// }
			if($request['limite_fecha_desde'] != null){
				$request['limite_fecha_desde'] = formatearFecha($request['limite_fecha_desde']);
			}
			if($request['limite_fecha_hasta'] != null){
				$request['limite_fecha_hasta'] = formatearFecha($request['limite_fecha_hasta']);
			}

			return $request;
		}

		public function insertCupon(string $strTitulo,$listProductos, $listCategorias,int $estado,int $tipoCupon,$minCompra=null,$minProductos=null,$stockPromo=null, $fechaInicio = null,$fechaFin = null,$montoFijo=null,$porcCupon=null,$envioGratis=null){
			$return = "";
			$this->strTitulo = $strTitulo;
			$this->intEstado = $estado;
			$this->intTipoCupon = $tipoCupon;
			$this->intMinCompra = $minCompra;
			$this->intMinProductos = $minProductos;
			$this->intStockPromo = $stockPromo;
		

            $productos = null;
            $categorias=null;
            if($listCategorias != null && $listCategorias != "todas"){

                $categorias = implode(",",$listCategorias);
            }
            if($listProductos != null && $listProductos != "todos"){
                   $productos = implode(",",$listProductos);

            }
		    $sql = "SELECT * FROM cupones WHERE nombre = '{$this->strTitulo}' ";

			$request = $this->select($sql);
		    $idUsuario = $_SESSION['idUser'];
			if(empty($request))
			{

				$query_insert  = "INSERT INTO cupones(nombre,estado,limite_cantidad_productos,limite_cantidad_usos,limite_fecha_desde,limite_fecha_hasta,tipo,minimo_compra,productos,categorias,fecha_carga,monto_descuento,porcentaje_descuento,envio_gratis,id_usuario_carga) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
	        	$arrData = array($this->strTitulo,$this->intEstado,$this->intMinProductos,$this->intStockPromo,$fechaInicio,$fechaFin,$this->intTipoCupon,$this->intMinCompra,$productos,$categorias,date('Y-m-d H:m:s'),$montoFijo,$porcCupon,$envioGratis,$idUsuario);
				$request_insert = $this->insert($query_insert,$arrData);
				if($listCategorias == "todas"){
					$query_select_cat = "Select idproducto from producto where status = 1";
                    $request_cat = $this->select_all($query_select_cat);

                    foreach($request_cat as $prod){
                    	$query_insert  = "INSERT INTO cupones_detalles(productoid,cuponid) VALUES(?,?)";
                	    $arrData = array($prod['idproducto'],$request_insert);
	        	        $request_insert_prod = $this->insert($query_insert,$arrData);
                    }

				}else{

					foreach($listCategorias as $categoria){
						$query_select_cat = "Select idproducto from producto where categoriaid = $categoria";
						$request_cat = $this->select_all($query_select_cat);
						foreach($request_cat as $prod){
							$query_insert  = "INSERT INTO cupones_detalles(productoid,cuponid) VALUES(?,?)";
							$arrData = array($prod['idproducto'],$request_insert);
							$request_insert_prod = $this->insert($query_insert,$arrData);
						}
	
					}
					foreach($listProductos as $producto){
	
							$query_insert  = "INSERT INTO cupones_detalles(productoid,cuponid) VALUES(?,?)";
							$arrData = array($producto,$request_insert);
	
							$request_insert_prod = $this->insert($query_insert,$arrData);
					}
	
				}
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}	

		public function updateCupon(int $idCupon,string $strTitulo,$listProductos, $listCategorias,int $estado,int $tipoCupon,$minCompra=null,$minProductos=null,$stockPromo=null, $fechaInicio = null,$fechaFin = null,$montoFijo=null,$porcCupon=null,$envioGratis=null){
			$return = "";
			$this->intIdCupon = $idCupon;
			$this->strTitulo = $strTitulo;
			$this->intEstado = $estado;
			$this->intTipoCupon = $tipoCupon;
			$this->intMinCompra = $minCompra;
			$this->intMinProductos = $minProductos;
			$this->intStockPromo = $stockPromo;
		

            $productos = null;
            $categorias=null;
			if($listCategorias != null && $listCategorias != "todas"){

                $categorias = implode(",",$listCategorias);
            }
            if($listProductos != null && $listProductos != "todos"){
                   $productos = implode(",",$listProductos);

            }
			$idUsuario = $_SESSION['idUser'];

		    $sql = "SELECT * FROM cupones WHERE nombre = '{$this->strTitulo}' ";
			$request = $this->select_all($sql);
		
				$sql = "UPDATE cupones SET nombre = ?, minimo_compra = ?,estado= ?,limite_cantidad_productos= ?,limite_cantidad_usos= ?,
				limite_fecha_desde= ?,limite_fecha_hasta= ?,
				tipo= ?,categorias= ?,productos= ?,
				monto_descuento= ?,porcentaje_descuento= ?,envio_gratis= ?, fecha_modificacion = ?, id_usuario_modificacion = ?
				WHERE idcupon = $this->intIdCupon";
				$arrData = array($this->strTitulo,$this->intMinCompra,$this->intEstado,$this->intMinProductos,$this->intStockPromo,$fechaInicio,$fechaFin,$this->intTipoCupon,$categorias,$productos,$montoFijo,$porcCupon,$envioGratis,date('Y-m-d H:m:s'),$idUsuario);
			
				$request = $this->update($sql,$arrData);
		        $query  = "DELETE FROM cupones_detalles 
						WHERE cuponid = $this->intIdCupon";
	            $request_delete = $this->delete($query);
	        
				if($listCategorias == "todas"){
					$query_select_cat = "Select idproducto from producto where status = 1";
                    $request_cat = $this->select_all($query_select_cat);

                    foreach($request_cat as $prod){
                    	$query_insert  = "INSERT INTO cupones_detalles(productoid,cuponid) VALUES(?,?)";
                	    $arrData = array($prod['idproducto'],$this->intIdCupon);
	        	        $request_insert_prod = $this->insert($query_insert,$arrData);
                    }

				}else{

					foreach($listCategorias as $categoria){
						$query_select_cat = "Select idproducto from producto where categoriaid = $categoria";
						$request_cat = $this->select_all($query_select_cat);
						foreach($request_cat as $prod){
							$query_insert  = "INSERT INTO cupones_detalles(productoid,cuponid) VALUES(?,?)";
							$arrData = array($prod['idproducto'],$this->intIdCupon);
							$request_insert_prod = $this->insert($query_insert,$arrData);
						}
	
					}
					foreach($listProductos as $producto){
	
							$query_insert  = "INSERT INTO cupones_detalles(productoid,cuponid) VALUES(?,?)";
							$arrData = array($producto,$request_insert);
	
							$request_insert_prod = $this->insert($query_insert,$arrData);
					}
	
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
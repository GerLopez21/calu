<?php 

	class ProductosModel extends Mysql
	{
		private $intIdProducto;
		private $strNombre;
		private $strDescripcion;
		private $intCodigo;
		private $intCategoriaId;
		private $intPrecio;
		private $intStock;
		private $intStock1;
		private $intStock2;
		private $intStock3;
		private $intStock4;
		private $intStock5;
		private $intStock6;
		private $intStock7;
		private $intStock8;
		private $intStatus;
		private $strRuta;
		private $strImagen;
		private $intPrecioDescuento;
		private $intObligatorio;

		public function __construct()
		{
			parent::__construct();
		}
		
		public function selectColores()
		{
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1 ){
				$whereAdmin = " and idrol != 1 ";
			}
			//EXTRAE ROLES
			$sql = "SELECT * FROM color";
			$request = $this->select_all($sql);
			return $request;
		}
	    public function selectTalles()
		{
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1 ){
				$whereAdmin = " and idrol != 1 ";
			}
			//EXTRAE ROLES
			$sql = "SELECT * FROM talles";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectProductos(){
		
			$sql = "SELECT p.idproducto,
							p.codigo,
							p.nombre,
							p.descripcion,
							p.categoriaid,
							c.nombre as categoria,
							p.precio,
							p.stock,
							p.preciodescuento,
							p.obl_talle_color,
							p.status 
					FROM producto p 
					INNER JOIN categoria c
					ON p.categoriaid = c.idcategoria
					WHERE p.status != 0 ";
					$request = $this->select_all($sql);
    				if(count($request) > 0){
    				    for ($c=0; $c < count($request) ; $c++) { 

    						$intIdProducto = $request[$c]['idproducto'];
    						$sqlImg = "SELECT img
    								FROM imagen
    								WHERE productoid = $intIdProducto limit 1";

    						$arrImg = $this->select_all($sqlImg);

    						if(count($arrImg) > 0){
    							for ($i=0; $i < count($arrImg); $i++) { 
    								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
    								    						$request[$c]['images'] = media().'/images/uploads/'.$arrImg[$i]['img'];


    							}
    						}

    					}
					}

			return $request;
		}	

		public function insertProducto(string $nombre, string $descripcion, int $categoriaid, string $precio, int $stock,
        int $preciodescuento, string $ruta, int $status,int $obligatorio){
			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;
			$this->intCategoriaId = $categoriaid;
			$this->strPrecio = $precio;
			$this->intStock = $stock;
			$this->intPrecioDescuento = $preciodescuento;
	
			$this->strRuta = $ruta;
			$this->intStatus = $status;
			$this->intObligatorio = $obligatorio;

			$return = 0;
			$sql = "SELECT * FROM producto WHERE codigo = '{$this->intCodigo}'";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$query_insert  = "INSERT INTO producto(categoriaid,
														nombre,
														descripcion,
														precio,
														stock,
														preciodescuento,
														ruta,
														status,
														obl_talle_color) 
								  VALUES(?,?,?,?,?,?,?,?,?)";
	        	$arrData = array($this->intCategoriaId,
        						$this->strNombre,
        						$this->strDescripcion,
        						$this->strPrecio,
        						$this->intStock,
								$this->intPrecioDescuento,
        						$this->strRuta,
        						$this->intStatus,
        						$this->intObligatorio
								);
							
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
	        return $return;
		}
			public function insertMovimiento(string $tipo_movimiento,  $gral_ind, string $procedencia, int $producto, $fecha, string $observacion = null, int $stock){
		
				$query_insert  = "INSERT INTO movimientos_stock(tipo_movimiento,
														gral_ind,
														procedencia,
														productoid,
														fecha,
														observacion,
														cantidad) 
								  VALUES(?,?,?,?,?,?,?)";

	        	$arrData = array($tipo_movimiento,
        						$gral_ind,
        						$procedencia,
        						$producto,
        						$fecha,
								$observacion,
        						$stock
								);
							
	        	$request_insert = $this->insert($query_insert,$arrData);

	        	$return = $request_insert;
		
	        return $return;
		}
	public function selectStockProducto($idproducto)
		{
		    
		    $this->intIdProducto = $idproducto;
		
			$sql = "SELECT s.idstock,s.cantidad,t.nombretalle,c.nombre,s.productoid,s.fotoreferencia,p.stock FROM stock s
            left join talles t on (t.idstocktalle = s.talleid)
            left join color c on (c.idcolor = s.colorid)	
            left join producto p on s.productoid = p.idproducto 

            where s.productoid = $this->intIdProducto and s.cantidad > 0";
            
            $request = $this->select_all($sql);
            $sqlSuma = "select sum(cantidad) as suma from stock where productoid = $this->intIdProducto and cantidad > 0";
                        $requestSuma = $this->select($sqlSuma);

            $request[0]['sumaindividual'] = $requestSuma['suma'];

			return $request;
		}
		public function updateProducto(int $idproducto, string $nombre, string $descripcion, int $categoriaid, string $precio, int $stock,int $preciodescuento,string $ruta, int $status,int $obligatorio){
			$this->intIdProducto = $idproducto;

			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;
			$this->intCategoriaId = $categoriaid;
			$this->strPrecio = $precio;
			$this->intStock = $stock;
			$this->intPrecioDescuento = $preciodescuento;
			$this->strRuta = $ruta;
			$this->intStatus = $status;
			$this->intObligatorio = $obligatorio;

			$return = 0;
			
			$sql = "SELECT * FROM producto WHERE codigo = '{$this->intCodigo}' AND idproducto != $this->intIdProducto ";

			$request = $this->select_all($sql);
		
			if(empty($request))
			{
				$sql = "UPDATE producto 
						SET categoriaid=?,
							nombre=?,
							descripcion=?,
							precio=?,
							stock=?,
							preciodescuento=?,
							ruta=?,
							status=?,
							obl_talle_color=?
						WHERE idproducto = $this->intIdProducto ";
				$arrData = array($this->intCategoriaId,
        						$this->strNombre,
        						$this->strDescripcion,
        						$this->strPrecio,
        						$this->intStock,
								$this->intPrecioDescuento,
								$this->strRuta,
        						$this->intStatus,
        						$this->intObligatorio);

	        	$request = $this->update($sql,$arrData);
	        	
	        	$return = $request;
		
			}else{
				$return = "exist";
			}
	        return $return;
		}

		public function selectProducto(int $idproducto){
			$this->intIdProducto = $idproducto;
			$sql = "SELECT p.idproducto,
							p.codigo,
							p.nombre,
							p.descripcion,
							p.precio,
							p.stock,
							p.preciodescuento,
							p.obl_talle_color,
							p.categoriaid,
							c.nombre as categoria,
							p.status
					FROM producto p
					INNER JOIN categoria c
					ON p.categoriaid = c.idcategoria
					WHERE idproducto = $this->intIdProducto";
			$request = $this->select($sql);

			return $request;

		}

		public function insertImage(int $idproducto, string $imagen){
			$this->intIdProducto = $idproducto;
			$this->strImagen = $imagen;
			$query_insert  = "INSERT INTO imagen(productoid,img) VALUES(?,?)";
	        $arrData = array($this->intIdProducto,
        					$this->strImagen);
	        $request_insert = $this->insert($query_insert,$arrData);
	        return $request_insert;
		}

		public function selectImages(int $idproducto){
			$this->intIdProducto = $idproducto;
			$sql = "SELECT productoid,img
					FROM imagen
					WHERE productoid = $this->intIdProducto";
			$request = $this->select_all($sql);
			return $request;
		}

		public function deleteImage(int $idproducto, string $imagen){
			$this->intIdProducto = $idproducto;
			$this->strImagen = $imagen;
			$query  = "DELETE FROM imagen 
						WHERE productoid = $this->intIdProducto 
						AND img = '{$this->strImagen}'";
	        $request_delete = $this->delete($query);
	        return $request_delete;
		}

		public function deleteProducto(int $idproducto){
			$this->intIdProducto = $idproducto;
			$sql = "UPDATE producto SET status = ? WHERE idproducto = $this->intIdProducto ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}
	}
 ?>
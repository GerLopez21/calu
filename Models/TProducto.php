<?php 
require_once("Libraries/Core/Mysql.php");
trait TProducto{
	private $con;
	private $strCategoria;
	private $intIdcategoria;
	private $intIdProducto;
	private $strProducto;
	private $cant;
	private $option;
	private $strRuta;
	private $strRutaCategoria;
	private $intIdOrden;

	public function getProductosT(){
		$this->con = new Mysql();
		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						c.nombre as categoria,
						p.precio,
						p.ruta,
						p.stock,
						p.preciodescuento
				FROM producto p 
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria

				WHERE p.status != 0 ORDER BY p.idproducto DESC LIMIT ".CANTPORDHOME;
				$request = $this->con->select_all($sql);
				if(count($request) > 0){
					for ($c=0; $c < count($request) ; $c++) { 
						$intIdProducto = $request[$c]['idproducto'];
						$sqlImg = "SELECT img
								FROM imagen
								WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select_all($sqlImg);
						if(count($arrImg) > 0){
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
						$request[$c]['images'] = $arrImg;
					}

					for ($d=0; $d < count($request) ; $d++) { 

						$intIdProducto = $request[$d]['idproducto'];
						$sqlDescuento = "SELECT *
								FROM descuentos d
								INNER JOIN descuentos_detalles dd
								on d.iddescuento = dd.descuentoid
								WHERE dd.productoid = $intIdProducto
								and d.estado = 1";
						$arrDescuento= $this->con->select($sqlDescuento);
						$request[$d]['descuento'] = $arrDescuento;

					    
						$intIdProducto = $request[$d]['idproducto'];
						$sqlPromocion = "SELECT *
								FROM promociones d
								INNER JOIN promociones_detalles pd
								on d.idpromocion = pd.promocionid
								
								WHERE pd.productoid = $intIdProducto
								and d.estado = 1";
						$arrPromocion= $this->con->select($sqlPromocion);
						if(!empty($arrPromocion)){
						switch ($arrPromocion['tipo']) {
                            case 1:
                                $nombreTipo = '2x1';
                                break;
                            case 2:
                                $nombreTipo = '3x2';
                                break;
                            case 3:
                                $nombreTipo = '4x3';
                                break;
                            // Agrega más casos según sea necesario
                            default:
                                $nombreTipo = '-';
                                break;
                        }
                        $arrPromocion['nombreTipo'] = $nombreTipo;
						}
						$request[$d]['promocion'] = $arrPromocion;
					}


				}
		return $request;
	}
        public function selectStockProducto($idproducto)
		{
		    $this->intIdProducto = $idproducto;
			
			$sql = "SELECT * FROM stock where productoid = $this->intIdProducto";

			$request = $this->con->select_all($sql);
			
			return $request;
		}
	public function getProductosPage($desde, $porpagina){
		$this->con = new Mysql();
		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						c.nombre as categoria,
						p.precio,
						p.ruta,
						p.stock
				FROM producto p 
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				WHERE p.status = 1 and c.status = 1 ORDER BY p.idproducto DESC LIMIT $desde,$porpagina";
				$request = $this->con->select_all($sql);
				if(count($request) > 0){
					for ($c=0; $c < count($request) ; $c++) { 
						$intIdProducto = $request[$c]['idproducto'];
						$sqlImg = "SELECT img
								FROM imagen
								WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select_all($sqlImg);
						if(count($arrImg) > 0){
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
						$request[$c]['images'] = $arrImg;
					}
				}
		return $request;
	}

	public function getProductosCategoriaT(int $idcategoria, string $ruta, $desde = null, $porpagina = null){
		$this->intIdcategoria = $idcategoria;
		$this->strRuta = $ruta;
		$where = "";
		if(is_numeric($desde) AND is_numeric($porpagina)){
			$where = " LIMIT ".$desde.",".$porpagina;
		}

		$this->con = new Mysql();
		$sql_cat = "SELECT idcategoria,nombre,ruta FROM categoria WHERE idcategoria = '{$this->intIdcategoria}'";
		$request = $this->con->select($sql_cat);

		if(!empty($request)){
			$this->strCategoria = $request['nombre'];
			$this->strRutaCategoria = $request['ruta'];
			$sql = "SELECT p.idproducto,
							p.codigo,
							p.nombre,
							p.descripcion,
							p.categoriaid,
							c.nombre as categoria,
							p.precio,
							p.ruta,
							p.stock
					FROM producto p 
					INNER JOIN categoria c
					ON p.categoriaid = c.idcategoria
					WHERE p.status = 1 and c.status = 1 AND p.categoriaid = $this->intIdcategoria AND c.ruta = '{$this->strRuta}'
					ORDER BY p.idproducto DESC ";

					$request = $this->con->select_all($sql);
					if(count($request) > 0){
						for ($c=0; $c < count($request) ; $c++) { 
							$intIdProducto = $request[$c]['idproducto'];
							$sqlImg = "SELECT img
									FROM imagen
									WHERE productoid = $intIdProducto";
							$arrImg = $this->con->select_all($sqlImg);
							if(count($arrImg) > 0){
								for ($i=0; $i < count($arrImg); $i++) { 
									$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
								}
							}
							$request[$c]['images'] = $arrImg;
						}
					}
			$request = array('idcategoria' => $this->intIdcategoria,
								'ruta' => $this->strRutaCategoria,
								'categoria' => $this->strCategoria,
								'productos' => $request
							);

		}
		return $request;
	}
        public function getProductosOrdenados(int $idorden=null, string $cat=null){
    
		$this->intIdOrden = $idorden;
		$this->strCategoria  =$cat;
		// $where = "";
		// if(is_numeric($desde) AND is_numeric($porpagina)){
		// 	$where = " LIMIT ".$desde.",".$porpagina;
		// }
		$this->con = new Mysql(); 
		if($this->intIdOrden == 1){
			$order= " ORDER BY p.precio ASC ";
		}
		if($this->intIdOrden == 2){
			$order= " ORDER BY p.precio DESC ";
		}
		if($this->intIdOrden == 3){
			$order= " ORDER BY p.idproducto DESC ";
		}
		if($this->intIdOrden == 4){
			$order= " ORDER BY p.idproducto ASC ";
		}
		if($this->strCategoria != null){
		    $sql_cat = "SELECT idcategoria FROM categoria WHERE ruta like '{$this->strCategoria}'";
		    $request = $this->con->select($sql_cat);
		    $idcategoria = $request['idcategoria'];

		    $categoria = "and categoriaid =".$idcategoria;
		}

		// $sql_cat = "SELECT idcategoria,nombre,ruta FROM categoria WHERE idcategoria = '{$this->intIdcategoria}'";
		// $request = $this->con->select($sql_cat);

		// if(!empty($request)){
		// 	$this->strCategoria = $request['nombre'];
		// 	$this->strRutaCategoria = $request['ruta'];

			$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						p.precio,
						p.ruta,
						p.stock,
						p.stocktalle1,
						p.stocktalle2,
						p.stocktalle3,
						p.stocktalle4,
						p.stocktalle5,
						p.stocktalle6,
						p.stocktalle7,
						p.stocktalle8,
						p.preciodescuento

						FROM producto p WHERE p.status = 1 " .$categoria .$order;

					$request = $this->con->select_all($sql);
					if(count($request) > 0){
						for ($c=0; $c < count($request) ; $c++) { 
							$intIdProducto = $request[$c]['idproducto'];
							$sqlImg = "SELECT img
									FROM imagen
									WHERE productoid = $intIdProducto";
							$arrImg = $this->con->select_all($sqlImg);
							if(count($arrImg) > 0){
								for ($i=0; $i < count($arrImg); $i++) { 
									$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
								}
							}
							$request[$c]['images'] = $arrImg;
						}
					}
			$request = array(
								'productos' => $request
							);

		//}

		return $request;
	}

	public function getProductoT(int $idproducto, string $ruta){
		$this->con = new Mysql();
		$this->intIdProducto = $idproducto;
		$this->strRuta = $ruta;
		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						c.nombre as categoria,
						c.ruta as ruta_categoria,
						p.precio,
						p.ruta,
						p.stock,
						p.preciodescuento

				FROM producto p 
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				WHERE p.status = 1 and c.status = 1 AND p.idproducto = '{$this->intIdProducto}' AND p.ruta = '{$this->strRuta}' ";
				$request = $this->con->select($sql);
				if(!empty($request)){
					$intIdProducto = $request['idproducto'];
					$sqlImg = "SELECT img
							FROM imagen
							WHERE productoid = $intIdProducto";
					$arrImg = $this->con->select_all($sqlImg);
					if(count($arrImg) > 0){
						for ($i=0; $i < count($arrImg); $i++) { 
							$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
						}
					}else{
						$arrImg[0]['url_image'] = media().'/images/uploads/product.png';
					}
					$request['images'] = $arrImg;
				}
		return $request;
	}

	public function getProductosRandom(int $idcategoria, int $cant, string $option){
		$this->intIdcategoria = $idcategoria;
		$this->cant = $cant;
		$this->option = $option;

		if($option == "r"){
			$this->option = " RAND() ";
		}else if($option == "a"){
			$this->option = " idproducto ASC ";
		}else{
			$this->option = " idproducto DESC ";
		}

		$this->con = new Mysql();
		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						c.nombre as categoria,
						p.precio,
						p.ruta,
						p.stock
				FROM producto p 
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				WHERE p.status = 1 and c.status = 1 AND p.categoriaid = $this->intIdcategoria
				ORDER BY $this->option LIMIT  $this->cant ";
				$request = $this->con->select_all($sql);
				if(count($request) > 0){
					for ($c=0; $c < count($request) ; $c++) { 
						$intIdProducto = $request[$c]['idproducto'];
						$sqlImg = "SELECT img
								FROM imagen
								WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select_all($sqlImg);
						if(count($arrImg) > 0){
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
						$request[$c]['images'] = $arrImg;
					}
				}
		return $request;
	}	

	public function getProductoIDT(int $idproducto){
		$this->con = new Mysql();
		$this->intIdProducto = $idproducto;
		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						c.nombre as categoria,
						p.precio,
						p.ruta,
						p.stock,
						p.preciodescuento
					
				FROM producto p 
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				WHERE p.status = 1 AND p.idproducto = '{$this->intIdProducto}' ";
				$request = $this->con->select($sql);
				if(!empty($request)){
					$intIdProducto = $request['idproducto'];
					$sqlImg = "SELECT img
							FROM imagen
							WHERE productoid = $intIdProducto";
					$arrImg = $this->con->select_all($sqlImg);
					if(count($arrImg) > 0){
						for ($i=0; $i < count($arrImg); $i++) { 
							$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
						}
					}else{
						$arrImg[0]['url_image'] = media().'/images/uploads/product.png';
					}
					$request['images'] = $arrImg;
				}
		return $request;
	}

	public function cantProductos($categoria = null){
		$where = "";
		if($categoria != null){
			$where = " AND categoriaid = ".$categoria;
		}
		$this->con = new Mysql();
		$sql = "SELECT COUNT(*) as total_registro FROM producto WHERE status = 1 ".$where;
		$result_register = $this->con->select($sql);
		$total_registro = $result_register;
		return $total_registro;

	}

	public function cantProdSearch($busqueda){
		$this->con = new Mysql();
		$sql = "SELECT COUNT(*) as total_registro FROM producto WHERE nombre LIKE '%$busqueda%' AND status = 1 ";
		$result_register = $this->con->select($sql);
		$total_registro = $result_register;
		return $total_registro;
	}

	public function getProdSearch($busqueda, $desde, $porpagina){
		$this->con = new Mysql();
		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						c.nombre as categoria,
						p.precio,
						p.ruta,
						p.stock
				FROM producto p 
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				WHERE p.status = 1 AND p.nombre LIKE '%$busqueda%' ORDER BY p.idproducto DESC LIMIT $desde,$porpagina";
				$request = $this->con->select_all($sql);
				if(count($request) > 0){
					for ($c=0; $c < count($request) ; $c++) { 
						$intIdProducto = $request[$c]['idproducto'];
						$sqlImg = "SELECT img
								FROM imagen
								WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select_all($sqlImg);
						if(count($arrImg) > 0){
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
						$request[$c]['images'] = $arrImg;
					}
				}
		return $request;
	}
		public function selectColores()
		{


			
			$sql = "SELECT * FROM color";
			$request = $this->con->select_all($sql);
			return $request;
		}
			public function selectTallesProducto($idproducto)
		{
			
			$this->intIdProducto = $idproducto;
			$sql = "SELECT s.talleid,s.colorid,t.nombretalle,c.nombre,c.codigo,s.fotoreferencia FROM stock s 
            LEFT OUTER JOIN color c on s.colorid = c.idcolor 
            LEFT OUTER JOIN talles t on s.talleid = t.idstocktalle 

            where s.productoid = $this->intIdProducto and s.cantidad > 0;
            ";
			$request = $this->con->select_all($sql);
			return $request;
		}
}

 ?>
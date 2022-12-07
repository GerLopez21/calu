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
		private $intDescuento;
		public function __construct()
		{
			parent::__construct();
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
							p.stocktalle1,
							p.stocktalle2,
							p.stocktalle3,
							p.stocktalle4,
							p.stocktalle5,
							p.stocktalle6,
							p.stocktalle7,
							p.stocktalle8,
							p.status 
					FROM producto p 
					INNER JOIN categoria c
					ON p.categoriaid = c.idcategoria
					WHERE p.status != 0 ";
					$request = $this->select_all($sql);
			return $request;
		}	

		public function insertProducto(string $nombre, string $descripcion, int $categoriaid, string $precio, int $stock,
		int $stock1,int $stock2,int $stock3,int $stock4,int $stock5,int $stock6,int $stock7,int $stock8, string $ruta, int $status){
			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;
			$this->intCategoriaId = $categoriaid;
			$this->strPrecio = $precio;
			$this->intStock = $stock;
			$this->intStock1 = $stock1;
			$this->intStock2 = $stock2;
			$this->intStock3 = $stock3;
			$this->intStock4 = $stock4;
			$this->intStock5 = $stock5;
			$this->intStock6 = $stock6;
			$this->intStock7 = $stock7;
			$this->intStock8 = $stock8;
			$this->strRuta = $ruta;
			$this->intStatus = $status;
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
														stocktalle1,
														stocktalle2,
														stocktalle3,
														stocktalle4,
														stocktalle5,
														stocktalle6,
														stocktalle7,
														stocktalle8,
														ruta,
														status) 
								  VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
	        	$arrData = array($this->intCategoriaId,
        						$this->strNombre,
        						$this->strDescripcion,
        						$this->strPrecio,
        						$this->intStock,
								$this->intStock1,
								$this->intStock2,
								$this->intStock3,
								$this->intStock4,
								$this->intStock5,
								$this->intStock6,
								$this->intStock7,
								$this->intStock8,
        						$this->strRuta,
        						$this->intStatus,
								);
							
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
	        return $return;
		}

		public function updateProducto(int $idproducto, string $nombre, string $descripcion, int $categoriaid, string $precio, int $stock,int $stock1,int $stock2,int $stock3,int $stock4,int $stock5,int $stock6,int $stock7,int $stock8,
		 string $ruta, int $status){
			$this->intIdProducto = $idproducto;

			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;
			$this->intCategoriaId = $categoriaid;
			$this->strPrecio = $precio;
			$this->intStock = $stock;
			$this->intStock1 = $stock1;
			$this->intStock2 = $stock2;
			$this->intStock3 = $stock3;
			$this->intStock4 = $stock4;
			$this->intStock5 = $stock5;
			$this->intStock6 = $stock6;
			$this->intStock7 = $stock7;
			$this->intStock8 = $stock8;
			$this->strRuta = $ruta;
			$this->intStatus = $status;
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
							stocktalle1=?,
							stocktalle2=?,
							stocktalle3=?,
							stocktalle4=?,
							stocktalle5=?,
							stocktalle6=?,
							stocktalle7=?,
							stocktalle8=?,
							ruta=?,
							status=? 
						WHERE idproducto = $this->intIdProducto ";
				$arrData = array($this->intCategoriaId,
        						$this->strNombre,
        						$this->strDescripcion,
        						$this->strPrecio,
        						$this->intStock,
								$this->intStock1,
								$this->intStock2,
								$this->intStock3,
								$this->intStock4,
								$this->intStock5,
								$this->intStock6,
								$this->intStock7,
								$this->intStock8,
        						$this->strRuta,
        						$this->intStatus);

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
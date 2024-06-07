<?php 

	class StockModel extends Mysql
	{
	
		public $intIdColor;
		public $intIdProducto;
		public $intIdTalle;
		public $intCantidad;
		public $strNombreTalle;
		public $strNombreColor;
        public $intIdImgRefer;
        public $intIdStock;

		public function __construct()
		{
			parent::__construct();
		}
			public function selectColores()
		{
			
			
			$sql = "SELECT * FROM color";
			$request = $this->select_all($sql);
			return $request;
		}
			public function selectTalles()
		{
			
			$sql = "SELECT * FROM talles";

			$request = $this->select_all($sql);
			return $request;
		}
	public function checkStock($idtalle,$idcolor,$cantidad,$idproducto)
		{
		    $this->intIdProducto = $idproducto;
			
			$sql = "SELECT * FROM stock where productoid = $this->intIdProducto and talleid = $idtalle and colorid=$idcolor and cantidad > 0";

			$request = $this->select($sql);
			return $request;
		}
			public function checkStockCapacidad($idtalle,$idcolor,$cantidad,$idproducto,$idstock)
		{
		    $capacidad = true;
		    $this->intIdProducto = $idproducto;
		    //Para los casos en que se baja de stock individual y no se sube
			if($idstock > 0){
			   $sqlStock = "SELECT cantidad FROM stock where idstock = $idstock";

			    $requestStock = $this->select($sqlStock);
			}

			if($requestStock['cantidad'] < $cantidad){
			    $sql = "SELECT stock FROM producto where idproducto = $this->intIdProducto";

    			$request = $this->select($sql);
    			$sqlStockCargado = "select sum(cantidad) as suma from stock where productoid = $this->intIdProducto and cantidad > 0 and idstock != $idstock";
    			$requestCargado = $this->select($sqlStockCargado);
    			$sumaTotal = $requestCargado['suma'] + $cantidad;
    
    			if($request['stock'] < $sumaTotal){
    			    $capacidad  = false;
    			}
			}
		
			return $capacidad;
		}
			public function selectStock($stockid)
		{
		    $this->intIdStock = $stockid;
			
			$sql = "SELECT * FROM stock where idstock = $this->intIdStock";

			$request = $this->select($sql);
			return $request;
		}
			public function selectStockProducto($idproducto)
		{
		    
		    $this->intIdProducto = $idproducto;
			
			$sql = "SELECT * FROM stock where productoid = $this->intIdProducto";

			$request = $this->select_all($sql);


			return $request;
		}
		public function deleteStockProducto($idproducto)
		{
		    
		   	$this->intIdProducto = $idproducto;
			$sql = "DELETE FROM stock WHERE productoid = $this->intIdProducto";

			$request = $this->delete($sql);
			return $request;
		}
        
			public function getIdTalle($talle)
		{
		    
		    $this->strNombreTalle = $talle;
            
            
			$sql = "SELECT idstocktalle FROM talles where nombretalle like '$this->strNombreTalle'";
			$request = $this->select_all($sql);
			return $request;
		}
			public function getProducto($idproducto)
		{
		    
		    $this->intIdProducto = $idproducto;
            
            
			$sql = "SELECT stock FROM producto where idproducto = $this->intIdProducto";

			$request = $this->select_all($sql);
			return $request;
		}
			public function getIdColor($color)
		{
		    
		    $this->strNombreColor = "'".$color."'";
            
            
			$sql = "SELECT idcolor FROM color where nombre = $this->strNombreColor";


			$request = $this->select_all($sql);
			return $request;
		}
			public function insertStocks(int $idtalle, int $idcolor, int $cantidad,int $idproducto, int $referencia){


			$this->intIdProducto = $idproducto;
			$this->intIdColor = $idcolor;
			$this->intCantidad = $cantidad;
			$this->intIdTalle = $idtalle;
            $this->intIdImgRefer =$referencia;
            $sql = "SELECT nombretalle FROM talles where idstocktalle = $idtalle";
			$request = $this->select($sql);
			
			$talle = $request['nombretalle'];
			  $sql = "SELECT nombre FROM color where idcolor = $idcolor";
			$request = $this->select($sql);
			
			$color = $request['nombre'];
			$query_insert  = "INSERT INTO stock(cantidad,talleid,productoid,colorid,fotoreferencia) VALUES(?,?,?,?,?)";
        	$arrData = array($this->intCantidad, $this->intIdTalle, $this->intIdProducto, $this->intIdColor, $this->intIdImgRefer);
		

        	$request_insert = $this->insert($query_insert,$arrData);
	        $query_insert2 = "INSERT INTO movimientos_stock (tipo_movimiento,procedencia,cantidad,fecha,productoid,observacion,gral_ind) VALUES (?,?,?,?,?,?,?)";
		    $arrData2 = array("Carga","Carga individual producto",$cantidad,date('Y-m-d H:i:s'),$idproducto,"Talle: ".$talle." Color: ".$color,0);

        	$request_insert2 = $this->insert($query_insert2,$arrData2);
        	$return2 = $request_insert2;

	        return $request_insert;
		}
            public function updateStock(int $idstock, int $cantidad, int $idTalle, int $idColor, int $referencia, int $idproducto){

			$this->intIdProducto = $idproducto;
			$this->intIdStock = $idstock;
			$this->intIdColor = $idColor;
			$this->intCantidad = $cantidad;
			$this->intIdTalle = $idTalle;
            $this->intIdImgRefer =$referencia;
             $sql = "SELECT nombretalle FROM talles where idstocktalle = $idTalle";
			$request = $this->select($sql);
			
			$talle = $request['nombretalle'];
			  $sql = "SELECT nombre FROM color where idcolor = $idColor";
			$request = $this->select($sql);
			
			$color = $request['nombre'];
			$sql = "UPDATE stock 
						SET cantidad=?,talleid=?,colorid=?,fotoreferencia=?
						
						WHERE idstock = $this->intIdStock ";
				$arrData = array($this->intCantidad,$this->intIdTalle,$this->intIdColor,$this->intIdImgRefer);

	        	$request = $this->update($sql,$arrData);
	        $sql2 = "select * from stock where colorid = $this->intIdColor and productoid = $this->intIdProducto";
           $request2 = $this->select_all($sql2);
            foreach($request2 as $stocks){
                $sqlFotoRefer = "UPDATE stock 
						SET fotoreferencia=?
						WHERE idstock =". $stocks['idstock'];
				$arrData = array($this->intIdImgRefer);
                $requestSqlRefer = $this->update($sqlFotoRefer,$arrData);

            }
              $query_insert2 = "INSERT INTO movimientos_stock (tipo_movimiento,procedencia,cantidad,fecha,productoid,observacion,gral_ind) VALUES (?,?,?,?,?,?,?)";
		    $arrData2 = array("Modificación","Actualización individual producto",$cantidad,date('Y-m-d H:i:s'),$idproducto,"Talle: ".$talle." Color: ".$color,0);

        	$request_insert2 = $this->insert($query_insert2,$arrData2);
        	$return2 = $request_insert2;
	        return $request;
		}

	}
 ?>
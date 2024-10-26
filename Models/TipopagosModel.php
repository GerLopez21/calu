<?php 

	class TipopagosModel extends Mysql
	{
	
		public $intIdTipopago;
		public $strNombre;
		public $strDescripcion;

		public function __construct()
		{
			parent::__construct();
		}

		public function getTipopagos()
		{
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1 ){
				$whereAdmin = " and idrol != 1 ";
			}
			//EXTRAE ROLES
			$sql = "SELECT * FROM tipopago";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectTipopago(int $idTipopago)
		{

			$this->intIdTipopago = $idTipopago;
			$sql = "SELECT * FROM tipopago WHERE idtipopago = $this->intIdTipopago";
			$request = $this->select($sql);
			return $request;
		}

		public function insertColor(string $tipopago, string $codigo){

			$return = "";
			$this->strNombre = $tipopago;
			$this->strDescripcion = $descripcion;


			$sql = "SELECT * FROM tipopago WHERE tipopago = '{$this->strDescripcion}' ";

			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO tipopago(tipopago,descripcion) VALUES(?,?)";
	        	$arrData = array($this->strNombre,$this->strDescripcion);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}	

		public function updateColor(int $idtipopago, string $nombre, string $descripcion){
			$this->intIdTipopago = idtipopago;
			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;


			$sql = "SELECT * FROM tipopago WHERE tipopago = '{$this->strNombre}' and idtipopago != $this->intIdTipopago";

			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE tipopago SET tipopago = ?, descripcion = ?  WHERE idtipopago = $this->intIdTipopago";
				$arrData = array($this->strNombre,$this->strDescripcion);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
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
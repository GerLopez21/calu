<?php 

	class TipoenviosModel extends Mysql
	{
	
		public $intIdTipoenvio;
		public $strNombre;
		public $strDescripcion;

		public function __construct()
		{
			parent::__construct();
		}

		public function getTipoenvios()
		{

			$whereAdmin = "";
			if($_SESSION['idUser'] != 1 ){
				$whereAdmin = " and idrol != 1 ";
			}
			//EXTRAE ROLES
			$sql = "SELECT * FROM tipoenvio  where fecha_baja is null";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectTipoenvio(int $idTipoenvio)
		{

			$this->intIdTipoenvio = $idTipoenvio;
			$sql = "SELECT * FROM tipoenvio WHERE idtipoenvio = $this->intIdTipoenvio";
			$request = $this->select($sql);
			return $request;
		}

		public function insertTipoEnvio(string $descripcion, string $nombre){

			$return = "";
			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;


			$sql = "SELECT * FROM tipoenvio WHERE tipoenvio = '{$this->strNombre}' ";

			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO tipoenvio(nombre,descripcion) VALUES(?,?)";
	        	$arrData = array($this->strNombre,$this->strDescripcion);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}	

		public function updateTipoenvio(int $idtipoenvio, string $nombre, string $descripcion){
			$this->intIdTipoenvio = $idtipoenvio;
			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;


			$sql = "SELECT * FROM tipoenvio WHERE nombre = '{$this->strNombre}' and idtipoenvio != $this->intIdTipoenvio";

			$request = $this->select_all($sql);
			if(empty($request))
			{
				$sql = "UPDATE tipoenvio SET nombre = ?, descripcion = ?  WHERE idtipoenvio = $this->intIdTipoenvio";
				$arrData = array($this->strNombre,$this->strDescripcion);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;			
		}

		public function deleteTipoEnvio(int $idtipoenvio)
		{
			$this->intIdTipoEnvio = $idtipoenvio;
			
			$usuario = $_SESSION['idUser'];
			$fecha = date('Y-m-d H:m:s');
		
                $sql = "update tipoenvio set fecha_baja = ?, usuario_baja = ? WHERE idtipoenvio = $this->intIdTipoEnvio";
				$arrData = array($fecha,$usuario);
				$request = $this->update($sql,$arrData);
				
				if($request)
				{
					$request = 'ok';	
				}else{
					$request = 'error';
				}
		
			return $request;
		}
	}
 ?>
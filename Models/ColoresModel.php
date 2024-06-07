<?php 

	class ColoresModel extends Mysql
	{
	
		public $intIdColor;
		public $strNombre;
		public $strCodigo;

		public function __construct()
		{
			parent::__construct();
		}

		public function getColores()
		{
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1 ){
				$whereAdmin = " and idrol != 1 ";
			}
			//EXTRAE ROLES
			$sql = "SELECT * FROM color order by nombre asc";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectColor(int $idColor)
		{
			//BUSCAR ROLE
			$this->intIdColor = $idColor;
			$sql = "SELECT * FROM color WHERE idcolor = $this->intIdColor";
			$request = $this->select($sql);
			return $request;
		}

		public function insertColor(string $nombre, string $codigo){

			$return = "";
			$this->strNombre = $nombre;
			$this->strCodigo = $codigo;


			$sql = "SELECT * FROM color WHERE nombre = '{$this->strNombre}' ";

			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO color(nombre,codigo) VALUES(?,?)";
	        	$arrData = array($this->strNombre,$this->strCodigo);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}	

		public function updateColor(int $idcolor, string $nombre, string $codigo){
			$this->intIdColor = $idcolor;
			$this->strNombre = $nombre;
			$this->strCodigo = $codigo;


			$sql = "SELECT * FROM color WHERE nombre = '$this->strNombre' AND idcolor != $this->intIdColor";

			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE color SET nombre = ?, codigo = ?  WHERE idcolor = $this->intIdColor";
				$arrData = array($this->strNombre,$this->strCodigo);
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
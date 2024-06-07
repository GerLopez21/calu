<?php 

	class TallesModel extends Mysql
	{
	
		public $intIdTalles;
		public $strRol;

		public function __construct()
		{
			parent::__construct();
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

		public function selectTalle(int $idTalle)
		{
			//BUSCAR ROLE
			$this->intIdTalle = $idTalle;
			$sql = "SELECT * FROM talles WHERE idstocktalle = $this->intIdTalle";
			$request = $this->select($sql);
			return $request;
		}

		public function insertTalle(string $nombre){

			$return = "";
			$this->strNombre = $nombre;
		

			$sql = "SELECT * FROM talles WHERE nombretalle = '{$this->strNombre}' ";

			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO talles(nombretalle) VALUES(?)";

	        	$arrData = array($this->strNombre);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;

			}else{
				$return = "exist";
			}
			return $return;
		}	

		public function updateTalle(int $idtalle, string $nombre){
			$this->intIdTalle = $idtalle;
			$this->strNombre = $nombre;
			

			$sql = "SELECT * FROM talles WHERE nombretalle = '$this->strNombre' AND idstocktalle != $this->intIdTalle";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE talles SET nombretalle = ? WHERE idstocktalle = $this->intIdTalle ";
				$arrData = array($this->strNombre);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;			
		}

		public function deleteTalle(int $idtalle)
		{
			$this->intIdTalle = $idtalle;
			$sql = "SELECT * FROM stock WHERE talleid = $this->intIdTalle";
			$request = $this->select_all($sql);

			if(empty($request))
			{
                $sql = "delete from talles WHERE idstocktalle = $this->intIdTalle";
        
				$request = $this->delete($sql);
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
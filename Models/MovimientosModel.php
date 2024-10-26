<?php 

	class MovimientosModel extends Mysql
	{
	
		public $intIdMovimientos;
		public $strRol;

		public function __construct()
		{
			parent::__construct();
		}

		public function selectMovimientos()
		{
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1 ){
				$whereAdmin = " and idrol != 1 ";
			}
			//EXTRAE ROLES
			$sql = "SELECT *,p.nombre,p.idproducto FROM movimientos_stock m
			inner join producto p on m.productoid = p.idproducto";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectMovimiento(int $idMovimiento)
		{
			//BUSCAR ROLE
			$this->intIdMovimiento = $idMovimiento;
			$sql = "SELECT * FROM movimientos_stock WHERE idmovimiento = $this->intIdMovimiento";
			$request = $this->select($sql);
			return $request;
		}

	

	
	
	}
 ?>
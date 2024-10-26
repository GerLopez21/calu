<?php 

	class Movimientos extends Controllers{
	    
		public function __construct()
		{
			parent::__construct();
			session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(MDTALLES);
		}

		public function Movimientos()
		{

			if(empty($_SESSION['permisosMod']['r'])){

				header("Location:".base_url().'/dashboard');
			}

			$data['page_id'] = 3;
			$data['page_tag'] = "movimientos";
			$data['page_name'] = "movimientos";
			$data['page_title'] = "movimientos <small> Tienda Virtual</small>";
			$data['page_functions_js'] = "functions_movimientos.js";

			$this->views->getView($this,"movimientos",$data);
		}

		public function getMovimientos()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectMovimientos();
				for ($i=0; $i < count($arrData); $i++) {

						$arrData[$i]['idmovimiento'] = $arrData[$i]['idmovimiento'];
						$arrData[$i]['tipo_movimiento'] = $arrData[$i]['tipo_movimiento'];
						if($arrData[$i]['gral_ind'] == 1)
    					{
    						$arrData[$i]['gral_ind'] = 'General';
    					}else{
    						$arrData[$i]['gral_ind'] = 'Individual';
    					}
						$arrData[$i]['procedencia'] = $arrData[$i]['procedencia'];
						$arrData[$i]['producto'] = $arrData[$i]['idproducto']." - ".$arrData[$i]['nombre'];
						$arrData[$i]['fecha'] = $arrData[$i]['fecha'];
						$arrData[$i]['cantidad'] = $arrData[$i]['cantidad'];

						$arrData[$i]['observacion'] = $arrData[$i]['observacion'];


			
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectMovimientos()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectMovimientos();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					$htmlOptions .= '<option value="'.$arrData[$i]['idstocktalle'].'">'.$arrData[$i]['nombretalle'].'</option>';
					
				}
			}
			echo $htmlOptions;
			die();		
		}

		public function getTalle(int $idtalle)
		{
			if($_SESSION['permisosMod']['r']){
				$intIdTalle = intval(strClean($idtalle));
				if($intIdTalle > 0)
				{
					$arrData = $this->model->selectTalle($intIdTalle);
					if(empty($arrData))
					{
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function setTalle(){
				$intIdTalle = intval($_POST['idtalle']);
				$strTalle =  strClean($_POST['txtNombre']);
				$request_talle = "";
				if($intIdTalle == 0)
				{
					//Crear
					if($_SESSION['permisosMod']['w']){

						$request_talle = $this->model->insertTalle($strTalle);
						$option = 1;
					}
				}else{
					//Actualizar
					if($_SESSION['permisosMod']['u']){
						$request_talle = $this->model->updatetalle($intIdTalle, $strTalle);
						$option = 2;
					}
				}

				if($request_talle > 0 )
				{
					if($option == 1)
					{
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_talle == 'exist'){
					
					$arrResponse = array('status' => false, 'msg' => '¡Atención! El Talle ya existe.');
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delTalle()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdTalle = intval($_POST['idtalle']);
					$requestDelete = $this->model->deleteTalle($intIdTalle);
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el talle');
					}else if($requestDelete == 'exist'){
						$arrResponse = array('status' => false, 'msg' => 'No se puede eliminar un talle asociado a stock.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el talle.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

	}
 ?>
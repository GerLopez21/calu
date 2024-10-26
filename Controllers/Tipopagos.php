<?php 

	class Tipopagos extends Controllers{

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
			getPermisos(MDCOLORES);
		}

		public function Tipopagos()
		{

			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_id'] = 3;
			$data['page_tag'] = "Tipopagos";
			$data['page_name'] = "tipopagos";
			$data['page_title'] = "Tipopagos <small> Tienda Virtual</small>";
			$data['page_functions_js'] = "functions_color.js";
			$this->views->getView($this,"tipopagos",$data);
		}

		public function getTipopagos()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->getTipopagos();

				for ($i=0; $i < count($arrData); $i++) {

					
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditColor" onClick="fntEditColor('.$arrData[$i]['idcolor'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelColor" onClick="fntDelColor('.$arrData[$i]['idcolor'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>
					</div>';
					}
					$arrData[$i]['options'] = '<div class="text-center"> '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectTipopagos()
		{
			$htmlOptions = "";
			$arrData = $this->model->getTipopagos();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					$htmlOptions .= '<option value="'.$arrData[$i]['idcolor'].'">'.$arrData[$i]['nombre'].'</option>';
					
				}
			}
			echo $htmlOptions;
			die();		
		}

		public function getColor(int $idcolor)
		{
			if($_SESSION['permisosMod']['r']){
				$intIdCOlor = intval(strClean($idcolor));
				if($intIdCOlor > 0)
				{
					$arrData = $this->model->selectColor($intIdCOlor);
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

		public function setColor(){
				$intIdColor = intval($_POST['idColor']);
				$strColor =  strClean($_POST['txtNombre']);
				$strCodigo =  strClean($_POST['txtCodigo']);

				$request_color = "";
				if($intIdColor == 0)
				{
					//Crear
					if($_SESSION['permisosMod']['w']){
						$request_color = $this->model->insertColor($strColor,$strCodigo);
						$option = 1;
					}
				}else{

					//Actualizar
					if($_SESSION['permisosMod']['u']){
						$request_color = $this->model->updateColor($intIdColor, $strColor,$strCodigo);
						$option = 2;
					}
				}

				if($request_color > 0 )
				{
					if($option == 1)
					{
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_color == 'exist'){
					
					$arrResponse = array('status' => false, 'msg' => '¡Atención! El Color ya existe.');
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delColor()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdcolor = intval($_POST['idcolor']);
					$requestDelete = $this->model->deleteColor($intIdcolor);
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Color');
					}else if($requestDelete == 'exist'){
						$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Color asociado a usuarios.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Color.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

	}
 ?>
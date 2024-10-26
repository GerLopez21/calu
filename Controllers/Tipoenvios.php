<?php 

	class Tipoenvios extends Controllers{

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

		public function Tipoenvios()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_id'] = 3;
			$data['page_tag'] = "Tipoenvios";
			$data['page_name'] = "tipoenvios";
			$data['page_title'] = "Tipoenvios <small> Tienda Virtual</small>";
			$data['page_functions_js'] = "functions_tipoenvios.js";

			$this->views->getView($this,"tipoenvios",$data);
		}

		public function getTipoenvios()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->getTipoenvios();

				for ($i=0; $i < count($arrData); $i++) {

					
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditTipoenvios" onClick="fntEditTipoenvio('.$arrData[$i]['idtipoenvio'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelTipoenvios" onClick="fntDelTipoenvio('.$arrData[$i]['idtipoenvio'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>
					</div>';
					}
					$arrData[$i]['options'] = '<div class="text-center"> '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectTipoenvios()
		{
			$htmlOptions = "";
			$arrData = $this->model->getTipoenvios();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					$htmlOptions .= '<option value="'.$arrData[$i]['idtipoenvio'].'">'.$arrData[$i]['nombre'].'</option>';
					
				}
			}
			echo $htmlOptions;
			die();		
		}

		public function getTipoenvio(int $idtipoenvio)
		{
			if($_SESSION['permisosMod']['r']){
				$intIdTipoenvio = intval(strClean($idtipoenvio));
				if($intIdTipoenvio > 0)
				{
					$arrData = $this->model->selectTipoenvio($intIdTipoenvio);
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

		public function setTipoenvio(){
				$intIdTipoenvio = intval($_POST['idTipoenvio']);
				$strNombre =  strClean($_POST['txtNombre']);
				$strDescripcion =  strClean($_POST['txtDescripcion']);
				$request_tipoenvio = "";
				if($intIdTipoenvio == 0)
				{
					//Crear
					if($_SESSION['permisosMod']['w']){
						$request_tipoenvio = $this->model->insertTipoenvio($strDescripcion,$strNombre);
						$option = 1;
					}
				}else{
					//Actualizar
					if($_SESSION['permisosMod']['u']){
						$request_tipoenvio = $this->model->updateTipoenvio($intIdTipoenvio, $strNombre,$strDescripcion);
						$option = 2;
					}
				}

				if($request_tipoenvio > 0 )
				{
					if($option == 1)
					{
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_tipoenvio == 'exist'){
					
					$arrResponse = array('status' => false, 'msg' => '¡Atención! El tipo de envío ya existe.');
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delTipoenvio()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdtipoenvio = intval($_POST['idtipoenvio']);
					$requestDelete = $this->model->deleteTipoenvio($intIdtipoenvio);
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el tipo de envío');
					}else if($requestDelete == 'exist'){
						$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un tipo de envío asociado a usuarios.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el tipo de envío.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

	}
 ?>
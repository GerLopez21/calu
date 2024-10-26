<?php 

	class Promociones extends Controllers{

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

		public function Promociones()
		{

			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_id'] = 3;
			$data['page_tag'] = "Promociones";
			$data['page_name'] = "promociones";
			$data['page_title'] = "Promociones <small> Tienda Virtual</small>";
			$data['page_functions_js'] = "functions_promociones.js";
			$this->views->getView($this,"promociones",$data);
		}

		public function getPromociones()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->getPromociones();
				for ($i=0; $i < count($arrData); $i++) {
                	$arrData[$i]['idpromocion'] = $arrData[$i]['idpromocion'];
					if($arrData[$i]['tipo'] == 1)
					{
						$arrData[$i]['tipo'] = '<span class="badge badge-success">2x1</span>';
					}elseif($arrData[$i]['tipo'] == 2){
						$arrData[$i]['tipo'] = '<span class="badge badge-success">3x2</span>';
					}elseif($arrData[$i]['tipo'] == 3){
						$arrData[$i]['tipo'] = '<span class="badge badge-success">3x2</span>';
					}elseif($arrData[$i]['tipo'] == 4){
						$arrData[$i]['tipo'] = '<span class="badge badge-success">4x3</span>';
					}else{
						$arrData[$i]['tipo'] = '<span class="badge badge-danger">Error</span>';

					}

					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditPromocion" onClick="fntEditPromocion('.$arrData[$i]['idpromocion'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelPromocion" onClick="fntDelPromocion('.$arrData[$i]['idpromocion'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>
					</div>';
					}
					$arrData[$i]['options'] = '<div class="text-center"> '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectPromociones()
		{
			$htmlOptions = "";
			$arrData = $this->model->getPromociones();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					$htmlOptions .= '<option value="'.$arrData[$i]['idpromocion'].'">'.$arrData[$i]['titulo'].'</option>';
					
				}
			}
			echo $htmlOptions;
			die();		
		}

		public function getPromocion(int $idpromocion)
		{
			if($_SESSION['permisosMod']['r']){
				$intIdPromocion = intval(strClean($idpromocion));
				if($intIdPromocion > 0)
				{
					$arrData = $this->model->selectPromocion($intIdPromocion);
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

		public function setPromocion(){
                
                $listCategorias = array();
                $listProductos = array();
                $idPromocion = intval($_POST['idpromocion']);
				if(isset($_POST['listCategoria'])){
                    $listCategorias = $_POST['listCategoria'];
				}
				if(isset($_POST['listProductos'])){
                    $listProductos = $_POST['listProductos'];
				}

               
                $estado =  intval($_POST['listStatus']);
                $tipoPromocion =  intval($_POST['listTipoPromocion']);
                $minCompra =  $_POST['txtMinCompra'];
                $minProductos =  $_POST['txtMinProductos'];
                $stockPromo = $_POST['txtStockPromo'];
                $tipoPago =  $_POST['txtTipoPago'];
                $fechaInicio = $_POST['txtFechaInicio'];
                $fechaFin = $_POST['txtFechaFin'];
                $combinableCat = $_POST['listCombinableCat'];
                $combinableVariado = $_POST['listCombinableVariado'];
				$aplicabilidad = $_POST['listAplicabilidad'];
				$montoPromo = $_POST['txtMontoFijo'];

				$request_promocion = "";
				if($idPromocion == 0)
				{
					//Crear
					if($_SESSION['permisosMod']['w']){
						$request_promocion = $this->model->insertPromocion($aplicabilidad,$listProductos, $listCategorias,$estado,$tipoPromocion,$minCompra,$minProductos,$stockPromo,$tipoPago,$fechaInicio,$fechaFin,$combinableCat,$combinableVariado);
						$option = 1;
					}
				}else{

					//Actualizar
					if($_SESSION['permisosMod']['u']){
						$request_promocion = $this->model->updatePromocion($idPromocion,$aplicabilidad,$listProductos, $listCategorias,$estado,$tipoPromocion,$combinableCat,$combinableVariado,$minCompra,$minProductos,$stockPromo,$tipoPago, $fechaInicio,$fechaFin,$montoPromo);
						$option = 2;
					}
				}

				if($request_promocion > 0 )
				{
					if($option == 1)
					{
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_promocion == 'exist'){
					
					$arrResponse = array('status' => false, 'msg' => '¡Atención! El Nombre de la promoción ya fue usado.');
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
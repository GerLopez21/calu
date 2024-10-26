<?php 


	class Cupones extends Controllers{

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

		public function Cupones()
		{

			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_id'] = 3;
			$data['page_tag'] = "Cupones y promos";
			$data['page_name'] = "Cupones y promos";
			$data['page_title'] = "Cupones y promos <small> Tienda Virtual</small>";
			$data['page_functions_js'] = "functions_cupones.js";
			$this->views->getView($this,"cupones",$data);
		}

		public function getCupones()
		{

			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->getCupones();
				for ($i=0; $i < count($arrData); $i++) {
                	$arrData[$i]['idcupon'] = $arrData[$i]['idcupon'];
            		$arrData[$i]['nombre'] = $arrData[$i]['nombre'];
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditCupon" onClick="fntEditCupon('.$arrData[$i]['idcupon'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelCupon" onClick="fntDelCupon('.$arrData[$i]['idcupon'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>
					</div>';
					}
					$arrData[$i]['options'] = '<div class="text-center"> '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectCupones()
		{
			$htmlOptions = "";
			$arrData = $this->model->getCupones();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					$htmlOptions .= '<option value="'.$arrData[$i]['idcupon'].'">'.$arrData[$i]['nombre'].'</option>';
					
				}
			}
			echo $htmlOptions;
			die();		
		}

		public function getCupon(int $idCupon)
		{
			if($_SESSION['permisosMod']['r']){
				$intIdCupon = intval(strClean($idCupon));
				if($intIdCupon > 0)
				{
					$arrData = $this->model->selectCupon($intIdCupon);
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

		public function setCupon(){
                $error = false;
				$error_msg = null;
                $listCategorias = array();
                $listProductos = array();
                $idCupon = intval($_POST['idcupon']);
				$strTitulo =  strtoupper(strClean($_POST['txtTitulo']));
				if(isset($_POST['listCategoria'])){
                    $listCategorias = $_POST['listCategoria'];
				}else{
					$listCategorias = "todas";
				}
				if(isset($_POST['listProductos'])){
                    $listProductos = $_POST['listProductos'];
				}else{
					$listProductos = "todos";
				}
                if($_POST['listTipoCupon'] == 1){
                    $montoFijo = $_POST['txtMontoFijo'];
                    $porcDescuento = 0;
                    $envioGratis = 0;
					if($montoFijo == null){
						$error = true;
						$error_msg = "No se declaró monto fijo para el cupón";
					}
                }else if($_POST['listTipoCupon'] == 2){
                    $montoFijo = 0;
                    $porcDescuento = $_POST['txtPorcentajeCupon'];
                    $envioGratis = 0;
					if($porcDescuento == null){
						$error = true;
						$error_msg = "No se declaró porcentaje de descuento para el cupón";
					}
                }else if($_POST['listTipoCupon'] ==3 ){
                    $montoFijo = 0;
                    $porcDescuento = 0;
                    $envioGratis = 1;
                }else{
					$error = true;
					$error_msg = "No se declaró el tipo de cupón";
				}
                $estado =  intval($_POST['listStatus']);
                $tipoDescuento =  intval($_POST['listTipoCupon']);
				if($_POST['txtMinCompra'] == ''){
					$minCompra = null;
				}else{
					$minCompra =  $_POST['txtMinCompra'];
				}
				if($_POST['txtMinProductos'] == ''){
					$minProductos = null;
				}else{
					$minProductos =  $_POST['txtMinProductos'];
				}
				if($_POST['txtStockPromo'] == ''){
					$stockPromo = null;
				}else{
					$stockPromo =  $_POST['txtStockPromo'];
				}
				if($_POST['txtStockPromo'] == ''){
					$stockPromo = null;
				}else{
					$stockPromo =  $_POST['txtStockPromo'];
				}
				
				if($_POST['txtFechaInicio'] == ''){
					$fechaInicio = null;
				}else{
					$fechaInicio =  $_POST['txtFechaInicio'];
				}
				if($_POST['txtFechaFin'] == ''){
					$fechaFin = null;
				}else{
					$fechaFin =  $_POST['txtFechaFin'];
				}
                if($error == false){
				
					$request_cupon = "";
					if($idCupon == 0)
					{
						//Crear
						if($_SESSION['permisosMod']['w']){
							$request_cupon = $this->model->insertCupon($strTitulo,$listProductos, $listCategorias,$estado,$tipoDescuento,$minCompra,$minProductos,$stockPromo,$fechaInicio,$fechaFin,$montoFijo,$porcDescuento,$envioGratis);
							$option = 1;
						}
					}else{
	
						//Actualizar
						if($_SESSION['permisosMod']['u']){
							$request_cupon = $this->model->updateCupon($idCupon,$strTitulo,$listProductos, $listCategorias,$estado,$tipoDescuento,$minCompra,$minProductos,$stockPromo,$fechaInicio,$fechaFin,$montoFijo,$porcDescuento,$envioGratis);
							$option = 2;
						}
					}
					if($request_cupon > 0  || $request_cupon != 'exist')
					{

						if($option == 1)
						{
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
						}
					}else if($request_cupon == 'exist'){
						
						$arrResponse = array('status' => false, 'msg' => '¡Atención! El Nombre del cupón ya fue usado.');
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}	
				}else{
					$arrResponse = array("status" => false, "msg" => $error_msg);

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
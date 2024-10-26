<?php 


	class Descuentos extends Controllers{

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

		public function Descuentos()
		{

			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_id'] = 3;
			$data['page_tag'] = "Descuentos y promos";
			$data['page_name'] = "descuentos y promos";
			$data['page_title'] = "Descuentos y promos <small> Tienda Virtual</small>";
			$data['page_functions_js'] = "functions_descuentos.js";
			$this->views->getView($this,"descuentos",$data);
		}

		public function getDescuentos()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->getDescuentos();
				for ($i=0; $i < count($arrData); $i++) {
                	$arrData[$i]['iddescuento'] = $arrData[$i]['iddescuento'];
            		$arrData[$i]['titulo'] = $arrData[$i]['titulo'];
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditDescuento" onClick="fntEditDescuento('.$arrData[$i]['iddescuento'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelDescuento" onClick="fntDelDescuento('.$arrData[$i]['iddescuento'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>
					</div>';
					}
					$arrData[$i]['options'] = '<div class="text-center"> '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectDescuentos()
		{
			$htmlOptions = "";
			$arrData = $this->model->getDescuentos();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					$htmlOptions .= '<option value="'.$arrData[$i]['iddescuento'].'">'.$arrData[$i]['titulo'].'</option>';
					
				}
			}
			echo $htmlOptions;
			die();		
		}

		public function getDescuento(int $iddescuento)
		{
			if($_SESSION['permisosMod']['r']){
				$intIdDescuento = intval(strClean($iddescuento));
				if($intIdDescuento > 0)
				{
					$arrData = $this->model->selectDescuento($intIdDescuento);
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

		public function setDescuento(){
                
                $listCategorias = array();
                $listProductos = array();
                $idDescuento = intval($_POST['iddescuento']);
				$strTitulo =  strClean($_POST['txtTitulo']);
				if(isset($_POST['listCategoria'])){
                    $listCategorias = $_POST['listCategoria'];
				}
				if(isset($_POST['listProductos'])){
                    $listProductos = $_POST['listProductos'];
				}
                if($_POST['listTipoDescuento'] == 1){
                    $montoFijo = $_POST['txtMontoFijo'];
                    $porcDescuento = 0;
                    $envioGratis = 0;
                }else if($_POST['listTipoDescuento'] == 2){
                    $montoFijo = 0;
                    $porcDescuento = $_POST['txtPorcentajeDescuento'];
                    $envioGratis = 0;
                }else if($_POST['listTipoDescuento'] ==3 ){
                    $montoFijo = 0;
                    $porcDescuento = 0;
                    $envioGratis = 1;
                }
                $estado =  intval($_POST['listStatus']);
                $tipoDescuento =  intval($_POST['listTipoDescuento']);
                $minCompra =  $_POST['txtMinCompra'];
                $minProductos =  $_POST['txtMinProductos'];
                $stockPromo = $_POST['txtStockPromo'];
                $tipoPago =  $_POST['txtTipoPago'];
                $fechaInicio = $_POST['txtFechaInicio'];
                $fechaFin = $_POST['txtFechaFin'];


                
				$request_descuento = "";
				if($idDescuento == 0)
				{
					//Crear
					if($_SESSION['permisosMod']['w']){
						$request_descuento = $this->model->insertDescuento($strTitulo,$listProductos, $listCategorias,$estado,$tipoDescuento,$minCompra,$minProductos,$stockPromo,$tipoPago,$fechaInicio,$fechaFin,$montoFijo,$porcDescuento,$envioGratis);
						$option = 1;
					}
				}else{

					//Actualizar
					if($_SESSION['permisosMod']['u']){
						$request_descuento = $this->model->updateDescuento($idDescuento,$strTitulo,$listProductos, $listCategorias,$estado,$tipoDescuento,$minCompra,$minProductos,$stockPromo,$tipoPago,$fechaInicio,$fechaFin,$montoFijo,$porcDescuento,$envioGratis);
						$option = 2;
					}
				}

				if($request_descuento > 0 )
				{
					if($option == 1)
					{
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_descuento == 'exist'){
					
					$arrResponse = array('status' => false, 'msg' => '¡Atención! El Nombre del descuento ya fue usado.');
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
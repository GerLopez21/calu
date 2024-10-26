<?php 

require_once("Models/TTipoPago.php"); 
class Pedidos extends Controllers{
	use TTipoPago;
	public function __construct()
	{
		parent::__construct();
		session_start();
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/login');
			die();
		}
		getPermisos(MPEDIDOS);
	}

	public function Pedidos()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Pedidos";
		$data['page_title'] = "PEDIDOS <small>Tienda Virtual</small>";
		$data['page_name'] = "pedidos";
		$data['page_functions_js'] = "functions_pedidos.js";
		$this->views->getView($this,"pedidos",$data);
	}

	public function getPedidos(){
		if($_SESSION['permisosMod']['r']){
			$idpersona = "";
			if( $_SESSION['userData']['idrol'] == RCLIENTES ){
				$idpersona = $_SESSION['userData']['idpersona'];
			}
			$arrData = $this->model->selectPedidos($idpersona);
		//	
			for ($i=0; $i < count($arrData); $i++) {
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				
				$arrData[$i]['asd'] = $arrData[$i]['idpedido'];
				$arrData[$i]['monto'] = SMONEY.formatMoney($arrData[$i]['monto']);
				$arrData[$i]['tipopago'] = $arrData[$i]['tipopago'];
				$arrData[$i]['fecha'] = $arrData[$i]['fecha'];
				$arrData[$i]['tipo_envio'] = $arrData[$i]['tipo_envio'];
				$arrData[$i]['nombre_cliente'] = $arrData[$i]['nombre_cliente'];
				$arrData[$i]['apellido_cliente'] = $arrData[$i]['apellido_cliente'];
				$arrData[$i]['dni_cliente'] = $arrData[$i]['dni_cliente'];
				$arrData[$i]['telefono_cliente'] = $arrData[$i]['telefono_cliente'];

				
				if($_SESSION['permisosMod']['r']){
					
					$btnView .= ' <a title="Ver Detalle" href="'.base_url().'/pedidos/orden/'.$arrData[$i]['idpedido'].'" target="_blanck" class="btn btn-info btn-sm"> <i class="far fa-eye"></i> </a>

						<a title="Generar PDF" href="'.base_url().'/factura/generarFactura/'.$arrData[$i]['idpedido'].'" target="_blanck" class="btn btn-danger btn-sm"> <i class="fas fa-file-pdf"></i> </a> ';

					
				}
				if($_SESSION['permisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idpedido'].')" title="Editar pedido"><i class="fas fa-pencil-alt"></i></button>';
				}
				$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function orden($idpedido){
		if(!is_numeric($idpedido)){
			header("Location:".base_url().'/pedidos');
		}
		if(empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard');
		}
		$idpersona = "";
		if( $_SESSION['userData']['idrol'] == RCLIENTES ){
			$idpersona = $_SESSION['userData']['idpersona'];
		}
		
		$data['page_tag'] = "Pedido - Tienda Virtual";
		$data['page_title'] = "PEDIDO <small>Tienda Virtual</small>";
		$data['page_name'] = "pedido";
		$data['arrPedido'] = $this->model->selectPedido($idpedido,$idpersona);
		$this->views->getView($this,"orden",$data);
	}

	public function transaccion($transaccion){
		if(empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard');
		}
		$idpersona = "";
		if( $_SESSION['userData']['idrol'] == RCLIENTES ){
			$idpersona = $_SESSION['userData']['idpersona'];
		}
		$requestTransaccion = $this->model->selectTransPaypal($transaccion,$idpersona);	
		$data['page_tag'] = "Detalles de la transacción - Tienda Virtual";
		$data['page_title'] = "Detalles de la transacción";
		$data['page_name'] = "detalle_transaccion";
		$data['page_functions_js'] = "functions_pedidos.js";
		$data['objTransaccion'] = $requestTransaccion;
		$this->views->getView($this,"transaccion",$data);
	}

	public function getTransaccion(string $transaccion){
		if($_SESSION['permisosMod']['r'] and $_SESSION['userData']['idrol'] != RCLIENTES){
			if($transaccion == ""){
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{
				$transaccion = strClean($transaccion);
				$requestTransaccion = $this->model->selectTransPaypal($transaccion);
				if(empty($requestTransaccion)){
					$arrResponse = array("status" => false, "msg" => "Datos no disponibles.");
				}else{
					$htmlModal = getFile("Template/Modals/modalReembolso",$requestTransaccion);
					$arrResponse = array("status" => true, "html" => $htmlModal);
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function setReembolso(){
		if($_POST){
			if($_SESSION['permisosMod']['u'] and $_SESSION['userData']['idrol'] != RCLIENTES){
				//dep($_POST);
				$transaccion = strClean($_POST['idtransaccion']);
				$observacion = strClean($_POST['observacion']);
				$requestTransaccion = $this->model->reembolsoPaypal($transaccion,$observacion);
				if($requestTransaccion){
					$arrResponse = array("status" => true, "msg" => "El reembolso se ha procesado.");
				}else{
					$arrResponse = array("status" => false, "msg" => "No es posible procesar el reembolso.");
				}
			}else{
				$arrResponse = array("status" => false, "msg" => "No es posible realizar el proceso, consulte al administrador.");
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getPedido(string $pedido){
		if($_SESSION['permisosMod']['u'] and $_SESSION['userData']['idrol'] != RCLIENTES){
			if($pedido == ""){
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{

				$requestPedido = $this->model->selectPedido($pedido,"");
				if(empty($requestPedido)){
					$arrResponse = array("status" => false, "msg" => "Datos no disponibles.");
				}else{
					$requestPedido['tipospago'] = $this->getTiposPagoT();

					$htmlModal = getFile("Template/Modals/modalPedido",$requestPedido);
					$arrResponse = array("status" => true, "html" => $htmlModal);
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function setPedido(){
		if($_POST){
			if($_SESSION['permisosMod']['u'] and $_SESSION['userData']['idrol'] != RCLIENTES){
        
                $flag = false;
				$idpedido = !empty($_POST['idpedido']) ? intval($_POST['idpedido']) : "";
				$estado = !empty($_POST['listEstado']) ? strClean($_POST['listEstado']) : "";
				$idtipopago =  !empty($_POST['listPago']) ? strClean($_POST['listPago']) : "";
				$mail = !empty($_POST['txtEmail']) ? strClean($_POST['txtEmail']) : "";
				$envio = !empty($_POST['listEnvio']) ? strClean($_POST['listEnvio']) : "";
				$direccion = !empty($_POST['txtDireccion']) ? strClean($_POST['txtDireccion']) : "";
				$telefono = !empty($_POST['txtTelefono']) ? strClean($_POST['txtTelefono']) : "";
				$monto = !empty($_POST['txtMonto']) ? strClean($_POST['txtMonto']) : NULL;
				$transaccion = !empty($_POST['txtTransaccion']) ? strClean($_POST['txtTransaccion']) : "";
				$fecha_pago = null;
				$codigo_seguimiento = !empty($_POST['txtSeguimiento']) ? strClean($_POST['txtSeguimiento']) : "";
				$codigo = strtoupper($codigo_seguimiento);
    			$fecha_retiro = !empty($_POST['txtRetiro']) ? strClean($_POST['txtRetiro']) : "";
                $fecha_envio = null;
		        
                if($envio == "Retiro centro"){
                    $envio = 1;
                }
                if($envio == "Envio domicilio"){
                    $envio = 2;
                }
                if($envio == "Envio correo"){
                    $envio = 3;
                }
                if($envio == "Retiro showroom"){
                    $envio = 4;
                }
                if($idtipopago == "Acordar"){
                    $idtipopago = 6;
                }
                if($idtipopago == "Transferencia"){
                    $idtipopago = 7;
                }
                if($idtipopago == "Efectivo"){
                    $idtipopago = 2;
                }
                 if($idtipopago == "Debito"){
                    $idtipopago = 3;
                }
                 if($idtipopago == "Credito"){
                    $idtipopago = 3;
                }
				if($idpedido == ""){

					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					if($idtipopago == ""){
						if($estado == ""){
							$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
						}else{
							$requestPedido = $this->model->updatePedido($idpedido,null,null,$idtipopago,$estado,idtipo);
							
							if($requestPedido){
							    $flag =true;
								$arrResponse = array("status" => true, "msg" => "Datos actualizados correctamente");
							}else{
								$arrResponse = array("status" => false, "msg" => "No es posible actualizar la información.");
							}
						}
					}else{
						if($idtipopago =="" or $estado == ""){
							$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
						}else{

							$requestPedido = $this->model->updatePedido($idpedido,$monto,$transaccion,$idtipopago,$estado,$mail,$envio,$direccion,$telefono,$fecha_pago,$cod_seguimiento,$fecha_retiro,$fecha_envio);

							if($requestPedido){
							    $flag = true;
								$arrResponse = array("status" => true, "msg" => "Datos actualizados correctamente");
							}else{
								$arrResponse = array("status" => false, "msg" => "No es posible actualizar la información.");
							}
						}
					}
				}
				if($flag == true){
				    if($estado == "Confirmado"){

                		            $fecha_pago = date('Y-m-d H:i');
                		            $dataEmailOrden = array('asunto' => "Se ha confirmado el pago de tu orden No.".$idpedido,
                													'email' => $mail, 
                													'emailCopia' => EMAIL_PEDIDOS,
                													'envio'=>$envio);
                							sendEmail($dataEmailOrden,"email_notificacion_pago");
                		        }
                                if($estado == "Completo"){
                		            $fecha_envio = date('Y-m-d H:i');
                		            $dataEmailOrden = array('asunto' => "Ya realizamos el despacho de tu orden ".$idpedido,
                													'email' => $mail, 
                													'emailCopia' => EMAIL_PEDIDOS,
                													'envio'=>$envio,'codigo'=>$codigo);
                							sendEmail($dataEmailOrden,"email_notificacion_envio");
                		        }
                		        if($estado == "Cancelado"){
                		            
                
                		            	$request_detalle = $this->model->selectDetallesPedido($idpedido);
                                        foreach($request_detalle as $detalle){
                                            $idproducto = $detalle['productoid'];
                                            
                                            $cantidad = $detalle['cantidad'];
                                            $talle = null;
                                            $color = null;
                                            if($detalle['talle'] != null){
                                                $talle = $detalle['talle'];
                    		            	$request_talle = $this->model->selectTalle($talle);
                                                $talle = $request_talle['idstocktalle'];
                
                
                                            }
                                            if($detalle['color'] != null){
                                            $color = $detalle['color'];
                                            $request_color = $this->model->selectColor($color);
                        	            	$color = $request_color['idcolor'];
                
                                            }
                                                
                
                		                    $requestPedido = $this->model->updateStockCancelado($idproducto,$talle,$color,$cantidad,$idpedido);
                                        }
                                        
                                        $dataEmailOrden = array('asunto' => "Hemos cancelado tu pedido Número: ".$idpedido,
                													'email' => $mail, 
                													'emailCopia' => EMAIL_PEDIDOS,
                													'envio'=>$envio,'codigo'=>$codigo);
                							sendEmail($dataEmailOrden,"email_notificacion_cancelacion");
                		        }
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}
}
 ?>
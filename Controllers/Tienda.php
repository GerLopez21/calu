<?php 
	require_once("Models/TCategoria.php");
	require_once("Models/TProducto.php");
	require_once("Models/TCliente.php");
	require_once("Models/LoginModel.php");


	class Tienda extends Controllers{
		use TCategoria, TProducto, TCliente;
		public $login;
		public function __construct()
		{
			parent::__construct();
			session_start();
			$this->login = new LoginModel();
		}

		public function tienda()
		{
		    $inactive = inactive();
		    if($inactive == 1 && empty($_SESSION['login'])){
		      header("Location:".base_url_inactive());

		    }	
		    
		    
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "tienda";
			//$data['productos'] = $this->getProductosT();
			$pagina = 1;
			$cantProductos = $this->cantProductos();
			$total_registro = $cantProductos['total_registro'];
			$desde = ($pagina-1) * PROPORPAGINA;
			$total_paginas = ceil($total_registro / PROPORPAGINA);
			$data['productos'] = $this->getProductosPage($desde,PROPORPAGINA);
			//dep($data['productos']);exit;
			$data['pagina'] = $pagina;
			$data['total_paginas'] = $total_paginas;
			$data['categorias'] = $this->getCategorias();
			$this->views->getView($this,"tienda",$data);
		}
			public function inactive()
		{
		    
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "Inactiva";
			$this->views->getView($this,"inactive",$data);
		}

		public function categoria($params){
			if(empty($params)){
				header("Location:".base_url_inactive());
			}else{
			    $inactive = inactive();
		    if($inactive == 1 && empty($_SESSION['login'])){
		      header("Location:".base_url_inactive());

		    }	
		    
		    
				$arrParams = explode(",",$params);
				$idcategoria = intval($arrParams[0]);

				$ruta = strClean($arrParams[1]);
				$pagina = 1;
				if(count($arrParams) > 2 AND is_numeric($arrParams[2])){
					$pagina = $arrParams[2];
				}

				$cantProductos = $this->cantProductos($idcategoria);
				$total_registro = $cantProductos['total_registro'];
				$desde = ($pagina-1) * PROCATEGORIA;
				$total_paginas = ceil($total_registro / PROCATEGORIA);
				$infoCategoria = $this->getProductosCategoriaT($idcategoria,$ruta,$desde,PROCATEGORIA);
				$categoria = strClean($params);
				$data['page_tag'] = NOMBRE_EMPESA." - ".$infoCategoria['categoria'];
				$data['page_title'] = $infoCategoria['categoria'];
				$data['page_name'] = "categoria";
				$data['productos'] = $infoCategoria['productos'];
				$data['infoCategoria'] = $infoCategoria;
				$data['pagina'] = $pagina;
				$data['ruta'] = $ruta;
				$data['total_paginas'] = $total_paginas;
				$data['categorias'] = $this->getCategorias();
				$this->views->getView($this,"categoria",$data);
			}
		}
    	public function orderby($params){
			if(empty($params)){
				header("Location:".base_url());
			}else{
			    $inactive = inactive();
    		    if($inactive == 1 && empty($_SESSION['login'])){
    		      header("Location:".base_url_inactive());
    
    		    }	

		    
				$arrParams = explode(",",$params);

				if(count($arrParams) == 2){
				   $idorden = intval($arrParams[1]); 
				   $categoria=$arrParams[0];  
                    $cat = str_replace("-"," ",$categoria);
				}else{
				    $idorden = intval($arrParams[0]);
				}
				
				$ruta = strClean($arrParams[1]);
				$pagina = 1;
				if(count($arrParams) > 2 AND is_numeric($arrParams[2])){
					$pagina = $arrParams[2];
				}

//				$cantProductos = $this->cantProductos($idcategoria);
//				$total_registro = $cantProductos['total_registro'];
//				$desde = ($pagina-1) * PROCATEGORIA;
//				$total_paginas = ceil($total_registro / PROCATEGORIA);
				$ordenados = $this->getProductosOrdenados($idorden,$categoria);
//				$categoria = strClean($params);
				$data['page_tag'] = NOMBRE_EMPESA;
				$data['page_title'] = NOMBRE_EMPESA;
				$data['page_name'] = "Productos ordenados";
//				$data['productos'] = $infoCategoria['productos'];
//				$data['infoCategoria'] = $infoCategoria;
				$data['pagina'] = $pagina;
                $data['productos'] = $ordenados['productos'];
				$data['total_paginas'] = 1;
				$data['categorias'] = $this->getCategorias();
				$this->views->getView($this,"orderby",$data);
			}
		}
			public function getColoresTalleStockAjax(){

        if($_POST != null){

            $producto = $_POST['producto'];
			$talle = $_POST['talle'];

            $requestStock = $this->getStockAjax($talle,$producto);
            $j = 0;
                        	                $arrGeneral = null;

            	for ($i=0; $i < count($requestStock); $i++) {

				                        $j++;
				     $arrData[$i]['status'] = true;
                    $arrData[$i]['idstock'] = $requestStock[$i]['idstock'];
                    $arrData[$i]['cantidad'] = $requestStock[$i]['cantidad'];
                    $arrData[$i]['talleid'] = $requestStock[$i]['talleid'];
                    $arrData[$i]['colorid'] = $requestStock[$i]['colorid'];
                    $arrData[$i]['productoid'] = $requestStock[$i]['productoid'];
                    $arrData[$i]['fotoreferencia'] = $requestStock[$i]['fotoreferencia'];
                    $arrData[$i]['nombre'] = $requestStock[$i]['nombre'];

                    $arrData[$i]['veces'] = $j;
	                $arrResponse = array("status" => true, 
	                

								
									"cantidad" => '2'
								);
									                $arrGeneral[$i] = $arrData[$i];

							//	$arrData = $arrData[0];

				  }
				echo json_encode($arrGeneral,JSON_UNESCAPED_UNICODE);

        }
	}
		public function producto($params){
			if(empty($params)){
				header("Location:".base_url());
			}else{
			    $inactive = inactive();
    		    if($inactive == 1 && empty($_SESSION['login'])){
    		      header("Location:".base_url_inactive());
    
    		    }	
		    
		    
				$arrParams = explode(",",$params);
				$idproducto = intval($arrParams[0]);
				$ruta = strClean($arrParams[1]);
				$infoProducto = $this->getProductoT($idproducto,$ruta);
				if(empty($infoProducto)){
					header("Location:".base_url());
				}
				$stockProducto = $this->selectStockProducto($idproducto);
				$tallesProducto = $this->selectTallesProducto($idproducto);
                
                // $ordenPersonalizado = array(
                // 'XS' => 1, // Definimos 'S' como 1
                // 'S' => 2,  // Definimos 'M' como 2
                // 'M'=> 3,
                // 'L'=>4,
                // 'XL'=>5,
                // 'XXL'=>6
                // );
                
                // // Función de comparación para ordenar el array
                // usort($tallesProducto, function($a, $b) use ($ordenPersonalizado) {
                //     return $ordenPersonalizado[$a['nombretalle']] - $ordenPersonalizado[$b['nombretalle']];
                // });
                
 
			//	$coloresProducto = $this->selectColoresTalle($idproducto,$tallesProducto);
				
				$data['page_tag'] = NOMBRE_EMPESA." - ".$infoProducto['nombre'];
				$data['page_title'] = $infoProducto['nombre'];
				$data['page_name'] = "producto";
				$data['producto'] = $infoProducto;
				$data['stock'] = $stockProducto;
				$data['tallesycolores'] = $tallesProducto;
            
			
			//	$data['colores'] = $colores;
				$data['productos'] = $this->getProductosRandom($infoProducto['categoriaid'],8,"r");
				$this->views->getView($this,"producto",$data);
			}
		}

		public function addCarrito(){
			if($_POST){
				//unset($_SESSION['arrCarrito']);exit;
				$error = false;
				$arrCarrito = array();
                $idtalle = null;
                $idcolor=null;
				$cantCarrito = 0;
                $fotoreferencia=$_POST['fotoreferencia'];
				$idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
				$cantidad = $_POST['cant'];
				$talle = $_POST['talle'];
				$color = $_POST['color'];
                $flag_error = false;
				dep($_POST);die;
				if($talle != "null"){

				    $idtalle = $this->getIdTalle($talle);
				}

				if($color != "null"){
				$idcolor = $this->getIdColor($color);
				    
				}

				$arrBaseProducto = $this->selectProducto($idproducto,$idtalle,$idcolor);

				 if($arrBaseProducto['obl_talle_color']== 1){

                      if($idtalle == null || $idcolor == null){
					        	$arrResponse = array("status" => false, "msg" => 'Debe seleccionar un talle y un color');
								$flag_error= true;
					    }
					  
				    }

			if($flag_error == false){
				if(is_numeric($idproducto) and is_numeric($cantidad)){
				   
					$arrInfoProducto = $this->getProductoIDT($idproducto);
                        
						if(!empty($arrInfoProducto)){
                        
                        if($arrBaseProducto['obl_talle_color']== 1){

							$arrProducto = array('idproducto' => $idproducto,
												'producto' => $arrInfoProducto['nombre'],
												'cantidad' => $cantidad, 
												'talle' => $idtalle,
												'color' => $idcolor,
												'preciodescuento'=>$arrInfoProducto['preciodescuento'],
												'precio' => $arrInfoProducto['precio'],
												'imagen' => $arrInfoProducto['images'][$fotoreferencia]['url_image'],
												'nombrecolor' =>$color,
												'nombretalle' =>$talle,
												'stock' =>$arrBaseProducto['cantidad'],
											);

							if(isset($_SESSION['arrCarrito'])){
								$on = true;
								$arrCarrito = $_SESSION['arrCarrito'];

								for ($pr=0; $pr < count($arrCarrito); $pr++) {

									if($arrCarrito[$pr]['idproducto'] == $idproducto){
											 					  
										if($arrCarrito[$pr]['talle'] == $arrBaseProducto['talleid']){
                                                          
            									if($arrCarrito[$pr]['color'] == $arrBaseProducto['colorid']){

        										$arrCarrito[$pr]['cantidad'] += $cantidad;
        										$arrCarrito[$pr]['talle'] == $talle;
        										$on = false;


                                  
    											if($arrBaseProducto['cantidad'] < $arrCarrito[$pr]['cantidad']){
    												$arrResponse = array("status" => false, "msg" => 'Se ha excedido de la cantidad del producto');
    												$error= true;
    					
    											}
										
										    }
										}
	                                            if($arrBaseProducto['cantidad'] < $cantidad){
												$arrResponse = array("status" => false, "msg" => 'Se ha excedido de la cantidad del producto');
												$error= true;
					
										    	}
									}
									          
								}
                                                 if($arrBaseProducto['cantidad'] < $cantidad){
												$arrResponse = array("status" => false, "msg" => 'Se ha excedido de la cantidad del producto');
												$error= true;
					
										    	}
								if($on){

								}
								if(!$error){
								    array_push($arrCarrito,$arrProducto);

									$_SESSION['arrCarrito'] = $arrCarrito;
								}
							}else{
							    

							    if($arrBaseProducto['cantidad'] < $cantidad){
												$arrResponse = array("status" => false, "msg" => 'Se ha excedido de la cantidad del producto');
												$error= true;
								}
								if(!$error){
								    array_push($arrCarrito, $arrProducto);
								    $_SESSION['arrCarrito'] = $arrCarrito;
								}
								
							}

							foreach ($_SESSION['arrCarrito'] as $pro) {
								$cantCarrito += $pro['cantidad'];
								if($pro['idproducto'] == $idproducto){
									if($pro['talle'] == $talle){
										$pro['cantidad']++;
									}
								}
							}

							$htmlCarrito ="";
							$htmlCarrito = getFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
							if($error != true){
								$arrResponse = array("status" => true, 
													"msg" => '¡Se agrego al corrito!',
													"cantCarrito" => $cantCarrito,
													"htmlCarrito" => $htmlCarrito
												);	
							}
                        }else{
                            $arrProducto = array('idproducto' => $idproducto,
												'producto' => $arrInfoProducto['nombre'],
												'cantidad' => $cantidad,
												'preciodescuento'=>$arrInfoProducto['preciodescuento'],
												'precio' => $arrInfoProducto['precio'],
												'imagen' => $arrInfoProducto['images'][0]['url_image'],
											);
						
							if(isset($_SESSION['arrCarrito'])){
								$on = true;
								$arrCarrito = $_SESSION['arrCarrito'];

								for ($pr=0; $pr < count($arrCarrito); $pr++) {

									if($arrCarrito[$pr]['idproducto'] == $idproducto){
											     $arrCarrito[$pr]['cantidad'] += $cantidad;
									        $on = false;

									}
										if($arrBaseProducto['stock'] < $arrCarrito[$pr]['cantidad']){
												$arrResponse = array("status" => false, "msg" => 'Se ha excedido de la cantidad del producto');
												$error= true;
					
											}
								}
                                
								
								if(!$error){
								    if($on){
									    array_push($arrCarrito,$arrProducto);

								    }
									$_SESSION['arrCarrito'] = $arrCarrito;
								}
							}else{

							    if($arrBaseProducto['stock'] < $cantidad){
												$arrResponse = array("status" => false, "msg" => 'Se ha excedido de la cantidad del producto');
												$error= true;
								}
								if(!$error){
								    array_push($arrCarrito, $arrProducto);
							    	$_SESSION['arrCarrito'] = $arrCarrito;
								}
							}
							foreach ($_SESSION['arrCarrito'] as $pro) {
								$cantCarrito += $pro['cantidad'];

								if($pro['idproducto'] == $idproducto){
										$pro['cantidad']++;
										
									
								}
							}
							$htmlCarrito ="";
							$htmlCarrito = getFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
							if($error != true){
								$arrResponse = array("status" => true, 
													"msg" => '¡Se agrego al corrito!',
													"cantCarrito" => $cantCarrito,
													"htmlCarrito" => $htmlCarrito
												);	
							}
                        }
						}else{
							$arrResponse = array("status" => false, "msg" => 'Producto no existente.');
						}
				}else{
					$arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
				}
			}

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delCarrito(){
			if($_POST){
				$arrCarrito = array();
				$cantCarrito = 0;
				$subtotal = 0;
				$idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
				$option = $_POST['option'];
				if(is_numeric($idproducto) and ($option == 1 or $option == 2)){
					$arrCarrito = $_SESSION['arrCarrito'];
					for ($pr=0; $pr < count($arrCarrito); $pr++) {
						if($arrCarrito[$pr]['idproducto'] == $idproducto){
							unset($arrCarrito[$pr]);
						}
					}
					sort($arrCarrito);
					$_SESSION['arrCarrito'] = $arrCarrito;
					foreach ($_SESSION['arrCarrito'] as $pro) {
						$cantCarrito += $pro['cantidad'];
						$subtotal += $pro['cantidad'] * $pro['precio'];
					}
					$htmlCarrito = "";
					if($option == 1){
						$htmlCarrito = getFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
					}
					$arrResponse = array("status" => true, 
											"msg" => '¡Producto eliminado!',
											"cantCarrito" => $cantCarrito,
											"htmlCarrito" => $htmlCarrito,
											"subTotal" => SMONEY.formatMoney($subtotal),
											"total" => SMONEY.formatMoney($subtotal + COSTOENVIO)
										);
				}else{
					$arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function updCarrito(){
			if($_POST){
				$arrCarrito = array();
				$totalProducto = 0;
				$subtotal = 0;
				$total = 0;

				$idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
				$arrBaseProducto = $this->selectProducto($idproducto);

				$cantidad = intval($_POST['cantidad']);
				if(is_numeric($idproducto) and $cantidad > 0){
					$arrCarrito = $_SESSION['arrCarrito'];
					for ($p=0; $p < count($arrCarrito); $p++) { 
						if($arrCarrito[$p]['idproducto'] == $idproducto){
							$talle = $arrCarrito[$p]['talle'];
							if($talle == '85'){
								if($arrBaseProducto['stocktalle1'] < $_POST['cantidad']){
									$cantidadTalle1 = $cantidadTalle1++;
									$arrResponse = array("status" => false, "msg" => 'Se ha excedido de la cantidad del producto');
									$error= true;
								}
							}
							if($talle == '90'){
								if($arrBaseProducto['stocktalle2'] < $_POST['cantidad']){
									$arrResponse = array("status" => false, "msg" => 'Se ha excedido de la cantidad del producto');
									$error= true;
		
								}
							}
							if($talle == '95'){
		
								if($arrBaseProducto['stocktalle3'] < $_POST['cantidad']){
		
									$arrResponse = array("status" => false, "msg" => 'Se ha excedido de la cantidad del producto');
									$error= true;
		
								}
							}
							if($talle == '100'){
								if($arrBaseProducto['stocktalle4'] < $_POST['cantidad']){
									$arrResponse = array("status" => false, "msg" => 'Se ha excedido de la cantidad del producto');
									$error= true;
		
								}
							}
							if($talle == '105'){
								if($arrBaseProducto['stocktalle5'] < $_POST['cantidad']){
									$arrResponse = array("status" => false, "msg" => 'Se ha excedido de la cantidad del producto');
									$error= true;
		
								}
							}
							if($talle == '110'){
								if($arrBaseProducto['stocktalle6'] < $_POST['cantidad']){
									$arrResponse = array("status" => false, "msg" => 'Se ha excedido de la cantidad del producto');
									$error= true;
		
								}
							}
							if($talle == '115'){
								if($arrBaseProducto['stocktalle7'] < $_POST['cantidad']){

									$arrResponse = array("status" => false, "msg" => 'Se ha excedido de la cantidad del producto');
									$error= true;
		
								}
							}
							if($talle == '120'){
								if($arrBaseProducto['stocktalle8'] < $_POST['cantidad']){
									$arrResponse = array("status" => false, "msg" => 'Se ha excedido de la cantidad del producto');
									$error= true;
		
								}
							}
							if(!$error){
							$arrCarrito[$p]['cantidad'] = $cantidad;
								$totalProducto = $arrCarrito[$p]['precio'] * $cantidad;
								break;
							}
						}
					}
					$_SESSION['arrCarrito'] = $arrCarrito;
					foreach ($_SESSION['arrCarrito'] as $pro) {
						$subtotal += $pro['cantidad'] * $pro['precio']; 
					}
					if(!$error){
					$arrResponse = array("status" => true, 
										"msg" => '¡Producto actualizado!',
										"totalProducto" => SMONEY.formatMoney($totalProducto),
										"subTotal" => SMONEY.formatMoney($subtotal),
										"total" => SMONEY.formatMoney($subtotal + COSTOENVIO)
									);
								}

				}else{
					$arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function registro(){
		   $inactive = inactive();
		    if($inactive == 1 && empty($_SESSION['login'])){
		      header("Location:".base_url_inactive());

		    }	
		    
		    
			error_reporting(0);
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmailCliente']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strEmail = strtolower(strClean($_POST['txtEmailCliente']));
					$intTipoId = RCLIENTES; 
					$request_user = "";
					
					$strPassword =  passGenerator();
					$strPasswordEncript = hash("SHA256",$strPassword);
					$request_user = $this->insertCliente($strNombre, 
														$strApellido, 
														$intTelefono, 
														$strEmail,
														$strPasswordEncript,
														$intTipoId );
					if($request_user > 0 )
					{
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						$nombreUsuario = $strNombre.' '.$strApellido;
						$dataUsuario = array('nombreUsuario' => $nombreUsuario,
											 'email' => $strEmail,
											 'password' => $strPassword,
											 'asunto' => 'Bienvenido a tu tienda en línea');
						$_SESSION['idUser'] = $request_user;
						$_SESSION['login'] = true;
						$this->login->sessionLogin($request_user);
						sendEmail($dataUsuario,'email_bienvenida');

					}else if($request_user == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el email ya existe, ingrese otro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function procesarVenta(){
		    															print_r("HOLA");die;

			if($_POST){
				$idtransaccionpaypal = NULL;
				$datospaypal = NULL;
				$personaid = $_SESSION['idUser'];
				$monto = 0;
				$tipopagoid = intval($_POST['inttipopago']);
				$direccionenvio = strClean($_POST['direccion']).', '.strClean($_POST['ciudad']);
				$status = "Pendiente";
				$subtotal = 0;
				$costo_envio = COSTOENVIO;
                $fecha_compra = date("Y-m-d H:i:sa");
				if(!empty($_SESSION['arrCarrito'])){
					foreach ($_SESSION['arrCarrito'] as $pro) {
						$subtotal += $pro['cantidad'] * $pro['precio']; 
					}
					$monto = $subtotal + COSTOENVIO;
					//Pago contra entrega
					if(empty($_POST['datapay'])){
						//Crear pedido
						$request_pedido = $this->insertPedido($idtransaccionpaypal, 
															$datospaypal, 
															$personaid,
															$costo_envio,
															$monto, 
															$tipopagoid,
															$direccionenvio, 
															$status,
															$fecha_compra);
						if($request_pedido > 0 ){

							//Insertamos detalle
							foreach ($_SESSION['arrCarrito'] as $producto) {
								$productoid = $producto['idproducto'];
								$precio = $producto['precio'];
								$cantidad = $producto['cantidad'];
								$talle = $producto['talle'];
								$color = $producto['color'];
								$this->insertDetalle($request_pedido,$productoid,$precio,$cantidad,$talle,$color);
							

								$producto = $this->getProducto($productoid);
								$this->updateProducto($productoid,$cantidad,$talle);
							}
							$infoOrden = $this->getPedido($request_pedido);
							$dataEmailOrden = array('asunto' => "Se ha creado la orden No.".$request_pedido,
													'email' => $_SESSION['userData']['email_user'], 
													'emailCopia' => EMAIL_PEDIDOS,
													'pedido' => $infoOrden );
							sendEmail($dataEmailOrden,"email_notificacion_orden");

							$orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
							$transaccion = openssl_encrypt($idtransaccionpaypal, METHODENCRIPT, KEY);
							$arrResponse = array("status" => true, 
											"orden" => $orden, 
											"transaccion" =>$transaccion,
											"msg" => 'Pedido realizado'
										);
							$_SESSION['dataorden'] = $arrResponse;
							unset($_SESSION['arrCarrito']);	
							session_regenerate_id(true);
						}
					}else{ //Pago con PayPal
						$jsonPaypal = $_POST['datapay'];
						$objPaypal = json_decode($jsonPaypal);
						$status = "Aprobado";
						if(is_object($objPaypal)){
							$datospaypal = $jsonPaypal;
							$idtransaccionpaypal = $objPaypal->purchase_units[0]->payments->captures[0]->id;
							if($objPaypal->status == "COMPLETED"){
								$totalPaypal = formatMoney($objPaypal->purchase_units[0]->amount->value);
								if($monto == $totalPaypal){
									$status = "Completo";
								}
								//Crear pedido
								$request_pedido = $this->insertPedido($idtransaccionpaypal, 
																	$datospaypal, 
																	$personaid,
																	$costo_envio,
																	$monto, 
																	$tipopagoid,
																	$direccionenvio, 
																	$status);
								if($request_pedido > 0 ){
									//Insertamos detalle
									foreach ($_SESSION['arrCarrito'] as $producto) {
										$productoid = $producto['idproducto'];
										$precio = $producto['precio'];
										$cantidad = $producto['cantidad'];
										$this->insertDetalle($request_pedido,$productoid,$precio,$cantidad);
										
										$producto = $this->getProducto($productoid);
								
										$this->updateProducto($productoid,$cantidad);
									}
									$infoOrden = $this->getPedido($request_pedido);
									print_r($infoOrden['email_cliente']);die;
									$dataEmailOrden = array('asunto' => "Se ha creado la orden No.".$request_pedido,
													'email' => $infoOrden['email_cliente'], 
													'emailCopia' => EMAIL_PEDIDOS,
													'pedido' => $infoOrden );

									sendEmail($dataEmailOrden,"email_notificacion_orden");

									$orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
									$arrResponse = array("status" => true, 
													"orden" => $orden, 
													"msg" => 'Pedido realizado'
												);
									$_SESSION['dataorden'] = $arrResponse;
									unset($_SESSION['arrCarrito']);
									session_regenerate_id(true);
								}else{
									$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
								}
							}else{
								$arrResponse = array("status" => false, "msg" => 'No es posible completar el pago con PayPal.');
							}
						}else{
							$arrResponse = array("status" => false, "msg" => 'Hubo un error en la transacción.');
						}
					}
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
				}
			}else{
				$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}
	public function procesarEnvio(){
	   $inactive = inactive();
		    if($inactive == 1 && empty($_SESSION['login'])){
		      header("Location:".base_url_inactive());

		    }	
		    
		if($_POST){
		    		    $error=false;

		    if($_POST['tipoenvio'] == 'entregalocal'){
		        if(empty($_POST['email']) || empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['telefono'])){
			    $error = true;
		        }
		        			    $tipoenvio=4;

		    }
		    if($_POST['tipoenvio'] == 'retirocentro'){
		        if(empty($_POST['email']) || empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['telefono'])){
			    $error = true; 
		        }
                			    $tipoenvio=1;

		    }
		    if($_POST['tipoenvio'] == 'enviocorreo'){
		        if(empty($_POST['email']) || empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['telefono'])){
			    $error = true; 
		        }
		        			    $tipoenvio=3;

		    }
		    if($_POST['tipoenvio'] == 'enviodomicilio'){
		        if(empty($_POST['email']) || empty($_POST['dni']) || empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['telefono'])
		        || empty($_POST['pais']) || empty($_POST['provincia']) || empty($_POST['calle']) || empty($_POST['numero'])|| empty($_POST['ciudad'])
		        || empty($_POST['codigopostal'])){
			    $error = true;
		        }
		        			    $tipoenvio=2;

		    }

			if($error == true)
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$email = ucwords(strClean($_POST['email']));
				$dni = intval(strClean($_POST['dni']));
				$pais = ucwords(strClean($_POST['pais']));
				$nombre = ucwords(strClean($_POST['nombre']));
				$apellido = ucwords(strClean($_POST['apellido']));
				$telefono = strtolower(strClean($_POST['telefono']));
				$calle = ucwords(strClean($_POST['calle']));
				$numero = strtolower(strClean($_POST['numero']));
				$barrio = ucwords(strClean($_POST['barrio']));
				$ciudad = ucwords(strClean($_POST['ciudad']));
				$codigopostal = strtolower(strClean($_POST['codigopostal']));
				$provincia = ucwords(strClean($_POST['provincia']));
				$nombreCompleto = $nombre." ".$apellido;
				$direccion = $calle." ".$numero;
				$status = "Pendiente"; 
				$request_pedido = $this->insertPedidoEnvio($tipoenvio, 
														$email, 
														$dni,
														$pais,
														$nombreCompleto,
														$telefono, 
														$direccion,
														$barrio,
														$ciudad,
														$codigopostal,
														$provincia,
														$status													);

				if($request_pedido > 0 )
				{
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
					// $dataUsuario = array('nombreUsuario' => $nombreUsuario,
					// 					 'email' => $strEmail,
					// 					 'password' => $strPassword,
					// 					 'asunto' => 'Bienvenido a tu tienda en línea');
					$_SESSION['idPedido'] = $request_pedido;
					$_SESSION['tipoenvio'] = $tipoenvio;
//					$_SESSION['login'] = true;
//					$this->login->sessionLogin($request_user);
//					sendEmail($dataUsuario,'email_bienvenida');

	
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible tomar el pedido');
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}
	public function procesarPedido(){
	   $inactive = inactive();
		    if($inactive == 1 && empty($_SESSION['login'])){
		      header("Location:".base_url_inactive());

		    }	
		    
		    

		if($_POST){
			$monto = 0;
			$status = "Pendiente";
			$subtotal = 0;
			$tipopago=$_POST['tipopago'];
            if($tipopago == "Transferencia bancaria"){
                $tipopago = 7;
            }

            if($tipopago == "Acordar pago"){
            $tipopago = 6;
            }
			if(!empty($_SESSION['arrCarrito'])){
				foreach ($_SESSION['arrCarrito'] as $pro) {
				    if($pro['preciodescuento'] > 0){
				        $monto += $pro['cantidad'] * $pro['preciodescuento']; 
				    }else{
				        $monto += $pro['cantidad'] * $pro['precio']; 
				        
				    }
				}
				$idpedido = $_SESSION['idPedido'];

					$request_pedido = $this->updatePedido($idpedido, $monto,	
																	$tipopago, 
																	
																	$status);
			
				if($request_pedido > 0){
					foreach ($_SESSION['arrCarrito'] as $producto) {
						$productoid = $producto['idproducto'];
						$precio = $producto['precio'];
						$cantidad = $producto['cantidad'];
						$talle = $producto['talle'];
						$color = $producto['color'];
                        $nombretalle = $producto['nombretalle'];
                        $nombrecolor = $producto['nombrecolor'];
						$this->insertDetalle($idpedido,$productoid,$precio,$cantidad,$nombretalle,$nombrecolor);

						$producto = $this->getProducto($productoid);
			//			$this->insertDetalle($idpedido,$productoid,$precio,$cantidad,$talle,$color);

						$this->updateProducto($productoid,$cantidad,$talle,$color);

					}

					$infoOrden = $this->getPedido($idpedido);

					$orden = openssl_encrypt($idpedido, METHODENCRIPT, KEY);

					$dataEmailOrden = array('asunto' => "Se ha creado la orden No.".$idpedido,
									'email' =>$infoOrden['orden']['email_cliente'], 
									'emailCopia' => EMAIL_PEDIDOS,
									'pedido' => $infoOrden,
									'datosCarrito'=>$_SESSION['arrCarrito'],
									'urlSeguimiento'=>'https://calu-store.com/tienda/seguimientopedido/'.$orden);

					sendEmail($dataEmailOrden,"email_notificacion_orden");


					$arrResponse = array("status" => true, 
									"orden" => $orden, 
									"tipopago" =>$tipopago,

									"msg" => 'Pedido realizado',
									"productos" => $_SESSION['arrCarrito'],
									"monto" => $monto,
									"ordenCompleta"=>$infoOrden,
								);

					$_SESSION['dataorden'] = $arrResponse;
					unset($_SESSION['arrCarrito']);	
					session_regenerate_id(true);
				}
					
			}else{
				$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');

			}

			

		echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		die();
					}
		print_r($_SESSION);die;
	}
		public function confirmarpedido(){
		  $inactive = inactive();
		    if($inactive == 1 && empty($_SESSION['login'])){
		      header("Location:".base_url_inactive());

		    }	
			if(empty($_SESSION['dataorden'])){
				header("Location: ".base_url());
			}else{
				$dataorden = $_SESSION['dataorden'];
			
                $pedido = $dataorden['orden'];
				$idpedido = openssl_decrypt($pedido, METHODENCRIPT, KEY);
				//$transaccion = openssl_decrypt($dataorden['transaccion'], METHODENCRIPT, KEY);
				$data['page_tag'] = "Confirmar Pedido";
				$data['page_title'] = "Confirmar Pedido";
				$data['page_name'] = "confirmarpedido";
				$data['orden'] = $idpedido;
				$data['direccion'] = $dataorden['ordenCompleta']['orden']['direccion_envio'];
				if($dataorden['ordenCompleta']['orden']['tipoenvio'] == 'Retiro showroom'){
				    $data['direccion'] = 'Retiro por showroom, una vez efectuado el pago te enviaremos la dirección';

				}
					if($dataorden['ordenCompleta']['orden']['tipoenvio'] == 'Retiro Centro'){
				    $data['direccion'] = 'Almacen Chile - Esquina Chile y San Lorenzo, Ciudad';

				}
				
				$data['productos'] = $dataorden['productos'];
				$data['monto'] = $dataorden['monto'];
				$data['status'] = $dataorden['ordenCompleta']['orden']['status'];
			
				//$data['transaccion'] = $transaccion;
				$this->views->getView($this,"confirmarpedido",$data);
			}
			//unset($_SESSION['dataorden']);
		}
        	public function seguimientopedido($params){
			if(empty($params)){
				header("Location: ".base_url());
			}else{
			    $pedido = $params;
			    $pedido = str_replace(" ","+",$pedido);
			    //$pedido = 'lpelT7hHfnX+Tm6sU+1/+A==';
                $pedido = str_replace(",","/",$pedido);

				$idpedido = openssl_decrypt($pedido, METHODENCRIPT, KEY);

				$infoOrden = $this->getPedido($idpedido);
				//$transaccion = openssl_decrypt($dataorden['transaccion'], METHODENCRIPT, KEY);
				$data['page_tag'] = "Seguimiento Pedido";
				$data['page_title'] = "Seguimiento Pedido";
				$data['page_name'] = "seguimientopedido";
				$data['orden'] = $idpedido;
				$data['tipoenvio'] = $infoOrden['orden']['tipoenvio'];
                $data['cod_seguimiento'] = $infoOrden['orden']['cod_seguimiento'];
                
                $data['fecha_retiro'] = cambiaFechaANormal($infoOrden['orden']['fecha_retiro']);
                $data['fecha_retiro2'] = sumaFechas($data['fecha_retiro'],3);


                $data['fecha_compra'] = cambiaFechaANormal(substr($infoOrden['orden']['fecha'],0,10));
                $data['fecha_compra'] = $data['fecha_compra']." ".substr($infoOrden['orden']['fecha'],12,14);
                $data['fecha_pago'] = cambiaFechaANormal(substr($infoOrden['orden']['fecha_pago'],0,10));
                $data['fecha_pago'] = $data['fecha_pago']." ".substr($infoOrden['orden']['fecha_pago'],12,14);
                $data['fecha_envio'] = cambiaFechaANormal(substr($infoOrden['orden']['fecha_envio'],0,10));
                $data['fecha_envio'] = $data['fecha_envio']." ".substr($infoOrden['orden']['fecha_envio'],12,14);
                //$data['fecha_retiro'] = $infoOrden['orden']['fecha_retiro'];
                $data['sucursal'] = $infoOrden['orden']['sucursal'];
				$data['productos'] = $infoOrden['detalle'];
                $data['status'] = $infoOrden['orden']['status'];
				$data['monto'] = $dataorden['monto'];
				$data['status'] = $infoOrden['orden']['status'];
				$data['direccion'] = $dataorden['ordenCompleta']['orden']['direccion_envio'];
				//$data['transaccion'] = $transaccion;
				$this->views->getView($this,"seguimientopedido",$data);
			}
			unset($_SESSION['dataorden']);
		}
		public function page($pagina = null){
           $inactive = inactive();
		    if($inactive == 1 && empty($_SESSION['login'])){
		      header("Location:".base_url_inactive());

		    }	
		    
		    
			$pagina = is_numeric($pagina) ? $pagina : 1;
			$cantProductos = $this->cantProductos();
			$total_registro = $cantProductos['total_registro'];
			$desde = ($pagina-1) * PROPORPAGINA;
			$total_paginas = ceil($total_registro / PROPORPAGINA);
			$data['productos'] = $this->getProductosPage($desde,PROPORPAGINA);
			//dep($data['productos']);exit;
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "tienda";
			$data['pagina'] = $pagina;
			$data['total_paginas'] = $total_paginas;
			$data['categorias'] = $this->getCategorias();
			$this->views->getView($this,"tienda",$data);
		}

		public function search(){
		    
			if(empty($_REQUEST['s'])){
				header("Location: ".base_url());
			}else{
				$busqueda = strClean($_REQUEST['s']);
			}
          $inactive = inactive();
		    if($inactive == 1 && empty($_SESSION['login'])){
		      header("Location:".base_url_inactive());

		    }	
		    
			$pagina = empty($_REQUEST['p']) ? 1 : intval($_REQUEST['p']);
			$cantProductos = $this->cantProdSearch($busqueda);
			$total_registro = $cantProductos['total_registro'];
			$desde = ($pagina-1) * PROBUSCAR;
			$total_paginas = ceil($total_registro / PROBUSCAR);
			$data['productos'] = $this->getProdSearch($busqueda,$desde,PROBUSCAR);
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = "Resultado de: ".$busqueda;
			$data['page_name'] = "tienda";
			$data['pagina'] = $pagina;
			$data['total_paginas'] = $total_paginas;
			$data['busqueda'] = $busqueda;
			$data['categorias'] = $this->getCategorias();
			$this->views->getView($this,"search",$data);

		}

		public function suscripcion(){
		  $inactive = inactive();
		    if($inactive == 1 && empty($_SESSION['login'])){
		      header("Location:".base_url_inactive());

		    }	
		    
			if($_POST){
				$nombre = ucwords(strtolower(strClean($_POST['txtNombre'])));
				$email  = strtolower(strClean($_POST['txtCorreo']));

				$suscripcion = $this->setSuscripcion($nombre,$email);
				if($suscripcion > 0){
					$arrResponse = array('status' => true, 'msg' => "Gracias por tu suscripción.");
					//Enviar correo
					$dataUsuario = array('asunto' => "Nueva suscripción",
										'email' => EMAIL_SUSCRIPCION,
										'nombreSuscriptor' => $nombre,
										'emailSuscriptor' => $email );
					sendEmail($dataUsuario,"email_suscripcion");
				}else{
					$arrResponse = array('status' => false, 'msg' => "El email ya fue registrado.");
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die();
		}

		public function contacto(){
		   $inactive = inactive();
		    if($inactive == 1 && empty($_SESSION['login'])){
		      header("Location:".base_url_inactive());

		    }	
		    
		    
			if($_POST){
				//dep($_POST);
				$nombre = ucwords(strtolower(strClean($_POST['nombreContacto'])));
				$email  = strtolower(strClean($_POST['emailContacto']));
				$mensaje  = strClean($_POST['mensaje']);
				$useragent = $_SERVER['HTTP_USER_AGENT'];
				$ip        = $_SERVER['REMOTE_ADDR'];
				$dispositivo= "PC";

				if(preg_match("/mobile/i",$useragent)){
					$dispositivo = "Movil";
				}else if(preg_match("/tablet/i",$useragent)){
					$dispositivo = "Tablet";
				}else if(preg_match("/iPhone/i",$useragent)){
					$dispositivo = "iPhone";
				}else if(preg_match("/iPad/i",$useragent)){
					$dispositivo = "iPad";
				}

				$userContact = $this->setContacto($nombre,$email,$mensaje,$ip,$dispositivo,$useragent);
				if($userContact > 0){
					$arrResponse = array('status' => true, 'msg' => "Su mensaje fue enviado correctamente.");
					//Enviar correo
					$dataUsuario = array('asunto' => "Nueva Usuario en contacto",
										'email' => EMAIL_CONTACTO,
										'nombreContacto' => $nombre,
										'emailContacto' => $email,
										'mensaje' => $mensaje );
					sendEmail($dataUsuario,"email_contacto");
				}else{
					$arrResponse = array('status' => false, 'msg' => "No es posible enviar el mensaje.");
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die();
		}
				public function wa(){
		    //TOQUEN QUE QUERRAMOS PONER 
            $token = 'CaluStore';
            //RETO QUE RECIBIREMOS DE FACEBOOK
            $palabraReto = $_GET['hub_challenge'];
            //TOQUEN DE VERIFICACION QUE RECIBIREMOS DE FACEBOOK
            $tokenVerificacion = $_GET['hub_verify_token'];
            //SI EL TOKEN QUE GENERAMOS ES EL MISMO QUE NOS ENVIA FACEBOOK RETORNAMOS EL RETO PARA VALIDAR QUE SOMOS NOSOTROS
            if ($token === $tokenVerificacion) {
                echo $palabraReto;
                exit;
            }
            /*
             * RECEPCION DE MENSAJES
             */
            //LEEMOS LOS DATOS ENVIADOS POR WHATSAPP
            $respuesta = file_get_contents("php://input");
            //CONVERTIMOS EL JSON EN ARRAY DE PHP
            $respuesta = json_decode($respuesta, true);
            //EXTRAEMOS EL MENSAJE DEL ARRAY
            $mensaje.= $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
            //GUARDAMOS EL MENSAJE Y LA RESPUESTA EN EL ARCHIVO text.txt
            $separador = "-";
            $separada = explode($separador, $mensaje);
            if(count($separada) == 4){
                $hola = "si";
            }else{
                $hola = "no";
            }
            file_put_contents("text.txt", $hola);
		}

	}

 ?>

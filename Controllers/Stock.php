<?php 

	class Stock extends Controllers{
		public function __construct()
		{
			parent::__construct();
		
		}
		public function getStockProducto(int $idproducto)
		{
		    $h=0;
			$productoid = intval($idproducto);

				$talles = $this->model->selectTalles();


				$colores= $this->model->selectColores();
                $cantidadStock = $this->model->selectStockProducto($productoid);

              //  $arrStock['talles'] = $arrTalles;
             //   $arrStock['colores'] = $arrColores;
             //   $arrStock['stocks'] = $arrStockProducto;
                for ($i=0; $i < count($talles); $i++) {   
                    for ($j=0; $j < count($colores); $j++) {          

                    $nombreTalle = $talles[$i]['nombretalle'];
                    $nombreColor = $colores[$j]['nombre'];
                    $idTalle = $talles[$i]['idstocktalle'];
                    $idColor =$colores[$j]['idcolor'];
                    $veces = count($colores) * count($talles);

                                        $stock=array('talle'=>$idTalle , 'color'=>$idColor , 'cantidad'=> 0,'producto' =>$productoid);
               // dep($cantidadStock);die;

                    if(!empty($cantidadStock)){
                        foreach($cantidadStock as $stockA){
                          
                            if($stockA['talleid'] == $talles[$i]['idstocktalle'] && $stockA['colorid'] == $colores[$j]['idcolor']){

                                        $stock = array('talle'=>$idTalle, 'nombreTalle'=>$nombreTalle,'color'=>$idColor,'nombreColor'=>$nombreColor, 'cantidad'=>$stockA['cantidad'],'fotoreferencia'=>$stockA['fotoreferencia'],'producto' =>$productoid);   
                                                                                                						                    break;
                                    }else{
                                        $stock = array('talle'=>$idTalle,'nombreTalle'=>$nombreTalle,'color'=>$idColor,'nombreColor'=>$nombreColor,'cantidad'=>0,'fotoreferencia'=>0,'producto' =>$productoid);    
                            }
                        }
                    }else{
                                        $stock = array('talle'=>$idTalle, 'nombreTalle'=>$nombreTalle,'color'=>$idColor,'nombreColor'=>$nombreColor, 'cantidad'=>0,'fotoreferencia'=>0,'producto' =>$productoid);
                    }
                    $arrStock[$h] = $stock;
                                             $h++;               

                }
            }
				$html = getModal("modalStock",$arrStock);

	
			die();
		}
        public function getStockProducto111(int $idproducto)
		{
			$productoid = intval($idproducto);
			if($productoid > 0)
			{
				$arrTalles = $this->model->selectTalles();
				$arrColores = $this->model->selectColores();
                $data['talles'] = $arrTalles;
                $data['colores'] = $arrColores;
			
				$html = getModal("modalStock",$data);
			}
			die();
		}
		 public function getStock(int $idStock)
		{

			$stockid = intval($idStock);
			if($stockid > 0)
			{
			    $arrStock = $this->model->selectStock($stockid);
			    $arrResponse = array('status' => true, 'data' => $arrStock);
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

				}
			die();
		}
		public function getStockProducto22($idproducto){
			if($_SESSION['permisosMod']['r']){
				$idproducto = intval($idproducto);
				if($idproducto > 0){
					$arrData = $this->model->getStockProducto($idproducto);
					if(empty($arrData)){
                        $arrData = ['idstock' => 0, 'cantidad' => 0, 'talleid'=> 0,'colorid'=> 0,'productoid'=> $idproducto];
					}
				$arrResponse = array('status' => true, 'data' => $arrData);
					
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
    
    		public function setStock1()
    		{
    			if($_POST)
                $imagenes = array();
                $cantidadTotal = 0;
    
    			{
                    $stockGeneral = $this->model->getProducto($_POST['producto']);
                
                    $arrayStockSeparado = $_POST;
                    
    				for($x = 0; $x<count($arrayStockSeparado['cantidad']);$x++){
    				    $cantidadTotal = $arrayStockSeparado['cantidad'][$x] + $cantidadTotal;
    				    
    				}
                    if($cantidadTotal == $stockGeneral[0]['stock']){
                        
                    
    				for($i = 0; $i<count($arrayStockSeparado['talles']);$i++){
    
                      
    				    $stock = array($arrayStockSeparado['talles'][$i],$arrayStockSeparado['colores'][$i],$arrayStockSeparado['cantidad'][$i],$arrayStockSeparado['referencia'][$i]);
                        if($arrayStockSeparado['referencia'][$i] > 0){
                            
                            $coloreimg = array($arrayStockSeparado['colores'][$i],$arrayStockSeparado['referencia'][$i]);
                          array_push($imagenes,$coloreimg);
                        }
                         
                        foreach($imagenes as $imagen){
                         
                     
                            if($arrayStockSeparado['colores'][$i] == $imagen[0]){
     
                                $stock = array($arrayStockSeparado['talles'][$i],$arrayStockSeparado['colores'][$i],$arrayStockSeparado['cantidad'][$i],$imagen[1]);
                            
                               
                            }
                        }
    				    $stockOrdenado[$i]=$stock;
                        
    				}
                                
                        
                    $idProducto = $arrayStockSeparado['producto'];
    
    
                    $this->model->deleteStockProducto($idProducto);
    
    				foreach ($stockOrdenado as $stock) {
    
    				    $talle = $this->model->getIdTalle($stock[0]);
    
    				    $idTalle = $talle[0]['idstocktalle'];								                   
    
    				    $color = $this->model->getIdColor($stock[1]);
    				    $idColor = $color[0]['idcolor'];								                   
    
    
    					$cantidad =$stock[2];
    					$fotoreferencia =$stock[3];
    					$requestPermiso = $this->model->insertStocks($idProducto, $idTalle, $idColor, $cantidad,$fotoreferencia);
    
    
    				}
    
                	if($requestPermiso > 0)
    				{
    					$arrResponse = array('status' => true, 'msg' => 'Stock actualizado.');
    				}else{
    					$arrResponse = array("status" => false, "msg" => 'No se pudo actualizar el stock');
    				}
    				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    			    }else{
    			       $arrResponse = array('status' => false, 'msg' => 'La cantidad es distinta al stock general, el stock general es de '.$stockGeneral[0]['stock'].' y la cantidad indicada es de '.$cantidadTotal);
    				    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    
    			    }
    			}
    			die();
    		}
            public function setStock()
    		{

    			if($_POST){
        			$idstock = intval($_POST['idStock']);
                    $idTalle = $_POST['listTalleid'];
                    $idColor = $_POST['listColorid'];
                    $cantidad = $_POST['txtCantidad'];
                    $producto = $_POST['idProducto'];
                    $fotoreferencia = $_POST['fotoreferencia'];
                    $checkStockCapacidad = true;
                    if($cantidad > 0){
                        $checkStockCapacidad = $this->model->checkStockCapacidad($idTalle,$idColor,$cantidad,$producto,$idstock);
                        
                    }
                    if($checkStockCapacidad == true){
                                if($idstock > 0){
                               $stockCargado = $this->model->checkStock($idTalle,$idColor,$cantidad,$producto,$fotoreferencia);
                                 if(empty($stockCargado) || $idstock == $stockCargado['idstock']){
                                $requestUpdate = $this->model->updateStock($idstock,$cantidad,$idTalle,$idColor,$fotoreferencia,$producto);
            				     if($requestUpdate > 0)
            				    {
            				    	$arrResponse = array('status' => true, 'msg' => 'Stock actualizado.');
            				    }else{
            				    	$arrResponse = array("status" => false, "msg" => 'No se pudo actualizar el stock');
            				    }
            		    				    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        
                            }else{
                                $arrResponse = array("status" => false, "msg" => 'El talle y el color ya tienen stock en este articulo');
            				    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                            }
                                
                              
        
                            
                        }else{
                            $stockCargado = $this->model->checkStock($idTalle,$idColor,$cantidad,$producto);
                            if(!empty($stockCargado)){
                                $arrResponse = array("status" => false, "msg" => 'El talle y el color ya tienen stock en este articulo');
            				    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        
                            }else{
                                $requestPermiso = $this->model->insertStocks($idTalle,$idColor,$cantidad,$producto,$fotoreferencia);
                        	    if($requestPermiso > 0)
            				    {
            				    	$arrResponse = array('status' => true, 'msg' => 'Stock cargado.');
            				    }else{
            				    	$arrResponse = array("status" => false, "msg" => 'No se pudo cargar el stock');
            				    }
            		    				    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        
                            }
                        
            		    }
                    }else{
                         $arrResponse = array("status" => false, "msg" => 'Ya se alcanzó el máximo de stock general del producto');
            				    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                    }
                    

    			}
    			
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
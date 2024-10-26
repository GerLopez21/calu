<?php 
	require_once("Models/TCategoria.php");
	require_once("Models/TProducto.php");
	require_once("Models/TTipoPago.php");
	require_once("Models/TCliente.php");
	class Carrito extends Controllers{
		use TCategoria, TProducto, TTipoPago, TCliente;
		public function __construct()
		{
			parent::__construct();
			session_start();
		}

		public function carrito()
		{
		    $inactive = inactive();
		    if($inactive == 1 && empty($_SESSION['login'])){
		      header("Location:".base_url_inactive());

		    }	
		    
		    
			$data['page_tag'] = NOMBRE_EMPESA.' - Carrito';
			$data['page_title'] = 'Carrito de compras';
			$data['page_name'] = "carrito";
			$this->views->getView($this,"carrito",$data); 
		}
		public function envio()
		{
			if(empty($_SESSION['arrCarrito'])){ 
				header("Location: ".base_url());
				die();
			}
			$data['page_tag'] = NOMBRE_EMPESA.' - Seleccionar envío';
			$data['page_title'] = 'Seleccionar envío';
			$data['page_name'] = "seleccionarenvio";
            $data['tipo_envios'] = $this->getTipoenvios();

			$this->views->getView($this,"envio",$data); 
		}
		public function confirmarpago()
		{
			if(empty($_SESSION['arrCarrito'])){ 
				header("Location: ".base_url());
				die();
			}

            $inactive = inactive();
		    if($inactive == 1 && empty($_SESSION['login'])){
		      header("Location:".base_url_inactive());

		    }	
		    
		    
			$data['page_tag'] = NOMBRE_EMPESA.' - Metodo de Pago';
			$data['page_title'] = 'Metodo de Pago';
			$data['page_name'] = "confirmarpago";
			$data['tiposPago'] = $this->getTiposPagoT();
			$data['idPedido'] = $_SESSION['idPedido'];
		    $data['tipoenvio'] = $_SESSION['tipoenvio'];
			$this->views->getView($this,"confirmarpago",$data); 
		}

	}
 ?>

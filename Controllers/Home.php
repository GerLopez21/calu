<?php 
	require_once("Models/TCategoria.php");
	require_once("Models/TProducto.php");
	class Home extends Controllers{
		use TCategoria, TProducto;
		public function __construct()
		{
			parent::__construct();
			session_start();
		}

		public function home()
		{
            $inactive = inactive();

		    if($inactive == 1 && empty($_SESSION['login'])){
		      header("Location:".base_url_inactive());

		    }			$pageContent = getPageRout('inicio');
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "tienda_virtual";
			$data['page'] = $pageContent;
			$data['slider'] = $this->getCategoriasT(CAT_SLIDER);
			$data['banner'] = $this->getCategoriasT(CAT_BANNER);
			$data['productos'] = $this->getProductosT();
			if(!isset($_SESSION['modal'])){ 
				$_SESSION['modal'] = false ;
				$data['mostrarModal'] = true;
		 	 }else{
				$data['mostrarModal'] = false;
			 }
		
			$this->views->getView($this,"home",$data); 
		}



	}
 ?>

<?php 
	class Cambios extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			getPermisos(MDPAGINAS);
		}

		public function cambios()
		{
			$pageContent = getPageRout('cambios');
			if(empty($pageContent)){
				header("Location: ".base_url());
			}else{
			    $inactive = inactive();
		    if($inactive == 1 && empty($_SESSION['login'])){
		      header("Location:".base_url_inactive());

		    }	
		    
		    
				$data['page_tag'] = NOMBRE_EMPESA;
				$data['page_title'] = NOMBRE_EMPESA." - ".$pageContent['titulo'];
				$data['page_name'] = $pageContent['titulo'];
				$data['page'] = $pageContent;
				$this->views->getView($this,"cambios",$data);  
			}

		}

	}
 ?>

<?php 
	headerTienda($data);
	$arrSlider = $data['slider'];
	$arrBanner = $data['banner'];
	$arrProductos = $data['productos'];
	$contentPage = "";
	if(!empty($data['page'])){
		$contentPage = $data['page']['contenido'];
	}
	

 ?>
	<!-- Slider -->

   	<section class="section-slide">

		<div class="wrap-slick1">

			<div class="slick1">

				<div class="item-slick1" style="background-image: url(https://calu-store.com/Assets/images/portada12.webp);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">

							<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">

							</div>
								
						</div>
					</div>
				</div>
			
			</div>
		</div>
	</section>
	<!-- Banner -->
	<div class="sec-banner bg0 p-t-80 p-b-50">
		<div class="container">
			<div class="row">
				<?php 
				for ($j=0; $j < count($arrBanner); $j++) {
					$ruta = $arrBanner[$j]['ruta']; 
				 ?>
				<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
					<!-- Block1 -->
					<div class="block1 wrap-pic-w" data-aos="fade-up">
						<img src="<?= $arrBanner[$j]['portada'] ?>" alt="<?= $arrBanner[$j]['nombre'] ?>">

						<a href="<?= base_url().'/tienda/categoria/'.$arrBanner[$j]['idcategoria'].'/'.$ruta; ?>" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
							<div class="block1-txt-child1 flex-col-l">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									<?= $arrBanner[$j]['nombre'] ?>
								</span>
								<!-- <span class="block1-info stext-102 trans-04">
									Spring 2018
								</span> -->
							</div>
							<div class="block1-txt-child2 p-b-4 trans-05">
								<div class="block1-link stext-101 cl0 trans-09">
									Ver productos
								</div>
							</div>
						</a>
					</div>
				</div>
				<?php 
				}
				 ?>
			</div>
		</div>
	</div>

	<!-- Product -->
	<section class="bg0 p-t-23 p-b-140">
		<div class="container">
			<div class="p-b-10">
				<h3 class="ltext-103 cl5">
					Nuevos Productos
				</h3>
			</div>
			<hr>
			<div class="row isotope-grid">
			<?php 
				for ($p=0; $p < count($arrProductos) ; $p++) {
					$rutaProducto = $arrProductos[$p]['ruta']; 
					if(count($arrProductos[$p]['images']) > 0 ){
						$portada = $arrProductos[$p]['images'][0]['url_image'];
					}else{
						$portada = media().'/images/uploads/product.png';
					}
			 ?>
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
					<!-- Block2 -->
					<div class="block2">
					<?php if($arrProductos[$p]['stock'] >0){ ?>
						<div class="block2-pic hov-img0" data-aos="fade-up">
							<img loading="lazy" src="<?= $portada ?>" alt="<?= $arrProductos[$p]['nombre'] ?>">
							<a href="<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$rutaProducto; ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
								Ver producto
							</a>
						</div>
						<?php }else{?>
							<div class="block2-pic hov-img1">
							<h1><b>SIN STOCK</b></h1>
							<img loading="lazy" src="<?= $portada ?>" alt="<?= $arrProductos[$p]['nombre'] ?>">
							<a href="<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$rutaProducto; ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
								Ver producto
							</a>
						</div>
						<?php }?>
						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$rutaProducto; ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
									<?= $arrProductos[$p]['nombre'] ?>
								</a>
    	                    <?php
    						if($arrProductos[$p]['preciodescuento'] > 0){ ?>
    						<span class="mtext-106 cl2">
    						<del>	<?= SMONEY.formatMoney($arrProductos[$p]['precio']); ?></del>
        					&nbsp;&nbsp;&nbsp;&nbsp;		<?= SMONEY.formatMoney($arrProductos[$p]['preciodescuento']); ?>
    
    						</span>
    					   <?php	}else{ ?>
    						<span class="mtext-106 cl2">
    							<?= SMONEY.formatMoney($arrProductos[$p]['precio']); ?>
    							
    						</span>
    						<?php } ?>
								
								<?php if ($arrProductos[$p]['stock'] < 10 && $arrProductos[$p]['stock'] > 0){
										?>Quedan pocos <?php
									} ?>
									<?php if ($arrProductos[$p]['stock'] <= 0){
										?>Agotado <?php
									} ?>
							</div>

							<div class="block2-txt-child2 flex-r p-t-3">
								<a href="#"
								 id="<?= openssl_encrypt($arrProductos[$p]['idproducto'],METHODENCRIPT,KEY); ?>"
								 class="btn-addwish-b2 dis-block pos-relative js-addwish-b2 js-addcart-detail
								 icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11
								 ">
									<i class="zmdi zmdi-shopping-cart"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>
			<!-- Load more -->
			<div class="flex-c-m flex-w w-full p-t-45">
				<a href="<?= base_url() ?>/tienda" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
					Ver más
				</a>
			</div>
		</div>

		<div class="container text-center p-t-80">
			<hr>
			<?= $contentPage ?>
		</div>
	</section>
<?php 
	footerTienda($data);
 ?>


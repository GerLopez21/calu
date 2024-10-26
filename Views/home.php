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
 <?php if($data['mostrarModal'] == true){  ?>

<div class="modal fade" id="modalInicio" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div style="align-items:center;" class="modal-content">
												<div class="modal-header">
													
												

												<div  class="logoModal">
														<img src="<?= media() ?>/tienda/images/calu.png" alt="Tienda Virtual" height="150px" width="200px">
													</div>
													
												</div>

												<form id="formNewsletter" name="formNewsletter" class="form-horizontal">
	
												<div class="modal-body">
														<div class="page-content">
														<p class="ltext-101 cl2" style="align-text=center;">Bienvenido/a a CALU</p>
														<p class="stext-102 cl2">Te invitamos a suscribirte y recibir todas nuestras novedades</p>
														<p class="stext-102 cl2">Te enviaremos un codigo para un descuento en tu primera compra con nosotros</p>
														<label class="stext-102 cl2" for="txtNombre">Nombre </label>
                 										 <input type="text" class="form-control" id="txtNombre" name="txtNombre">
														  <label class="stext-102 cl2" for="txtCorreo">Correo </label>
                 										 <input type="text" class="form-control" id="txtCorreo" name="txtCorreo">
														</div>
												</div>
												<div class="modal-footer">
												<button id="btnActionModalNewsletter" class="btnModal btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
												<button type="button" class="btnModal btn-danger" data-dismiss="modal">Cerrar</button>
												</div>
												</form>

												</div>
											</div>
											</div>

											<?php } ?>
	<!--fin modal inicio-->

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
						<div class="block2-pic hov-img0">
							<img loading="lazy" src="<?= $portada ?>" alt="<?= $arrProductos[$p]['nombre'] ?>">
							<?php if(!empty($arrProductos[$p]['descuento'])){ ?>
								<div class="product-label p-r-80">
									
									<span class="descuento stext-103 cl2 size-102"><b><?= $arrProductos[$p]['descuento']['titulo'] ?></b> <a href="#" data-toggle="modal" data-target="#modalRequisitosDescuentos" <i class="fa fa-info-circle" style="color:#cfbdb5" aria-hidden="true"> </a></span>
								</div>
								<?php } ?>
									<!-- Modal Descuentos -->
									<div class="modal fade" id="modalRequisitosDescuentos" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title"> Info para aplicar descuento </h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
														<div class="page-content">
														<?php if (isset($arrProductos[$p]['descuento']['minimo_compra'])){ ?>

															<?php if($arrProductos[$p]['descuento']['minimo_compra'] > 0){ ?>
															
															Mínimo de compra: <?= SMONEY.formatMoney($arrProductos[$p]['descuento']['minimo_compra']); ?>
															
															<?php } ?>
															<br>
															<?php if($arrProductos[$p]['descuento']['limite_cantidad_productos'] > 1){ ?>
															
															Mínimo de productos: <?= $arrProductos[$p]['descuento']['limite_cantidad_productos']; ?>
															
															<?php } ?>
															<?php } ?>

														</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
												</div>
												</div>
											</div>
											</div>
								<?php if(!empty($arrProductos[$p]['promocion'])){ ?>
								<div class="product-label ">
									
									<span class="promo stext-103 cl2 size-102"><b><?= $arrProductos[$p]['promocion']['nombreTipo'] ?></b> <a href="#" data-toggle="modal" data-target="#modalRequisitosPromos" <i class="fa fa-info-circle" style="color:#cfbdb5" aria-hidden="true"> </a></span>
								</div>
								<?php } ?>
												<!-- Modal Descuentos -->
												<div class="modal fade" id="modalRequisitosPromos" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title"> Info para aplicar promoción </h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
														<div class="page-content">

														<?php if (isset($arrProductos[$p]['promocion']['minimo_compra'])){ ?>

															<?php if($arrProductos[$p]['promocion']['minimo_compra'] > 0){ ?>
															
															<span class="stext-103 cl2 size-102">Mínimo de compra: <?= SMONEY.formatMoney($arrProductos[$p]['promocion']['minimo_compra']); ?></span>
															
															<?php } ?>
															<br>
															<?php if($arrProductos[$p]['promocion']['limite_cantidad_productos'] > 0){ ?>
															
															<span class="stext-103 cl2 size-102">Mínimo de productos: <?= SMONEY.formatMoney($arrProductos[$p]['promocion']['limite_cantidad_productos']); ?></span>

															
															<?php } ?>
															<br>
															<?php if($arrProductos[$p]['promocion']['combinable_variado'] == 1){ ?>
															
															Podes combinarlo con productos de cualquier tipo que esten con la promo
															<?php } ?>
															<br>
															<?php if($arrProductos[$p]['promocion']['combinable_categoria'] == 1){ ?>
															
															Solo combinable con productos de la categoría que esten con la promo
															<?php } ?>
															<?php } ?>
														</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
												</div>
												</div>
											</div>
											</div>
											<!-- cierro modal promos -->
									
										<!-- cierro modal descuentos -->
								
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
							<br>
							<span class="stext-102 col-12 cl1 js-insta-variation-precio p-l-0">

							<?= SMONEY.formatMoney($arrProductos[$p]['precio']*0.75); ?> con efectivo o transferencia 
							
							
						</span>
						<span class="stext-102 col-12 cl1 js-insta-variation-precio p-l-0">

							3 cuotas sin interes de <?= SMONEY.formatMoney($arrProductos[$p]['precio']/3); ?>
							
							
						</span>
    						<?php } ?>
								
								<?php if ($arrProductos[$p]['stock'] < 10 && $arrProductos[$p]['stock'] > 0){
										?><h5 class="stext-102 cl2">
										Quedan pocos 
										</h5>
								<?php
									} ?>
									<?php if ($arrProductos[$p]['stock'] <= 0){
										?><h5 class="stext-102 cl2">
										Agotado
										</h5> <?php
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


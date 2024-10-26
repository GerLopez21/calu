<?php 
headerTienda($data);
$arrProducto = $data['producto'];
$arrProductos = $data['productos'];
$arrImages = $arrProducto['images']; 
$rutacategoria = $arrProducto['categoriaid'].'/'.$arrProducto['ruta_categoria'];
$urlShared = base_url()."/tienda/producto/".$arrProducto['idproducto']."/".$arrProducto['ruta'];
$asd = "disabled";
$arrStock = $data['stock'];
$arrTalles = $data['tallesycolores'];
$tallescargados = array();
$colorescargados = array();
 ?>
<br><br><br>
<hr>
	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="<?= base_url(); ?>" class="stext-109 cl8 hov-cl1 trans-04">
				Inicio
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>
			<a href="<?= base_url().'/tienda/categoria/'.$rutacategoria; ?>" class="stext-109 cl8 hov-cl1 trans-04">
				<?= $arrProducto['categoria'] ?>
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>
			<span class="stext-109 cl4">
				<?= $arrProducto['nombre'] ?>
			</span>
		</div>
	</div>
	<!-- Product Detail -->
	<section class="sec-product-detail bg0 p-t-65 p-b-60">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-7 p-b-30">
					<div class="p-l-25 p-r-30 p-lr-0-lg">
						<div class="wrap-slick3 flex-sb flex-w">
							<div class="wrap-slick3-dots"></div>
							<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

							<div class="slick3 gallery-lb">
							<?php 
								if(!empty($arrImages)){
									for ($img=0; $img < count($arrImages) ; $img++) { 
										
							 ?>
								<div class="item-slick3" data-thumb="<?= $arrImages[$img]['url_image']; ?>">
									<div class="wrap-pic-w pos-relative">
										<img src="<?= $arrImages[$img]['url_image']; ?>" alt="<?= $arrProducto['nombre']; ?>">
										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="<?= $arrImages[$img]['url_image']; ?>">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>
							<?php 
									}
								} 
							?>
							</div>
						</div>
					</div>
				</div>
					
				<div class="col-md-6 col-lg-5 p-b-30">
					<div class="p-r-50 p-t-5 p-lr-0-lg">
						<h4 class="mtext-105 cl2 js-name-detail p-b-14">
							<?= $arrProducto['nombre']; ?>
						</h4>
						<!-- ?php
						if($arrProducto['preciodescuento'] > 0){ ?>
						<span class="mtext-106 col-12 cl2 js-insta-variation-precio">
						<del>	?= SMONEY.formatMoney($arrProducto['precio']); ?></del>
    					&nbsp;&nbsp;&nbsp;&nbsp;		?= SMONEY.formatMoney($arrProducto['preciodescuento']); ?>

						</span>
					   ?php	}else{ ?> -->
						<span class="mtext-106 col-12 cl2 js-insta-variation-precio">

							<?= SMONEY.formatMoney($arrProducto['precio']); ?> 
							
							
						</span><br>
						<span class="mtext-102 col-12 cl1 js-insta-variation-precio">

							<?= SMONEY.formatMoney($arrProducto['precio']*0.75); ?> con efectivo o transferencia 
							
							
						</span><br>
						<span class="mtext-102 col-12 cl1 js-insta-variation-precio">

							3 cuotas sin interes de <?= SMONEY.formatMoney($arrProducto['precio']/3); ?>
							
							
						</span>
						<?php if(!empty($arrProducto['descuento'])){ ?>
								<div class="product-label">
									
									<span class="promo stext-103 cl2 size-102"><b><?= $arrProducto['descuento']['titulo'] ?></b> <a href="#" data-toggle="modal" data-target="#modalRequisitosDescuentos" <i class="fa fa-info-circle" style="color:#cfbdb5" aria-hidden="true"> </a></span>
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
														<?php if (isset($arrProducto['descuento']['minimo_compra'])){ ?>

															<?php if($arrProducto['descuento']['minimo_compra'] > 0){ ?>
															
															Mínimo de compra: <?= SMONEY.formatMoney($arrProducto['descuento']['minimo_compra']); ?>
															
															<?php } ?>
															<br>
															<?php if($arrProducto['descuento']['limite_cantidad_productos'] > 1){ ?>
															
															Mínimo de productos: <?= $arrProducto['descuento']['limite_cantidad_productos']; ?>
															
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
										<!-- cierro modal descuentos -->
						
						<h5 class="stext-102 cl3 p-t-23 p-lr-15">
							<?= $arrProducto['descripcion']; ?>
						</h5>
					
						<!--  -->
						 <?php if($arrProducto['stock']>0){
                                    ?>
						<div class="p-t-10">
						      <div class="col-12">
            <div data-variant="TALLE" class="mtext-106 js-btn-variation-container text-sm-left">
                <?php if(!empty($arrTalles)){?>
                          <label for="variation_1" class="form-label mb-1"> TALLE: &nbsp;
                           <?php } ?>
                <strong class="js-insta-variation-label"></strong>
              </label>
                        
              <div class="mtext-106 row ml-0 justify-content-sm-start no-gutters">
                                               
                <?php
                 for ($i=0; $i < count($arrTalles); $i++) { 
                     if(!in_array($arrTalles[$i]['nombretalle'],$tallescargados)){
                                           
                                    $nombre= str_replace('/', '-', $arrTalles[$i]['nombretalle']);
                     ?>
                                <div class="col-auto">
                     <a data-option="<?= $arrTalles[$i]['talleid'];?>" style="border-color:#abaaaa;" class="js-btn-variation btn btn-<?php echo $nombre ?> btn-talle mr-2 mb-3 TALLE" id="talle" name="talle" value="<?= $arrTalles[$i]['talleid'];?>">
                        <?= $arrTalles[$i]['nombretalle'];?>
                    </a>
                    <?php array_push($tallescargados,$arrTalles[$i]['nombretalle']);


                            ;?>
                </div>
                <?php
                }}

                ?>
                     
                              </div>
            </div>
        </div>
        <div id="containerColor" class="col-12 js-talle js-colores-80x60">
            <div data-variant="TALLE" class="mtext-106 js-btn-variation-container text-sm-left">
                          <label for="variation_1" class="form-label mb-1"> COLOR: &nbsp;
                <strong class="js-insta-variation-label-color"></strong>
              </label>
              <div  id="coloresInit" class="mtext-106 row ml-0 justify-content-sm-start no-gutters">
			  <?php
                 for ($i=0; $i < count($arrTalles); $i++) { 

                     if(!in_array($arrTalles[$i]['nombre'],$colorescargados)){
                                    $nombre= str_replace('/', '-', $arrTalles[$i]['nombre']);

                     ?>
                                <div class="col-auto">
                     <a data-option="<?= $arrTalles[$i]['nombre'];?>" style="border-color:#abaaaa;" class="js-btn-variation btn btn-<?php echo $nombre ?> btn-talle mr-2 mb-3 COLOR" id="color" name="color" value="<?= $arrTalles[$i]['nombre'];?>">
                        <?= $arrTalles[$i]['nombre'];?>
                    </a>
                    <?php array_push($colorescargados,$arrTalles[$i]['nombre']);


                            ;?>
                </div>
                <?php
                }}

                ?>
             
                              
                            </div>
							<div id="containerFilas" class="disp"></div>
                                <div id="containerFilas2" class="disp"></div>
                                <div id="containerFilas3" class="disp"></div>
            </div>
        </div>
   						<div class="form-group col-xl">

						<div class="wrap-num-product flex-w m-r-20 m-tb-10">
							
										<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-minus"></i>
										</div>

										<input id="cant-product" class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1" min="1">

										<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-plus"></i>
										</div>
									</div>
                            
							  
							</div>
                               
									<button id="<?= openssl_encrypt($arrProducto['idproducto'],METHODENCRIPT,KEY); ?>" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
										Agregar al carrito
									</button>
															<?php }else{ ?>

									</div>			
									<span class="mtext-106 cl2">
    						         SIN STOCK   						</span>
								<?php } ?>
							
						</div>
						<!--  -->
						
						<div class="flex-w flex-m p-l-100 p-t-40 respon7">
							<div class="flex-m bor9 p-r-10 m-r-11">
								Compartir en:
							</div>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook"
								onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?= $urlShared; ?> &t=<?= $arrProducto['nombre'] ?>','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"
								>
								<i class="fa fa-facebook"></i>
							</a>

							<a href="https://twitter.com/intent/tweet?text=<?= $arrProducto['nombre'] ?>&url=<?= $urlShared; ?>&hashtags=<?= SHAREDHASH; ?>" target="_blank" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
								<i class="fa fa-twitter"></i>
							</a>

							<a href="https://api.whatsapp.com/send?text=<?= $arrProducto['nombre'].' '.$urlShared ?>" target="_blank" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="WhatsApp">
								<i class="fab fa-whatsapp" aria-hidden="true"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
			<h3>Productos Relacionados</h3>
		</div>
	</section>

	<!-- Related Products -->
	<section class="sec-relate-product bg0 p-t-45 p-b-105">
		<div class="container">
			<!-- Slide2 -->
			<div class="wrap-slick2">
				<div class="slick2">

				<?php 
					if(!empty($arrProductos)){
						for ($p=0; $p < count($arrProductos); $p++) { 
							$ruta = $arrProductos[$p]['ruta'];
							if(count($arrProductos[$p]['images']) > 0 ){
								$portada = $arrProductos[$p]['images'][0]['url_image'];
							}else{
								$portada = media().'/images/uploads/product.png';
							}
				 ?>
					<div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-pic hov-img0">
								<img src="<?= $portada ?>" alt="<?= $arrProductos[$p]['nombre'] ?>">

								<a href="<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$ruta; ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
									Ver producto
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$ruta; ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										<?= $arrProductos[$p]['nombre'] ?>
									</a>
									<span class="mtext-106 col-12 cl2 js-insta-variation-precio p-l-02">

							<?= SMONEY.formatMoney($arrProducto['precio']); ?> 
							
							
						</span><br>
						<span class="stext-102 col-12 cl1 js-insta-variation-precio p-l-0">

							<?= SMONEY.formatMoney($arrProductos[$p]['precio']*0.75); ?> con efectivo o transferencia 
							
							
						</span>
						<span class="stext-102 col-12 cl1 js-insta-variation-precio p-l-0">

							3 cuotas sin interes de <?= SMONEY.formatMoney($arrProductos[$p]['precio']/3); ?>
							
							
						</span>
						<?php if(!empty($arrProducto['descuento'])){ ?>
								<div class="product-label">
									
									<span class="promo stext-103 cl2 size-102"><b><?= $arrProducto['descuento']['titulo'] ?></b> <a href="#" data-toggle="modal" data-target="#modalRequisitosDescuentos" <i class="fa fa-info-circle" style="color:#cfbdb5" aria-hidden="true"> </a></span>
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
														<?php if (isset($arrProducto['descuento']['minimo_compra'])){ ?>

															<?php if($arrProducto['descuento']['minimo_compra'] > 0){ ?>
															
															Mínimo de compra: <?= SMONEY.formatMoney($arrProducto['descuento']['minimo_compra']); ?>
															
															<?php } ?>
															<br>
															<?php if($arrProducto['descuento']['limite_cantidad_productos'] > 1){ ?>
															
															Mínimo de productos: <?= $arrProducto['descuento']['limite_cantidad_productos']; ?>
															
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
							
								</div>
								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#"
									 id="<?= openssl_encrypt($arrProductos[$p]['idproducto'],METHODENCRIPT,KEY); ?>"
									 pr="1"
									 class="btn-addwish-b2 dis-block pos-relative js-addwish-b2 js-addcart-detail
									 icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11
									 ">
										<i class="zmdi zmdi-shopping-cart"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				<?php 
						}
					}	
				 ?>

				</div>
			</div>
		</div>
	</section>
<?php 
	footerTienda($data);
?>

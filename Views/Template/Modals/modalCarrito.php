<?php 
$total = 0;
if(isset($_SESSION['arrCarrito']) and count($_SESSION['arrCarrito']) > 0){ 
 ?>
<ul class="header-cart-wrapitem w-full">
<?php 
	foreach ($_SESSION['arrCarrito'] as $producto) {
	   if($producto['preciodescuento'] > 0){
	$total += $producto['cantidad'] * $producto['preciodescuento'];
	   }else{
	       	$total += $producto['cantidad'] * $producto['precio'];

	   }
	$idProducto = openssl_encrypt($producto['idproducto'],METHODENCRIPT,KEY);	
 ?>	
	<li class="header-cart-item flex-w flex-t m-b-12">
		<div class="header-cart-item-img col-5" >
			<img src="<?= $producto['imagen'] ?>" alt="<?= $producto['producto'] ?>">
		</div>
		<div class="header-cart-item-txt p-t-2 col-3">
			<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
			 <?php   if($producto['nombretalle'] == null){ ?>
    				<?= $producto['producto'] ?>
    			<?php }else{ ?>
    			<?= $producto['producto']. " Talle ".$producto['nombretalle']." Color ".$producto['nombrecolor']  ?>
    			<?php } ?>

			<br>
			<?php if($producto['preciodescuento'] > 0){ ?>
			    <?= $producto['cantidad'].' x '.SMONEY.formatMoney($producto['preciodescuento']) ?>

		<?php	}else{ ?>
		    	<?= $producto['cantidad'].' x '.SMONEY.formatMoney($producto['precio']) ?>

		  <?php  } ?>
			</a>
        </div>
	
			<div class="header-cart-delete">
			    <br>
					<i class="zmdi zmdi-delete" idpr="<?= $idProducto ?>" op="1" onclick="fntdelItem(this)"></i>
				</div>
	</li>
<?php } ?>
</ul>
<div class="w-full">
	<div class="header-cart-total w-full p-tb-40">
		Total: <?= SMONEY.formatMoney($total); ?>
	</div>

	<div class="header-cart-buttons flex-w w-full">
		<a href="<?= base_url() ?>/carrito" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
			Ver carrito
		</a>

		<a href="<?= base_url() ?>/carrito/envio" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
			Seleccionar metodo de envío
		</a>
	</div>
</div>
<?php 
}
 ?>
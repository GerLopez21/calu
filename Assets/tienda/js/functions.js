talleseleccionado= null;
colorseleccionado =null;
colorselected = null;

$(".js-select2").each(function(){
	$(this).select2({
		minimumResultsForSearch: 20,
		dropdownParent: $(this).next('.dropDownSelect2')
	});
});
$('#modalInicio').modal('show');

$('.parallax100').parallax100();

$('.gallery-lb').each(function() { // the containers for all your galleries
	$(this).magnificPopup({
        delegate: 'a', // the selector for gallery item
        type: 'image',
        gallery: {
        	enabled:true
        },
        mainClass: 'mfp-fade'
    });
});

$('.js-addwish-b2').on('click', function(e){
	e.preventDefault();
});

$('.js-addwish-b2').each(function(){
	var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
	$(this).on('click', function(){
		swal(nameProduct, "¡Se agrego al corrito!", "success");
		//$(this).addClass('js-addedwish-b2');
		//$(this).off('click');
	});
});

$('.js-addwish-detail').each(function(){
	var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

	$(this).on('click', function(){
		swal(nameProduct, "is added to wishlist !", "success");

		$(this).addClass('js-addedwish-detail');
		$(this).off('click');
	});
});

/*---------------------------------------------*/

 $('.slick3').not('.slick-initialized').slick();
$(document).on('click','.cambiarSlide', function(e){ //esta función se ejecutará en todos los casos


    
    e.preventDefault();
    var slideIndex = $(this).data('slide-index');

    // Ir a la diapositiva deseada
    
        $('.slick3').slick('slickGoTo', slideIndex);



  });
$('.js-addcart-detail').each(function(){
	let nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
	let cant = 1;
	$(this).on('click', function(){
		let id = this.getAttribute('id');
		if(document.querySelector('#cant-product')){
			cant = document.querySelector('#cant-product').value;
		}
		if(this.getAttribute('pr')){
			cant = this.getAttribute('pr');
		}
		fotoreferencia = $('.slick-current').attr("data-slick-index");
		


		if(document.querySelector('#talle')){
			talle = document.querySelector('#talle').value;
		}
		talle = talleseleccionado;
		color = colorseleccionado;
		alert(color)


		if(isNaN(cant) || cant < 1){
			swal("","La cantidad debe ser mayor o igual que 1" , "error");
			return;
		} 
	/*	if(talle == null){
			swal("","Tenes que seleccionar algun talle" , "error");
			return;
		} 
		if(color == null){
			swal("","Tenes que seleccionar algun color" , "error");
			return;
		} */
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	    let ajaxUrl = base_url+'/Tienda/addCarrito'; 
	    let formData = new FormData();
	    formData.append('id',id);
	    formData.append('cant',cant);
		formData.append('talle',talle);
    	formData.append('fotoreferencia',fotoreferencia);
		formData.append('color',color);

	    request.open("POST",ajaxUrl,true);
	    request.send(formData);
	    request.onreadystatechange = function(){
	        if(request.readyState != 4) return;
	        if(request.status == 200){
	        	let objData = JSON.parse(request.responseText);
	        	if(objData.status){
		            document.querySelector("#productosCarrito").innerHTML = objData.htmlCarrito;
		            //document.querySelectorAll(".cantCarrito")[0].setAttribute("data-notify",objData.cantCarrito);
		            //document.querySelectorAll(".cantCarrito")[1].setAttribute("data-notify",objData.cantCarrito);
		            const cants = document.querySelectorAll(".cantCarrito");
					cants.forEach(element => {
						element.setAttribute("data-notify",objData.cantCarrito)
					});
					swal(nameProduct, "¡Se agrego al corrito!", "success");
	        	}else{
	        		swal("", objData.msg , "error");
	        	}
	        } 
	        return false;
	    }
	});
});

$('.js-pscroll').each(function(){
	$(this).css('position','relative');
	$(this).css('overflow','hidden');
	var ps = new PerfectScrollbar(this, {
		wheelSpeed: 1,
		scrollingThreshold: 1000,
		wheelPropagation: false,
	});

	$(window).on('resize', function(){
		ps.update();
	})
});
if(document.querySelector(".js-btn-variati1on")){
	let optmetodo = document.querySelectorAll(".js-btn-vari1ation");
    optmetodo.forEach(function(optmetodo) {
        optmetodo.addEventListener('click', function(){
       $(".btn").css( "background-color", "white" );
       document.querySelector(".js-colores-XS").classList.add("notblock");
       document.querySelector(".js-colores-S").classList.add("notblock");
       document.querySelector(".js-colores-M").classList.add("notblock");
       document.querySelector(".js-colores-L").classList.add("notblock");
       document.querySelector(".js-colores-XL").classList.add("notblock");
       document.querySelector(".js-colores-XXL").classList.add("notblock");
       document.querySelector(".js-colores-6").classList.add("notblock");
       document.querySelector(".js-colores-7").classList.add("notblock");
       document.querySelector(".js-colores-8").classList.add("notblock");
       document.querySelector(".js-colores-ÚNICO").classList.add("notblock");


	
        let seleccionado = $(this).parent().find('.js-btn-variation').html();
        talleseleccionado = seleccionado.trim();
		let selected  = $(this).parent().find('.js-btn-variation').html();
        let selected2 = ".btn-"+selected.trim();
    	$('.js-btn-variation').css( "border-color", "#abaaaa"  );
    	$('.js-btn-variation-color').css( "border-color", "#abaaaa"  );

    $('.js-color-'+colorselected).css( "border-color", "#abaaaa"  );

      $('.js-insta-variation-label-color').html(''); 


      	
    if(talleseleccionado === 'XS'){
	$(selected2).css( "border-color", "#ebabab" );
      $('.js-insta-variation-label').html(selected); 
      	document.querySelector(".js-colores-XS").classList.remove("notblock");

    }
    if(talleseleccionado === 'ÚNICO'){
	$(selected2).css( "border-color", "#ebabab" );
      $('.js-insta-variation-label').html(selected); 
      	document.querySelector(".js-colores-ÚNICO").classList.remove("notblock");

    }
    if(talleseleccionado == 'M'){
	$(selected2).css( "border-color", "#ebabab" );
      $('.js-insta-variation-label').html(selected); 
      	document.querySelector(".js-colores-M").classList.remove("notblock");

    }
      if(talleseleccionado == 'S'){
	$(selected2).css( "border-color", "#ebabab" );
      $('.js-insta-variation-label').html(selected); 
      	document.querySelector(".js-colores-S").classList.remove("notblock");

    }
       if(talleseleccionado == 'L'){
	$(selected2).css( "border-color", "#ebabab" );
      $('.js-insta-variation-label').html(selected); 
      	document.querySelector(".js-colores-L").classList.remove("notblock");

    }
     if(talleseleccionado == 'XL'){
	$(selected2).css( "border-color", "#ebabab" );
      $('.js-insta-variation-label').html(selected); 
      	document.querySelector(".js-colores-XL").classList.remove("notblock");

    }
     if(talleseleccionado == 'XXL'){
	$(selected2).css( "border-color", "#ebabab" );
      $('.js-insta-variation-label').html(selected); 
      	document.querySelector(".js-colores-XXL").classList.remove("notblock");

    }
     if(talleseleccionado == '6'){
	$(selected2).css( "border-color", "#ebabab" );
      $('.js-insta-variation-label').html(selected); 
      	document.querySelector(".js-colores-6").classList.remove("notblock");

    }
     if(talleseleccionado == '7'){
	$(selected2).css( "border-color", "#ebabab" );
      $('.js-insta-variation-label').html(selected); 
      	document.querySelector(".js-colores-7").classList.remove("notblock");

    }
     if(talleseleccionado == '8'){
	$(selected2).css( "border-color", "#ebabab" );
      $('.js-insta-variation-label').html(selected); 
      	document.querySelector(".js-colores-8").classList.remove("notblock");

    }
    if(seleccionado == 90){
$(selected2).css( "background-color", "black" );
		
      $('.js-insta-variation-label').html(selected); 
      	document.querySelector(".js-colores-90").classList.remove("notblock");



    }
    if(seleccionado == 95){
$(selected2).css( "background-color", "black" );
		
      $('.js-insta-variation-label').html(selected); 
      	document.querySelector(".js-colores-95").classList.remove("notblock");

    }
    if(seleccionado == 100){
$(selected2).css( "background-color", "black" );
		
      $('.js-insta-variation-label').html(selected); 
      	document.querySelector(".js-colores-100").classList.remove("notblock");

    }
    if(seleccionado == 105){
$(selected2).css( "background-color", "black" );
		
      $('.js-insta-variation-label').html(selected); 
      	document.querySelector(".js-colores-105").classList.remove("notblock");

    }
    if(seleccionado == 110){
$(selected2).css( "background-color", "black" );
		
      $('.js-insta-variation-label').html(selected); 
      	document.querySelector(".js-colores-110").classList.remove("notblock");

    }
    if(seleccionado == 115){
$(selected2).css( "background-color", "black" );
		
      $('.js-insta-variation-label').html(selected); 
      	document.querySelector(".js-colores-115").classList.remove("notblock");

    }
     if(seleccionado == 120){
 $(selected2).css( "background-color", "black" );
		
      $('.js-insta-variation-label').html(selected); 
      	document.querySelector(".js-colores-120").classList.remove("notblock");

    }

    

			if(this.value == "Retiro centro"){
				document.querySelector('#divMetodoPago').classList.remove("notblock");
			}
			if(this.value == "Retiro local"){
        		document.querySelector('#divMetodoPago').classList.remove("notblock");
			}
			if(this.value == "Envio correo"){
        		document.querySelector('#divMetodoPago').classList.remove("notblock");
			}
			if(this.value == "Envio domicilio"){
        		document.querySelector('#divMetodoPago').classList.remove("notblock");
			}
			
        });
    });
}
if(document.querySelector(".js-btn-var1iation-color")){
	let optcolor = document.querySelectorAll(".js-btn-vari1ation-color");
    optcolor.forEach(function(optcolor) {
        optcolor.addEventListener('click', function(){
       $(".btn-color").css( "border", "solid" );
           	$('.js-btn-variation-color').css( "border-color", "#abaaaa"  );


     

	
        let colorS = $(this).data('option');
		let selected  = $(this).parent().parent().parent().parent().find('.js-btn-variation').html();

        let seleccionado2 = $(this).parent().find('.js-btn-variation-color').html();

        colorseleccionado = colorS.trim();
        
    	 let colorselected = colorseleccionado.replace(/\s+/g, '-');

    	
        let jscolor = "'.js-color-"+colorseleccionado+"'";

    	$('.js-color-'+colorselected).css( "border-color", "#ebabab" );
    	      $('.js-insta-variation-label-color').html(colorseleccionado); 

    if(talleseleccionado == "80"){
	$(seleccionado2).css( "background-color", "black" );
		
      $('.js-insta-variation-label-color').html(colorseleccionado); 
      	document.querySelector(".js-colores-80").classList.remove("notblock");

    }
    if(talleseleccionado == 85){
	$(seleccionado2).css( "background-color", "black" );
		
      $('.js-insta-variation-label-color').html(colorseleccionado); 
      	document.querySelector(".js-colores-85").classList.remove("notblock");

    }
    if(talleseleccionado == 90){
$(seleccionado2).css( "background-color", "black" );
		
      $('.js-insta-variation-label-color').html(colorseleccionado); 
      	document.querySelector(".js-colores-90").classList.remove("notblock");



    }
    if(talleseleccionado == 95){
$(seleccionado2).css( "background-color", "black" );
		
      $('.js-insta-variation-label-color').html(colorseleccionado); 
      	document.querySelector(".js-colores-95").classList.remove("notblock");

    }
    if(talleseleccionado == 100){
$(seleccionado2).css( "background-color", "black" );
		
      $('.js-insta-variation-label-color').html(colorseleccionado); 
      	document.querySelector(".js-colores-100").classList.remove("notblock");

    }
    if(talleseleccionado == 105){
$(seleccionado2).css( "background-color", "black" );
		
      $('.js-insta-variation-label-color').html(colorseleccionado); 
      	document.querySelector(".js-colores-105").classList.remove("notblock");

    }
    if(talleseleccionado == 110){
$(seleccionado2).css( "background-color", "black" );
		
      $('.js-insta-variation-label-color').html(seleccionado); 
      	document.querySelector(".js-colores-110").classList.remove("notblock");

    }
    if(talleseleccionado == 115){
$(seleccionado2).css( "background-color", "black" );
		
      $('.js-insta-variation-label-color').html(seleccionado); 
      	document.querySelector(".js-colores-115").classList.remove("notblock");

    }
     if(talleseleccionado == 120){
 $(seleccionado2).css( "background-color", "black" );
		
      $('.js-insta-variation-label-color').html(seleccionado); 
      	document.querySelector(".js-colores-120").classList.remove("notblock");

    }
    if(colorseleccionado == "Rojo"){


      $('.js-insta-variation-label-color').html(colorseleccionado); 

    }
    if(colorseleccionado == "Azul"){

		
      $('.js-insta-variation-label-color').html(colorseleccionado); 

    }
    if(colorseleccionado == "Blanco"){

		
      $('.js-insta-variation-label-color').html(colorseleccionado); 

    }
    if(colorseleccionado == "Violeta"){

		
      $('.js-insta-variation-label-color').html(colorseleccionado); 

    }
    if(colorseleccionado == "Verde agua"){

		
      $('.js-insta-variation-label-color').html(colorseleccionado); 

    }
    if(colorseleccionado == "Negro"){

		
      $('.js-insta-variation-label-color').html(colorseleccionado); 

    }
    if(colorseleccionado == "Estampado negro y flores blancas"){

		
      $('.js-insta-variation-label-color').html(colorseleccionado); 

    }
    if(colorseleccionado == "Estampado negro y flores rosas"){

		
      $('.js-insta-variation-label-color').html(colorseleccionado); 

    }
   

			if(this.value == "Retiro centro"){
				document.querySelector('#divMetodoPago').classList.remove("notblock");
			}
			if(this.value == "Retiro local"){
        		document.querySelector('#divMetodoPago').classList.remove("notblock");
			}
			if(this.value == "Envio correo"){
        		document.querySelector('#divMetodoPago').classList.remove("notblock");
			}
			if(this.value == "Envio domicilio"){
        		document.querySelector('#divMetodoPago').classList.remove("notblock");
			}
			
        });
    });
}

$(document).on('click','.js-btn-variation', function(){ //esta función se ejecutará en todos los casos
    let seleccionado = $(this).data('option'); // Obtiene el valor del data-option del botón clickeado
	let seleccionadoHtml = $(this).text(); // Obtiene el texto dentro del botón clickeado, para ponerlo arriba

	talleseleccionado = seleccionado;
	$('.js-btn-variation').css( "border-color", "#abaaaa"  );
	$('.js-btn-variation-color').css( "border-color", "#abaaaa"  );
	const searchParams = new URLSearchParams(window.location.search);
	var urlCompleta = window.location.href;
	$('.js-insta-variation-label').html(seleccionadoHtml); 

	let selected = seleccionadoHtml.replace(/\//g, '-');
	
	let selected2 = ".btn-"+selected.trim();
	   $(selected2).css( "border-color", "#ebabab" );

	
	// Usando expresiones regulares
	var matches = urlCompleta.match(/\/producto\/(\d+)\//);
	var numeroProducto = matches ? matches[1] : null;


	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Tienda/getColoresTalleStockAjax/'; 
	let formData = new FormData();
	formData.append('talle',seleccionado);
	formData.append('producto',numeroProducto);
	newElementDisponibilidad = '';

	request.open("POST",ajaxUrl,true);
	request.send(formData);
	let newElement ="";
	let newElement2 ="";
	let newElement3 ="";
		request.onreadystatechange = function(){
				 if(request.readyState != 4) return;
				 if(request.status == 200){
					 let responseText = request.responseText;
				 var data = JSON.parse(responseText);
				 document.querySelector("#containerColor").classList.remove("notblock");

				 // Acceder a los nombres
				 var i = 0;
				 data.forEach(function(item) {
					 i = i+1;                
					 let nueva = item.nombre.replace(/ /g, "-")
					 console.log("chauuuu")
					 document.querySelector("#coloresInit").classList.add("notblock");

					 if(i >= 4 && i < 8){
					 console.log(i)

						 newElement2 += `
						 			<div  id="coloresInit2" class="mtext-106 row ml-0 justify-content-sm-start no-gutters">

										 <div class="col-auto disp" style="padding:0;">
										 <a data-option="${item.colorid}"  data-slide-index="${item.fotoreferencia}" class="js-btn-variation-color cambiarSlide btn-${nueva} btn btn-talle js-color-${nueva} mr-2 mb-3 TALLE id="${nueva}" name="transferencia" value="${nueva}">
										 ${item.nombre}
									 </a>
									 </div>
									 </div>

								`;
					 }else if(i >= 8){
													 console.log("hola")

						 newElement3 += `
						 <div  id="coloresInit2" class="mtext-106 row ml-0 justify-content-sm-start no-gutters">

										 <div class="col-auto disp" style="padding:0;">
										 <a data-option="${item.colorid}"  data-slide-index="${item.fotoreferencia}" class="js-btn-variation-color cambiarSlide btn-${nueva} btn btn-talle js-color-${nueva} mr-2 mb-3 TALLE id="${nueva}" name="transferencia" value="${nueva}">
										 ${item.nombre}
									 </a>
									 </div>									 </div>

								`;
					 }else{
						 newElement += `
						 <div  id="coloresInit2" class="mtext-106 row ml-0 justify-content-sm-start no-gutters">

										 <div class="col-auto disp" style="padding:0;">
										 <a data-option="${item.colorid}"  data-slide-index="${item.fotoreferencia}" class="js-btn-variation-color cambiarSlide btn-${nueva} btn btn-talle js-color-${nueva} mr-2 mb-3 TALLE id="${nueva}" name="transferencia" value="${nueva}">
										 ${item.nombre}
									 </a>
									 </div>
									 </div>

								`;
					 }
					 
	  
				 });

												 document.querySelector("#containerFilas").innerHTML = newElement; 
												 document.querySelector("#containerFilas2").innerHTML = newElement2; 
												 document.querySelector("#containerFilas3").innerHTML = newElement3; 


				 }
			 }

});
if(document.querySelector(".js-btn-variat1ion")){
    
	let optmetodo = document.querySelectorAll(".js-btn-variation");
    optmetodo.forEach(function(optmetodo) {
        optmetodo.addEventListener('click', function(){
       $(".btn").css( "background-color", "white" );
		document.querySelector("#containerColor").classList.add("notblock");
      $('.js-insta-variation-label-color').html(''); 
      
      $('.js-insta-variation-label-material').html(''); 
        $('.js-insta-variation-label').html(''); 



        let seleccionado = $(this).parent().find('.js-btn-variation').html();
        talleseleccionado = seleccionado.trim();
		let selectedNoReplace  = $(this).parent().find('.js-btn-variation').html();

        let selected = selectedNoReplace.replace(/\//g, '-');
        
        let selected2 = ".btn-"+selected.trim();

    	$('.js-btn-variation').css( "border-color", "#abaaaa"  );
    	$('.js-btn-variation-color').css( "border-color", "#abaaaa"  );
        const searchParams = new URLSearchParams(window.location.search);
        var urlCompleta = window.location.href;
        $('.js-insta-variation-label').html(talleseleccionado); 
	       $(selected2).css( "border-color", "#ebabab" );

        
        // Usando expresiones regulares
        var matches = urlCompleta.match(/\/producto\/(\d+)\//);
        var numeroProducto = matches ? matches[1] : null;
        let talleSeleccionadoReplace = talleseleccionado.replace(/\//g, '-');


        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Tienda/getColoresTalleStockAjax/'; 
        let formData = new FormData();
        formData.append('talle',talleseleccionado);
        formData.append('producto',numeroProducto);

        request.open("POST",ajaxUrl,true);
        request.send(formData);
        let newElement ="";
                let newElement2 ="";
                let newElement3 ="";

           request.onreadystatechange = function(){
                        if(request.readyState != 4) return;
                        if(request.status == 200){
                            let responseText = request.responseText;
                        var data = JSON.parse(responseText);
                        document.querySelector("#containerColor").classList.remove("notblock");

                        // Acceder a los nombres
                        var i = 0;
                        data.forEach(function(item) {
                            i = i+1;                
                            let nueva = item.nombre.replace(/ /g, "-")
                            console.log("chauuuu")
                            if(i >= 3 && i < 6){
                            console.log(i)

                                newElement2 += `
                                                <div class="col-auto disp" style="padding:0;">
                                                <a data-option="${item.nombre}"  data-slide-index="${item.fotoreferencia}" class="js-btn-variation-color cambiarSlide btn-${nueva} btn btn-talle js-color-${nueva} mr-2 mb-3 TALLE id="${nueva}" name="transferencia" value="${nueva}">
                                                ${item.nombre}
                                            </a>
                                            </div>
                                            
                                       `;
                            }else if(i >= 6){
                                                            console.log("hola")

                                newElement3 += `
                                                <div class="col-auto disp" style="padding:0;">
                                                <a data-option="${item.nombre}"  data-slide-index="${item.fotoreferencia}" class="js-btn-variation-color cambiarSlide btn-${nueva} btn btn-talle js-color-${nueva} mr-2 mb-3 TALLE id="${nueva}" name="transferencia" value="${nueva}">
                                                ${item.nombre}
                                            </a>
                                            </div>
                                       `;
                            }else{
                                newElement += `
                                                <div class="col-auto disp" style="padding:0;">
                                                <a data-option="${item.nombre}"  data-slide-index="${item.fotoreferencia}" class="js-btn-variation-color cambiarSlide btn-${nueva} btn btn-talle js-color-${nueva} mr-2 mb-3 TALLE id="${nueva}" name="transferencia" value="${nueva}">
                                                ${item.nombre}
                                            </a>
                                            </div>
                                       `;
                            }
                            
             
                        });
                                                        document.querySelector("#containerFilas").innerHTML = newElement; 
                                                        document.querySelector("#containerFilas2").innerHTML = newElement2; 
                                                        document.querySelector("#containerFilas3").innerHTML = newElement3; 


                        }
                    }


    

			
        });
    });
}
$(document).on('click','.js-btn-variation-color', function(){ //esta función se ejecutará en todos los casos
        $('.js-insta-variation-label-color').html(''); 

       $(".btn").css( "background-color", "white" );
		let seleccionadocolor = $(this).data('option'); // Obtiene el valor del data-option del botón clickeado

		alert(seleccionadocolor)
        colorseleccionado = seleccionadocolor;
		let colorSeleccionadoHtml = $(this).text(); // Obtiene el texto dentro del botón clickeado, para ponerlo arriba

        let colorsinespa = colorSeleccionadoHtml.replace(/ /g, "-")

		let selectedcolor  = $(this).parent().find('.js-btn-variation-color').html();
        let selectedbtncolor = ".btn-"+colorsinespa.trim();
    	$('.js-btn-variation-color').css( "border-color", "#abaaaa"  );
        const searchParams = new URLSearchParams(window.location.search);
        var urlCompleta = window.location.href;
 
       // let seleccionado = $(this).find('.js-btn-variation').html();
        //talleseleccionado = seleccionado.trim();

        // Usando expresiones regulares
        var matches = urlCompleta.match(/\/producto\/(\d+)\//);
        var numeroProducto = matches ? matches[1] : null;

        $('.js-insta-variation-label-color').html(colorSeleccionadoHtml); 
	       $(selectedbtncolor).css( "border-color", "#ebabab" );



    
});
/*==================================================================
[ +/- num product ]*/
$('.btn-num-product-down').on('click', function(){
    let numProduct = Number($(this).next().val());
    let idpr = this.getAttribute('idpr');
    if(numProduct > 1) $(this).next().val(numProduct - 1);
    let cant = $(this).next().val();
    if(idpr != null){
    	fntUpdateCant(idpr,cant);
    }
});

$('.btn-num-product-up').on('click', function(){
    let numProduct = Number($(this).prev().val());
    let idpr = this.getAttribute('idpr');
    $(this).prev().val(numProduct + 1);
    let cant = $(this).prev().val();
	if(idpr != null){
    	fntUpdateCant(idpr,cant);
    }
});

//Actualizar producto
if(document.querySelector(".num-product")){
	let inputCant = document.querySelectorAll(".num-product");
	inputCant.forEach(function(inputCant) {
		inputCant.addEventListener('keyup', function(){
			let idpr = this.getAttribute('idpr');
			let cant = this.value;
			if(idpr != null){
		    	fntUpdateCant(idpr,cant);
		    }
		});
	});
}

if(document.querySelector("#formRegister")){
    let formRegister = document.querySelector("#formRegister");
    formRegister.onsubmit = function(e) {
        e.preventDefault();
        let strNombre = document.querySelector('#txtNombre').value;
        let strApellido = document.querySelector('#txtApellido').value;
        let strEmail = document.querySelector('#txtEmailCliente').value;
        let intTelefono = document.querySelector('#txtTelefono').value;

        if(strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '' )
        {
            swal("Atención", "Todos los campos son obligatorios." , "error");
            return false;
        }

        let elementsValid = document.getElementsByClassName("valid");
        for (let i = 0; i < elementsValid.length; i++) { 
            if(elementsValid[i].classList.contains('is-invalid')) { 
                swal("Atención", "Por favor verifique los campos en rojo." , "error");
                return false;
            } 
        } 
        divLoading.style.display = "flex";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Tienda/registro'; 
        let formData = new FormData(formRegister);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    window.location.reload(false);
                }else{
                    swal("Error", objData.msg , "error");
                }
            }
            divLoading.style.display = "none";
            return false;
        }
    }
}


function fntdelItem(element){
	//Option 1 = Modal
	//Option 2 = Vista Carrito
	let option = element.getAttribute("op");
	let idpr = element.getAttribute("idpr");
	if(option == 1 || option == 2 ){

		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	    let ajaxUrl = base_url+'/Tienda/delCarrito'; 
	    let formData = new FormData();
	    formData.append('id',idpr);
	    formData.append('option',option);
	    request.open("POST",ajaxUrl,true);
	    request.send(formData);
	    request.onreadystatechange = function(){
	        if(request.readyState != 4) return;
	        if(request.status == 200){
	        	let objData = JSON.parse(request.responseText);
	        	if(objData.status){
	        		if(option == 1){
			            document.querySelector("#productosCarrito").innerHTML = objData.htmlCarrito;
			            const cants = document.querySelectorAll(".cantCarrito");
						cants.forEach(element => {
							element.setAttribute("data-notify",objData.cantCarrito)
						});
	        		}else{
	        			element.parentNode.parentNode.remove();
	        			document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
	        			document.querySelector("#totalCompra").innerHTML = objData.total;
	        			if(document.querySelectorAll("#tblCarrito tr").length == 1){
	            			window.location.href = base_url;
	            		}
	        		}
	        	}else{
	        		swal("", objData.msg , "error");
	        	}
	        } 
	        return false;
	    }

	}
}

function fntUpdateCant(pro,cant){
	if(cant <= 0){
		document.querySelector("#btnComprar").classList.add("notblock");
	}else{
		document.querySelector("#btnComprar").classList.remove("notblock");
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	    let ajaxUrl = base_url+'/Tienda/updCarrito'; 
	    let formData = new FormData();
	    formData.append('id',pro);    
	   	formData.append('cantidad',cant);
	   	request.open("POST",ajaxUrl,true);
	    request.send(formData);
	    request.onreadystatechange = function(){
	    	if(request.readyState != 4) return;
	    	if(request.status == 200){
	    		let objData = JSON.parse(request.responseText);
	    		if(objData.status){
	    			let colSubtotal = document.getElementsByClassName(pro)[0];
	    			colSubtotal.cells[4].textContent = objData.totalProducto;
	    			document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
	    			document.querySelector("#totalCompra").innerHTML = objData.total;
	    		}else{
	    			swal("", objData.msg , "error");
	    		}
	    	}

	    }
	}
	return false;
}




if(document.querySelector("#condiciones")){
	let opc = document.querySelector("#condiciones");
	opc.addEventListener('click', function(){
		let opcion = this.checked;

		if(opcion){
		    if(document.querySelector("#retirolocal").checked == true || document.querySelector("#retirocentro").checked == true){
		        document.querySelector('#datosFact2').classList.remove("notblock");
			document.querySelector("#datosFact2").scrollIntoView({ behavior: "smooth",block: "start",});
		    }else{
		        document.querySelector('#datosFact').classList.remove("notblock");
			document.querySelector("#datosFact").scrollIntoView({ behavior: "smooth",block: "start",});
		    }
			
			
		}else{
			document.querySelector('#datosFact').classList.add("notblock");
		}
	});
}
function fntViewPago(){
	let direccion = document.querySelector("#txtDireccion").value;
	let ciudad = document.querySelector("#txtCiudad").value;
	if(direccion == "" || ciudad == ""){
		document.querySelector('#divMetodoPago').classList.add("notblock");
	}else{
		document.querySelector('#divMetodoPago').classList.remove("notblock");
	}}
if(document.querySelector("#continuar")){
	let opt = document.querySelector("#continuar");
	opt.addEventListener('click', function(){
		let opcion = this.checked;
		if(opcion){
			document.querySelector('#divPago').classList.remove("notblock");
		}else{
			document.querySelector('#divPago').classList.add("notblock");
		}
	});
}
if(document.querySelector("#continuar")){
	let opt = document.querySelector("#continuar");
	opt.addEventListener('click', function(){
		let opcion = this.checked;
		if(opcion){
			document.querySelector('#divPago').classList.remove("notblock");
		}else{
			document.querySelector('#divPago').classList.add("notblock");
		}
	});
}
$('.opcionEnvio').on('click', function(e){
	alert("o")
	alert(this.value)
	alert(this.checked)
	if(this.checked){
		let envioSelected = this.value
		let ajaxUrl = base_url+'/Tienda/getEnvioSelected/'+envioSelected;
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let newElement = "";

		request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
			if(request.readyState != 4) return;
            if(request.readyState == 4 && request.status == 200){
				let responseText = request.responseText;
			var data = JSON.parse(responseText);
			$('.envio-option').hide();

				data.forEach(function(item) {

				newElement += `
			
						<div class="envio-option">
									<label  class="span-check-local" >
										
										<span style="font-family:Poppins-Medium; font-size:14px; text-align: center;"><b><input style="display:inline;" type="checkbox" checked class="opcionEnvio"  id="retirolocal" name="retirolocal" value=${item.idtipoenvio} >
										 ${item.nombre}</b></span>
										<br>
										<span style="font-family:Poppins-Medium;display:flex;cursor:pointer;">       ${item.descripcion} </span>
									</label>
						</div>
					   `;
            	});
			}
			document.querySelector("#containerFilasEnvio").innerHTML = newElement; 
			document.querySelector('#divMetodoPago').classList.remove("notblock");

        }
	}else{

	}
			if(this.value == "Retiro centro"){
				document.querySelector('#divMetodoPago').classList.remove("notblock");
        			$("#enviocorreo").prop( "checked", false );
				$("#retirolocal").prop( "checked", false );
				$("#enviodomicilio").prop( "checked", false );
				$(".span-check-centro").css( "font-size", "16px" );
				$(".span-check-centro").css( "padding", "10px");

				$(".span-check-centro").css( "box-shadow", "-1px -1px 18px 7px #e193dc");
				$(".span-check-centro").css( "transition", "box-shadow 0.3s ease-in-out" );
                if($("#retirocentro").is(":checked")){
                 				$(".span-check-centro").css( "padding", "10px");

    				$(".span-check-centro").css( "box-shadow", "-1px -1px 18px 7px #e193dc");
    				$(".span-check-centro").css( "transition", "box-shadow 0.3s ease-in-out" );	
    				$(".span-check-centro").css( "font-size", "16px" );
                }else{
                   				$(".span-check-centro").css( "padding", "0px");

    				 $(".span-check-centro").css( "box-shadow", "none" );
    				$(".span-check-centro").css( "font-size", "14px" );
                }
                
				$(".span-check-local").css( "box-shadow", "none"  );
				$(".span-check-dcilio").css( "box-shadow", "none"  );
				$(".span-check-correo").css( "box-shadow", "none"  );
					$(".span-check-local").css( "font-size", "14px" );
				$(".span-check-dcilio").css( "font-size", "14px" );
				$(".span-check-correo").css("font-size", "14px"  );

			}
			if(this.value == "Retiro local"){
        		document.querySelector('#divMetodoPago').classList.remove("notblock");
        			$("#enviocorreo").prop( "checked", false );
				$("#retirocentro").prop( "checked", false );
				$("#enviodomicilio").prop( "checked", false );
				$(".span-check-local").css( "font-size", "16px" );
				$(".span-check-local").css( "padding", "10px");

				$(".span-check-local").css( "box-shadow", "-1px -1px 18px 7px #e193dc");
				$(".span-check-local").css( "transition", "box-shadow 0.3s ease-in-out" );
                if($("#retirolocal").is(":checked")){
                 				$(".span-check-local").css( "padding", "10px");

    				$(".span-check-local").css( "box-shadow", "-1px -1px 18px 7px #e193dc");
    				$(".span-check-local").css( "transition", "box-shadow 0.3s ease-in-out" );	
    				$(".span-check-local").css( "font-size", "16px" );
                }else{
                   				$(".span-check-local").css( "padding", "0px");

    				 $(".span-check-local").css( "box-shadow", "none" );
    				$(".span-check-local").css( "font-size", "14px" );
                }
				$(".span-check-centro").css( "box-shadow", "none"  );
				$(".span-check-dcilio").css( "box-shadow", "none"  );
				$(".span-check-correo").css( "box-shadow", "none"  );
					$(".span-check-centro").css( "font-size", "14px" );
				$(".span-check-dcilio").css( "font-size", "14px" );
				$(".span-check-correo").css("font-size", "14px"  );
				$(".span-check-correo").css("padding", "0px"  );
				$(".span-check-dcilio").css("padding", "0px"  );
				$(".span-check-centro").css("padding", "0px"  );


			}
			if(this.value == "Envio correo"){
        		document.querySelector('#divMetodoPago').classList.remove("notblock");
        			$("#retirocentro").prop( "checked", false );
				$("#retirolocal").prop( "checked", false );
				$("#enviodomicilio").prop( "checked", false );
				$(".span-check-correo").css( "font-size", "16px" );
				$(".span-check-correo").css( "padding", "10px" );

				$(".span-check-correo").css( "box-shadow", "-1px -1px 18px 7px #e193dc");
				$(".span-check-correo").css( "transition", "box-shadow 0.3s ease-in-out" );
                if($("#enviocorreo").is(":checked")){
                 				$(".span-check-correo").css( "padding", "10px" );

    				$(".span-check-correo").css( "box-shadow", "-1px -1px 18px 7px #e193dc");
    				$(".span-check-correo").css( "transition", "box-shadow 0.3s ease-in-out" );	
    				$(".span-check-correo").css( "font-size", "16px" );
                }else{
                   				$(".span-check-correo").css( "padding", "0px" );

    				 $(".span-check-correo").css( "box-shadow", "none" );
    				$(".span-check-correo").css( "font-size", "14px" );
                }

				$(".span-check-local").css( "box-shadow", "none"  );
				$(".span-check-dcilio").css( "box-shadow", "none"  );
				$(".span-check-centro").css( "box-shadow", "none"  );
					$(".span-check-local").css( "font-size", "14px" );
				$(".span-check-dcilio").css( "font-size", "14px" );
				$(".span-check-centro").css("font-size", "14px"  );
							$(".span-check-local").css("padding", "0px"  );
				$(".span-check-dcilio").css("padding", "0px"  );
				$(".span-check-centro").css("padding", "0px"  );
			}
			if(this.value == "Envio domicilio"){
        		document.querySelector('#divMetodoPago').classList.remove("notblock");
        				$("#retirocentro").prop( "checked", false );
				$("#retirolocal").prop( "checked", false );
				$("#enviocorreo").prop( "checked", false );
		        $(".span-check-dcilio").css( "font-size", "16px" );
		        		        $(".span-check-dcilio").css( "padding", "10px" );

                if($("#enviodomicilio").is(":checked")){
                 
    				$(".span-check-dcilio").css( "box-shadow", "-1px -1px 18px 7px #e193dc");
    				$(".span-check-dcilio").css( "transition", "box-shadow 0.3s ease-in-out" );	
    				$(".span-check-dcilio").css( "font-size", "16px" );
                }else{
                   
    				 $(".span-check-dcilio").css( "box-shadow", "none" );
    				$(".span-check-dcilio").css( "font-size", "14px" );
                }
				$(".span-check-local").css( "box-shadow", "none"  );
				$(".span-check-correo").css( "box-shadow", "none"  );
				$(".span-check-centro").css( "box-shadow", "none"  );
					$(".span-check-local").css( "font-size", "14px" );
				$(".span-check-correo").css( "font-size", "14px" );
				$(".span-check-centro").css("font-size", "14px"  );
							$(".span-check-correo").css("padding", "0px"  );
				$(".span-check-local").css("padding", "0px"  );
				$(".span-check-centro").css("padding", "0px"  );
			}
	

});
$('.opcionPago').on('click', function(e){
    				 $(".span-check-acordar").css( "box-shadow", "none" );
    				 $(".span-check-transferencia").css( "box-shadow", "none" );
			if(this.value == "Transferencia bancaria"){

				$("#acordar").prop( "checked", false );
	
				
			}
			if(this.value == "Acordar pago"){
        			$("#transferencia").prop( "checked", false );

			}

			if(this.value == "Transferencia bancaria"){
        			$("#acordar").prop( "checked", false );
			
				$(".span-check-transferencia").css( "font-size", "16px" );
                
                if($("#transferencia").is(":checked")){
				$(".span-check-transferencia").css( "box-shadow", "-1px -1px 18px 7px #e193dc");
				$(".span-check-transferencia").css( "transition", "box-shadow 0.3s ease-in-out" );
                }
                if($("#acordar").is(":checked")){
                 
    				$(".span-check-acordar").css( "box-shadow", "-1px -1px 18px 7px #e193dc");
    				$(".span-check-acordar").css( "transition", "box-shadow 0.3s ease-in-out" );	
    				$(".span-check-acordar").css( "font-size", "16px" );
                }else{
                   
    				 $(".span-check-acordar").css( "box-shadow", "none" );
    				$(".span-check-acordar").css( "font-size", "14px" );
                }
                
				$(".span-check-acordar").css( "box-shadow", "none"  );
			
			
					$(".span-check-transferencia").css( "font-size", "14px" );
				$(".span-check-acordar").css("font-size", "14px"  );

			}
			if(this.value == "Acordar pago"){

        	   $("#transferencia").prop( "checked", false );

				$(".span-check-acordar").css( "font-size", "16px" );
                if($("#acordar").is(":checked")){

				$(".span-check-acordar").css( "box-shadow", "-1px -1px 18px 7px rgba(0, 0, 255, .2)");
				$(".span-check-acordar").css( "transition", "box-shadow 0.3s ease-in-out" );
                }
                if($("#transferencia").is(":checked")){
                 
    				$(".span-check-transferencia").css( "box-shadow", "-1px -1px 18px 7px rgba(0, 0, 255, .2)");
    				$(".span-check-transferencia").css( "transition", "box-shadow 0.3s ease-in-out" );	
    				$(".span-check-transferencia").css( "font-size", "16px" );
                }else{
                   
    				 $(".span-check-transferencia").css( "box-shadow", "none" );
    				$(".span-check-transferencia").css( "font-size", "14px" );
                   }
				$(".span-check-transferencia").css( "box-shadow", "none"  );
					$(".span-check-transferencia").css( "font-size", "14px" );
				$(".span-check-acordar").css("font-size", "14px"  );


			}
});
if(document.querySelector(".opcionEnvio")){
	let optmetodo = document.querySelectorAll(".opcionEnvio");
    optmetodo.forEach(function(optmetodo) {
        optmetodo.addEventListener('click', function(){
            	document.querySelector('#datosFact2').classList.add("notblock");
		        document.querySelector('#datosFact').classList.add("notblock");

		if(document.querySelector("#condiciones").checked == true){
		      if(document.querySelector("#retirolocal").checked == true || document.querySelector("#retirocentro").checked == true){
		        document.querySelector('#datosFact2').classList.remove("notblock");
			document.querySelector("#datosFact2").scrollIntoView({ behavior: "smooth",block: "start",});
		    }else{
		        document.querySelector('#datosFact').classList.remove("notblock");
			document.querySelector("#datosFact").scrollIntoView({ behavior: "smooth",block: "start",});
		    }
		}
			if(this.value == "Retiro centro"){
				document.querySelector('#divMetodoPago').classList.remove("notblock");
			
				
			}
			if(this.value == "Retiro local"){
        		document.querySelector('#divMetodoPago').classList.remove("notblock");
			}
			if(this.value == "Envio correo"){
        		document.querySelector('#divMetodoPago').classList.remove("notblock");
			}
			if(this.value == "Envio domicilio"){
        		document.querySelector('#divMetodoPago').classList.remove("notblock");
			}
			
        });
    });
}
if(document.querySelector(".opcionPago")){
	let optmetodoPago = document.querySelectorAll(".opcionPago");
    optmetodoPago.forEach(function(optmetodoPago) {
        optmetodoPago.addEventListener('click', function(){
            document.querySelector('#divConfirmarPago').classList.remove("notblock");
            pagoseleccionado = this.value

        	if(this.value == "transferencia"){

        		document.querySelector('#divConfirmarPago').classList.remove("notblock");
			}
			if(this.value == "acordar"){

        		document.querySelector('#divConfirmarPago').classList.remove("notblock");

			}
	
			
        });
    });
}
// function fntViewPago(){
// 	let direccion = document.querySelector("#retiro").value;
// 	let ciudad = document.querySelector("#entrelocal").value;
// 	console.log(document.querySelector("#entrelocal").value);
// 	if(direccion == "" || ciudad == ""){
// 		document.querySelector('#divMetodoPago').classList.remove("notblock");
// 	}
// }


if(document.querySelector("#btnComprar")){
	let btnPago = document.querySelector("#btnComprar");
	btnPago.addEventListener('click',function() { 

	   
        tipopago = pagoseleccionado

	    if( tipopago == ""){
			swal("", "Seleccione un tipo de pago	" , "error");
			return;
		}else{
			divLoading.style.display = "flex";
			let request = (window.XMLHttpRequest) ? 
	                    new XMLHttpRequest() : 
	                    new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Tienda/procesarPedido';
			let formData = new FormData();
		    formData.append('tipopago',tipopago);    
		   	request.open("POST",ajaxUrl,true);
		    request.send(formData);
		    request.onreadystatechange = function(){
		    	if(request.readyState != 4) return;
		    	if(request.status == 200){
		    		let objData = JSON.parse(request.responseText);
		    		if(objData.status){
		    			window.location = base_url+"/tienda/confirmarpedido/";
		    		}else{
		    			swal("", objData.msg , "error");
		    		}
		    	}
		    	divLoading.style.display = "none";
            	return false;
		    }
		}

	},false);
}
if(document.querySelector("#formDatos")){
    let formDatos = document.querySelector("#formDatos");
	var tipoenvio = "";
    formDatos.onsubmit = function(e) {
        e.preventDefault();
    	let seleccionado = document.querySelectorAll(".opcionEnvio").value;
        checked1=false;
        checked2=false;
        checked3=false;
        checked4=false;
		if($('#retirolocal').is(':checked') == true){
			var tipoenvio = "entregalocal";
			var checked1 = true;
		}
		if($('#retirocentro').is(':checked') == true){
			var tipoenvio = "retirocentro";
			var checked2 = true;
		}
		if($('#enviocorreo').is(':checked') == true){
			var tipoenvio = "enviocorreo";
			var checked3 = true;
		}
        if($('#enviodomicilio').is(':checked') == true){
			var tipoenvio = "enviodomicilio";
			var checked4 = true;
		}
		if(checked1 == true && checked2 == true || checked1 == true && checked3 == true || checked1 == true && checked4 == true || checked2 == true && checked3 == true ||  
		 checked2 == true && checked4 == true || checked1 == true && checked2 == true && checked3 == true && checked4 == true){
		    swal("", "Solo puede seleccionar un tipo de envio" , "error");
			return;
		}
		if(checked1 == false && checked2 == false && checked3 == false && checked4 == false){
		     swal("", "Tenes que seleccionar al menos un tipo de envio" , "error");
			return;
		}
		let strEmail = document.querySelector('#txtEmail').value;
		let strPais = document.querySelector('#txtPais').value;
		let intDni = document.querySelector('#txtDni').value;
		let strNombre = document.querySelector('#txtNombre').value;
		let strApellido = document.querySelector('#txtApellido').value;
		let intTelefono = document.querySelector('#txtTelefono').value;
		let strCalle = document.querySelector('#txtCalle').value;
		let intNumero = document.querySelector('#txtNumero').value;
		let strBarrio = document.querySelector('#txtBarrio').value;
		let strCiudad = document.querySelector('#txtCiudad').value;
		let intCP = document.querySelector('#txtCP').value;
		let strProvincia = document.querySelector('#txtProvincia').value;

	    // let ciudad = document.querySelector("#txtCiudad").value;
	    // let inttipopago = document.querySelector("#listtipopago").value; 
	    if(tipoenvio == "enviodomicilio"){
	         if( tipoenvio == "" || strEmail == "" || strPais == "" || intDni == "" || strNombre == "" || strApellido == "" || intTelefono == ""
		    || strCalle == "" || intNumero == "" || strCiudad == "" || intCP == "" || strProvincia == ""){
		     var error = true;   
		    }
	    }
	    if(tipoenvio == "retirocentro"){
	         if( tipoenvio == "" || strEmail == "" || strNombre == "" || strApellido == "" || intTelefono == "" || intDni == ""){
		     var error = true;   
		    }
	    }
	    if(tipoenvio == "entregalocal"){
	         if( tipoenvio == "" || strEmail == "" || strNombre == "" || strApellido == "" || intTelefono == "" || intDni == ""){
		     var error = true;   
		    }
	    }
	     if(tipoenvio == "enviocorreo"){
	         if( tipoenvio == "" || strEmail == "" || strPais == "" || intDni == "" || strNombre == "" || strApellido == "" || intTelefono == ""
		    || strCalle == "" || intNumero == "" || strCiudad == "" || intCP == "" || strProvincia == ""){
		     var error = true;   
		    }
	    }
	   
	    if(error == true){
			swal("", "Complete datos de envío" , "error");
			return;
		
		}else{
			divLoading.style.display = "flex";
			let request = (window.XMLHttpRequest) ? 
	                    new XMLHttpRequest() : 
	                    new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Tienda/procesarEnvio';
			let formData = new FormData();
		    formData.append('tipoenvio',tipoenvio);    
			formData.append('email',strEmail);    
			formData.append('pais',strPais);    
			formData.append('dni',intDni);    
			formData.append('nombre',strNombre);    
			formData.append('apellido',strApellido);  
			formData.append('telefono',intTelefono);    
			formData.append('calle',strCalle);    
			formData.append('numero',intNumero);    
			formData.append('barrio',strBarrio);    
			formData.append('ciudad',strCiudad);    
			formData.append('codigopostal',intCP);    
			formData.append('provincia',strProvincia);    

		   	request.open("POST",ajaxUrl,true);
		    request.send(formData);
		    request.onreadystatechange = function(){
		    	if(request.readyState != 4) return;
		    	if(request.status == 200){
		    		let objData = JSON.parse(request.responseText);
		    		if(objData.status){
		    			window.location = base_url+"/carrito/confirmarpago/";
		    		}else{
		    			swal("", objData.msg , "error");
		    		}
		    	}
		    	divLoading.style.display = "none";
            	return false;
		    }
		}

	},false;
}
if(document.querySelector("#formDatos2")){
    let formDatos2 = document.querySelector("#formDatos2");
	var tipoenvio = "";
    formDatos2.onsubmit = function(e) {
        e.preventDefault();
    	let seleccionado = document.querySelectorAll(".opcionEnvio").value;
        checked1=false;
        checked2=false;
        checked3=false;
        checked4=false;
		if($('#retirolocal').is(':checked') == true){
			var tipoenvio2 = "entregalocal";
			var checked1 = true;
		}
		if($('#retirocentro').is(':checked') == true){
			var tipoenvio2 = "retirocentro";
			var checked2 = true;
		}
		
		if(checked1 == true && checked2 == true || checked1 == true && checked3 == true || checked1 == true && checked4 == true || checked2 == true && checked3 == true ||  
		 checked2 == true && checked4 == true || checked1 == true && checked2 == true && checked3 == true && checked4 == true){
		    swal("", "Solo puede seleccionar un tipo de envio" , "error");
			return;
		}
		if(checked1 == false && checked2 == false && checked3 == false && checked4 == false){
		     swal("", "Tenes que seleccionar al menos un tipo de envio" , "error");
			return;
		}
		let strEmail2 = document.querySelector('#txtEmail2').value;
		let intDni2 = document.querySelector('#txtDni2').value;
		let strNombre2 = document.querySelector('#txtNombre2').value;
		let strApellido2 = document.querySelector('#txtApellido2').value;
		let intTelefono2 = document.querySelector('#txtTelefono2').value;
		
	    // let ciudad = document.querySelector("#txtCiudad").value;
	    // let inttipopago = document.querySelector("#listtipopago").value; 
	    if(tipoenvio2 == "retirocentro"){
	         if( tipoenvio2 == "" || strEmail2 == "" || strNombre2 == "" || strApellido2 == "" || intTelefono2 == "" || intDni2 == ""){
		     var error = true;   
		    }
	    }
	    if(tipoenvio2 == "entregalocal"){
	         if( tipoenvio2 == "" || strEmail2 == "" || strNombre2 == "" || strApellido2 == "" || intTelefono2 == "" || intDni2 == ""){
		     var error = true;   
		    }
	    }

	    if(error == true){
			swal("", "Complete datos de envío" , "error");
			return;
		
		}else{
			divLoading.style.display = "flex";
			let request = (window.XMLHttpRequest) ? 
	                    new XMLHttpRequest() : 
	                    new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Tienda/procesarEnvio';
			let formData2 = new FormData();
		    formData2.append('tipoenvio',tipoenvio2);    
			formData2.append('email',strEmail2);    
			formData2.append('dni',intDni2);    
			formData2.append('nombre',strNombre2);    
			formData2.append('apellido',strApellido2);  
			formData2.append('telefono',intTelefono2);    
			

		   	request.open("POST",ajaxUrl,true);
		    request.send(formData2);
		    request.onreadystatechange = function(){
		    	if(request.readyState != 4) return;
		    	if(request.status == 200){
		    		let objData = JSON.parse(request.responseText);
		    		if(objData.status){
		    			window.location = base_url+"/carrito/confirmarpago/";
		    		}else{
		    			swal("", objData.msg , "error");
		    		}
		    	}
		    	divLoading.style.display = "none";
            	return false;
		    }
		}

	},false;
}

if(document.querySelector("#frmSuscripcion")){
	let frmSuscripcion = document.querySelector("#frmSuscripcion");
	frmSuscripcion.addEventListener('submit',function(e) { 
		e.preventDefault();

		let nombre = document.querySelector("#nombreSuscripcion").value;
		let email = document.querySelector("#emailSuscripcion").value;

		if(nombre == ""){
			swal("", "El nombre es obligatorio" ,"error");
			return false;
		}

		if(!fntEmailValidate(email)){
			swal("", "El email no es válido." ,"error");
			return false;
		}	
		
		divLoading.style.display = "flex";
		let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Tienda/suscripcion';
		let formData = new FormData(frmSuscripcion);
	   	request.open("POST",ajaxUrl,true);
	    request.send(formData);
	    request.onreadystatechange = function(){
	    	if(request.readyState != 4) return;
	    	if(request.status == 200){
	    		let objData = JSON.parse(request.responseText);
	    		if(objData.status){
	    			swal("", objData.msg , "success");
                	document.querySelector("#frmSuscripcion").reset();
	    		}else{
	    			swal("", objData.msg , "error");
	    		}
	    	}
	    	divLoading.style.display = "none";
        	return false;
	    
		}

	},false);
}
if(document.querySelector("#formNewsletter")){
	let formNewsletter = document.querySelector("#formNewsletter");
	formNewsletter.onsubmit = function(e) {
		e.preventDefault();
		let strNombre = document.querySelector('#txtNombre').value;
		let strEmail = document.querySelector('#txtCorreo').value;
		
		if(strNombre == '' || strEmail == '')
		{
			swal("Atención", "Todos los campos son obligatorios." , "error");
			return false;
		}

		 
		divLoading.style.display = "flex";
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Tienda/suscripcion'; 
		let formData = new FormData(formNewsletter);
		request.open("POST",ajaxUrl,true);
		request.send(formData);
		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				let objData = JSON.parse(request.responseText);
				if(objData.status)
				{
					$('#modalInicio').modal("hide");
					formNewsletter.reset();

					swal("Suscripto!", objData.msg ,"success");
				}else{
					swal("Error", objData.msg , "error");
				}
			}
			divLoading.style.display = "none";
			return false;
		}
	}
}

if(document.querySelector("#frmContacto")){
	let frmContacto = document.querySelector("#frmContacto");
	frmContacto.addEventListener('submit',function(e) { 
		e.preventDefault();

		let nombre = document.querySelector("#nombreContacto").value;
		let email = document.querySelector("#emailContacto").value;
		let mensaje = document.querySelector("#mensaje").value;

		if(nombre == ""){
			swal("", "El nombre es obligatorio" ,"error");
			return false;
		}

		if(!fntEmailValidate(email)){
			swal("", "El email no es válido." ,"error");
			return false;
		}

		if(mensaje == ""){
			swal("", "Por favor escribe el mensaje." ,"error");
			return false;
		}	
		
		divLoading.style.display = "flex";
		let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Tienda/contacto';
		let formData = new FormData(frmContacto);
	   	request.open("POST",ajaxUrl,true);
	    request.send(formData);
	    request.onreadystatechange = function(){
	    	if(request.readyState != 4) return;
	    	if(request.status == 200){
	    		let objData = JSON.parse(request.responseText);
	    		if(objData.status){
	    			swal("", objData.msg , "success");
                	document.querySelector("#frmContacto").reset();
	    		}else{
	    			swal("", objData.msg , "error");
	    		}
	    	}
	    	divLoading.style.display = "none";
        	return false;
		}

	},false);
}
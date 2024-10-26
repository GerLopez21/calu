let tableCupones;
let rowTable = "";
    tableCupones = $('#tableCupones').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Cupones/getCupones",
            "dataSrc":""
        },
        "columns":[
            {"data":"idcupon"},
            {"data":"nombre"},
            {"data":"options"}

        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  ,
    });
      if(document.querySelector("#formCupones")){
        let formCupones = document.querySelector("#formCupones");
        formCupones.onsubmit = function(e) {
            e.preventDefault();
            let strTitulo = document.querySelector('#txtTitulo').value;
            var intCategorias= "todas";
            var intProductos = "todos";
            if($('.opcionProductos').is(':checked')){
                alert($('.opcionProductos').is(':checked'))
                var intCategorias = document.querySelector('#listCategoria').value;
                var intProductos = document.querySelector('#listProductos').value;
            }
          
            let intStatus = document.querySelector('#listStatus').value;
         
             let intTipoCupon = document.querySelector('#listTipoCupon').value;
             let minCompra = document.querySelector('#txtMinCompra').value;
             let minProductos = document.querySelector('#txtMinProductos').value;
             let stockPromo = document.querySelector('#txtStockPromo').value;
             let fechaInicio = document.querySelector('#txtFechaInicio').value;
             let fechaFin = document.querySelector('#txtFechaFin').value;
             let montoFijo = document.querySelector('#txtMontoFijo').value;
             let porcentajeCupon = document.querySelector('#txtPorcentajeCupon').value;
        

            if(strTitulo == '' || intStatus == '' || intTipoCupon == '')
            {
                swal("Atención", "Los campos nombre, estado y tipo de cupon son obligatorios" , "error");
                return false;
            }
            if($('.opcionProductos').is(':checked') && (intCategorias == '' || intProductos == '')){
                swal("Atención", "No se puede elegir la opción productos específicos y no elegir productos o categorías" , "error");
                return false;
            }
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Cupones/setCupon'; 
            let formData = new FormData(formCupones);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        alert("a")
                        swal("", objData.msg ,"success");

                        if(rowTable == ""){
                            tableCupones.api().ajax.reload();
                        }else{
                         
                          
                            rowTable.cells[1].textContent = txtTitulo;
                            

                            rowTable = ""; 
                        }
                      

                    }else{
                        alert("b")
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }
window.addEventListener('load', function() {
       fntProductos();
       fntCategorias();
}, false);

function fntProductos(){
    if(document.querySelector('#listProductos')){
        let ajaxUrl = base_url+'/Productos/getSelectProductos';
        let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listProductos').innerHTML = request.responseText;
                $('#listProductos').selectpicker('render');
            }
        }
    }
}
function fntCategorias(){
    if(document.querySelector('#listCategoria')){
        let ajaxUrl = base_url+'/Categorias/getSelectCategorias';
        let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listCategoria').innerHTML = request.responseText;
                $('#listCategoria').selectpicker('render');
            }
        }
    }
}
//Para abrir div monto fijo o cupon
if(document.querySelector("#listTipoCupon")){

	let tipodesc3 = document.querySelector("#listTipoCupon");

	tipodesc3.addEventListener('change', function(){
		document.querySelector('#divMontoFijo').classList.add("notblock");
		document.querySelector('#divPorcCupon').classList.add("notblock");

	    if(document.querySelector("#listTipoCupon").value == 1){
			document.querySelector('#divMontoFijo').classList.remove("notblock");
        }
       if(document.querySelector("#listTipoCupon").value == 2){
			document.querySelector('#divPorcCupon').classList.remove("notblock");
        }    


	});
}
function fntEditCupon(idcupon){

    document.querySelector('#titleModal').innerHTML ="Actualizar cupon";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    var idcupon = idcupon;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl  = base_url+'/Cupones/getCupon/'+idcupon;
    request.open("GET",ajaxUrl ,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){

            var objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#idcupon").value = objData.data.idcupon;
                document.querySelector("#txtTitulo").value = objData.data.nombre;
                document.querySelector("#listCategoria").value = objData.data.categorias;
                document.querySelector("#listProductos").value = objData.data.productos;
                document.querySelector("#listStatus").value = objData.data.estado;
                document.querySelector("#listTipoCupon").value = objData.data.tipo;
                if(objData.data.tipo == 1){
                    document.querySelector('#divMontoFijo').classList.remove("notblock");
                }
                if(objData.data.tipo == 2){
                    document.querySelector('#divPorcCupon').classList.remove("notblock");
                }
                document.querySelector("#txtMontoFijo").value = objData.data.monto_descuento;
                document.querySelector("#txtPorcentajeCupon").value = objData.data.porcentaje_descuento;
                document.querySelector("#txtMinCompra").value = objData.data.minimo_compra;
                document.querySelector("#txtMinProductos").value = objData.data.limite_cantidad_productos;
                document.querySelector("#txtStockPromo").value = objData.data.limite_cantidad_usos;
                document.querySelector("#txtFechaInicio").value = objData.data.limite_fecha_desde;
                document.querySelector("#txtFechaFin").value = objData.data.limite_fecha_hasta;

                 // Procesar los productos seleccionados
                 if(objData.data.productos != null){
                    document.querySelector('#especificos').classList.remove("notblock");

                    var productos = objData.data.productos.split(","); // Convertir la cadena en un array
                    var listProductos = document.querySelector("#listProductos");
    
                    // Recorrer todas las opciones y marcar las seleccionadas
                    for (var i = 0; i < listProductos.options.length; i++) {
                        if (productos.includes(listProductos.options[i].value)) {
                            listProductos.options[i].selected = true;
                        }
                    }
   
                 }
                 if(objData.data.categorias != null){
                    document.querySelector('#especificos').classList.remove("notblock");

                 var categorias = objData.data.categorias.split(","); // Convertir la cadena en un array
                 var listCategorias = document.querySelector("#listCategoria");
                 
                 // Recorrer todas las opciones y marcar las seleccionadas
                 for (var i = 0; i < listCategorias.options.length; i++) {
                     if (categorias.includes(listCategorias.options[i].value)) {
                         listCategorias.options[i].selected = true;
                     }
                 }
                }
                $('#listCategoria').selectpicker('render');
                $('#listProductos').selectpicker('render');
                $('#listStatus').selectpicker('render');
                $('#listTipoCupon').selectpicker('render');

                $('#modalFormCupones').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }

}

function fntDelMaterial(idmaterial){
    var idmaterial = idmaterial;
    swal({
        title: "Eliminar material",
        text: "¿Realmente quiere eliminar el material?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Materiales/delMaterial/';
            var strData = "idmaterial="+idmaterial;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableMateriales.api().ajax.reload(function(){
                            fntEditMaterial();
                            fntDelMaterial();
                        });
                    }else{
                        swal("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });
}

$('.opcionProductos').on('click', function(e){
     
    if ($(this).is(':checked')) {
        document.querySelector('#especificos').classList.remove("notblock");
    }else{
        document.querySelector('#especificos').classList.add("notblock");
    }
   
   

});
function openModal()
{
    rowTable = "";
    document.querySelector('#idcupon').value ="";
  //  document.querySelector('#idProducto').value =document.querySelector("#idProducto").value;
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Stock";
    document.querySelector("#formCupones").reset();
    $('#modalFormCupones').modal('show');
}
    
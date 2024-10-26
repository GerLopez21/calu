let tableDescuentos;
let rowTable = "";
    tableDescuentos = $('#tableDescuentos').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Descuentos/getDescuentos",
            "dataSrc":""
        },
        "columns":[
            {"data":"iddescuento"},
            {"data":"titulo"},
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
      if(document.querySelector("#formDescuentos")){
        let formDescuentos = document.querySelector("#formDescuentos");
        formDescuentos.onsubmit = function(e) {
            e.preventDefault();
            let strTitulo = document.querySelector('#txtTitulo').value;
            let intCategorias= document.querySelector('#listCategoria').value;
            let intProductos = document.querySelector('#listProductos').value;
            let intStatus = document.querySelector('#listStatus').value;
         
             let intTipoDescuento = document.querySelector('#listTipoDescuento').value;
             let minCompra = document.querySelector('#txtMinCompra').value;
             let minProductos = document.querySelector('#txtMinProductos').value;
             let stockPromo = document.querySelector('#txtStockPromo').value;
             let tipoPago = document.querySelector('#txtTipoPago').value;
             let fechaInicio = document.querySelector('#txtFechaInicio').value;
             let fechaFin = document.querySelector('#txtFechaFin').value;
             let montoFijo = document.querySelector('#txtMontoFijo').value;
             let porcentajeDescuento = document.querySelector('#txtPorcentajeDescuento').value;

            
            console.log(strTitulo);
            console.log(intStatus);
            console.log(intTipoDescuento);
            
    
            if(strTitulo == '' || intStatus == '' || intTipoDescuento == '')
            {
                swal("Atención", "Los campos titulo, estado y tipo de descuento son obligatorios" , "error");
                return false;
            }
     
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Descuentos/setDescuento'; 
            let formData = new FormData(formDescuentos);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableDescuentos.api().ajax.reload();
                        }else{
                         
                  
                            rowTable.cells[0].textContent = document.querySelector("#listTamanoid").selectedOptions[0].text;
                            rowTable.cells[1].textContent = document.querySelector("#listMaterialid").selectedOptions[0].text;
                            rowTable.cells[2].textContent = strCantidad;
                            rowTable.cells[3].textContent = strCantidad;

                            tableStock.api().ajax.reload();

                            rowTable = ""; 
                        }
                        formDescuentos.reset();
                        location.reload();
                        $('#modalFormDescuentos').modal("hide");
                        swal("Descuento", objData.msg ,"success");

                    }else{
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
//Para abrir div monto fijo o descuento
if(document.querySelector("#listTipoDescuento")){

	let tipodesc3 = document.querySelector("#listTipoDescuento");

	tipodesc3.addEventListener('change', function(){
		document.querySelector('#divMontoFijo').classList.add("notblock");
		document.querySelector('#divPorcDescuento').classList.add("notblock");

	    if(document.querySelector("#listTipoDescuento").value == 1){
			document.querySelector('#divMontoFijo').classList.remove("notblock");
        }
       if(document.querySelector("#listTipoDescuento").value == 2){
			document.querySelector('#divPorcDescuento').classList.remove("notblock");
        }    


	});
}
function fntEditDescuento(iddescuento){

    document.querySelector('#titleModal').innerHTML ="Actualizar descuento";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    var iddescuento = iddescuento;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl  = base_url+'/Descuentos/getDescuento/'+iddescuento;
    request.open("GET",ajaxUrl ,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){

            var objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#iddescuento").value = objData.data.iddescuento;
                document.querySelector("#txtTitulo").value = objData.data.titulo;
                document.querySelector("#listCategoria").value = objData.data.categorias;
                document.querySelector("#listProductos").value = objData.data.productos;
                document.querySelector("#listStatus").value = objData.data.estado;
                document.querySelector("#listTipoDescuento").value = objData.data.tipo;
                document.querySelector("#txtMontoFijo").value = objData.data.monto_descuento;
                document.querySelector("#txtPorcentajeDescuento").value = objData.data.porcentaje_descuento;
                document.querySelector("#txtMinCompra").value = objData.data.minimo_compra;
                document.querySelector("#txtMinProductos").value = objData.data.limite_cantidad_productos;
                document.querySelector("#txtStockPromo").value = objData.data.limite_cantidad_usos;
                document.querySelector("#txtTipoPago").value = objData.data.limite_tipo_pago;
                document.querySelector("#txtFechaInicio").value = objData.data.limite_fecha_desde;
                document.querySelector("#txtFechaFin").value = objData.data.limite_fecha_hasta;

                 // Procesar los productos seleccionados
                 if(objData.data.productos != null){
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
                $('#listTipoDescuento').selectpicker('render');

                $('#modalFormDescuentos').modal('show');
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
function openModal()
{
    rowTable = "";
    document.querySelector('#iddescuento').value ="";
  //  document.querySelector('#idProducto').value =document.querySelector("#idProducto").value;
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Stock";
    document.querySelector("#formDescuentos").reset();
    $('#modalFormDescuentos').modal('show');
}

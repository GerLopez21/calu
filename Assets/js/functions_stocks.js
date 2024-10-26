let tableStock;
    tableStock = $('#tableStock').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Productos/getStock",
            "dataSrc":""
        },
        "columns":[
            {"data":"talle"},
            {"data":"color"},
            {"data":"cantidad"},
            {"data":"fotoreferencia"},
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
         "initComplete": function(settings, json) {
            var stock = json[0].stock;
            var individual = json[0].sumaindividual;

            // Agregar el dato de stock general como encabezado
            var extraHeaderRow = '<tr><th colspan="5">Stock General: ' + stock + ' | La suma individual es de: ' + individual + '</th></tr>';
            $('#tableStock thead').prepend(extraHeaderRow);
            if(stock > individual){
               var extraHeaderRow2 = '<tr><th colspan="5">ATENCIÓN! EXISTE DIFERENCIA ENTRE EL STOCK INDIVIDUAL Y EL GENERAL</th></tr>';
                $('#tableStock thead').prepend(extraHeaderRow2);

            }
        }
    });
    
     if(document.querySelector("#formStock")){
        let formStock = document.querySelector("#formStock");
        formStock.onsubmit = function(e) {
            e.preventDefault();
            let strCantidad = document.querySelector('#txtCantidad').value;
            let intTalle= document.querySelector('#listTalleid').value;
            let intColor = document.querySelector('#listColorid').value;
            let idProducto = document.querySelector('#idProducto').value;
            let fotoreferencia = document.querySelector('#fotoreferencia').value;

            if(strCantidad == '' || intTalle == '' || intColor == '' || intColor == 61 || intTalle  == 1)
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }

     
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Stock/setStock'; 
            let formData = new FormData(formStock);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableStock.api().ajax.reload();
                        }else{
                         
                  
                            rowTable.cells[0].textContent = document.querySelector("#listTalleid").selectedOptions[0].text;
                            rowTable.cells[1].textContent = document.querySelector("#listColorid").selectedOptions[0].text;
                            rowTable.cells[2].textContent = strCantidad;
                            rowTable.cells[3].textContent = strCantidad;

                            tableStock.api().ajax.reload();

                            rowTable = ""; 
                        }
                        $('#modalFormStock').modal("hide");
                        formStock.reset();
                        location.reload();
                        swal("Stock", objData.msg ,"success");
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
        fntTalles();
        fntColores();

}, false);

function fntTalles(){
    if(document.querySelector('#listTalleid')){
        let ajaxUrl = base_url+'/Talles/getSelectTalles';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listTalleid').innerHTML = request.responseText;
                                $('#listTalleid').selectpicker('render');

            }
        }
    }
}
function fntColores(){
    if(document.querySelector('#listColorid')){
        let ajaxUrl = base_url+'/Colores/getSelectColores';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listColorid').innerHTML = request.responseText;
                                                $('#listColorid').selectpicker('render');

            }
        }
    }
}
function fntEditInfo(element,idStock){

    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Stock";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
 
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Stock/getStock/'+idStock;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let htmlImage = "";
                let objStock = objData.data;
                document.querySelector("#idProducto").value = objStock.productoid;
                document.querySelector("#idStock").value = objStock.idstock;
                document.querySelector("#txtCantidad").value = objStock.cantidad;
                document.querySelector("#fotoreferencia").value = objStock.fotoreferencia;

                document.querySelector("#listTalleid").value = objStock.talleid;
                document.querySelector("#listColorid").value = objStock.colorid;
      
                $('#listTalleid').selectpicker('render');
                $('#listColorid').selectpicker('render');

                    
                $('#modalFormStock').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function openModal()
{
    rowTable = "";
    document.querySelector('#idStock').value ="";
  //  document.querySelector('#idProducto').value =document.querySelector("#idProducto").value;
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Stock";
    document.querySelector("#formStock").reset();
    $('#modalFormStock').modal('show');
}

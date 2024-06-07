var tableMovimientos;
var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

	tableMovimientos = $('#tableMovimientos').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Movimientos/getMovimientos",
            "dataSrc":""
        },
        "columns":[
            {"data":"idmovimiento"},
            {"data":"tipo_movimiento"},
            {"data":"procedencia"},
            {"data":"producto"},
            {"data":"fecha"},
            {"data":"observacion"},
            {"data":"cantidad"},
            {"data":"gral_ind"},

        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

    //NUEVO ROL
    var formMovimiento = document.querySelector("#formMovimiento");
    formMovimiento.onsubmit = function(e) {
        e.preventDefault();

        var intIdMovimiento = document.querySelector('#idtalle').value;
        var strNombre = document.querySelector('#txtNombre').value;
     
        if(strNombre == '')
        {
            swal("Atención", "Todos los campos son obligatorios." , "error");
            return false;
        }
        divLoading.style.display = "flex";
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'/Movimientos/setMovimiento'; 
        var formData = new FormData(formMovimiento);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
           if(request.readyState == 4 && request.status == 200){
                
                var objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    $('#modalformMovimiento').modal("hide");
                    formMovimiento.reset();
                    swal("Movimientos", objData.msg ,"success");
                    tableMovimientos.api().ajax.reload();
                }else{
                    swal("Error", objData.msg , "error");
                }              
            } 
            divLoading.style.display = "none";
            return false;
        }

        
    }

});

$('#tableMovimientos').DataTable();



window.addEventListener('load', function() {
    /*fntEditRol();
    fntDelRol();
    fntPermisos();*/
}, false);





    
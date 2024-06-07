let tableProductos;
let rowTable = "";
$( document ).ready(function() {

           fntCategorias();

});

$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});
tableProductos = $('#tableProductos').dataTable( {
    "aProcessing":true,
    "aServerSide":true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax":{
        "url": " "+base_url+"/Productos/getProductos",
        "dataSrc":""
    },
    "columns":[
        {"data":"idproducto"},
        { "data": "images" ,
              "render": function ( data) {
              return '<img src="' + data+ '" height=40px/>';}
            },
        {"data":"nombre"},
        {"data":"stock"},
        {"data":"precio"},
        {"data":"status"},
        {"data":"options"}
    ],
    "columnDefs": [
                    { 'className': "textcenter", "targets": [ 3 ] },
                    { 'className': "textright", "targets": [ 4 ] },
                    { 'className': "textcenter", "targets": [ 5 ] }
                  ],       
    'dom': 'lBfrtip',
    'buttons': [
        {
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i> Copiar",
            "titleAttr":"Copiar",
            "className": "btn btn-secondary",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4, 5] 
            }
        },{
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr":"Esportar a Excel",
            "className": "btn btn-success",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4, 5] 
            }
        },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr":"Esportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4, 5] 
            }
        },{
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr":"Esportar a CSV",
            "className": "btn btn-info",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4, 5] 
            }
        }
    ],
    "resonsieve":"true",
    "bDestroy": true,
    "iDisplayLength": 10,
    "order":[[0,"desc"]]  
});

window.addEventListener('load', function() {

    if(document.querySelector("#formProductos")){
        let formProductos = document.querySelector("#formProductos");
        formProductos.onsubmit = function(e) {
            e.preventDefault();
            let strNombre = document.querySelector('#txtNombre').value;
            let strPrecio = document.querySelector('#txtPrecio').value;
            let intStock = document.querySelector('#txtStock').value;
            let intStatus = document.querySelector('#listStatus').value;
            let intObl = document.querySelector('#listObl').value;

            if(strNombre == '' || strPrecio == '' || intStock == '' )
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }
            // if(intCodigo.length < 5){
            //     swal("Atención", "El código debe ser mayor que 5 dígitos." , "error");
            //     return false;
            // }
            divLoading.style.display = "flex";
            tinyMCE.triggerSave();
            let request = (window.XMLHttpRequest) ? 
                            new XMLHttpRequest() : 
                            new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Productos/setProducto'; 
            let formData = new FormData(formProductos);

            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("", objData.msg ,"success");
                        document.querySelector("#idProducto").value = objData.idproducto;
                        document.querySelector("#containerGallery").classList.remove("notblock");

                        if(rowTable == ""){
                            tableProductos.api().ajax.reload();
                        }else{
                           htmlStatus = intStatus == 1 ? 
                            '<span class="badge badge-success">Activo</span>' : 
                            '<span class="badge badge-danger">Inactivo</span>';
                          //  rowTable.cells[1].textContent = intCodigo;
                            rowTable.cells[2].textContent = strNombre;
                            rowTable.cells[3].textContent = intStock;
                            rowTable.cells[4].textContent = smony+strPrecio;
                            rowTable.cells[5].innerHTML =  htmlStatus;
                            rowTable = ""; 
                        }
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }
       
    if(document.querySelector(".btnAddImage")){
       let btnAddImage =  document.querySelector(".btnAddImage");
       btnAddImage.onclick = function(e){
        let key = Date.now();
        let newElement = document.createElement("div");
        newElement.id= "div"+key;
        newElement.innerHTML = `
            <div class="prevImage"></div>
            <input type="file" name="foto" id="img${key}" class="inputUploadfile">
            <label for="img${key}" class="btnUploadfile"><i class="fas fa-upload "></i></label>
            <button class="btnDeleteImage notblock" type="button" onclick="fntDelItem('#div${key}')"><i class="fas fa-trash-alt"></i></button>`;
        document.querySelector("#containerImages").appendChild(newElement);
        document.querySelector("#div"+key+" .btnUploadfile").click();
        fntInputFile();
       }
    }
    fntInputFile();
}, false);

window.addEventListener('load', function() {
    if(document.querySelector("#formStock")){
        let formStock = document.querySelector("#formStock");
        formStock.onsubmit = function(e) {
            e.preventDefault();
            
           
            // if(intCodigo.length < 5){
            //     swal("Atención", "El código debe ser mayor que 5 dígitos." , "error");
            //     return false;
            // }
            divLoading.style.display = "flex";
            tinyMCE.triggerSave();
            let request = (window.XMLHttpRequest) ? 
                            new XMLHttpRequest() : 
                            new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Stock/setStock'; 
            let formData = new FormData(formStock);
            formData.append('idProducto',idProducto);

            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("", objData.msg ,"success");
                        document.querySelector("#idProducto").value = objData.idproducto;

                        if(rowTable == ""){
                            tableProductos.api().ajax.reload();
                        }else{

                           htmlStatus = intStatus == 1 ? 
                            '<span class="badge badge-success">Activo</span>' : 
                            '<span class="badge badge-danger">Inactivo</span>';
                          //  rowTable.cells[1].textContent = intCodigo;
                            rowTable.cells[2].textContent = strNombre;
                            rowTable.cells[3].textContent = intStock;
                            rowTable.cells[4].textContent = smony+strPrecio;
                            rowTable.cells[5].innerHTML =  htmlStatus;
                            rowTable = ""; 
                        }
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }

 
    fntColores1();
    fntTalles1();
   fntColores2();
    fntTalles2();
       fntColores3();
    fntTalles3();
       fntColores4();
    fntTalles4();
       fntColores5();
    fntTalles5();
       fntColores6();
    fntTalles6();
       fntColores7();
    fntTalles7();

}, false);


tinymce.init({
	selector: '#txtDescripcion',
	width: "100%",
    height: 400,    
    statubar: true,
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
});

function fntInputFile(){
    let inputUploadfile = document.querySelectorAll(".inputUploadfile");
    inputUploadfile.forEach(function(inputUploadfile) {
        inputUploadfile.addEventListener('change', function(){
            let idProducto = document.querySelector("#idProducto").value;
            let parentId = this.parentNode.getAttribute("id");
            let idFile = this.getAttribute("id");            
            let uploadFoto = document.querySelector("#"+idFile).value;
            let fileimg = document.querySelector("#"+idFile).files;
            let prevImg = document.querySelector("#"+parentId+" .prevImage");
            let nav = window.URL || window.webkitURL;
            if(uploadFoto !=''){
                let type = fileimg[0].type;
                let name = fileimg[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
                    prevImg.innerHTML = "Archivo no válido";
                    uploadFoto.value = "";
                    return false;
                }else{
                    let objeto_url = nav.createObjectURL(this.files[0]);
                    prevImg.innerHTML = `<img class="loading" src="${base_url}/Assets/images/loading.svg" >`;

                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url+'/Productos/setImage'; 
                    let formData = new FormData();
                    formData.append('idproducto',idProducto);
                    formData.append("foto", this.files[0]);
                    request.open("POST",ajaxUrl,true);
                    request.send(formData);
                    request.onreadystatechange = function(){
                        if(request.readyState != 4) return;
                        if(request.status == 200){
                            let objData = JSON.parse(request.responseText);
                            if(objData.status){
                                prevImg.innerHTML = `<img src="${objeto_url}">`;
                                document.querySelector("#"+parentId+" .btnDeleteImage").setAttribute("imgname",objData.imgname);
                                document.querySelector("#"+parentId+" .btnUploadfile").classList.add("notblock");
                                document.querySelector("#"+parentId+" .btnDeleteImage").classList.remove("notblock");
                            }else{
                                swal("Error", objData.msg , "error");
                            }
                        }
                    }

                }
            }

        });
    });
}

function fntDelItem(element){
    let nameImg = document.querySelector(element+' .btnDeleteImage').getAttribute("imgname");
    let idProducto = document.querySelector("#idProducto").value;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Productos/delFile'; 

    let formData = new FormData();
    formData.append('idproducto',idProducto);
    formData.append("file",nameImg);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
        if(request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let itemRemove = document.querySelector(element);
                itemRemove.parentNode.removeChild(itemRemove);
            }else{
                swal("", objData.msg , "error");
            }
        }
    }
}

function fntViewInfo(idProducto){
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let htmlImage = "";
                let objProducto = objData.data;
                let estadoProducto = objProducto.status == 1 ? 
                '<span class="badge badge-success">Activo</span>' : 
                '<span class="badge badge-danger">Inactivo</span>';

                document.querySelector("#celCodigo").innerHTML = objProducto.codigo;
                document.querySelector("#celNombre").innerHTML = objProducto.nombre;
                document.querySelector("#celPrecio").innerHTML = objProducto.precio;
                document.querySelector("#celStock").innerHTML = objProducto.stock;
                document.querySelector("#celCategoria").innerHTML = objProducto.categoria;
                document.querySelector("#celStatus").innerHTML = estadoProducto;
                document.querySelector("#celDescripcion").innerHTML = objProducto.descripcion;

                if(objProducto.images.length > 0){
                    let objProductos = objProducto.images;
                    for (let p = 0; p < objProductos.length; p++) {
                        htmlImage +=`<img src="${objProductos[p].url_image}"></img>`;
                    }
                }
                document.querySelector("#celFotos").innerHTML = htmlImage;
                $('#modalViewProducto').modal('show');

            }else{
                swal("Error", objData.msg , "error");
            }
        }
    } 
}

function fntEditInfo(element,idProducto){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Producto";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let htmlImage = "";
                let objProducto = objData.data;
                document.querySelector("#idProducto").value = objProducto.idproducto;
                document.querySelector("#txtNombre").value = objProducto.nombre;
                document.querySelector("#txtDescripcion").value = objProducto.descripcion;
                document.querySelector("#txtPrecio").value = objProducto.precio;
                document.querySelector("#txtStock").value = objProducto.stock;
                document.querySelector("#listObl").value = objProducto.obl_talle_color;
               document.querySelector("#txtDescuento").value = objProducto.preciodescuento;
         
                document.querySelector("#listCategoria").value = objProducto.categoriaid;
                document.querySelector("#listStatus").value = objProducto.status;
                tinymce.activeEditor.setContent(objProducto.descripcion); 
                $('#listCategoria').selectpicker('render');
                $('#listStatus').selectpicker('render');
                $('#listObl').selectpicker('render');

                if(objProducto.images.length > 0){
                    let objProductos = objProducto.images;
                    for (let p = 0; p < objProductos.length; p++) {
                        let key = Date.now()+p;
                        htmlImage +=`<div id="div${key}">
                            <div class="prevImage">
                            <img src="${objProductos[p].url_image}"></img>
                            </div>
                            <button type="button" class="btnDeleteImage" onclick="fntDelItem('#div${key}')" imgname="${objProductos[p].img}">
                            <i class="fas fa-trash-alt"></i></button></div>`;
                    }
                }
                document.querySelector("#containerImages").innerHTML = htmlImage; 
                document.querySelector("#containerGallery").classList.remove("notblock");           
                $('#modalFormProductos').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntDelInfo(idProducto){
    swal({
        title: "Eliminar Producto",
        text: "¿Realmente quiere eliminar el producto?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Productos/delProducto';
            let strData = "idProducto="+idProducto;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableProductos.api().ajax.reload();
                    }else{
                        swal("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });

}
 if(document.querySelector(".btnAgregarFilas")){
       
       let btnAddImage =  document.querySelector(".btnAgregarFilas");
       btnAddImage.onclick = function(e){
           var veces = document.querySelector("#txtFilas").value;

            for (let j = 0 ; j < veces ; j++) {
         let idproducto = document.querySelector("#idProducto").value;
        let newElement = document.createElement("div");
               fntEditStock(this,idproducto);
                        fntColores();
    fntTalles();
        newElement.innerHTML = `
         <label for="listTalle">Talles</label>
									<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
										<select id="listTalle" class="js-select2" name="listTalles">
										<?php 
											if(count($data['talles']) > 0){ 
												foreach ($data['talles'] as $talle) {
										 ?>
										 	<option value="<?= $talle['nombretalle']?>"><?= $talle['nombretalle']?></option>
										<?php
													
												}
										 } ?>
										</select>
										<div class="dropDownSelect2"></div>
									</div>`;
             
        document.querySelector("#containerFilas").appendChild(newElement);
       }
       
       }
        
    }

function fntEditStock(idProducto){
    var idproducto = idProducto;

    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Stock/getStockProducto/'+idproducto;
    request.open("GET",ajaxUrl,true);
    request.send();


    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#contentAjax').innerHTML = request.responseText;

            $('.modalStock').modal('show');


            document.querySelector('#formStock').addEventListener('submit',fntSavePermisos,false);
        }
    }
}
function fntSavePermisos(evnet){
    evnet.preventDefault();
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Stock/setStock'; 
    var formElement = document.querySelector("#formStock");

    var formData = new FormData(formElement);
    request.open("POST",ajaxUrl,true);
    request.send(formData);


    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                swal("Permisos de usuario", objData.msg ,"success");
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
    
}
function fntEditStock111(element,idProducto){
  
    document.querySelector('#titleModal').innerHTML ="Actualizar Stock";
    document.querySelector('.modal-header').classList.replace("headerRegisterStock", "headerUpdateStock");
    document.querySelector('#btnActionStock').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Stock/getStockProducto/'+idProducto;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let htmlImage = "";
                let objProducto = objData.data;

                document.querySelector("#idProducto").value = objProducto.productoid;
               
                document.querySelector("#txtStockCantidad1").value = objProducto.cantidad1;
                document.querySelector("#txtStockCantidad2").value = objProducto.cantidad2;
                document.querySelector("#txtStockCantidad3").value = objProducto.cantidad3;
                document.querySelector("#txtStockCantidad4").value = objProducto.cantidad4;
                document.querySelector("#txtStockCantidad5").value = objProducto.cantidad5;
                document.querySelector("#txtStockCantidad6").value = objProducto.cantidad6;
                document.querySelector("#txtStockCantidad7").value = objProducto.cantidad7;
                document.querySelector("#txtStockCantidad8").value = objProducto.cantidad8;
                document.querySelector("#txtStockCantidad9").value = objProducto.cantidad9;
                document.querySelector("#txtStockCantidad10").value = objProducto.cantidad10;
                document.querySelector("#txtStockCantidad11").value = objProducto.cantidad11;
                document.querySelector("#txtStockCantidad12").value = objProducto.cantidad12;
                document.querySelector("#txtStockCantidad13").value = objProducto.cantidad13;
                document.querySelector("#txtStockCantidad14").value = objProducto.cantidad14;
                document.querySelector("#txtStockCantidad15").value = objProducto.cantidad15;
                document.querySelector("#txtStockCantidad16").value = objProducto.cantidad16;
                document.querySelector("#txtStockCantidad17").value = objProducto.cantidad17;
                document.querySelector("#txtStockCantidad18").value = objProducto.cantidad18;
                document.querySelector("#txtStockCantidad19").value = objProducto.cantidad19;
                document.querySelector("#txtStockCantidad20").value = objProducto.cantidad20;
                document.querySelector("#txtStockCantidad21").value = objProducto.cantidad21;
                document.querySelector("#txtStockCantidad22").value = objProducto.cantidad22;
                document.querySelector("#txtStockCantidad23").value = objProducto.cantidad23;
                document.querySelector("#txtStockCantidad24").value = objProducto.cantidad24;
                document.querySelector("#txtStockCantidad25").value = objProducto.cantidad25;
                document.querySelector("#txtStockCantidad26").value = objProducto.cantidad26;
                document.querySelector("#txtStockCantidad27").value = objProducto.cantidad27;
                document.querySelector("#txtStockCantidad28").value = objProducto.cantidad28;
                document.querySelector("#txtStockCantidad29").value = objProducto.cantidad29;
                document.querySelector("#txtStockCantidad30").value = objProducto.cantidad30;
                document.querySelector("#txtStockCantidad31").value = objProducto.cantidad31;
                document.querySelector("#txtStockCantidad32").value = objProducto.cantidad32;
                document.querySelector("#txtStockCantidad33").value = objProducto.cantidad33;
                document.querySelector("#txtStockCantidad34").value = objProducto.cantidad34;
                
                document.querySelector("#listTalles1").value = objProducto.talleid;
                document.querySelector("#listColores1").value = objProducto.colorid;
                document.querySelector("#listTalles2").value = objProducto.talleid;
                document.querySelector("#listColores2").value = objProducto.colorid;
                document.querySelector("#listTalles3").value = objProducto.talleid;
                document.querySelector("#listColores3").value = objProducto.colorid;
                document.querySelector("#listTalles4").value = objProducto.talleid;
                document.querySelector("#listColores4").value = objProducto.colorid;
                document.querySelector("#listTalles5").value = objProducto.talleid;
                document.querySelector("#listColores5").value = objProducto.colorid;
                document.querySelector("#listTalles6").value = objProducto.talleid;
                document.querySelector("#listColores6").value = objProducto.colorid;
                document.querySelector("#listTalles7").value = objProducto.talleid;
                document.querySelector("#listColores7").value = objProducto.colorid;
                document.querySelector("#listTalles8").value = objProducto.talleid;
                document.querySelector("#listColores8").value = objProducto.colorid;
                document.querySelector("#listTalles9").value = objProducto.talleid;
                document.querySelector("#listColores9").value = objProducto.colorid;
                document.querySelector("#listTalles10").value = objProducto.talleid;
                document.querySelector("#listColores10").value = objProducto.colorid;
                document.querySelector("#listTalles11").value = objProducto.talleid;
                document.querySelector("#listColores11").value = objProducto.colorid;
                document.querySelector("#listTalles12").value = objProducto.talleid;
                document.querySelector("#listColores12").value = objProducto.colorid;

                tinymce.activeEditor.setContent("stock"); 
                $('#listTalles1').selectpicker('render');
                $('#listColores1').selectpicker('render');
                $('#listTalles2').selectpicker('render');
                $('#listColores2').selectpicker('render');
                $('#listTalles3').selectpicker('render');
                $('#listColores3').selectpicker('render');
                $('#listTalles4').selectpicker('render');
                $('#listColores4').selectpicker('render');
                $('#listTalles5').selectpicker('render');
                $('#listColores5').selectpicker('render');
                $('#listTalles6').selectpicker('render');
                $('#listColores6').selectpicker('render');
                $('#listTalles7').selectpicker('render');
                $('#listColores7').selectpicker('render');
                $('#listTalles8').selectpicker('render');
                $('#listColores8').selectpicker('render');
                $('#listTalles9').selectpicker('render');
                $('#listColores9').selectpicker('render');
                $('#listTalles10').selectpicker('render');
                $('#listColores10').selectpicker('render');
                $('#listTalles11').selectpicker('render');
                $('#listColores11').selectpicker('render');
                $('#listTalles12').selectpicker('render');
                $('#listColores12').selectpicker('render');
 
                
                     
                $('#modalStockProductos').modal('show');
            }else{
                swal("Error", objData.msg , "error");
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



function openModal()
{
    rowTable = "";
    document.querySelector('#idProducto').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
    document.querySelector("#formProductos").reset();
    document.querySelector("#containerImages").innerHTML = "";
    $('#modalFormProductos').modal('show');

}

var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdownList'))
var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
  return new bootstrap.Dropdown(dropdownToggleEl)
})
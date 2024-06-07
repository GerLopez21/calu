<?php 
    const BASE_URL = "http://localhost/calu";
	//const BASE_URL = "https://calu-store.com";

	//Zona horaria
	date_default_timezone_set('America/Argentina/Mendoza');

	//Datos de conexión a Base de Datos
	const DB_HOST = "localhost";
	const DB_NAME = "calu";
	const DB_USER = "root";
	const DB_PASSWORD = "root";
	const DB_CHARSET = "utf8";

	//Para envío de correo
	const ENVIRONMENT = 0; // Local: 0, Produccón: 1;

	//Deliminadores decimal y millar Ej. 24,1989.00
	const SPD = ".";
	const SPM = ",";

	//Simbolo de moneda
	const SMONEY = "$";
	const CURRENCY = "ARS";

	//Api PayPal
	//SANDBOX PAYPAL
	const URLPAYPAL = "https://api-m.sandbox.paypal.com";
	const IDCLIENTE = "";
	const SECRET = "";
	//LIVE PAYPAL
	//const URLPAYPAL = "https://api-m.paypal.com";
	//const IDCLIENTE = "";
	//const SECRET = "";

	//Datos envio de correo
	const NOMBRE_REMITENTE = "CALU";
	const EMAIL_REMITENTE = "info@calu-store.com";
	const NOMBRE_EMPESA = "CALU";
	const WEB_EMPRESA = "www.calu-store.com";

	const DESCRIPCION = "La mejor tienda en línea con artículos de moda.";
	const SHAREDHASH = "CALU";

	//Datos Empresa
	const DIRECCION = "Godoy Cruz, Mendoza";
	const TELEMPRESA = "+5492612508912";
	const WHATSAPP = "+5492612508912";
	const EMAIL_EMPRESA = "calumendozastore@gmail.com";
	const EMAIL_PEDIDOS = "calumendozastore@gmail.com"; 
	const EMAIL_SUSCRIPCION = "calumendozastore@gmail.com";
	const EMAIL_CONTACTO = "calumendozastore@gmail.com";

	const CAT_SLIDER = "1,2,3,4,5,6,7,8,9,10";
	const CAT_BANNER = "1,2,3,4,5,6,7,8,9,10";
	const CAT_FOOTER = "1,2,3,4,5,6,7,8,9,10";

	//Datos para Encriptar / Desencriptar
	const KEY = 'abelosh';
	const METHODENCRIPT = "AES-128-ECB";

	//Envío
	const COSTOENVIO = 5;

	//Módulos
	const MDASHBOARD = 1;
	const MUSUARIOS = 2;
	const MCLIENTES = 3;
	const MPRODUCTOS = 4;
	const MPEDIDOS = 5;
	const MCATEGORIAS = 6;
	const MSUSCRIPTORES = 7;
	const MDCONTACTOS = 8;
	const MDPAGINAS = 9;
	const MDCOLORES = 10;
	const MDTALLES = 11;

	//Páginas
	const PINICIO = 1;
	const PTIENDA = 2;
	const PCARRITO = 3;
	const PNOSOTROS = 4;
	const PCONTACTO = 5;
	const PPREGUNTAS = 6;
	const PTERMINOS = 7;
	const PSUCURSALES = 8;
	const PERROR = 9;

	//Roles 
	const RADMINISTRADOR = 1;
	const RSUPERVISOR = 2;
	const RCLIENTES = 3;

	const STATUS = array('Completo','Cancelado','Confirmado','Pendiente','Entregado');

	const TIPO_ENVIO = array('Retiro centro','Retiro showroom','Envio correo', 'Envio domicilio');

	const TIPO_PAGO = array('Efectivo','Debito','Credito','Transferencia','Acordar');
	
	const SUCURSALES = array('Showroom','Centro','Correo Argentino','Envio Domicilio');


	//Productos por página
	const CANTPORDHOME = 50;
	const PROPORPAGINA = 10;
	const PROCATEGORIA = 10;
	const PROBUSCAR = 4;

	//REDES SOCIALES
	const FACEBOOK = "https://www.facebook.com/calu";
	const INSTAGRAM = "https://www.instagram.com/calu.mendoza//";
	

 ?>
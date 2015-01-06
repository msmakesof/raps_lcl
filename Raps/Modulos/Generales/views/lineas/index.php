<?php		
	session_start();
	include_once($_SESSION['urlPrincipalIndex']);
	include_once(urlModulos()."Generales/models/lineas.php");	

	$titulo = 'LINEAS';	
	$urlPaginador = urlInicial().'Publico/Librerias/funcionesBasicas.php?opc=1'; 
	$urlCambioEstado = urlInicial().'Publico/Librerias/funcionesBasicas.php?opc=2'; 
	$urlModificaRegistro = urlInicial().'Publico/Librerias/funcionesBasicas.php?opc=3'; 

	$forma = "";
	$url = urlInicial().'Modulos/Generales/controllers/lineasControllers.php?opcionController=1'; 
	$campos = array("idLineas","descripcion", "enviaEmail", "estado");
	$tipos = array("hidden","text", "select", "select");
	$tamano = array("0","60", "15", "15");
	$span = array("0","12","6","6");
	$llamadoFunciones = array('','', "enviaEmailHtml", "estadoHtml");
	//$forma .= formaDetalle($campos,$tipos,$tamano,$url,$llamadoFunciones);
	$forma .= formaDetalle($campos,$tipos,$span,$url,$llamadoFunciones);

	
	$tabla = 'lineas';
	$condicion = "";
	$campos = array("idLineas","descripcion", "enviaEmail", "estado");
	$tamano = array("5",	"60", "12", "12");
	$titulos = array("No.","Descripci&oacute;n", "Env&iacute;a Email", "Estado");
	$llamadoFunciones = array('','', "enviaEmailDetalle", "estadoDetalle");
	$forma .= "<div id='divPaginador'>";
	$pos=$_GET['pos'];
	$forma .= paginador($tabla,$condicion,$pos,$campos,$tamano,$titulos,$llamadoFunciones,'','','php');
	$forma .= "</div>";
	include("/var/www/Raps/template.php");		

?>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
	var camposForma = ["descripcion", "enviaEmail", "estado"];
	var tiposForma = ["text", "select", "select"];
	var titulosCampos = ["Descripci&oacute;n", "Envia Email", "Estado"];	
	
	function ordenarBusqueda(campo)
	{				 
		$('#ordenPaginador').val(campo);
		filtrarBusqueda();
	}
	function filtrarBusqueda()
	{	
		busqueda = $('#searchID').val();
		cantidadRegistros = busqueda.length;    	
		urlPaginador = <?php echo json_encode($urlPaginador);?>;
		tabla = <?php echo json_encode($tabla);?>;
		camposArr = <?php echo json_encode($campos);?>;
		tamanoArr = <?php echo json_encode($tamano);?>;
		titulosArr = <?php echo json_encode($titulos);?>;
		llamadoFuncionesArr = <?php echo json_encode($llamadoFunciones);?>;
		campos='';
		tamano='';
		titulos='';
		condicion='';
		llamadoFunciones='';				
		for(var i=0;i<camposArr.length;i++)
	    {
	       campos = campos+camposArr[i]+',';
	       tamano = tamano+tamanoArr[i]+',';
	       titulos = titulos+titulosArr[i]+',';
	       llamadoFunciones = llamadoFunciones+llamadoFuncionesArr[i]+',';
	    }	    		    	
		filtrarBusquedaPrincipal(urlPaginador,tabla,campos,tamano,titulos,condicion);
	}	

	function cambiarEstado(campoPrimario,valor)
	{
		
		$( "#dialog-confirm" ).html("Esta seguro de cambiar el estado");
		$( "#dialog-confirm" ).dialog({
	      resizable: false,
	      height:160,
	      modal: true,
	      buttons: {
	        "Aceptar": function() {	          	
	          	urlCambioEstado = <?php echo json_encode($urlCambioEstado);?>;
				tabla = <?php echo json_encode($tabla);?>;
				cambiarEstadoPrincipal(urlCambioEstado,tabla,campoPrimario,valor);	
	        },
	        Rechazar: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });		
	}	

	function modificarRegistro(campoPrimario,valor)
	{
		if($('#'+campoPrimario).val() != 0 && $('#'+campoPrimario).val() != '')
		{			
			message = "Hay un registro en edici&oacute;n";
			mensajes(message, 1)			
			return;
		}
		urlModificaRegistro = <?php echo json_encode($urlModificaRegistro);?>;
		tabla = <?php echo json_encode($tabla);?>;
		camposArr = <?php echo json_encode($campos);?>;
		campos='';
		for(var i=0;i<camposArr.length;i++)
	    {
	       campos = campos+camposArr[i]+',';	      
	    }
		modificarRegistroPrincipal(urlModificaRegistro,tabla,campoPrimario,valor,campos);
	}

</script>


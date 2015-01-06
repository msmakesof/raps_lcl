<?php		
	session_start();
	include_once($_SESSION['urlPrincipalIndex']);
	include_once(urlModulos()."Generales/models/procesos.php");	

	$titulo = 'PROCESOS';	
	$urlPaginador = urlInicial().'Publico/Librerias/funcionesBasicas.php?opc=1'; 
	$urlCambioEstado = urlInicial().'Publico/Librerias/funcionesBasicas.php?opc=2'; 
	$urlModificaRegistro = urlInicial().'Publico/Librerias/funcionesBasicas.php?opc=3'; 

	$forma = "";
	$url = urlInicial().'Modulos/Generales/controllers/procesosControllers.php?opcionController=1'; 
	$campos = array("idProceso","nombre", "idMacroProceso", "estado");
	$tipos = array("hidden","text", "select", "select");
	$tamano = array("0","60", "15", "15");
	$llamadoFunciones = array('','', "idMacroProcesoHtml", "estadoHtml");
	$forma .= formaDetalle($campos,$tipos,$tamano,$url,$llamadoFunciones);

	
	$tabla = 'procesos';
	$condicion = "";
	$campos = array("idProceso","nombre", "idMacroProceso", "estado");
	$tamano = array("5",	"56", "14", "14");
	$titulos = array("No.","Descripci&oacute;n", "Macro Proceso", "Estado");
	$llamadoFunciones = array('','', "idMacroProcesoDetalle", "estadoDetalle");
	$forma .= "<div id='divPaginador'>";
	$pos=$_GET['pos'];
	$forma .= paginador($tabla,$condicion,$pos,$campos,$tamano,$titulos,$llamadoFunciones,'','','php');
	$forma .= "</div>";
	include("/var/www/Raps/template.php");		

?>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
	var camposForma = ["nombre", "idMacroProceso", "estado"];
	var tiposForma = ["text", "select", "select"];
	var titulosCampos = ["Descripci&oacute;n", "Macro Proceso", "Estado"];	
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


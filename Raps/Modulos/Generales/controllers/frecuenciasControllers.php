<?php		
	session_start();
	include_once($_SESSION['urlPrincipalIndex']);
	include_once(urlModulos()."Generales/models/frecuencias.php");	

	$opc = $_GET['opcionController'];	
	switch ($opc) {
    	case 0:
        	echo index();
        	break;
    	case 1:    	
        	guardar();
        	break;  
			
		case 3:    	
        	errgraba();
        	break;  	  	
	}
	 
	function index($msj,$estado)
	{		
		if($msj != '' && $estado != '')
		{			
			session_start();
			$_SESSION['mensaje'] = mensajes($msj,$estado);	
		}
		$url =  urlModulosRelativa()."Generales/views/frecuencias/index.php";		
		header("Location: $url "); die();
	}

	function guardar()
	{
		$modeloFrecuencias = new modeloFrecuencias();		
		$modeloFrecuencias->setIdFrecuencias($_POST['idFrecuencias']);
		$modeloFrecuencias->setNombre($_POST['nombre']);
		$modeloFrecuencias->setDescripcion($_POST['descripcion']);
		$modeloFrecuencias->setEstado($_POST['estado']);	
		if($_POST['idFrecuencias'] == '' || $_POST['idFrecuencias'] == 0)
		{
			$modeloFrecuencias->guardar();
			$mensaje = "Se guardo Satisfactoriamente";
		}
		else
		{			
			$modeloFrecuencias->actualizar();
			$mensaje = "Se actualizo el resgitro Satisfactoriamente";
		}
		index($mensaje,"0");
	}	
	
	function errgraba(){
	$message = "Existe un error Interno.   El sistema se encuentra verificando esto.";
	index('',"0");
	mensajes($message,"3");
	}
?>
<?php		
	session_start();
	include_once($_SESSION['urlPrincipalIndex']);
	include_once(urlModulos()."Generales/models/procesos.php");	

	$opc = $_GET['opcionController'];	
	switch ($opc) {
    	case 0:
        	echo index();
        	break;
    	case 1:    	
        	guardar();
        	break;    	
	}
	 
	function index($msj,$estado)
	{		
		if($msj != '' && $estado != '')
		{			
			session_start();
			$_SESSION['mensaje'] = mensajes($msj,$estado);	
		}
		$url =  urlModulosRelativa()."Generales/views/procesos/index.php";		
		header("Location: $url "); die();
	}

	function guardar()
	{		
		$modeloProceso = new modeloProcesos();							
		$modeloProceso->setIdProceso($_POST['idProceso']);
		$modeloProceso->setNombre($_POST['nombre']);
		$modeloProceso->setIdMacroProceso($_POST['idMacroProceso']);		
		$modeloProceso->setEstado($_POST['estado']);
		
		if($_POST['idProceso'] == '' || $_POST['idProceso'] == 0)
		{
			$modeloProceso->guardar();
			$mensaje = "Se guardo Satisfactoriamente";
		}
		else
		{			
			$modeloProceso->actualizar();
			$mensaje = "Se actualizo el resgitro Satisfactoriamente";
		}
		index($mensaje,"0");
	}	
?>
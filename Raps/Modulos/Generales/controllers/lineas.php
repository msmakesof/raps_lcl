<?php		
	session_start();
	include_once($_SESSION['urlPrincipalIndex']);
	include_once(urlModulos()."Generales/models/lineas.php");	

	$opc = $_GET['opc'];
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
		$url =  urlModulosRelativa()."Generales/views/lineas/index.php";		
		header("Location: $url "); die();
	}

	function guardar()
	{
		$modeloLineas = new modeloLineas();
		$modeloLineas->setDescripcion($_POST['descripcion']);
		$modeloLineas->setEnviaEmail($_POST['enviaEmail']);
		$modeloLineas->setEstado($_POST['estado']);	
		$modeloLineas->guardar();
		index("Se guardo Satisfactoriamente","0");
	}	
?>
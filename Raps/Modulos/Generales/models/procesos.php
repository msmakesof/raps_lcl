<?php
	session_start();
	include_once($_SESSION['urlPrincipalIndex']);
	class modeloProcesos 
	{
		public $idProceso;
	    public $nombre;
	    public $idMacroProceso;
	    public $estado;
	 
	    function setIdProceso($idProceso)
	    {
	        $this->idProceso = $idProceso;
	    }

	    function setNombre($nombre)
	    {
	        $this->nombre = $nombre;
	    }

	    function setIdMacroProceso($idMacroProceso)
	    {
	        $this->idMacroProceso = $idMacroProceso;
	    }

	    function setEstado($estado)
	    {
	        $this->estado = $estado;
	    }

	    function getIdProceso()
	    {
	        $idProceso = $this->idProceso;
	        return $idProceso;
	    }

	    function getNombre()
	    {
	        $nombre = $this->nombre;
	        return $nombre;
	    }

	    function getIdMacroProceso()
	    {
	        $idMacroProceso = $this->idMacroProceso;
	        return $idMacroProceso;
	    }

	    function getEstado()
	    {
	        $estado = $this->estado;
	        return $estado;
	    }

	    function guardar()
		{
			$sql  = "INSERT INTO procesos (idProceso,nombre,idMacroProceso,estado) VALUES ( ";
			$sql .= "0,";
			$sql .= "'".validarCadena($this->nombre)."',";
			$sql .= "'".validarCadena($this->idMacroProceso)."',";
			$sql .= "'".validarCadena($this->estado)."');";
			$conexion = crearConexion();			
			mysql_query($sql, $conexion) or die("Problemas al almacenar en la tabla Procesos".mysql_error());
			cerrarConexion($conexion);
			return $sql;
		}

		function actualizar()
		{
			$sql  = "UPDATE procesos SET ";			
			$sql .= "nombre = '".validarCadena($this->nombre)."',";	
			$sql .= "idMacroProceso = '".validarCadena($this->idMacroProceso)."',";
			$sql .= "estado = '".validarCadena($this->estado)."'";
			$sql .= " WHERE idProceso = ".validarCadena($this->idProceso);
			$conexion = crearConexion();			
			mysql_query($sql, $conexion) or die("Problemas al actualizar en la tabla Procesos".$sql.mysql_error());
			cerrarConexion($conexion);
			return $sql;
		}
	    
	}

	function idMacroProcesoHtml()
	{ 
		$HTML = "";
		$HTML .= "<option value='@'>Seleccione...</option>";
		$sql  = "SELECT * FROM macroproceso WHERE estado = '1'";					
		$conexion = crearConexion();					
		$resultado=mysql_query($sql, $conexion) or die("Problemas en el select para consultar el macroproceso(SELECT):".mysql_error());
	    while ($resul=mysql_fetch_array($resultado))
	    {        	
        	$HTML .= "<option value='".$resul['idMacroProceso']."'>".$resul['nombre']."</option>";
	    }
		cerrarConexion($conexion);				
		return $HTML;
	}
	function idMacroProcesoDetalle($idMacroProceso)
	{
		if($idMacroProceso == 1)
		{
			$detalle = 'Si';
		}
		else if($idMacroProceso == 0)
		{
			$detalle = 'No';
		}
		return $detalle;
	}
	function estadoHtml()
	{
		$HTML = "";
		$HTML .= "<option value='@'>Seleccione...</option>";
		$HTML .= "<option value='1'>Activo</option>";
		$HTML .= "<option value='0'>Inactivo</option>";
		return $HTML;
	}
	function estadoDetalle($estado)
	{
		if($estado == 1)
		{
			$detalle = 'Activo';
		}
		else if($estado == 0)
		{
			$detalle = 'Inactivo';
		}
		return $detalle;
	}
?>
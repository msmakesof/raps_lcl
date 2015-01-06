<?php
	session_start();
	include_once($_SESSION['urlPrincipalIndex']);
	class modeloFrecuencias 
	{
		public $idFrecuencias;
	    public $nombre;
		public $descripcion;
	    public $estado;
	 
	    function setIdFrecuencias($idFrecuencias)
	    {
	        $this->idFrecuencias = $idFrecuencias;
	    }

	    function setNombre($nombre)
	    {
	        $this->nombre = $nombre;
	    }
		
		function setDescripcion($descripcion)
		{
			$this->descripcion = $descripcion;
		}

	    function setEstado($estado)
	    {
	        $this->estado = $estado;
	    }

	    function getIdFrecuencias()
	    {
	        $idFrecuencias = $this->idFrecuencias;
	        return $idFrecuencias;
	    }

	    function getNombre()
	    {
	        $nombre = $this->nombre;
	        return $nombre;
	    }
		
		function getDescripcion()
		{
			$descripcion = $this->descripcion;
			return $descripcion;
		}
	    function getEstado()
	    {
	        $estado = $this->estado;
	        return $estado;
	    }

	    function guardar()
		{
			$sql  = "INSERT INTO frecuencias (idFrecuencias,nombre,descripcion,estado) VALUES ( ";
			$sql .= "0,";
			$sql .= "'".validarCadena($this->nombre)."',";
			$sql .= "'".validarCadena($this->descripcion)."',";
			$sql .= "'".validarCadena($this->estado)."');";
			$conexion = crearConexion();			
			mysql_query($sql, $conexion) or die("Problemas al almacenar en la tabla Frecuencias".mysql_error());
			cerrarConexion($conexion);
			return $sql;
		}

		function actualizar()
		{
			$huboerr = "N";
			$sql  = "UPDATE frecuencias SET ";			
			$sql .= "nombre = '".$this->nombre."',";
			$sql .= "descripcion = '".validarCadena($this->descripcion)."',";
			$sql .= "estado = '".validarCadena($this->estado)."'";
			$sql .= " WHERE idFrecuencias = ".validarCadena($this->idFrecuencias);
			$conexion = crearConexion();
			mysql_query($sql, $conexion) or die(capErr(mysql_errno(),mysql_error(),'frecuencias',__FILE__, __LINE__));
			cerrarConexion($conexion);
			return $sql;
		}
	    
	}

	function enviaEmailHtml()
	{
		$HTML = "";
		$HTML .= "<option value='@'>Seleccione...</option>";
		$HTML .= "<option value='1'>Si</option>";
		$HTML .= "<option value='0'>No</option>";
		return $HTML;
	}
	function enviaEmailDetalle($enviaEmail)
	{
		if($enviaEmail == 1)
		{
			$detalle = 'Si';
		}
		else if($enviaEmail == 0)
		{
			$detalle = 'No';
		}
		return $detalle;
	}
	function estadoHtml()
	{
		$HTML = "";
		$HTML .= "<option value='@'>Estado...</option>";
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
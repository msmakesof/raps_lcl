<?php
	session_start();
	include_once($_SESSION['urlPrincipalIndex']);
	class modeloLineas 
	{
		public $idLineas;
	    public $descripcion;
	    public $enviaEmail;
	    public $estado;
	 
	    function setIdLineas($idLineas)
	    {
	        $this->idLineas = $idLineas;
	    }

	    function setDescripcion($descripcion)
	    {
	        $this->descripcion = $descripcion;
	    }

	    function setEnviaEmail($enviaEmail)
	    {
	        $this->enviaEmail = $enviaEmail;
	    }

	    function setEstado($estado)
	    {
	        $this->estado = $estado;
	    }

	    function getIdLineas()
	    {
	        $idLineas = $this->idLineas;
	        return $idLineas;
	    }

	    function getDescripcion()
	    {
	        $descripcion = $this->descripcion;
	        return $descripcion;
	    }

	    function getEnviaEmail()
	    {
	        $enviaEmail = $this->enviaEmail;
	        return $enviaEmail;
	    }

	    function getEstado()
	    {
	        $estado = $this->estado;
	        return $estado;
	    }

	    function guardar()
		{
			$sql  = "INSERT INTO lineas (idLineas,descripcion,enviaEmail,estado) VALUES ( ";
			$sql .= "0,";
			$sql .= "'".validarCadena($this->descripcion)."',";
			$sql .= "'".validarCadena($this->enviaEmail)."',";
			$sql .= "'".validarCadena($this->estado)."');";
			$conexion = crearConexion();			
			mysql_query($sql, $conexion) or die("Problemas al almacenar en la tabla Lineas".mysql_error());
			cerrarConexion($conexion);
			return $sql;
		}

		function actualizar()
		{
			$sql  = "UPDATE lineas SET ";			
			$sql .= "descripcion = '".validarCadena($this->descripcion)."',";
			$sql .= "enviaEmail = '".validarCadena($this->enviaEmail)."',";
			$sql .= "estado = '".validarCadena($this->estado)."'";
			$sql .= " WHERE idLineas = ".validarCadena($this->idLineas);
			$conexion = crearConexion();			
			mysql_query($sql, $conexion) or die("Problemas al almacenar en la tabla Lineas".mysql_error());
			cerrarConexion($conexion);
			return $sql;
		}
	    
	}

	function enviaEmailHtml()
	{
		$HTML = "";
		$HTML .= "<option value='@'>envia Email...</option>";
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
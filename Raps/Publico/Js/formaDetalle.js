function guardarForma()
{
	msj='';
	for(i=0;i < camposForma.length; i++)
	{
		campo = $('#'+camposForma[i]).val();
		if(tiposForma[i]=='text' && campo == '')
		{
			msj += "- El campo "+titulosCampos[i]+" esta vacio.<BR>"; 
		}
		else if(tiposForma[i]=='select' && campo == '@')
		{
			msj += "- Debe seleccionar el campo "+titulosCampos[i]+". <BR>"; 
		}			
	}
	if(msj != "")
	{
		mensajes(msj, 2);			
		return false;
	}
	else
	{
		$('#idForma').submit();
	}
}

function mensajes(message, estado)
   {   	
	  if(estado == 0)
      {
         title = 'Confirmaci&oacute;n';
         estado = 'confirmacion';
      }
      else if(estado == 1)
      {
         title = 'Advertencia';
         estado = '';
      }
      else
      {
         title = 'Error';
         estado = 'error';
      } 
      opts = {};
      opts.classes = [$('#freeow-style').val()];
      opts.classes.push(estado);     
      $('#mensaje').freeow(title, message, opts);            
   }


function filtrarBusquedaPrincipal(urlPaginador,tabla,campos,tamano,titulos,condicion)
{		
	busqueda = $('#searchID').val();
	order = $('#ordenPaginador').val();
	limit = $('#limitPaginador').val();
    cantidadRegistros = busqueda.length;
    if(cantidadRegistros > 2 || busqueda == '' || order != '')
    {	    	
    	$.ajax({
		    data: {
		    	"tabla" : tabla, 
		    	"condicion" : busqueda,
		    	"pos" : '1',
		    	"campos" : campos,
		    	"tamano" : tamano,
		    	"titulos" : titulos,
		    	"llamadoFunciones" : llamadoFunciones,
		    	"order" : order,
		    	"limit" : limit
		    },
		    type: "POST",
		    dataType: "json",
		    url: urlPaginador,
		})			
		 .done(function( data, textStatus, jqXHR ) {
		     //alert(data);			     
		     $('#tablePaginador').remove();
		     $('.pagination').parent().remove();
		     $('#tablaCampos').after(data);
		 })
		 .fail(function( jqXHR, textStatus, errorThrown ) {			     
		     mensajes("Por favor comuniquese con el departamento de sistemas",2);
		});
    }      
}

function cambiarEstadoPrincipal(urlCambioEstado,tabla,campoPrimario,valor)
{
	$.ajax({
	    data: {
	    	"tabla" : tabla, 
	    	"campoPrimario" : campoPrimario,
	    	"valor" : valor	    	
	    },
	    type: "POST",
	    dataType: "json",
	    url: urlCambioEstado,
	})			
	 .done(function( data, textStatus, jqXHR ) {
	 	message = "Hay un registro en edici&oacute;n";
		mensajes(message, 1)
	    location.reload();
	 })
	 .fail(function( jqXHR, textStatus, errorThrown ) {			     
	     mensajes("Por favor comuniquese con el departamento de sistemas",2);
	});
}

function modificarRegistroPrincipal(urlModificaRegistro,tabla,campoPrimario,valor,campos)
{
	$.ajax({
	    data: {
	    	"tabla" : tabla, 
	    	"campoPrimario" : campoPrimario,
	    	"campos" : campos,
	    	"valor" : valor	    	
	    },
	    type: "POST",
	    dataType: "json",
	    url: urlModificaRegistro,
	})			
	 .done(function( data, textStatus, jqXHR ) {
	 	resultado = data.split(",");
	 	campos = campos.split(",");
	 	for(i=0;i < resultado.length; i++)
	 	{	 		
	 		$('#'+campos[i]).val(resultado[i]);	 		
	 	}
	     //location.reload();
	 })
	 .fail(function( jqXHR, textStatus, errorThrown ) {			     
	     mensajes("Por favor comuniquese con el departamento de sistemas",2);
	});
}

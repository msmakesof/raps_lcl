function objetoAjax()
{
	var xmlhttp=false;
	try {
		   xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		   try {
			  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		   } catch (E) {
				   xmlhttp = false;
		   }
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		   xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}


function naudita(){
	ajax=objetoAjax();
	divResultado2 = document.getElementById('zonenuevo');	
		
		ajax.open("POST", "addi_audita.php",true);	
			ajax.onreadystatechange=function()
			{  		
				if (ajax.readyState==1)
				{
					divResultado2.innerHTML='Cargando...<img src="indicator_green.gif">';
				}
				
				if(ajax.readyState==4)
				{ //si es 4, ya la respuesta del servidor esta lista, de lo contrario...
					
					if (ajax.status==200)
					{
						divResultado2.innerHTML=ajax.responseText;
							return;
					}
				
					else if(ajax.status==404)
					{ // ...de lo contrario se muestra el texto CARGANDO 
						divResultado2.innerHTML='Cargando...<img src="indicator_green.gif">'; 
					}
					else
					{
						divResultado2.innerHTML='Error...'.ajax.status; 
					}
					
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		
			ajax.send(null);
	
}

function graba_audita(){
	vnombre = document.getElementById('nombre');
	alert(vnombre);
	ajax=objetoAjax();
	divResultado2 = document.getElementById('zonenuevo');	
		
		ajax.open("POST", "audi_grabador.php?id="+vnombre,true);	
			ajax.onreadystatechange=function()
			{  		
				if (ajax.readyState==1)
				{
					divResultado2.innerHTML='Cargando...<img src="indicator_green.gif">';
				}
				
				if(ajax.readyState==4)
				{ //si es 4, ya la respuesta del servidor esta lista, de lo contrario...
					
					if (ajax.status==200)
					{
						divResultado2.innerHTML=ajax.responseText;
						divResultado2.innerHTML='';
						return;
					}
				
					else if(ajax.status==404)
					{ // ...de lo contrario se muestra el texto CARGANDO 
						divResultado2.innerHTML='Cargando...<img src="indicator_green.gif">'; 
					}
					else
					{
						divResultado2.innerHTML='Error...'.ajax.status; 
					}
					
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		
			ajax.send(null);
	
}

function lnk_ta(pvar, pnom){
	ajax=objetoAjax();
	divResultado2 = document.getElementById('zonaaudita');
	//divResultado2 = document.getElementById('zonenuevo');	
		
		ajax.open("POST", "busca_audi.php?id="+pvar+"&nom="+pnom,true);	
			ajax.onreadystatechange=function()
			{  		
				if (ajax.readyState==1)
				{
					divResultado2.innerHTML='Cargando...<img src="indicator_green.gif">';
				}
				
				if(ajax.readyState==4)
				{ //si es 4, ya la respuesta del servidor esta lista, de lo contrario...
					
					if (ajax.status==200)
					{
						divResultado2.innerHTML=ajax.responseText;
						//divResultado2.innerHTML='';
						///divResultado1.innerHTML=ajax.responseText;
						return;
					}
				
					else if(ajax.status==404)
					{ // ...de lo contrario se muestra el texto CARGANDO 
						divResultado2.innerHTML='Cargando...<img src="indicator_green.gif">'; 
					}
					else
					{
						divResultado2.innerHTML='Error...'.ajax.status; 
					}
					
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		
			ajax.send(null);
	
}

function adilcos(){
	ajax=objetoAjax();
	divResultado22 = document.getElementById('zenda1');
	//divResultado2 = document.getElementById('zonenuevo');	
		
		ajax.open("POST", "adicl.php",true);	
			ajax.onreadystatechange=function()
			{  		
				if (ajax.readyState==1)
				{
					divResultado2.innerHTML='Cargando...<img src="indicator_green.gif">';
				}
				
				if(ajax.readyState==4)
				{ //si es 4, ya la respuesta del servidor esta lista, de lo contrario...
					
					if (ajax.status==200)
					{
						divResultado22.innerHTML=ajax.responseText;
						//divResultado2.innerHTML='';
						///divResultado1.innerHTML=ajax.responseText;
						return;
					}
				
					else if(ajax.status==404)
					{ // ...de lo contrario se muestra el texto CARGANDO 
						divResultado22.innerHTML='Cargando...<img src="indicator_green.gif">'; 
					}
					else
					{
						divResultado22.innerHTML='Error...'.ajax.status; 
					}
					
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		
			ajax.send(null);
	
}


function lnk_ta(pvar, pnom){
	ajax=objetoAjax();
	divResultado2 = document.getElementById('zonaaudita');
	//divResultado2 = document.getElementById('zonenuevo');	
		
		ajax.open("POST", "busca_audi.php?id="+pvar+"&nom="+pnom,true);	
			ajax.onreadystatechange=function()
			{  		
				if (ajax.readyState==1)
				{
					divResultado2.innerHTML='Cargando...<img src="indicator_green.gif">';
				}
				
				if(ajax.readyState==4)
				{ //si es 4, ya la respuesta del servidor esta lista, de lo contrario...
					
					if (ajax.status==200)
					{
						divResultado2.innerHTML=ajax.responseText;
						//divResultado2.innerHTML='';
						///divResultado1.innerHTML=ajax.responseText;
						return;
					}
				
					else if(ajax.status==404)
					{ // ...de lo contrario se muestra el texto CARGANDO 
						divResultado2.innerHTML='Cargando...<img src="indicator_green.gif">'; 
					}
					else
					{
						divResultado2.innerHTML='Error...'.ajax.status; 
					}
					
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		
			ajax.send(null);
	
}

function borra_ta(pvar, pnom){
	
	ajax=objetoAjax();
	divResultado22 = document.getElementById('formulario');
	
	if(window.confirm("Desea eliminar PERMANENTEMENTE el tipo de Auditoria "+ pnom +" ?")) 
	{
		ajax.open("POST", "del_ta.php?id="+pvar,true);	
			ajax.onreadystatechange=function()
			{  		
				if (ajax.readyState==1)
				{
					divResultado22.innerHTML='Cargando...<img src="../indicator_green.gif">';
				}
				
				if(ajax.readyState==4)
				{ //si es 4, ya la respuesta del servidor esta lista, de lo contrario...
					
					if (ajax.status==200)
					{
						divResultado22.innerHTML=ajax.responseText;
						window.location.reload();
					}
				
					else if(ajax.status==404)
					{ // ...de lo contrario se muestra el texto CARGANDO 
						divResultado22.innerHTML='Cargando...<img src="../indicator_green.gif">'; 
					}
					else
					{
						divResultado22.innerHTML='Error...'.ajax.status; 
					}
					
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		
			ajax.send(null);
	}
	else
	{
		divResultado22.innerHTML="";
	}
}

<?php $ruta = "Publico/dataTables/"; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>.::: Consulta de Riesgos</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="<?php echo $ruta; ?>css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $ruta; ?>css/base.css" />         

        <script type="text/javascript" src="<?php echo $ruta; ?>js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta; ?>js/funcionesriesgos.js"></script>
  
        <link rel="stylesheet" type="text/css" href=<?php echo $ruta; ?>"css/demo_table.css" />
        <script type="text/javascript" language="javascript" src="<?php echo $ruta; ?>js/jquery.dataTables.js">
        </script>        
    </head>
    <body>
    <div class="consul">
        <div id="divimgs1">
                <div id="logo1" align="center"><img src="../images/header1x.png"></div>    
        </div><br>        
        <header>
            <h2>Listado de Riesgos</h2>
        </header>
    
        <article id="contenido"></article>
		<!-- <footer>&copy; INTER RAPIDISIMO S.A. 2014</footer>  --> 
   </div>   
</body>
</html>
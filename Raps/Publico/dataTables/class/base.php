<?php require_once('../../Connections/cnn_cargo.php'); 
session_start();
?>
<?php 
//echo "f.......".$_SESSION['autenticado']."<br>"; 
//&& isset($_SESSION['uid']))
if ( !isset($_SESSION['autenticado']) && $_SESSION['autenticado'] != 'SI' )
{
?>	
	<form name="formulario" method="post" action="../../imenu/index.php">
	<input type="hidden" name="msg_error" value="2">
	</form>
	<script type="text/javascript"> 
	alert("bye...");
		document.formulario.submit();
	</script>
<?php
}
else {
?>	
    <!DOCTYPE html>
    <!--[if lt IE 7 ]> <html lang="en" class="no-js ie6 lt8"> <![endif]-->
    <!--[if IE 7 ]>    <html lang="en" class="no-js ie7 lt8"> <![endif]-->
    <!--[if IE 8 ]>    <html lang="en" class="no-js ie8 lt8"> <![endif]-->
    <!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
    <!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <title>.::.   Menu Principal .::.</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../../base_base.css"/>
        <link rel="stylesheet" href="../../imenu/css/style_base.css" type="text/css" media="screen"/>
        <style>
        body{
        font-family:Arial;
        }
        .content{
        width:940px;
        clear: both;
        /*margin-left: 1px;  posicion del menu*/
                }
                span.reference{
                    position:fixed;
                    left:10px;
                    bottom:10px;
                    font-size:12px;
                }
                span.reference a{
                    color:#aaa;
                    text-transform:uppercase;
                    text-decoration:none;
                    text-shadow:1px 1px 1px #000;
                    margin-right:30px;
                }
                span.reference a:hover{
                    color:#ddd;
                }
                ul.sdt_menu{
                    margin-top:100px;
                }
                h1.title{
                    text-indent:-9000px;
                    background:transparent url(../../imenu/title.png) no-repeat top left;
                    width:633px;
                    height:69px;
                }
            </style>
    </head>
    
    <body>
        <div  align="center">
        <div class="logindexa">
            <div class="content" align="center">        
            <p><div id="mk" align="left"><?php echo "Bienvenido: ".strtoupper($_SESSION['nombresusu']) ?></div></p>
                <p><div id="mk" align="left">,   seleccione la Operaci&oacute;n a realizar:</div></p>                
        </div>
            <hr>
            <div>
                <div class="xlogindexa" align="center">
                <table title="Membership of W3C" summary="Test Table"> 
                <caption>W3C Membership</caption> 
                <thead> 
                <tr> 
                <th>Type</th>
                <th>America</th>
                <th>Europe</th>
                <th>Pacific</th>
                <th>Total</th> 
                </tr> 
                </thead> 
                <tbody> 
                <tr> 
                <th>Full</th>
                    <td>62</td>
                    <td>29</td>
                    <td>17</td>
                    <td>108</td> 
                </tr> 
                <tr> 
                <th>Affiliate</th>
                <td>240</td>
                <td>123</td>
                <td>47</td>
                <td>410</td> 
                </tr>
                <tr>
                <th>Total</th>
                <td>302</td>
                <td>152</td>
                <td>64</td>
                <th>518</th>
                </tr>
                </tbody>
                </table>
                </div>
          </div>
    
            <!-- The JavaScript -->
            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
            <script type="text/javascript" src="../../imenu/jquery.easing.1.3.js"></script>
            <script type="text/javascript">
                $(function() {
                    /**
                    * for each menu element, on mouseenter, 
                    * we enlarge the image, and show both sdt_active span and 
                    * sdt_wrap span. If the element has a sub menu (sdt_box),
                    * then we slide it - if the element is the last one in the menu
                    * we slide it to the left, otherwise to the right
                    */
                    $('#sdt_menu > li').bind('mouseenter',function(){
                        var $elem = $(this);
                        $elem.find('img')
                             .stop(true)
                             .animate({
                                'width':'170px',
                                'height':'170px',
                                'left':'0px'
                             },400,'easeOutBack')
                             .andSelf()
                             .find('.sdt_wrap')
                             .stop(true)
                             .animate({'top':'140px'},500,'easeOutBack')
                             .andSelf()
                             .find('.sdt_active')
                             .stop(true)
                             .animate({'height':'170px'},300,function(){
                            var $sub_menu = $elem.find('.sdt_box');
                            if($sub_menu.length){
                                var left = '170px';
                                if($elem.parent().children().length == $elem.index()+1)
                                    left = '-170px';
                                $sub_menu.show().animate({'left':left},200);
                            }	
                        });
                    }).bind('mouseleave',function(){
                        var $elem = $(this);
                        var $sub_menu = $elem.find('.sdt_box');
                        if($sub_menu.length)
                            $sub_menu.hide().css('left','0px');
                        
                        $elem.find('.sdt_active')
                             .stop(true)
                             .animate({'height':'0px'},300)
                             .andSelf().find('img')
                             .stop(true)
                             .animate({
                                'width':'0px',
                                'height':'0px',
                                'left':'85px'},400)
                             .andSelf()
                             .find('.sdt_wrap')
                             .stop(true)
                             .animate({'top':'25px'},500);
                    });
                });
            </script>
            <p>&nbsp;</p>
            <hr>
            <p>&nbsp;</p>            
          <p align="center"><span class="badge badge-inverse">&copy; AGENTE DE CARGA 2013</span></p>
        </div>
        </div>    
    </body>
    </html>
<?php
}
?>	    
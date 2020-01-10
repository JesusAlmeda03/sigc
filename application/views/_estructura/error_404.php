<?php
/****************************************************************************************************
*
*  VIEWS/_estructura/error_404.php
*
*   	Descripción:
*			Error 404 de página no encontrada
*
*		Fecha de Creación:
*			06/Octubre/2011
*
*		Ultima actualización:
*			31/Julio/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas 
*
****************************************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="google-site-verification" content="DmAKz0NdpgmHDSro7vRYZw3ku_1LPRJ0opu6zSNq5tE" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>P&aacute;gina no Encontrada | Sistema Integral de Gesti&oacute;n de Calidad UJED</title>
		
		<!-- cufon -->
		<script src="<?=base_url()?>includes/js/cufon/cufon-yui.js" type="text/javascript"></script>
		<script src="<?=base_url()?>includes/js/cufon/GeosansLight_500-GeosansLight_oblique_500.font.js" type="text/javascript"></script>	
		<script type="text/javascript">
		Cufon.replace( '.titulo, .menu_item, .paginas, #nombre' );
		</script>
		
		<!-- jquery ui -->
		<link type="text/css" href="<?=base_url()?>includes/jquery-ui-1.8.16/css/sigc/jquery-ui-1.8.16.custom.css" rel="Stylesheet" />
		<script type="text/javascript" src="<?=base_url()?>includes/jquery-ui-1.8.16/js/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>includes/jquery-ui-1.8.16/js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>includes/jquery-ui-1.8.16/js/jquery.ui.datepicker-es.js"></script>
		
		<!-- hoja de estilos -->
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>includes/css/estilo.css" />
		
		<!-- funciones javascript -->
		<script type="text/javascript" src="<?=base_url()?>includes/js/funciones.js"></script>
		
		<!-- menu -->
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>includes/css/menu.css" media="screen">
		<script type="text/javascript" src="<?=base_url()?>includes/js/menu/hoverIntent.js"></script>
		<script type="text/javascript" src="<?=base_url()?>includes/js/menu/superfish.js"></script>				
		<script type="text/javascript" src="<?=base_url()?>includes/js/collapse.js"></script>			
		<script type="text/javascript">				
		animatedcollapse.addDiv('box_user_act', 'fade=1,height=auto')
		animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
			//$: Access to jQuery
			//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
			//state: "block" or "none", depending on state
		}			
		animatedcollapse.init();
		jQuery(function(){
			jQuery('ul.sf-menu').superfish();
		});	
		</script>
		
		<!-- datatables -->
		<style type="text/css" title="currentStyle"> @import "<?=base_url()?>includes/datatables-1.8.3/css/tabla.css"; </style>        
        <script type="text/javascript" language="javascript" src="<?=base_url()?>includes/datatables-1.8.3/js/jquery.dataTables.js"></script>        
		<link rel="shortcut icon" href="<?=base_url()?>includes/img/sigc.png"/>
		
		<!-- tinymce -->
		<script type="text/javascript" src="<?=base_url()?>includes/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript">
            tinyMCE.init({
                mode : "textareas",
                theme : "simple",
            });
        </script>            
	</head>
	
	<body>
		<div class="wrapper">
	        <div class="banner">
	        	<table style="width:955px; margin:auto; padding-top:5px;">
	        		<tr>
	        			<td width="68">
	        				<div style="width:40px; height:40px; background-color:#FFF; border:1px solid #EEE; margin-left:8px; padding:5px;">
	        					<img src="<?=base_url()?>includes/img/sigc.png" />
	        				</div>
	        			</td>
	        			<td valign="middle">
							<div id="nombre" style="font-size:42px; color:#FFF; padding-top:5px">			                	
		               			SISTEMA INTEGRAL DE GESTI&Oacute;N DE CALIDAD UJED
		               		</div>
	        			</td>                			
	        		</tr>
	        	</table>
	        </div>
			<div class="content">
				<div class="cont" style="width:970px; min-height:300px">
					<div class="titulo">P&aacute;gina no Encontrada</div>
					<div class="texto">
                    	<table>
                        	<tr>
                            	<td>
			                    	<img src="http://scalidad.ujed.mx/includes/img/404.gif" />
                                </td>
                                <td valign="top" style="padding:20px; text-align:center">
                                La p&aacute;gina que buscas no se encuentra, por favor revisa que hayas escrito correctamente la dirección e intentalo de nuevo, si regresas a esta
                                p&aacute;gina comunicate con el web master:<br /><br /><br />
                                <div style="width:300px; height:auto; padding:20px 10px; margin:auto; text-align:center; border:1px solid #CCC;">
                                    Web Master: <a href="<?=base_url()?>index.php/misc/contacto">ISC Rogelio Casta&ntilde;eda Andrade</a><br />
                                    e-mail: <a href="#">rogeliocas@gmail.com</a><br />    
                                    ext: 3036
                                </div>     
                                <br /><br />
                                Tambi&eacute;n puedes regresar a la p&aacute;gina de inicio:<br />
                                <a href="<?=base_url()?>">Sistema Integral de Gesti&oacute;n de Calidad UJED</a>
                                </td>
                            </tr>
                        </table>
                    </div>
				</div>
			</div>	        
		</div>
		<div class="footer">
            <span style="font-size:12px">Sistema Integral de Gesti&oacute;n de Calidad UJED</span><br />
            Web Master: <a href="http://www.webHERE.com.mx" target="_blank">ISC Rogelio Casta&ntilde;eda Andrade</a><br />
            e-mail: <a href="#">rogeliocas@gmail.com</a><br />
            ext: 3036
        </div>
	</body>
</html>
<?php
/****************************************************************************************************
*
*  VIEWS/_estructura/header.php
*
*   	Descripción:
*			Header del sistema
*
*		Fecha de Creación:
*			06/Octubre/2011
*
*		Ultima actualización:
*			09/Julio/2011
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
			<title><?=$titulo?> | Sistema Integral de Gesti&oacute;n de Calidad</title>
			
			<!-- meta tags -->
			<meta name="description" content="Sitio web del Sistema Integral de Gestión de Calidad de la Universidad Juárez del Estado de Durango" />
			<meta name="keywords" content="sistema integral de gestion de calidad, sistema integral de gestion de calidad ujed, sistema de calidad ujed, sistema de gestión de calidad ujed, ujed, calidad ujed, scalidad, scalidad ujed" />
			<meta name="author" content="ISC Rogelio Castañeda Andrade" />
			<meta name="robots" content="index, follow" />

			<!-- fuentes 
			<link href='http://fonts.googleapis.com/css?family=Nunito:300|Open+Sans' rel='stylesheet' type='text/css'> -->
			<!-- cufon -->
			<script src="<?=base_url()?>includes/js/cufon/cufon-yui.js" type="text/javascript"></script>
			<script src="<?=base_url()?>includes/js/cufon/GeosansLight_500-GeosansLight_oblique_500.font.js" type="text/javascript"></script>	
			<script type="text/javascript">
			Cufon.replace( '#nombre_titulo, .titulo_tabla' );
			</script>
			<script src="<?=base_url()?>includes/js/cufon/Walkway_SemiBold_400.font.js" type="text/javascript"></script>	
			<script type="text/javascript">
			Cufon.replace( '.titulo, .menu_item, .paginas, .footer, .area' );
			</script>
			
			<!-- jquery ui -->
			<link type="text/css" href="<?=base_url()?>includes/jquery-ui-1.9.0.custom/css/scalidad/jquery-ui-1.9.0.custom.css" rel="Stylesheet" />
			<script type="text/javascript" src="<?=base_url()?>includes/jquery-ui-1.9.0.custom/js/jquery-1.8.2.js"></script>
			<script type="text/javascript" src="<?=base_url()?>includes/jquery-ui-1.9.0.custom/js/jquery-ui-1.9.0.custom.min.js"></script>
			<script type="text/javascript" src="<?=base_url()?>includes/jquery-ui-1.9.0.custom/js/jquery.ui.datepicker-es.js"></script>
			<script>
			$(function() {
				$( ".in_button" ).button({
					icons: {
		                primary: "ui-icon-locked"
		            },
		    	});
			});
			</script>
			
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

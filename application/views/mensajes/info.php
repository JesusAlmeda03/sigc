<?php
/****************************************************************************************************
*
*  VIEWS/_pagina/info.php
*
*	Descripción:  		  
*		Despliega un mensaje de información
*
*	Fecha de Creación:
*		10/Octubre/2011
*
*	Ultima actualización:
*		12/Octubre/2011
*
*	Autor:
*		ISC Rogelio Castañeda Andrade
*		HERE (http://www.webHERE.com.mx)
*		rogeliocas@gmail.com
*
****************************************************************************************************/
?>
<script>
$(function() {
	$( "#msj_ok" ).dialog({
		modal: true,
		buttons: {
			Aceptar: function() {				
				$( this ).dialog( "close" );
			}
		}
	});
});
</script>
<div id="msj_ok" title="<?=$msj_titulo;?>">
	<span class="ui-icon ui-icon-alert" style="float:left; margin:0 15px 0px 0;"></span>
	<p style="padding-right:5px; margin-left:30px"><?=$mensaje?></p>
</div>
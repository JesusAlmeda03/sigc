<?php
/****************************************************************************************************
*
*  VIEWS/_pagina/info.php
*
*	Descripci�n:  		  
*		Despliega un mensaje de informaci�n
*
*	Fecha de Creaci�n:
*		10/Octubre/2011
*
*	Ultima actualizaci�n:
*		12/Octubre/2011
*
*	Autor:
*		ISC Rogelio Casta�eda Andrade
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
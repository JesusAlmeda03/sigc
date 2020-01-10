<?php
/****************************************************************************************************
*
*  VIEWS/_pagina/ok_redirec.php
*
*	Descripción:  		  
*		Despliega un mensaje de éxito y te redirecciona a una pagina específica
*
*	Fecha de Creación:
*		12/Octubre/2011
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
		},
		close: function(event, ui) { location.href = "<?=base_url()."index.php/".$enlace?>"; }		
	});
});
</script>
<div id="msj_ok" title="<?=$mensaje_titulo;?>">
	<span class="ui-icon ui-icon-check" style="float:left; margin:0 15px 0px 0;"></span>
	<p style="padding-right:5px; margin-left:30px"><?=$mensaje?></p>
</div>
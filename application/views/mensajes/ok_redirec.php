<?php
/****************************************************************************************************
*
*  VIEWS/_pagina/ok_redirec.php
*
*	Descripci�n:  		  
*		Despliega un mensaje de �xito y te redirecciona a una pagina espec�fica
*
*	Fecha de Creaci�n:
*		12/Octubre/2011
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
		},
		close: function(event, ui) { location.href = "<?=base_url()."index.php/".$enlace?>"; }		
	});
});
</script>
<div id="msj_ok" title="<?=$mensaje_titulo;?>">
	<span class="ui-icon ui-icon-check" style="float:left; margin:0 15px 0px 0;"></span>
	<p style="padding-right:5px; margin-left:30px"><?=$mensaje?></p>
</div>
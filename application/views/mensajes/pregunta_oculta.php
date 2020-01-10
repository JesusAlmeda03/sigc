<?php
/****************************************************************************************************
*
*  VIEWS/mensajes/pregunta_oculta.php
*
*		Descripción:
*			Despliega un mensaje de pregunta
*
*		Fecha de Creación:
*			20/Octubre/2011
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
<script>
function pregunta_cambiar( tipo, id, estado, pregunta, redirecciona ) {
	enlace = "<?=base_url()?>index.php/admin/inicio/cambiar_estado/"+tipo+"/"+id+"/"+estado+"/"+redirecciona;
	$(function() {
		$( "#pregunta_oculta" ).html( '<p><span class="ui-icon ui-icon-help" style="float:left; margin:0 7px 20px 0;"></span></p>'+pregunta );
		$( "#pregunta_oculta" ).dialog({
			autoOpen: true,
			resizable: false,
			width:'auto',
			height:'auto',
			modal: true,
			buttons: {
				"Si": function() {
					$( this ).dialog( "close" );
					location.href = enlace;
				},
				"No": function() {
					$( this ).dialog( "close" );
				}
			},
		});
	});
}
</script>
<div id="pregunta_oculta" title="Confirma" ></div>  
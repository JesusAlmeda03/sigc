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
function pregunta_eliminar_medicion( id_indicador, id_medicion, pregunta, tipo ) {
	enlace = "<?=base_url()?>index.php/procesos/indicadores/eliminar_medicion/"+id_indicador+"/"+id_medicion+"/"+tipo;
	$(function() {
		$( "#pregunta_eliminar_medicion" ).html( '<p><span class="ui-icon ui-icon-help" style="float:left; margin:0 7px 20px 0;"></span></p>'+pregunta );
		$( "#pregunta_eliminar_medicion" ).dialog({
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
<div id="pregunta_eliminar_medicion" title="Confirma" ></div>  
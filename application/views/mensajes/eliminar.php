<?php
/****************************************************************************************************
*
*  VIEWS/_pagina/pregunta_enlaces.php
*
*	Descripción:  		  
*		Despliega un mensaje de pregunta, recibe 2 enlaces para redireccionar segunr la respuesta
*
*	Fecha de Creación:
*		20/Octubre/2011
*
*	Ultima actualización:
*		20/Octubre/2011
*
*	Autor:
*		ISC Rogelio Castañeda Andrade
*		HERE (http://www.webHERE.com.mx)
*		rogeliocas@gmail.com
*
****************************************************************************************************/
$uri = str_replace('/','-',uri_string());

?>
<script>
var item_eliminar;
function pregunta_eliminar( i, pre ) {
	item_eliminar = i;
	document.getElementById( "eliminar_pregunta" ).innerHTML = pre;
	$('#msj_eliminar').dialog('open');
}

$(function() {                    
	$( "#msj_eliminar" ).dialog({
		autoOpen: false,
		resizable: true,
		width:'auto',
		height:'auto',
		modal: true,
		position: "center",
		buttons: {
			"Si": function() {
				$( this ).dialog( "close" );
				location.href = "<?=base_url()?>index.php/misc/eliminar/<?=$cambiar_tipo?>/" + item_eliminar + "/<?=$uri?>";
			},
			"No": function() {
				$( this ).dialog( "close" );
			}
		},
	});
});
</script>
<div id="msj_eliminar" title="Eliminar"><p><span class="ui-icon ui-icon-help" style="float:left; margin:0 7px 20px 0;"></span><span id="eliminar_pregunta">Pregunta?</span></p></div>
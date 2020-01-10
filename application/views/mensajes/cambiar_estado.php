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
var item_cambiar;
var item_estado;
function pregunta_cambiar( i, edo, pre ) {
	item_cambiar = i;
	item_estado = edo;
	document.getElementById( "cambiar_pregunta" ).innerHTML	= pre
	$('#msj_cambiar').dialog('open');
}

$(function() {                    
	$( "#msj_cambiar" ).dialog({
		autoOpen: false,
		resizable: true,
		width:'auto',
		height:'auto',
		modal: true,
		position: "center",
		buttons: {
			"Si": function() {
				$( this ).dialog( "close" );
				location.href = "<?=base_url()?>index.php/misc/cambiar_estado/<?=$cambiar_tipo?>/" + item_cambiar + "/" + item_estado + "/<?=$uri?>";
			},
			"No": function() {
				$( this ).dialog( "close" );
			}
		},
	});
});
</script>
<div id="msj_cambiar" title="Cambiar de Estado" style="display:none"><p><span class="ui-icon ui-icon-help" style="float:left; margin:0 7px 20px 0;"></span><span id="cambiar_pregunta">Pregunta?</span></p></div>
<?php
/****************************************************************************************************
*
*  VIEWS/_pagina/pregunta_enlaces.php
*
*	Descripci�n:  		  
*		Despliega un mensaje de pregunta, recibe 2 enlaces para redireccionar segunr la respuesta
*
*	Fecha de Creaci�n:
*		20/Octubre/2011
*
*	Ultima actualizaci�n:
*		20/Octubre/2011
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
	$( "#pregunta" ).dialog({
		autoOpen: true,
		resizable: false,
		width:'auto',
		height:'auto',
		modal: true,
		buttons: {
			"Si": function() {
				$( this ).dialog( "close" );
				location.href = "<?=base_url().'index.php/'.$enlace_si?>/";
			},
			"No": function() {
				$( this ).dialog( "close" );
				location.href = "<?=base_url().'index.php/'.$enlace_no?>/";
			}
		},
	});
});
</script>
<div id="pregunta" title="<?=$mensaje_titulo?>">
	<p><span class="ui-icon ui-icon-help" style="float:left; margin:0 7px 20px 0;"></span><?=$mensaje?></p>
</div>  
<?php
/****************************************************************************************************
*
*  VIEWS/_pagina/error_validacion.php
*
*	Descripción:  		  
*		Despliega los errores de validación del formulario
*
*	Fecha de Creación:
*		30/Septiembre/2011
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
if ( validation_errors() ) { ?>
	<script>
	$(function() {
		$( "#msj_error_validacion" ).dialog({
			modal: true,
			buttons: {
				Aceptar: function() {				
					$( this ).dialog( "close" );
				}
			}
		});
	});
	</script>
	<div id="msj_error_validacion" title="Error de Validaci&oacute;n">
		<span class="ui-icon ui-icon-close" style="float:left; margin:0 15px 0px 0;"></span>
		<p style="padding-right:5px; margin-left:30px"><?=validation_errors()?></p>
	</div>
	<?php
}
?>
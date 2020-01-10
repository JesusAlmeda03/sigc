<?php
/****************************************************************************************************
*
*	VIEWS/admin/evaluaciones/iniciar.php
*
*		Descripción:
*			Vista iniciar evaluaciones 
*
*		Fecha de Creación:
*			30/Octubre/2011
*
*		Ultima actualización:
*			9/Febrero/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
?>
    <div class="cont_admin">
    	<div class="titulo"><?=$titulo?></div>    	
        <div class="texto"> 
        	<script>
			$(function() {
                $( "#fecha" ).datepicker({
					changeMonth: true,
					changeYear: true,
				});
				$('#fecha').datepicker($.datepicker.regional['es']);
				$('#fecha').datepicker('option', {dateFormat: 'yy-mm-d'});
				$("#startDate").datepicker({dateFormat: 'yy-mm-dd'});
			});				
         	</script>       	
			<?php
			$encuesta_extras = 'id="encuesta" onfocus="hover(\'encuesta\')"  style="width:350px"';
			$formulario = array(
				// * Boton submit
				'boton' => array (
					'name'		=> 'aceptar',
					'class'		=> 'in_button',
					'style'		=> ' width:250px'
				),
				// Nombre
				'nombre' => array (
					'name'		=> 'nombre',
					'id'		=> 'nombre',
					'value'		=> set_value('nombre'),
					'class'		=> 'in_text',
					'onfocus'	=> "hover('nombre')",
				),
				// Fecha
				'fecha' => array (
					'name'		=> 'fecha',
					'id'		=> 'fecha',
					'value'		=> set_value('fecha'),
					'class'		=> 'in_text',
					'onfocus'	=> "hover('fecha')",					
				),
				// Observaciones
				'observaciones' => array (
					'name'		=> 'observaciones',
					'id'		=> 'observaciones',
					'value'		=> set_value('observaciones'),
					'class'		=> 'in_area',
					'onfocus'	=> "hover('observaciones')",
				)				
			);			
			echo form_open();
			echo '<table class="tabla_form" width="980">';
			echo '<tr><th class="text_form" width="50">Encuesta: </th>';
			echo '<td>'.form_dropdown('encuesta',$encuesta_options,set_value('encuesta'),$encuesta_extras).'</td></tr>';
			echo '<tr><th class="text_form">Nombre: </th>';
			echo '<td>'.form_input($formulario['nombre']).'</td>';
			echo '<tr><th class="text_form">Fecha: </th>';
			echo '<td>'.form_input($formulario['fecha']).'</td>';
			echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Observaciones: </th>';
			echo '<td>'.form_textarea($formulario['observaciones']).'</td></tr>';
			echo '</table><br />';
			echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Iniciar Evaluacion').'</div>';
			echo form_close();
            ?>
        </div>
    </div>
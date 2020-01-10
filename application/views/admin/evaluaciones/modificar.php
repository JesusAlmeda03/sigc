<?php
/****************************************************************************************************
*
*	VIEWS/admin/evaluaciones/modificar.php
*
*		Descripción:
*			Vista modificar evaluaciones 
*
*		Fecha de Creación:
*			9/Febrero/2012
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
        <div class="text">        	
			<?php
			$encuesta_extras = 'id="encuesta" onfocus="hover(\'encuesta\')"  style="width:350px"';
			$formulario = array(
				// * Boton submit
				'boton' => array (
					'name'		=> 'aceptar',
					'class'		=> 'in_button',					
				),
				// Fecha
				'fecha' => array (
					'name'		=> 'fecha',
					'id'		=> 'fecha',
					'value'		=> $fec,
					'class'		=> 'in_text',
					'onfocus'	=> "hover('fecha')",					
				),
				// Observaciones
				'observaciones' => array (
					'name'		=> 'observaciones',
					'id'		=> 'observaciones',
					'value'		=> $obs,
					'class'		=> 'in_area',
					'onfocus'	=> "hover('observaciones')",
				)				
			);			
			echo form_open();
			echo '<table class="tabla_form" width="950">';
			echo '<tr><th class="text_form" width="50">Encuesta: </th>';
			echo '<td>'.$enc.'</td></tr>';
			echo '<tr><th class="text_form">Fecha: </th>';
			echo '<td>'.form_input($formulario['fecha']).'</td>';
			echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Observaciones: </th>';
			echo '<td>'.form_textarea($formulario['observaciones']).'</td></tr>';
			echo '</table><br />';
			echo '<div style="width:950px; text-align:center;">'.form_submit($formulario['boton'],'Modificar').'</div>';
			echo form_close();
            ?>
        </div>
    </div>
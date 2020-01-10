<?php
/****************************************************************************************************
*
*	VIEWS/procesos/capacitacion/inicio.php
*
*		Descripción:
*			Vista principal de capacitación
*
*		Fecha de Creación:
*			09/Enero/2013
*
*		Ultima actualización:
*			09/Enero/2013
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
?>
	<div class="content">
		<div class="cont">
			<div class="titulo"><?=$titulo?></div>
            <div class="texto">
            	<?php
            	$formulario = array(
					// * Boton submit
					'boton' => array (
						'id'		=> 'aceptar',
						'name'		=> 'aceptar',
						'class'		=> 'in_button',
						'onfocus'	=> 'hover(\'aceptar\')'
					),
					// Fecha
					'fecha' => array (
						'name'		=> 'fecha',
						'id'		=> 'fecha',
						'value'		=> set_value('fecha'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('fecha')",
						'style'		=> 'width:200px'

					),
				);
				
            	echo form_open();
				echo '<table class="tabla_form" width="700">';
            	echo '<tr><th class="text_form">Campo: </th>';
				echo '<td>'.form_input($formulario['fecha']).'</td></tr>';
				echo '</table><br />';
				echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
				echo form_close();
            	?>
            </div>
		</div>
<?php
/****************************************************************************************************
*
*	VIEWS/procesos/expediente/revisar.php
*
*		Descripción:
*			Revisa el expediente de un usuario 
*
*		Fecha de Creación:
*			10/Enero/2013
*
*		Ultima actualización:
*			10/Enero/2013
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
$formulario = array(
	// * Boton submit
	'boton' => array (
		'id'		=> 'aceptar',
		'name'		=> 'aceptar',
		'class'		=> 'in_button',
		'onfocus'	=> 'hover(\'aceptar\')'
	),
	// Archivo
	'Descripcion' => array (
		'name'		=> 'Descripcion',
		'id'		=> 'Descripcion',
		'value'		=> set_value('Descripcion'),
		'class'		=> 'in_text',
		'onfocus'	=> "hover('Descripcion')",
	)
);

?>
	<div class="content">
		<div class="cont">
			<div class="titulo"><?=$titulo?></div>
            <div class="texto">
            	<?php
					echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
					echo '<table class="tabla_form" width="700">';
					echo '<tr><th class="text_form" width="80">Descripcion: </th>';
					echo '<td>'.form_input($formulario['Descripcion']).'</td></tr>';
					echo '<tr><th class="text_form" width="80">Tipo: </th>';
					echo '<td><select name="Tipo" class="in_text">
									<option disabled="" slected="selected"> - Selecciona un Tipo -</option>
									<option value="constancia">Constancia</option>
									<option value="Induccion">Induccion</option>
									<option disabled=""> -- Grado de Estudios -- </option>
									<option value="estudios">Estudios Tecnicos</option>
									<option value="licenciatura">Licenciatura</option>
									<option value="maestria">Maestría</option>
									<option value="doctorado">Doctorado</option>
								</select>
						 </td></tr>';
					echo '</table><br />';
					echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
					echo form_close();
				?>
            </div>
			
		</div>
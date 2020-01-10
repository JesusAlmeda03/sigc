<?php
/****************************************************************************************************
*
*	VIEWS/inicio/contacto.php
*
*		Descripción:
*			Formulario de Contacto
*
*		Fecha de Creación:
*			10/Octubre/2011
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
	<div class="content">		
		<div class="cont">
			<div class="titulo"><?=$titulo?></div>
			<div class="texto" style="font-size:20px">
				<?php							
				$formulario = array(
					// * Boton submit
					'boton' => array (
						'name'		=> 'enviar',
						'class'		=> 'in_button'
					),
					// Nombre
					'nombre' => array (
						'name'		=> 'nombre',
						'id'		=> 'nombre',
						'value'		=> $this->session->userdata('nombre'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('nombre')",
					),
					// Correo
					'correo' => array (
						'name'		=> 'correo',
						'id'		=> 'correo',
						'value'		=> $this->session->userdata('correo'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('correo')",
					),
					// Mensaje
					'mensaje' => array (
						'name'		=> 'mensaje',
						'id'		=> 'mensaje',
						'value'		=> set_value('mensaje'),
						'class'		=> 'in_area',
						'onfocus'	=> "hover('mensaje')",
					)
				);
				echo form_open();
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="text_form" width="50">Nombre: </th>';
				echo '<td>'.form_input($formulario['nombre']).'</td></tr>';
				echo '<tr><th class="text_form">Correo: </th>';
				echo '<td>'.form_input($formulario['correo']).'</td>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Mensaje: </th>';
				echo '<td>'.form_textarea($formulario['mensaje']).'</td></tr>';
				echo '</table><br />';
				echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
				echo form_close();
				?>
			</div>
		</div>
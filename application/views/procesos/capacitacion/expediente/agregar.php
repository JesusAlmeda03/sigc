<?php
/****************************************************************************************************
*
*	VIEWS/procesos/expediente/agregar.php
*
*		Descripción:
*			Agrega una evidencia al expediente del usuario
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
					// Archivo
	                'archivo' => array (
	                    'name'		=> 'archivo',
	                    'id'		=> 'archivo',
	                    'value'		=> set_value('archivo'),
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('archivo')",
	                )
				);
				
            	echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
	            echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="text_form" width="80">Usuario: </th>';
	            echo '<td>'.$nombre_usuario.'</td></tr>';
	            echo '<tr><th class="text_form" width="80">Archivo: </th>';
	            echo '<td>'.form_upload($formulario['archivo']).'</td></tr>';
	            echo '</table><br />';
	            echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
	            echo form_close();
            	?>
            	<br /><br />
				<table><tr><td><a href="<?=base_url()?>index.php/procesos/capacitacion/expediente_listado" onmouseover="tip('Regresa al listado<br />de usuarios')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/procesos/capacitacion/expediente_listado" onmouseover="tip('Regresa al listado<br />de usuarios')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
            </div>
		</div>
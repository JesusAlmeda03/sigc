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
					)
				);
				
            // guarda las respuestas del puesto
            	echo form_open();
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="text_form" width="130">Puesto: </th>';
				echo '<td style="font-size:18px">'.$puesto_usuario.'</td></tr>';
				echo '</table><br />';
				if( $habilidades->num_rows() > 0 ) {
					echo '<table class="tabla_opciones" width="700">';
					echo '<tr>';
					echo '<th style="font-weight:bold; text-align:center; font-size:14px">Habilidades y Aptitudes</th>';
					for( $x = 1; $x <= 10; $x++ )
						echo '<th><strong style="font-size:28px;" class="menu_item">'.$x.'</strong></th>';
					echo '</tr>';
					foreach( $habilidades->result() as $row ) {
						echo '<tr>';
						echo '	<th>'.$row->Habilidad.'</th>';
						for( $x = 1; $x <= 10; $x++ )
							echo '<td><input type="radio" name="habilidad_'.$row->IdCapacitacionHabilidad.'"  value="'.$x.'" /> <br /><br /></td>';
						echo '</tr>';
					}
					echo '</table>';
				}
				else {
					echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no puedes realizar la Detección de Necesidades de Capacitación porque no hay Habilidades y Aptitudes registradas para tu puesto.</td></tr></table>';
				}
				echo '<br /><div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
				echo form_close();
				echo '<br /><br />';
				echo '<table><tr><td><a href="'.base_url().'index.php/procesos/capacitacion/evaluar/'.$id_evaluacion.'/'.$id_usuario.'" onmouseover="tip(\'Regresa al listado<br />de puestos\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a	 href="'.base_url().'index.php/procesos/capacitacion/evaluar/'.$id_evaluacion.'/'.$id_usuario.'" onmouseover="tip(\'Regresa al listado<br />de puestos\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
            	?>
            </div>
		</div>
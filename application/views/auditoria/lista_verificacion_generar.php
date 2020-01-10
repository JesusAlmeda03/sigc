<?php
/****************************************************************************************************
*
*	VIEWS/inicio/lista_verificacion.php
*
*		Descripción:
*			Vista de la lista de verificación de la auditoría
*
*		Fecha de Creación:
*			31/Octubre/2011
*
*		Ultima actualización:
*			31/Octubre/2011
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
			<div class="titulo"><?=$titulo_pagina?></div>
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
	            );
			
				if( !$elige_proceso ) {
					echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Elige el proceso para el cual vas a generar la lista de verificación.</td></tr></table><br />';
					echo form_open('',array('name' => 'formulario_elige_proceso', 'id' => 'formulario_elige_proceso'));
					echo '<table class="tabla_form">';
					echo '	<tr>';
					echo '		<th>Elige el Proceso:</th>';
					echo '		<td>'.form_dropdown('procesos', $procesos, '', 'id="procesos" onfocus="hover(\'procesos\')" style="width:100%"').'</td>';
					echo '	</tr>';
					echo '</table><br />';
					echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
					echo form_close();
					echo '<br /><br />';
					echo '<table><tr><td><a href="'.base_url().'index.php/auditoria" onmouseover="tip(\'Regresa al listado<br />de actividades del auditor\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/auditoria" onmouseover="tip(\'Regresa al listado<br />de actividades del auditor\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
				}
				else {
					$proceso_hidden = array( 'proceso_hidden' => $id_proceso );
					echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Genera la Lista de Verificaci&oacute;n eligiendo de la lista los puntos que deseas considerar en la Auditor&iacute;a que realizaras.</td></tr></table><br />';
					
					// Lista de Verificación por default
					if( $lista->num_rows() > 0 ) {
						echo form_open('',array('name' => 'formulario', 'id' => 'formulario'), $proceso_hidden );
						echo '<table class="tabla_form" width="700">';
						echo '<tr><th colspan="5" style="text-align:center; font-size:18px">'.$proceso.'</th></tr>';
						echo '<tr><th></th><th>Punto</th><th>Requisito ISO 9001:2008</th><th>Cuestionamiento y/o Evidencia Solicitada</th><th>Que Buscar</th></tr>';
						$i = 0;
						foreach( $lista->result() as $row ) {
							if( $i ) {
								echo '<tr>';
								$i = 0;
							}
							else {
								echo '<tr class="odd">';
								$i = 1;
							}
							echo '<th width="15"><input type="checkbox" id="lista" name="lista[]" value="'.$row->IdListaVerificacion.'" /></th>';
							echo '<td>'.$row->Punto.'</td>';
							echo '<td>'.$row->Requisito.'</td>';
							
							echo '<td>'.$row->Pregunta.'</td>';
							echo '<td>'.$row->Que.'</td>';
							echo '</tr>';
						}
						echo '</table><br />';
						echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
	            		echo form_close();
					}
					else {
						echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay lista de verificaci&oacute;n para elegir.</td></tr></table>';
					}
	
					echo '<br /><br />';
					if( $agregar ) {
						echo '<table><tr><td><a href="'.base_url().'index.php/auditoria/lista_verificacion/revisar" onmouseover="tip(\'Regresa a la Lista de Verificaci&oacute;n\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/auditoria/lista_verificacion/revisar" onmouseover="tip(\'Regresa a la Lista de Verificaci&oacute;n\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
					}
					else {
						echo '<table><tr><td><a href="'.base_url().'index.php/auditoria/lista_verificacion/generar" onmouseover="tip(\'Regresa a elegir el proceso\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/auditoria/lista_verificacion/generar" onmouseover="tip(\'Regresa a elegir el proceso\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
					}
				}
				?>
			</div>
		</div>
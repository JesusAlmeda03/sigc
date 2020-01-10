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
					echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Elige el proceso para revisar la lista de verificación.</td></tr></table><br />';
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
					echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/agregar.png" width="20" /></th><td><a href="'.base_url().'index.php/auditoria/lista_verificacion/agregar">Agregar mas Preguntas</a></td></tr></table><br />';
					echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/doc.png" width="20" /></th><td><a target="_blank" href="'.base_url().'index.php/auditoria/lista_verificacion/documento/'.$id_proceso.'">Documento de la Lista de Verificaci&oacute;n para imprimir</a></td></tr></table><br />';
					
					// Lista de Verificación por default
					if( $lista->num_rows() > 0 ) {
						echo '<table class="tabla_form" width="700">';
						echo '<tr><th colspan="3" style="text-align:center; font-size:18px">'.$proceso.'</th></tr>';
						echo '<tr><th>Requisito ISO 9001:2008</th>';
						echo '<th>Cuestionamiento y/o Evidencia Solicitada</th><th></th></tr>';
						foreach( $lista->result() as $row ) {
							echo '<tr>';
							echo '<td>'.$row->Requisito.'</td>';
							echo '<td>'.$row->Pregunta.'</td>';
							echo '<td width="20"><a onclick="pregunta_cambiar( \'lista_verificacion\', \''.$id_auditoria.'-'.$row->IdListaVerificacionUsuario.'\', 0, \'&iquest;Deseas eliminar este punto de tu Lista de Verificaci&oacute;n?\',\'auditoria-lista_verificacion-revisar\')" onmouseover="tip(\'Quitar este punto<br />de la Lista de Verificaci&oacute;n\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';
							echo '</tr>';
						}
						echo '</table><br />';
					}
					else {
						echo '<table class="tabla_form" width="700">';
						echo '<tr><th colspan="3" style="text-align:center; font-size:18px">'.$proceso.'</th></tr>';
						echo '</table>';
						echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay lista de verificaci&oacute;n para elegir.</td></tr></table>';
					}
					echo '<br /><br />';
					echo '<table><tr><td><a href="'.base_url().'index.php/auditoria/lista_verificacion/revisar" onmouseover="tip(\'Regresa a elegir el proceso\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/auditoria/lista_verificacion/revisar" onmouseover="tip(\'Regresa a elegir el proceso\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
				}
				?>
			</div>
		</div>
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
            	<script>alert('Antes de Registrar sus respuestas, por favor verifique que a seleccionado todas las preguntas de su lista de verificacion');</script>
            	<script>
            	// envia automaticamente el formulario despues de 10 minutos
				//setInterval(function(){ document.formulario.submit(); },900000);
				setInterval(function(){ document.getElementById( 'formulario' ).submit(); },900000);
            	</script>
				<?php
				$formulario = array(
	                // * Boton submit
	                'boton' => array (
	                    'id'		=> 'aceptar',
	                    'name'		=> 'aceptar',
	                    'class'		=> 'in_button',
		                    'onfocus'	=> 'hover(\'aceptar\')'
	                ),
	                // Tipo
					'tipo' => array (
						'conforme' => array (
							'name'		=> 'tipo',
							'id'		=> 'conforme',
							'value'		=> 'Conforme',
							'class'		=> 'in_radio',
						),
						'no_conforme' => array (
							'name'		=> 'tipo',
							'id'		=> 'no_conforme',
							'value'		=> 'No Conforme',
							'class'		=> 'in_radio',
							'style'		=> 'margin-bottom:10px'
						),
						'mejora' => array (
							'name'		=> 'tipo',
							'id'		=> 'mejora',
							'value'		=> 'Oportunidad de Mejora',
							'class'		=> 'in_radio',
							'style'		=> 'margin-bottom:10px'
						),
					),
	            );

				if( !$elige_proceso ) {
					echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Elige el proceso del cual vas a guradar las respuestas.</td></tr></table><br />';
					echo form_open('',array('name' => 'formulario_elige_proceso', 'id' => 'formulario_elige_proceso'));
					echo '<table class="tabla_form">';
					echo '	<tr>';
					echo '		<th>Elige el Proceso:</th>';
					echo '		<td>'.form_dropdown('procesos', $procesos, '', 'id="procesos" onfocus="hover(\'procesos\')" style="width:100%"').'</td>';
					echo '	</tr>';
					echo '</table><br />';
					echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
					echo form_close();
				}
				else {
					$proceso_hidden = array( 'proceso_hidden' => $id_proceso );
					echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Guarda las respuestas del proceso:<br /><span style="font-weight:bold; font-size:18px">'.$proceso.'</span></td></tr></table><br />';
					// Lista de Verificación por default
					if( $lista->num_rows() > 0 ) {
						echo form_open('',array('name' => 'formulario', 'id' => 'formulario'), $proceso_hidden );
						foreach( $lista->result() as $row ) {
							//if( $row->IdProceso == $id_proceso || $row->IdProceso == '') {
							if( $respuestas->num_rows() > 0) {
								$show = false;
								foreach( $respuestas->result() as $row_res ) {
									if( $this->session->userdata( 'id_area') != 9 ) {
										if( $row_res->IdProceso == $id_proceso && $row_res->IdListaVerificacionUsuario == $row->IdListaVerificacionUsuario ) {
											$show = true;
											echo '<table class="tabla_form" width="700">';
											echo '<tr><td style="background-color:#EAECEE; font-size:18px;">';
											echo '<span style="font-size:14px">'.$row->Requisito.'</span><br />';
											echo $row->Pregunta.'<br />';
											echo '<div style="font-size:12px">';
											$con = $n_c = $opm = '';
											switch( $row_res->Tipo ) {
												case 'Conforme' : $con = 'checked="checked" '; break;
												case 'No Conforme' : $n_c = 'checked="checked" '; break;
												case 'Oportunidad de Mejora' : $opm = 'checked="checked" '; break;
											}
											echo '<input id="mejora" '.$con.'class="in_radio" type="radio" style="margin-bottom:10px" value="Conforme" name="tipo_'.$row->IdListaVerificacionUsuario.'"> Conforme<br />';
											echo '<input id="mejora" '.$n_c.'class="in_radio" type="radio" style="marin-bottom:10px" value="No Conforme" name="tipo_'.$row->IdListaVerificacionUsuario.'"> No Conforme<br />';
											echo '<input id="mejora" '.$opm.'class="in_radio" type="radio" style="margin-bottom:10px" value="Oportunidad de Mejora" name="tipo_'.$row->IdListaVerificacionUsuario.'"> Oportunidad de Mejora<br />';						
											echo '<div>';
											echo '</td></tr>';
											echo '<tr><td><textarea name="respuesta_'.$row->IdListaVerificacionUsuario.'" id="respuesta_'.$row->IdListaVerificacionUsuario.'">'.$row_res->Hallazgo.'</textarea></td></tr>';
											echo '</table><br />';
										}
									}
									else {
										if( $row_res->IdBiblioteca == $id_proceso && $row_res->IdListaVerificacionUsuario == $row->IdListaVerificacionUsuario ) {
											$show = true;
											echo '<table class="tabla_form" width="700">';
											echo '<tr><td style="background-color:#EAECEE; font-size:18px;">';
											echo '<span style="font-size:14px">'.$row->Requisito.'</span><br />';
											echo $row->Pregunta.'<br />';
											echo '<div style="font-size:12px">';
											$con = $n_c = $opm = '';
											switch( $row_res->Tipo ) {
												case 'Conforme' : $con = 'checked="checked" '; break;
												case 'No Conforme' : $n_c = 'checked="checked" '; break;
												case 'Oportunidad de Mejora' : $opm = 'checked="checked" '; break;
											}
											echo '<input id="mejora" '.$con.'class="in_radio" type="radio" style="margin-bottom:10px" value="Conforme" name="tipo_'.$row->IdListaVerificacionUsuario.'"> Conforme<br />';
											echo '<input id="mejora" '.$n_c.'class="in_radio" type="radio" style="marin-bottom:10px" value="No Conforme" name="tipo_'.$row->IdListaVerificacionUsuario.'"> No Conforme<br />';
											echo '<input id="mejora" '.$opm.'class="in_radio" type="radio" style="margin-bottom:10px" value="Oportunidad de Mejora" name="tipo_'.$row->IdListaVerificacionUsuario.'"> Oportunidad de Mejora<br />';						
											echo '<div>';
											echo '</td></tr>';
											echo '<tr><td><textarea name="respuesta_'.$row->IdListaVerificacionUsuario.'" id="respuesta_'.$row->IdListaVerificacionUsuario.'">'.$row_res->Hallazgo.'</textarea></td></tr>';
											echo '</table><br />';
										}
									}
								}
								/*if( !$show ) {
									echo '<table class="tabla_form" width="700">';
									echo '<tr><td style="background-color:#EAECEE; font-size:18px;">';
									echo '<span style="font-size:14px">'.$row->Requisito.'</span><br />';
									echo $row->Pregunta.'<br />';
									echo '<div style="font-size:12px">';
									echo '<input id="mejora" class="in_radio" type="radio" style="margin-bottom:10px" value="Conforme" name="tipo_'.$row->IdListaVerificacionUsuario.'"> Conforme<br />';
									echo '<input id="mejora" class="in_radio" type="radio" style="marin-bottom:10px" value="No Conforme" name="tipo_'.$row->IdListaVerificacionUsuario.'"> No Conforme<br />';
									echo '<input id="mejora" class="in_radio" type="radio" style="margin-bottom:10px" value="Oportunidad de Mejora" name="tipo_'.$row->IdListaVerificacionUsuario.'"> Oportunidad de Mejora<br />';						
									echo '<div>';
									echo '</td></tr>';
									echo '<tr><td><textarea name="respuesta_'.$row->IdListaVerificacionUsuario.'" id="respuesta_'.$row->IdListaVerificacionUsuario.'"></textarea></td></tr>';
									echo '</table><br />';
								}*/
							}
							else {
								echo '<table class="tabla_form" width="700">';
								echo '<tr><td style="background-color:#EAECEE; font-size:18px;">';
								echo '<span style="font-size:14px">'.$row->Requisito.'</span><br />';
								echo $row->Pregunta.'<br />';
								echo '<div style="font-size:12px">';
								echo '<input id="mejora" class="in_radio" type="radio" style="margin-bottom:10px" value="Conforme" name="tipo_'.$row->IdListaVerificacionUsuario.'"> Conforme<br />';
								echo '<input id="mejora" class="in_radio" type="radio" style="marin-bottom:10px" value="No Conforme" name="tipo_'.$row->IdListaVerificacionUsuario.'"> No Conforme<br />';
								echo '<input id="mejora" class="in_radio" type="radio" style="margin-bottom:10px" value="Oportunidad de Mejora" name="tipo_'.$row->IdListaVerificacionUsuario.'"> Oportunidad de Mejora<br />';						
								echo '<div>';
								echo '</td></tr>';
								echo '<tr><td><textarea name="respuesta_'.$row->IdListaVerificacionUsuario.'" id="respuesta_'.$row->IdListaVerificacionUsuario.'"></textarea></td></tr>';
								echo '</table><br />';
							}
						}
						echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Guardar').'</div>';
	            		echo form_close();
					}
					else {
						echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay lista de verificaci&oacute;n para elegir.</td></tr></table>';
					}
				}
				?>
				<br /><br />
				<table><tr><td><a href="<?=base_url()?>index.php/auditoria" onmouseover="tip('Regresa al listado<br />de actividades del auditor')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/auditoria" onmouseover="tip('Regresa al listado<br />de actividades del auditor')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
			</div>
		</div>
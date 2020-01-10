<?php
/****************************************************************************************************
*
*	VIEWS/inicio/hallazgos.php
*
*		Descripción:
*			Vista para guardar los hallazgos de una auditoría
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
				
				echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table class="tabla_form">';
				echo '	<tr>';
				echo '		<th width="150">Elige el Proceso:</th>';
				echo '		<td>'.form_dropdown('procesos', $procesos, $proceso, 'id="procesos" onfocus="hover(\'procesos\')" style="width:100%" onchange="form.submit()"').'</td>';				
				echo '	</tr>';
				echo '	<tr>';
				echo '		<th>Documento de los hallazgos:</th>';
				echo ' 		<td><a onmouseover="tip(\'Generar reporte de hallazgos de la auditoría\')" onmouseout="cierra_tip()" href="'.base_url().'index.php/auditoria/comprobante/'.$proceso.'" target="_blank"><img src="'.base_url().'includes/img/icons/big/pdf.png" width="60" /></a></td>';
				echo '	</tr>';
				echo '</table><br />';
				echo form_close();
				
				echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Se muestran solo los hallazgos con estatus de <span style="font-weight:bold">No Conformidad</span> u <span style="font-weight:bold">Oportunidad de Mejora</span>.</td></tr></table><br />';
				
				if( $lista_verificacion->num_rows() > 0 ) {
					$i = $j = 0;
					$tipo = '';
					echo '<table class="tabla_form" width="700" style="margin-bottom:5px">';
					foreach( $lista_verificacion->result() as $row ) {
						if( $row->Hallazgo != '' && $row->Tipo != 'Conforme' ) {
							$j++;
							if( $proceso == 'todos' ) {
								$col = 5;
							}
							else {
								$col = 4;
							}
							if( $tipo == $row->Tipo) {
								echo '<tr><td width="20" style="background-color:#EAECEE;" class="titulo_tabla">'.$j.'.</td>';
								if( $proceso == 'todos' ) {
									echo '<td>'.$row->Proceso.'</td>';
								}
								echo '<td>'.$row->Requisito.'</td><td>'.$row->Hallazgo.'</td>';
								echo '<td width="20">';
								if ( $row->Tipo == 'No Conforme' ) {
									$conformidad = true;
									
									if( $conformidades->num_rows() > 0 ) {
										foreach( $conformidades->result() as $row_con ) {
											if( $row_con->IdHallazgo == $row->IdRespuestaLista ) {
												$conformidad = false;
												break;
											}
										}
									}
									
									if( $conformidad ) {
										echo '<a href="'.base_url().'index.php/procesos/conformidades/auditoria/'.$row->IdRespuestaLista.'" onmouseover="tip(\'Levantar No Conformidad<br />en base a este Hallazgo\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/seguimiento.png" /></a>';
									}
									else {
										echo '<a href="'.base_url().'index.php/procesos/conformidades/seguimiento_usuario/'.$row->IdRespuestaLista.'" onmouseover="tip(\'No Conformidad ya levantada\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/terminada.png" /></a>';
									}
								}
								echo '</td>';
								echo '</tr>';
							}
							else {
								if( $tipo != '' ) {
									echo '</table>';
								}
								$tipo = $row->Tipo;
								echo '<table class="tabla_form" width="700" style="margin-bottom:5px">';
								echo '<tr><th colspan="'.$col.'">';
								if( $row->Tipo == '0' )
									echo "No se especificó el tipo de hallazgo";
								else
									echo $row->Tipo;
								echo '</th></tr>';
								echo '<tr><td width="20" style="background-color:#EAECEE;" class="titulo_tabla">'.$j.'.</td>';
								if( $proceso == 'todos' ) {
									echo '<td>'.$row->Proceso.'</td>';
								}
								echo '<td>'.$row->Requisito.'</td><td>'.$row->Hallazgo.'</td>';
								echo '<td width="20">';
								if ( $row->Tipo == 'No Conforme' ) {
									$conformidad = true;
									
									if( $conformidades->num_rows() > 0 ) {
										foreach( $conformidades->result() as $row_con ) {
											if( $row_con->IdHallazgo == $row->IdRespuestaLista ) {
												$conformidad = false;
												break;
											}
										}
									}
									
									if( $conformidad ) {
										echo '<a href="'.base_url().'index.php/procesos/conformidades/auditoria/'.$row->IdRespuestaLista.'" onmouseover="tip(\'Levantar No Conformidad<br />en base a este Hallazgo\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/seguimiento.png" /></a>';
									}
									else {
										echo '<a href="'.base_url().'index.php/procesos/conformidades/seguimiento_usuario/'.$row->IdRespuestaLista.'" onmouseover="tip(\'No Conformidad ya levantada\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/terminada.png" /></a>';
									}
								}
								echo '</td>';
								echo '</tr>';
							}
						}
					}
					echo '</table>';
				}
				else {
					echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay hallazgos de tu auditor&iacute;a.</td></tr></table>';
				}
				?>
				<br /><br />
				<table><tr><td><a href="<?=base_url()?>index.php/auditoria" onmouseover="tip('Regresa al listado<br />de actividades del auditor')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/auditoria" onmouseover="tip('Regresa al listado<br />de actividades del auditor')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
			</div>
		</div>
<?
/****************************************************************************************************
*
*	VIEWS/inicio/especifico.php
*
*		Descripción:
*			Vista del programa específico de auditoría
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
				// Datos de la Auditoría
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th width="200" class="titulo_tabla" style="text-align:center; font-size:28px">Alcance de la Auditor&iacute;a</th>';
				echo '<td>'.$alcance.'</td></tr>';
				echo '<tr><th class="titulo_tabla" style="text-align:center; font-size:28px">Objetivo de la Auditor&iacute;a</th>';
				echo '<td>'.$objetivo.'</td></tr>';
				echo '<tr><th class="titulo_tabla" style="text-align:center; font-size:28px">Auditor Lider</th>';
				echo '<td>'.$lider.'</td></tr>';
				echo '</table><br />';
				
				// Programa Específico de Auditoría
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th colspan="2" class="titulo_tabla" style="text-align:center; font-size:28px">Programaci&oacute;n</th></tr>';
				echo '</table>';
				// procesos
				$tabla = '';
				if( $procesos->num_rows() > 0 ) {
					foreach( $procesos->result() as $row_pro ) {
						$tabla .= '<tr><td style="background-color:#EAECEE; border:1px solid #CCC">'.$row_pro->Proceso;
						// equipos
						$tabla_header = '';
						if( $equipos->num_rows() > 0 ) {
							foreach( $equipos->result() as $row_equ ) {
								$renglon = '';
								$tabla_header .= '<td style="background-color:#EAECEE; text-align:center; font-weight:bold; border:1px solid #CCC">'.$row_equ->Nombre.'</td>';
								// relacion equipos - procesos
								if( $equipos_procesos->num_rows() > 0 ) {
									foreach( $equipos_procesos->result() as $row_eqp ) {
										if( $row_eqp->IdProceso == $row_pro->IdProceso && $row_eqp->IdEquipo == $row_equ->IdEquipo ) {
											$renglon = '<td style="border:1px solid #CCC">'.$row_eqp->Fecha.'<br />'.$row_eqp->Hora.'</td>';
										}
									}
								}
								if( $renglon != '' ) {
									$tabla .= $renglon;
								}
								else {
									$tabla .= '<td style="border:1px solid #CCC"></td>';
								}
							}
						}
						$tabla .= '</td></tr>';
					}
				}
				echo '<table class="tabla_form" width="700"><tr><td style="background-color:#EAECEE; text-align:center; font-weight:bold; border:1px solid #CCC">Procesos</td>'.$tabla_header.'</tr>'.$tabla.'</table><br />';
				
				// Procesos
				if( $procesos->num_rows() > 0 ) {
					echo '<table class="tabla_form" width="700">';
					echo '<tr><th colspan="2" class="titulo_tabla" style="text-align:center; font-size:28px">Procesos a Auditar</th></tr>';
					echo '<tr><td style="background-color:#EAECEE; text-align:center; font-weight:bold">Procesos</td><td style="background-color:#EAECEE; text-align:center; font-weight:bold">&Aacute;rea</td></tr>';
					foreach( $procesos->result() as $row ) {
						echo '<tr>';
						echo '<td>'.$row->Proceso.'</td>';
						echo '<td>';
						if( $procesos_documentos->num_rows() > 0 ) {
							foreach( $procesos_documentos->result() as $row_docs ) {
								if( $row->IdProceso == $row_docs->IdProceso ) {
									echo $row_docs->Area.'<br />';
								}
							}
						}
						echo '</td>';
						echo '</tr>';
					}
					echo '</table><br />';
				}
				else {
					echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>No se han definido procesos a auditar para esta auditor&iacute;a!</td></tr></table>';
				}
	
				// Equipos
				if( $auditores->num_rows() > 0 ) {
					$id_equipo = '';
					echo '<table class="tabla_form" width="700">';
					echo '<tr><th colspan="2" class="titulo_tabla" style="text-align:center; font-size:28px">Equipos de Auditores</th></tr>';
					echo '</table>';
					echo '<table class="tabla_form" width="700" style="margin-bottom:5px">';
					foreach( $auditores->result() as $row ) {
						if( $id_equipo == $row->IdEquipo) {
							echo '<tr><td width="180" style="background-color:#EAECEE;">'.$row->Tipo.'</td><td>';
							if( $row->IdUsuario == $this->session->userdata('id_usuario') ) {
								echo '<img src="'.base_url().'includes/img/icons/star_full.png" /> ';
							}
							echo $row->Nombre.' '.$row->Paterno.' '.$row->Materno.' ('.$row->Area.')</td>';
						}
						else {
							if( $id_equipo != '' ) {
								echo '</table>';
							}
							$id_equipo = $row->IdEquipo;
							echo '<table class="tabla_form" width="700" style="margin-bottom:5px">';
							echo '<tr><td colspan="2" style="background-color:#EAECEE; font-weight:bold">'.$row->Equipo.'</th></tr>';
							echo '<tr><td width="180" style="background-color:#EAECEE;">'.$row->Tipo.'</td><td>';
							if( $row->IdUsuario == $this->session->userdata('id_usuario') ) {
								echo '<img src="'.base_url().'includes/img/icons/star_full.png" /> ';
							}
							echo $row->Nombre.' '.$row->Paterno.' '.$row->Materno.' ('.$row->Area.')</td>';
						}
					}
					echo '</table>';
				}
				else {
					echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>No se han definido equipos de auditores para esta auditor&iacute;a!</td></tr></table>';
				}
				?>
				<br /><br />
				<table><tr><td><a href="<?=base_url()?>index.php/auditoria" onmouseover="tip('Regresa al listado<br />de actividades del auditor')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/auditoria" onmouseover="tip('Regresa al listado<br />de actividades del auditor')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
			</div>
		</div>
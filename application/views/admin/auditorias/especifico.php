<?php
/****************************************************************************************************
*
*	VIEWS/admin/aduditorias/especifico.php
*
*		Descripción:
*			Vista del programa específico de auditoría
*
*		Fecha de Creación:
*			30/Octubre/2012
*
*		Ultima actualizaciÓn:
*			30/Octubre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
?>          
    <div class="cont_admin">
    	<div class="titulo"><?=$titulo?></div>
        <div class="texto">
        	<?php
        	// Modificar los datos
        	if( $estado_auditoria == 'modificar' ) {
        		// Formulario de campos faltantes de la auditoria específica
	        	$formulario = array(
	                // * Boton submit
	                'boton_modificar' => array (
	                    'id'		=> 'modificar',
	                    'name'		=> 'modificar',
	                    'class'		=> 'in_button',
	                    'onfocus'	=> 'hover(\'modificar\')'
	                ),
	                // Alcance
	                'alcance' => array (
	                    'name'		=> 'alcance',
	                    'id'		=> 'alcance',
	                    'value'		=> $alcance,
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('alcance')",
	                ),
	                // Objetivo
	                'objetivo' => array (
	                    'name'		=> 'objetivo',
	                    'id'		=> 'objetivo',
	                    'value'		=> $objetivo,
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('objetivo')",
	                ),
	                // Lider
	                'lider' => array (
	                    'name'		=> 'lider',
	                    'id'		=> 'lider',
	                    'value'		=> $lider,
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('lider')",
	                ),
	            );
					        	
	        	echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table class="tabla_form" width="980">';
				echo '<tr><th width="150" valign="top">Alcance de la Auditor&iacute;a:</th><td>'.form_textarea($formulario['alcance']).'</td></tr>';
				echo '<tr><th valign="top">Objetivo de la Auditor&iacute;a:</th><td>'.form_textarea($formulario['objetivo']).'</td></tr>';
				echo '<tr><th valign="top">Auditor Lider:</th><td>'.form_input($formulario['lider']).'</td></tr>';
				echo '</table>';
	        	echo '<br />';
	        	echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton_modificar'],'Modificar').'</div>';
	        	echo form_close().'<br /><br />';
			}
			// Muestra / Agrega los datos
			else {
	        	// Formulario de campos faltantes de la auditoria específica
	        	$formulario = array(
	                // * Boton submit
	                'boton' => array (
	                    'id'		=> 'aceptar',
	                    'name'		=> 'aceptar',
	                    'class'		=> 'in_button',
	                    'onfocus'	=> 'hover(\'aceptar\')'
	                ),
	                // Alcance
	                'alcance' => array (
	                    'name'		=> 'alcance',
	                    'id'		=> 'alcance',
	                    'value'		=> set_value('alcance'),
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('alcance')",
	                ),
	                // Objetivo
	                'objetivo' => array (
	                    'name'		=> 'objetivo',
	                    'id'		=> 'objetivo',
	                    'value'		=> set_value('objetivo'),
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('objetivo')",
	                ),
	                // Lider
	                'lider' => array (
	                    'name'		=> 'lider',
	                    'id'		=> 'lider',
	                    'value'		=> 'Coordinador de Calidad',
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('lider')",
	                ),
	            );
				
				// Auditoría activa
	        	if( $estado_auditoria == 'pendiente' ) {
		        	echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
					echo '<table class="tabla_form" width="980">';
					echo '<tr><th width="150" valign="top">Alcance de la Auditor&iacute;a:</th><td>'.form_textarea($formulario['alcance']).'</td></tr>';
					echo '<tr><th valign="top">Objetivo de la Auditor&iacute;a:</th><td>'.form_textarea($formulario['objetivo']).'</td></tr>';
					echo '<tr><th valign="top">Auditor Lider:</th><td>'.form_input($formulario['lider']).'</td></tr>';
					echo '</table>';
		        	echo '<br />';
		        	echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
		        	echo form_close().'<br /><br />';
				}
				elseif( $estado_auditoria == 'activar' ) { 
		        	echo '<table class="tabla_form" width="980" onclick="pregunta_cambiar( \'auditorias\', \''.$id_auditoria.'\', 1, \'&iquest;Deseas activar esta Auditor&iacute;a?\', \'auditorias-especifico-'.$id_auditoria.'-'.$ano.'-'.$auditoria.'-'.$estado.'\')">';
					echo '<tr><td style="text-align:center; font-size:18px; padding:10px"><a href="#"><img src="'.base_url().'includes/img/icons/activar_big.png" /></a><br /><a href="#" style="color:#333">Activar esta Auditor&iacute;a</a></td></tr>';
					echo '</table><br />';
					// datos de la auditoría
					echo '<table class="tabla_form" width="980" style="position:relative">';
					echo '<tr><th width="200" class="titulo_tabla" style="text-align:center; font-size:28px">Alcance de la Auditor&iacute;a</th>';
					echo '<td>'.$alcance.'<a style="position:absolute; top:10px; left:940px" href="'.base_url().'index.php/admin/auditorias/especifico/'.$id_auditoria.'/'.$ano.'/'.$auditoria.'/'.$estado.'/modificar" onmouseover="tip(\'Modificar los datos de<br />esta Auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" width="30" /></a></td></tr>';
					echo '<tr><th class="titulo_tabla" style="text-align:center; font-size:28px">Objetivo de la Auditor&iacute;a</th>';
					echo '<td>'.$objetivo.'</td></tr>';
					echo '<tr><th class="titulo_tabla" style="text-align:center; font-size:28px">Auditor Lider</th>';
					echo '<td>'.$lider.'</td></tr>';
					echo '</table><br />';
				}
				elseif( $estado_auditoria == 'completa' ) {
					// datos de la auditoría
					echo '<table class="tabla_form" width="980" style="position:relative">';
					echo '<tr><th width="200" class="titulo_tabla" style="text-align:center; font-size:28px">Alcance de la Auditor&iacute;a</th>';
					echo '<td>'.$alcance.'<a style="position:absolute; top:10px; left:940px" href="'.base_url().'index.php/admin/auditorias/especifico/'.$id_auditoria.'/'.$ano.'/'.$auditoria.'/'.$estado.'/modificar" onmouseover="tip(\'Modificar los datos de<br />esta Auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" width="30" /></a></td></tr>';
					echo '<tr><th class="titulo_tabla" style="text-align:center; font-size:28px">Objetivo de la Auditor&iacute;a</th>';
					echo '<td>'.$objetivo.'</td></tr>';
					echo '<tr><th class="titulo_tabla" style="text-align:center; font-size:28px">Auditor Lider</th>';
					echo '<td>'.$lider.'</td></tr>';
					echo '</table><br />';
				}
			}
			
			// Programa Específico de Auditoría
			echo '<table class="tabla_form" width="980">';
			echo '<tr><th colspan="2" class="titulo_tabla" style="text-align:center; font-size:28px">Programaci&oacute;n</th><th width="20"><div style="width:24px; height:24px; background-color:#EEE; float:left; padding:2px;"><a href="'.base_url().'index.php/admin/auditorias/procesos_equipos/'.$id_auditoria.'/especifico" onmouseover="tip(\'Agregar asignaciones de<br />Procesos a Equipos\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/agregar.png" /></a></div></th></tr>';
			echo '</table>';
			// procesos
			$tabla = '';
			$tabla_header = '';
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
										$renglon = '<td style="border:1px solid #CCC">'.$row_eqp->Fecha.'<br />'.$row_eqp->Hora.'<br /><a onclick="pregunta_cambiar( \'proceso_equipo\', \''.$row_eqp->IdEquipo.'_'.$row_pro->IdProceso.'\', 0, \'&iquest;Deseas quitarle este proceso al equipo?\', \'auditorias-especifico-'.$id_auditoria.'-'.$ano.'-'.$auditoria.'-'.$estado.'\')" onmouseover="tip(\'Quitar este proceso al equipo\')" onmouseout="cierra_tip()" style="float:right"><img src="'.base_url().'includes/img/icons/eliminar.png" /><a></td>';
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
			echo '<table class="tabla_form" width="980"><tr><td style="background-color:#EAECEE; text-align:center; font-weight:bold; border:1px solid #CCC">Procesos</td>'.$tabla_header.'</tr>'.$tabla.'</table><br />';
			
			// Procesos
			if( $procesos->num_rows() > 0 ) {
				echo '<table class="tabla_form" width="980">';
				echo '<tr><th colspan="2" class="titulo_tabla" style="text-align:center; font-size:28px">Procesos a Auditar</th><th width="20"><div style="width:24px; height:24px; background-color:#EEE; float:left; padding:2px;"><a href="'.base_url().'index.php/admin/auditorias/procesos/'.$id_auditoria.'/especifico" onmouseover="tip(\'Agregar Procesos a<br />esta Auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/agregar.png" /></a></div></th></tr>';
				echo '<tr><td style="background-color:#EAECEE; text-align:center; font-weight:bold">Procesos</td><td style="background-color:#EAECEE; text-align:center; font-weight:bold">&Aacute;rea</td><td style="background-color:#EAECEE"></td></tr>';
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
					echo '<td width="20"><a onclick="pregunta_cambiar( \'proceso_auditoria\', \''.$id_auditoria.'_'.$row->IdProceso.'\', 0, \'&iquest;Deseas eliminar a este proceso de la auditor&iacute;a?\', \'auditorias-especifico-'.$id_auditoria.'-'.$ano.'-'.$auditoria.'-'.$estado.'\')" onmouseover="tip(\'Eliminar este proceso<br />de la Auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';
					echo '</tr>';
				}
				echo '</table><br />';
			}
			else {
				echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>No se han definido procesos a auditar para esta auditor&iacute;a!</td></tr></table>';
			}

			// Equipos
			if( $auditores->num_rows() > 0 ) {
				$id_equipo = '';
				echo '<table class="tabla_form" width="980">';
				echo '<tr><th colspan="2" class="titulo_tabla" style="text-align:center; font-size:28px">Equipos de Auditores</th><th width="20"><div style="width:24px; height:24px; background-color:#EEE; float:left; padding:2px;"><a href="'.base_url().'index.php/admin/auditorias/equipos/'.$id_auditoria.'/especifico" onmouseover="tip(\'Agregar Equipos a<br />esta Auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/agregar.png" /></a></div></th></tr>';
				echo '</table>';
				echo '<table class="tabla_form" width="980" style="margin-bottom:5px">';
				foreach( $auditores->result() as $row ) {
					if( $id_equipo == $row->IdEquipo) {
						echo '<tr><td width="180" style="background-color:#EAECEE;">'.$row->Tipo.'</td><td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.' ('.$row->Area.')</td>';
						echo '<td width="20" colspan="2" style="text-align:center"><a onclick="pregunta_cambiar( \'usuario_equipo\', \''.$row->IdEquipo.'_'.$row->IdUsuario.'\', 0, \'&iquest;Deseas eliminar a este usuario del equipo?\', \'auditorias-especifico-'.$id_auditoria.'-'.$ano.'-'.$auditoria.'-'.$estado.'\')" onmouseover="tip(\'Eliminar a este usuario<br />del Equipo\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td></tr>';
					}
					else {
						if( $id_equipo != '' ) {
							echo '</table>';
						}
						$id_equipo = $row->IdEquipo;
						echo '<table class="tabla_form" width="980" style="margin-bottom:5px">';
						echo '<tr><td colspan="2" style="background-color:#EAECEE; font-weight:bold">'.$row->Equipo.'</th>';
						echo '<td width="20" style="background-color:#EAECEE"><a href="'.base_url().'index.php/admin/auditorias/equipos/'.$id_auditoria.'/especifico/modificar/'.$row->IdEquipo.'" onmouseover="tip(\'Modificar el nombre del equipo o<br />agregar nuevos miembros\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
						echo '<td width="20" style="background-color:#EAECEE"><a onclick="pregunta_cambiar( \'equipo\', '.$row->IdEquipo.', 0, \'&iquest;Deseas eliminar a todo este equipo?\', \'auditorias-especifico-'.$id_auditoria.'-'.$ano.'-'.$auditoria.'-'.$estado.'\')" onmouseover="tip(\'Eliminar este equipo<br />de la Auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td></tr>';
						echo '<tr><td width="180" style="background-color:#EAECEE;">'.$row->Tipo.'</td><td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.' ('.$row->Area.')</td>';
						echo '<td width="20" colspan="2" style="text-align:center"><a onclick="pregunta_cambiar( \'usuario_equipo\', \''.$row->IdEquipo.'_'.$row->IdUsuario.'\', 0, \'&iquest;Deseas eliminar a este usuario del equipo?\', \'auditorias-especifico-'.$id_auditoria.'-'.$ano.'-'.$auditoria.'-'.$estado.'\')" onmouseover="tip(\'Eliminar a este usuario<br />del Equipo\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td></tr>';
					}
				}
				echo '</table>';
			}
			else {
				echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>No se han definido equipos de auditores para esta auditor&iacute;a!</td></tr></table>';
			}
            ?>
            <br /><br />
			<table><tr><td><a href="<?=base_url()?>index.php/admin/auditorias/programa_especifico/<?=$ano?>/<?=$auditoria?>/<?=$estado?>" onmouseover="tip('Regresa al Programa Anual de Auditor&iacute;as')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/admin/auditorias/programa_especifico/<?=$ano?>/<?=$auditoria?>/<?=$estado?>" onmouseover="tip('Regresa al Programa Anual de Auditor&iacute;as')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
        </div>
    </div>
<?php
/****************************************************************************************************
*
*	VIEWS/admin/aduditorias/especifico.php
*
*		Descripción:
*			Vista para la revision del estado de los procesos de la auditoria
*
*		Fecha de Creación:
*			27/Noviembre/2013
*
*		Ultima actualizaciÓn:
*			27/Noviembre/2013
*
*		Autor:
*			ISC Jesus Carlos Almeda Macias
*			iscalmeda@gmail.com
*			
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
		        	echo '<table class="tabla_form" width="980">';
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
					echo '<td>'.$alcance.'<a style="position:absolute; top:10px; left:940px" </td></tr>';
					echo '<tr><th class="titulo_tabla" style="text-align:center; font-size:28px">Objetivo de la Auditor&iacute;a</th>';
					echo '<td>'.$objetivo.'</td></tr>';
					echo '<tr><th class="titulo_tabla" style="text-align:center; font-size:28px">Auditor Lider</th>';
					echo '<td>'.$lider.'</td></tr>';
					echo '</table><br />';
				}
			}
			
			//Programa Específico de Auditoría
			echo '<table class="tabla_form" width="980">';
			echo '<tr><th colspan="2" class="titulo_tabla" style="text-align:center; font-size:28px">Procesos</th></tr>';
			echo '</table>';
			// procesos
			$tabla = '';
			$tabla_header = '';
			if( $consulta->num_rows() > 0 ) {
				echo '<table class="tabla_form" width="980">';
						echo '<tr><td style="background-color:#EAECEE; font-weight:bold">Proceso</td><td style="background-color:#EAECEE; font-weight:bold">Equipo</td><td style="background-color:#EAECEE; font-weight:bold; text-align: center;">Ver lista de Verificacion</td></tr>';
						
				foreach( $consulta->result() as $row_equipos ) {
					$proc=$row_equipos->IdProceso;
						echo '<tr>';
						echo '<td width="70%">'.$row_equipos->Proceso.'</td>';
							echo '<td>'. $row_equipos->Nombre.'</td>';
							echo '<td style="font-weight:bold; text-align: center;">';
								echo '<a href="'.base_url().'index.php/admin/auditorias/listas_procesos/'.$id_auditoria.'/'.$proc.'/ver" onmouseover="tip(\'Ver Lista de Verificacion\')" onmouseout="cierra_tip()">';
								echo '<img src="'.base_url().'includes/img/icons/ver.png" width="15" />';
								echo '</a>';
							echo '</td>'; 
						echo '</tr>';
					
				}
				echo '</table>';
					
			}
			
			//No Conformidades
			echo '</br>';
			echo '<table class="tabla_form" width="980">';
			echo '<tr><th colspan="2" class="titulo_tabla" style="text-align:center; font-size:28px">No Conformidades de la Auditoria</th></tr>';
			echo '</table>';
			
			$tabla = '';
			$tabla_header = '';
			if( $consulta3->num_rows() > 0 ) {
				echo '<table class="tabla_form" width="980">';
				echo '<tr>
						<td style="background-color:#EAECEE; width: "15%"; font-weight:bold">Equipo</td>
						<td style="background-color:#EAECEE; width: "10%"; font-weight:bold">Tipo</td>
						<td style="background-color:#EAECEE; width: "20%"; font-weight:bold;">Departamento</td>
						<td style="background-color:#EAECEE; width: "20%"; font-weight:bold;">Area</td>
						<td style="vackground-color:#EAECEE; width: "15%"; font-weight:bold;">Ver</td>
					</tr>';
						
				foreach( $consulta3->result() as $row_equipos3 ) {
						$proceso=$row_equipos3->IdConformidad;
						echo '<tr>';
						echo '<td>'.$row_equipos3->Nombre.'</td>';
						echo '<td>'.$row_equipos3->Tipo.'</td>';
						echo '<td>'.$row_equipos3->Departamento.'</td>';
						echo '<td>'.$row_equipos3->Area.'</td>';
						echo '<td>';
							echo '<a href="'.base_url().'index.php/admin/auditorias/conformidades/'.$id_auditoria.'/'.$proceso.'/ver_conformidad" onmouseover="tip(\'Ver Lista de Verificacion\')" onmouseout="cierra_tip()">';
								echo '<img src="'.base_url().'includes/img/icons/ver.png" width="15" />';
							echo '</a>';
						echo '</td>'; 
						echo '</tr>';
					
				}
				echo '</table>';
					
			}
			// Equipos
			if( $auditores->num_rows() > 0 ) {
				$id_equipo = '';
				echo '<br>';
				echo '<table class="tabla_form" width="980">';
				echo '<tr><th colspan="2" class="titulo_tabla" style="text-align:center; font-size:28px">Equipos de Auditores</th><th width="20"></th></tr>';
				echo '</table>';
				echo '<table class="tabla_form" width="980" style="margin-bottom:5px">';
				foreach( $auditores->result() as $row ) {
					if( $id_equipo == $row->IdEquipo) {
						echo '<tr><td width="180" style="background-color:#EAECEE;">'.$row->Tipo.'</td><td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.' ('.$row->Area.')</td>';
						echo '<td width="20" colspan="2" style="text-align:center"></td></tr>';
						
						
					}
					else {
						if( $id_equipo != '' ) {
							
							echo '</table>';
						}
						$id_equipo = $row->IdEquipo;
						echo '<table class="tabla_form" width="980" style="margin-bottom:5px">';
						echo '<tr><td colspan="2" style="background-color:#EAECEE; font-weight:bold">'.$row->Equipo.'</th>';
						echo '<td width="20" style="background-color:#EAECEE"></td>';
						echo '<td width="20" style="background-color:#EAECEE"></td></tr>';
						echo '<tr><td width="180" style="background-color:#EAECEE;">'.$row->Tipo.'</td><td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.' ('.$row->Area.')</td>';
						echo '<td width="20" colspan="2" style="text-align:center"></td></tr>';
						
					}
					
				}
				echo '</table>';
			
					
			
			}
			else {
				echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>No se han definido equipos de auditores para esta auditor&iacute;a!</td></tr></table>';
			}
            ?>
            <br /><br />
			<table><tr><td><a href="<?=base_url()?>index.php/admin/auditorias/revisar_avances" onmouseover="tip('Regresa al Programa Anual de Auditor&iacute;as')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/admin/auditorias/revisar_avances/" onmouseover="tip('Regresa al Programa Anual de Auditor&iacute;as')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
        </div>
    </div>
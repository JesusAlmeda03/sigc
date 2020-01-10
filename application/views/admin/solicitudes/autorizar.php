<?php
/****************************************************************************************************
 *
 *	VIEWS/admin/solicitudes/autorizar.php
 *
 *		Descripción:
 *			Vista para autorizar las solicitudes
 *
 *		Fecha de Creación:
 *			26/Enero/2012
 *
 *		Ultima actualización:
 *			26/Enero/2012
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
			<script>
			function activa_box(i) {					
				if( document.getElementById('solicitud_' + i).checked ) {
					document.getElementById('solicitud_' + i).checked = true;
					document.getElementById('tit_solicitud_' + i).style.background = 'green';
				}
				else {
					document.getElementById('solicitud_' + i).checked = false;
					document.getElementById('tit_solicitud_' + i).style.background = '#CC0000';
				}
			}
			
			function activa_box_element(i) {								
				document.getElementById('solicitud_' + i).checked = true;
				document.getElementById('tit_solicitud_' + i).style.background = 'green';
			}
			</script>	
			<?php
			$area_extras = 'id="area" onfocus="hover(\'area\')"  style="width:350px;" onchange="form.submit()"';
			$tipo_extras = 'id="tipo" onfocus="hover(\'tipo\')"  style="width:150px;" onchange="form.submit()"';
			echo form_open();
			echo '
	        	<table class="tabla_form" width="980">
	            	<tr><th width="100">&Aacute;rea</th><td>'.form_dropdown('area',$area_options,$area,$area_extras).'</td></tr>
	            	<tr><th width="100">Tipo</th><td>'.form_dropdown('tipo',$tipo_options,$tipo,$tipo_extras ).'</td></tr>
	         	</table><br />
         	';
            echo form_close();
			$formulario = array(
			// Nombre
				'observaciones' => array('id' => 'observaciones', 'value' => set_value('observaciones'), 'class' => 'in_text', 'onfocus' => "hover('observaciones')", 'style' => 'width:250px', ),
			// * Boton submit
				'boton_aceptar' => array('id' => 'boton_aceptar', 'name' => 'boton_aceptar', 'class' => 'in_button', 'onfocus' => 'hover(\'boton_aceptar\')'),
			// * Boton submit
	                'boton_rechazar' => array (
	                    'id'		=> 'boton_rechazar',
	                    'name'		=> 'boton_rechazar',
	                    'class'		=> 'in_button',
	                    'onfocus'	=> 'hover(\'boton_rechazar\')',
						'style'		=> 'margin-left:10px',				
					),
			);		
			if ( sizeof($listado_solicitudes) > 0 ) {
				echo '<table class="tabla" width="980"><tr><th width="20"><img src="' . base_url() . 'includes/img/icons/small/info.png" /></th><td>Marca las solicitudes que vas a autorizar, si es <label style="font-style:italic">Alta</label> o <label style="font-style:italic">Modificaci&oacute;n</label> deberas agregar el archivo en <label style="font-style:italic">PDF</label></td></tr></table><br />';
				echo form_open_multipart('', array('name' => 'formulario', 'id' => 'formulario'));
				foreach ( $listado_solicitudes as $row ) {
					$solicitud = 'id="solicitud_' . $row['IdSolicitud'] . '" onclick="activa_box(' . $row['IdSolicitud'] . ')"';
					echo '<table class="tabla_form" id="tabla_solicitud_' . $row['IdSolicitud'] . '" width="980" style="margin-bottom:20px">';
					echo '<tr><th colspan="2" id="tit_solicitud_' . $row['IdSolicitud'] . '" style="font-weight:bold; font-size:14px; text-align:center">' . form_checkbox('solicitud[]', $row['IdSolicitud'], false, $solicitud) . ' <span class="titulo_tabla">Seleccionar</span></th></tr>';
					echo '<tr><th width="150">Solicitud:</th><td>' . $row['Solicitud'] . '<input type="text" style="display:none"  value="' . $row['Solicitud'] . '" name="tipo_solicitud_'.$row['IdSolicitud'].'" /></td></tr>';
					echo '<tr><th>&Aacute;rea:</th><td>' . $row['Area'] . '</td></tr>';
					echo '<tr><th>Secci&oacute;n:</th><td>' . $row['Seccion'];
					if( $row['Comun'] )
						echo ' (Uso Com&uacute;n)';
					echo '</td></tr>';
					echo '<tr><th>C&oacute;digo:</th><td>' . $row['Codigo'] . '</td></tr>';
					echo '<tr><th>Nombre:</th><td>' . $row['Nombre'] . '</td></tr>';
					echo '<tr><th>Fecha:</th><td>' . $row['Fecha'] . '</td></tr>';
					echo '<tr><th>Edici&oacute;n:</th><td>' . $row['Edicion'] . '</td></tr>';
					echo '<tr><th>Acciones:</th><td>';
					echo '<div style="width:15px; padding:5px; border:1px solid #EEE; margin-right:5px; float:left"><a href="' . base_url() . 'includes/docs/' . $row['Ruta'] . '" onMouseover="tip(\'Descargar documento\')"; onMouseout="cierra_tip()"><img src="' . base_url() . 'includes/img/icons/doc.png" width="24" /></a></div>';
					echo '<div style="width:15px; padding:5px; border:1px solid #EEE; margin-right:5px; float:left"><a class="iframe" href="' . base_url() . 'index.php/admin/solicitudes/ver_lista_distribucion/' . $row['IdSolicitud'] . '/'.$area.'/0/'.$tipo.'/autorizar" onMouseover="tip(\'Lista de distribuci&oacute;n\')"; onMouseout="cierra_tip()"><img src="' . base_url() . 'includes/img/icons/users.png" /></a></div>';
					echo '<div style="width:15px; padding:5px; border:1px solid #EEE; margin-right:5px; float:left"><a class="iframe" href="' . base_url() . 'index.php/admin/solicitudes/ver/' . $row['IdSolicitud'] . '/'.$area.'/0/'.$tipo.'/autorizar" onMouseover="tip(\'Ver solicitud\')"; onMouseout="cierra_tip()"><img src="' . base_url() . 'includes/img/icons/ver.png" /></a></div>';
					echo '<div style="width:15px; padding:5px; border:1px solid #EEE; margin-right:5px; float:left"><a class="iframe" href="' . base_url() . 'index.php/admin/solicitudes/modificar/' . $row['IdSolicitud'] . '/'.$area.'/0/'.$tipo.'/autorizar" onMouseover="tip(\'Modificar solicitud\')"; onMouseout="cierra_tip()"><img src="' . base_url() . 'includes/img/icons/modificar.png" /></a></div>';
					echo '<div style="width:15px; padding:5px; border:1px solid #EEE; margin-right:5px; float:left"><a onclick="pregunta_cambiar(\'solicitudes\','. $row['IdSolicitud'] . ',5,\'&iquest;Deseas eliminar esta solicitud?<br />Si lo haces se eliminara toda la informaci&oacute;n del seguimiento\',\'solicitudes-autorizar-'.$area.'-'.$tipo.'\')" onMouseover="tip(\'Eliminar solicitud\')"; onMouseout="cierra_tip()"><img src="' . base_url() . 'includes/img/icons/eliminar.png" /></a></div>';								
					echo '</td></tr>';
					echo '<tr><th>Observaciones de la Solicitud:</th><td><input onclick="activa_box_element(' . $row['IdSolicitud'] . ')" id="observaciones_'.$row['IdSolicitud'].'" onfocus="hover(\'observaciones_'.$row['IdSolicitud'].'\')" class="in_text" type="text" value="" name="observaciones_'.$row['IdSolicitud'].'"><input style="display:none" id="observaciones_old" type="text" value="'.$row['Observaciones'].'" name="observaciones_old_'.$row['IdSolicitud'].'"></td></tr>';				
					if ($row['Solicitud'] != "Baja") {
						echo '<tr><th>Subir Archivo:</th><td><input onclick="activa_box_element(' . $row['IdSolicitud'] . ')" type="file" name="archivo_' . $row['IdSolicitud'] . '" id="archivo_' . $row['IdSolicitud'] . '" onfocus="hover(\'archivo_' . $row['IdSolicitud'] . '\')" /></td></tr>';
					}
					echo '</table>';
				}
				echo '<br /><div style="width:980px; text-align:center;">'.form_submit($formulario['boton_aceptar'],'Autorizar').form_submit($formulario['boton_rechazar'],'Rechazar').'</div>';
				echo form_close();
			}
			else {
				if( $area == 'elige' ) {
                	echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Elige una opci&oacute;n para ver las solicitudes</td></tr></table>';
                }
				else {
					echo '<table class="tabla" width="980"><tr><th width="20"><img src="' . base_url() . 'includes/img/icons/small/info.png" /></th><td>Por el momento no hay solicitudes</td></tr></table>';
				}
			}
			?>
		</div>
	</div>
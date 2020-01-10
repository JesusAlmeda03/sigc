<?php
/****************************************************************************************************
*
*	VIEWS/admin/solicitudes/listado.php
*
*		Descripción:
*			Vista que muestra el listado de las solicitudes en el panel de administrador
*
*		Fecha de Creación:
*			17/Enero/2012
*
*		Ultima actualización:
*			17/Enero/2012
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
			$area_extras = 'id="area" onfocus="hover(\'area\')"  style="width:350px;" onchange="form.submit()"';
			$estado_extras = 'id="estado" onfocus="hover(\'estado\')"  style="width:350px;" onchange="form.submit()"';
			$tipo_extras = 'id="tipo" onfocus="hover(\'tipo\')"  style="width:150px;" onchange="form.submit()"';
			echo form_open();
			echo '
	        	<table class="tabla_form" width="980">
	            	<tr><th width="100">&Aacute;rea</th><td>'.form_dropdown('area',$area_options,$area,$area_extras).'</td></tr>
	            	<tr><th width="100">Estado</th><td>'.form_dropdown('estado',$estado_options,$estado,$estado_extras ).'</td></tr>
	            	<tr><th width="100">Tipo</th><td>'.form_dropdown('tipo',$tipo_options,$tipo,$tipo_extras ).'</td></tr>
	         	</table><br />
         	';
            echo form_close();
			
			if ($consulta -> num_rows() > 0) {
				echo '<table class="tabla" id="tabla" width="980">';
				echo '<thead><tr><th width="10" class="no_sort"></th><th width="10" class="no_sort"></th>';
				if ($area == "todos")
					echo '<th>&Aacute;rea</th>';
				echo '<th>C&oacute;digo</th><th>Edicion</th><th>Nombre</th><th>Fecha de la Solicitud</th><th class="no_sort" width="15"></th><th class="no_sort"  width="15"></th><th class="no_sort" width="15"></th><th class="no_sort" width="15"></th></tr></thead><tbody>';
				foreach ($consulta->result() as $row) :
					// tipo de solicitud
					switch( $row->Solicitud ) {
						case "Alta" :
							$img_tip = '<img src="'.base_url().'includes/img/icons/alta.png" onmouseover="tip(\'Solicitud de Alta\')" onmouseout="cierra_tip()" />';
							break;
							
						case "Baja" :
							$img_tip = '<img src="'.base_url().'includes/img/icons/baja.png" onmouseover="tip(\'Solicitud de Baja\')" onmouseout="cierra_tip()" />';
							break;
							
						case "Modificacion" :
							$img_tip = '<img src="'.base_url().'includes/img/icons/modificacion.png" onmouseover="tip(\'Solicitud de Modificaci&oacute;n\')" onmouseout="cierra_tip()" />';
							break;
					}
						
					// definen las acciones segun el estado de la solicitud				
					switch( $row->Estado ) {
						// pendientes
						case 0 :						
							$img_edo = '<img src="' . base_url() . 'includes/img/icons/pendiente.png" onmouseover="tip(\'Solicitud pendiente\')" onmouseout="cierra_tip()" />';
							$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\',' . $row -> IdSolicitud . ',5,\'&iquest;Deseas eliminar esta solicitud?\',\'solicitudes-listado-'.$area.'-'.$estado.'-'.$tipo.'\')" onMouseover="tip(\'Eliminar solicitud\')"; onMouseout="cierra_tip()"><img src="' . base_url() . 'includes/img/icons/eliminar.png" /></a>';
							break;
	
						// pendientes - aceptada por el solicitador	
						case 1 :						
							$img_edo = '<img src="' . base_url() . 'includes/img/icons/pendiente.png" onmouseover="tip(\'Solicitud aceptada por el Solicitador\')" onmouseout="cierra_tip()" />';
							$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\',' . $row -> IdSolicitud . ',5,\'&iquest;Deseas eliminar esta solicitud?\',\'solicitudes-listado-'.$area.'-'.$estado.'-'.$tipo.'\')" onMouseover="tip(\'Eliminar solicitud\')"; onMouseout="cierra_tip()"><img src="' . base_url() . 'includes/img/icons/eliminar.png" /></a>';
							break;
						
						// pendientes - aceptada por el autorizador	
						case 2 :						
							$img_edo = '<img src="' . base_url() . 'includes/img/icons/pendiente.png" onmouseover="tip(\'Solicitud aceptada por el Autorizador\')" onmouseout="cierra_tip()" />';
							$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\',' . $row -> IdSolicitud . ',5,\'&iquest;Deseas eliminar esta solicitud?\',\'solicitudes-listado-'.$area.'-'.$estado.'-'.$tipo.'\')" onMouseover="tip(\'Eliminar solicitud\')"; onMouseout="cierra_tip()"><img src="' . base_url() . 'includes/img/icons/eliminar.png" /></a>';
							break;
								
						// terminadas
						case 3 :
							$img_edo = '<img src="' . base_url() . 'includes/img/icons/terminada.png" onmouseover="tip(\'Solicitud aceptada por<br />Coordinaci&oacute;n de Calidad\')" onmouseout="cierra_tip()" />';
							$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\',' . $row -> IdSolicitud . ',5,\'&iquest;Deseas eliminar esta solicitud?<br />Si lo haces se eliminara toda la informaci&oacute;n del seguimiento\',\'solicitudes-listado-'.$area.'-'.$estado.'-'.$tipo.'\')" onMouseover="tip(\'Eliminar solicitud\')"; onMouseout="cierra_tip()"><img src="' . base_url() . 'includes/img/icons/eliminar.png" /></a>';
							break;
							
						// rechazada
						case 4 :
							$img_edo = '<img src="' . base_url() . 'includes/img/icons/eliminada.png" onmouseover="tip(\'Solicitud rechazada\')" onmouseout="cierra_tip()" />';
							$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\',' . $row -> IdSolicitud . ',5,\'&iquest;Deseas eliminar esta solicitud?<br />Si lo haces se eliminara toda la informaci&oacute;n del seguimiento\',\'solicitudes-listado-'.$area.'-'.$estado.'-'.$tipo.'\')" onMouseover="tip(\'Eliminar solicitud\')"; onMouseout="cierra_tip()"><img src="' . base_url() . 'includes/img/icons/eliminar.png" /></a>';
							break;
	
						// eliminadas
						case 5 :						
							$img_edo = '<img src="' . base_url() . 'includes/img/icons/eliminada.png" onmouseover="tip(\'Solicitud eliminada\')" onmouseout="cierra_tip()" />';
							$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\',' . $row -> IdSolicitud . ',0,\'&iquest;Deseas restaurar esta solicitud?\',\'solicitudes-listado-'.$area.'-'.$estado.'-'.$tipo.'\')" onMouseover="tip(\'Restaurar solicitud\')"; onMouseout="cierra_tip()"><img src="' . base_url() . 'includes/img/icons/activar.png" /></a>';
							break;
					}
					echo '<tr>';
					echo '<th>' . $img_edo . '</th>';
					echo '<th valign="top">'.$img_tip.'</th>';
					if ($area == "todos")
					echo '<td>' . $row -> Area . '</td>';
					echo '<td>' . $row -> Codigo . '</td>';
					echo '<td>' . $row -> Edicion. '</td>';
					echo '<td>' . $row -> Nombre . '</td>';
					echo '<td>' . $row -> Fecha . '</td>';
					echo '<td><a href="' . base_url() . 'index.php/admin/solicitudes/ver_lista_distribucion/' . $row -> IdSolicitud . '/'.$area.'/'.$estado.'/'.$tipo.'" onMouseover="tip(\'Ver lista de distribuci&oacute;n\')"; onMouseout="cierra_tip()"><img src="' . base_url() . 'includes/img/icons/users.png" /></a></td>';
					echo '<td><a href="' . base_url() . 'index.php/admin/solicitudes/ver/' . $row -> IdSolicitud . '/'.$area.'/'.$estado.'/'.$tipo.'" onMouseover="tip(\'Ver solicitud\')"; onMouseout="cierra_tip()"><img src="' . base_url() . 'includes/img/icons/ver.png" /></a></td>';
					echo '<td><a href="' . base_url() . 'index.php/admin/solicitudes/modificar/' . $row -> IdSolicitud.'/'.$area.'/'.$estado.'/'.$tipo.'" onMouseover="tip(\'Modificar solicitud\')"; onMouseout="cierra_tip()"><img src="' . base_url() . 'includes/img/icons/modificar.png" /></a></td>';
					echo '<td>' . $img_cam . '</td>';
					echo '</tr>';
				endforeach;
				echo '</tbody></table>';
				echo $sort_tabla;
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
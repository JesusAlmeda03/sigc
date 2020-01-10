<?php
/****************************************************************************************************
*
*	VIEWS/misc/listados/conformidades.php
*
*		Descripci�n:
*			Vista de los Listados generados por los procesos automatizados
*			iconset:icojoy
*
*		Fecha de Creaci�n:
*			20/Octubre/2011
*
*		Ultima actualizaci�n:
*			20/Octubre/2011
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
				$estado = array(
					'todos'			=> 'Todas',
					'sin-atender'	=> 'Sin Atender',
					'atendidas'		=> 'Atendida',
					'evidencias'	=> 'Evidencias Pendientes',
					'cerradas'		=> 'Cerrada',
				);
				if( $this->session->userdata('CON') )
					$estado['eliminadas'] = 'Eliminadas';
				$estado_extras = 'id="estado" onfocus="hover(\'estado\')" style="width:170px; margin:0 0 0 5px;" onchange="form.submit()"';
				
		// Selección de listado
				echo form_open();
				echo '
					<table class="tabla_form" width="700">
	                    <tr>
	                        <th class="text_form" width="50">Estado</th>
	                        <td>'.form_dropdown('estado', $estado, $edo, $estado_extras).'</td>
	                    </tr>
	             	</table><br />
	            ';
				echo form_close();
				
		// Tabla de resultados
				$usuario_levanto = false;
				if( $consulta->num_rows() > 0 ) {
					foreach( $consulta->result() as $row ) {
						if( $row->IdUsuario == $this->session->userdata('id_usuario') ) {
							$usuario_levanto = true;
							break;
						}
					}
				}
                if( $consulta->num_rows() > 0 ) {
					echo '<table class="tabla" id="tabla" width="700">';
					echo '<thead>
							<tr>
								<th width="15" class="no_sort"></th>
								<th>No</th>
								<th width="60">Fecha de la no conformidad</th>
								<th width="150">Departamento al que se dirige la no conformidad</th>
								<th>Origen</th>
								<th>Tipo</th>
								<th class="no_sort" width="15" style="border:0"></th>';
					if( $this->session->userdata('CON') && $row->Estado != 1) {
						echo '<th class="no_sort" width="15" style="border:0"></th>';
						echo '<th class="no_sort" width="15" style="border:0"></th>';
						echo '<th class="no_sort" width="15" style="border:0"></th>';
						
						
					}
					echo '</tr></thead><tbody>';
                    foreach( $consulta->result() as $row ) :
						// definen las acciones segun el estado de la no conformidad
						$permiso = $this->session->userdata('CON') ;
						switch( $row->Estado ) {
							// sin atender
							
							case 0 : 
								
									$img_edo = '<img src="'.base_url().'includes/img/icons/pendiente.png" onmouseover="tip(\'No conformidad pendiente\')" onmouseout="cierra_tip()" />';
									$acc_edo = '<a href="'.base_url().'index.php/procesos/conformidades/revisar/'.$row->IdConformidad.'/'.$edo.'" onmouseover="tip(\'Ver no conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a>';	

									$img_cam = '<a onclick="pregunta_cambiar( \'conformidades\', '.$row->IdConformidad.', 3, \'&iquest;Deseas eliminar esta no conformidad?\',\'listados-conformidades-'.$edo.'\')" onmouseover="tip(\'Eliminar no conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								
							break;								
							// atendidas
							case 1 :
								$img_edo = '<img src="'.base_url().'includes/img/icons/terminada.png" onmouseover="tip(\'No conformidad atendida\')" onmouseout="cierra_tip()" />';
								$acc_edo = '<a href="'.base_url().'index.php/procesos/conformidades/ver/'.$row->IdConformidad.'/'.$edo.'" onmouseover="tip(\'Ver no conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a>';
								$img_cam = '<a onclick="pregunta_cambiar( \'conformidades\', '.$row->IdConformidad.', 3, \'&iquest;Deseas eliminar esta no conformidad? Si lo haces todos los datos del seguimiento se borraran\',\'listados-conformidades-'.$edo.'\')" onmouseover="tip(\'Eliminar no conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;
								
							// cerradas
							case 2 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/cerrada.png" onmouseover="tip(\'No conformidad cerrada\')" onmouseout="cierra_tip()" />';
								$acc_edo = '<a href="'.base_url().'index.php/procesos/conformidades/ver/'.$row->IdConformidad.'/'.$edo.'" onmouseover="tip(\'Ver no conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a>';
								$img_cam = '<a onclick="pregunta_cambiar( \'conformidades\', '.$row->IdConformidad.', 3, \'&iquest;Deseas eliminar esta no conformidad?\',\'listados-conformidades-'.$edo.'\')" onmouseover="tip(\'Eliminar no conformidad\',\'listados-conformidades-'.$edo.'\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;
								
							// eliminadas
							case 3 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/eliminada.png" onmouseover="tip(\'No conformidad eliminada\')" onmouseout="cierra_tip()" />';
								$acc_edo = '<a href="'.base_url().'index.php/procesos/conformidades/ver/'.$row->IdConformidad.'/'.$edo.'" onmouseover="tip(\'Ver no conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a>';
								$img_cam = '<a onclick="pregunta_cambiar( \'conformidades\', '.$row->IdConformidad.', 0, \'&iquest;Deseas activar esta no conformidad?\',\'listados-conformidades-'.$edo.'\')" onmouseover="tip(\'Activar no conformidad\',\'listados-conformidades-'.$edo.'\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar.png" /></a>';
								break;
								
							// evidencias
							case 4 :
								$img_edo = '<img src="'.base_url().'includes/img/icons/terminada.png" onmouseover="tip(\'No conformidad atendida<br />con evidencias pendientes\')" onmouseout="cierra_tip()" />';
								$acc_edo = '<a href="'.base_url().'index.php/procesos/conformidades/ver/'.$row->IdConformidad.'/'.$edo.'" onmouseover="tip(\'Agergar evidencias de la No Conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/seguimiento.png" /></a>';
								$img_cam = '<a onclick="pregunta_cambiar( \'conformidades\', '.$row->IdConformidad.', 3, \'&iquest;Deseas eliminar esta no conformidad? Si lo haces todos los datos del seguimiento se borraran\',\'listados-conformidades-'.$edo.'\')" onmouseover="tip(\'Eliminar no conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;
						}
                        echo '<tr>';
                        echo '<th>'.$img_edo.'</th>';
                        echo '<td>'.$row->IdConformidad.'</td>';
						echo '<td>'.$row->Fecha.'</td>';
						echo '<td>'.$row->Departamento.'</td>';
						echo '<td>'.$row->Origen.'</td>';
						echo '<td>'.$row->Tipo.'</td>';
						echo '<td>'.$acc_edo.'</td>';
						if( $this->session->userdata('CON') && $row->Estado != 1 ) {
							
							if( $row->Estado != 2 ) {
								echo '<td><a href="'.base_url().'index.php/procesos/conformidades/seguimiento/'.$row->IdConformidad.'/'.$edo.'" onmouseover="tip(\'Ver no conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/seguimiento.png" /></a></td>';
								echo '<td><a href="'.base_url().'index.php/procesos/conformidades/modificar/'.$row->IdConformidad.'/'.$edo.'" onmouseover="tip(\'Modificar No Conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
								echo '<td>'.$img_cam.'</td>';
							}
							else {
								echo '<td></td><td></td><td></td>';
							}
						}
						elseif( $usuario_levanto ) {
							echo '<td></td><td></td><td></td>';
						}
						echo '</tr>';
                    endforeach;
					echo '</tbody></table>';
					echo $sort_tabla;
                }
                else {
                    echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay no conformidades</td></tr></table>';
                }
                ?>
        </div>
    </div>

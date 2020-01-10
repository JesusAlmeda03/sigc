<?php
/****************************************************************************************************
*
*	VIEWS/procesos/conformidades/seguimiento_usuarios.php
*
*		Descripción:
*			Vista de las No Conformidades levantadas por el usuario
*
*		Fecha de Creación:
*			04/Abril/2011
*
*		Ultima actualización:
*			04/Abril/2011
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
					'pendientes' 	=> 'Sin Atender - Pendientes de Cerrar',
					'cerradas'		=> 'Cerradas',
					'evidencias'	=> 'Evidencias Pendientes',
					'eliminadas'	=> 'Eliminadas',
				);				
				$estado_extras = 'id="estado" onfocus="hover(\'estado\')" style="width:300px; margin:0 0 0 5px;" onchange="form.submit()"';
				
		// Selección de listado
				echo form_open();
				echo '
					<table class="tabla_form" width="700">
	                    <tr>
	                        <th class="text_form" width="50">Estado</th>
	                        <td>'.form_dropdown('estado', $estado, $selec, $estado_extras).'</td>
	                    </tr>
	             	</table><br />
	            ';
				echo form_close();
			
		// Tabla de resultados				
                if( $consulta->num_rows() > 0 ) {
					echo '<table class="tabla" id="tabla" width="700">';
					echo '<thead><tr><th width="15" class="no_sort"></th><th>&Aacute;rea</th><th width="60">Fecha de la no conformidad</th><th width="150">Departamento al que se dirige la no conformidad</th><th>Origen</th><th>Tipo</th>';					 
					echo '<th class="no_sort"></th><th class="no_sort"></th>';
					echo '</tr></thead><tbody>';					
                    foreach( $consulta->result() as $row ) :
						// definen las acciones segun el estado de la no conformidad
						switch( $row->Estado ) {
							// sin atender
							case 0 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/pendiente.png" onmouseover="tip(\'No conformidad sin atender\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar('.$row->IdConformidad.',3,\'&iquest;Deseas eliminar esta conformidad?\')" onmouseover="tip(\'Eliminar No Conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';								
								break;
								
							// atendidas
							case 1 :
								$img_edo = '<img src="'.base_url().'includes/img/icons/terminada.png" onmouseover="tip(\'No conformidad atendida\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar('.$row->IdConformidad.',3,\'&iquest;Deseas eliminar esta conformidad?<br />Se eliminara toda la informaci&oacute;n del seguimiento\')" onmouseover="tip(\'Eliminar No Conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';								
								break;
								
							// cerradas
							case 2 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/terminada.png" onmouseover="tip(\'No conformidad cerrada\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar('.$row->IdConformidad.',3,\'&iquest;Deseas eliminar esta conformidad?<br />Se eliminara toda la informaci&oacute;n del seguimiento\')" onmouseover="tip(\'Eliminar No Conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;
								
							// eliminadas
							case 3 :								
								$img_edo = '<img src="'.base_url().'includes/img/icons/eliminada.png" onmouseover="tip(\'No conformidad eliminada\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar('.$row->IdConformidad.',0,\'&iquest;Deseas restaurar esta no conformidad?\')" onmouseover="tip(\'Restaurar No Conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;
								
							// evidencias
							case 4 :
								$img_edo = '<img src="'.base_url().'includes/img/icons/terminada.png" onmouseover="tip(\'No conformidad atendida\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar('.$row->IdConformidad.',3,\'&iquest;Deseas eliminar esta conformidad?<br />Se eliminara toda la informaci&oacute;n del seguimiento\')" onmouseover="tip(\'Eliminar No Conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';								
								break;
						}
                        echo '<tr>';
						echo '<th>'.$img_edo.'</th>';
						echo '<td>'.$row->Area.'</td>';
						echo '<td>'.$row->Fecha.'</td>';
						echo '<td>'.$row->Departamento.'</td>';
						echo '<td>'.$row->Origen.'</td>';
						echo '<td>'.$row->Tipo.'</td>';
						echo '<td><a href="'.base_url().'index.php/procesos/conformidades/modificar/'.$row->IdConformidad.'" onmouseover="tip(\'Modificar No Conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
						echo '<td>'.$img_cam.'</td>';						
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
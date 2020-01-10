<?php
/****************************************************************************************************
*
*	VIEWS/misc/listados/quejas.php
*
*		Descripci�n:
*			Vista de los Listados generados por los procesos automatizados
*			iconset:icojoy
*
*		Fecha de Creaci�n:
*			18/Octubre/2011
*
*		Ultima actualizaci�n:
*			19/Octubre/2011
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
					'todos'	=> 'Todas',
					'pendientes'	=> 'Pendientes',
					'terminadas'	=> 'Terminadas',
				);
				if( $this->session->userdata('QUE') )
					$estado['eliminadas'] = 'Eliminadas';
				$estado_extras = 'id="estado" onfocus="hover(\'estado\')" style="width:120px; margin:0 0 0 5px;" onchange="form.submit()"';
				
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
                if( $consulta->num_rows() > 0 ) {
					echo '<table class="tabla" id="tabla" width="700">';
					echo '<thead><tr><th width="15" class="no_sort"></th><th width="60">Fecha de la queja</th><th>Departamento al que se dirige la queja</th><th>Nombre de la persona que se queja</th><th class="no_sort" style="border:0"></th>';
					// Responsable de Quejas
					if( $this->session->userdata('QUE') ) 
						echo '<th class="no_sort" style="border:0"></th><th class="no_sort" style="border:0"></th>';
					echo '</tr></thead><tbody>';
                    foreach( $consulta->result() as $row ) :
						// definen las acciones segun el estado de la queja
						switch( $row->Estado ) {
							// pendientes
							case 0 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/pendiente.png" onmouseover="tip(\'Queja pendiente\')" onmouseout="cierra_tip()" />';
								$acc_edo = '<td><a href="'.base_url().'index.php/procesos/quejas/seguimiento/'.$row->IdQueja.'/'.$edo.'" onmouseover="tip(\'Dar seguimiento a la queja\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/seguimiento.png" /></a></td>';
								$img_cam = '<a onclick="pregunta_cambiar( \'quejas\', '.$row->IdQueja.', 2, \'&iquest;Deseas eliminar esta queja?\',\'listados-quejas-'.$edo.'\')" onmouseover="tip(\'Eliminar queja\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;
								
							// terminadas
							case 1 :
								$img_edo = '<img src="'.base_url().'includes/img/icons/terminada.png" onmouseover="tip(\'Queja resuelta\')" onmouseout="cierra_tip()" />';
								$acc_edo = '<td><a href="'.base_url().'index.php/procesos/quejas/ver/'.$row->IdQueja.'/'.$edo.'" onmouseover="tip(\'Ver queja\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
								$img_cam = '<a onclick="pregunta_cambiar( \'quejas\', '.$row->IdQueja.', 2, \'&iquest;Deseas eliminar esta queja?\',\'listados-quejas-'.$edo.'\')" onmouseover="tip(\'Eliminar queja\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;
								
							// eliminadas
							case 2 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/eliminada.png" onmouseover="tip(\'Queja eliminada\')" onmouseout="cierra_tip()" />';
								$acc_edo = '<td><a href="'.base_url().'index.php/procesos/quejas/ver/'.$row->IdQueja.'/'.$edo.'" onmouseover="tip(\'Ver queja\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
								$img_cam = '<a onclick="pregunta_cambiar( \'quejas\', '.$row->IdQueja.', 0, \'&iquest;Deseas eliminar esta queja?\',\'listados-quejas-'.$edo.'\')" onmouseover="tip(\'Eliminar queja\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar.png" /></a>';
								break;
						}
                        echo '<tr>';
						echo '<th>'.$img_edo.'</th>';
						echo '<td>'.$row->Fecha.'</td>';
						echo '<td>'.$row->Departamento.'</td>';
						echo '<td>'.$row->Nombre.'</td>';
						echo $acc_edo;
						if( $this->session->userdata('QUE') ) {
							echo '<td><a href="'.base_url().'index.php/procesos/quejas/modificar/'.$row->IdQueja.'/'.$edo.'" onmouseover="tip(\'Modificar Queja\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
							echo '<td>'.$img_cam.'</td>';
						}
                    endforeach;
					echo '</tbody></table>';
					echo $sort_tabla;
                }
                else {
                    echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay quejas</td></tr></table>';
                }
                ?>
        </div>
    </div>
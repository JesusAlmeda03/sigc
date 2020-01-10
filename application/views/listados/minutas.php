<?php
/****************************************************************************************************
*
*	VIEWS/misc/listados/minutas.php
*
*		Descripci�n:
*			Vista del listado de las minutas
*
*		Fecha de Creaci�n:
*			19/Noviembre/2011
*
*		Ultima actualizaci�n:
*			19/Noviembre/2011
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
		// Selección de listado
				if( $this->session->userdata('MIN') ) {
					$estado = array(
						'todos'			=> 'Todas',
						'activas'		=> 'Activas',
						'eliminadas'	=> 'Eliminadas',
					);
				
					$estado_extras = 'id="estado" onfocus="hover(\'estado\')" style="width:120px; margin:0 0 0 5px;" onchange="form.submit()"';
		
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
				}
			
		// Tabla de resultados				
                if( $consulta->num_rows() > 0 ) {
					echo '<table class="tabla" id="tabla" width="700">';
					echo '<thead><tr><th class="no_sort" style="width:5px"></th><th>A&ntilde;o</th><th>Periodo</th><th class="no_sort" width="15" style="border:0"></th>';
					// Responsable de Minutas
					if( $this->session->userdata('MIN') ) 
						echo '<th class="no_sort" width="15" style="border:0"></th><th class="no_sort" width="15" style="border:0"></th>';
					echo '</tr></thead><tbody>';
                    foreach( $consulta->result() as $row ) :
						// definen las acciones segun el estado de la minuta
						switch( $row->Estado ) {
							// eliminadas
							case 0 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/eliminada.png" onmouseover="tip(\'Minuta eliminada\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar(\'minutas\','.$row->IdMinuta.',1,\'&iquest;Deseas restaurar esta minuta?\',\'listados-minutas-'.$edo.'\')" onmouseover="tip(\'Restaurar minuta\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar.png" /></a>';
								break;
								
							// activas
							case 1 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/terminada.png" onmouseover="tip(\'Minuta activa\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar(\'minutas\','.$row->IdMinuta.',0,\'&iquest;Deseas eliminar esta minuta?\',\'listados-minutas-'.$edo.'\')" onmouseover="tip(\'Eliminar minuta\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;
						}
                        echo '<tr>';
						echo '<th>'.$img_edo.'</th>';
						echo '<td>'.$row->Ano.'</td>';
						echo '<td>'.$row->Periodo.'</td>';
						echo '<td><a href="'.base_url().'index.php/procesos/minutas/ver/'.$row->IdMinuta.'" target="_blank" onmouseover="tip(\'Ver minuta\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
						if( $this->session->userdata('MIN') ) {
							echo '<td><a href="'.base_url().'index.php/procesos/minutas/ver_modificar/'.$row->IdMinuta.'/'.$row->IdMinutaPuntos.'/'.$edo.'" onmouseover="tip(\'Modificar minuta\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
							echo '<td>'.$img_cam.'</td>';
						}
                    endforeach;
					echo '</tbody></table>';
					echo $sort_tabla;
                }
                else {
                    echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay minutas</td></tr></table>';
                }
                ?>
        </div>
    </div>
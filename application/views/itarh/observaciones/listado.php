<?php
/****************************************************************************************************
*
*	VIEWS/itarh/observaciones/listado.php
*
*		Descripción:
*			Listado de observaciones
*
*		Fecha de Creación:
*			09/Octubre/2011
*
*		Ultima actualización:
*			09/Octubre/2011
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
			$quincena_extras = 'id="quincena" onfocus="hover(\'quincena\')"  style="width:300px;" onchange="form.submit()"';
			
			$estado_options = array(
				'todos'  		=> ' - Todas las Observaciones - ',
				'pendientes'	=> 'Pendientes',
				'solventadas'	=> 'Solventadas',
				'eliminadas'	=> 'Eliminadas',
			);
			$estado_extras = 'id="estado" onfocus="hover(\'estado\')"  style="width:210px;" onchange="form.submit()"';
			
			echo form_open();
			echo '
	        	<table class="tabla_form" width="880" style="float:left">
	        		<tr><th width="100">Quincena</th><td>'.form_dropdown('quincena',$quincena_options,$quincena,$quincena_extras ).'</td></tr>
	            	<tr><th width="100">Estado</th><td>'.form_dropdown('estado',$estado_options,$estado,$estado_extras ).'</td></tr>
	         	</table>
         	';
            echo form_close();
			echo '<div style="width:100px; text-align:center; float:left;">';
			echo '<a href="'.base_url().'index.php/itarh/observaciones/excel/'.$quincena.'/'.$estado.'" onmouseover="tip(\'Exportar esta tabla a Excel\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/excel.png" width="80" /></a>';
			echo '</div>';
			echo '<div style="clear:both"></div><br />';
			
            if( $consulta->num_rows() > 0 ) {
                echo '<table class="tabla" id="tabla" width="980">';
                echo '<thead><tr>';
				echo '<th width="10" class="no_sort"></th>';
                echo '<th>No</th>';
				if( $quincena == 'todos' ) {
					echo '<th>Quincena</th>';
				}
				echo '<th>Matricula</th>';
				echo '<th>Nombre</th>';
				//echo '<th>Tipo de<br />Empleado</th>';
				//echo '<th>Unidad<br />Responsable</th>';
				//echo '<th>Permanencia</th>';
				//echo '<th>Hrs.<br />Contrato</th>';
				echo '<th>Sistema</th>';
				echo '<th>Contralor&iacute;a</th>';
				echo '<th>Observaci&oacute;n</th>';
				echo '<th width="10" class="no_sort"></th>';
				echo '</tr></thead><tbody>';
                foreach( $consulta->result() as $row ) {
					switch( $row->Estado ) {
						case 0 :
							$img_estado = '<img onmouseover="tip(\'Pendiente\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/pendiente.png" />';
							$img_cambia_estado = '<a onclick="pregunta_cambiar( \'observaciones\', '.$row->IdObservacion.', 2, \'&iquest;Deseas eliminar esta observaci&oacute;n?\', \'itarh-observaciones-listado-'.$quincena.'-'.$estado.'\')" onMouseover="tip(\'Eliminar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
							$img_detalle = '<td><a href="'.base_url().'index.php/itarh/observaciones/resolver/'.$row->IdObservacion.'/'.$quincena.'_'.$estado.'" onMouseover="tip(\'Resolver\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/seguimiento.png" /></a></td>';
							break;
							
						case 1 :
							$img_estado = '<img onmouseover="tip(\'Solventada\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/terminada.png" />';
							$img_cambia_estado = '<a onclick="pregunta_cambiar( \'observaciones\', '.$row->IdObservacion.', 2, \'&iquest;Deseas eliminar esta observaci&oacute;n?<br />Esta acci&oacute;n eliminara toda la informaci&oaci&oacute;n del seguimiento\', \'itarh-observaciones-listado-'.$quincena.'-'.$estado.'\')" onMouseover="tip(\'Eliminar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
							$img_detalle = '<td><a href="'.base_url().'index.php/itarh/observaciones/detalles/'.$row->IdObservacion.'/'.$quincena.'_'.$estado.'" onMouseover="tip(\'Ver Detalles\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
							break;
							
						case 2 :
							$img_estado = '<img onmouseover="tip(\'Eliminada\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/eliminada.png" />';
							$img_cambia_estado = '<a onclick="pregunta_cambiar( \'observaciones\', '.$row->IdObservacion.', 0, \'&iquest;Deseas activar este observaci&oacute;n?\', \'itarh-observaciones-listado-'.$quincena.'-'.$estado.'\')" onMouseover="tip(\'Activar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar.png" /></a>';
							$img_detalle = '';
							break;
					}
                    echo '<tr>';
					echo '<th>'.$img_estado.'</th>';
                    echo '<td>'.$row->IdObservacion.'</td>';
					if( $quincena == 'todos' ) {
						echo '<td>'.$row->Quincena.'</td>';
					}
					echo '<td>'.$row->Matricula.'</td>';
                    echo '<td>'.$row->Nombre.'</td>';
					//echo '<td>'.$row->Empleado.'</td>';
					//echo '<td>'.$row->Unidad.'</td>';
					//echo '<td>'.$row->Permanencia.'</td>';
					//echo '<td>'.$row->Horas.'</td>';
					echo '<td>'.$row->Sistema.'</td>';
					echo '<td>'.$row->Contraloria.'</td>';
                    echo '<td>'.$row->Observacion.'</td>';
					echo '<td>';
					echo '<table><tr>';
					echo $img_detalle;
					if( $row->IdUsuario == $this->session->userdata( 'id_usuario' ) ) {
						echo '<td><a href="'.base_url().'index.php/itarh/observaciones/modificar/'.$row->IdObservacion.'/'.$quincena.'_'.$estado.'" onMouseover="tip(\'Modificar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
					}
					echo '<td>'.$img_cambia_estado.'</td>';
					echo '</tr></table>';
					echo '</td></tr>';
                }
                echo '</tbody></table>';
				echo $sort_tabla;
            }
            else {
				echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay observaciones</td></tr></table>';
            }
            ?>
        </div>
    </div>
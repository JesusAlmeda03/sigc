<?php
/****************************************************************************************************
*
*	VIEWS/admin/varios/conformidades.php
*
*		Descripci�n:
*			Vista que muestra las no conformidades
*
*		Fecha de Creaci�n:
*			07/Noviembre/2011
*
*		Ultima actualizaci�n:
*			07/Noviembre/2011
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
			$area_extras = 'id="area" onfocus="hover(\'area\')"  style="width:350px; margin:0 0 0 5px; float:left" onchange="form.submit()"';
			$estado_extras = 'id="estado" onfocus="hover(\'estado\')"  style="width:350px; margin:0 0 0 5px; float:left" onchange="form.submit()"';
			echo form_open();
			echo '
	        	<table class="tabla_form" width="980">
	            	<tr><th width="100">&Aacute;rea</th><td>'.form_dropdown("area",$area_options,$area,$area_extras).'</td></tr>
	                <tr><th>Estado</th><td>'.form_dropdown("estado",$estado_options,$estado,$estado_extras ).'</td></tr>
	         	</table><br />
         	';
            echo form_close();
			
            if( $consulta->num_rows() > 0 ) {
                echo '<table class="tabla" id="tabla" width="980">';
                echo '<thead><tr><th width="10" class="no_sort"></th>';
				if( $area == "todos") echo '<th>&Aacute;rea</th><th>Folio</th>';
				echo '<th width="60">Fecha de la no conformidad</th><th>Departamento al que se dirige la no conformidad</th><th>Origen</th><th>Tipo</th><th class="no_sort"></th><th class="no_sort"></th><th class="no_sort"></th></tr></thead><tbody>';
                foreach( $consulta->result() as $row ) :
					// definen las acciones segun el estado de la no conformidad
					switch( $row->Estado ) {
						// sin atender
						case 0 : 
							$acc_edo = '<td><a href="'.base_url().'index.php/procesos/conformidades/seguimiento/'.$row->IdConformidad.'" onmouseover="tip(\'Dar seguimiento a la no conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/seguimiento.png" /></a></td>';
							$img_edo = '<img src="'.base_url().'includes/img/icons/pendiente.png" onmouseover="tip(\'No conformidad pendiente\')" onmouseout="cierra_tip()" />';
							$img_cam = '<a onclick="pregunta_cambiar(\'conformidades\','.$row->IdConformidad.',3,\'&iquest;Deseas eliminar esta conformidad?\',\'varios-conformidades-'.$area.'-'.$estado.'\')" onmouseover="tip(\'Eliminar No Conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
							break;
							
						// atendidas
						case 1 :
							$acc_edo = '<td><a href="'.base_url().'index.php/procesos/conformidades/ver/'.$row->IdConformidad.'" onmouseover="tip(\'Ver no conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
							$img_edo = '<img src="'.base_url().'includes/img/icons/terminada.png" onmouseover="tip(\'No conformidad resuelta\')" onmouseout="cierra_tip()" />';
							$img_cam = '<a onclick="pregunta_cambiar(\'conformidades\','.$row->IdConformidad.',3,\'&iquest;Deseas eliminar esta conformidad?<br />Se eliminara toda la informaci&oacute;n del seguimiento\',\'varios-conformidades-'.$area.'-'.$estado.'\')" onmouseover="tip(\'Eliminar No Conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
							break;
							
						// cerradas
						case 2 : 
							$acc_edo = '<td><a href="'.base_url().'index.php/procesos/conformidades/ver/'.$row->IdConformidad.'" onmouseover="tip(\'Ver no conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
							$img_edo = '<img src="'.base_url().'includes/img/icons/cerrada.png" onmouseover="tip(\'No conformidad cerrada\')" onmouseout="cierra_tip()" />';
							$img_cam = '<a onclick="pregunta_cambiar(\'conformidades\','.$row->IdConformidad.',3,\'&iquest;Deseas eliminar esta conformidad?<br />Se eliminara toda la informaci&oacute;n del seguimiento\',\'varios-conformidades-'.$area.'-'.$estado.'\')" onmouseover="tip(\'Eliminar No Conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
							break;
							
						// eliminadas
						case 3 : 
							$acc_edo = '<td><a href="'.base_url().'index.php/procesos/conformidades/ver/'.$row->IdConformidad.'" onmouseover="tip(\'No conformidad eliminada\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
							$img_edo = '<img src="'.base_url().'includes/img/icons/eliminada.png" onmouseover="tip(\'No conformidad eliminada\')" onmouseout="cierra_tip()" />';							
							$img_cam = '<a onclick="pregunta_cambiar(\'conformidades\','.$row->IdConformidad.',0,\'&iquest;Deseas restaurar esta no conformidad?\',\'varios-conformidades-'.$area.'-'.$estado.'\')" onmouseover="tip(\'Restaurar No Conformidad\',\'varios-conformidades\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar.png" /></a>';
							break;
					}
					echo '<tr>';
					echo '<th>'.$img_edo.'</th>';
					if( $area == "todos") echo '<td>'.$row->Area.'</td>';					
					echo '<td>'.$row->IdConformidad.'</td>';
					echo '<td>'.$row->Fecha.'</td>';
					echo '<td>'.$row->Departamento.'</td>';
					echo '<td>'.$row->Origen.'</td>';
					echo '<td>'.$row->Tipo.'</td>';
					echo '<td width="15"><a href="'.base_url().'index.php/admin/varios/conformidades_ver/'.$row->IdConformidad.'/'.$area.'/'.$estado.'" onmouseover="tip(\'Ver no conformidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
					echo '<td width="15"><a href="'.base_url().'index.php/admin/varios/conformidades_modificar/'.$row->IdConformidad.'/'.$area.'/'.$estado.'" onMouseover="tip(\'Modificar no conformidad\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';					
					echo '<td width="15">'.$img_cam.'</td>';
                    echo '</tr>';
                endforeach;
                echo '</tbody></table>';
				echo $sort_tabla;
            }
            else {
            	if( $area == 'elige' ) {
            		echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Elige una opci&oacute;n para ver las quejas</td></tr></table>';
            	} 
				else {
                	echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay no conformidades</td></tr></table>';
				}
            }
            ?>
        </div>
    </div>
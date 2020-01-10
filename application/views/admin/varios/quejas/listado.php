<?php
/****************************************************************************************************
*
*	VIEWS/admin/varios/quejas.php
*
*		Descripción:
*			Vista que muestra las quejas en el panel de administrador 
*
*		Fecha de Creación:
*			30/Octubre/2011
*
*		Ultima actualización:
*			2/Febrero/2012
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
				if( $area == "todos") echo '<th>&Aacute;rea</th>';
				echo '<th>Fecha de la Queja</th><th>Departamento al que se dirige la queja</th><th>Nombre de la persona que se queja</th><th class="no_sort"></th><th class="no_sort"></th><th class="no_sort"></th></tr></thead><tbody>';
                foreach( $consulta->result() as $row ) :
					// definen las acciones segun el estado de la queja
					switch( $row->Estado ) {
						// pendientes
						case 0 : 
							$acc_edo = '<td><a href="'.base_url().'index.php/procesos/quejas/modificar/'.$row->IdQueja.'" onmouseover="tip(\'Dar seguimiento a la queja\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/seguimiento.png" /></a></td>';
							$img_edo = '<img src="'.base_url().'includes/img/icons/pendiente.png" onmouseover="tip(\'Queja pendiente\')" onmouseout="cierra_tip()" />';
							$img_cam = '<a onclick="pregunta_cambiar(\'quejas\','.$row->IdQueja.',2,\'&iquest;Deseas eliminar esta queja?\',\'varios-quejas-'.$area.'-'.$estado.'\')" onMouseover="tip(\'Eliminar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
							break;
							
						// terminadas
						case 1 :
							$acc_edo = '<td><a href="'.base_url().'index.php/procesos/quejas/ver/'.$row->IdQueja.'" onmouseover="tip(\'Ver queja\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
							$img_edo = '<img src="'.base_url().'includes/img/icons/terminada.png" onmouseover="tip(\'Queja resuelta\')" onmouseout="cierra_tip()" />';
							$img_cam = '<a onclick="pregunta_cambiar(\'quejas\,'.$row->IdQueja.',2,\'&iquest;Deseas eliminar esta queja?<br />Si lo haces se eliminara toda la informaci&oacute;n del seguimiento\',\'varios-quejas-'.$area.'-'.$estado.'\')" onMouseover="tip(\'Eliminar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
							break;
							
						// eliminadas
						case 2 : 
							$acc_edo = '<td><a href="'.base_url().'index.php/procesos/quejas/ver/'.$row->IdQueja.'" onmouseover="tip(\'Ver queja\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
							$img_edo = '<img src="'.base_url().'includes/img/icons/eliminada.png" onmouseover="tip(\'Queja eliminada\')" onmouseout="cierra_tip()" />';
							$img_cam = '<a onclick="pregunta_cambiar(\'quejas\','.$row->IdQueja.',0,\'&iquest;Deseas restaurar esta queja?\',\'varios-quejas-'.$area.'-'.$estado.'\')" onMouseover="tip(\'Restaurar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar.png" /></a>';
							break;
					}
					echo '<tr>';
					echo '<th>'.$img_edo.'</th>';
					if( $area == "todos") echo '<td>'.$row->Area.'</td>';
					echo '<td>'.$row->Fecha.'</td>';
					echo '<td>'.$row->Departamento.'</td>';
					echo '<td>'.$row->Nombre.'</td>';
					echo '<td width="15"><a href="'.base_url().'index.php/admin/varios/quejas_ver/'.$row->IdQueja.'/'.$area.'/'.$estado.'" onmouseover="tip(\'Ver queja\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
					echo '<td width="15"><a href="'.base_url().'index.php/admin/varios/quejas_modificar/'.$row->IdQueja.'/'.$area.'/'.$estado.'" onMouseover="tip(\'Modificar queja\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
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
                	echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay quejas</td></tr></table>';
                }
            }
            ?>
        </div>
    </div>
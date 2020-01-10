<?php
/****************************************************************************************************
*
*	VIEWS/admin/minutas/minutas_areas.php
*
*		Descripción:
*			Listado de minutas de las áreas en el panel de administrador
*
*		Fecha de Creación:
*			30/Octubre/2011
*
*		Ultima actualización:
*			23/Enero/2012
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
				echo '<th>A&ntilde;o</th><th>Periodo</th><th class="no_sort" width="15"></th><th class="no_sort" width="15"></th><th class="no_sort" width="15"></tr></thead><tbody>';
                foreach( $consulta->result() as $row ) :
					// definen las acciones segun el estado de la minuta
					switch( $row->Estado ) {													
						// eliminadas
						case 0 : 							
							$img_edo = '<img src="'.base_url().'includes/img/icons/eliminada.png" onmouseover="tip(\'Minuta eliminada\')" onmouseout="cierra_tip()" />';
							$img_cam = '<a onclick="pregunta_cambiar(\'minutas\','.$row->IdMinuta.',1,\'&iquest;Deseas restaurar esta minuta?\',\'varios-minutas-'.$area.'-'.$estado.'\')" onmouseover="tip(\'Restaurar minuta\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar.png" /></a>';
							break;
							
						// activas
						case 1 :							
							$img_edo = '<img src="'.base_url().'includes/img/icons/terminada.png" onmouseover="tip(\'Minuta activa\')" onmouseout="cierra_tip()" />';
							$img_cam = '<a onclick="pregunta_cambiar(\'minutas\','.$row->IdMinuta.',0,\'&iquest;Deseas eliminar esta minuta?\',\'varios-minutas-'.$area.'-'.$estado.'\')" onmouseover="tip(\'Eliminar minuta\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
							break;
					}
					echo '<tr>';
					echo '<th>'.$img_edo.'</th>';
					if( $area == "todos") echo '<td>'.$row->Area.'</td>';
					echo '<td>'.$row->Ano.'</td>';
					echo '<td>'.$row->Periodo.'</td>';
					echo '<td width="40"><a href="'.base_url().'index.php/procesos/minutas/ver/'.$row->IdMinuta.'" target="_blank" onmouseover="tip(\'Ver minuta\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
					echo '<td width="40"><a href="'.base_url().'index.php/procesos/minutas/ver_modificar/'.$row->IdMinuta.'/'.$row->IdMinutaPuntos.'" onmouseover="tip(\'Modificar minuta\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
					echo '<td width="40">'.$img_cam.'</td>';
                    echo '</tr>';
                endforeach;
                echo '</tbody></table>';
				echo $sort_tabla;
            }
            else {
            	if( $area == 'elige' ) {
            		echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Elige una opci&oacute;n para ver las minutas</td></tr></table>';
            	} 
				else {
                	echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay minutas</td></tr></table>';
				}
            }
            ?>
        </div>
    </div><div class="btm_sh" style="width:982px; margin:0 0 5px 0"></div>    
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
*			HERE (http://www.webHERE.com.mx)
*			rogeliocas@gmail.com
*
****************************************************************************************************/
?>
    <div class="cont" style="width:970px;">
    	<? $uri = str_replace('/','-',uri_string()); ?>        
    	<div class="title">
            <?php
			$area_extras = 'id="area" onfocus="hover(\'area\')"  style="width:350px; margin:-5px 0 0 5px; float:left" onchange="form.submit()"';
			$estado_extras = 'id="estado" onfocus="hover(\'estado\')"  style="width:350px; margin:-5px 0 0 5px; float:left" onchange="form.submit()"';
			echo form_open();
			?>
        	<table>
            	<tr>
                	<td><?=$titulo?></td>
                	<td><?=form_dropdown('area',$area_options,$area,$area_extras)?></td>
                	<td><?=form_dropdown('estado',$estado_options,$estado,$estado_extras )?></td>
                </tr>
            </table>
            <?=form_close()?>
        </div>
        <div class="text">
			<?php
            if( $consulta->num_rows() > 0 ) {
                echo '<table class="tabla" id="tabla" width="950">';
                echo '<thead><tr><th width="10" class="no_sort"></th>';
				if( $area == "all") echo '<th>&Aacute;rea</th>';
				echo '<th>A&ntilde;o</th><th>Periodo</th><th class="no_sort"><th class="no_sort"></th><th class="no_sort"></th><th class="no_sort"></tr></thead><tbody>';
                foreach( $consulta->result() as $row ) :
					// definen las acciones segun el estado de la minuta
					switch( $row->Estado ) {													
						// eliminadas
						case 0 : 							
							$img_edo = '<img src="'.base_url().'includes/img/icons/delete.gif" onmouseover="ddrivetip(\'Minuta eliminada\')" onmouseout="hideddrivetip()" />';
							$img_cam = '<a onclick="pregunta_cambiar('.$row->IdMinuta.',1,\'&iquest;Deseas restaurar esta minuta?\')" onmouseover="ddrivetip(\'Restaurar minuta\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/ok2.gif" /></a>';
							break;
							
						// activas
						case 1 :							
							$img_edo = '<img src="'.base_url().'includes/img/icons/ok.gif" onmouseover="ddrivetip(\'Minuta activa\')" onmouseout="hideddrivetip()" />';
							$img_cam = '<a onclick="pregunta_cambiar('.$row->IdMinuta.',0,\'&iquest;Deseas eliminar esta minuta?\')" onmouseover="ddrivetip(\'Eliminar minuta\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/delete.gif" /></a>';
							break;
					}
					echo '<tr>';
					echo '<th>'.$img_edo.'</th>';
					if( $area == "all") echo '<td>'.$row->Area.'</td>';
					echo '<td>'.$row->Ano.'</td>';
					echo '<td>'.$row->Periodo.'</td>';					
					echo '<td width="40"><a href="#" onmouseover="ddrivetip(\'Abrir documento de la minuta\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/pdf.png" width="24" height="24" /></td>';
					echo '<td width="40"><a href="'.base_url().'index.php/procesos/minutas/ver/'.$row->IdMinuta.'" target="_blank" onmouseover="ddrivetip(\'Ver minuta\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/ver.gif" /></a></td>';
					echo '<td width="40"><a href="'.base_url().'index.php/procesos/minutas/ver_modificar/'.$row->IdMinuta.'/'.$row->IdMinutaPuntos.'" onmouseover="ddrivetip(\'Modificar minuta\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/edit.gif" /></a></td>';
					echo '<td width="40">'.$img_cam.'</td>';
                    echo '</tr>';
                endforeach;
                echo '</tbody></table>';
				echo $sort_tabla;
            }
            else {
                echo '<table class="tabla" width="950"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay minutas en las &aacute;reas</td></tr></table>';
            }
            ?>
        </div>
    </div><div class="btm_sh" style="width:982px; margin:0 0 5px 0"></div>    
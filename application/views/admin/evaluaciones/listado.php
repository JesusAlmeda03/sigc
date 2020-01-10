<?php
/****************************************************************************************************
*
*	VIEWS/admin/evaluaciones/evaluacion.php
*
*		Descripción:
*			Vista que muestra las evaluaciones 
*
*		Fecha de Creación:
*			30/Octubre/2011
*
*		Ultima actualización:
*			9/Febrero/2012
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
			$estado_options = array('todos' => ' - Todas - ','activas' => 'Activas', 'inactivas' => 'Inactivas');
			$estado_extras = 'id="estado" onfocus="hover(\'estado\')"  style="width:150px;" onchange="form.submit()"';
			echo form_open();
			echo '
	        	<table class="tabla_form" width="980">
	            	<tr><th width="100">Estado</th><td>'.form_dropdown('estado',$estado_options,$estado,$estado_extras ).'</td></tr>
	         	</table><br />
         	';
            echo form_close();
			
			if( $evaluaciones->num_rows() > 0 ) {
				echo '<table class="tabla" id="tabla" width="980">';
                echo '<thead><tr><th width="10" class="no_sort"></th><th>Encuesta</th><th>Nombre</th><th>Fecha</th><th>Observaciones</th><th width="10" class="no_sort"></th><th width="10" class="no_sort"></th></tr></thead>';
				foreach( $evaluaciones->result() as $row ) {
					echo '<tr>';
					if( $row->Estado ) {
						$img_edo = '<th><img onmouseover="tip(\'Evaluaci&oacute;n activa\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/terminada.png" /></th>';
						$img_act = '<td><a onclick="pregunta_cambiar(\'evaluaciones\',' . $row -> IdEvaluacion . ',0,\'&iquest;Deseas desactivar esta evaluaci&oacute;n?\',\'evaluaciones-listado-'.$estado.'\')" onmouseover="tip(\'Desactivar evaluaci&oacute;n\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';
					}
					else { 
						$img_edo = '<th><img onmouseover="tip(\'Evaluaci&oacute;n inactiva\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/pendiente.png" /></th>';
						// valida si se puede activar la evaluacion
						if( $evaluaciones_all->num_rows() > 0 ) {
							foreach( $evaluaciones_all->result() as $row_all ) {
								if( $row_all->IdEncuesta == $row->IdEncuesta )
									$img_act = '<td><a onmouseover="tip(\'Pr el momento no se puede activar<br />existe otra evaluaci&oacute;n de la misma encuesta activa\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activa.png" /></td>';
								else
									$img_act = '<td><a onclick="pregunta_cambiar(' . $row -> IdEvaluacion . ',1,\'&iquest;Deseas restaurar esta evaluaci&oacute;n?\')" onmouseover="tip(\'Activar evaluaci&oacute;n\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activa.png" /></a></td>';								
							}
						}
						else{
							$img_act = '<td><a onclick="pregunta_cambiar(\'evaluaciones\',' . $row -> IdEvaluacion . ',1,\'&iquest;Deseas restaurar esta evaluaci&oacute;n?\',\'evaluaciones-listado-'.$estado.'\')" onmouseover="tip(\'Activar evaluaci&oacute;n\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activa.png" /></a></td>';
						}						
						
					}
					
					echo $img_edo;
					echo '<td>'.$row->Encuesta.'</td>';
					echo '<td>'.$row->Nombre.'</td>';
					echo '<td>'.$row->Fecha.'</td>';
					echo '<td>'.$row->Observaciones.'</td>';
					echo '<td><a href="'.base_url().'index.php/admin/evaluaciones/modificar/'.$row->IdEvaluacion.'" onmouseover="tip(\'Modificar evaluaci&oacute;n\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
					echo $img_act;					
					echo '</tr>';
				}
				echo '</table>';
				echo $sort_tabla;
			}
			else {
                echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay evaluaciones</td></tr></table>';
            }			
            ?>
        </div>
    </div>
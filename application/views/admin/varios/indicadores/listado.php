<?php
/****************************************************************************************************
 *
 *	VIEWS/admin/varios/indicadores.php
 *
 *		Descripción:
 *			Vista que muestra los indicadores
 *
 *		Fecha de Creación:
 *			2/Febrero/2012
 *
 *		Ultima actualizaci�n:
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
		<div class="titulo"><?=$titulo ?></div>
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
            echo '<table class="tabla" width="980">';
           	echo '<thead><tr><th width="20">Indicador</th><th class="no_sort" colspan="2" width="15" style="text-align: right"><a href="'.base_url().'index.php/admin/varios/agregar_indicador/'.$area.'"><img src="'.base_url().'/includes/img/icons/agregar.png" width="24"></a></th></tr></thead></table>';
         
            echo '<table class="tabla" id="tabla" width="980">';
			echo '<thead><tr><th class="no_sort"></th>';

			
			if ($indicadores -> num_rows() > 0) {
				if( $area == "todos")
					echo '<th>&Aacute;rea</th>';
				
				
				echo '<tbody>';
				$i = 0;
				foreach ($indicadores->result() as $row) {
					// definen las acciones segun el estado de la no conformidad
					switch( $row->Estado ) {
						// eliminados
						case 0 :
							$img_cam = '<td width="15"><a href="'.base_url().'index.php/admin/varios/activar_indicador/'.$row->IdIndicador.'/'.$area.'" onMouseover="tip(\'Modificar indicador\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar.png" /></a></td>';
							break;
							
						// activos
						case 1 :
							$img_cam = '<td width="15"><a href="'.base_url().'index.php/admin/varios/eliminar_indicador/'.$row->IdIndicador.'/'.$area.'" onMouseover="tip(\'Modificar indicador\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';
							break;
					}

					if ($i) {
						echo '<tr class="odd">';
						$i = 0;
					} else {
						echo '<tr>';
						$i = 1;
					}
					echo '<th width="30" style="text-align:center"><a href="' . base_url() . 'index.php/admin/varios/indicadores_grafica/'.$row->IdIndicador.'/todos/'.$area.'/'.$estado.'" onmouseover="tip(\'Revisar el indicador\')" onmouseout="cierra_tip()"><img src="' . base_url() . 'includes/img/icons/grafica.png" /></a></th>';
					if( $area == "todos") echo '<td>' . $row -> Area . '</td>';

					echo '<td>' . $row -> Indicador . '</td>';
					echo '<td width="15"><a href="'.base_url().'index.php/admin/varios/indicadores_modificar/'.$row->IdIndicador.'/'.$area.'/'.$estado.'" onMouseover="tip(\'Modificar indicador\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
					echo $img_cam;
					echo '</tr>';
				}
				echo '</tbody></table>';
				echo $sort_tabla;
			}


			?>
		</div>
	</div>
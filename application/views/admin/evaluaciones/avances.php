<?php
/****************************************************************************************************
*
*	VIEWS/admin/varios/avances.php
*
*		Descripción:
*			Vista que muestra los avances 
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
    <div class="cont_admin" style="width:970px;">
    	<div class="titulo">
    		<?php
			$encuesta_extras = 'id="encuesta" onfocus="hover(\'encuesta\')"  style="width:350px; margin:-5px 0 0 5px; float:left" onchange="form.submit()"';
			$area_extras = 'id="area" onfocus="hover(\'area\')"  style="width:350px; margin:-5px 0 0 5px; float:left" onchange="form.submit()"';
			echo form_open();
			?>
			<table>
				<tr>
					<td><?=$titulo
					?></td>
					<td><?=form_dropdown('encuesta',$encuesta_options,$encuesta,$encuesta_extras)
					?></td>
					<td><?=form_dropdown('area',$area_options,$area,$area_extras)					
					?></td>
				</tr>
			</table>
			<?=form_close()
			?>
    	</div>
        <div class="text">
        	<?php
				echo '<table class="tabla" id="tabla" width="950">';
				echo '<thead><tr><th class="no_sort" width="20"></th><th>Nombre</th>';
				if( $area == 'all' ) 
					echo '<th>&Aacute;rea</th>';
				echo '<th>Porcentaje de Avance Personal</th></tr></thead><tbody>';
				$i = 0;
				$j = 0;
				$total = 0;
				foreach( $listado as $row ) {
					if( $i ) {					
						echo '<tr>';
						$i = 0;
					}
					else {
						echo '<tr class="odd">';
						$i = 1;
					}
					if( $row['Porcentaje'] == '100' )
						echo '<th><img onmouseover="ddrivetip(\'Evaluaci&oacute;n terminada\')" onmouseout="hideddrivetip()" src="'.base_url().'includes/img/icons/terminada.png" /></th>';
					else 
						echo '<th><img onmouseover="ddrivetip(\'Evaluaci&oacute;n pendiente\')" onmouseout="hideddrivetip()" src="'.base_url().'includes/img/icons/pendiente.png" /></th>';
					if( $area == 'all' ) 
						echo '<td>'.$row['Area'].'</td>';
					echo '<td>'.$row['Nombre'].'</td><td>'.$row['Porcentaje'].' %</td></tr>';
					$total = $total + $row['Porcentaje'];
					$j++;
				}				
				$total = round( ( $total / $j ) * 100 ) / 100 ;				
				echo '<tr><th></th>';
				if( $area == 'all' )
					echo '<th></th>';
				echo '<th>Avance TOTAL</th><th class="text_form">'.$total.'%</th></tr>';
				echo '</tbody></table>';
				echo $sort_tabla;
				?>
        </div>
    </div>
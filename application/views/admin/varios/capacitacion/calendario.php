
<div class="content">
		<div class="cont">
			<div class="titulo">Calendario Anual de Capacitacion</div>
            <div class="texto">
            	<?php				
            	if( $consulta->num_rows() > 0 ) {
            		echo '<table class="tabla" id="tabla" width="700">';
					echo '<thead><tr><th width="15" class="no_sort"></th><th>Nombre del Curso</th><th>Cupo</th><th>Fecha</th></thead>';
					echo '<tbody>';
            		foreach( $consulta->result() as $row ) {
						echo '<tr>';
						echo '	<th></th>';
						echo '	<td>'.$row->Curso.'</td><td> '.$row->Cantidad.'</td><td> '.$row->Fecha.'</td>';
						echo '</tr>';
            		}
					echo '</tbody>';
					echo '</table>';
					echo $sort_tabla;
            	}
				else {
                    echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay cursos programados</td></tr></table>';
                }
            	?>
            </div>
</div>


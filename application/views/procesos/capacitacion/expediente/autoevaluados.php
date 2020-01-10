<div class="content">
		<div class="cont">
			<div class="titulo"><?=$titulo?></div>
            <div class="texto">
            	<?php				
            	if( $usuarios->num_rows() > 0 ) {
            		echo '<table class="tabla" id="tabla" width="700">';
					echo '<thead><tr><th width="15" class="no_sort"></th><th>Nombre del Usuario</th><th class="no_sort" width="15" style="border:0"></th><th class="no_sort" width="15" style="border:0">S</th></tr></thead>';
					echo '<tbody>';
            		foreach( $usuarios->result() as $row ) {
						echo '<tr>';
						echo '	<th><img src="'.base_url().'includes/img/icons/small/account.png" /></th>';
						echo '	<td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.'</td>';
						
						echo '</tr>';
            		}
					echo '</tbody>';
					echo '</table>';
					echo $sort_tabla;
            	}
				else {
                    echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay usuarios</td></tr></table>';
                }
            	?>
            </div>
		</div>
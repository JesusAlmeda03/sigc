<div class="content">
		<div class="cont">			
            <?php				
            if( $autoevaluados->num_rows() > 0 ) {
                echo '<div class="titulo">'.$titulo.'</div>';
                echo '<div class="texto">';
            	echo '<table class="tabla" id="tabla" width="700">';
				echo '<thead><tr><th width="15" class="no_sort"></th><th>Nombre del Usuario</th><th width="15" class="no_sort"></th></thead>';
				echo '<tbody>';
            	foreach( $autoevaluados->result() as $row ) {
					echo '<tr>';
					echo '	<th><img src="'.base_url().'includes/img/icons/small/account.png" /></th>';
					echo '	<td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.'</td>';
					echo '	<td><a href="'.base_url().'index.php/procesos/capacitacion/revisar_evaluacion/'.$row->IdUsuario.'" onmouseover="tip(\'Revisar evaluación\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
					echo '</tr>';
            	}
				echo '</tbody>';
				echo '</table>';
				echo $sort_tabla;
                echo '</div>';
            }				
            ?>            

            <?php				
            if( $no_autoevaluados->num_rows() > 0 ) {
                echo '<br /><br /><br /><br /><br />';
                echo '<div class="titulo">Usuarios que no han respondido la encuesta</div>';
                echo '<div class="texto">';
            	echo '<table class="tabla" id="tabla_no_autoevaluados" width="700">';
				echo '<thead><tr><th width="15" class="no_sort"></th><th>Nombre del Usuario</th></thead>';
				echo '<tbody>';
            	foreach( $no_autoevaluados->result() as $row ) {
					echo '<tr>';
					echo '	<th><img src="'.base_url().'includes/img/icons/small/account.png" /></th>';
					echo '	<td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.'</td>';
						
					echo '</tr>';
            	}
				echo '</tbody>';
				echo '</table>';
				echo '
                    <script type="text/javascript" charset="utf-8">
                        $(document).ready(function() {
                            var dontSort = [];
                            $("#tabla_no_autoevaluados thead th").each( function () {
                                if ( $(this).hasClass( "no_sort" )) {
                                    dontSort.push( { "bSortable": false } );
                                } else {
                                    dontSort.push( null );
                                }
                            } );
                            $("#tabla_no_autoevaluados").dataTable({
						        "bJQueryUI": true,
						        "sPaginationType": "full_numbers",
                                "aoColumns": dontSort,
                                "iDisplayLength": 15,
                                "aLengthMenu": [[-1, 10, 25, 50, 100], [ " - Todos los registros - ", "10 registros", "25 registros", "50 registros", "100 registros"]]
                            });
                        } );
                    </script>
                ';
                echo '</div>';
            }				
            ?>  
</div>
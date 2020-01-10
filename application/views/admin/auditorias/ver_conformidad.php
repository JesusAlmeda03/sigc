<?php
/****************************************************************************************************
*
*	VIEWS/admin/aduditorias/revisar_avance.php
*
*		Descripción:
*			Vista para revisar el estado de las observaciones en los procesos
*
*		Fecha de Creación:
*			26/noviembre/2013
*
*		Ultima actualizaciÓn:
*			26/noviembre/2013
*
*		Autor:
*			ISC Jesus Carlos Almeda Macias
*			iscalmeda@gmail.com
*			
*
****************************************************************************************************/
?>          

<div class="cont_admin">
	<?='<div class="titulo"> Revisar No conformidad</div>';?>
    	
        <div class="texto">
        <?php
			if( $consulta->num_rows() > 0 ) {
				echo '<table class="tabla_form" width="980">';
				foreach( $consulta2->result() as $conformidad2) {
					
				}		
						
				foreach( $consulta->result() as $conformidad) {
					
						echo '<tr>';
							echo '<th>Departamento: </th><td>'. $conformidad->Departamento.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<th>Fecha: </th><td>'.$conformidad->Fecha.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<th>Auditor: </th><td>'. $conformidad->Nombre.' '.$conformidad->Paterno.' '.$conformidad->Materno.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<th width="25%">No Conformidad: </th><td>'.$conformidad->Descripcion.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<th>Accion: </th><td>'.$conformidad->Accion.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<th>Tipo: </th><td>'. $conformidad->Tipo.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<th>Categoria: </th><td>'.$conformidad->Categoria.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<th>Causa: </th><td>'.$conformidad->Causa.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<th>Seguimiento: </th><td>'.$conformidad2->Causa.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<th>Herramienta: </th><td>'.$conformidad2->Herramienta.'</td>';
						echo '</tr>';
						$estado=$conformidad->Estado;
						switch ( $estado ){
							case 1 :
								echo '<tr>';
									echo '<th>Estado: </th><td>Atendida</td>';
								echo '</tr>';
							break;	
							
							case 2 :
								echo '<tr>';
									echo '<th>Estado: </th><td>Cerrada</td>';
								echo '</tr>';
							break;	
							case 3 :
								echo '<tr>';
									echo '<th>Estado: </th><td>Eliminada</td>';
								echo '</tr>';
							break;	
							case 4 :
								echo '<tr>';
									echo '<th>Estado: </th><td>Atendida Sin Evidencias</td>';
								echo '</tr>';
							break;	
							
						}
				}
				echo '</table>';
			}else{
				echo '<h1>Esta no conformidad no cuenta con acciones correctivas</h1>';
			}
				
		?>
        </div>
    </div>
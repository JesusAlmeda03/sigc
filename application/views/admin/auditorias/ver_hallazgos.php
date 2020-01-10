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
	<?php
	foreach( $consulta2->result() as $row_titulo ) {
		echo '<div class="titulo">Lista de Verificaci&oacuten: </br>'. $row_titulo->Proceso.'</div>';
	}
?>
    	
        <div class="texto">
        <?php
			if( $consulta->num_rows() > 0 ) {
				echo '<table class="tabla_form" width="980">';
						echo '<tr><td style="background-color:#EAECEE; font-weight:bold">Requisito</td><td style="background-color:#EAECEE; font-weight:bold">Pregunta</td></tr>';
						
				foreach( $consulta->result() as $row_equipos ) {
					
						echo '<tr>';
						echo '<td>'.$row_equipos->Hallazgo.'</td>';
							
						echo '</tr>';
					
				}
			}
				echo '</table>';
		?>
        </div>
    </div>
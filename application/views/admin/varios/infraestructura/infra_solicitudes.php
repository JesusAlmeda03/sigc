<?
/****************************************************************************************************
*
*	VIEWS/procesos/infraestructura/registrar.php
*
*		Descripción:
*			Genera lista de reportes para solicitud de aprovacion por carte de CC
*
*		Fecha de Creación:
*			13/Noviembre/2013
*
*		Ultima actualización:
*			13/Noviembre/2013
 
*		Autor:
*			ISC Jesus Carlos Almeda Macias
*			iscalmeda@gmail.com
*			@c
*
****************************************************************************************************/
?>
	<div class="content">		
		<div class="cont">
			<div class="titulo"><?=$titulo?></div>
            <div class="texto">
				<?php
				

					if($consulta->num_rows() > 0){
						echo '<table class="tabla_form" width="700">';
						echo '<tr><th>Elementos</th><th>Estado</th><th>Descripcion de la inconformidad</th><th>Area</th><th>Departamento</th></tr>';
						foreach($consulta->result() as $row ):
							echo '<tr><th>'.$row->Concepto.'</th>';
							echo '<td>'.$row->Respuesta.'</td>'; 
							echo '<td>'.$row->Observacion.'</td>';
							echo '<td>'.$row->Area.'</td>';
							echo '<td>'.$row->Departamento.'</td></tr>';
						endforeach;
						
					echo '</table>';
				}else{
					echo 'No Solicitudes por revisar';
				}
				
				?>
				
				
        </div>
    </div>
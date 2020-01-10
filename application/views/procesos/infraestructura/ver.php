<?
/****************************************************************************************************
*
*	VIEWS/procesos/infraestructura/registrar.php
*
*		Descripción:
*			Genera lista de reportes de infraestructura de un area
*
*		Fecha de Creación:
*			31/Octubre/2013
*
*		Ultima actualización:
*			05/Octubre/2013
*				-Se inicializo 
*		Autor:
*			ISC Jesus Carlos Almeda Macias
*			iscalmeda@gmail.com
*			@c
*
****************************************************************************************************/

?>

	<div class="content">		
		<div class="cont">
			<?php 
				foreach($consulta->result() as $des){}
				 foreach($periodo->result() as $periodo){}
				  foreach($area->result() as $areaR){}
				if(empty($des->Departamento)){
					echo '<div class="titulo">Reporte General</div>';
				}else{
					foreach($departamento->result() as $dep){
						echo '<div class="titulo">'.$dep->Departamento.'<br>'.$areaR->Area.'<br><h4>6.3 Reporte de Infraestructura</h4>'.$periodo->Nombre.'</div>';
					}
				}
			?>
			
			
            <div class="texto">
				<?php
				if($consulta->num_rows() > 0){
					echo '<table class="tabla_form" width="700">';
					echo '	<thead>';
					echo '		<tr><th>Elementos</th><th>Estado</th><th>Descripcion</th>';
					echo '	</thead>';
					echo '	<tbody>';
					echo '		<tr>';
						foreach($consulta->result() as $des){
					echo '			<td>'.$des->Concepto.'</t>';
					echo '			<td>'.$des->Respuesta.'</td>';
					echo '			<td>'.$des->Observacion.'</td>';
					echo '		</tr>';
					echo '  </tbody>';
						}
					echo '</table>';	
					
					echo '<table class="tabla_form" width="700">';
						echo '<thead>';
							echo '		<tr><th>Acciones a Tomar</th>';
							foreach($consulta2->result() as $acciones){
								echo '<tr><td>'.$acciones->Acciones.'</td></tr>';
							}
						echo '</thead>';
					echo '</table>';
				}else{
					echo 'Sin informacion';
				}
				
												  
				?>
				<table>
					<tbody>
						<tr>
							<td>
								<a onmouseout="cierra_tip()" onmouseover="tip('Regresa al listado de reportes')" href="<?=base_url()?>index.php/procesos/infraestructura/reportes"><img src="<?=base_url()?>includes/img/icons/back2.png"></a>
							</td>
							<td valign="middle">
								<a style="letter-spacing:2px; padding-left:5px;" onmouseout="cierra_tip()" onmouseover="tip('Regresa al listado de reportes')" href="<?=base_url()?>index.php/procesos/infraestructura/reportes">Regresar</a>
							</td>
						</tr>
					</tbody>
				</table>
				
        </div>
    </div>
</div>

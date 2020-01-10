<?php
/****************************************************************************************************
*
*	VIEWS/procesos/capacitacion/cursos_propuestos.php
*
*		Descripción:
*			Vista para revisar los cursos propuestos en el área
*
*		Fecha de Creación:
*			28/Enero/2013
*
*		Ultima actualización:
*			28/Enero/2013
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
?>
	<div class="content">
		<div class="cont">
			<div class="titulo"><?=$titulo?></div>
            <div class="texto">
            	<?php
            	$formulario = array(
					// * Boton submit
					'boton' => array (
						'id'		=> 'aceptar',
						'name'		=> 'aceptar',
						'class'		=> 'in_button',
						'onfocus'	=> 'hover(\'aceptar\')'
					),
				);

				if( $cursos->num_rows > 0 ) {
					if( $cursos_area->num_rows > 0 ) {
						echo '<table class="tabla" width="700">';
						echo '<thead ><tr><th class="no_sort" style="background: #CC0000; color: white;"></th><th style="background: #CC0000; color: white;">Nombre del Curso</th><th style="background: #CC0000; color: white;">Tipo</th><th style="background: #CC0000; color: white;">Observaciones</th></tr></thead>';
						echo '<tbody>';
						foreach( $cursos_area->result() as $row ) {
							echo '<tr>';
							if( $row->Estado ) {
								echo '	<td><img onmouseover="tip(\'Curso Autorizado\')" onmouseoute="cierra_tip()" src="'.base_url().'includes/img/icons/terminada.png"/></td>';
							}
							else {
								
								echo '	<td><img onmouseover="tip(\'Curso pendiente de autorizar<br />en Coordinación de Calidad\')" onmouseoute="cierra_tip()" src="'.base_url().'includes/img/icons/pendiente.png"/></td>';
							}
							$area=$this->session->userdata('area');
						
							echo '	<td>'.$row->Curso.'</td>';
							echo '	<td>'.$row->Tipo.'</td>';
							
							echo '	<td>'.$row->Observaciones.'</td>';
							echo '</tr>';
						}
						echo '</tbody>';
						echo '</table>';
						echo $sort_tabla;
					}
					echo "<br>";
					echo form_open();
					echo '<table>
							<tr>
								<td valign="top">';
					echo '			<table class="tabla" width="500"><tr>
									<th width="20">
										<img src="'.base_url().'includes/img/icons/small/info.png" />
									</th>
										<td>Se muestra una lista de los Cursos de Capacitación propuestos por los usuarios de tu área con la cantidad de votos de cada uno.</td></tr></table><br />';
					echo '		</td>
								<td valign="top">';
					
					echo '<table class="tabla_form" width="190">
								<tr>
									<td style="background-color:#fff; text-align:center">
										<a href="'.base_url().'index.php/procesos/capacitacion/cursos/'.$id_evaluacion.'/propuestos">
										<img src="'.base_url().'includes/img/icons/agregar.png"><br />Agregar un nuevo Curso de Capacitación</a>
									</td>
								</tr>
						  </table>';			
						  		
					echo '</td></tr></table>';
					
					echo '<table class="tabla" width="700">';
					echo '<thead>
								<tr>
									<th width="15" class="no_sort"></th>
									<th>Nombre del Curso</th>
									<th width="45">Votos</th>
								</tr>
							</thead>';
					echo '<tbody>';
					echo '<table>';
					foreach( $cursos->result() as $row ) {
						echo '<tr>';
						if( $this->session->userdata('CAP') ) {
							echo "<td><a href=".base_url().'index.php/procesos/capacitacion/cursos_propuestos_info/'.$id_evaluacion.'/'.$row->IdCapacitacionCurso.'>Agregar Info</a></td>';
							
						}
						else {
							
						}
						echo '	<td>'.$row->Curso.'</td>';
						if( $row->Total == 1 ) {
							if( $row->IdCapacitacionCursoVoto != NULL ) {
								$total = $row->Total + 1;
								echo '	<td>'.$total.'</td>';
							}
							else {
								echo '	<td>'.$row->Total.'</td>';
							}
						}
						else {
							echo '	<td>'.$row->Total.'</td>';
						}
						echo '</tr>';
					}
					echo '</tbody>';
					echo '</table>';
					echo $sort_tabla;
					if( $this->session->userdata('CAP') ) {
						echo '<br /><div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
					}	
					echo form_close();
				}
				else {
					if( $cursos_area->num_rows > 0 ) {
						echo '<table class="tabla" width="700">';
						echo '<thead><tr><th class="no_sort" width="15"></th><th>Nombre del Curso</th><th>Tipo</th><th>Fecha Tentativa</th><th>Observaciones</th></tr></thead>';
						echo '<tbody>';
						foreach( $cursos_area->result() as $row ) {
							echo '<tr>';
							if( $row->Estado ) {
								echo '	<th><img onmouseover="tip(\'Curso Autorizado\')" onmouseoute="cierra_tip()" src="'.base_url().'includes/img/icons/terminada.png"/></th>';
							}
							else {
								echo '	<th><img onmouseover="tip(\'Curso pendiente de autorizar<br />en Coordinación de Calidad\')" onmouseoute="cierra_tip()" src="'.base_url().'includes/img/icons/pendiente.png"/></th>';
							}
							echo '  <td> </td>';
							echo '	<td>'.$row->Curso.'</td>';
							echo '	<td></td>';//.$row->Tipo.'';
							echo '  <td></td>';//.$row->Fecha.'';
							echo '	<td>'.$row->Observaciones.'</td>';
							echo '</tr>';
						}
						echo '</tbody>';
						echo '</table>';
						echo $sort_tabla;
						
						echo '<br />';
						echo '<table class="tabla_form" width="190"><tr><td style="background-color:#fff; text-align:center"><a href="'.base_url().'index.php/procesos/capacitacion/cursos_propuestos_info"><img src="'.base_url().'includes/img/icons/agregar.png"><br />Modificar la información de los cursos propuestos</a></td></tr></table>';						
					}
					else {
						echo '<table><tr><td valign="top">';
						echo '<table class="tabla" width="500"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay cursos propuestos en tu área</td></tr></table><br />';
						echo '</td><td valign="top">';
						echo '<table class="tabla_form" width="190"><tr><td style="background-color:#fff; text-align:center"><a href="'.base_url().'index.php/procesos/capacitacion/cursos/'.$id_evaluacion.'/propuestos"><img src="'.base_url().'includes/img/icons/agregar.png"><br />Agregar un nuevo Curso de Capacitación</a></td></tr></table>';					
						echo '</td></tr></table>';					
					}
				}
            	?>
            </div>
		</div>
<?php
/****************************************************************************************************
*
*	VIEWS/procesos/capacitacion/cursos.php
*
*		Descripción:
*			Vista para elegir cursos de capacitacion
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
					// Curso
					'curso' => array (
						'name'		=> 'curso',
						'id'		=> 'curso',
						'value'		=> set_value('curso'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('curso')",
					),
					// Comentarios
					'comentarios' => array (
						'name'		=> 'comentarios',
						'id'		=> 'comentarios',
						'value'		=> set_value('comentarios'),
						'onfocus'	=> "hover('comentarios')",
					)
				);
				
				echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Puedes proponer uno o varios Cursos de Capacitación en base a tus resultados</td></tr></table><br />';
				
				// Resultados
				echo $grafica;
				/*if( $habilidades->num_rows() > 0 ) {
					echo '<table class="tabla_form" width="700">';
					foreach( $habilidades->result() as $row_h ) {
						echo '<tr><th width="200">'.$row_h->Habilidad.'</th>';
						if( $resultados->num_rows() > 0 ) {
							$i = 0;
							$total = 0;
							foreach( $resultados->result() as $row_r ) {
								if( $row_h->IdCapacitacionHabilidad == $row_r->IdHabilidad ) {
									$total = $total + $row_r->Valor;
									$i++;
								}
							}
							$total = $total / $i;
							echo '<td>'.$total.'</td></tr>';
						}
					}
					echo '</table><br />';
				}*/
			
				// Formulario cursos
            	echo form_open();
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="text_form" width="130">Nombre del Curso: </th>';
				echo '<td>'.form_input($formulario['curso']).'</td></tr>';
				
				echo '<tr><th class="text_form" width="130">Comentarios a cerca del curso: </th>';
				echo '<td>'.form_textarea($formulario['comentarios']).'</td></tr>';
				echo '</table><br />';
				echo '<br /><div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
				echo form_close().'<br /><br /><br />';
				
				// Cursos propuestos
				if( $cursos->num_rows > 0 && !$propuestos ) {
					echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>O puedes votar a favor de uno de los Cursos de Capacitación ya propuestos haciendo click en el icono <img src="'.base_url().'includes/img/icons/terminada.png" /></td></tr></table><br />';
					echo '<table class="tabla" id="tabla" width="700">';
					echo '<thead><tr><th width="15" class="no_sort"></th><th>Nombre del Curso</th></tr></thead>';
					echo '<tbody>';
					$i=0;
					foreach( $cursos->result() as $row ) {
						echo '<tr>';
						echo '	<th><a href="'.base_url().'index.php/procesos/capacitacion/votar/'.$id_evaluacion.'/'.$row->IdCapacitacionCurso.'" onmouseover="tip(\'Votar a favor de este curso\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar_big.png" width="28" /></a></th>';
						echo '	<td>'.$row->Curso.'</td>';
						echo '</tr>';
						
						
						
					}echo '</tbody>';
						echo '</table>';
						echo $sort_tabla;
					
				}
				
				if( $propuestos ) {
					echo '<table><tr><td><a href="'.base_url().'index.php/procesos/capacitacion/cursos_propuestos" onmouseover="tip(\'Regresa al listado de<br />Cursos de Capacitación Propuestos\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/procesos/capacitacion/cursos_propuestos" onmouseover="tip(\'Regresa al listado de<br />Cursos de Capacitación Propuestos\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
				}
            	?>
            </div>
		</div>
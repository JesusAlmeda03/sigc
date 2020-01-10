<script>
	
	</script>
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
					echo form_open();
					echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Establece las condiciones de los Cursos de Capacitación Propuestos</td></tr></table><br />';
					foreach($cursos->result() as $row ) {
						
						
						if($anio=='0000'){
						echo '<table class="tabla_form" id="tabla" width="700">';
						echo '<tr>';
						echo '	<th valign="top">Curso:</th>';
						echo '	<td><input type="text" name="Curso" id="Curso"</td>';
						echo '</tr>';
						echo '<tr>';
						echo '	<th valign="top">Financiado por:</th>';
						echo '	<td>';
						echo ' 		<input type="radio" name="tipo_'.$row->IdCapacitacionCurso.'" value="Recursos Propios" class="in_radio"'; if( $row->Tipo == 'Recursos Propios' ) echo 'checked="checked"'; echo '> Recursos Propios<br />';
						echo ' 		<input type="radio" name="tipo_'.$row->IdCapacitacionCurso.'" value="Dentro de la Universidad" class="in_radio"'; if( $row->Tipo == 'Dentro de la Universidad' ) echo 'checked="checked"'; echo '> Dentro de la Universidad<br />';
						echo ' 		<input type="radio" name="tipo_'.$row->IdCapacitacionCurso.'" value="Institucion Externa" class="in_radio"'; if( $row->Tipo == 'Institución Externa' ) echo 'checked="checked"'; echo '> Institución Externa<br />';
						echo ' 		<input type="radio" name="tipo_'.$row->IdCapacitacionCurso.'" value="Recuros Pifi" class="in_radio"'; if( $row->Tipo == 'Recurso Pifi' ) echo 'checked="checked"'; echo '> Recurso Pifi<br />';
						echo ' 		<input type="radio" name="tipo_'.$row->IdCapacitacionCurso.'" value="otra" class="in_radio"'; if( $row->Tipo == 'Otra' ) echo 'checked="checked"'; echo '> Otra<br />';
						echo '	</td>';
						echo '  </tr>';
						echo ' <tr>';
						echo '	<th valign="top">Fecha Tentativa:</th>';
						echo '	<td>';?>
						
						<script>
	$(function(){$("#Fecha").datepicker({dateFormat: "yy-mm-dd"});
		});
	</script>
	<?
						echo " 		<input type='text' name='Fecha' id='Fecha'>";
						echo '	</td>';
						echo '  </tr>';
						echo '<tr>';
						echo '	<th valign="top">Cantidad:</th>';
						echo '	<td>';
						echo " 		<input type='text' name='Cantidad' id='Cantidad'>";
						echo '	</td>';
						echo '  </tr>';
						echo '  <tr>';
						echo '	<th valign="top">Comentarios:</th>';
						echo '	<td><textarea style="width:100%" name="observaciones_'.$row->IdCapacitacionCurso.'">'.$row->Observaciones.'</textarea></td>';
						echo '</tr>';
						echo '</table><br />';
						
						}
					}
					echo '<br /><div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
					echo form_close();
				}
				else {
					echo '<table class="tabla" width="672"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay cursos propuestos en tu área</td></tr></table>';	
				}
				echo '<br /><br />';
				echo '<table><tr><td><a href="'.base_url().'index.php/procesos/capacitacion/cursos_propuestos" onmouseover="tip(\'Regresa al listado<br />de cursos propuestos\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a	 href="'.base_url().'index.php/procesos/capacitacion/cursos_propuestos" onmouseover="tip(\'Regresa al listado<br />de cursos propuestos\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
            	?>
            </div>
		</div>
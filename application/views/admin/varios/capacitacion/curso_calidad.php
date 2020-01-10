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
					),
					
					// Fecha
					'fecha' => array (
						'name'		=> 'fecha',
						'id'		=> 'fecha',
						'value'		=> set_value('fecha'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('fecha')",
					),
					// Cantidad
					'cantidad' 		=> array (
						'name'		=> 'cantidad',
						'id'		=> 'cantidad',
						'value'		=> set_value('cantidad'),
						'onfocus'	=> "hover('cantidad')",
					),
					
					
				);

				
					echo form_open();
					echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Establece las condiciones de los Cursos de Capacitación Propuestos</td></tr></table><br />';
						echo '<table class="tabla_form" id="tabla" width="700">';
						echo '<tr>';
						echo '	<th valign="top">Curso:</th>';
						echo '<td>'.form_input($formulario['curso']).'</td></tr>';
						echo '</tr>';
						echo '<tr>';
						echo '	<th valign="top">Financiado por:</th>';
						echo '	<td>';
						echo ' 		<input type="radio" name="tipo" value="Recursos Propios">Recursos Propios<br>';
						echo ' 		<input type="radio" name="tipo" value="Dentro de la Universidad" > Dentro de la Universidad<br>'; 
						echo ' 		<input type="radio" name="tipo" value="Institucion Externa" > Institucion Externa<br>';
						echo ' 		<input type="radio" name="tipo" value="Recurso PIFI" >Recuros PIFI<br>'; 
						echo ' 		<input type="radio" name="tipo" value="Otra" > Otro<br>'; 
						echo '	</td>';
						echo '  </tr>';
						echo ' <tr>';
						echo '	<th valign="top">Fecha Tentativa:</th>';
						?>
						
						<script>
	$(function(){$("#fecha").datepicker({dateFormat: "yy-mm-dd"});
		});
	</script>
	<?
						echo '<td>'.form_input($formulario['fecha']).'</td></tr>';
						
						echo '<tr>';
						echo '	<th valign="top">Cantidad:</th>';
					
						echo '<td>'.form_input($formulario['cantidad']).'</td></tr>';
						echo '	</td>';
						echo '  </tr>';
						echo '  <tr>';
						echo '	<th valign="top">Comentarios:</th>';
						echo '<td>'.form_input($formulario['comentarios']).'</td></tr>';
						echo '</tr>';
						echo '</table><br />';
						
						
					
					echo '<br /><div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
					echo form_close();
				
			
				echo '<br /><br />';
				echo '<table><tr><td><a href="'.base_url().'index.php/procesos/capacitacion/cursos_propuestos" onmouseover="tip(\'Regresa al listado<br />de cursos propuestos\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a	 href="'.base_url().'index.php/procesos/capacitacion/cursos_propuestos" onmouseover="tip(\'Regresa al listado<br />de cursos propuestos\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
            	?>
            </div>
		</div>
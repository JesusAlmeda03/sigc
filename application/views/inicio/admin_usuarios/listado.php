<?php
/****************************************************************************************************
*
*	VIEWS/admin/usuarios/listado.php
*
*		Descripci�n:
*			Vista que muestra todo el listado de usuarios
*
*		Fecha de Creaci�n:
*			27/Octubre/2011
*
*		Ultima actualizaci�n:
*			27/Octubre/2011
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
				$estado_extras = 'id="estado" onfocus="hover(\'estado\')"  style="width:150px;" onchange="form.submit()"';
				echo form_open();
				echo '
		        	<table class="tabla_form" width="700">
		            	<tr>
		            		<th width="100">Estado</th>
		            		<td>'.form_dropdown('estado',$estado_options,$estado,$estado_extras ).'</td>
		            		<td style="width:100px; text-align:center; background-color:#FFF"><a href="'.base_url().'index.php/inicio/agregar_usuario/'.$estado.'" onmouseover="tip(\'Agregar un nuevo<br />usuario a tu &aacute;rea\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/agregar.png" /><br />Nuevo Usuario</a></td>
		            	</tr>
		         	</table><br />
	         	';
	            echo form_close();
				
	            if( $consulta->num_rows() > 0 ) {
	                echo '<table class="tabla" id="tabla" width="700">';
	                echo '<thead><tr><th width="10" class="no_sort"></th>';
					echo '<th>Nombre</th><th>Paterno</th><th>Materno</th><th class="no_sort"></th><th class="no_sort"></th></tr></thead><tbody>';
	                foreach( $consulta->result() as $row ) {
						if( $row->Estado ) {
							$img_estado = '<img onmouseover="tip(\'Usuario Activo\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/terminada.png" />';
							$img_cambia_estado = '<a onclick="pregunta_cambiar( \'usuarios\', '.$row->IdUsuario.', 0, \'&iquest;Deseas eliminar a este usuario?\', \'inicio-administracion_usuarios-'.$estado.'\')" onMouseover="tip(\'Eliminar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
						}
						else {
							$img_estado = '<img onmouseover="tip(\'Usuario Inactivo\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/eliminada.png" />';
							$img_cambia_estado = '<a onclick="pregunta_cambiar( \'usuarios\', '.$row->IdUsuario.', 1, \'&iquest;Deseas activar a este usuario?\', \'inicio-administracion_usuarios-'.$estado.'\')" onMouseover="tip(\'Activar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar.png" /></a>';
						}
	                    echo '<tr>';
	                    echo '<th>'.$img_estado.'</th>';
	                    echo '<td>'.$row->Nombre.'</td>';
	                    echo '<td>'.$row->Paterno.'</td>';
	                    echo '<td>'.$row->Materno.'</td>';
						echo '<td width="24"><a href="'.base_url().'index.php/inicio/modificar_usuario/'.$row->IdUsuario.'/'.$estado.'" onMouseover="tip(\'Modificar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';					
						echo '<td width="24">'.$img_cambia_estado.'</td>';
	                    echo '</tr>';
	                }
	                echo '</tbody></table>';
					echo $sort_tabla;
	            }
	            else {
					echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay usuarios</td></tr></table>';
	            }
	            ?>
            </div>
		</div>
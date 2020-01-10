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
    <div class="cont_admin">
    	<div class="titulo"><?=$titulo?></div>
        <div class="texto">
			<?php
			$area_extras = 'id="area" onfocus="hover(\'area\')"  style="width:350px;" onchange="form.submit()"';
			$estado_extras = 'id="estado" onfocus="hover(\'estado\')"  style="width:150px;" onchange="form.submit()"';
			echo form_open();
			echo '
	        	<table class="tabla_form" width="980">
	            	<tr><th width="100">&Aacute;rea</th><td>'.form_dropdown('area',$area_options,$area,$area_extras).'</td></tr>
	            	<tr><th width="100">Estado</th><td>'.form_dropdown('estado',$estado_options,$estado,$estado_extras ).'</td></tr>
	         	</table><br />
         	';
            echo form_close();
			
            if( $consulta->num_rows() > 0 ) {
                echo '<table class="tabla" id="tabla" width="980">';
                echo '<thead><tr><th width="10" class="no_sort"></th>';
				if( $area == "todos")
					echo '<th>&Aacute;rea</th>';
				echo '<th>Nombre</th><th>Paterno</th><th>Materno</th><th>Correo</th><th>Usuario</th>';
				if( !$this->session->userdata( 'ADI' ) ) {
					if( $this->session->userdata( 'nombre' ) == 'Rogelio Castañeda Andrade' || $this->session->userdata( 'nombre' ) == 'Jesús Carlos Almeda Macias' ) {
						echo '<th class="no_sort"></th>';
					}
					echo '<th class="no_sort"></th><th class="no_sort"></th><th class="no_sort"></th>';
				}
				echo '</tr></thead><tbody>';
                foreach( $consulta->result() as $row ) {
					if( $row->Estado ) {
						$img_estado = '<img onmouseover="tip(\'Usuario Activo\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/terminada.png" />';
						$img_cambia_estado = '<a onclick="pregunta_cambiar( \'usuarios\', '.$row->IdUsuario.', 0, \'&iquest;Deseas eliminar a este usuario?\', \'usuarios-listado-'.$area.'-'.$estado.'\')" onMouseover="tip(\'Eliminar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
					}
					else {
						$img_estado = '<img onmouseover="tip(\'Usuario Inactivo\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/eliminada.png" />';
						$img_cambia_estado = '<a onclick="pregunta_cambiar( \'usuarios\', '.$row->IdUsuario.', 1, \'&iquest;Deseas activar a este usuario?\', \'usuarios-listado-'.$area.'-'.$estado.'\')" onMouseover="tip(\'Activar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar.png" /></a>';
					}
                    echo '<tr>';
                    echo '<th>'.$img_estado.'</th>';
					if( $area == "todos") echo '<td>'.$row->Area.'</td>';
                    echo '<td>'.$row->Nombre.'</td>';
                    echo '<td>'.$row->Paterno.'</td>';
                    echo '<td>'.$row->Materno.'</td>';
                    echo '<td>'.$row->Correo.'</td>';
                    echo '<td>'.$row->Usuario.'</td>';
					if( !$this->session->userdata( 'ADI' ) ) {
						if( $this->session->userdata( 'nombre' ) == 'Rogelio Castañeda Andrade' || $this->session->userdata( 'nombre' ) == 'Jesús Carlos Almeda Macias'  ) {
							echo '<td width="24"><a href="'.base_url().'index.php/admin/usuarios/sesion_usuario/'.$row->IdUsuario.'" target="_blank" onMouseover="tip(\'Iniciar sesión como este usuario\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/small/account.png" /></a></td>';
						}
						echo '<td width="24"><a href="'.base_url().'index.php/admin/usuarios/expediente/'.$row->IdUsuario.'/listado-'.$area.'-'.$estado.'" onMouseover="tip(\'Expediente\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/small/archivo.png" /></a></td>';
						echo '<td width="24"><a href="'.base_url().'index.php/admin/usuarios/modificar_usuario/'.$row->IdUsuario.'/listado-'.$area.'-'.$estado.'" onMouseover="tip(\'Modificar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';					
						echo '<td width="24">'.$img_cambia_estado.'</td>';
					}
                    echo '</tr>';
                }
                echo '</tbody></table>';
				echo $sort_tabla;
            }
            else {
            	if( $area == 'elige' ) {
                	echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Elige una opci&oacute;n para ver a los usuarios</td></tr></table>';
                }
				else {
					echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay usuarios</td></tr></table>';
				}
            }
            ?>
        </div>
    </div>
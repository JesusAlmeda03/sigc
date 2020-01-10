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
			echo form_open();
			echo '
	        	<table class="tabla_form" width="980">
	            	<tr><th width="100">&Aacute;rea</th><td>'.form_dropdown('area',$area_options,$are,$area_extras).'</td></tr>
	         	</table><br />
         	';
            echo form_close();
			
			if( $consulta ) {
				$i = 1;
				echo '<table class="tabla" id="tabla" width="980">';
				echo '<thead><tr>';
				if( $are == 'todos' ) echo '<th class="text_form" style="letter-spacing:0; font-size:11px; text-align:center">&Aacute;rea</th>';
				echo '<th class="text_form" width="150" style="letter-spacing:0; font-size:11px; text-align:center">Nombre</th>';
				if( $permisos->num_rows() > 0 ) {
					foreach( $permisos->result() as $row )
						echo '<th class="text_form" width="80" style="letter-spacing:0; font-size:11px; text-align:center">'.$row->Permiso.'</th>';
				}
				echo '<th class="no_sort" width="15"></th></thead><tbody>';	
				foreach( $consulta as $usuario => $permisos ) {
					$columnas = array('',false,false,false,false,false,false,false,false,false,false,false,false,false);
					foreach( $permisos as $per ) {
						$area = $per['area'];
						$ida = $per['ida'];
						$idu = $per['idu'];
						$columnas[$per['permiso']] = true;
					}
					echo '<tr>';
					if( $are == 'todos' ) echo '<th style="width:150px; text-align:left; color:#000">'.$area.'</th>';
					echo '<th style="text-align:left; color:#000">'.$usuario.'</th>';
					for( $i = 1; $i <= 13; $i++ ){
						if( $columnas[$i] == true )
							echo '<td class="sort_imagen" style="text-align:center"><a href="'.base_url().'index.php/admin/usuarios/quitar_permisos/'.$idu.'/'.$i.'/'.$usu.'/'.$are.'" onmouseover="tip(\'Quitar Permiso\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/star_full.png" /></a></td>';
						else
							echo '<td class="sort_imagen" style="text-align:center"><a href="'.base_url().'index.php/admin/usuarios/asignar_permisos/'.$idu.'/'.$i.'/'.$usu.'/'.$are.'" onmouseover="tip(\'Otorgar Permiso\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/star_empty.png" /></a></td>';
					}
					echo '<td><a onclick="pregunta_cambiar( \'usuarios_especiales\', '.$idu.', 0, \'&iquest;Deseas quitarle todos los permisos a este usuario?\', \'usuarios-especiales-todos-'.$are.'\')" onMouseover="tip(\'Eliminar\')" onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';
					echo '</tr>';
					$i++;
				}
				echo '</tbody></table>';
				echo $sort_tabla;
			}
			else {
            	if( $are == 'elige' ) {
                	echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Elige una opci&oacute;n para ver a los usuarios</td></tr></table>';
                }
				else {
					echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay usuarios</td></tr></table>';
				}
            }
            ?>
        </div>
    </div>
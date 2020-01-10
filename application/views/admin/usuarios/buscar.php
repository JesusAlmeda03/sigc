<?php
/****************************************************************************************************
*
*	VIEWS/admin/usuarios/buscar.php
*
*		Descripci�n:
*			Vista para buscar usuarios
*
*		Fecha de Creaci�n:
*			23/Octubre/2011
*
*		Ultima actualizaci�n:
*			23/Octubre/2011
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
			$style_are = $style_nom = $style_pat = $style_mat = $style_usu = "";
			$style = 'border:1px solid #CC0000;';
			if( $are != "" ) $style_are = $style;
			if( $nom != "" ) $style_nom = $style;
			if( $pat != "" ) $style_pat = $style;
			if( $mat != "" ) $style_mat = $style;
			if( $usu != "" ) $style_usu = $style;
			
            // Area		
            $area_extras = 'id="area" onfocus="hover(\'area\')" style="width:200px; '.$style_are.'"';
            $formulario = array(
                // Boton submit
                'boton' => array (
                    'id'		=> 'aceptar',
                    'name'		=> 'aceptar',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'aceptar\')',					
                ),
                // Nombre
                'nombre' => array (
                    'name'		=> 'nombre',
                    'id'		=> 'nombre',
                    'value'		=> $nom,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('nombre')",
					'style'		=> $style_nom,
                ),
                // Paterno
                'paterno' => array (
                    'name'		=> 'paterno',
                    'id'		=> 'paterno',
                    'value'		=> $pat,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('paterno')",
					'style'		=> $style_pat,
                ),
                // Materno
                'materno' => array (
                    'name'		=> 'materno',
                    'id'		=> 'materno',
                    'value'		=> $mat,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('materno')",
					'style'		=> $style_mat,
                ),
                // Usuario
                'usuario' => array (
                    'name'		=> 'usuario',
                    'id'		=> 'usuario',
                    'value'		=> $usu,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('usuario')",
					'style'		=> $style_usu,
                ),			
            );
			echo '<table width="952"><tr><td width="350" valign="top">';
            echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
            echo '<table class="tabla_form" width="340">';
            echo '<tr><th class="text_form" width="50">&Aacute;rea: </th>';
            echo '<td>'.form_dropdown('area',$area_options,$are,$area_extras).'</td></tr>';
            echo '<tr><th class="text_form" width="50">Nombre: </th>';
            echo '<td>'.form_input($formulario['nombre']).'</td></tr>';
            echo '<tr><th class="text_form" width="50">Apellido Paterno: </th>';
            echo '<td>'.form_input($formulario['paterno']).'</td></tr>';
            echo '<tr><th class="text_form" width="50">Apellido Materno: </th>';
            echo '<td>'.form_input($formulario['materno']).'</td></tr>';
            echo '<tr><th class="text_form" width="50">Usuario: </th>';
            echo '<td>'.form_input($formulario['usuario']).'</td></tr>';
            echo '</table><br />';
            echo '<div style="width:350px; text-align:center;">'.form_submit($formulario['boton'],'Buscar').'<input type="button" name="limpiar" value="Limpiar" id="limpiar" class="in_button" onfocus="hover(\'limpiar\')" style="margin-left:10px" onclick="location.href=\''.base_url().'index.php/admin/usuarios/buscar/0\'"  /></div>';
            echo form_close();
			echo '</td>';
			echo '<td valign="top">';
			if( $busqueda ) {
				if( $consulta->num_rows() > 0 ) {
					echo '<table class="tabla" id="tabla" width="625">';
					echo '<thead><tr><th widht="5" class="no_sort"></th>';
					if( $are == 'all')
						echo '<th>&Aacute;rea</th>';
					echo '<th>Nombre</th><th>Paterno</th><th>Materno</th>';
					if( $this->session->userdata( 'nombre' ) == 'Rogelio Castañeda Andrade' || $this->session->userdata( 'nombre' ) == 'Jesús Carlos Almeda Macias' ) {
						echo '<th class="no_sort"></th>';
					}
					echo '<th class="no_sort"></th><th class="no_sort"></th><th class="no_sort"></th></tr></thead><tbody>';
					foreach( $consulta->result() as $row ) :
						if( $row->Estado ) {
							$img_estado = '<img onmouseover="tip(\'Usuario Activo\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/terminada.png" />';
							$img_cambia_estado = '<a onclick="pregunta_cambiar( \'usuarios\', '.$row->IdUsuario.', 0, \'&iquest;Deseas eliminar a este usuario?\', \'usuarios-buscar\')" onMouseover="tip(\'Eliminar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
						}
						else {
							$img_estado = '<img onmouseover="tip(\'Usuario Inactivo\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/eliminada.png" />';
							$img_cambia_estado = '<a onclick="pregunta_cambiar( \'usuarios\', '.$row->IdUsuario.', 1, \'&iquest;Deseas activar a este usuario?\', \'usuarios-buscar\')" onMouseover="tip(\'Activar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar.png" /></a>';
						}
						echo '<tr><th>'.$img_estado.'</th>';
						if( $are == 'all' ) echo '<td>'.$row->Area.'</td>';
						echo '<td>'.$row->Nombre.'</td><td>'.$row->Paterno.'</td><td>'.$row->Materno.'</td>';
						if( $this->session->userdata( 'id_usuario' ) == '638' ) {
							echo '<td width="24"><a href="'.base_url().'index.php/admin/usuarios/sesion_usuario/'.$row->IdUsuario.'" target="_blank" onMouseover="tip(\'Iniciar sesión como este usuario\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/small/account.png" /></a></td>';
						}
						echo '<td width="24"><a href="'.base_url().'index.php/admin/usuarios/expediente/'.$row->IdUsuario.'/buscar" onMouseover="tip(\'Expediente\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/small/archivo.png" /></a></td>';
						echo '<td width="24"><a href="'.base_url().'index.php/admin/usuarios/modificar_usuario/'.$row->IdUsuario.'/buscar" onMouseover="tip(\'Modificar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
						echo '<td width="24">'.$img_cambia_estado.'</td>';
						echo '</tr>';
					endforeach;
					echo '</tbody></table>';
					echo $sort_tabla;
				}
				else {
	                echo '<table class="tabla" width="600"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>No se encontraron coincidencias con la b&uacute;squeda</td></tr></table>';
				}
			}
			echo '</td></tr></table>';
            ?>            
        </div>
    </div>
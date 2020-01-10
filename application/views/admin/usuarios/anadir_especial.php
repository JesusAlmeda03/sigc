<?php
/****************************************************************************************************
*
*	VIEWS/admin/usuarios/anadir_especial.php
*
*		Descripci�n:
*			Vista para a�adir usuarios especiales
*
*		Fecha de Creaci�n:
*			04/Noviembre/2011
*
*		Ultima actualizaci�n:
*			04/Noviembre/2011
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
			$style = 'border:1px solid #007799;';
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
					echo '<thead><tr><th widht="15" class="no_sort"></th>';
					if( $are == 'all')
						echo '<th>&Aacute;rea</th>';
					echo '<th>Nombre</th><th>Paterno</th><th>Materno</th><th class="no_sort"></th></tr></thead><tbody>';
					foreach( $consulta->result() as $row ) :
						echo '<tr><th></th>';
						if( $are == 'all' )
							echo '<td>'.$row->Area.'</td>';
						echo '<td>'.$row->Nombre.'</td><td>'.$row->Paterno.'</td><td>'.$row->Materno.'</td>';
						if( $row->IdPermiso != "" )
							echo '<td class="sort_imagen" style="text-align:center"><a href="'.base_url().'index.php/admin/usuarios/especiales/'.$row->IdUsuario.'/0" onmouseover="tip(\'Este usuario ya tiene<br />Permisos Especiales\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/star_full.png" /></a></td>';
						else
							echo '<td class="sort_imagen" style="text-align:center"><a href="'.base_url().'index.php/admin/usuarios/asignar_permisos/'.$row->IdUsuario.'/0/'.$usu.'/'.$are.'" onmouseover="tip(\'Otorgar Permisos\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/star_empty.png" /></a></td>';
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
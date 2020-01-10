<?php
/****************************************************************************************************
*
*	VIEWS/admin/usuarios/jerarquias.php
*
*		Descripcián:
*			Asigna las jerarquias de los usuarios
*
*		Fecha de Creación:
*			08/Octubre/2012
*
*		Ultima actualización:
*			08/Octubre/2012
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
            // Area		
            $area_extras = 'id="area" onfocus="hover(\'area\')" onchange="form.submit()"';
			
			// Usuarios
			$usuarios_extras = 'id="usuarios" onfocus="hover(\'usuarios\')" style="width:410px" onchange="form.submit()"';
			
			// Formulario areas
            $formulario = array(
                // * Boton submit
                'boton' => array (
                    'id'		=> 'aceptar',
                    'name'		=> 'aceptar',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'aceptar\')'
                ),				
            );
            echo form_open();
			
            echo '<table class="tabla_form" width="980">';
            echo '<tr><th class="text_form" width="100">Elige el &Aacute;rea: </th>';
            echo '<td>'.form_dropdown('area',$areas,$area,$area_extras).'</td></tr>';
			echo '</table><br />';
			
			echo '<table><tr><td valign="top">';
			if( $area != 'elige' ) {
				echo '<table class="tabla_form" width="420">';
	            echo '<tr><th class="text_form" style="text-align:left">Elige el Usuario: </th></tr>';
	            echo '<tr><td>'.form_dropdown('usuarios',$usuarios,$usuario,$usuarios_extras).'</td></tr>';
				echo '</table><br />';
				
				echo '</td><td>';
				if( $subordinados ) {
	                echo '<table class="tabla" id="tabla" style="width:550px;">';
	                echo '<thead>';
					echo '<tr><th colspan="4" style="text-align:center;font-size:14px">Usuarios ya Asignados a este Usuario</th></tr>';
					echo '<tr><th>Nombre</th><th width="15"></th></tr></thead><tbody>';
	                foreach( $subordinados->result() as $row ) {
	                    echo '<tr>';
	                    echo '<td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.'</td>';
						echo '<td><a onclick="pregunta_cambiar( \'usuarios_jerarquias\', '.$row->IdUsuario.', 0, \'&iquest;Deseas quitar a este usuario de la lista?\', \'usuarios-jerarquias-'.$area.'-'.$usuario.'\')" onMouseover="tip(\'Eliminar de la lista<br />de este usuario\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
	                    echo '</tr>';
	                }
	                echo '</tbody></table><br />';
	            }
				
				if( $usuarios_asignar ) {
	                echo '<table class="tabla" id="tabla" style="width:550px;">';
	                echo '<thead>';
					echo '<tr><tr><th colspan="4" style="text-align:center;font-size:14px">Usuarios posibles a Asignar para este Usuario</th></tr>';
					echo '<tr><th></th><th>Nombre</th></tr></thead><tbody>';
	                foreach( $usuarios_asignar->result() as $row ) {
	                    echo '<tr>';
	                    echo '<td>'.form_checkbox('usuario-sub[]', $row->IdUsuario, false, 'id="usuario-sub_'.$row->IdUsuario.'"').'</td>';
	                    echo '<td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.'</td>';
	                    echo '</tr>';
	                }
	                echo '</tbody></table><br />';
					echo '<div style="padding-left:230px">'.form_submit($formulario['boton'],'Asignar').'</div>';
	            }
			}
			echo '</td></tr></table>';
			echo form_close();
            ?>
        </div>
    </div>
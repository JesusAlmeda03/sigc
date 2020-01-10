<?php
/****************************************************************************************************
*
*	VIEWS/admin/aduditorias/qeuipos.php
*
*		Descripción:
*			Vista para generar los equipos
*
*		Fecha de Creación:
*			23/Octubre/2012
*
*		Ultima actualizaciÓn:
*			23/Octubre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
?>          
    <div class="cont_admin">
    	<div class="titulo"><?=$titulo_pagina?></div>
        <div class="texto">
        	<script>
        	function selecciona( id ) {
        		document.getElementById( 'usuario_' + id ).checked = true;
        	}
        	</script>
        	<?php
        	$formulario = array(
                // * Boton submit
                'boton' => array (
                    'id'		=> 'aceptar',
                    'name'		=> 'aceptar',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'aceptar\')'
                ),
                // Nombre Equipo
                'equipo' => array (
                    'name'		=> 'equipo',
                    'id'		=> 'equipo',
                    'value'		=> $equipo,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('equipo')",
                ),
            );
			
			// Auditores
			if( $auditores->num_rows() > 0 ) {
				echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table class="tabla_form" width="980">';
				echo '<tr><th width="150">Nombre del Equipo:</th><td>'.form_input($formulario['equipo']).'</td></tr>';
				echo '</table><br />';
				echo '<table class="tabla_form" width="980">';
				foreach( $auditores->result() as $row ) {
					echo '<tr>';
					echo '<th width="15"><input type="checkbox" id="usuario_'.$row->IdUsuario.'" name="usuario[]" value="'.$row->IdUsuario.'" /></th>';
					echo '<td>';
					echo '<select id="tipo_'.$row->IdUsuario.'" name="tipo_'.$row->IdUsuario.'" onfocus="hover(\'tipo_'.$row->IdUsuario.'\')" style="width:210px; margin-right:10px" onclick="selecciona('.$row->IdUsuario.')">';
					echo '	<option value="Jefe de Equipo Auditor">Auditor Lider</option>';
					echo '	<option value="Auditor Interno" selected="selected">Auditor Interno</option>';
					echo '	<option value="Auditor en Entrenamiento">Auditor en Entrenamiento</option>';
					echo '</select>';
					echo $row->Nombre.' '.$row->Paterno.' '.$row->Materno.' ('.$row->Area.')</td>';
					echo '</tr>';
				}
				echo '</table>';
            	echo '<br />';
            	echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
            	echo form_close();
			}
			else {
				echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay ningun auditor disponible</td></tr></table>';
			}

			// Equipos
			if( $equipos->num_rows() > 0 ) {
				$id_equipo = '';
				echo '<br /><table class="tabla_form" width="980">';
				foreach( $equipos->result() as $row ) {
					if( $id_equipo == $row->IdEquipo) {
						echo '<tr><td width="180" style="background-color:#EAECEE;">Auditor '.$row->Tipo.'</td><td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.' ('.$row->Area.')</td></tr>';
					}
					else {
						if( $id_equipo != '' ) {
							echo '</table>';
						}
						$id_equipo = $row->IdEquipo;
						echo '<br /><table class="tabla_form" width="980">';
						echo '<tr><th colspan="2">'.$row->Equipo.'</th></tr>';
						echo '<tr><td width="180" style="background-color:#EAECEE;">Auditor '.$row->Tipo.'</td><td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.' ('.$row->Area.')</td></tr>';
					}
				}
				echo '</table>';
			}
			echo '<br /><br />';
			if( $ano == 'especifico' ) {
				echo '<table><tr><td><a href="'.base_url().'index.php/admin/auditorias/especifico/'.$id_auditoria.'" onmouseover="tip(\'Regresa al Programa Espec&iacute;fico de Auditor&iacute;as\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/admin/auditorias/especifico/'.$id_auditoria.'" onmouseover="tip(\'Regresa al Programa Espec&iacute;fico de Auditor&iacute;as\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
			}
			else {
				echo '<table><tr><td><a href="'.base_url().'index.php/admin/auditorias/programa_especifico/'.$ano.'/'.$auditoria.'/'.$estado.'" onmouseover="tip(\'Regresa al Programa Anual de Auditor&iacute;as\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/admin/auditorias/programa_especifico/'.$ano.'/'.$auditoria.'/'.$estado.'" onmouseover="tip(\'Regresa al Programa Anual de Auditor&iacute;as\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
			}
            ?>
        </div>
    </div>
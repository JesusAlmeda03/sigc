<?php
/****************************************************************************************************
*
*	VIEWS/procesos/solicitudes/lista_distribucion.php
*
*		Descripci�n:
*			Vista para elegir la lista de distribucion de la solicitud
*
*		Fecha de Creaci�n:
*			24/Noviembre/2011
*
*		Ultima actualizaci�n:
*			24/Noviembre/2011
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
            <script>
			j = true;
			
			function todos() {
				if( j ) {
					j = false;
					seleccionar_todo();
				}
				else {
					j = true;
					deseleccionar_todo();
				}
			}
			
			function seleccionar_todo(){ 
			   for( i = 0; i < document.formulario.elements.length; i++ ) 
				  if( document.formulario.elements[i].type == "checkbox" )	
					 document.formulario.elements[i].checked = 1;
			}
			
			function deseleccionar_todo(){ 
			   for( i = 0; i < document.formulario.elements.length; i++ )
				  if( document.formulario.elements[i].type == "checkbox" )	
					 document.formulario.elements[i].checked = 0;
			}
			
			function lista_distribucion( i ) {
				document.getElementById('distribucion_' + i).checked = 1;
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
                // * Boton submit
                'boton_continuar' => array (
                    'id'		=> 'boton_continuar',
                    'name'		=> 'boton_continuar',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'boton_continuar\')',
					'style'		=> 'width:150px; height:55px;',
					'onclick'	=> 'location.href = \''.base_url().'\'',
				),
			);
			if( $usuarios->num_rows() > 0 ) {
				$j = 1;
				echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table class="tabla_form" style="width:200px; margin-left:780px"><tr><td><input type="checkbox" name="all" onclick="todos()" /></td><td>Seleccionar a todos para la lista de distribuci&oacute;n</td></tr></table><br />';
				echo '<table class="tabla" id="tabla" width="980">';
				echo '<thead><tr><th class="no_sort"></th><th>Nombre</th><th width="50" class="no_sort">Lista de Distribucion</th>';
				if( !$solicitador ) {
					echo '<th width="50" class="no_sort">Solicitador</th>';
				}
				if( !$autorizador ) {
					echo '<th width="50" class="no_sort">Autorizador</th>';
				}
				echo '</tr></thead><tbody>';
				foreach( $usuarios->result() as $row ) {
					$lista = true;
					
					// revisa que no este ya en la lista de distribuci�n
					if( $lista_distribucion->num_rows() > 0 ) {
						foreach ( $lista_distribucion->result() as $row_lista ) {
							if( $row_lista->IdUsuario == $row->IdUsuario ) {
								$lista = false;
							}
						}
					}
					
					// si no esta, muestra a l usuario
					if( $lista ) {
						if( $j ) {
							echo '<tr>';
							$j = 0;
						}
						else {
							echo '<tr class="odd">';
							$j = 1;
						}
						echo '	<td></td>';
						echo '	<td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.'</td>';
						$distribucion = 'id="distribucion_'.$row->IdUsuario.'"';
						$sol_aut = 'onclick="lista_distribucion('.$row->IdUsuario.')"';
						echo '	<td style="text-align:center">'.form_checkbox('distribucion[]', $row->IdUsuario, false, $distribucion).'</td>';
						if( !$solicitador ) {
							echo '	<td style="text-align:center">'.form_radio('solicitador', $row->IdUsuario, false, $sol_aut).'</td>';
						}
						if( !$autorizador ) {
							echo '	<td style="text-align:center">'.form_radio('autorizador', $row->IdUsuario, false, $sol_aut).'</td>';
						}
						echo '</tr>';
					}
				}
				echo '</tbody></table><br />';
				echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
				echo form_close();
			}
			else {
                echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>No se han encontrado usuarios disponibles para agregar a la lista de distribuci&oacute;n.</td></tr></table><br /><br />';
				echo '<div style="width:980px; text-align:center;">'.form_button($formulario['boton_continuar'],'Continuar').'</div>';
			}
			
			// si viene redirigido del listado de solicitudes
			if( $etapa ) {
				echo '<table><tr><td><a href="'.base_url().'index.php/procesos/solicitudes/ver_lista_distribucion/'.$id.'/'.$etapa.'" onmouseover="tip(\'Regresa a la lista de distribuci&oacute;n\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/procesos/solicitudes/ver_lista_distribucion/'.$id.'/'.$etapa.'" onmouseover="tip(\'Regresa a la lista de distribuci&oacute;n\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
			}
            ?>
        </div>
    </div>
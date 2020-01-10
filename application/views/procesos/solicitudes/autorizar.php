<?php
/****************************************************************************************************
*
*	VIEWS/procesos/solicitudes/autorizar.php
*
*		Descripci�n:
*			Vista para autorizar las solicitudes
*
*		Fecha de Creaci�n:
*			04/Enero/2012
*
*		Ultima actualizaci�n:
*			04/Enero/2012
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
					// Nombre
					'observaciones' => array (					
						'id'		=> 'observaciones',
						'value'		=> set_value('observaciones'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('observaciones')",
						'style'		=> 'width:250px',
					),
	                // * Boton submit
	                'boton_aceptar' => array (
	                    'id'		=> 'boton_aceptar',
	                    'name'		=> 'boton_aceptar',
	                    'class'		=> 'in_button',
	                    'onfocus'	=> 'hover(\'boton_aceptar\')'
					),
	                // * Boton submit
	                'boton_rechazar' => array (
	                    'id'		=> 'boton_rechazar',
	                    'name'		=> 'boton_rechazar',
	                    'class'		=> 'in_button',
	                    'onfocus'	=> 'hover(\'boton_rechazar\')',
						'style'		=> 'margin-left:10px',				
					),
				);
				if( $solicitudes->num_rows() > 0 ) {
					echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Marca el cuadro de la primera columna para seleccionar las solicitudes.</td></tr></table><br />';
					echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
					echo '<table class="tabla" id="tabla" width="700">';
					echo '<thead><tr>';
					echo '<th class="no_sort" width="15"></th>';
					echo '<th class="no_sort" style="width:5px"></th>';
					echo '<th width="60">C&oacute;digo del Documento</th>';
					echo '<th width="150">Nombre del Documento</th>';
					if( $autorizador != 'revisar' )
						echo '<th>Escribe aqui las Observaciones</th>';
					echo '<th class="no_sort" width="15"></th>';
					echo '</tr></thead><tbody>';
	                foreach( $solicitudes->result() as $row ) {
						// tipo de solicitud
						switch( $row->Solicitud ) {
							case "Alta" :
								$img_tip = '<img src="'.base_url().'includes/img/icons/alta.png" onmouseover="tip(\'Solicitud de Alta\')" onmouseout="cierra_tip()" />';
								break;
								
							case "Baja" :
								$img_tip = '<img src="'.base_url().'includes/img/icons/baja.png" onmouseover="tip(\'Solicitud de Baja\')" onmouseout="cierra_tip()" />';
								break;
								
							case "Modificacion" :
								$img_tip = '<img src="'.base_url().'includes/img/icons/modificacion.png" onmouseover="tip(\'Solicitud de Modificaci&oacute;n\')" onmouseout="cierra_tip()" />';
								break;						
						}
	
						$solicitud = 'id="solicitud_'.$row->IdSolicitud.'"';
						echo '<tr>';					
						echo '<th style="text-align:center">'.form_checkbox('solicitud[]', $row->IdSolicitud, false, $solicitud).'</th>';
						echo '<th>'.$img_tip.'</th>';
						echo '<td>'.$row->Codigo.'</td>';
						echo '<td>'.$row->Nombre.'</td>';
						if( $autorizador != 'revisar' ) {
							echo '<td>';
							if( $row->Observaciones != '' )
								echo $row->Observaciones.'<br /><br />_ _ _ _ _ _ _ _ _ _<br /><br /><strong>Escribe aqui tus observaciones: </strong>';
							echo '<input id="observaciones_'.$row->IdSolicitud.'" onfocus="hover(\'observaciones_'.$row->IdSolicitud.'\')" class="in_text" type="text" value="" name="observaciones_'.$row->IdSolicitud.'"><input style="display:none" id="observaciones_old" type="text" value="'.$row->Observaciones.'" name="observaciones_old_'.$row->IdSolicitud.'"></td>';
						}					
						echo '<td><a href="'.base_url().'index.php/procesos/solicitudes/ver/'.$row->IdSolicitud.'/'.$autorizador.'" onmouseover="tip(\'Ver solicitud\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
					}
					echo '</tbody></table><br />';
					echo $sort_tabla;
					echo '<div style="width:700px; text-align:center;">';
					echo form_submit($formulario['boton_aceptar'],'Aceptar');
					if( $autorizador != 'revisar' ) 
						echo form_submit($formulario['boton_rechazar'],'Rechazar');
					echo '</div>';
					echo form_close();
				}
				else {
	                echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no tiene solicitudes pendientes para aprobar.</td></tr></table><br /><br />';
				}
	            ?>
	        </div>
	    </div>
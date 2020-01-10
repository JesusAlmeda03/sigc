<?php
/****************************************************************************************************
*
*	VIEWS/procesos/solicitudes/rechazadas.php
*
*		Descripción:
*			Vista del listado de las solicitudes rechazadas
*
*		Fecha de Creación:
*			09/Enero/2011
*
*		Ultima actualización:
*			09/Enero/2011
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
                'boton_restaurar' => array (
                    'id'		=> 'boton_restaurar',
                    'name'		=> 'boton_restaurar',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'boton_restaurar\')'
				),                
			);
							
                if( $solicitudes->num_rows() > 0 ) {
                	echo '<table class="tabla" width="700"><tr><th width="20" valign="top"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>En la columna Observaciones puedes ver las causas por las que se ha rechazado la solicitud</td></tr></table><br />';
                	echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
					echo '<table class="tabla" id="tabla" width="700">';
					echo '<thead><tr>';
					echo '<th class="no_sort" width="15"></th>';
					echo '<th class="no_sort" style="width:5px"></th>';
					echo '<th width="60">C&oacute;digo</th>';
					echo '<th width="60">Fecha</th>';
					echo '<th>Observaciones</th>';
					echo '<th class="no_sort" width="15"></th>';
					echo '<th class="no_sort" width="15"></th>';
					// Responsable de Solicitudes
					if( $this->session->userdata('SOL') ) { 
						echo '<th class="no_sort" width="15"></th>';
						echo '<th class="no_sort" width="15"></th>';
					}
					echo '</tr></thead><tbody>';
                    foreach( $solicitudes->result() as $row ) :						
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
						
						// definen las acciones segun el estado de la solicitud
						switch( $row->Estado ) {
							// pendientes
							case 0 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/pendiente.png" onmouseover="tip(\'Solicitud pendiente\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\','.$row->IdSolicitud.',5,\'&iquest;Deseas eliminar esta solicitud?<br />Si lo haces se eliminaran todas las autorizaciones realizadas por la Lista de Distribuci&oacute;n\',\'procesos-solicitudes-rechazadas\')" onmouseover="tip(\'Eliminar solicitud\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;
								
							// aceptadas por el solicitador
							case 1 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/pendiente.png" onmouseover="tip(\'Solicitud pendiente\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\','.$row->IdSolicitud.',5,\'&iquest;Deseas eliminar esta solicitud?<br />Si lo haces se eliminaran todas las autorizaciones realizadas por la Lista de Distribuci&oacute;n\',\'procesos-solicitudes-rechazadas\')" onmouseover="tip(\'Eliminar solicitud\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;
								
							// aceptadas por el autorizador
							case 2 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/pendiente.png" onmouseover="tip(\'Solicitud pendiente\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\','.$row->IdSolicitud.',5,\'&iquest;Deseas eliminar esta solicitud?<br />Si lo haces se eliminaran todas las autorizaciones realizadas por la Lista de Distribuci&oacute;n\',\'procesos-solicitudes-rechazadas\')" onmouseover="tip(\'Eliminar solicitud\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;							
							
							// aceptadas por coodrinacion de calidad
							case 3 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/terminada.gif" onmouseover="tip(\'Solicitud pendiente\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\','.$row->IdSolicitud.',5,\'&iquest;Deseas eliminar esta solicitud?<br />Si lo haces se eliminaran todas las autorizaciones realizadas por la Lista de Distribuci&oacute;n\',\'procesos-solicitudes-rechazadas\')" onmouseover="tip(\'Eliminar solicitud\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;
								
							// rechazadas
							case 4 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/eliminada.png" onmouseover="tip(\'Solicitud rechazada\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\','.$row->IdSolicitud.',5,\'&iquest;Deseas eliminar esta solicitud?<br />Si lo haces se eliminaran todas las autorizaciones realizadas por la Lista de Distribuci&oacute;n\',\'procesos-solicitudes-rechazadas\')" onmouseover="tip(\'Eliminar solicitud\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;
								
							// eliminadas
							case 5 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/eliminada.png" onmouseover="tip(\'Solicitud eliminada\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\','.$row->IdSolicitud.',0,\'&iquest;Deseas restaurar esta solicitud?\',\'procesos-solicitudes-rechazadas\')" onmouseover="tip(\'Restaurar solicitud\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ok2.gif" /></a>';
								break;
						}
						$solicitud = 'id="solicitud_'.$row->IdSolicitud.'"';
                        echo '<tr>';
						echo '<th valign="top">'.form_checkbox('solicitud[]', $row->IdSolicitud, false, $solicitud).'</th>';
						echo '<th valign="top">'.$img_tip.'</th>';
						echo '<td valign="top">'.$row->Codigo.'</td>';
						echo '<td valign="top">'.$row->Fecha.'</td>';
						echo '<td valign="top">'.$row->Observaciones.'<br /><br />_ _ _ _ _ _ _ _ _ _<br /><br /><strong>Escribe aqui tus observaciones: </strong><input id="observaciones" class="in_text" type="text" value="" name="observaciones_'.$row->IdSolicitud.'"><input style="display:none" id="observaciones_old" type="text" value="'.$row->Observaciones.'" name="observaciones_old_'.$row->IdSolicitud.'"></td>';
						echo '<td valign="top"><a href="'.base_url().'index.php/procesos/solicitudes/ver_lista_distribucion/'.$row->IdSolicitud.'/rechazadas" onmouseover="tip(\'Ver lista de distribuci&oacute;n\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/users.png" /></a></td>';
						echo '<td valign="top"><a href="'.base_url().'index.php/procesos/solicitudes/ver/'.$row->IdSolicitud.'/rechazadas" onmouseover="tip(\'Ver solicitud\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
						if( $this->session->userdata('SOL') ) {
							echo '<td valign="top"><a href="'.base_url().'index.php/procesos/solicitudes/modificar/'.$row->IdSolicitud.'/rechazadas" onmouseover="tip(\'Modificar solicitud\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
							echo '<td valign="top">'.$img_cam.'</td>';
						}
                    endforeach;
					echo '</tbody></table><br />';
					echo $sort_tabla;
					echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton_restaurar'],'Restaurar').'</div>';
					echo form_close();
                }
                else {
                    echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay solicitudes rechazadas</td></tr></table>';					
                }
                ?>
        </div>
    </div>
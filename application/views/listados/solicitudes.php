<?php
/****************************************************************************************************
*
*	VIEWS/misc/listados/solicitudes.php
*
*		Descripci�n:
*			Vista del listado de las solicitudes
*
*		Fecha de Creaci�n:
*			25/Noviembre/2011
*
*		Ultima actualizaci�n:
*			28/Noviembre/2011
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
				// estado de la solicitud
				$estado = array(
					'todos'					=> 'Todas',
					'pendientes'			=> 'Pendientes',
					'aceptadas-solicitador'	=> 'Aceptadas por el Solicitador',
					'aceptadas-autorizador'	=> 'Aceptadas por el Autorizador',
					'aceptadas-cc'			=> 'Aceptadas por Coordinaci&oacute;n de Calidad',
					'rechazadas'			=> 'Rechazadas',
				);
				if( $this->session->userdata('SOL') )
					$estado['eliminadas'] = 'Eliminadas';
				$estado_extras = 'id="estado" onfocus="hover(\'estado\')" style="width:350px; margin:0" onchange="form.submit()"';
				
				// tipo de solicitud
				$tipo = array(
					'todos'			=> 'Todas',
					'Alta' 			=> 'Altas',
					'Baja'			=> 'Bajas',
					'Modificacion'	=> 'Modificaciones',
				);
				$tipo_extras = 'id="tipo" onfocus="hover(\'tipo\')" style="width:150px; margin:0" onchange="form.submit()"';
				
		// Selección de listado
                echo form_open();
				echo '
					<table class="tabla_form" width="700">
	                    <tr>
	                        <th class="text_form" width="50">Estado</th>
	                        <td>'.form_dropdown('estado',$estado,$edo,$estado_extras ).'</td>
	                    </tr>
	                    <tr>
	                        <th class="text_form">Tipo</th>
	                        <td>'.form_dropdown('tipo',$tipo,$tip,$tipo_extras).'</td>
	                    </tr>
	             	</table><br />
	            ';
				echo form_close();
				
		// Tabla de resultados
                if( $consulta->num_rows() > 0 ) {
					echo '<table class="tabla" id="tabla" width="700">';
					echo '<thead><tr>';
					echo '<th class="no_sort" width="15" style="border:0"></th>';
					echo '<th class="no_sort" style="width:5px" style="border:0"></th>';
					echo '<th width="60">C&oacute;digo</th>';
					echo '<th>Nombre del Documento</th>';
					echo '<th width="60">Fecha</th>';					
					echo '<th class="no_sort" width="15" style="border:0"></th>';
					echo '<th class="no_sort" width="15" style="border:0"></th>';
					// Responsable de Solicitudes
					if( $this->session->userdata('SOL') ) {
						echo '<th class="no_sort" width="15" style="border:0"></th>';
						echo '<th class="no_sort" width="15" style="border:0"></th>';
					}
					echo '</tr></thead><tbody>';
                    foreach( $consulta->result() as $row ) :
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
								$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\','.$row->IdSolicitud.',5,\'&iquest;Deseas eliminar esta solicitud?<br />Si lo haces se eliminaran todas las autorizaciones realizadas por la Lista de Distribuci&oacute;n\',\'listados-solicitudes-'.$edo.'-'.$tip.'\')" onmouseover="tip(\'Eliminar solicitud\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;
								
							// aceptadas por el solicitador
							case 1 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/pendiente.png" onmouseover="tip(\'Solicitud pendiente<br />(Aceptada por el solicitador)\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\','.$row->IdSolicitud.',5,\'&iquest;Deseas eliminar esta solicitud?<br />Si lo haces se eliminaran todas las autorizaciones realizadas por la Lista de Distribuci&oacute;n\',\'listados-solicitudes-'.$edo.'-'.$tip.'\')" onmouseover="tip(\'Eliminar solicitud\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;
								
							// aceptadas por el autorizador
							case 2 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/pendiente.png" onmouseover="tip(\'Solicitud pendiente<br />(Aceptada por el autorizador)\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\','.$row->IdSolicitud.',5,\'&iquest;Deseas eliminar esta solicitud?<br />Si lo haces se eliminaran todas las autorizaciones realizadas por la Lista de Distribuci&oacute;n\',\'listados-solicitudes-'.$edo.'-'.$tip.'\')" onmouseover="tip(\'Eliminar solicitud\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;							
							
							// aceptadas por coordinacion de calidad
							case 3 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/terminada.png" onmouseover="tip(\'Solicitud aceptada<br />por Coordinaci&oacute;n de Calidad\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\','.$row->IdSolicitud.',5,\'&iquest;Deseas eliminar esta solicitud?<br />Si lo haces se eliminaran todas las autorizaciones realizadas por la Lista de Distribuci&oacute;n\',\'listados-solicitudes-'.$edo.'-'.$tip.'\')" onmouseover="tip(\'Eliminar solicitud\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;
								
							// rechazadas
							case 4 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/eliminada.png" onmouseover="tip(\'Solicitud rechazada\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\','.$row->IdSolicitud.',5,\'&iquest;Deseas eliminar esta solicitud?<br />Si lo haces se eliminaran todas las autorizaciones realizadas por la Lista de Distribuci&oacute;n\',\'listados-solicitudes-'.$edo.'-'.$tip.'\')" onmouseover="tip(\'Eliminar solicitud\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
								break;
								
							// eliminadas
							case 5 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/eliminada.png" onmouseover="tip(\'Solicitud eliminada\')" onmouseout="cierra_tip()" />';
								$img_cam = '<a onclick="pregunta_cambiar(\'solicitudes\','.$row->IdSolicitud.',0,\'&iquest;Deseas restaurar esta solicitud?\',\'listados-solicitudes-'.$edo.'-'.$tip.'\')" onmouseover="tip(\'Restaurar solicitud\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar.png" /></a>';
								break;
						}
                        echo '<tr>';
						echo '<th valign="top">'.$img_edo.'</th>';
						echo '<th valign="top">'.$img_tip.'</th>';
						echo '<td valign="top">'.$row->Codigo.'</td>';
						echo '<td>'.$row->Nombre.'</td>';
						echo '<td valign="top">'.$row->Fecha.'</td>';						
						echo '<td valign="top"><a href="'.base_url().'index.php/procesos/solicitudes/ver_lista_distribucion/'.$row->IdSolicitud.'/'.$edo.'/'.$tip.'" onmouseover="tip(\'Ver lista de distribuci&oacute;n\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/users.png" /></a></td>';
						echo '<td valign="top"><a href="'.base_url().'index.php/procesos/solicitudes/ver/'.$row->IdSolicitud.'/'.$edo.'/'.$tip.'" onmouseover="tip(\'Ver solicitud\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
						if( $this->session->userdata('SOL') ) {
							echo '<td valign="top"><a href="'.base_url().'index.php/procesos/solicitudes/modificar/'.$row->IdSolicitud.'/'.$edo.'/'.$tip.'" onmouseover="tip(\'Modificar solicitud\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
							echo '<td valign="top">'.$img_cam.'</td>';
						}
                    endforeach;
					echo '</tbody></table>';
					echo $sort_tabla;
                }
                else {
                    echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay solicitudes</td></tr></table>';					
                }
                ?>
        </div>
    </div>
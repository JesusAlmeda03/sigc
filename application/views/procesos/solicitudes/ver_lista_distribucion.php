<?php
/****************************************************************************************************
*
*	VIEWS/solicitudes/ver_lista_distribucion.php
*
*		Descripci�n:
*			Vista para ver la lista de distribucion
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
	<div class="content">
		<div class="cont">
			<div class="titulo"><?=$titulo?></div>
            <div class="texto">
				<?php
				if( $this->session->userdata('SOL') ) {
					echo '<table class="tabla_form" style="width:200px; margin-left:500px"><tr><td><a href="'.base_url().'index.php/procesos/solicitudes/lista_distribucion/'.$ids.'/'.$estado.'/'.$tipo.'"><img src="'.base_url().'includes/img/icons/agregar.png" /></a></td><td><a href="'.base_url().'index.php/procesos/solicitudes/lista_distribucion/'.$ids.'/'.$estado.'/'.$tipo.'" style="color:#333">Agregar a alguien a la Lista de Distribuci&oacute;n</a></td></tr></table><br />';
				}
                if( $usuarios->num_rows() > 0 ) {
                    $j = 1;					
					echo '<table class="tabla" id="tabla" width="700">';
					echo '<thead><tr><th class="no_sort" width="15"></th><th class="no_sort" width="15"></th><th>Nombre</th>';
					if( $this->session->userdata('SOL') ) 
						echo '<th class="no_sort" width="15"></th>';
					echo '</thead><tbody>';
                    foreach( $usuarios->result() as $row ) {
                        if( $j ) {
                            echo '<tr>';
                            $j = 0;
                        }
                        else {
                            echo '<tr class="odd">';
                            $j = 1;
                        }
						// tipo de usuario
						switch( $row->Tipo ) {
							// lista de distribuci�n
							case 0 :
								$img_tip = '<img src="'.base_url().'includes/img/icons/users.png" onmouseover="tip(\'Lista de Distribuci&oacute;n\')" onmouseout="cierra_tip()" />';
								break;
								
							// solicitador
							case 1 :
								$img_tip = '<img src="'.base_url().'includes/img/icons/small/account.png" onmouseover="tip(\'Solicitante\')" onmouseout="cierra_tip()" />';
								break;
								
							// autorizador
							case 2 :
								$img_tip = '<img src="'.base_url().'includes/img/icons/star_full.png" onmouseover="tip(\'Autorizador\')" onmouseout="cierra_tip()" />';
								break;
						}
						
						// estado solicitud
						switch( $row->Aceptado ) {
							// pendiente
							case 0 :
								$img_edo = '<img src="'.base_url().'includes/img/icons/pendiente.png" onmouseover="tip(\'Solicitud pendiente de aceptar\')" onmouseout="cierra_tip()" />';
								break;
								
							// aceptada
							case 1 :
								$img_edo = '<img src="'.base_url().'includes/img/icons/terminada.png" onmouseover="tip(\'Solicitud aceptada\')" onmouseout="cierra_tip()" />';
								break;
								
							// rechazada
							case 2 :
								$img_edo = '<img src="'.base_url().'includes/img/icons/eliminada.png" onmouseover="tip(\'Solicitud rechazada\')" onmouseout="cierra_tip()" />';
								break;
						}
						
                        echo '	<th>'.$img_tip.'</th>';
                        echo '	<td>'.$img_edo.'</td>';
                        echo '	<td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.'</td>';
						if( $this->session->userdata('SOL') )
							echo '	<td><a onclick="pregunta_eliminar_distribucion('.$ids.','.$row->IdUsuario.',\'&iquest;Deseas eliminar a este usuario de la lista de distribuci&oacute;n\',\''.$estado.'-'.$tipo.'\')" onmouseover="tip(\'Eliminar de la Lista de Distribuci&oacute;n\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';						
                        echo '</tr>';
                    }
					echo '</tbody></table><br /><br />';
					echo $sort_tabla;
                }
                else {
                    echo '<table class="tabla" width="700"><tr><th width="20" valign="top"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento esta solicitud no tiene Lista de Distribuci&oacute;n.<br /><br /><strong>NOTA: </strong><br />Es muy necesario que las solicitudes tengan lista de distribuci&oacute;n as&iacute; como usuarios <label style="font-style:italic">Solicitadores</label> y <label style="font-style:italic">Autorizadores</label> ya que si no los tiene la solicitud no podra porceder correctamente.<br />Ponte en contacto con el encargado de solicitudes de tu &aacute;rea para resolver este problema.</td></tr></table><br /><br />';					
                }
				
				if( $estado != '' || $tipo != '' ) {
					switch( $estado ) {
						default :
							echo '<table><tr><td><a href="'.base_url().'index.php/listados/solicitudes/'.$estado.'/'.$tipo.'" onmouseover="tip(\'Regresa al listado de solicitudes\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/listados/solicitudes/'.$estado.'/'.$tipo.'" onmouseover="tip(\'Regresa al listado de solicitudes\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
							break;
							
						case 'solicitar' :
							echo '<table><tr><td><a href="'.base_url().'index.php/procesos/solicitudes/solicitar/" onmouseover="tip(\'Regresa al listado de solicitudes<br />para autorizar\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/procesos/solicitudes/solicitar/" onmouseover="tip(\'Regresa al listado de solicitudes<br />para autorizar\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
							break;
							
						case 'autorizar' :
							echo '<table><tr><td><a href="'.base_url().'index.php/procesos/solicitudes/autorizar/" onmouseover="tip(\'Regresa al listado de solicitudes<br />para autorizar\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/procesos/solicitudes/autorizar/" onmouseover="tip(\'Regresa al listado de solicitudes<br />para autorizar\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
							break;
							
						case 'rechazadas' :
							echo '<table><tr><td><a href="'.base_url().'index.php/procesos/solicitudes/rechazadas" onmouseover="tip(\'Regresa al listado de solicitudes<br />rechazadas\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/procesos/solicitudes/rechazadas/" onmouseover="tip(\'Regresa al listado de solicitudes<br />rechazadas\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
							break;
					}
				}
            ?>
        </div>
    </div>
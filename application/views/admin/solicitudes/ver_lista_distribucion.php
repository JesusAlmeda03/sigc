<?php
/****************************************************************************************************
*
*	VIEWS/admin/solicitudes/ver_lista_distribucion.php
*
*		Descripción:
*			Vista para ver la lista de distribucion en el panel de administrador
*
*		Fecha de Creación:
*			23/Enero/2012
*
*		Ultima actualización:
*			23/Enero/2012
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
        if( $usuarios->num_rows() > 0 ) {
            $j = 1;					
			echo '<table class="tabla" id="tabla" width="980">';
			echo '<thead><tr><th class="no_sort" width="15"></th><th class="no_sort" width="15"></th><th>Nombre</th></tr></thead><tbody>';
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
                echo '</tr>';
            }
			echo '</tbody></table><br /><br />';
			echo $sort_tabla;
        }
        else {
            echo '<table class="tabla" width="980"><tr><th width="20" valign="top"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento esta solicitud no tiene Lista de Distribuci&oacute;n.<br /><br /><strong>NOTA: </strong><br />Es muy necesario que las solicitudes tengan lista de distribuci&oacute;n as&iacute; como usuarios <label style="font-style:italic">Solicitadores</label> y <label style="font-style:italic">Autorizadores</label> ya que si no los tiene la solicitud no podra porceder correctamente.<br />Ponte en contacto con el encargado de solicitudes de tu &aacute;rea para resolver este problema.</td></tr></table><br /><br />';					
        }
		
		if( $autorizar ) {
			echo '<table><tr><td><a href="'.base_url().'index.php/admin/solicitudes/autorizar/'.$area.'/'.$tipo.'" onmouseover="tip(\'Regresa al listado de solicitudes a autorizar\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/admin/solicitudes/autorizar/'.$area.'/'.$tipo.'" onmouseover="tip(\'Regresa al listado de solicitudes a autorizar\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
		}
		else {
			echo '<table><tr><td><a href="'.base_url().'index.php/admin/solicitudes/listado/'.$area.'/'.$estado.'/'.$tipo.'" onmouseover="tip(\'Regresa al listado de solicitudes\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/admin/solicitudes/listado/'.$area.'/'.$estado.'/'.$tipo.'" onmouseover="tip(\'Regresa al listado de solicitudes\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
		}	
    ?>
	</div>
</div>
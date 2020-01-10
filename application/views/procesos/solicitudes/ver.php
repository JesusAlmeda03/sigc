<?php
/****************************************************************************************************
*
*	VIEWS/solicitudes/ver.php
*
*		Descripci�n:
*			Vista para ver la solicitud
*
*		Fecha de Creaci�n:
*			28/Noviembre/2011
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
				// Datos de la Solicitud
				echo '<table class="tabla_form" width="700">';
				echo '<thead><tr><th colspan="2"><span class="titulo_tabla">Datos de la Solicitud</span></th></tr></thead>';
				echo '<tr><th class="text_form" style="font-weight:normal" width="100">Fecha de la Solicitud: </th>';
				echo '<td class="row">'.$fec.'</td></tr>';
				echo '<tr><th class="text_form" style="font-weight:normal">Tipo de Solicitud: </th>';
				echo '<td class="row">'.$tip.'</td></tr>';
				echo '<tr><th class="text_form" style="font-weight:normal" valign="top">Causas: </th>';
				echo '<td class="row">'.$cau.'</td></tr>';
				echo '<tr><th class="text_form" style="font-weight:normal" valign="top">Observaciones: </th>';
				echo '<td class="row">'.$obs.'</td></tr>';
				echo '</table>';
				echo '<br />';
				
				// Datos del Documento
				echo '<table class="tabla_form" width="700">';
				echo '<thead><tr><th colspan="2"><span class="titulo_tabla">Datos del Documento</span></th></tr></thead>';
				echo '<tr><th class="text_form" style="font-weight:normal" width="100">Secci&oacute;n: </th>';				
				echo '<td class="row">'.$cod.'</td></tr>';
				echo '<tr><th class="text_form" style="font-weight:normal" valign="top">Edici&oacute;n: </th>';
				echo '<td class="row">'.$edi.'</td></tr>';
				echo '<tr><th class="text_form" style="font-weight:normal" valign="top">Nombre: </th>';
				echo '<td class="row">'.$nom.'</td></tr>';				
				echo '</table>';
				echo '<br />';
				
				// Documentos
				echo '<table class="tabla_form" width="700">';
				echo '<thead><tr><th colspan="2"><span class="titulo_tabla">Documentos</span></th></tr></thead>';
				echo '<tr><th width="100" style="text-align:center"><a href="'.base_url().'includes/docs/'.$doc.'" target="_blank" onMouseover="tip(\'Abrir el documento\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/pdf.png" width="35" /></a></th>';
				echo '<td class="row"><a href="'.base_url().'includes/docs/'.$doc.'" target="_blank" onMouseover="tip(\'Abrir el documento\')"; onMouseout="cierra_tip()">Documento de la Solicitud</a></td></tr>';
				echo '</table><br /><br />';
				
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
						
						case 'revisar' :
							echo '<table><tr><td><a href="'.base_url().'index.php/procesos/solicitudes/revisar" onmouseover="tip(\'Regresa al listado de solicitudes<br />para revisar\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/procesos/solicitudes/revisar/" onmouseover="tip(\'Regresa al listado de solicitudes<br />para revisar\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
							break;
					}
				}
            ?>
        </div>
    </div>
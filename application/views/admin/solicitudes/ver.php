<?php
/****************************************************************************************************
*
*	VIEWS/admin_files/solicitudes/ver.php
*
*		Descripción:
*			Vista para ver la solicitud en el panel de administrador
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
			// Datos de la Solicitud
			echo '<table class="tabla_form" width="950">';
			echo '<thead><tr><th colspan="2"><span class="titulo_tabla">Datos de la Solicitud</span></th></tr></thead>';
			echo '<tr><th class="text_form" style="font-weight:normal" width="100">Fecha del Documento: </th>';
			echo '<td class="row">'.$fed.'</td></tr>';
			echo '<tr><th class="text_form" style="font-weight:normal" width="100">C&oacute;digo: </th>';
			echo '<td class="row">'.$cod.'</td></tr>';
			echo '<tr><th class="text_form" style="font-weight:normal" width="100">Nombre: </th>';
			echo '<td class="row">'.$nom.'</td></tr>';		
			echo '<tr><th class="text_form" style="font-weight:normal" width="100">Fecha de la Solicitud: </th>';
			echo '<td class="row">'.$fec.'</td></tr>';
			echo '<tr><th class="text_form" style="font-weight:normal" width="100">Edici&oacute;n: </th>';
			echo '<td class="row">'.$edi.'</td></tr>';
			echo '<tr><th class="text_form" style="font-weight:normal">Tipo de Solicitud: </th>';
			echo '<td class="row">'.$tip.'</td></tr>';
			echo '<tr><th class="text_form" style="font-weight:normal" valign="top">Causas: </th>';
			echo '<td class="row">'.$cau.'</td></tr>';
			echo '<tr><th class="text_form" style="font-weight:normal" valign="top">Observaciones: </th>';
			echo '<td class="row">'.$obs.'</td></tr>';
			echo '</table>';
			echo '<br />';
			
			// Documentos
			echo '<table class="tabla_form" width="950">';
			echo '<thead><tr><th colspan="2"><span class="titulo_tabla">Documentos</span></th></tr></thead>';
			echo '<tr><th width="100" style="text-align:center"><a href="'.base_url().'includes/docs/'.$doc.'" target="_blank" onMouseover="ddrivetip(\'Abrir el documento\')"; onMouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/pdf.png" width="35" /></a></th>';
			echo '<td class="row"><a href="'.base_url().'includes/docs/'.$doc.'" target="_blank" onMouseover="ddrivetip(\'Abrir el documento\')"; onMouseout="hideddrivetip()">Documento de la Solicitud</a></td></tr>';
			echo '</table><br /><br />';
			
			if( $autorizar ) {
				echo '<table><tr><td><a href="'.base_url().'index.php/admin/solicitudes/autorizar/'.$area.'/'.$tipo.'" onmouseover="tip(\'Regresa al listado de solicitudes a autorizar\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/admin/solicitudes/autorizar/'.$area.'/'.$tipo.'" onmouseover="tip(\'Regresa al listado de solicitudes a autorizar\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
			}
			else {
				echo '<table><tr><td><a href="'.base_url().'index.php/admin/solicitudes/listado/'.$area.'/'.$estado.'/'.$tipo.'" onmouseover="tip(\'Regresa al listado de solicitudes\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/admin/solicitudes/listado/'.$area.'/'.$estado.'/'.$tipo.'" onmouseover="tip(\'Regresa al listado de solicitudes\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
			}
	    	?>
	    </div>
	</div>
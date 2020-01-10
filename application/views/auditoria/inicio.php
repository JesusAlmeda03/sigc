<?php
/****************************************************************************************************
*
*	VIEWS/inicio/auditor.php
*
*		Descripción:
*			Vista de las actividades de los auditores para una auditoría
*
*		Fecha de Creación:
*			31/Octubre/2011
*
*		Ultima actualización:
*			31/Octubre/2011
*
*		Autor:
*			ISC Rogelio Casta�eda Andrade
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
				echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Las acciones realizadas se aplicaran solo a la Auditor&iacute;a vigente:<br /><span style="font-size:14px; font-weight:bold">'.$auditoria.'</span></td></tr></table><br />';
				
				// Programa Específico de Auditoría
				echo '<table class="tabla_opciones" style="width:700px">';
                echo '<tr >';
                echo '	<th width="100" style="text-align:center; padding:15px 0;"><div style="margin:9px 0 9px 0"><a href="'.base_url().'index.php/auditoria/especifico" onmouseover="tip(\'Programa Espec&iacute;fico de Auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/programa.png" width="35" /></a></div></th>';
                echo '	<td><a style="color:#333; font-size:18px" href="'.base_url().'index.php/auditoria/especifico">Programa Espec&iacute;fico de Auditor&iacute;a</a></td>';
                echo '</tr>';
                echo '</table><br />';
				
				// Instructivos de Trabajo
				echo '<table class="tabla_opciones" style="width:700px">';					
                echo '<tr >';
                echo '	<th width="100" style="text-align:center; padding:15px 0;"><div style="margin:9px 0 9px 0"><a href="'.base_url().'index.php/auditoria/instructivos" onmouseover="tip(\'Revisar Instructivos de Trabajo para la Auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/doc.png" width="35" /></a></div></th>';
                echo '	<td><a style="color:#333; font-size:18px" href="'.base_url().'index.php/auditoria/instructivos">Revisar Instructivos de Trabajo para la Auditor&iacute;a</a></td>';
                echo '</tr>';
                echo '</table><br />';
								
				// Generar Lista de Verificación
				echo '<table class="tabla_opciones" style="width:700px">';					
                echo '<tr >';
                echo '	<th width="100" style="text-align:center; padding:15px 0;"><div style="margin:9px 0 9px 0"><a href="'.base_url().'index.php/auditoria/lista_verificacion/generar" onmouseover="tip(\'Generar Lista de Verificaci&oacute;n\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/evaluacion.png" width="35" /></a></div></th>';
                echo '	<td><a style="color:#333; font-size:18px" href="'.base_url().'index.php/auditoria/lista_verificacion/generar">Generar Lista de Verificaci&oacute;n</a></td>';
                echo '</tr>';
                echo '</table><br />';
				
				// Revisar tu Lista de Verificación
				echo '<table class="tabla_opciones" style="width:700px">';					
                echo '<tr >';
                echo '	<th width="100" style="text-align:center; padding:15px 0;"><div style="margin:9px 0 9px 0"><a href="'.base_url().'index.php/auditoria/lista_verificacion/revisar" onmouseover="tip(\'Revisar tu Lista de Verificaci&oacute;n\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/evaluacion.png" width="35" /></a></div></th>';
                echo '	<td><a style="color:#333; font-size:18px" href="'.base_url().'index.php/auditoria/lista_verificacion/revisar">Revisar tus Lista de Verificaci&oacute;n</a></td>';
                echo '</tr>';
                echo '</table><br />';
			
				// Guardar Respuestas Lista de Verificación
				echo '<table class="tabla_opciones" style="width:700px">';					
                echo '<tr >';
                echo '	<th width="100" style="text-align:center; padding:15px 0;"><div style="margin:9px 0 9px 0"><a href="'.base_url().'index.php/auditoria/respuestas_lista_verificacion" onmouseover="tip(\'Guardar Respuestas de la Lista de Verificaci&oacute;n\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/guardar_lv.png" width="35" /></a></div></th>';
                echo '	<td><a style="color:#333; font-size:18px" href="'.base_url().'index.php/auditoria/respuestas_lista_verificacion">Guardar Respuestas de la Lista de Verificaci&oacute;n</a></td>';
                echo '</tr>';
                echo '</table><br />';
			
				if( $hallazgos ) {
					// Reporte de Hallazgos
					echo '<table class="tabla_opciones" style="width:700px">';					
	                echo '<tr >';
	                echo '	<th width="100" style="text-align:center; padding:15px 0;"><div style="margin:9px 0 9px 0"><a href="'.base_url().'index.php/auditoria/hallazgos" onmouseover="tip(\'Reporte de Hallazgos\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/hallazgos.png" width="35" /></a></div></th>';
	                echo '	<td><a style="color:#333; font-size:18px" href="'.base_url().'index.php/auditoria/hallazgos">Reporte de Hallazgos</a></td>';
	                echo '</tr>';
	                echo '</table><br />';
				}
				?>
			</div>
		</div>
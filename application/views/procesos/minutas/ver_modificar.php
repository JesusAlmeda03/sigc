<?php
/****************************************************************************************************
*
*	VIEWS/procesos/minutas/modificar.php
*
*		Descripci�n:
*			Listado de todos los indicadores
*
*		Fecha de Creaci�n:
*			19/Noviembre/2011
*
*		Ultima actualizaci�n:
*			19/Noviembre/2011
*
*		Autor:
*			ISC Rogelio Casta�eda Andrade
*			HERE (http://www.webHERE.com.mx)
*			rogeliocas@gmail.com
*
****************************************************************************************************/
?>
	<div class="content">		
		<div class="cont">
			<div class="titulo"><?=$titulo.': '.$periodo?></div>
            <div class="texto">
				<?php
				// Lugar y Fecha
				echo '<table class="tabla_form" width="700">';
				echo '<thead><tr>';
				echo '<th width="20"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/10/'.$idmp.'/1/'.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></th>';
				echo '<th>Lugar y Fecha</th>';
				echo '</tr></thead>';
				echo '</table>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px">'.$lug.'</div>';				
				
				// Participantes
				echo '<table class="tabla_form" width="700">';
				echo '<thead><tr>';
				echo '<th width="20"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/0/'.$idmp.'/1/'.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></th>';
				echo '<th>Participantes</th>';
				echo '</tr></thead>';
				echo '</table>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px">'.$par.'</div>';
				
				// I. Puntos Pendientes
				echo '<table class="tabla_form" width="700">';
				echo '<thead><tr>';
				echo '<th width="20"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/1/'.$idmp.'/1/'.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></th>';
				echo '<th>I. Puntos Pendientes</th>';
				echo '</tr></thead>';
				echo '</table>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px">'.$pun.'</div>';
				
				// II. Objetivos de Calidad
				echo '<table class="tabla_form" width="700">';
				echo '<thead><tr>';
				echo '<th width="20"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/2/'.$idmp.'/1/'.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></th>';
				echo '<th>II. Objetivos de Calidad</th>';
				echo '</tr></thead>';
				echo '</table>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px">'.$obj.'</div>';
				
				// III. Procesos
				echo '<table class="tabla_form" width="700">';
				echo '<thead><tr>';
				echo '<th width="20"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/3/'.$idmp.'/1/'.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></th>';
				echo '<th>III. Procesos</th>';
				echo '</tr></thead>';
				echo '</table>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px">'.$pro.'</div>';
				
				// IV Desempeño
				echo '<table class="tabla_form" width="700">';
				echo '<thead><tr>';
				echo '<th width="20"></th>';
				echo '<th>IV. Desempe&ntilde;o</th>';
				echo '</tr></thead>';
				echo '</table>';
				// IV.1 - Infraestructura y Ambiente de Trabajo
				echo '<div style="width:698px; border:1px solid #EEE; background-color:#fafafb; border-bottom:none">';
				echo '<a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/41/'.$idmp.'/1/'.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a>';
				echo 'Infraestructura y Ambiente de Trabajo</div>';
				echo '<div style="width:678px; border:1px solid #EEE; padding:10px; background-color:#fafafb; border-top:none">Atendidas</div>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; float:left;">'.$ina.'</div>';				
				echo '<div style="width:678px; border:1px solid #EEE; padding:10px; background-color:#fafafb">No Atendidas</div>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px;">'.$inn.'</div>';
				// IV.2 - Clima Organizacional
				echo '<div style="width:678px; border:1px solid #EEE; padding:10px; background-color:#fafafb">';
				echo '<a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/42/'.$idmp.'/1/'.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a>';
				echo 'Clima Organizacional</div>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px;">'.$cli.'</div>';
				// IV.3 - Satisfacción de Usuarios
				echo '<div style="width:678px; border:1px solid #EEE; padding:10px; background-color:#fafafb">';
				echo '<a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/43/'.$idmp.'/1/'.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a>';
				echo 'Satisfacción de Usuarios</div>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px;">'.$sat.'</div>';
				// IV.4 - Auditoría Interna
				echo '<div style="width:678px; border:1px solid #EEE; padding:10px; background-color:#fafafb">';
				echo '<a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/44/'.$idmp.'/1/'.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a>';
				echo 'Auditoría Interna</div>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px;">'.$aud.'</div>';
				// IV.5 - Capacitación
				echo '<div style="width:678px; border:1px solid #EEE; padding:10px; background-color:#fafafb">';
				echo '<a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/45/'.$idmp.'/1/'.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a>';
				echo 'Capacitaci&oacute;n</div>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px;">'.$cap.'</div>';
				// IV.6 - Mejora Continua
				echo '<div style="width:678px; border:1px solid #EEE; padding:10px; background-color:#fafafb">';
				echo '<a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/46/'.$idmp.'/1/'.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a>';
				echo 'Mejora Continua</div>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px;">'.$mej.'</div>';
				// IV.7 - Quejas
				echo '<div style="width:678px; border:1px solid #EEE; padding:10px; background-color:#fafafb">';
				echo '<a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/47/'.$idmp.'/1/'.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a>';
				echo 'Quejas</div>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px;">'.$que.'</div>';
				// IV.8 - Evaluación al Desempeño
				echo '<div style="width:678px; border:1px solid #EEE; padding:10px; background-color:#fafafb">';
				echo '<a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/48/'.$idmp.'/1/'.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a>';
				echo 'Evaluaci&oacute;n al Desempe&ntilde;o</div>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px;">'.$des.'</div>';
				
				// V. Acciones Correctivas y Preventivas
				echo '<table class="tabla_form" width="700">';
				echo '<thead><tr>';
				echo '<th width="20"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/5/'.$idmp.'/1/'.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></th>';
				echo '<th>V. Acciones Correctivas y Preventivas</th>';
				echo '</tr></thead>';
				echo '</table>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px">'.$acc.'</div>';
				
				// VI. Cambios que podrian afectar al SIGC
				echo '<table class="tabla_form" width="700" style="clear:both; margin-top:10px;">';
				echo '<thead><tr>';
				echo '<th width="20"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/6/'.$idmp.'/1/'.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></th>';
				echo '<th>VI. Cambios que podrian afectar al SIGC</th>';
				echo '</tr></thead>';
				echo '</table>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px">'.$cam.'</div>';
				
				// VII. Recomendaciones para la mejora (Mejora Continua)
				echo '<table class="tabla_form" width="700" style="clear:both; margin-top:10px;">';
				echo '<thead><tr>';
				echo '<th width="20"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/7/'.$idmp.'/1/'.$estado.''.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></th>';
				echo '<th>VII. Recomendaciones para la mejora (Mejora Continua)</th>';
				echo '</tr></thead>';
				echo '</table>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px">'.$rec.'</div>';
				
				// VIII. Asuntos Generales
				echo '<table class="tabla_form" width="700" style="clear:both; margin-top:10px;">';
				echo '<thead><tr>';
				echo '<th width="20"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/8/'.$idmp.'/1'.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></th>';
				echo '<th>VIII. Asuntos Generales</th>';
				echo '</tr></thead>';
				echo '</table>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px">'.$asu.'</div>';
				
				// IX. Tareas
				echo '<table class="tabla_form" width="700" style="clear:both; margin-top:10px;">';
				echo '<thead><tr>';
				echo '<th width="20"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/9/'.$idmp.'/1/'.$estado.'" onmouseover="tip(\'Modificar este punto\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></th>';
				echo '<th>IX. Tareas</th>';
				echo '</tr></thead>';
				echo '</table>';
				echo '<div style="width:698px; max-height:130px; overflow:hidden; border:1px solid #EEE; margin-bottom:10px">'.$tar.'</div>';				
				
				echo "<br />";
				echo '<table><tr><td><a href="'.base_url().'index.php/listados/minutas/'.$estado.'" onmouseover="tip(\'Regresa al listado de minutas\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/listados/minutas/'.$estado.'" onmouseover="tip(\'Regresa al listado de minutas\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
                ?>
        </div>
    </div>
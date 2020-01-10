<?php
/****************************************************************************************************
*
*	VIEWS/admin/minutas/puntos.php
*
*		Descripción:
*			Vista que muestra todos los puntos de la minuta del comite
*
*		Fecha de Creación:
*			23/Abril/2012
*
*		Ultima actualización:
*			23/Abril/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			HERE (http://www.webHERE.com.mx)
*			rogeliocas@gmail.com
*
****************************************************************************************************/
?>
    <div class="cont" style="width:970px;">
    	<div class="title"><?=$titulo?><br /><span style="font-size: 14px;"><?=$minuta?></span></div>
        <div class="text">        	
			<?php
			echo '<table class="tabla" width="670"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Elige un punto para agregar / modificar la informaci&oacute;n</td></tr></table><br />';
			      	
			echo '<table class="tabla" id="tabla">';

			// Acuerdos Pendientes
			echo '<tr>';
			echo '<td><a href="'.base_url().'index.php/admin/minutas/acuerdos/'.$per.'/'.$ano.'" onmouseover="ddrivetip(\'Alimentar / modificar<br />este punto\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/open.gif" /></a></td>';
			echo '<td>Acuerdos</td>';
			echo '</tr>';
			
			// Lugar y Fecha
			echo '<tr>';
			echo '<td><a href="'.base_url().'index.php/admin/minutas/punto_comite/1/'.$per.'/'.$ano.'" onmouseover="ddrivetip(\'Alimentar / modificar<br />este punto\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/open.gif" /></a></td>';
			echo '<td>Lugar</td>';
			echo '</tr>';
			
			// Participantes
			echo '<tr>';
			echo '<td><a href="'.base_url().'index.php/admin/minutas/punto_comite/2/'.$per.'/'.$ano.'" onmouseover="ddrivetip(\'Alimentar / modificar<br />este punto\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/open.gif" /></a></td>';
			echo '<td>Participantes</td>';
			echo '</tr>';
								
			// I. Puntos Pendientes
			echo '<tr>';
			echo '<td><a href="'.base_url().'index.php/admin/minutas/punto_comite/3/'.$per.'/'.$ano.'" onmouseover="ddrivetip(\'Alimentar / modificar<br />este punto\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/open.gif" /></a></td>';
			echo '<td>I. Puntos Pendientes</td>';
			echo '</tr>';
			
			// II. Objetivos de Calidad
			echo '<tr>';
			echo '<td><a href="'.base_url().'index.php/admin/minutas/punto_comite/4/'.$per.'/'.$ano.'" onmouseover="ddrivetip(\'Alimentar / modificar<br />este punto\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/open.gif" /></a></td>';
			echo '<td>II. Objetivos de Calidad</td>';
			echo '</tr>';
			
			// III. Procesos
			echo '<tr>';
			echo '<td><a href="'.base_url().'index.php/admin/minutas/punto_comite/5/'.$per.'/'.$ano.'" onmouseover="ddrivetip(\'Alimentar / modificar<br />este punto\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/open.gif" /></a></td>';
			echo '<td>III. Procesos</td>';
			echo '</tr>';
			
			// IV. Desempe&ntilde;o
			echo '<tr>';
			echo '<td><a href="'.base_url().'index.php/admin/minutas/punto_comite/6/'.$per.'/'.$ano.'" onmouseover="ddrivetip(\'Alimentar / modificar<br />este punto\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/open.gif" /></a></td>';
			echo '<td>IV. Desempe&ntilde;o</td>';
			echo '</tr>';
			
			// V. Acciones Correctivas y Preventivas
			echo '<tr>';
			echo '<td><a href="'.base_url().'index.php/admin/minutas/punto_comite/7/'.$per.'/'.$ano.'" onmouseover="ddrivetip(\'Alimentar / modificar<br />este punto\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/open.gif" /></a></td>';
			echo '<td>V. Acciones Correctivas y Preventivas</td>';
			echo '</tr>';
			
			// VI. Cambios que podrian afectar al SIGC
			echo '<tr>';
			echo '<td><a href="'.base_url().'index.php/admin/minutas/punto_comite/8/'.$per.'/'.$ano.'" onmouseover="ddrivetip(\'Alimentar / modificar<br />este punto\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/open.gif" /></a></td>';
			echo '<td>VI. Cambios que podrian afectar al SIGC</td>';
			echo '</tr>';
			
			// VII. Recomendaciones para la mejora (Mejora Continua)
			echo '<tr>';
			echo '<td><a href="'.base_url().'index.php/admin/minutas/punto_comite/9/'.$per.'/'.$ano.'" onmouseover="ddrivetip(\'Alimentar / modificar<br />este punto\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/open.gif" /></a></td>';
			echo '<td>VII. Recomendaciones para la mejora (Mejora Continua)</td>';
			echo '</tr>';
			
			// VIII. Asuntos Generales
			echo '<tr>';
			echo '<td><a href="'.base_url().'index.php/admin/minutas/punto_comite/10/'.$per.'/'.$ano.'" onmouseover="ddrivetip(\'Alimentar / modificar<br />este punto\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/open.gif" /></a></td>';
			echo '<td>VIII. Asuntos Generales</td>';
			echo '</tr>';
			
			// IX. Tareas
			echo '<tr>';
			echo '<td><a href="'.base_url().'index.php/admin/minutas/punto_comite/11/'.$per.'/'.$ano.'" onmouseover="ddrivetip(\'Alimentar / modificar<br />este punto\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/open.gif" /></a></td>';
			echo '<td>IX. Tareas</td>';
			echo '</tr>';
			
			echo '</table>';			
        	?><br /><br />
        	<table><tr><td><a href="<?=base_url()?>index.php/admin/minutas/minutas_comite" onmouseover="ddrivetip('Regresa al listado de minutas')" onmouseout="hideddrivetip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/admin/minutas/minutas_comite" onmouseover="ddrivetip('Regresa al listado de minutas')" onmouseout="hideddrivetip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
        </div>
    </div><div class="btm_sh" style="width:982px; margin:0 0 5px 0"></div>
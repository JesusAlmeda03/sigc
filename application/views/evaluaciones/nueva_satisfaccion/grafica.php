<?php
/****************************************************************************************************
*
*	VIEWS/evaluaciones/grafica.php
*
*		Descripción:
*			Vista de la gráfica de los resultados de la evaluación
*
*		Fecha de Creación:
*			20/Enero/2011
*
*		Ultima actualización:
*			25/Septiembre/2012
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
				echo '<table class="tabla_form" width="700">';
				echo '<tr>';
				echo '<th width="210" class="text_form">&Aacute;rea:</th>';
				echo '<td>'.$area.'</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<th class="text_form">Secci&oacute;n de la evaluaci&oacute;n</th>';
				echo '<td>'.$seccion.'</td>';
				echo '</tr>';				
				echo '</table><br />';
				echo $grafica;
				echo '<br />';
				echo $tabla;				
				?>
				<br />
				<table><tr><td><a href="<?=base_url()?>index.php/evaluaciones/nueva_satisfaccion/resultados" onmouseover="tip('Regresa a opciones<br />de la evaluaci&oacute;n')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/evaluaciones/nueva_satisfaccion/resultados" onmouseover="tip('Regresa a opciones<br />de la evaluaci&oacute;n')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
			</div>
		</div>
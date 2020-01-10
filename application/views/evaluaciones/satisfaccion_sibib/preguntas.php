<?php
/****************************************************************************************************
*
*	VIEWS/evaluaciones/comun/preguntas.php
*
*		Descripción:
*			Vista de las pregunts de la encuesta
*
*		Fecha de Creación:
*			20/Enero/2011
*
*		Ultima actualización:
*			20/Enero/2011
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
            	<?=$main?>
                <br />
                <table><tr><td><a href="<?=base_url()?>index.php/evaluaciones/<?=$evaluacion?>" onmouseover="tip('Regresa a las opciones de la evaluaci&oacute;n')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/evaluaciones/<?=$evaluacion?>" onmouseover="tip('Regresa a las opciones de la evaluaci&oacute;n')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
			</div>
		</div>
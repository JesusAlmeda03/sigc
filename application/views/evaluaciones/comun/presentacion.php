<?php
/****************************************************************************************************
*
*	VIEWS/evaluaciones/comun/presentacion.php
*
*		Descripción:  		  
*			Vista de la presentacion de la evaluaci�n
*
*		Fecha de Creación:
*			31/Octubre/2011
*
*		Ultima actualización:
*			31/Octubre/2011
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
			<div class="titulo"><?=$titulo?><br /><span style="font-size:22px"><?=$nombre?></span></div>
            <div class="texto">
            	<?=$main?>
            	<br />
                <table><tr><td><a href="<?=base_url()?>index.php/evaluaciones/<?=$evaluacion?>" onmouseover="tip('Regresa a las opciones de la evaluaci&oacute;n')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/evaluaciones/<?=$evaluacion?>" onmouseover="tip('Regresa a las opciones de la evaluaci&oacute;n')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
            </div>
		</div>

<?php
/****************************************************************************************************
*
*	VIEWS/itarh/usuarios/resolver.php
*
*		Descripción:
*			Resolver Observaciones
*
*		Fecha de Creación:
*			09/Octubre/2011
*
*		Ultima actualización:
*			09/Octubre/2011
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
            echo '<table class="tabla_form" width="980">';
            echo '<tr><th class="text_form" width="150">Quincena: </th>';
            echo '<td>'.$quincena.'</td></tr>';
            echo '<tr><th class="text_form">Matricula: </th>';
            echo '<td>'.$matricula.'</td></tr>';
            echo '<tr><th class="text_form">Nombre: </th>';
            echo '<td>'.$nombre.'</td></tr>';
			echo '<tr><th class="text_form">Unidad Responsable: </th>';
            echo '<td>'.$unidad.'</td></tr>';
            echo '<tr><th class="text_form">Tipo de Empleado: </th>';
            echo '<td>'.$empleado.'</td></tr>';
            echo '<tr><th class="text_form">Permanencia: </th>';
            echo '<td>'.$permanencia.'</td></tr>';
            echo '<tr><th class="text_form">Horas Contrato: </th>';
            echo '<td>'.$contrato.'</td></tr>';
			echo '<tr><th class="text_form" valign="top">Sistema: </th>';
            echo '<td>'.$sistema.'</td></tr>';
			echo '<tr><th class="text_form" valign="top">Contraloria: </th>';
            echo '<td>'.$contraloria.'</td></tr>';
			echo '<tr><th class="text_form" valign="top">Observaci&oacute;n: </th>';
            echo '<td>'.$observacion.'</td></tr>';
            echo '<tr><th class="text_form" valign="top">Acci&oacute;n Correctiva: </th>';
            echo '<td>'.$accion.'</td></tr>';
            echo '</table><br />';
            ?>
            <br /><br />
			<table><tr><td><a href="<?=base_url()?>index.php/itarh/observaciones/listado/<?=$enlace?>" onmouseover="tip('Regresa al listado<br />de observaciones')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/itarh/observaciones/listado/<?=$enlace?>" onmouseover="tip('Regresa al listado<br />de observaciones')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
        </div>
    </div>
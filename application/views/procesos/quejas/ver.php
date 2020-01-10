<?php
/****************************************************************************************************
*
*	VIEWS/procesos/quejas/ver.php
*
*		Descripción:
*			Vista de la información de la queja
*
*		Fecha de Creación:
*			30/Octubre/2011
*
*		Ultima actualización:
*			30/Octubre/2011
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
			<div class="titulo">Queja <?=$tipo_title?></div>
            <div class="texto">
				<?php
				echo '<table class="tabla_form" width="700">';
				echo '<thead><tr><th colspan="2"><span class="titulo_tabla">Datos de la Queja</span></th></tr></thead>';
				echo '<tr><th class="text_form" width="100" style="font-weight:normal">&Aacute;rea: </th>';
				echo '<td class="row">'.$are.'</td></tr>';
				echo '<tr><th class="text_form" style="font-weight:normal">Departamento: </th>';
				echo '<td class="row">'.$dep.'</td></tr>';
				echo '<tr><th class="text_form" style="font-weight:normal">Nombre: </th>';
				echo '<td class="row">'.$nom.'</td></tr>';
				echo '<tr><th class="text_form" style="font-weight:normal">Fecha: </th>';
				echo '<td class="row">'.$fec.'</td></tr>';
				echo '<tr><th class="text_form" style="font-weight:normal">Correo: </th>';
				echo '<td class="row">'.$cor.'</td></tr>';
				echo '<tr><th class="text_form" style="font-weight:normal">Tel&eacute;fono: </th>';
				echo '<td class="row">'.$tel.'</td></tr>';
				echo '<tr><th class="text_form" style="font-weight:normal">Queja: </th>';
				echo '<td class="row">'.$que.'</td></tr>';
				echo '</table>';
				echo '<br />';
				if( $seguimiento ) {
					echo '<table class="tabla_form" width="700">';
					echo '<thead><tr><th colspan="2"><span class="titulo_tabla">Datos del Seguimiento de la Queja</span></th></tr></thead>';
					echo '<tr><th class="text_form" width="100" style="font-weight:normal">Responsable: </th>';
					echo '<td class="row">'.$res.'</td></tr>';
					echo '<tr><th class="text_form" style="font-weight:normal">Descripci&oacute;n: </th>';
					echo '<td class="row">'.$des.'</td></tr>';
					echo '<tr><th class="text_form" style="font-weight:normal">Fecha: </th>';
					echo '<td class="row">'.$fec_seg.'</td></tr>';
					if( $obs != "" ) {
						echo '<tr><th class="text_form" style="font-weight:normal">Observaci&oacute;n: </th>';
						echo '<td class="row">'.$obs.'</td></tr>';
					}
					echo '</table>';
					echo '<br />';
					echo '<table class="tabla_form" width="700">';
					echo '<thead><tr><th colspan="2"><span class="titulo_tabla">Documentos Generados</span></th></tr></thead>';
					echo '<tr><th width="100" style="text-align:center"><a href="'.base_url().'index.php/procesos/quejas/documento/'.$idq.'" target="_blank" onMouseover="tip(\'Abrir el documento\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/pdf.png" width="35" /></a></th>';
					echo '<td><a href="'.base_url().'index.php/procesos/quejas/documento/'.$idq.'" target="_blank" onMouseover="tip(\'Abrir el documento\')"; onMouseout="cierra_tip()">Queja Terminada</a></td></tr>';
					echo '</table>';
				}
                ?>
                <br /><br />
				<table><tr><td><a href="<?=base_url()?>index.php/listados/quejas/<?=$estado?>" onmouseover="tip('Regresa al listado de quejas')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/listados/quejas/<?=$estado?>" onmouseover="tip('Regresa al listado de quejas')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
            </div>
		</div>
<?php
/****************************************************************************************************
 *
 *	VIEWS/admin/varios/ver.php
 *
 *		Descripción:
 *			Vista de la información de la no conformidad en el panel de administrador
 *
 *		Fecha de Creación:
 *			2/Febrero/2012
 *
 *		Ultima actualización:
 *			2/Febrero/2012
 *
 *		Autor:
 *			ISC Rogelio Castañeda Andrade
 *			rogeliocas@gmail.com
 *			@rogelio_cas
 *
 ****************************************************************************************************/
?>
	<div class="cont_admin">
		<div class="titulo">
			<?=$titulo ?>
		</div>
		<div class="text">
			<?php
			echo '<table class="tabla_form" width="980">';
			echo '<thead><tr><th colspan="2">Datos de la Queja</th></tr></thead>';
			echo '<tr><th class="text_form" width="80" style="font-weight:normal">Usuario que levant&oacute; la No Conformidad: </th>';
			echo '<td class="row">' . $usu . ' ' . $aru . '</td></tr>';
			echo '<tr><th class="text_form" style="font-weight:normal">&Aacute;rea: </th>';
			echo '<td class="row">' . $are . '</td></tr>';
			echo '<tr><th class="text_form" style="font-weight:normal">Departamento: </th>';
			echo '<td class="row">' . $dep . '</td></tr>';
			//echo '<tr><th class="text_form" style="font-weight:normal">Consecutivo: </th>';
			//echo '<td class="row">'.$con.'</td></tr>';
			echo '<tr><th class="text_form" style="font-weight:normal">Fecha: </th>';
			echo '<td class="row">' . $fec . '</td></tr>';
			echo '<tr><th class="text_form" style="font-weight:normal">Origen: </th>';
			echo '<td class="row">' . $ori . '</td></tr>';
			echo '<tr><th class="text_form" style="font-weight:normal">Tipo: </th>';
			echo '<td class="row">' . $tip . '</td></tr>';
			echo '<tr><th class="text_form" style="font-weight:normal" valign="top">Descripci&oacute;n: </th>';
			echo '<td class="row">' . $des . '</td></tr>';
			echo '</table>';
			echo '<br />';
			if ($seguimiento) {
				echo '<table class="tabla_form" width="980">';
				echo '<thead><tr><th colspan="2">Datos del Seguimiento de la No Conformidad</th></tr></thead>';
				echo '<tr><th class="text_form" width="80" style="font-weight:normal" valign="top">Causa: </th>';
				echo '<td class="row">' . $cau . '</td></tr>';
				echo '</table>';
				echo '<br />';
				echo '<table class="tabla_form" width="980">';
				echo '<tr><th class="text_form" style="font-weight:normal" valign="top"><strong>Diagrama de Pescado:</strong> </th></tr>';
				echo '<tr><td class="row">';
				if ($diagrama -> num_rows() > 0) {
					$i = 1;
					echo '<table width="980" style="background:url(' . base_url() . 'includes/img/pix/pescado.png) no-repeat center center"><tr>';
					foreach ($diagrama->result() as $row) :
						echo '<td><div style="border:1px solid #EEE; width:150px; height:auto; margin:auto; padding:15px;"><strong>' . $row -> Categoria . '</strong><br />' . $row -> Causa . '</div></td>';
						if ($i >= 3) {
							echo '</tr><tr>';
							$i = 0;
						}
						$i++;
					endforeach;
					echo '</table>';
				}
				echo '</td></tr>';
				echo '</table>';
				echo '<br />';
				echo '<table class="tabla_form" width="980">';
				echo '<tr><th class="text_form" style="font-weight:normal" valign="top"><strong>Acciones a Tomar:</strong> </th></tr>';
				echo '</table>';
				if ($acciones -> num_rows() > 0) {
					$i = 1;
					foreach ($acciones->result() as $row) :
						echo '<table class="tabla_form" width="980">';
						switch( substr($row->Fecha,5,2) ) {
							case "00" :
								$mes = "";
								break;
							case "01" :
								$mes = "Enero";
								break;
							case "02" :
								$mes = "Febrero";
								break;
							case "03" :
								$mes = "Marzo";
								break;
							case "04" :
								$mes = "Abril";
								break;
							case "05" :
								$mes = "Mayo";
								break;
							case "06" :
								$mes = "Junio";
								break;
							case "07" :
								$mes = "Julio";
								break;
							case "08" :
								$mes = "Agosto";
								break;
							case "09" :
								$mes = "Septiembre";
								break;
							case "10" :
								$mes = "Octubre";
								break;
							case "11" :
								$mes = "Noviembre";
								break;
							case "12" :
								$mes = "Diciembre";
								break;
						}
						$fec_accion = substr($row -> Fecha, 8, 2) . " / " . $mes . " / " . substr($row -> Fecha, 0, 4);
						echo '<tr><th class="text_form" width="80" style="font-weight:normal">Numero: </th>';
						echo '<td class="row">' . $i . '</td></tr>';
						echo '<tr><th class="text_form" width="80" style="font-weight:normal">Fecha: </th>';
						echo '<td class="row">' . $fec_accion . '</td></tr>';
						echo '<tr><th class="text_form" width="80" style="font-weight:normal"Tipo: </th>';
						echo '<td class="row">' . $row -> Tipo . '</td></tr>';
						echo '<tr><th class="text_form" width="80" style="font-weight:normal">Responsable: </th>';
						echo '<td class="row">' . $row -> Responsable . '</td></tr>';
						echo '<tr><th class="text_form" width="80" style="font-weight:normal" valign="top">Acci&oacute;n: </th>';
						echo '<td class="row">' . $row -> Accion . '</td></tr>';
						echo '</table><br />';
						$i++;
					endforeach;
				}
				echo '<br />';
				echo '<table class="tabla_form" width="980">';
				echo '<thead><tr><th colspan="2">Documentos Generados</th></tr></thead>';
				echo '<tr><th width="80" style="text-align:center"><a href="' . base_url() . 'index.php/procesos/conformidades/documento/' . $idc . '" target="_blank" onMouseover="tip(\'Abrir el documento\')"; onMouseout="cierra_tip()"><img src="' . base_url() . 'includes/img/icons/pdf.png" width="35" /></a></th>';
				echo '<td><a href="' . base_url() . 'index.php/procesos/conformidades/documento/' . $idc . '" target="_blank" onMouseover="tip(\'Abrir el documento\')"; onMouseout="cierra_tip()">No Conformidad Atendida</a></td></tr>';
				echo '</table>';
			}
			?>
			<br /><br />
			<table><tr><td><a href="<?=base_url() ?>index.php/admin/varios/conformidades/<?=$area?>/<?=$estado?>" onmouseover="tip('Regresa al listado de<br />no conformidades')" onmouseout="cierra_tip()"><img src="<?=base_url() ?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url() ?>index.php/admin/varios/conformidades/<?=$area?>/<?=$estado?>" onmouseover="tip('Regresa al listado de<br />no conformidades')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
		</div>
	</div>

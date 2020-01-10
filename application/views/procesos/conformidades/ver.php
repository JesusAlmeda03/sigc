<?php
/****************************************************************************************************
*
*	VIEWS/procesos/quejas/ver.php
*
*		Descripci�n:  		  
*			Vista de la informaci�n de la no conformidad
*
*		Fecha de Creaci�n:
*			30/Octubre/2011
*
*		Ultima actualizaci�n:
*			15/Diciembre/2011
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
			<div class="titulo">No Conformidad <?=$tipo_title?></div>
            <div class="texto">
				<?php
				$formulario = array(
	                // * Boton submit
	                'boton' => array (
	                    'id'		=> 'aceptar',
	                    'name'		=> 'aceptar',
	                    'class'		=> 'in_button',
	                    'onfocus'	=> 'hover(\'aceptar\')'
	                ),
	                // Archivo
	                'archivo' => array (
	                    'name'		=> 'archivo',
	                    'id'		=> 'archivo',
	                    'value'		=> set_value('archivo'),
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('archivo')",
	                )
	            );
				if( $estado_nc == 4 ) {
					echo '<br />';
					echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
					echo '<table class="tabla_form" width="700">';
					echo '<thead><tr><th colspan="2"><span class="titulo_tabla">Evidencias</span></th></tr></thead>';
					echo '<tr><th width="170">Subir Evidencias de la<br />No Conformidad Solventada:</th>';
					echo '<td>'.form_upload($formulario['archivo']).'</td></tr>';
					echo '</table><br />';
					echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
            		echo form_close().'<br />';
				}
				
				echo '<table class="tabla_form" width="700">';
				echo '<thead><tr><th colspan="2"><span class="titulo_tabla">Datos de la No Conformidad</div></th></tr></thead>';
				echo '<tr><th class="text_form" width="80" style="font-weight:normal">Usuario que levant&oacute; la No Conformidad: </th>';
				echo '<td class="row">'.$usu.' '.$aru.'</td></tr>';
				echo '<tr><th class="text_form" style="font-weight:normal">&Aacute;rea: </th>';
				echo '<td class="row">'.$are.'</td></tr>';
				echo '<tr><th class="text_form" style="font-weight:normal">Departamento: </th>';
				echo '<td class="row">'.$dep.'</td></tr>';
				//echo '<tr><th class="text_form" style="font-weight:normal">Consecutivo: </th>';
				//echo '<td class="row">'.$con.'</td></tr>';
				echo '<tr><th class="text_form" style="font-weight:normal">Fecha: </th>';
				echo '<td class="row">'.$fec.'</td></tr>';
				echo '<tr><th class="text_form" style="font-weight:normal">Origen: </th>';
				echo '<td class="row">'.$ori.'</td></tr>';
				echo '<tr><th class="text_form" style="font-weight:normal">Tipo: </th>';
				echo '<td class="row">'.$tip.'</td></tr>';
				echo '<tr><th class="text_form" style="font-weight:normal" valign="top">Descripci&oacute;n: </th>';
				echo '<td class="row">'.$des.'</td></tr>';
				echo '</table>';
				echo '<br />';
				if($aCont -> num_rows() > 0){
					echo '<table class="tabla_form" width="700">';
					echo '<thead><tr><th colspan="2"><span class="titulo_tabla">Acciones de Contencion</div></th></tr></thead>';
					foreach ($aCont -> result() as $contencion){
						echo '<td class="row">'.$contencion->Acciones.'</td></tr>';
					}
					echo '</table>';
					echo '<br />';

					echo '<table class="tabla_form" width="700">';
					echo '<thead><tr><th colspan="2"><span class="titulo_tabla">Evidencia de Acciones de Contencion</div></th></tr></thead>';
					foreach ($aCont -> result() as $contencion){
						echo '<td class="row">'.$contencion->Evidencia.'</td></tr>';
					}
					echo '</table>';
					echo '<br />';
				}else{
				 echo 'No hay';
				}
				if( $seguimiento ) {
					echo '<table class="tabla_form" width="700">';
					echo '<thead><tr><th colspan="2"><span class="titulo_tabla">Datos del Seguimiento de la No Conformidad</span></th></tr></thead>';
					echo '<tr><th class="text_form" width="80" style="font-weight:normal" valign="top">Causa Ra&iacute;z: </th>';
					echo '<td class="row">'.$cau.'</td></tr>';
					echo '<tr><th class="text_form" width="80" style="font-weight:normal" valign="top">Nombre y Puesto del Auditor Responsable de vigilar el cumplimiento: </th>';
					echo '<td class="row">'.$aud.'</td></tr>';
					echo '</table>';
					echo '<br />';
					echo '<table class="tabla_form" width="700">';
					echo '<tr><th style="font-weight:normal" valign="top"><span class="titulo_tabla">Diagrama de Pescado:</span> </th></tr>';					
					echo '<tr><td class="row">';
					if( $diagrama->num_rows() > 0 ) {
						$i = 1;
						echo '<table style="width:690px; background:url('.base_url().'includes/img/pix/pescado.png) no-repeat center center"><tr>';
						foreach( $diagrama->result() as $row ) :
							echo '<td><div style="border:1px solid #EEE; width:150px; height:auto; margin:auto; padding:15px;"><strong>'.$row->Categoria.'</strong><br />'.$row->Causa.'</div></td>';
							if( $i >= 3 ) {
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
					echo '<table class="tabla_form" width="700">';
					echo '<tr><th style="font-weight:normal" valign="top" colspan="2"><span class="titulo_tabla">Acciones a Tomar:</span> </th></tr>';
					if( $acciones->num_rows() > 0 ) {
						$i = 1;
						foreach( $acciones->result() as $row ) :
							switch( substr($row->Fecha,5,2) ) {
								case "00" : $mes = ""; break;
								case "01" : $mes = "Enero"; break;
								case "02" : $mes = "Febrero"; break;
								case "03" : $mes = "Marzo"; break;
								case "04" : $mes = "Abril"; break;
								case "05" : $mes = "Mayo"; break;
								case "06" : $mes = "Junio"; break;
								case "07" : $mes = "Julio"; break;
								case "08" : $mes = "Agosto"; break;
								case "09" : $mes = "Septiembre"; break;
								case "10" : $mes = "Octubre"; break;
								case "11" : $mes = "Noviembre"; break;
								case "12" : $mes = "Diciembre"; break;					
							}
							$fec_accion = substr($row->Fecha,8,2)." / ".$mes." / ".substr($row->Fecha,0,4);
							echo '<tr><th class="text_form" width="80" style="font-weight:normal">Numero: </th>';
							echo '<td class="row">'.$i.'</td></tr>';
							echo '<tr><th class="text_form" width="80" style="font-weight:normal">Fecha: </th>';
							echo '<td class="row">'.$fec_accion.'</td></tr>';
							echo '<tr><th class="text_form" width="80" style="font-weight:normal"Tipo: </th>';
							echo '<td class="row">'.$row->Tipo.'</td></tr>';
							echo '<tr><th class="text_form" width="80" style="font-weight:normal">Responsable: </th>';
							echo '<td class="row">'.$row->Responsable.'</td></tr>';
							echo '<tr><th class="text_form" width="80" style="font-weight:normal" valign="top">Acci&oacute;n: </th>';
							echo '<td class="row">'.$row->Accion.'</td></tr>';
							$i++;
						endforeach;
					}
					echo '</table><br />';
					echo '<br />';
					echo '<table class="tabla_form" width="700">';
					echo '<thead><tr><th colspan="2"><span class="titulo_tabla">Documentos</span></th></tr></thead>';
					echo '<tr><th width="80" style="text-align:center"><a href="'.base_url().'index.php/procesos/conformidades/documento/'.$id.'" target="_blank" onMouseover="tip(\'Abrir el documento\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/pdf.png" width="35" /></a></th>';
					echo '<td><a href="'.base_url().'index.php/procesos/conformidades/documento/'.$id.'" target="_blank" onMouseover="tip(\'Abrir el documento\')"; onMouseout="cierra_tip()">Documento de la No Conformidad Atendida</a></td></tr>';
					/*if( $evidencias->num_rows() > 0 ) {
						$i = 1;
						foreach( $evidencias->result() as $row ) {
							echo '<tr><th width="80" style="text-align:center"><a href="'.base_url().'includes/docs/'.$row->Evidencia.'" target="_blank" onMouseover="tip(\'Abrir esta evidencia\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/doc.png" width="35" /></a></th>';
							echo '<td><a href="'.base_url().'includes/docs/'.$row->Evidencia.'" target="_blank" onMouseover="tip(\'Abrir esta evidencia\')"; onMouseout="cierra_tip()">Evidencia '.$i.'</a></td></tr>';
							$i++;
						}
					}*/
					echo '</table>';
				}
				
				if( $estado == 'cerrar' ) {
					echo '<br /><table><tr><td><a href="'.base_url().'index.php/procesos/conformidades/'.$estado.'" onmouseover="tip(\'Regresa al listado de<br />no conformidades para cerrar\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/procesos/conformidades/'.$estado.'" onmouseover="tip(\'Regresa al listado de<br />no conformidades\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
				}
				else {
					echo '<br /><table><tr><td><a href="'.base_url().'index.php/listados/conformidades/'.$estado.'" onmouseover="tip(\'Regresa al listado de<br />no conformidades\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/listados/conformidades/'.$estado.'" onmouseover="tip(\'Regresa al listado de<br />no conformidades\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
				}
                ?>
            </div>
		</div>

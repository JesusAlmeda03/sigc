<?php
/****************************************************************************************************
*
*	VIEWS/procesos/minutas/punto.php
*
*		Descripci�n:
*			Vista de los puntos de la minuta
*
*		Fecha de Creaci�n:
*			19/Noviembre/2011
*
*		Ultima actualizaci�n:
*			20/Noviembre/2011
*
*		Autor:
*			ISC Rogelio Casta�eda Andrade
*			HERE (http://www.webHERE.com.mx)
*			rogeliocas@gmail.com
*
****************************************************************************************************/
?>
	<div class="content">
		<link rel="stylesheet" href="<?=base_url()?>includes/colorbox/colorbox.css" />	
		<script src="<?=base_url()?>includes/colorbox/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){				
				$(".iframe").colorbox({iframe:true, width:"730px", height:"400px"});
				$.colorbox.resize()
			});
		</script>
		
		<div class="cont">
			<div class="titulo">
				<?php
				echo $titulo.'<br />';
				echo ' <span style="font-size:18px">'.$periodo.': '.$titulo_punto.'</span>';
				?>
			</div>
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
					// Texto
					$texto => array (
						'name'		=> $texto,
						'id'		=> $texto,
						'value'		=> $texto_contenido,
						'onfocus'	=> "hover(".$texto.")",
						'style'		=> 'height:200px',
					),
					// Texto
					$texto_2 => array (
						'name'		=> $texto_2,
						'id'		=> $texto_2,
						'value'		=> $texto_contenido_2,
						'onfocus'	=> "hover(".$texto_2.")",
						'style'		=> 'height:200px',
					),
				);
				
				// Tabla de avance de la minuta
				$verde = '00D000';
				echo '<table width="700" class="paginas" style="border-collapse:collapse; text-align:center;"><tr>';
				echo '<td style="width:39px; font-size:11px;';
				if( $lug != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/10/'.$idmp.'/0" onmouseover="tip(\'Lugar y Fecha\')" onmouseout="cierra_tip()">L</a></td>';
				echo '<td style="width:39px; font-size:11px;';
				if( $par != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/0/'.$idmp.'/0" onmouseover="tip(\'Participantes\')" onmouseout="cierra_tip()">P</a></td>';
				echo '<td style="width:39px; font-size:11px;';
				if( $pun != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/1/'.$idmp.'/0" onmouseover="tip(\'I. Puntos Pendientes\')" onmouseout="cierra_tip()">I</a></td>';
				echo '<td style="width:39px; font-size:11px;';
				if( $obj != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/2/'.$idmp.'/0" onmouseover="tip(\'II. Objetivos de Calidad\')" onmouseout="cierra_tip()">II</a></td>';
				echo '<td style="width:39px; font-size:11px;';
				if( $pro != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/3/'.$idmp.'/0" onmouseover="tip(\'III. Procesos\')" onmouseout="cierra_tip()">III</a></td>';
				echo '<td style="width:39px; font-size:11px;';
				if( $inf != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/41/'.$idmp.'/0" onmouseover="tip(\'IV. Desempe&ntilde;o<br />Infraestructura y Ambiente de Trabajo\')" onmouseout="cierra_tip()">IV-1</a></td>';
				echo '<td style="width:39px; font-size:11px;';
				if( $cli != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/42/'.$idmp.'/0" onmouseover="tip(\'IV. Desempe&ntilde;o<br />Clima Organizacional\')" onmouseout="cierra_tip()">IV-2</a></td>';
				echo '<td style="width:39px; font-size:11px;';
				if( $sat != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/43/'.$idmp.'/0" onmouseover="tip(\'IV. Desempe&ntilde;o<br />Satisfacci&oacute;n de Usuarios\')" onmouseout="cierra_tip()">IV-3</a></td>';
				echo '<td style="width:39px; font-size:11px;';
				if( $aud != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/44/'.$idmp.'/0" onmouseover="tip(\'IV. Desempe&ntilde;o<br />Auditor&iacute;a Interna\')" onmouseout="cierra_tip()">IV-4</a></td>';
				echo '<td style="width:39px; font-size:11px;';
				if( $cap != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/45/'.$idmp.'/0" onmouseover="tip(\'IV. Desempe&ntilde;o<br />Capacitaci&oacute;n\')" onmouseout="cierra_tip()">IV-5</a></td>';
				echo '<td style="width:39px; font-size:11px;';
				if( $mej != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/46/'.$idmp.'/0" onmouseover="tip(\'IV. Desempe&ntilde;o<br />Mejora Continua\')" onmouseout="cierra_tip()">IV-6</a></td>';
				echo '<td style="width:39px; font-size:11px;';
				if( $que != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/47/'.$idmp.'/0" onmouseover="tip(\'IV. Desempe&ntilde;o<br />Quejas\')" onmouseout="cierra_tip()">IV-7</a></td>';
				echo '<td style="width:39px; font-size:11px;';
				if( $des != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/48/'.$idmp.'/0" onmouseover="tip(\'IV. Desempe&ntilde;o<br />Evaluaci&oacute;n al Desempe&ntilde;o\')" onmouseout="cierra_tip()">IV-8</a></td>';
				echo '<td style="width:39px; font-size:11px;';
				if( $acc != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/5/'.$idmp.'/0" onmouseover="tip(\'V. Acciones Correctivas y Preventivas\')" onmouseout="cierra_tip()">V</a></td>';
				echo '<td style="width:39px; font-size:11px;';
				if( $cam != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/6/'.$idmp.'/0" onmouseover="tip(\'VI. Cambios que podrian afectar al SIGC\')" onmouseout="cierra_tip()">VI</a></td>';
				echo '<td style="width:39px; font-size:11px;';
				if( $rec != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/7/'.$idmp.'/0" onmouseover="tip(\'VII. Recomendaciones para la mejora (Mejora Continua)\')" onmouseout="cierra_tip()">VII</a></td>';
				echo '<td style="width:39px; font-size:11px;';
				if( $asu != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/8/'.$idmp.'/0" onmouseover="tip(\'VIII. Asuntos Generales\')" onmouseout="cierra_tip()">VIII</a></td>';
				echo '<td style="width:39px; font-size:11px;';
				if( $tar != "" ) echo 'background-color:#'.$verde;
				echo '"><a href="'.base_url().'index.php/procesos/minutas/puntos/'.$idm.'/9/'.$idmp.'/0" onmouseover="tip(\'IX. Tareas\')" onmouseout="cierra_tip()">IX</a></td>';
				echo '</tr></table>';
				
				switch( $idp ) {
					// Lugar y Fecha
					case 10 :
						$formulario[$texto]['style'] = 'height:100px';						
						echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
						echo '<table class="tabla_form" width="700">';
						echo '<tr><th class="text_form" valign="top" style="padding-top:10px; text-align:left" width="70">'.$titulo_punto.': </th></tr>';
						echo '<tr><td>'.form_textarea($formulario[$texto]).'</td></tr>';
						echo '</table><br />';
						echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
						echo form_close();
						break;

					// II. Objetivos de Calidad
					case 2 :						
						echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
						echo '<table class="tabla_form" width="700">';						
						echo '<tr><th width="20" style="background-color:#F8A4A7"><a class="iframe" href="'.base_url().'index.php/procesos/objetivos" onmouseover="tip(\'Abrir informaci&oacute;n de<br />los Objetivos de Calidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/link.png" /></a></th><th class="text_form" valign="middle" style="padding-top:10px; text-align:left">'.$titulo_punto.': </th></tr>';				
						echo '<tr><td colspan="2">'.form_textarea($formulario[$texto]).'</td></tr>';
						echo '</table><br />';
						echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
						echo form_close();
						break;
						
					// III. Procesos
					case 3 :						
						echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
						echo '<table class="tabla_form" width="700">';
						echo '<tr><th width="20" style="background-color:#F8A4A7"><a class="iframe" href="'.base_url().'index.php/procesos/indicadores" onmouseover="tip(\'Abrir informaci&oacute;n de<br />los Indicadores\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/link.png" /></a></th><th class="text_form" valign="middle" style="padding-top:10px; text-align:left">'.$titulo_punto.': </th></tr>';				
						echo '<tr><td colspan="2">'.form_textarea($formulario[$texto]).'</td></tr>';
						echo '</table><br />';
						echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
						echo form_close();
						break;
																						
					// IV. Desempeño - Infraestructura y Ambiente de Trabajo
					case 41 :
						$formulario[$texto]['style'] = 'height:100px';
						$formulario[$texto_2]['style'] = 'height:100px'; 
						echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
						echo '<table class="tabla_form" width="700">';
						echo '<tr><th class="text_form" valign="top" style="padding-top:10px; text-align:left" width="70">'.$titulo_punto.': </th></tr>';
						echo '<tr><td>Atendiadas</td></tr><tr><td>'.form_textarea($formulario[$texto]).'</td></tr>';
						echo '<tr><td>No Atendiadas</td></tr><tr><td>'.form_textarea($formulario[$texto_2]).'</td></tr>';
						echo '</table><br />';
						echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
						echo form_close();
						break;
						
					// IV. Quejas
					case 47 :						
						echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
						echo '<table class="tabla_form" width="700">';
						echo '<tr><th width="20" style="background-color:#F8A4A7"><a class="iframe" href="'.base_url().'index.php/listados/quejas/all/0" onmouseover="tip(\'Abrir informaci&oacute;n de<br />las Quejas\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/link.png" /></a></th><th class="text_form" valign="middle" style="padding-top:10px; text-align:left">'.$titulo_punto.': </th></tr>';				
						echo '<tr><td colspan="2">'.form_textarea($formulario[$texto]).'</td></tr>';
						echo '</table><br />';
						echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
						echo form_close();
						break;

					// V. Acciones Correctivas y Preventivas
					case 5 :
						echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
						echo '<table class="tabla_form" width="700">';
						echo '<tr><th width="20" style="background-color:#F8A4A7"><a class="iframe" href="'.base_url().'index.php/listados/conformidades/all/0" onmouseover="tip(\'Abrir informaci&oacute;n de<br />las No Conformidades\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/link.png" /></a></th><th class="text_form" valign="middle" style="padding-top:10px; text-align:left">'.$titulo_punto.': </th></tr>';				
						echo '<tr><td colspan="2">'.form_textarea($formulario[$texto]).'</td></tr>';
						echo '</table><br />';
						echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
						echo form_close();
						break;
												
					// Todos los puntos
					default :
						echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
						echo '<table class="tabla_form" width="700">';
						echo '<tr><th class="text_form" valign="top" style="padding-top:10px; text-align:left" width="70">'.$titulo_punto.': </th></tr>';
						echo '<tr><td>'.form_textarea($formulario[$texto]).'</td></tr>';
						echo '</table><br />';
						echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
						echo form_close();
						break;
				}
                ?>
        </div>
    </div>
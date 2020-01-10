<?php
/****************************************************************************************************
*
*	VIEWS/evaluaciones/clima/resultados.php
*
*		Descripción:
*			Vista de los resultados de la evaluación
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
			<div class="titulo"><?=$titulo?><br /><span style="font-size:22px">Gr&aacute;fica / Tabla de Resultados</span></div>
            <div class="texto">          	
            	<?php
            	$evaluacion_extras = 'id="evaluacion" onfocus="hover(\'evaluacion\')" style="width:400px"';
            	$area_extras = 'id="area" onfocus="hover(\'area\')" style="width:400px" ';
				$seccion_extras = 'id="seccion" onfocus="hover(\'seccion\')" style="width:400px"';
				
				$formulario = array(
					// * Boton submit
					'boton' => array (
						'id'		=> 'aceptar',
						'name'		=> 'aceptar',
						'class'		=> 'in_button',
						'onfocus'	=> 'hover(\'aceptar\')',
						'style'		=> 'width:250px'
					),
				);
														
				echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Elige las opciones para visualizar la gr&aacute;fica de resultados</td></tr></table><br />';
				echo '<table class="tabla_form" width="700">';
				echo '<tr>';
				echo '	<th class="text_form">Evaluaci&oacute;n</th>';
				echo '	<td>'.form_dropdown('evaluacion',$eva,set_value('evaluacion'),$evaluacion_extras).'</td>';
				echo '</tr>';
				echo '<tr>';
				echo '	<th width="210" class="text_form">&Aacute;rea:</th>';
				echo '	<td>'.form_dropdown('area',$areas,set_value('area'),$area_extras).'</td>';
				echo '</tr>';
				echo '<tr>';
				echo '	<th class="text_form">Secci&oacute;n de la Evaluaci&oacute;n</th>';
				echo '	<td>'.form_dropdown('seccion',$sec,set_value('seccion'),$seccion_extras).'</td>';
				echo '</tr>';
				echo '</table><br />';
				echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Ver Gráfica / Tabla').'</div>';
				echo form_close();				
				
				?>
				<br />
                <table><tr><td><a href="<?=base_url()?>index.php/evaluaciones/<?=$evaluacion?>" onmouseover="tip('Regresa a las opciones de la evaluaci&oacute;n')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/evaluaciones/<?=$evaluacion?>" onmouseover="tip('Regresa a las opciones de la evaluaci&oacute;n')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
			</div>
		</div>
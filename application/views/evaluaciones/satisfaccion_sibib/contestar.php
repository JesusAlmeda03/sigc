<?php
/****************************************************************************************************
*
*	VIEWS/evaluaciones/contestar_biblioteca.php
*
*		Descripción:
*			Vista para contestar la evaluación de satisfaccion de usuarios del SIBIB
*
*		Fecha de Creación:
*			20/Febrero/2012
*
*		Ultima actualización:
*			20/Febrero/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			HERE (http://www.webHERE.com.mx)
*			rogeliocas@gmail.com
*
****************************************************************************************************/
?>
	<div class="content">		
		<div class="cont">
			<div class="titulo"><?=$titulo?><br /><span style="font-size:22px"><?=$biblioteca?></span></div>
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
					// * Boton revisar
		            'boton_revisar' => array (
		                'id'		=> 'revisar',
		                'name'		=> 'revisar',
		                'class'		=> 'in_button',
		                'onfocus'	=> 'hover(\'revisar\')',
						'onclick'	=> 'revisar_preguntas()',
						'style'		=> 'width:150px; height:55px; margin-left:10px'
		            ),			
				);
                echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Antes de ingresar los resultados, debes tener cuidado de que la <strong>suma de todas las respuestas de cada pregunta</strong> sea igual al <strong>n&uacute;mero total de usuarios de '.$biblioteca.' encuestados</strong></td></tr></table><br />';
				echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));				
				if( $secciones->num_rows() > 0 ) {
					foreach( $secciones->result() as $row ) {
						if( $preguntas->num_rows() > 0 ) {							
							echo '<table class="tabla_form" width="670" style="border:1px solid #EEE;">';
							echo '<thead><tr><th colspan="2" style="font-size:18px; text-align:center">'.$row->Seccion.'</th></tr></thead>';
							echo '<tr><th width="250">N&uacute;mero total de usuarios de '.$biblioteca.' encuestados:</th>';
							echo '<td><input type="text" class="in_text" value="0" style="margin-top:10px" name="sec_'.$row->IdSeccion.'" id="sec_'.$row->IdSeccion.'" onfocus="hover(\'sec_'.$row->IdSeccion.'\')" /></td></tr>';
							echo '<tr><td colspan="2">';
							$i = 1;
							foreach( $preguntas->result() as $row_p ) {
								if( $row->IdSeccion == $row_p->IdSeccion ) {
									echo '<table class="tabla_form" width="690" style="border:1px solid #EEE; margin-bottom:10px">';
									echo '<tr><th><strong style="font-size:28px" class="menu_item">'.$i.'.</strong> '.$row_p->Pregunta.'</th></tr>';
									echo '<tr><td style="padding-left:20px">';									
									if( $opciones->num_rows() > 0 ) {
										foreach( $opciones->result() as $row_o ) {
											$caja_texto =  array (
													'name'		=> $row->IdSeccion.'_'.$row_p->IdPregunta.'_'.$row_o->IdOpcion,
													'id'		=> $row->IdSeccion.'_'.$row_p->IdPregunta.'_'.$row_o->IdOpcion,
													'value'		=> set_value($row->IdSeccion.'_'.$row_p->IdPregunta.'_'.$row_o->IdOpcion, '0'),
													'class'		=> 'in_text',
													'onfocus'	=> "hover('".$row->IdSeccion."_".$row_p->IdPregunta."_".$row_o->IdOpcion."')",
													'style'		=> 'width:25px; text-align:right; margin-right:10px'
											);
											echo form_input($caja_texto);
											echo $row_o->Opcion."<br />";
										}
									}									
									echo '</td></tr>';
									echo '</table>';
									$i++;
								}
							}
							echo '</td></tr>';
							echo '</table><br /><br />';
						}						
					}															
				}				
				echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
				echo form_close();                
				?>
				<br />
				<table><tr><td><a href="<?=base_url()?>index.php/evaluaciones/satisfaccion_sibib/presentacion" onmouseover="tip('Regresa a opciones<br />de la evaluaci&oacute;n')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/evaluaciones/satisfaccion_sibib/presentacion" onmouseover="tip('Regresa a opciones<br />de la evaluaci&oacute;n')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
			</div>
		</div>
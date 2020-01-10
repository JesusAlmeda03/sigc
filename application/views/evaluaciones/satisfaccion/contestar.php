<?php
/****************************************************************************************************
*
*	VIEWS/evaluaciones/satisfaccion/contestar.php
*
*		Descripción:
*			Vista para contestar la evaluación de satisfaccion de usuarios
*
*		Fecha de Creación:
*			20/Febrero/2012
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
			<div class="titulo"><?=$titulo?><br /><span style="font-size:22px"><?=$seccion?></span></div>
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
				
                echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Antes de ingresar los resultados, debes tener cuidado de que la <strong>suma de todas las respuestas de cada pregunta</strong> sea igual al <strong>n&uacute;mero total de usuarios encuestados</strong></td></tr></table><br />';
				echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
				if( $preguntas->num_rows() > 0 ) {							
					echo '<table class="tabla_form" width="700" style="border:1px solid #EEE;">';
					echo '<tr><th width="200">N&uacute;mero total de '.$seccion.' encuestados:</th>';
					echo '<td><input type="text" class="in_text" value="0" style="width:100px; margin-top:10px" name="sec_'.$ids.'" id="sec_'.$ids.'" onfocus="hover(\'sec_'.$ids.'\')" /></td></tr>';
					echo '</table><br />';
					$i = 1;
					foreach( $preguntas->result() as $row_p ) {						
						echo '<table class="tabla_form" width="700" style="border:1px solid #EEE; margin-bottom:10px">';
						echo '<tr><th><strong style="font-size:28px" class="menu_item">'.$i.'.</strong> '.$row_p->Pregunta.'</th></tr>';									
						echo '<tr><td style="padding-left:20px">';									
						if( $opciones->num_rows() > 0 ) {
							foreach( $opciones->result() as $row_o ) {
								$caja_texto =  array (
										'name'		=> $ids.'_'.$row_p->IdPregunta.'_'.$row_o->IdOpcion,
										'id'		=> $ids.'_'.$row_p->IdPregunta.'_'.$row_o->IdOpcion,
										'value'		=> set_value($ids.'_'.$row_p->IdPregunta.'_'.$row_o->IdOpcion, '0'),
										'class'		=> 'in_text',
										'onfocus'	=> "hover('".$ids."_".$row_p->IdPregunta."_".$row_o->IdOpcion."')",
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
				echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
				echo form_close();                
				?>
				<br />
				<table><tr><td><a href="<?=base_url()?>index.php/evaluaciones/satisfaccion/presentacion" onmouseover="tip('Regresa al listado')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/evaluaciones/satisfaccion/presentacion" onmouseover="tip('Regresa al listado')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
			</div>
		</div>
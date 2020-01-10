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
			<div class="titulo"><?=$titulo?><br /><span style="font-size:22px">Listado de Preguntas</span></div>
            <div class="texto">
				<?php 
                if( $secciones->num_rows() > 0 ) {			
                    foreach( $secciones->result() as $row_sec ) :
						echo '<table class="tabla_form" id="tabla" width="700"><tr><th colspan="2" class="titulo_tabla" style="font-size:22px; text-align:center">'.$row_sec->Seccion.'</th></tr>';
		                if( $preguntas->num_rows() > 0 ) {
							$i = 0;
							$j = 1;
		                    foreach( $preguntas->result() as $row_pre ) :
								if( $row_sec->IdSeccion == $row_pre->IdSeccion ) {
									if( $i ) {
										echo '<tr class="odd">';
										$i = 0;
									}
									else {
										echo '<tr>';
										$i = 1;
									}
									echo '<th class="titulo_tabla" style="font-size:24px" width="15">'.$j.'.</th>';
									echo '<td>'.$row_pre->Pregunta.'</td>';
									echo '</tr>';
									$j++;
								}
							endforeach;
							echo '</table><br />';
						}
					endforeach;
				}
                else {
                    echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento esta evaluaci&oacute;n no tiene preguntas</td></tr></table>';
                }
                ?>
                <br />
                <table><tr><td><a href="<?=base_url()?>index.php/evaluaciones/<?=$evaluacion?>" onmouseover="tip('Regresa a las opciones de la evaluaci&oacute;n')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/evaluaciones/<?=$evaluacion?>" onmouseover="tip('Regresa a las opciones de la evaluaci&oacute;n')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
			</div>
		</div>
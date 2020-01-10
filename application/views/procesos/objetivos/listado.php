<?php
/****************************************************************************************************
*
*	VIEWS/procesos/objetivos/listado.php
*
*		Descripci�n:
*			Listado de todos los indicadores
*
*		Fecha de Creaci�n:
*			17/Noviembre/2011
*
*		Ultima actualizaci�n:
*			17/Noviembre/2011
*
*		Autor:
*			ISC Rogelio Casta�eda Andrade
*			HERE (http://www.webHERE.com.mx)
*			rogeliocas@gmail.com
*
****************************************************************************************************/
?>
	<div class="content">
		<div class="cont">
			<div class="titulo"><?=$titulo?></div>
            <div class="texto">
				<?php
        	if( $objetivos->num_rows() > 0 ) {
            foreach( $objetivos->result() as $row_obj ){
							echo '<table class="tabla_form" id="tabla" width="700"><tr><th class="text_form" style="font-size:16px; text-align:center">'.$row_obj->Objetivo.'</th></tr></table>';
			          if( $indicadores->num_rows() > 0 ) {
									echo '<table class="tabla" id="tabla" width="700">';
									echo '<tbody>';
									$i = 0;
		            	foreach( $indicadores->result() as $row_ind ){
										if( $row_obj->IdObjetivo == $row_ind->IdObjetivo ) {
											if( $i ) {
												echo '<tr class="odd">';
												$i = 0;
											}else{
												echo '<tr>';
												$i = 1;
											}
												echo '<th width="30" style="text-align:center"><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$row_ind->IdIndicador.'/todos" onmouseover="tip(\'Revisar el Objetivo de Calidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/grafica.png" /></a></th>';
												echo '<td><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$row_ind->IdIndicador.'/todos">'.$row_ind->Indicador.'</a></td>';
												echo '</tr>';
										}

								}

								echo '</tbody></table><br />';
							}else{
	              echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay objetivos de calidad</td></tr></table>';
	            }
						}
					}?>
        </div>
    </div>

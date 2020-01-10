<?php
/****************************************************************************************************
*
*	VIEWS/procesos/objetivos/mediciones.php
*
*		Descripci�n:
*			Vista para eliminar / ver las mediciones del indicador
*
*		Fecha de Creaci�n:
*			16/Noviembre/2011
*
*		Ultima actualizaci�n:
*			25/Septiembre/2011
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
			<div class="titulo"><?=$titulo?></div>
            <div class="texto">				            
	            <?php
				// Listado de mediciones
                if( $mediciones->num_rows() > 0 ) {
					echo '<table class="tabla_form" width="700">';
					echo '<tr><th>Fecha</th><th>Medici&oacute;n</th><th width="20"></th></tr>';
					$i = 1;
                    foreach( $mediciones->result() as $row ) :
						if( $i ) {
							echo '<tr>';
							$i--;
						}
						else {
							echo '<tr class="odd">';
							$i++;
						}						
						switch( substr($row->Fecha,5,2) ) {
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
						$fecha = substr($row->Fecha,8,2)." / ".$mes." / ".substr($row->Fecha,0,4);
						echo '<td>'.$fecha.'</td><td>'.$row->Medicion.'%</td>';
						echo '<td><a onclick="pregunta_eliminar_medicion('.$id.','.$row->IdObjetivoMedicion.',\'&iquest;Deseas eliminar esta medici&oacute;n?\',\'objetivos\')" onMouseover="tip(\'Eliminar medici&oacute;n\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';
					endforeach;
					echo '</table>';
				}
				echo '<br /><br /><table><tr><td><a href="'.base_url().'index.php/procesos/objetivos/grafica/'.$id.'/todos" onmouseover="tip(\'Regresa a la gr&aacute;fica del<br />Indicador del Objetivo de Calidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/procesos/objetivos/grafica/'.$id.'/todos" onmouseover="tip(\'Regresa a la gr&aacute;fica del<br />Indicador del Objetivo de Calidad\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';				
                ?>                
        	</div>
    	</div>
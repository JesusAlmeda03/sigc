<?php
/****************************************************************************************************
*
*	VIEWS/procesos/indicadores/grafica.php
*
*		Descripción:
*			Vista de la grafica de los indicadores
*
*		Fecha de CreaciÓn:
*			16/Noviembre/2011
*
*		Ultima actualizaciÓn:
*			22/Febrero/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
?>
	<div class="cont_admin">
		<div class="titulo"><?=$titulo?></div>
        <div class="texto">
            <?php
			$formulario = array(
				// Fecha
				'fecha' => array (
					'name'		=> 'fecha',
					'id'		=> 'fecha',
					'value'		=> set_value('fecha'),
					'class'		=> 'in_text',
					'onfocus'	=> "hover('fecha')",
					'style'		=> 'width:200px'
				),
				// Fecha
				'medicion' => array (
					'name'		=> 'medicion',
					'id'		=> 'medicion',
					'value'		=> set_value('medicion'),
					'class'		=> 'in_text',
					'onfocus'	=> "hover('medicion')",
					'style'		=> 'width:200px'
				),
			);
			
			// Datos del Indicador
            if( $indicador->num_rows() > 0 ) {
				echo '<table class="tabla_form" width="980">';
				$i = 0;
                foreach( $indicador->result() as $row ) :
					$tipo = $row->Tipo;
					echo '<tr><th width="70">Indicador</th><td>'.$row->Indicador.'</td></tr>';
					echo '<tr><th>Meta</th><td>'.$row->Meta.'</td></tr>';
					echo '<tr><th>Calculo</th><td>'.$row->Calculo.'</td></tr>';
					echo '<tr><th>Frecuencia</th><td>'.$row->Frecuencia.'</td></tr>';
					echo '<tr><th>Responsable</th><td>'.$row->Responsable.'</td></tr>';
					if( $row->Observaciones != "" )
						echo '<tr style="border-bottom:1px solid #EEE"><th>Observaciones</th><td>'.$row->Observaciones.'</td></tr>';
                endforeach;
				echo '</tbody></table>';
            }
			
			// Años
			echo $anos;
			
			// Gafica
            echo $grafica;
			
			// Listado de mediciones
            if( $mediciones->num_rows() > 0 ) {
				echo '<table class="tabla" width="980">';
				echo '<thead><tr><th>Fecha</th><th>Medici&oacute;n</th></tr></thead>';
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
					echo '<td>'.$fecha.'</td><td>'.$row->Medicion;
					if( $tipo == 'DIA' )
						echo ' dias';
					else
						echo '%';
					echo '</td></tr>';
				endforeach;
				echo '</table>';
				
				echo '<br /><br /><table><tr><td><a href="'.base_url().'index.php/admin/varios/indicadores/'.$area.'/'.$estado.'" onmouseover="tip(\'Regresa al listado de indicadores\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/admin/varios/indicadores/'.$area.'/'.$estado.'" onmouseover="tip(\'Regresa al listado de no indicadores\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
			}				
			?>            
    	</div>
	</div>
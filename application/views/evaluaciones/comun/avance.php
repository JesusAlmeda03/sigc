<?php
/****************************************************************************************************
*
*	VIEWS/evaluaciones/comun/avance.php
*
*		Descripción:  		  
*			Vista del listado del personal faltante de contestar la evalucion
*
*		Fecha de Creación:
*			29/Febrero/2012 (bisiesto :D)
*
*		Ultima actualización:
*			29/Febrero/2012 (bisiesto :D)
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
			<div class="titulo"><?=$titulo?><br /><span style="font-size:22px">Avance</span></div>
            <div class="texto"><br />
				<?php
			// Genera los datos de la tabla
				$i = 0;
				$j = 0;
				$total = 0;
				$tabla  = '<table class="tabla" id="tabla" width="700">';
				$tabla .= '<thead><tr><th class="no_sort" width="15"></tg><th>Nombre</th><th>Porcentaje de Avance de cada Persona</th></tr></thead>';
				foreach( $listado as $row ) {
					if( $i ) {
						$tabla .= '<tr>';
						$i = 0;
					}
					else {
						$tabla .= '<tr class="odd">';
						$i = 1;
					}
					if( $row['Porcentaje'] == '100' ) {
						$tabla .= '<th><img onmouseover="tip(\'Evaluacion terminada\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/terminada.png" /></th>';
					}
					else {
						$tabla .= '<th><img onmouseover="tip(\'Evaluacion pendiente\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/pendiente.png" /></th>';
					}
					$tabla .= '<td>'.$row['Nombre'].'</td><td>'.$row['Porcentaje'].' %</td></tr>';
					$total = $total + $row['Porcentaje'];
					$j++;
				}				
				$total = round( ( $total / $j ) * 100 ) / 100 ;
				$tabla .= '</tbody></table>';
				$tabla .= $sort_tabla;
				
			// Porcentaje de avance
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="titulo_tabla" style="font-size:24px">Avance TOTAL del &aacute;rea</th><td style="font-size:24px; text-align:center">'.$total.'%</td></tr>';
				echo '</table><br />';
				
			// Imprime la tabla
				echo $tabla;
				?>
				<br />
                <table><tr><td><a href="<?=base_url()?>index.php/evaluaciones/<?=$evaluacion?>" onmouseover="tip('Regresa a las opciones de la evaluaci&oacute;n')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/evaluaciones/<?=$evaluacion?>" onmouseover="tip('Regresa a las opciones de la evaluaci&oacute;n')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
			</div>
		</div>
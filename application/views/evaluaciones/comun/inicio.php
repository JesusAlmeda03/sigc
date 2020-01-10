<?php
/****************************************************************************************************
*
*	VIEWS/evaluaciones/inicio.php
*
*		Descripción:
*			Vista del inicio de las evaluaciones
*
*		Fecha de Creación:
*			22/Noviembre/2011
*
*		Ultima actualización:
*			22/Noviembre/2011
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
            <div class="texto"><br />
				<?php
                if( $evalua ) {
	                echo '<table class="tabla_opciones" style="width:700px">';
                    echo '<tr >';
                    echo '	<th width="100" style="text-align:center; padding:15px 0;"><a href="'.base_url().'index.php/evaluaciones/'.$evaluacion.'/presentacion" onmouseover="tip(\'Realizar la evaluaci&oacute;n\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/evaluacion.png" /></a></th>';
                    echo '	<td><a style="color:#333; font-size:18px" href="'.base_url().'index.php/evaluaciones/'.$evaluacion.'/presentacion">Contestar '.$nombre.'</a></td>';
                    echo '</tr>';
	                echo '</table><br />';
                }

				if( $grafica ) {
	                echo '<table class="tabla_opciones" style="width:700px">';
                    echo '<tr >';
                    echo '	<th width="100" style="text-align:center; padding:15px 0;"><a href="'.base_url().'index.php/evaluaciones/'.$evaluacion.'/resultados" onmouseover="tip(\'Graficas de restultados\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/evaluacion_grafica.png" /></a></th>';
                    echo '	<td><a style="color:#333; font-size:18px" href="'.base_url().'index.php/evaluaciones/'.$evaluacion.'/resultados">Gr&aacute;ficas / Tablas de Resultados</a></td>';
                    echo '</tr>';
	                echo '</table><br />';
                }

				if( $preguntas ) {

	                echo '<table class="tabla_opciones" style="width:700px">';
                    echo '<tr >';
                    echo '	<th width="100" style="text-align:center; padding:15px 0;"><a href="'.base_url().'index.php/evaluaciones/'.$evaluacion.'/preguntas" onmouseover="tip(\'Ver listado de las preguntas\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/evaluacion_pregunta.png" /></a></th>';
                    echo '	<td><a style="color:#333; font-size:18px" href="'.base_url().'index.php/evaluaciones/'.$evaluacion.'/preguntas">Ver Listado de las Preguntas</a></td>';
                    echo '</tr>';
	                echo '</table><br />';
                }

				if( $avance ) {

	                echo '<table class="tabla_opciones" style="width:700px">';
                    echo '<tr >';
                    echo '	<th width="100" style="text-align:center; padding:15px 0;"><div style="margin:9px 0 9px 0"><a href="'.base_url().'index.php/evaluaciones/'.$evaluacion.'/avance" onmouseover="tip(\'Ver listado del personal faltante\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/evaluaciones_usuarios.png" width="30" /></a></div></th>';
                    echo '	<td><a style="color:#333; font-size:18px" href="'.base_url().'index.php/evaluaciones/'.$evaluacion.'/avance">Porcentaje de Avance en el &Aacute;rea. ';//<span style="font-weight:bold; font-size:24px">'.$total.'%</span></a></td>';
                    echo '</tr>';
	                echo '</table><br />';
                }
                ?>
			</div>
		</div>

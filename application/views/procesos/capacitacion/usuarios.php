<?php
/****************************************************************************************************
*
*	VIEWS/procesos/capacitacion/usuarios.php
*
*		Descripción:
*			Vista para elegir los usuarios para evaluar sus habilidades
*
*		Fecha de Creación:
*			05/Febrero/2013
*
*		Ultima actualización:
*			05/Febrero/2013
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
            	echo '<table class="tabla" width="700">';//<tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Elige el usuario para el que vas a evaluar sus Habilidades y Aptitudes</td></tr></table><br />';
				if( $usuarios->num_rows() > 0 ) {
					echo '<table class="tabla" width="700">';
					foreach( $usuarios->result() as $row ) {
						echo '<tr>';
						echo '	<th width="15"><a href="'.base_url().'index.php/procesos/capacitacion/evaluar/'.$id_evaluacion.'/'.$row->IdUsuario.'" onmouseover="tip(\'Evaluar habilidades/aptitudes\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/seguimiento.png"></th>';
						echo '	<td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.'</td>';
						echo '</tr>';
					}
					echo '</table>';
				}
				else {
					echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Esta evaluación ya esta terminada. Sin embargo la alerta estara activa mientras el periodo este activo.</td></tr></table>';
				}
            	?>
            </div>
		</div>

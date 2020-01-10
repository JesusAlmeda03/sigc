<?php
/****************************************************************************************************
*
*	VIEWS/areas/inicio.php
*
*		Descripción:
*			Áreas Administrativas Certificadas del sistema
*
*		Fecha de Creación:
*			12/Octubre/2012
*
*		Ultima actualización:
*			12/Octubre/2012
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
				if( $areas->num_rows() > 0 ) {
					echo '<table>';
					echo '<tr>';
					$i = 0;
					foreach( $areas->result() as $row ) {
						if( $i == 4 ) {
							echo '</tr><tr>';
							$i = 0;
						}
						echo '<td style="padding:2px"><table class="tabla_form" style="width:169px; height:150px"><tr><td class="area" style="font-size:24px; text-align:center">'.$row->Area.'</td></tr></table></td>';
						$i++;
					}
					echo '</tr>';
					echo '</table>';
				}
				?>
			</div>
		</div>
<?php
/****************************************************************************************************
*
*	VIEWS/inicio/instructivos.php
*
*		Descripción:
*			Vista de los instructivos para la auditoría
*
*		Fecha de Creación:
*			31/Octubre/2011
*
*		Ultima actualización:
*			31/Octubre/2011
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
			<div class="titulo"><?=$titulo_pagina?></div>
            <div class="texto">
				<?php
				echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>A continuaci&oacute;n se te presentan los Instructivos de Trabajo relacionados con los Procesos que tu Equipo tiene asignados para auditar.</td></tr></table><br />';
				
				if( $instructivos->num_rows() > 0 ) {
            		echo '<table class="tabla" id="tabla" width="700">';
					echo '	<thead>';
					echo '		<tr>';
					echo '			<th width="15" class="no_sort"></th>';
					echo '			<th>Proceso</th>';
					echo '			<th>&Aacute;rea</th>';
					echo '			<th width="20">C&oacute;digo</th>';
					echo '			<th>Nombre</th>';
					echo '		</tr>';
					echo '	</thead>';
					echo '	<tbody>';
					foreach( $instructivos->result() as $row ) {
						// obtiene la extensión del documento
						if( substr($row->Ruta,11) == "." ) { 
							$ext = substr($row->Ruta,12);
						}
						else {
							$doc = $row->Ruta;
							$j = 0;
							$k = 0;
							$i = strlen($doc) - 1;
							for ( $i; $i > 0 ; $i-- ) {
								if ( $doc[$i] == "." ){
									$j = $k;
									break;
								}
								$k++;
							}
							$ext = substr($doc,strlen($doc)-$j,$j);						
						}
						
						echo '	<tr>';
						echo '		<th><a href="'.base_url().'includes/docs/'.$row->Ruta.'" onMouseover="ddrivetip(\''.$row->Nombre.'\')"; onMouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/'.$ext.'.png" width="35" /></a></th>';
						echo '		<td>'.$row->Proceso.'</td>';						
						echo '		<td>'.$row->Area.'</td>';
						echo '		<td>'.$row->Codigo.'</td>';
						echo '		<td>'.$row->Nombre.'</td>';
						echo '		</tr>';
                    }
					echo '	</tbody>';
					echo '</table>';
					echo $sort_tabla;
                }
                else {
                    echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay documentos</td></tr></table>';
                }
				?>
				<br /><br />
				<table><tr><td><a href="<?=base_url()?>index.php/auditoria" onmouseover="tip('Regresa al listado<br />de actividades del auditor')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/auditoria" onmouseover="tip('Regresa al listado<br />de actividades del auditor')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
			</div>
		</div>
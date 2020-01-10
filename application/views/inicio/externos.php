<?php
/****************************************************************************************************
*
*	VIEWS/inicio/documentos.php
*
*		Descripción:
*			Vista del listado de las listas maestras de los documentos
*
*		Fecha de Creación:
*			15/Octubre/2012
*
*		Ultima actualización:
*			15/Octubre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			@rogelio_cas
*			rogeliocas@gmail.com
*
****************************************************************************************************/
?>
	<div class="content">		
		<div class="cont">
			<div class="titulo"><?=$titulo?></div>
            <div class="texto">
            	<?php
	            if( $documentos->num_rows() > 0 ) {
	                echo '<table class="tabla" id="tabla" width="700">';
	                echo '<thead><tr>';	                
					echo '<th class="no_sort" style="border:0; border-bottom:1px solid #E0E0E0"></th>';
					echo '<th class="no_sort">Nombre</th>';
					echo '<th>Responsable</th>';
					echo '<th width="20">Edici&oacute;n</th>';
					echo '<th width="20">Ubica&oacute;n</th>';
					echo '</tr></thead><tbody>';
	                foreach( $documentos->result() as $row ) {
	                    echo '<tr>';
						echo '<th></th>';
	                    echo '<td>'.$row->Nombre.'</td>';
						echo '<td>'.$row->Responsable.'</td>';
	                    echo '<td>'.$row->Edicion.'</td>';
						echo '<td>'.$row->Ubicacion.'</td>';
	                    echo '</tr>';
	                }
	                echo '</tbody></table>';
					echo $sort_tabla;
	            }
	            else {
	                echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay documentos</td></tr></table>';
	            }
	            ?>
            </div>
		</div>
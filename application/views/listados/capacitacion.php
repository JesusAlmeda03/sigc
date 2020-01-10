<?php
/****************************************************************************************************
*
*	VIEWS/listados/mantenimiento.php
*
*		Descripción:
*			Vista del listado de los programas de mantenimiento de equipo de cómputo
*
*		Fecha de Creación:
*			16/Abril/2011
*
*		Ultima actualización:
*			21/Septiembre/2012
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
                if( $consulta->num_rows() > 0 ) {
					echo '<table class="tabla" id="tabla" width="700">';
					echo '<thead><tr><th class="no_sort" width="10"></th><th width="150">Curso</th><th width="15%">Fecha</th><th width="150">Tipo</th><th width="150">Observaciones</th>';
					echo '</tr></thead><tbody>';
                    foreach( $consulta->result() as $row ) :						
                        echo '<tr>';
						echo '<th><img src="'.base_url().'includes/img/icons/terminada.png"></th>';
						echo '<td>'.$row->Curso.'</td>';
						echo '<td>'.$row->Fecha.'</td>';
						echo '<td>'.$row->Tipo.'</td>';
						echo '<td>'.$row->Observaciones.'</td>';
                    endforeach;
					echo '</tbody></table>';
					echo $sort_tabla;
                }
                else {
                    echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay cursos programados</td></tr></table>';
                }
                ?>
        </div>
    </div>
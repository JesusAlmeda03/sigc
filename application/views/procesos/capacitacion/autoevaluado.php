<?php
/****************************************************************************************************
*
*	VIEWS/procesos/expediente/listado.php
*
*		Descripción:
*			Listado de los usuarios para actualizar / revisar su expediente
*
*		Fecha de Creación:
*			10/Enero/2013
*
*		Ultima actualización:
*			10/Enero/2013
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
			<div class="titulo">Usuarios que ya respondieron la evaluacion</div>
            <div class="texto">
            	<?php				
            	if( $usuarios->num_rows() > 0 ) {
            		echo '<table class="tabla" id="tabla" width="700">';
					echo '<thead><tr><th width="15" class="no_sort"></th><th>Nombre del Usuario</th><th>Ver</th></tr></thead>';
					echo '<tbody>';
            		foreach( $usuarios->result() as $row ) {
						echo '<tr>';
						echo '	<th><img src="'.base_url().'includes/img/icons/small/account.png" /></th>';
						echo '	<td>Hola'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.'</td>';
						echo '	<td>Hola</td>';

						echo '</tr>';
            		}
					echo '</tbody>';
					echo '</table>';
					echo $sort_tabla;
            	}
				else {
                    echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay usuarios</td></tr></table>';
                }
            	?>
            </div>
		</div>
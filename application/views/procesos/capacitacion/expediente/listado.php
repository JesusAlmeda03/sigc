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
			<div class="titulo"><?=$titulo?></div>
            <div class="texto">
            	<?php				
            	if( $usuarios->num_rows() > 0 ) {
            		echo '<table class="tabla" id="tabla" width="700">';
					echo '<thead><tr><th width="15" class="no_sort"></th><th>Nombre del Usuario</th><th class="no_sort" width="15" style="border:0"></th><th class="no_sort" width="15" style="border:0"></th></tr></thead>';
					echo '<tbody>';
            		foreach( $usuarios->result() as $row ) {
						echo '<tr>';
						echo '	<th><img src="'.base_url().'includes/img/icons/small/account.png" /></th>';
						echo '	<td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.'</td>';
						echo '	<td><a href="'.base_url().'index.php/procesos/capacitacion/expediente_agregar/'.$row->IdUsuario.'" onmouseover="tip(\'Aregar archivos al expediente\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/agregar.png" width="16" /></a></td>';
						echo '	<td><a href="'.base_url().'index.php/procesos/capacitacion/expediente_revisar/'.$row->IdUsuario.'" onmouseover="tip(\'Revisar expediente\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
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
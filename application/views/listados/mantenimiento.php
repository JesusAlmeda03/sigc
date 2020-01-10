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
					echo '<thead><tr><th class="no_sort" style="width:5px"></th><th width="150">&Aacute;rea</th><th width="150">A&ntilde;o</th><th width="150">Periodo</th><th width="150">Fecha</th><th class="no_sort" width="15" style="border:0"></th>';
					// Responsable de Mantenimiento
					if( $this->session->userdata('MAN') ) 
						echo '<th class="no_sort" width="15" style="border:0"></th><th class="no_sort" width="15" style="border:0"></th>';
					echo '</tr></thead><tbody>';
                    foreach( $consulta->result() as $row ) :
						// definen las acciones segun el estado del programa
						switch( $row->Estado ) {
							// eliminadas
							case 0 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/eliminar.png" onmouseover="ddrivetip(\'Programa inactivo\')" onmouseout="hideddrivetip()" />';
								$img_cam = '<a onclick="pregunta_cambiar('.$row->IdPrograma.',1,\'&iquest;Deseas restaurar este programa?\')" onmouseover="ddrivetip(\'Restaurar Programa\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/ok2.gif" /></a>';
								break;
								
							// activas
							case 1 : 
								$img_edo = '<img src="'.base_url().'includes/img/icons/terminada.png" onmouseover="ddrivetip(\'Programa activo\')" onmouseout="hideddrivetip()" />';
								$img_cam = '<a onclick="pregunta_cambiar('.$row->IdPrograma.',0,\'&iquest;Deseas eliminar este programa?\')" onmouseover="ddrivetip(\'Eliminar Programa\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/delete.gif" /></a>';
								break;
						}
                        echo '<tr>';
						echo '<th>'.$img_edo.'</th>';
						echo '<td>'.$row->Area.'</td>';
						echo '<td>'.$row->Ano.'</td>';
						echo '<td>'.$row->Periodo.'</td>';
						echo '<td>'.$row->Fecha.'</td>';
						echo '<td><a href="'.base_url().'index.php/procesos/mantenimiento/documento/'.$row->IdPrograma.'" target="_blank" onmouseover="ddrivetip(\'Abrir el programa de mantenimiento\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/pdf.png" width="24" height="24" /></a></td>';
						if( $this->session->userdata('MAN') ) {
							echo '<td><a href="'.base_url().'index.php/procesos/mantenimiento/modificar/'.$row->IdPrograma.'/" onmouseover="ddrivetip(\'Modificar programa\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/edit.gif" /></a></td>';
							echo '<td>'.$img_cam.'</td>';
						}
                    endforeach;
					echo '</tbody></table>';
					echo $sort_tabla;
                }
                else {
                    echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay programas</td></tr></table>';
                }
                ?>
        </div>
    </div>
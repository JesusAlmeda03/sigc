<?php
/****************************************************************************************************
*
*	VIEWS/admin/auditorias/programa_especifico.php
*
*		Descripción:
*			Vista de los programas anuales de auditoría
*
*		Fecha de Creación:
*			23/Octubre/2012
*
*		Ultima actualización:
*			23/Octubre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
?>          
    <div class="cont_admin">
    	<div class="titulo"><?=$titulo?></div>
        <div class="texto">
			<?php
			$ano_extras = 'id="ano" onfocus="hover(\'ano\')"  style="width:350px;" onchange="form.submit()"';
			$auditoria_extras = 'id="auditoria" onfocus="hover(\'auditoria\')"  style="width:350px;" onchange="form.submit()"';
			$auditorias = array(
				'todos'	 			=> ' - Todas -',
				'SIGC'				=> 'Interna SIGC',
				'Certificación'		=> 'Certificaci&oacute;n',
				'1° Seguimiento'	=> '1° Seguimiento',
				'2° Seguimiento'	=> '2° Seguimiento',
				'Recertificación'	=> 'Recertificaci&oacute;n',
			);
			$estado_extras = 'id="estado" onfocus="hover(\'estado\')"  style="width:350px;" onchange="form.submit()"';
			$estados = array(
				'todos'	=> ' - Todas las Auditor&iacute;as - ',
				'0'		=> 'Pendientes',
				'1'		=> 'Activas',
				'2'		=> 'Terminadas',
				'3'		=> 'Eliminadas',
			);
			echo form_open();
			echo '
	        	<table class="tabla_form" width="980">
	            	<tr><th width="100">A&ntilde;o</th><td>'.form_dropdown('ano',$anos,$ano,$ano_extras).'</td></tr>
	            	<tr><th width="100">Auditor&iacute;a</th><td>'.form_dropdown('auditoria',$auditorias,$auditoria,$auditoria_extras).'</td></tr>
	            	<tr><th width="100">Estado</th><td>'.form_dropdown('estado',$estados,$estado,$estado_extras).'</td></tr>
	         	</table><br />
         	';
            echo form_close();
            if( $programa->num_rows() > 0 ) {
                echo '<table class="tabla" id="tabla" width="980">';
                echo '<thead><tr><th width="15" class="no_sort"></th><th>A&ntilde;o</th><th>Auditoria</th><th>Periodo</th><th class="no_sort" width="15"></th>';
				echo '</tr></thead><tbody>';
                foreach( $programa->result() as $row ) {
                	switch ( $row->Estado ) {
                	// Auditoría pendiente
						case '0' :
							$img_edo = '<th><img onmouseover="tip(\'Auditoria pendiente\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/pendiente.png" /></th>';
							$img_acc = '';
							// procesos
							if( !$row->IdAuditoriaProceso ) {
								$img_acc .= '<td style="border:0"><a href="'.base_url().'index.php/admin/auditorias/procesos/'.$row->IdAuditoria.'/'.$ano.'/'.$auditoria.'/'.$estado.'" onmouseover="tip(\'Establecer los Procesos a Auditar\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/star_full.png" /></a></td>';
							}
							// equipos
							if( !$row->IdEquipo ) {
								$img_acc .= '<td style="border:0"><a href="'.base_url().'index.php/admin/auditorias/equipos/'.$row->IdAuditoria.'/'.$ano.'/'.$auditoria.'/'.$estado.'" onmouseover="tip(\'Generar los Equipos\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/users.png" /></a></td>';
							}
							// relación Procesos-Equipo
							if( $row->IdAuditoriaProceso && $row->IdEquipo) {
								$img_acc .= '<td style="border:0"><a href="'.base_url().'index.php/admin/auditorias/procesos_equipos/'.$row->IdAuditoria.'/'.$ano.'/'.$auditoria.'/'.$estado.'" onmouseover="tip(\'Asignar Procesos a Equipos\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/seguimiento.png" /></a></td>';
								$img_acc .= '<td style="border:0"><a href="'.base_url().'index.php/admin/auditorias/especifico/'.$row->IdAuditoria.'/'.$ano.'/'.$auditoria.'/'.$estado.'" onmouseover="tip(\'Programa Espec&iacute;fico de Auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
							}
							$img_acc .= '<td style="border:0"><a href="'.base_url().'index.php/admin/auditorias/modificar_auditoria/'.$row->IdAuditoria.'/'.$ano.'/'.$auditoria.'/'.$estado.'" onmouseover="tip(\'Modificar esta auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
							$img_acc .= '<td style="border:0"><a onclick="pregunta_cambiar( \'auditorias\', '.$row->IdAuditoria.', 3, \'&iquest;Deseas eliminar esta Auditor&iacute;a?\',\'auditorias-programa_especifico-'.$ano.'-'.$auditoria.'-'.$estado.'\')" onmouseover="tip(\'Eliminar Auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';
							break;
									
					// Auditoría activa con Programa Específico
						case '1' :
							$img_edo = '<th><img onmouseover="tip(\'Auditoria activa\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/terminada.png" /></th>';
							$img_acc = '<td style="border:0"><a href="'.base_url().'index.php/admin/auditorias/especifico/'.$row->IdAuditoria.'/'.$ano.'/'.$auditoria.'/'.$estado.'" onmouseover="tip(\'Revisar Programa Espec&iacute;fico<br />para esta auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
							$img_acc .= '<td style="border:0"><a onclick="pregunta_cambiar( \'auditorias\', '.$row->IdAuditoria.', 2, \'&iquest;Deseas cerrar esta Auditor&iacute;a?\',\'auditorias-programa_especifico-'.$ano.'-'.$auditoria.'-'.$estado.'\')" onmouseover="tip(\'Cerrar Auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/cerrada.png" /></a></td>';
							$img_acc .= '<td style="border:0"><a href="'.base_url().'index.php/admin/auditorias/modificar_auditoria/'.$row->IdAuditoria.'/'.$ano.'/'.$auditoria.'/'.$estado.'" onmouseover="tip(\'Modificar esta auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
							$img_acc .= '<td style="border:0"><a onclick="pregunta_cambiar( \'auditorias\', '.$row->IdAuditoria.', 3, \'&iquest;Deseas eliminar esta Auditor&iacute;a?\',\'auditorias-programa_especifico-'.$ano.'-'.$auditoria.'-'.$estado.'\')" onmouseover="tip(\'Eliminar Auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';
							break;
							
					// Auditoría Terminada
						case '2' :
							$img_edo = '<th><img onmouseover="tip(\'Auditoria cerrada\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/cerrada.png" /></th>';
							$img_acc = '<td style="border:0"><a href="'.base_url().'index.php/admin/auditorias/especifico/'.$row->IdAuditoria.'/'.$ano.'/'.$auditoria.'/'.$estado.'" onmouseover="tip(\'Revisar Programa Espec&iacute;fico<br />para esta auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
							$img_acc .= '<td style="border:0"><a href="'.base_url().'index.php/admin/auditorias/modificar_auditoria/'.$row->IdAuditoria.'/'.$ano.'/'.$auditoria.'/'.$estado.'" onmouseover="tip(\'Modificar esta auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
							$img_acc .= '<td style="border:0"><a onclick="pregunta_cambiar( \'auditorias\', '.$row->IdAuditoria.', 3, \'&iquest;Deseas eliminar esta Auditor&iacute;a?\',\'auditorias-programa_especifico-'.$ano.'-'.$auditoria.'-'.$estado.'\')" onmouseover="tip(\'Eliminar Auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';
							break;
							
					// Auditoría Eliminada
						case '3' :
							$img_edo = '<th><img onmouseover="tip(\'Auditoria eliminada\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/eliminada.png" /></th>';
							$img_acc = '<td style="border:0"><a href="'.base_url().'index.php/admin/auditorias/especifico/'.$row->IdAuditoria.'/'.$ano.'/'.$auditoria.'/'.$estado.'" onmouseover="tip(\'Revisar Programa Espec&iacute;fico<br />para esta auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
							$img_acc .= '<td style="border:0"><a href="'.base_url().'index.php/admin/auditorias/modificar_auditoria/'.$row->IdAuditoria.'/'.$ano.'/'.$auditoria.'/'.$estado.'" onmouseover="tip(\'Modificar esta auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
							$img_acc .= '<td style="border:0"><a onclick="pregunta_cambiar( \'auditorias\', '.$row->IdAuditoria.', 0, \'&iquest;Deseas activar esta Auditor&iacute;a?\',\'auditorias-programa_especifico-'.$ano.'-'.$auditoria.'-'.$estado.'\')" onmouseover="tip(\'Activar Auditor&iacute;a\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar.png" /></a></td>';
							break;
					}
                    echo '<tr>';
					echo $img_edo;
					echo '<td>'.$row->Ano.'</td>';
					echo '<td>'.$row->Auditoria.'</td>';
                   	echo '<td>del '.$row->Inicio.' al '.$row->Termino.'</td>';
					echo '<td style="padding:0;"><table><tr>';
					echo $img_acc.'</tr></table></td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
				echo $sort_tabla;
            }
            else {
            	if( $ano == 'elige' ) {
            		echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Elige un a&ntilde;o para visualizar el Programa Anual de Auditor&iacute;a</td></tr></table>';
            	}
				else {
            		echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay programas</td></tr></table>';
				}
            }
            ?>
        </div>
    </div>
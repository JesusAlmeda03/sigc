<?php
/****************************************************************************************************
*
*	VIEWS/admin/aduditorias/procesos.php
*
*		Descripción:
*			Vista para guardar los procesos
*
*		Fecha de Creación:
*			23/Octubre/2012
*
*		Ultima actualizaciÓn:
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
    	<div class="titulo"><?=$titulo_pagina?></div>
        <div class="texto">
        	<?php
        	$formulario = array(
                // * Boton submit
                'boton' => array (
                    'id'		=> 'aceptar',
                    'name'		=> 'aceptar',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'aceptar\')'
                ),
            );
			
			if( $procesos->num_rows() > 0 ) {
				$tipo = '';
				echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table class="tabla_form" width="980">';
				foreach( $procesos->result() as $row ) {
					if( $tipo == $row->Tipo) {
						echo '<tr>';
						echo '<th width="15"><input type="checkbox" id="procesos" name="procesos[]" value="'.$row->IdProcesos.'" /></th>';
						echo '<td>'.$row->Proceso.'</td>';
						echo '</tr>';
					}
					else {
						if( $tipo != '' ) {
							echo '</table><br />';
						}
						$tipo = $row->Tipo;
						echo '<table class="tabla_form" width="980">';
						echo '<tr><th colspan="2" class="titulo_tabla">Procesos '.$row->Tipo.'</th></tr>';
						echo '<tr>';
						echo '<th width="15"><input type="checkbox" id="procesos" name="procesos[]" value="'.$row->IdProcesos.'" /></th>';
						echo '<td>'.$row->Proceso.'</td>';
						echo '</tr>';
					}
				}
				echo '</table>';
            	echo '<br />';
            	echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
            	echo form_close();
			}
			else {
				echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay procesos disponibles para auditar</td></tr></table>';
			}
			
			echo '<br /><br />';
			if( $ano == 'especifico' ) {
				echo '<table><tr><td><a href="'.base_url().'index.php/admin/auditorias/especifico/'.$id_auditoria.'" onmouseover="tip(\'Regresa al Programa Espec&iacute;fico de Auditor&iacute;as\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/admin/auditorias/especifico/'.$id_auditoria.'" onmouseover="tip(\'Regresa al Programa Espec&iacute;fico de Auditor&iacute;as\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
			}
			else {
				echo '<table><tr><td><a href="'.base_url().'index.php/admin/auditorias/programa_especifico/'.$ano.'/'.$auditoria.'/'.$estado.'" onmouseover="tip(\'Regresa al Programa Anual de Auditor&iacute;as\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/admin/auditorias/programa_especifico/'.$ano.'/'.$auditoria.'/'.$estado.'" onmouseover="tip(\'Regresa al Programa Anual de Auditor&iacute;as\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
			}
            ?>
        </div>
    </div>
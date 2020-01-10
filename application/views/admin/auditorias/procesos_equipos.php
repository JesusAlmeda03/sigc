<?php
/****************************************************************************************************
*
*	VIEWS/admin/aduditorias/procesos_equipos.php
*
*		Descripción:
*			Vista para generar las relaciones procesos - equipos
*
*		Fecha de Creación:
*			30/Octubre/2012
*
*		Ultima actualizaciÓn:
*			30/Octubre/2012
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
        	<script>
			$(function() {
                $( "#fecha" ).datepicker({
                    changeMonth: true,
                    changeYear: true,
                });
                $('#fecha').datepicker($.datepicker.regional['es']);
                $('#fecha').datepicker('option', {dateFormat: 'yy-mm-d'});
                $("#startDate").datepicker({dateFormat: 'yy-mm-dd'});
            });
            </script>
        	<?php
        	$formulario = array(
                // * Boton submit
                'boton' => array (
                    'id'		=> 'aceptar',
                    'name'		=> 'aceptar',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'aceptar\')'
                ),
                // Nombre Equipo
                'equipo' => array (
                    'name'		=> 'equipo',
                    'id'		=> 'equipo',
                    'value'		=> set_value('equipo'),
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('equipo')",
                ),
                
				// Fecha
                'fecha' => array (
                    'name'		=> 'fecha',
                    'id'		=> 'fecha',
                    'value'		=> set_value('fecha'),
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('fecha')",
                    'style'		=> 'width:100px',
                ),
                
				// Hora
                'hora' => array (
                    'name'		=> 'hora',
                    'id'		=> 'hora',
                    'value'		=> set_value('hora'),
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('hora')",
                    'style'		=> 'width:150px',
                ),
            );
			
			$form  = form_open('',array('name' => 'formulario', 'id' => 'formulario'));
			
			$form .= '<table class="tabla_form" width="980">';
			$form .= '<tr><th class="text_form" width="100">Fecha: </th>';
            $form .= '<td>'.form_input($formulario['fecha']).'</td></tr>';
			$form .= '<tr><th class="text_form">Hora: </th>';
            $form .= '<td>'.form_input($formulario['hora']).'</td></tr>';
			$form .= '</table><br />';
			
			$form .= '<table><tr><td valign="top">';
			
			$disponibles = true; 
			
			// Procesos
			if( $procesos->num_rows() > 0 ) {
				$tipo = '';
				$form .= '<table class="tabla_form" width="485">';
				foreach( $procesos->result() as $row ) {
					if( $tipo == $row->Tipo) {
						$form .= '<tr>';
						$form .= '<th width="15"><input type="checkbox" id="proceso" name="proceso[]" value="'.$row->IdProceso.'" /></th>';
						$form .= '<td>'.$row->Proceso.'</td>';
						$form .= '</tr>';
					}
					else {
						if( $tipo != '' ) {
							$form .= '</table><br />';
						}
						$tipo = $row->Tipo;
						$form .= '<table class="tabla_form" width="485">';
						$form .= '<tr><th colspan="2">Procesos '.$row->Tipo.'</th></tr>';
						$form .= '<tr>';
						$form .= '<th width="15"><input type="checkbox" id="proceso" name="proceso[]" value="'.$row->IdProceso.'" /></th>';
						$form .= '<td>'.$row->Proceso.'</td>';
						$form .= '</tr>';
					}
				}
				$form .= '</table>';
			}
			else {
				$disponibles = false;
			}

			$form .= '</td><td valign="top">'; 
			
			// Equipos
			if( $equipos->num_rows() > 0 ) {
				$id_equipo = '';
				$form .= '<table class="tabla_form" width="485">';
				foreach( $equipos->result() as $row ) {
					if( $id_equipo == $row->IdEquipo) {
						$form .= '</tr><td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.' ('.$row->Area.')</td></tr>';
					}
					else {
						if( $id_equipo != '' ) {
							$form .= '</table><br />';
						}
						$id_equipo = $row->IdEquipo;
						$form .= '<table class="tabla_form" width="485">';
						$form .= '<tr><th><input type="radio" id="equipo" name="equipo" value="'.$row->IdEquipo.'" /> '.$row->Equipo.'</th></tr>';
						$form .= '</tr><td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.' ('.$row->Area.')</td></tr>';
					}
				}
				$form .= '</table>';
			}
			else {
				$disponibles = false;
			}
			
			$form .= '</td></tr></table>';
			$form .= '<div style="width:980px; text-align:center; clear:both;"><br />'.form_submit($formulario['boton'],'Aceptar').'</div>';
			
			$form .= form_close();
			
			if( $disponibles ) {
				echo $form;
			}
			else {
				echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>No hay disponibles procesos para asignar</td></tr></table>';
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
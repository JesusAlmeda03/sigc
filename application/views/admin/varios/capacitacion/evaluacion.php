<?php
/****************************************************************************************************
*
*	VIEWS/admin/minutas/acuerdos.php
*
*	Descripción:
*		Acuerdos de la reunión pasada y acuerdos de la reunión actual
*
*	Fecha de Creación:
*		8/Marzo/2012
*
*	Ultima actualización:
*		8/Marzo/2012
*
*	Autor:
*		ISC Rogelio Castañeda Andrade
*		HERE (http://www.webHERE.com.mx)
*		rogeliocas@gmail.com
*
****************************************************************************************************/
?>
    <div class="cont_admin">
    	<div class="titulo"><?=$titulo?></span></div>
        <div class="texto">        	
        	<?php
        	// Formulario para Iniciar una nueva Evaluación
        	$formulario = array(
				// * Boton submit
				'boton' => array (
					'name'		=> 'aceptar',
					'class'		=> 'in_button',
					'style'		=> ' width:250px'
				),
				// Fecha
				'fecha' => array (
					'name'		=> 'fecha',
					'id'		=> 'fecha',
					'value'		=> set_value('fecha'),
					'class'		=> 'in_text',
					'onfocus'	=> "hover('fecha')",					
				),				
			);			
			echo form_open();
			echo '<table class="tabla_form" width="980">';
			echo '<tr><th class="text_form">Fecha de la Evaluación: </th>';
			echo '<td>'.form_input($formulario['fecha']).'</td>';
			echo '</table><br />';
			echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Iniciar Evaluacion').'</div>';
			echo form_close().'<br /><br />';
        	
        	// Listado de Evaluaciones
            if( $evaluaciones->num_rows() > 0 ) {
                echo '<table class="tabla" id="tabla" width="980">';
                echo '<thead><tr><th width="10" class="no_sort"></th>';
				echo '<th>Fecha de la Evaluación</th><th class="no_sort"></th></tr></thead><tbody>';
                foreach( $evaluaciones->result() as $row ) :
					// definen las acciones segun el estado de la queja
					switch( $row->Estado ) {
						// activas
						case 1 :							
							$img_edo = '<img src="'.base_url().'includes/img/icons/terminada.png" onmouseover="tip(\'Evaluación Activa\')" onmouseout="cierra_tip()" />';
							$img_cam = '<a onclick="pregunta_cambiar(\'evaluacion_dnc\','.$row->IdCapacitacionEvaluacion.',0,\'&iquest;Deseas desactivar esta evaluación?\',\'varios-cap_evaluacion\')" onMouseover="tip(\'Activar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
							break;
							
						// inactivas
						case 0 :
							$img_edo = '<img src="'.base_url().'includes/img/icons/pendiente.png" onmouseover="tip(\'Evaluación Inactiva\')" onmouseout="cierra_tip()" />';
							$img_cam = '<a onclick="pregunta_cambiar(\'evaluacion_dnc\','.$row->IdCapacitacionEvaluacion.',1,\'&iquest;Deseas activar esta evaluación?\',\'varios-cap_evaluacion\')" onMouseover="tip(\'Desactivar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar.png" /></a>';
							break;
					}
					echo '<tr>';
					echo '<th>'.$img_edo.'</th>';
					echo '<td>'.$row->Fecha.'</td>';
					//echo '<td width="15"><a href="'.base_url().'index.php/admin/varios/quejas_modificar/'.$row->IdCapacitacionEvaluacion.'" onMouseover="tip(\'Modificar queja\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
					echo '<td width="15">'.$img_cam.'</td>';
                    echo '</tr>';
                endforeach;
                echo '</tbody></table>';
				echo $sort_tabla;
            }
            else {
                echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay evaluaciones</td></tr></table>';
            }
			?>
        </div>
    </div>
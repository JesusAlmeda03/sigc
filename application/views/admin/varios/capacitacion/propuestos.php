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
        	 $formulario = array(
				// Nombre
				'observaciones' => array (					
					'id'		=> 'observaciones',
					'value'		=> set_value('observaciones'),
					'class'		=> 'in_text',
					'onfocus'	=> "hover('observaciones')",
					'style'		=> 'width:250px',
				),
                // * Boton submit
                'boton' => array (
                    'id'		=> 'boton',
                    'name'		=> 'boton',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'boton\')',
                    'style'		=> 'width:420px',
				),
			);
			
        	$area_extras = 'id="area" onfocus="hover(\'area\')"  style="width:350px; margin:0 0 0 5px; float:left" onchange="form.submit()"';
			$evaluacion_extras = 'id="evaluacion" onfocus="hover(\'evaluacion\')"  style="width:350px; margin:0 0 0 5px; float:left" onchange="form.submit()"';
		
        	
        	// Listado de Evaluaciones
            if( $propuestos->num_rows() > 0 ) {
            	echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
                echo '<table class="tabla" id="tabla" width="980">';
                echo '<thead><tr><th width="10" class="no_sort"></th>';
				
				echo '<th>Area</th><th>Curso</th><th>Fecha</th><th>Cupo</th><th>Tipo</th><th>Observaciones</th></tr></thead><tbody>';
                foreach( $propuestos->result() as $row ) :					
					echo '<tr>';
					echo '<th>'.form_checkbox('aprobar[]', $row->IdCapacitacionCursoPropuesto, false, 'id="aprobar_'.$row->IdCapacitacionCursoPropuesto.'"' ).'</th>';
					
					echo '<td>'.$row->Area.'</td>';
					echo '<td>'.$row->Curso.'</td>';
					echo '<td>'.$row->Fecha.'</td>';
					echo '<td>'.$row->Cantidad.'</td>';
					echo '<td>'.$row->Tipo.'</td>';
					echo '<td>'.$row->Observaciones.'</td>';
                    echo '</tr>';
                    
                endforeach;
                echo '</tbody></table><br />';				
				echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aprobar los cursos seleccionados').'</div>';
				echo form_close();
            }
            else {
                echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay cursos propuestos</td></tr></table>';
            }
			
			
			?>
        </div>
    </div>
    
	
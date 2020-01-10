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
        	$area_extras = 'id="area" onfocus="hover(\'area\')"  style="width:350px; margin:0 0 0 5px; float:left" onchange="form.submit()"';
			$evaluacion_extras = 'id="evaluacion" onfocus="hover(\'evaluacion\')"  style="width:350px; margin:0 0 0 5px; float:left" onchange="form.submit()"';
			echo form_open();
			echo '
	        	<table class="tabla_form" width="980">
	            	<tr><th width="100">&Aacute;rea</th><td>'.form_dropdown("area",$area_options,$area,$area_extras).'</td></tr>
	            	<tr><th>Evaluación</th><td>'.form_dropdown("evaluacion",$evaluacion_options,$evaluacion,$evaluacion_extras ).'</td></tr>
	         	</table><br />
         	';
            echo form_close();
			
        	// Listado de Evaluaciones
            if( $propuestos->num_rows() > 0 ) {
                echo '<table class="tabla" id="tabla" width="980">';
                echo '<thead><tr><th width="10" class="no_sort"></th>';
				if( $area == 'todos' )
					echo '<th>Área</th>';
				echo '<th>Curso</th><th>Tipo</th><th>Observaciones</th></tr></thead><tbody>';
                foreach( $propuestos->result() as $row ) :					
					echo '<tr>';
					echo '<th>'.form_checkbox('aprobar[]', $row->IdCapacitacionCursoPropuesto, false, 'id="aprobar_'.$row->IdCapacitacionCursoPropuesto.'"' ).'</th>';
					if( $area == 'todos' )
						echo '<td>'.$row->Area.'</td>';
					echo '<td>'.$row->Curso.'</td>';
					echo '<td>'.$row->Tipo.'</td>';
					echo '<td>'.$row->Observaciones.'</td>';
                    echo '</tr>';
                endforeach;
                echo '</tbody></table>';
				echo $sort_tabla;
            }
            else {
                echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay cursos abrobados</td></tr></table>';
            }
			?>
        </div>
    </div>
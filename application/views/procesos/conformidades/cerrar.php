<?php
/****************************************************************************************************
*
*	VIEWS/procesos/conformidades/cerrar.php
*
*		Descripción:
*			Vista para cerrar las no conformidades
*
*		Fecha de Creación:
*			18/Enero/2012
*
*		Ultima actualización:
*			18/Enero/2012
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
            	 <table class="tabla" width="700"><tr><th width="20"><img src="<?php echo base_url() ?>includes/img/icons/small/info.png" /></th><td>Marca el cuadro de la primera columna para seleccionar las conformidades.</td></tr></table><br />            	 
            <script>
			j = true;
			
			function todos() {
				if( j ) {
					j = false;
					seleccionar_todo();
				}
				else {
					j = true;
					deseleccionar_todo();
				}
			}
			
			function seleccionar_todo(){ 
			   for( i = 0; i < document.formulario.elements.length; i++ ) 
				  if( document.formulario.elements[i].type == "checkbox" )	
					 document.formulario.elements[i].checked = 1;
			}
			
			function deseleccionar_todo(){ 
			   for( i = 0; i < document.formulario.elements.length; i++ )
				  if( document.formulario.elements[i].type == "checkbox" )	
					 document.formulario.elements[i].checked = 0;
			}
			
			function lista_distribucion( i ) {
				document.getElementById('distribucion_' + i).checked = 1;
			}
			</script>
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
                'boton_cerrar' => array (
                    'id'		=> 'boton_cerrar',
                    'name'		=> 'boton_cerrar',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'boton_cerrar\')',
                    'style'		=> 'width:330px',
				),
                // * Boton submit
                'boton_rechazar' => array (
                    'id'		=> 'boton_rechazar',
                    'name'		=> 'boton_rechazar',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'boton_rechazar\')',
					'style'		=> 'margin-left:10px',				
				),
			);
			if( $conformidades->num_rows() > 0 ) {				
				echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table class="tabla" id="tabla" width="700">';
				echo '<thead><tr>';
				echo '<th class="no_sort" width="15"></th>';
				echo '<th class="no_sort" width="15"></th>';				
				echo '<th width="60">No.</th>';
				echo '<th width="60">Fecha</th>';
				echo '<th>&Aacute;rea</th>';
				echo '<th>Departamento</th>';				
				echo '<th class="no_sort" width="15"></th>';
				echo '</tr></thead><tbody>';
                foreach( $conformidades->result() as $row ) :
					$conformidad = 'id="conformidad_'.$row->IdConformidad.'"';
					echo '<tr>';					
					echo '<th style="text-align:center">'.form_checkbox('conformidad[]', $row->IdConformidad, false, $conformidad).'</th>';
					echo '<th><img src="'.base_url().'includes/img/icons/terminada.png" onmouseover="tip(\'No conformidad atendida\')" onmouseout="cierra_tip()" /></th>';
					echo '<td>'.$row->IdConformidad.'</td>';
					echo '<td>'.$row->Fecha.'</td>';
					echo '<td>'.$row->Area.'</td>';
					echo '<td>'.$row->Departamento.'</td>';
					echo '<td><a href="'.base_url().'index.php/procesos/conformidades/ver/'.$row->IdConformidad.'/cerrar" onmouseover="tip(\'Ver no conforidad\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/ver.png" /></a></td>';
				endforeach;
				echo '</tbody></table><br />';
				echo $sort_tabla;
				echo '<div style="width:670px; text-align:center;">'.form_submit($formulario['boton_cerrar'],'Cerrar No Conformidad').'</div>';
				echo form_close();
			}
			else {
                echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no tienes no conformidades para cerrar.</td></tr></table><br /><br />';
			}
            ?>
        </div>
    </div>
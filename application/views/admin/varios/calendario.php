<?php
/****************************************************************************************************
*
*	VIEWS/admin/varios/contacto.php
*
*		Descripción:
*			Vista que muestra el listado de contacto
*
*		Fecha de Creación:
*			6/Febrero/2012
*
*		Ultima actualización:
*			6/Febrero/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
$fecha = array(
		'type' => 'input',
		'class' => 'in_text',
		'name' => 'Fecha', 
		'id'  => 'fecha'
	);
$evento = array(
		'type' => 'input',
		'class' => 'in_text',
		'name' => 'Evento', 
	);
$boton = array(
		'type' => 'submit', 
		'name' => 'boton', 
		'class' => 'in_button', 
		'value' => 'Agregar'
	);
?>


    <div class="cont_admin">
    	<div class="titulo"><?=$titulo?></div>
        <div class="texto">			
            <?php
			
			echo '<table><tr><td>';
			echo form_open();
			echo '  <table class="tabla_form" width="745">
	            		<tr>
	            			<th style="width: 50px">Fecha</th>
	            			<td style="width: 100px; text-align: left;">'.form_input($fecha).'</td>
	            		</tr>
	            		<tr>
	            			<th style="width: 50px;">Evento</th>
	            			<td style="width: 100px; text-align: left;">'.form_input($evento).'</td>
	            		</tr>
	            		<tr>
	            			<td colspan="2" style="text-align: center;">'.form_input($boton).'</td>
	            		</tr>
	         		</table>
	         		<br />
         	';
            echo form_close();	
			if( $calendario->num_rows() > 0 ) {
				echo '<table class="tabla" id="tabla" width="100%">';
                echo '<thead><tr><th>Fecha</th><th>Evento</th><th></th></tr></thead>';
				echo '<tbody>';
				foreach( $calendario->result() as $row ) {
					echo '<tr>';
					echo '<td width="140">'.$row->Fecha.'</td>';
					echo '<td width="750px">'.$row->Evento.'</td>';
					echo '<td><a href="'.base_url().'index.php/admin/varios/dCal/'.$row->IdEvento.'"><img src="'.base_url().'includes/img/icons/eliminar.png"></a></td>';
					echo '</tr>';
					
				}
				echo '</tbody>';
				echo '</table>';
				echo $sort_tabla;
			}
			else {
                echo '<table class="tabla" width="75%"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay noticias</td></tr></table>';
	        }
            ?>
        </div>
    </div>
    	<script>
		$(function(){$("#fecha").datepicker({dateFormat: "yy-mm-dd"});
			});
	</script>
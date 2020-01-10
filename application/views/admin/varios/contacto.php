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
?>
    <div class="cont_admin">
    	<div class="titulo"><?=$titulo?></div>
        <div class="texto">			
			<?php
			$estado_extras = 'id="estado" onfocus="hover(\'estado\')"  style="width:350px; margin:0 0 0 5px; float:left" onchange="form.submit()"';
			echo form_open();
			echo '
	        	<table class="tabla_form" width="980">
	                <tr><th>Estado</th><td>'.form_dropdown("estado",$estado_options,$estado,$estado_extras ).'</td></tr>
	         	</table><br />
         	';
            echo form_close();
			
			if( $contacto->num_rows() > 0 ) {
				$i = 0;
				echo '<table width="950" ><tr>';
				foreach( $contacto->result() as $row ) {
					echo '<td valign="top">';
					echo '<table class="tabla_form" width="470" style="margin:5px">';
					if( $row->Estado == '1' ) {
						echo '<div style="position:absolute"><img src="'.base_url().'includes/img/icons/pendiente.png" width="20" /></div>';
						echo '<tr><th colspan="2" style="text-align:center"><input type="checkbox" onclick="location=\''.base_url().'index.php/admin/varios/contacto_archivar/'.$row->IdContacto.'\'" /> Marcar mensaje como le&iacute;do</th></tr>';
					}
					else {
						echo '<div style="position:absolute"><img src="'.base_url().'includes/img/icons/terminada.png" width="20" /></div>';
					}
					echo '<tr><th>Fecha</th><td>'.$row->Fecha.'</td></tr>';
					echo '<tr><th>Nombre</th><td>'.$row->Nombre.'</td></tr>';
					echo '<tr><th>Correo</th><td>'.$row->Correo.'</td></tr>';
					echo '<tr><th valign="top">Mensaje</th><td>'.$row->Mensaje.'</td></tr>';
					echo '</table><br />';
					if ( $i ) {
						echo '</tr><tr>';
						$i = 0;
					} 
					else {
						$i = 1;						
					}
				}
				echo '</tr></table>';
			}			
			else {
	        	echo '<table class="tabla" width="950"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay mensajes de contacto</td></tr></table>';
	        }
            ?>
        </div>
    </div>
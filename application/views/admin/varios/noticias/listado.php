<?php
/****************************************************************************************************
*
*	VIEWS/admin/varios/noticias.php
*
*		Descripción:
*			Vista que muestra el listado de las noticias
*
*		Fecha de Creación:
*			30/Octubre/2011
*
*		Ultima actualización:
*			2/Febrero/2012
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
			echo '<table><tr><td>';
			echo form_open();
			echo '
	        	<table class="tabla_form" width="745">
	            	<tr><th>Estado</th><td>'.form_dropdown("estado",$estado_options,$estado,$estado_extras ).'</td></tr>
	         	</table><br />
         	';
            echo form_close();
			echo '</td><td>';
			echo '<table class="tabla_form" style="width:230px; height:41px"><tr><td><a href="'.base_url().'index.php/admin/varios/noticias_agregar"><img src="'.base_url().'includes/img/icons/agregar.png" /></a></td><td><a href="'.base_url().'index.php/admin/varios/noticias_agregar" style="color:#333">Agregar una nueva noticia</a></td></tr></table><br />';
			echo '</td></tr></table>';
			
			if( $noticias->num_rows() > 0 ) {
				echo '<table class="tabla" id="tabla" width="980">';
                echo '<thead><tr><th width="10" class="no_sort"></th><th>Fecha</th><th>Resumen</th><th>Noticia</th><th width="10" class="no_sort"></th><th width="10" class="no_sort"></th></tr></thead>';
				echo '<tbody>';
				foreach( $noticias->result() as $row ) {
					echo '<tr>';
					if( $row->Estado )
						echo '<th><img src="'.base_url().'includes/img/icons/terminada.png" /></th>';
					else
						echo '<th><img src="'.base_url().'includes/img/icons/pendiente.png" /></th>';
					echo '<td width="140">'.$row->Fecha.'</td>';
					echo '<td width="350">'.$row->Resumen.'</td>';
					echo '<td>'.$row->Noticia.'</td>';
					echo '<td><a href="'.base_url().'index.php/admin/varios/noticias_modificar/'.$row->IdNoticia.'" onmouseover="tip(\'Modificar noticia\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
					if( $row->Estado )
						echo '<td><a onclick="pregunta_cambiar(\'noticias\','.$row->IdNoticia.',0,\'&iquest;Deseas eliminar esta noticia?\',\'varios-noticias-'.$estado.'\')" onmouseover="tip(\'Eliminar Noticia\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';
					else
						echo '<td><a onclick="pregunta_cambiar(\'noticias\','.$row->IdNoticia.',1,\'&iquest;Deseas restaurar esta noticia?\',\'varios-noticias-'.$estado.'\')" onmouseover="tip(\'Restaurar Noticia\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar.png" /></a></td>';
					echo '</tr>';
				}
				echo '</tbody>';
				echo '</table>';
				echo $sort_tabla;
			}
			else {
                echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay noticias</td></tr></table>';
	        }
            ?>
        </div>
    </div>
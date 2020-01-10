<?php
/****************************************************************************************************
*
*	VIEWS/admin/documentos/maestra.php
*
*		Descripci�n:
*			Vista de la lista maestra de documentos
*
*		Fecha de Creaci�n:
*			21/Octubre/2011
*
*		Ultima actualizaci�n:
*			21/Octubre/2011
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
            if( $consulta->num_rows() > 0 ) {
                echo '<table class="tabla" id="tabla" width="980">';
                echo '<thead><tr><th width="15" class="no_sort"></th><th width="20">C&oacute;digo</th>';
				echo '<th>&Aacute;rea</th>';
				echo '<th>Nombre</th><th>Secci&oacute;n</th><th width="20">Edici&oacute;n</th><th width="20">Fecha</th><th class="no_sort"></th><th class="no_sort"></th></tr></thead><tbody>';
                foreach( $consulta->result() as $row ) :
                    echo '<tr>';
                    echo '<th><a href="'.base_url().'includes/docs/'.$row->Ruta.'" target="_blank" onMouseover="tip(\''.$row->Nombre.'\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/archivo.png" width="35" /></a></th>';
                    
                    echo '<td>'.$row->Codigo.'</td>';
   	                echo '<td>'.$row->Area.'</td>';
                    echo '<td>'.$row->Nombre.'</td>';
                    echo '<td>'.$row->Seccion.'</td>';
                    echo '<td>'.$row->Edicion.'</td>';
                    echo '<td>'.$row->Fecha.'</td>';
					echo '<td width="24"><a href="'.base_url().'index.php/admin/documentos/modificar_documento/'.$row->IdDocumento.'/inactivos" onMouseover="tip(\'Modificar\')" onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
					echo '<td width="24"><a onclick="pregunta_cambiar( \'documentos\', '.$row->IdDocumento.', 1, \'&iquest;Deseas restaurar este documento?\', \'documentos-inactivos\')" onMouseover="tip(\'Activar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar.png" /></a></td>';
                    echo '</tr>';
                endforeach;
                echo '</tbody></table>';
				echo $sort_tabla;
            }
            else {
                echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay documentos</td></tr></table>';
            }
            ?>
        </div>
    </div>
<?php
/****************************************************************************************************
*
*	VIEWS/admin/documentos/comun.php
*
*		Descripci�n:
*			Vista de la lista maestra de documentos de uso com�n
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
                echo '<thead><tr><th width="35" class="no_sort"></th><th></th><th width="20">C&oacute;digo</th><th>Nombre</th><th width="20">Edici&oacute;n</th><th width="20">Fecha</th>';
				if( !$this->session->userdata( 'ADI' ) ) {
                	echo '<th class="no_sort"></th><th class="no_sort"></th>';
				}
                echo '</tr></thead><tbody>';
                foreach( $consulta->result() as $row ) :
                    echo '<tr>';
/*						$doc = $row->Ruta;
                    $j = 0;
                    $k = 0;
                    for ( $i = strlen($doc); $i > 0 ; $i-- ) {
                        if ( $doc[$i] == "." ){
                            $j = $k;
                            break;
                        }
                        $k++;
                    }
                    $ext = substr($doc,strlen($doc)-$j,$j);*/
                    $ext = substr($row->Ruta,12);
                    switch( $ext ) {
                        // Word
                        case 'doc' :
                            echo '<th><a href="'.base_url().'includes/docs/'.$row->Ruta.'" onMouseover="tip(\''.$row->Nombre.'\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/doc.png" width="35" /></a></th>';
                            break;
                            
                        // Word 2010
                        case 'docx' :
                            echo '<th><a href="'.base_url().'includes/docs/'.$row->Ruta.'" onMouseover="tip(\''.$row->Nombre.'\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/doc.png" width="35" /></a></th>';
                            break;
                            
                        // Excel
                        case 'xls' :
                            echo '<th><a href="'.base_url().'includes/docs/'.$row->Ruta.'" onMouseover="tip(\''.$row->Nombre.'\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/xls.png" width="35" /></a></th>';
                            break;
                            
                        // Excel 2011
                        case 'xlsx' :
                            echo '<th><a href="'.base_url().'includes/docs/'.$row->Ruta.'" onMouseover="tip(\''.$row->Nombre.'\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/xls.png" width="35" /></a></th>';
                            break;
                        
                        // Pdf
                        case 'pdf' :
                            echo '<th><a href="'.base_url().'includes/docs/'.$row->Ruta.'" target="_blank" onMouseover="tip(\''.$row->Nombre.'\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/pdf.png" width="35" /></a></th>';
                            break;
                        
                        // Archivo
                        default :
                            echo '<th><a href="'.base_url().'includes/docs/'.$row->Ruta.'" target="_blank" onMouseover="tip(\''.$row->Nombre.'\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/archivo.png" width="35" /></a></th>';
                            break;
                    }
                    echo '<td>'.$row->Seccion.'</td>';
                    echo '<td>'.$row->Codigo.'</td>';
                    echo '<td>'.$row->Nombre.'</td>';
                    echo '<td>'.$row->Edicion.'</td>';
                    echo '<td>'.$row->Fecha.'</td>';
					if( !$this->session->userdata( 'ADI' ) ) {
						echo '<td width="24"><a href="'.base_url().'index.php/admin/documentos/modificar_documento/'.$row->IdDocumento.'/comun" onMouseover="tip(\'Modificar\')" onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
						echo '<td width="24"><a onclick="pregunta_cambiar( \'documentos\', '.$row->IdDocumento.', 0, \'&iquest;Deseas eliminar este documento?\', \'documentos-comun\')" onMouseover="tip(\'Eliminar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';
					}
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
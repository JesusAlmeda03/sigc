<?php
/****************************************************************************************************
*
*	VIEWS/inicio/documentos.php
*
*		Descripción:
*			Vista del listado de las listas maestras de los documentos
*
*		Fecha de Creación:
*			15/Octubre/2012
*
*		Ultima actualización:
*			15/Octubre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			@rogelio_cas
*			rogeliocas@gmail.com
*
****************************************************************************************************/
?>
	<div class="content">		
		<div class="cont">
			<div class="titulo"><?=$titulo?></div>
            <div class="texto">
            	<?php
	            if( $documentos->num_rows() > 0 ) {
	                echo '<table class="tabla" id="tabla" width="700">';
	                echo '<thead><tr>';
	                echo '<th width="15" class="no_sort" style="border:0; border-bottom:1px solid #E0E0E0"></th>';
	                echo '<th width="15" class="no_sort" style="border:0; border-bottom:1px solid #E0E0E0"></th>';
	                echo '<th width="20">C&oacute;digo</th>';
					echo '<th>Nombre</th>';
					echo '<th>Secci&oacute;n</th>';
					echo '<th width="20">Edici&oacute;n</th>';
					echo '<th width="20">Fecha</th>';
					echo '</tr></thead><tbody>';
	                foreach( $documentos->result() as $row ) :
$tipo=$row->Seccion;
						if($tipo<>'Registros'){
	                    echo '<tr>';
					
						// Si tiene, muestra el documento en Word
						if( $row->RutaWord != "" ) {
							echo '	<th><a href="'.base_url().'includes/docs/'.$row->RutaWord.'" onMouseover="tip(\''.$row->Nombre.'<br />en formato word\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/doc.png" width="35" /></a></th>';
						}							
						else {
							echo '	<th><a onMouseover="tip(\'No se ha encontrado el<br />documento en formato word\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/doc_notfound.png" width="35" height="35" /></a></th>';
						}
						
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
	                    echo '<td>'.$row->Codigo.'</td>';
	                    echo '<td>'.$row->Nombre.'</td>';
	                    echo '<td>'.$row->Seccion.'</td>';
	                    echo '<td>'.$row->Edicion.'</td>';
	                    echo '<td>'.$row->Fecha.'</td>';
	                    echo '</tr>';
			}
	                endforeach;
	                echo '</tbody></table>';
					echo $sort_tabla;
	            }
	            else {
	                echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay documentos</td></tr></table>';
	            }
	            ?>
            </div>
		</div>

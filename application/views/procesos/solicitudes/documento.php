<?php
/****************************************************************************************************
*
*	VIEWS/solicitudes/altas.php
*
*		Descripci�n:
*			Vista para la solicitud de alta de documentos
*
*		Fecha de Creaci�n:
*			24/Noviembre/2011
*
*		Ultima actualizaci�n:
*			25/Noviembre/2011
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
				<?php
                $style_are = $style_cod = $style_edi = $style_nom = $style_fec = "";
                $style = 'border:1px solid #C62223;';
                if( $cod != "" ) $style_cod = $style;
        
		        if( $nom != "" ) $style_nom = $style;
				
		// Tipos de documentos
            	$seccion_extras = 'id="seccion" onfocus="hover(\'seccion\')" onchange="form.submit()" style="width:370px; margin:0 0 0 5px;"';
				echo form_open('','');
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="text_form" width="200">Elige el tipo de documento: </th>';
	            echo '<td>'.form_dropdown('seccion',$seccion_options,$sec,$seccion_extras).'</td></tr>';
				echo '</table><br />';
                echo form_close();
				
		// Tabla de resultados
				if( $busqueda ) {
                    if( $consulta->num_rows() > 0 ) {
                        echo '<table class="tabla" id="tabla" width="700">';
                        echo '<thead><tr><th colspan="2" class="no_sort"></th>';
                        echo '<th>C&oacute;digo</th><th>Edici&oacute;n</th><th>Nombre</th><th>Fecha</th><th class="no_sort" width="15"></th></tr></thead><tbody>';
						$j = 1;
                        foreach( $consulta->result() as $row ) :
							if( $j ) {
								echo '<tr>';
								$j = 0;
							}
							else {
								echo '<tr class="odd">';
								$j = 1;
							}							
							if( substr($row->Ruta,11) == "." ) { 
								$ext = substr($row->Ruta,12);
							}
							else {
								$doc = $row->Ruta;
								$j = 0;
								$k = 0;
								$i = strlen($doc) - 1;
								for ( $i; $i > 0 ; $i-- ) {
									if ( $doc[$i] == "." ){
										$j = $k;
										break;
									}
									$k++;
								}
								$ext = substr($doc,strlen($doc)-$j,$j);						
							}
							switch( $ext ) {
								// Word
								case 'doc' :
									

									if(empty($row->RutaWord)){
										echo '<th><img src="'.base_url().'includes/img/icons/doc_notfound.png" width="35" /></th>';	
									}else{
										echo '<th><a href="'.base_url().'includes/docs/'.$row->RutaWord.'" onMouseover="tip(\''.$row->Nombre.'\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/doc.png" width="35" /></a></th>';
									}

									break;
									
								// Word 2010
								case 'docx' :
									
								
									if(empty($row->RutaWord)){
										echo '<th><img src="'.base_url().'includes/img/icons/doc_notfound.png" width="35" /></th>';	
									}else{
										echo '<th><a href="'.base_url().'includes/docs/'.$row->RutaWord.'" onMouseover="tip(\''.$row->Nombre.'\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/doc.png" width="35" /></a></th>';
									}
									break;
									
								// Excel
								case 'xls' :
									echo '<th><a href="'.base_url().'includes/docs/'.$row->Ruta.'" onMouseover="tip(\''.$row->Nombre.'\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/xls.png" width="35" /></a></th>';
									if(empty($row->RutaWord)){
										echo '<th><img src="'.base_url().'includes/img/icons/doc_notfound.png" width="35" /></th>';	
									}else{
										echo '<th><a href="'.base_url().'includes/docs/'.$row->RutaWord.'" onMouseover="tip(\''.$row->Nombre.'\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/xls.png" width="35" /></a></th>';
									}
									break;
									
								// Excel 2011
								case 'xlsx' :
									echo '<th><a href="'.base_url().'includes/docs/'.$row->Ruta.'" onMouseover="tip(\''.$row->Nombre.'\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/archivo.png" width="35" /></a></th>';
									if(empty($row->RutaWord)){
										echo '<th><img src="'.base_url().'includes/img/icons/doc_notfound.png" width="35" /></th>';	
									}else{
										echo '<th><a href="'.base_url().'includes/docs/'.$row->RutaWord.'" onMouseover="tip(\''.$row->Nombre.'\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/archivo.png" width="35" /></a></th>';
									}
									break;
								
								// Pdf
								case 'pdf' :

									echo '<th><a href="'.base_url().'includes/docs/'.$row->Ruta.'" onMouseover="tip(\''.$row->Nombre.'\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/pdf.png" width="35" /></a></th>';
									if(empty($row->RutaWord)){
										echo '<th><img src="'.base_url().'includes/img/icons/doc_notfound.png" width="35" /></th>';	
									}else{
										echo '<th><a href="'.base_url().'includes/docs/'.$row->RutaWord.'" onMouseover="tip(\''.$row->Nombre.'\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/archivo.png" width="35" /></a></th>';
									}
									
									break;
								
								// Archivo
								default :
									echo '<th><a href="'.base_url().'includes/docs/'.$row->Ruta.'" target="_blank" onMouseover="tip(\''.$row->Nombre.'\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/archivo.png" width="35" /></a></th>';
									break;
							}
                            echo '<td>'.$row->Codigo.'</td><td>'.$row->Edicion.'</td><td>'.$row->Nombre.'</td><td>'.$row->Fecha.'</td>';
                            echo '<td width="24"><a href="'.base_url().'index.php/procesos/solicitudes/'.$solicitud.'/'.$row->IdDocumento.'" onMouseover="tip(\'Elegir documento para '.$solicitud.'\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/seguimiento.png" /></a></td>';
                            echo '</tr>';
                        endforeach;
                        echo '</tbody></table>';
						echo $sort_tabla;
                    }
                    else {
                    	echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>No se encontraron coincidencias con la b&uacute;squeda</td></tr></table>';
                    }
                }
                ?>
	        </div>
    </div>

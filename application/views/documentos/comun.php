<?php
/****************************************************************************************************
*
*	VIEWS/documentos/comun.php
*
*		Descripción:
*			Listado de Documentos de Uso Común
*
*		Fecha de Creación:
*			06/Octubre/2011
*
*		Ultima actualización:
*			31/Julio/2012
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
                if( $documentos->num_rows() > 0 ) {
                	
                // Instructivos de Trabajo con permisos de CONTROLADOR DE DOCUMENTOS
                	if( $this->session->userdata('SOL') && $id == 1 ) {
                		echo '<table class="tabla" id="tabla" width="700">';
						echo '	<thead>';
						echo '		<tr>';
						echo '			<th width="15" class="no_sort"></th>';
						echo '			<th width="15" class="no_sort"></th>';
						echo '			<th width="20">C&oacute;digo</th>';
						echo '			<th>Nombre</th>';
						echo '			<th width="10">Edici&oacute;n</th>';
						echo '			<th width="120">Fecha</th>';
						echo '		</tr>';
						echo '	</thead>';
						echo '	<tbody>';
						foreach( $documentos->result() as $row ) {
							// obtiene la extensión del documento
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
							
							echo '	<tr>';
							// Si tiene, muestra el documento en Word
							if( $row->RutaWord != "" )
								echo '	<th><a href="'.base_url().'includes/docs/'.$row->RutaWord.'" onMouseover="ddrivetip(\''.$row->Nombre.'<br />en formato word\')"; onMouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/doc.png" width="35" /></a></th>';							
							else
								echo '	<th><a onMouseover="ddrivetip(\'No se ha encontrado el<br />documento en formato word\')"; onMouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/doc_notfound.png" width="35" height="35" /></a></th>';
							echo '		<th><a href="'.base_url().'includes/docs/'.$row->Ruta.'" onMouseover="ddrivetip(\''.$row->Nombre.'\')"; onMouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/'.$ext.'.png" width="35" /></a></th>';				
							echo '		<td>'.$row->Codigo.'</td>';
							echo '		<td>'.$row->Nombre.'</td>';
							echo '		<td>'.$row->Edicion.'</td>';
							echo '		<td>'.$row->Fecha.'</td>';
							echo '		</tr>';
	                    }
						echo '	</tbody>';
						echo '</table>';
						echo $sort_tabla;
					}
					
                // Registros
					elseif( $id == 12 ) {
						echo '<table class="tabla" id="tabla" width="700">';
						echo '	<thead>';
						echo '		<tr>';
						echo '			<th width="15" class="no_sort"></th>';
						echo '			<th width="20">C&oacute;digo</th>';
						echo '			<th>Nombre</th>';
						echo '			<th width="40">Retenci&oacute;n</th>';
						echo '			<th width="40">Disposici&oacute;n</th>';						
						echo '			<th width="120">Fecha</th>';
						echo '		</tr>';
						echo '	</thead>';
						echo '	<tbody>';
	                    foreach( $documentos->result() as $row ) {							
							// obtiene la extensión del documento
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
							
							echo '	<tr>';
							echo '		<th><a href="'.base_url().'includes/docs/'.$row->Ruta.'" onMouseover="ddrivetip(\''.$row->Nombre.'\')"; onMouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/'.$ext.'.png" width="35" /></a></th>';				
							echo '		<td>'.$row->Codigo.'</td>';
							echo '		<td>'.$row->Nombre.'</td>';
							echo '		<td>'.$row->Retencion.'</td>';
							echo '		<td>'.$row->Disposicion.'</td>';
							echo '		<td>'.$row->Fecha.'</td>';
							echo '	</tr>';
	                    }
						echo '	</tbody>';
						echo '</table>';
						echo $sort_tabla;
					}

				// Todos los documentos por área
				else {
                		echo '<table class="tabla" id="tabla" width="700">';
						echo '	<thead>';
						echo '		<tr>';
						echo '			<th width="15" class="no_sort"></th>';
						echo '			<th width="20">C&oacute;digo</th>';
						echo '			<th>Nombre</th>';
						echo '			<th width="10">Edici&oacute;n</th>';
						echo '			<th width="120">Fecha</th>';
						echo '		</tr>';
						echo '	</thead>';
						echo '	<tbody>';
						foreach( $documentos->result() as $row ) {
							// obtiene la extensión del documento
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
							
							echo '	<tr>';
							echo '		<th><a href="'.base_url().'includes/docs/'.$row->Ruta.'" onMouseover="ddrivetip(\''.$row->Nombre.'\')"; onMouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/'.$ext.'.png" width="35" /></a></th>';				
							echo '		<td>'.$row->Codigo.'</td>';
							echo '		<td>'.$row->Nombre.'</td>';
							echo '		<td>'.$row->Edicion.'</td>';
							echo '		<td>'.$row->Fecha.'</td>';
							echo '		</tr>';
	                    }
						echo '	</tbody>';
						echo '</table>';
						echo $sort_tabla;
					}

                }
                else {
                    echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay documentos</td></tr></table>';
                }
                ?>
			</div>
		</div>
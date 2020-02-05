<?php
/****************************************************************************************************
*
*	VIEWS/documentos/area.php
*
*		Descripción:
*			Listado de Documentos por área
*
*		Fecha de Creación:
*			06/Octubre/2011
*
*		Ultima actualización:
*			11/Julio/2012
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
                if( $evidencias->num_rows() > 0 ){
                	
                    // Instructivos de Trabajo con permisos de CONTROLADOR DE DOCUMENTOS
                		echo '<table class="tabla" id="tabla" width="700">';
						echo '	<thead>';
						echo '		<tr>';
						echo '			<th width="20"></th>';
						echo '			<th>Nombre</th>';
						echo '			<th width="120">Fecha</th>';
						echo '		</tr>';
						echo '	</thead>';
						echo '	<tbody>';
						foreach( $evidencias->result() as $row ) {
							$ruta = base_url()."includes/gestion/".$row->Ruta;
							

							// obtiene la extensión del documento
							    echo '	<tr>';					   
								echo '	    <th>
												<a href="'.$ruta.'"onMouseover="ddrivetip(\'No se ha encontrado el<br />documento en formato word\')"; onMouseout="hideddrivetip()" target="_blank">
									
												<img src="'.base_url().'includes/img/icons/doc.png" width="35" height="35" /></a></th>';
                                echo '		<td>'.$row->Nombre.'</td>';
                                echo '		<td>'.$row->Fecha.'</td>';
                                echo '	</tr>';
                        }
                            echo '	</tbody>';
						    echo '</table>';
						    echo $sort_tabla;
                        
						
                    }else {
                        echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay Evidencias</td></tr></table>';
					}
					
                
                ?>
            </div>
        </div>
    </div>


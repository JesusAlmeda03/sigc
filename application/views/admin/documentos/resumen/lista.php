<?php
/****************************************************************************************************
*
*	VIEWS/admin/documentos/resumen/listado.php
*
*		Descripci�n:
*			Vista que muestra todo el listado de usuarios
*
*		Fecha de Creaci�n:
*			27/Octubre/2011
*
*		Ultima actualizaci�n:
*			27/Octubre/2011
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
?>
<div class="cont_admin">
		<div class="cont">
			<div class="titulo"><?=$titulo?></div>
            <div class="texto">
            	<?php
            		echo '<table class="tabla" id="tabla" width="700">';
					echo '<thead><tr><th width="15" class="no_sort"></th><th>Descripcion del Documento</th><th>Tipo</th><th>Fecha</th><th colspan="3">Acciones</th></tr></thead>';
                    echo '<tbody>';
                    if($listado->num_rows() > 0){
                        foreach( $listado->result() as $row ) {
                            echo '<tr>';
                            echo '	<th><img src="'.base_url().'includes/img/icons/doc.png" /></th>';
                            
                            echo '	<td>'.$row->Nombre.'</td>';
                            echo '	<td>'.$row->Tipo.'</td>';
                            
                            
                            echo '	<td>'.$row->Fecha.'</td>';
                            
                            echo '	<td>
                                        <center>
                                            <a href="'.base_url().'includes/docs/expedientes/'.$row->Ruta.'" target="_blank">
                                                <img src="'.base_url().'includes/img/icons/ver.png" />
                                            </a>
                                        </center>
                                    </td>
                                    ';
                            echo '	<td>
                                    <center>
                                        <a href="'.base_url().'index.php/admin/documentos/resumen_editar/'.$row->IdResumen.'">
                                            <img src="'.base_url().'includes/img/icons/modificar.png" />
                                        </a>
                                    </center>
                                </td>
                                ';
                            if($row->Estado == 1){
                                echo '	<td>
                                    <center>
                                        <a href="'.base_url().'index.php/admin/documentos/resumen_eliminar/'.$row->IdResumen.'">
                                            <img src="'.base_url().'includes/img/icons/eliminar.png" />
                                        </a>
                                    </center>
                                </td>
                                ';
                            }else{
                                echo '	<td>
                                    <center>
                                        <a href="'.base_url().'index.php/admin/documentos/resumen_cambiar/'.$row->IdResumen.'">
                                            <img src="'.base_url().'includes/img/icons/activar.png" />
                                        </a>
                                    </center>
                                </td>
                                ';
                            }
            
                            echo '</tr>';
                        }
                    }else{
                        echo '<tr><td colspan="4">No hay ningun registro</td></tr>';
                    }
            		
					echo '</tbody>';
					echo '</table>';
					echo $sort_tabla;
				?>
            </div>
			
		</div>
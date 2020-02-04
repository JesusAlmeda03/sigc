<?php
/****************************************************************************************************
*
*	VIEWS/procesos/expediente/revisar.php
*
*		Descripción:
*			Revisa el expediente de un usuario 
*
*		Fecha de Creación:
*			10/Enero/2013
*
*		Ultima actualización:
*			10/Enero/2013
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
            	echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="text_form" width="80">Usuario: </th>';
	            echo '<td>'.$nombre_usuario.'</td></tr>';
				echo '</table><br />';
				
            	
            	

					echo '<table class="tabla" id="tabla" width="700">';
					echo '<thead><tr><th width="15" class="no_sort"></th><th>Descripcion del Documento</th><th>Tipo</th><th colspan="2">Acciones</th></tr></thead>';
					echo '<tbody>';
            		foreach( $usuario_expediente->result() as $row ) {
						echo '<tr>';
						echo '	<th><img src="'.base_url().'includes/img/icons/doc.png" /></th>';
						if($row->Descripcion == Null ){
							echo '	<td>'.$row->Fecha.'</td>';
						}else{
							echo '	<td>'.$row->Descripcion.'</td>';
						}
						echo '	<td>'.strtoupper($row->Tipo).'</td>';
						
						echo '	<td>
									<center>
										<a href="'.base_url().'includes/docs/expedientes/'.$row->Ruta.'" target="_blank">
											<img src="'.base_url().'includes/img/icons/ver.png" />
										</a>
									</center>
								</td>
								<td>
									<center>
										<a href="'.base_url().'index.php/procesos/capacitacion/expediente_modificar/'.$row->IdExpediente.'">
											<img src="'.base_url().'includes/img/icons/modificar.png" />
										</a>
									</center>
								</td>';
						echo '</tr>';
            		}
					echo '</tbody>';
					echo '</table>';
					echo $sort_tabla;
				?>
            </div>
			
		</div>
<?php
/****************************************************************************************************
*
*	VIEWS/procesos/indicadores/listado.php
*
*		Descripci�n:
*			Listado de todos los indicadores
*
*		Fecha de Creaci�n:
*			30/Octubre/2011
*
*		Ultima actualizaci�n:
*			30/Octubre/2011
*
*		Autor:
*			ISC Rogelio Casta�eda Andrade
*			HERE (http://www.webHERE.com.mx)
*			rogeliocas@gmail.com
*
****************************************************************************************************/
?>
	<div class="content">		
		<div class="cont">
			<div class="titulo"><?=$titulo?></div>
            <div class="texto">
				<?php 
                if( $consulta->num_rows() > 0 ) {
					echo '<table class="tabla" id="tabla" width="700">';
					echo '<tbody>';
					$i = 0;
                    foreach( $consulta->result() as $row ) :
						if( $i ) {
							echo '<tr class="odd">';
							$i = 0;
						}
						else {
							echo '<tr>';
							$i = 1;
						}
						switch( $this->session->userdata( 'id_area' ) ) {
							// Contraloría
							case '1' :
								if( $row->IdIndicador == '146' ) {
									echo '<th width="30" style="text-align:center"><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$row->IdIndicador.'/todos" onmouseover="tip(\'Revisar el Indicador\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/grafica.png" /></a></th>';
									echo '<td><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$row->IdIndicador.'/todos">'.$row->Indicador.'</a></td>';
								}
								else {
									echo '<th width="30" style="text-align:center"><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$row->IdIndicador.'/todos" onmouseover="tip(\'Revisar el Indicador\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/grafica.png" /></a></th>';
									echo '<td><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$row->IdIndicador.'/todos">'.$row->Indicador.'</a></td>';
								}	
								break;
								
							// Obras
							case '2' :
								if( $row->IdIndicador == '107' ) {
									echo '<th width="30" style="text-align:center"><a href="'.base_url().'index.php/procesos/indicadores/grafica_especiales/'.$row->IdIndicador.'/todos" onmouseover="tip(\'Revisar el Indicador\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/grafica.png" /></a></th>';
									echo '<td><a href="'.base_url().'index.php/procesos/indicadores/grafica_especiales/'.$row->IdIndicador.'/todos">'.$row->Indicador.'</a></td>';
								}
								else {
									echo '<th width="30" style="text-align:center"><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$row->IdIndicador.'/todos" onmouseover="tip(\'Revisar el Indicador\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/grafica.png" /></a></th>';
									echo '<td><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$row->IdIndicador.'/todos">'.$row->Indicador.'</a></td>';
								}
								break;
								
							// Todas las demas áreas
							default :
								echo '<th width="30" style="text-align:center"><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$row->IdIndicador.'/todos" onmouseover="tip(\'Revisar el Indicador\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/grafica.png" /></a></th>';
								echo '<td><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$row->IdIndicador.'/todos">'.$row->Indicador.'</a></td>';
								break;
							
						}
						echo '</tr>';
                    endforeach;
					echo '</tbody></table>';
                }
                else {
                    echo '<table class="tabla" width="672"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay indicadores</td></tr></table>';
                }
                ?>
        </div>
    </div>
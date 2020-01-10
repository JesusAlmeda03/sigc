<?php
/****************************************************************************************************
*
*	VIEWS/admin/minutas/minutas_comite.php
*
*	Descripción:
*		
*
*	Fecha de Creación:
*		31/Enero/2012
*
*	Ultima actualización:
*		9/Marzo/2012
*
*	Autor:
*		ISC Rogelio Castañeda Andrade
*		HERE (http://www.webHERE.com.mx)
*		rogeliocas@gmail.com
*
****************************************************************************************************/
?>
    <div class="cont" style="width:970px;">
    	<div class="title"><?=$titulo?></div>
        <div class="text">
        	<?php
        	echo '<table class="tabla" width="950"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Estas minutas se van generando automaticamente en base a las minutas de las &aacute;reas</td></tr></table><br />';
			if( $minutas->num_rows() > 0 ) {
				echo '<table class="tabla" id="tabla" width="950">';
				echo '<thead><tr><th width="20" class="no_sort"></th><th>Periodo</th><th>Ano</th><th width="20" class="no_sort"></th></tr></thead>';
				echo '<tbody>';
				foreach( $minutas->result() as $row ) {
					echo '<tr>';
					switch( $row->Periodo ) {
						case "Enero - Marzo" : $per = 1; break;
						case "Abril - Junio" : $per = 2; break;
						case "Julio - Septiembre" :	$per = 3; break;
						case "Octubre - Diciembre" : $per = 4;	break;
						default : $per = 0; break;
					}
					echo '<th width="20"><a href="'.base_url().'index.php/admin/minutas/ver/'.$per.'/'.$row->Ano.'" target="_blank" onmouseover="ddrivetip(\'Abrir minuta\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/doc.png" /></a></th>';
					echo '<td>'.$row->Periodo.'</td><td>'.$row->Ano.'</td>';
					//echo '<td><a href="'.base_url().'index.php/admin/minutas/acuerdos/'.$per.'/'.$row->Ano.'" onmouseover="ddrivetip(\'Agregar / editar<br />acuerdos de la reunion\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/edit.gif" /></a></td>';
					echo '<td><a href="'.base_url().'index.php/admin/minutas/puntos/'.$per.'/'.$row->Ano.'" onmouseover="ddrivetip(\'Agregar / editar<br />comentarios\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
					echo '</tr>';
				}
				echo '</tbody></table>';
				echo $sort_tabla;
			}
        	?>			
        </div>
    </div><div class="btm_sh" style="width:982px; margin:0 0 5px 0"></div>
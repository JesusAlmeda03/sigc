<?php
/****************************************************************************************************
*
*	VIEWS/misc/enlaces.php
*
*		Descripci�n:  		  
*			Vista de la p�gina de enlaces de interes
*
*		Fecha de Creaci�n:
*			11/Octubre/2011
*
*		Ultima actualizaci�n:
*			11/Octubre/2011
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
			<div class="titulo">Enlaces de Interes</div>
            <div class="texto">
				<?php
                if( $consulta->num_rows() > 0 ) {
					echo '<table class="tabla" style="widht:700px">';
                    foreach( $consulta->result() as $row ) :
                        echo '<tr><th valign="middle"><a href="'.$row->Enlace.'" target="_blank" onMouseover="ddrivetip(\''.$row->Enlace.'\')"; onMouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/small/ext.png" /></a></th><th valign="middle"> <a href="'.$row->Enlace.'" target="_blank" onMouseover="ddrivetip(\''.$row->Enlace.'\')"; onMouseout="hideddrivetip()">'.$row->Nombre.'</a></th><td>'.$row->Descripcion.'</td></tr>';
                    endforeach;
					echo '</table>';
                }
                else {
                    echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay enlaces de interes</td></tr></table>';
                }
                ?>
			</div>
		</div>
<?php
/****************************************************************************************************
*
*	VIEWS/areas/area.php
*
*		Descripci�n:  		  
*			Vista de la descripci�n de un �rea espec�fica
*
*		Fecha de Creaci�n:
*			20/Octubre/2011
*
*		Ultima actualizaci�n:
*			20/Octubre/2011
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
			<div class="titulo"><?=$titulo_area?></div>
            <div class="texto">
				<?php
				echo '<a href="'.$paginaweb.'" target="_blank" onMouseover="ddrivetip(\''.$paginaweb.'\')"; onMouseout="hideddrivetip()"><img src="'.base_url().'includes/img/areas/'.$this->session->userdata('id_area').'_big.png" /></a><br />';
				echo $paginaweb;
				?>						
            </div>
		</div>
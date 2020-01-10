<?php
/****************************************************************************************************
*
*	VIEWS/admin/ajax_secciones.php
*
*		Descripción:  		  
*			Vista de las secciones traidas mediante ajax
*
*		Fecha de Creación:
*			20/Octubre/2011
*
*		Ultima actualización:
*			20/Octubre/2011
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			HERE (http://www.webHERE.com.mx)
*			rogeliocas@gmail.com
*
****************************************************************************************************/
if( $secciones->num_rows() > 0 ) {
	echo '<select name="seccion" id="seccion" onfocus="hover(\'seccion\')" onchange="registro()">';
	foreach( $secciones->result() as $row ) :
		echo '<option value="'.$row->IdSeccion.'">';
		echo $row->Seccion;
		echo '</option>';
	endforeach;
	echo "</select>";
}
else {
	echo '<div style="padding-bottom:10px">Por el momento no hay Secciones</div>';
}
?>

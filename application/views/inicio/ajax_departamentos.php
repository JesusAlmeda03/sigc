<?php
/****************************************************************************************************
*
*	VIEWS/procesos/ajax_departamentos.php
*
*		Descripción:  		  
*			Vista de los deparamentos traidos mediante ajax
*
*		Fecha de Creación:
*			18/Octubre/2011
*
*		Ultima actualización:
*			18/Octubre/2011
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			HERE (http://www.webHERE.com.mx)
*			rogeliocas@gmail.com
*
****************************************************************************************************/
if( $departamentos->num_rows() > 0 ) {
	echo '<select name="departamento" id="departamento" onfocus="hover(\'departamento\')">';
	foreach( $departamentos->result() as $row ) :
		echo '<option value="'.$row->IdDepartamento.'">';
		echo $row->Departamento;
		echo '</option>';
	endforeach;
	echo "</select>";
}
else {
	echo '<div style="padding-bottom:10px">Por el momento no hay Departamentos de esta &Aacute;rea</div>';
}
?>

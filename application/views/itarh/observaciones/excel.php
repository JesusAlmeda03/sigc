<?php
/****************************************************************************************************
*
*	VIEWS/itarh/observaciones/listado.php
*
*		Descripción:
*			Listado de observaciones
*
*		Fecha de Creación:
*			09/Octubre/2011
*
*		Ultima actualización:
*			09/Octubre/2011
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=observaciones.xls");
header("Pragma: no-cache");
header("Expires: 0");

if( $consulta->num_rows() > 0 ) {
	echo '<html><head></head><body>';
    echo '<table class="tabla" id="tabla">';
	echo '<thead><tr>';
	echo '<th>No</th>';
	echo '<th>Estatus</th>';
	echo '<th>Quincena</th>';
	echo '<th>Matricula</th>';
	echo '<th>Nombre</th>';
	echo '<th>Tipo de<br />Empleado</th>';
	echo '<th>Unidad<br />Responsable</th>';
	echo '<th>Permanencia</th>';
	echo '<th>Hrs.<br />Contrato</th>';
	echo '<th>Sistema</th>';
	echo '<th>Contralor&iacute;a</th>';
	echo '<th>Observaci&oacute;n</th>';
	echo '</tr></thead><tbody>';
	foreach( $consulta->result() as $row ) {
		switch( $row->Estado ) {
			case 0 :
				$img_estado = 'Pendiente';
				break;
				
			case 1 :
				$img_estado = 'Solventada';
				break;
				
			case 2 :
				$img_estado = 'Eliminada';
				break;
		}
	    echo '<tr>';
	    echo '<td>'.$row->IdObservacion.'</td>';
	    echo '<th>'.$img_estado.'</th>';
		echo '<td>'.$row->Quincena.'</td>';
		echo '<td>'.$row->Matricula.'</td>';
	    echo '<td>'.$row->Nombre.'</td>';
		echo '<td>'.$row->Empleado.'</td>';
		echo '<td>'.$row->Unidad.'</td>';
		echo '<td>'.$row->Permanencia.'</td>';
		echo '<td>'.$row->Horas.'</td>';
		echo '<td>'.$row->Sistema.'</td>';
		echo '<td>'.$row->Contraloria.'</td>';
	    echo '<td>'.$row->Observacion.'</td>';
	    echo '</tr>';
	}
	echo '</tbody></table>';
}
echo '</body></html>';
?>
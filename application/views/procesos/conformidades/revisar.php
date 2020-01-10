<?php
/****************************************************************************************************
*
*	VIEWS/procesos/quejas/ver.php
*
*		Descripci�n:
*			Vista de la informaci�n de la no conformidad
*
*		Fecha de Creaci�n:
*			30/Octubre/2011
*
*		Ultima actualizaci�n:
*			15/Diciembre/2011
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
			<div class="titulo">No Conformidad</div>
            <div class="texto">
				<?php
					if($conformidad -> num_rows() > 0){
						foreach($conformidad -> result() as $row){
							echo '<table class="tabla_form" width="700">';
							echo '<thead><tr><th colspan="2"><span class="titulo_tabla">Datos de la No Conformidad</div></th></tr></thead>';
							echo '<tr><th class="text_form" width="80" style="font-weight:normal">Usuario que levant&oacute; la No Conformidad: </th>';
							echo '<td class="row">'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.'</td></tr>';
							echo '<tr><th class="text_form" style="font-weight:normal">&Aacute;rea: </th>';
							echo '<td class="row">'.$row->Area.'</td></tr>';
							echo '<tr><th class="text_form" style="font-weight:normal">Departamento: </th>';
							echo '<td class="row">'.$row->Departamento.'</td></tr>';
							//echo '<tr><th class="text_form" style="font-weight:normal">Consecutivo: </th>';
							//echo '<td class="row">'.$con.'</td></tr>';
							echo '<tr><th class="text_form" style="font-weight:normal">Fecha: </th>';
							echo '<td class="row">'.$row->Fecha.'</td></tr>';
							echo '<tr><th class="text_form" style="font-weight:normal">Origen: </th>';
							echo '<td class="row">'.$row->Origen.'</td></tr>';
							echo '<tr><th class="text_form" style="font-weight:normal">Tipo: </th>';
							echo '<td class="row">'.$row->Tipo.'</td></tr>';
							echo '<tr><th class="text_form" style="font-weight:normal" valign="top">Descripci&oacute;n: </th>';
							echo '<td class="row">'.$row->Descripcion.'</td></tr>';
							echo '</table>';
							echo '<br />';
						}
					}

				?>
            </div>
		</div>
	</div>

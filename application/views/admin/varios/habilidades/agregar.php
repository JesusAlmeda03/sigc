<?php
/****************************************************************************************************
 *
 *	VIEWS/admin/varios/habilidades_agregar.php
 *
 *		Descripción:
 *			Vista que muestra el formulario para agregar habilidades a los usuarios de cada area
 *
 *		Fecha de Creación:
 *			2/Febrero/2012
 *
 *		Ultima actualizaci�n:
 *			2/Febrero/2012
 *
 *		Autor:
 *			ISC Rogelio Castañeda Andrade
 *			rogeliocas@gmail.com
 *			@rogelio_cas
 *
 ****************************************************************************************************/
foreach($nombre->result() as $nom){}
?>

	<div class="cont_admin">
		<div class="titulo"><?=$titulo ." para: ".$nom->Nombre." ".$nom->Paterno." ".$nom->Materno?></div>
		<div class="titulo"><?php echo "Con el puesto de: ".$nom->Puesto; echo " <a href='../habilidades_mpuesto/".$nom->IdPuesto."'>Cambiar</a>"?> </div>
        <div class="texto">
            <?php
			$formulario = array(
				// * Boton submit
				'boton' => array (
					'id'		=> 'aceptar',
					'name'		=> 'aceptar',
					'class'		=> 'in_button',
					'onfocus'	=> 'hover(\'aceptar\')'
				),
				// * Boton submit
				'boton_cancelar' => array (
					'id'		=> 'cancelar',
					'name'		=> 'cancelar',
					'class'		=> 'in_button',
					'onfocus'	=> 'hover(\'cancelar\')',
					'style'		=> 'width:120px; height:45px; font-size:16px; letter-spacing:3px; margin-left:10px',

				),
				// Habilidad
				'habilidad' => array (
					'name'		=> 'habilidad',
					'id'		=> 'habilidad',
					'class'		=> 'in_text',
					'onfocus'	=> "hover('habilidad')",

				),

				// Habilidad
				'puesto' => array (
					'name'		=> 'puesto',
					'id'		=> 'puesto',
					'class'		=> 'in_text',
					'onfocus'	=> "hover('puesto')",

				),

			);
            ?>
			<?php
			// Formulario de modificacion de la habilidad
			echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
			echo form_hidden('puesto', $nom->IdPuesto);
			echo '<table width="980" class="tabla_form">';
			echo '<tr><th class="text_form" width="70" valign="top" style="padding-top:10px;">Habilidad: </th><td>'.form_input($formulario['habilidad']).'</td></tr>';
			echo '</table><br />';
			echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').form_button($formulario['boton_cancelar'],'Cancelar').'</div>';
			echo form_close();

			// Listado de habilidades
			echo '<br /><br />';
			if ($habilidades -> num_rows() > 0) {
				echo '<table class="tabla" id="tabla" width="980">';
				echo '<thead><tr>';

				echo '<th style="width: 90%">Habilidades</th><th></th></tr></thead>';
				echo '<tbody>';
				$i = 0;
					foreach ($habilidades->result() as $hab) {
							// definen las acciones segun el estado de la no conformidad

							echo "<tr><td>";
							echo $hab->Habilidad;
							echo "</td>";
							echo "<td>";
							echo "<a href='../habilidades_eliminar/".$hab->IdCapacitacionHabilidad."/".$hab->IdUsuario."'><img src='".base_url()."includes/img/icons/eliminar.png' /></a>";
							echo "</td>";
							//echo "<td><a href="eliminar modificar</td></tr>";
					}
				}else{
					echo "<tr><th>El usuario no tiene habilidades asigandas</th></tr>";
				}
				echo '</tbody></table>';
				echo $sort_tabla;


            ?>
            <br />
            <table><tr><td><a href="<?=base_url() ?>index.php/admin/varios/habilidades/" onmouseover="tip('Regresa al listado de<br />indicadores')" onmouseout="cierra_tip()"><img src="<?=base_url() ?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url() ?>index.php/admin/varios/habilidades/" onmouseover="tip('Regresa al listado de<br />no conformidades')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
    	</div>
	</div>

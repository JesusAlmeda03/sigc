<?php
/****************************************************************************************************
 *
 *	VIEWS/admin/varios/habilidades_puesto.php
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
				// Indicador
				'puesto' => array (
					'name'		=> 'puesto',
					'id'		=> 'puesto',
					'class'		=> 'in_text',
					'onfocus'	=> "hover('puesto')",
					
				),
				
			);
            ?>	          
			<?php 
			// Formulario de modificacion del indicador
			echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
			echo '<table width="980" class="tabla_form">';
			echo '<tr><th class="text_form" width="70" valign="top" style="padding-top:10px;">Puesto</th><td>'.form_input($formulario['puesto']).'</td></tr>';
			echo '</table><br />';
			echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
			echo form_close();
			
			// Listado de mediciones
			echo '<br /><br />';
           
            ?>
            <br />
            <table><tr><td><a href="<?=base_url() ?>index.php/admin/varios/habilidades/" onmouseover="tip('Regresa al listado de<br />indicadores')" onmouseout="cierra_tip()"><img src="<?=base_url() ?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url() ?>index.php/admin/varios/habilidades/" onmouseover="tip('Regresa al listado de<br />no conformidades')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>                
    	</div>
	</div>
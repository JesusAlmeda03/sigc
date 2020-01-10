<?php
/****************************************************************************************************
 *
 *	VIEWS/admin/varios/agregar_indicador.php
 *
 *		Descripción:
 *			Vista que muestra los indicadores
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
if($Area -> num_rows() > 0){
	foreach($Area->result() as $area){

	}
}
?>

	<div class="cont_admin">
		<div class="titulo"><?=$titulo.' para: '.$area->Area;?></div>
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
				'indicador' => array (
					'name'		=> 'indicador',
					'id'		=> 'indicador',
					
					'onfocus'	=> "hover('indicador')",
					'style'		=> 'height:50px',
				),
				// Meta
				'meta' => array (
					'name'		=> 'meta',
					'id'		=> 'meta',
					
					'class'		=> 'in_text',
					'onfocus'	=> "hover('meta')",
				),
				// Calculo
				'calculo' => array (
					'name'		=> 'calculo',
					'id'		=> 'calculo',
					
					'onfocus'	=> "hover('calculo')",
					'style'		=> 'height:50px',						
				),
				// Frecuencia
				'frecuencia' => array (
					'name'		=> 'frecuencia',
					'id'		=> 'frecuencia',
					
					'class'		=> 'in_text',
					'onfocus'	=> "hover('frecuencia')",
				),
				// Responsable
				'responsable' => array (
					'name'		=> 'responsable',
					'id'		=> 'responsable',
				
					'class'		=> 'in_text',
					'onfocus'	=> "hover('responsable')",
				),
				// Observaciones
				'observaciones' => array (
					'name'		=> 'observaciones',
					'id'		=> 'observaciones',
					
					'onfocus'	=> "hover('observaciones')",
					'style'		=> 'height:50px',						
				)
			);
            ?>	          
			<?php 
			// Formulario de modificacion del indicador
			echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
			echo '<table width="980" class="tabla_form">';
			echo '<tr><th class="text_form" width="70" valign="top" style="padding-top:10px;">Indicador</th><td>'.form_textarea($formulario['indicador']).'</td></tr>';
			echo '<tr><th class="text_form">Meta</th><td>'.form_input($formulario['meta']).'</td></tr>';
			echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Calculo</th><td>'.form_textarea($formulario['calculo']).'</td></tr>';
			echo '<tr><th class="text_form">Frecuencia</th><td>'.form_input($formulario['frecuencia']).'</td></tr>';
			echo '<tr><th class="text_form">Responsable</th><td>'.form_input($formulario['responsable']).'</td></tr>';
			echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Observaciones</th><td>'.form_textarea($formulario['observaciones']).'</td></tr>';
			echo '</table><br />';
			echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').form_button($formulario['boton_cancelar'],'Cancelar').'</div>';
			echo form_close();
			
			// Listado de mediciones
			echo '<br /><br />';
           
            ?>
            <br />
            <table><tr><td><a href="<?=base_url() ?>index.php/admin/varios/indicadores/" onmouseover="tip('Regresa al listado de<br />indicadores')" onmouseout="cierra_tip()"><img src="<?=base_url() ?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url() ?>index.php/admin/varios/indicadores/" onmouseover="tip('Regresa al listado de<br />no conformidades')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>                
    	</div>
	</div>
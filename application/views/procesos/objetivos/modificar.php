<?php
/****************************************************************************************************
*
*	VIEWS/procesos/indicadores/modificar.php
*
*		Descripci�n:
*			Vista para modificar la informaci�n de un indicador
*
*		Fecha de Creaci�n:
*			16/Noviembre/2011
*
*		Ultima actualizaci�n:
*			16/Noviembre/2011
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
			<div class="titulo"><?=$titulo?></div>
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
						'onclick'	=> 'location.href=\''.base_url().'index.php/procesos/objetivos/grafica/'.$id.'/todos\'',
					),
					// Indicador
					'indicador' => array (
						'name'		=> 'indicador',
						'id'		=> 'indicador',
						'value'		=> $ind,
						'onfocus'	=> "hover('indicador')",
						'style'		=> 'height:50px',
					),
					// Meta
					'meta' => array (
						'name'		=> 'meta',
						'id'		=> 'meta',
						'value'		=> $met,
						'class'		=> 'in_text',
						'onfocus'	=> "hover('meta')",
					),
					// Calculo
					'calculo' => array (
						'name'		=> 'calculo',
						'id'		=> 'calculo',
						'value'		=> $cal,
						'onfocus'	=> "hover('calculo')",
						'style'		=> 'height:50px',						
					),
					// Frecuencia
					'frecuencia' => array (
						'name'		=> 'frecuencia',
						'id'		=> 'frecuencia',
						'value'		=> $fre,
						'class'		=> 'in_text',
						'onfocus'	=> "hover('frecuencia')",
					),
					// Observaciones
					'observaciones' => array (
						'name'		=> 'observaciones',
						'id'		=> 'observaciones',
						'value'		=> $obs,
						'onfocus'	=> "hover('observaciones')",
						'style'		=> 'height:50px',						
					)
				);
                ?>	          
				<?php 
				// Formulario de modificacion del indicador
				echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table width="700" class="tabla_form">';
				echo '<tr><th class="text_form" style="font-size:16px; text-align:center; font-weight:normal" colspan="2">'.$obj.'</th></tr>';
				echo '<tr><th class="text_form" width="70" valign="top" style="padding-top:10px;">Indicador</th><td>'.form_textarea($formulario['indicador']).'</td></tr>';
				echo '<tr><th class="text_form">Meta</th><td>'.form_input($formulario['meta']).'</td></tr>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Calculo</th><td>'.form_textarea($formulario['calculo']).'</td></tr>';
				echo '<tr><th class="text_form">Frecuencia</th><td>'.form_input($formulario['frecuencia']).'</td></tr>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Observaciones</th><td>'.form_textarea($formulario['observaciones']).'</td></tr>';
				echo '</table><br />';
				echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').form_button($formulario['boton_cancelar'],'Cancelar').'</div>';
				echo form_close();				
                ?>
        	</div>
    	</div>
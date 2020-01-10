<?php
/****************************************************************************************************
*
*	VIEWS/admin/varios/noticias.php
*
*		Descripción:
*			Vista que muestra y agrega noticias
*
*		Fecha de Creación:
*			2/Febrero/2012
*
*		Ultima actualización:
*			2/Febrero/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
?>
    <div class="cont_admin">
    	<div class="titulo"><?=$titulo?></div>
        <div class="text">
			<script>
			$(function() {
                $( "#fecha" ).datepicker({
					changeMonth: true,
					changeYear: true,
				});
				$('#fecha').datepicker($.datepicker.regional['es']);
				$('#fecha').datepicker('option', {dateFormat: 'yy-mm-d'});
				$("#startDate").datepicker({dateFormat: 'yy-mm-dd'});
			});
            </script>
			<?php 
			$formulario = array(
				// * Boton submit
				'boton' => array (
					'id'		=> 'modificar',
					'name'		=> 'modificar',
					'class'		=> 'in_button',
					'onfocus'	=> 'hover(\'modificar\')'
				),
				// Fecha
				'fecha' => array (
					'name'		=> 'fecha',
					'id'		=> 'fecha',
					'value'		=> set_value('fecha'),
					'class'		=> 'in_text',
					'onfocus'	=> "hover('fecha')",
					'style'		=> 'width:200px'

				),
				// Resumen
				'resumen' => array (					
					'name'		=> 'resumen',
					'id'		=> 'resumen',
					'class' 	=> 'in_text',
					'value'		=> set_value('resumen'),
					'onfocus'	=> "hover('resumen')",
				),
				// Noticia
				'noticia' => array (
					'name'		=> 'noticia',
					'id'		=> 'noticia',
					'value'		=> set_value('noticia'),
					'onfocus'	=> "hover('noticia')",
					'style'		=> "height:300px",
				)
			);
			echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
			echo '<table class="tabla_form" width="950">';
			echo '<tr><th class="text_form" style="text-align:left">Fecha: </th></tr>';
			echo '<tr><td>'.form_input($formulario['fecha']).'</td></tr>';
			echo '<tr><th class="text_form" style="text-align:left">Resumen: <br /><span style="font-size:11px">El <label style="font-style:italic">Resumen</label> es el que aparece en la p&aacute;gina principal del sistema, debe ser corto y sencillo.</span></th></tr>';
			echo '<tr><td>'.form_input($formulario['resumen']).'</td></tr>';
			echo '<tr><th class="text_form" valign="top" style="padding-top:10px; text-align:left">Noticia: <br /><span style="font-size:11px">Si deseas agregar mas informaci&oacute;n lo puedes hacer en el siguiente recuadro, este texto no aparecer&aacute; en la p&aacute;gina principal pero ser&aacute; ligado atravez del resumen.<br /><br />Si no hay necesidad de agregar mas texto a la noticia es recomndable dejarlo en blanco.</span></th></tr>';
			echo '<tr><td>'.form_textarea($formulario['noticia']).'</td></tr>';
			echo '</table><br />';
			echo '<div style="width:950px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
			echo form_close();
            ?>
            <br /><br />
			<table><tr><td><a href="<?=base_url() ?>index.php/admin/varios/noticias" onmouseover="tip('Regresa al listado de<br />noticias')" onmouseout="cierra_tip()"><img src="<?=base_url() ?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url() ?>index.php/admin/varios/noticias" onmouseover="tip('Regresa al listado de<br />noticias')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
        </div>
    </div>
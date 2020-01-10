<?php
/****************************************************************************************************
*
*	VIEWS/admin/varios/noticias_modificar.php
*
*		Descripción:
*			Vista que modifica una noticia
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
				$('#fecha').datepicker('option', {dateFormat: 'yy-mm-dd'});
				var queryDate = '<?=$fec?>',
				dateParts = queryDate.match(/(\d+)/g)
				realDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
				$('#fecha').datepicker('setDate', realDate);
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
				// * Boton submit
				'boton_cancelar' => array (
					'id'		=> 'cancelar',
					'name'		=> 'cancelar',
					'class'		=> 'in_button',
					'onfocus'	=> 'hover(\'cancelar\')',
					'style'		=> 'width:120px; height:45px; font-size:16px; letter-spacing:3px; margin-left:10px',
					'onclick'	=> 'location.href=\''.base_url().'index.php/admin/varios/noticias\'',
				),
				// Fecha
				'fecha' => array (
					'name'		=> 'fecha',
					'id'		=> 'fecha',
					'value'		=> $fec,
					'class'		=> 'in_text',
					'onfocus'	=> "hover('fecha')",
					'style'		=> 'width:200px'

				),
				// Resumen
				'resumen' => array (					
					'name'		=> 'resumen',
					'id'		=> 'resumen',
					'class' 	=> 'in_text',
					'value'		=> $res,
					'onfocus'	=> "hover('resumen')",
				),
				// Noticia
				'noticia' => array (
					'name'		=> 'noticia',
					'id'		=> 'noticia',
					'value'		=> $not,
					'onfocus'	=> "hover('noticia')",
					'style'		=> "height:300px",
				)
			);
			echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
			echo '<table class="tabla_form" width="980">';
			echo '<tr><th class="text_form" style="text-align:left">Fecha: </th></tr>';
			echo '<tr><td>'.form_input($formulario['fecha']).'</td></tr>';
			echo '<tr><th class="text_form" style="text-align:left">Resumen: <br /><span style="font-size:11px">El <label style="font-style:italic">Resumen</label> es el que aparece en la p&aacute;gina principal del sistema, debe ser corto y sencillo.</span></th></tr>';
			echo '<tr><td>'.form_input($formulario['resumen']).'</td></tr>';
			echo '<tr><th class="text_form" valign="top" style="padding-top:10px; text-align:left">Noticia: <br /><span style="font-size:11px">Si deseas agregar mas informaci&oacute;n lo puedes hacer en el siguiente recuadro, este texto no aparecer&aacute; en la p&aacute;gina principal pero ser&aacute; ligado atravez del resumen.<br /><br />Si no hay necesidad de agregar mas texto a la noticia es recomndable dejarlo en blanco.</span></th></tr>';
			echo '<tr><td>'.form_textarea($formulario['noticia']).'</td></tr>';
			echo '</table><br />';
			echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Modificar').form_button($formulario['boton_cancelar'],'Cancelar').'</div>';
			echo form_close();
            ?>
        </div>
    </div>
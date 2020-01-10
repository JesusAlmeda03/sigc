<?php
/****************************************************************************************************
*
*	VIEWS/admin/aduditorias/generar_anual.php
*
*		Descripción:
*			Vista para generar el programa anual de auditorías
*
*		Fecha de Creación:
*			23/Octubre/2012
*
*		Ultima actualizaciÓn:
*			23/Octubre/2012
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
        <div class="texto">
        	<script>
			$(function() {
				// Inicio
                $( "#inicio" ).datepicker({
                    changeMonth: true,
                    changeYear: true,
                });
                $('#inicio').datepicker($.datepicker.regional['es']);
                $('#inicio').datepicker('option', {dateFormat: 'yy-mm-d'});
                $("#startDate").datepicker({dateFormat: 'yy-mm-dd'});
                // Termino
                $( "#termino" ).datepicker({
                    changeMonth: true,
                    changeYear: true,
                });
                $('#termino').datepicker($.datepicker.regional['es']);
                $('#termino').datepicker('option', {dateFormat: 'yy-mm-d'});
                $("#startDate").datepicker({dateFormat: 'yy-mm-dd'});
            });
            </script>
			<?php
			// Auditorias
			$auditoria_extras = 'id="auditoria" onfocus="hover(\'auditoria\')" style="width:200px"';
			$auditorias = array(
				'SIGC'	 			=> 'Interna SIGC',
				'Certificación'		=> 'Certificaci&oacute;n',
				'1° Seguimiento'	=> '1° Seguimiento',
				'2° Seguimiento'	=> '2° Seguimiento',
				'Recertificación'	=> 'Recertificaci&oacute;n',
			);
			
            $formulario = array(
                // * Boton submit
                'boton' => array (
                    'id'		=> 'aceptar',
                    'name'		=> 'aceptar',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'aceptar\')'
                ),
                // Año
                'ano' => array (
                    'name'		=> 'ano',
                    'id'		=> 'ano',
                    'value'		=> set_value('ano'),
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('ano')",
                    'style'		=> 'width:100px',
                ),
                // Inicio de la Auditoría
                'inicio' => array (
                    'name'		=> 'inicio',
                    'id'		=> 'inicio',
                    'value'		=> set_value('inicio'),
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('inicio')",
                    'style'		=> 'width:100px',
                ),
                // Termino de la Auditoría
                'termino' => array (
                    'name'		=> 'termino',
                    'id'		=> 'termino',
                    'value'		=> set_value('termino'),
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('termino')",
                    'style'		=> 'width:100px',
                ),
            );
            echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
            echo '<table class="tabla_form" width="980">';
            echo '<tr><th class="text_form" width="250">Auditor&iacute;a: </th>';
            echo '<td>'.form_dropdown('auditoria',$auditorias,set_value('auditoria'),$auditoria_extras).'</td></tr>';
			echo '<tr><th class="text_form">A&ntilde;o: </th>';
            echo '<td>'.form_input($formulario['ano']).'</td></tr>';
            echo '<tr><th class="text_form">Periodo de la Auditor&iacute;a: </th>';
            echo '<td>del '.form_input($formulario['inicio']).' al '.form_input($formulario['termino']).'</td></tr>';
            echo '</table><br />';
            echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
            echo form_close();
            ?>
        </div>
    </div>
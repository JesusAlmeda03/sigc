<?php
/****************************************************************************************************
*
*	VIEWS/admin/aduditorias/modificar_auditoria.php
*
*		Descripción:
*			Vista para modificar una auditoría
*
*		Fecha de Creación:
*			8/Noviembre/2012
*
*		Ultima actualizaciÓn:
*			8/Noviembre/2012
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
                var queryDate = '<?=$inicio?>',
				dateParts = queryDate.match(/(\d+)/g)
				realDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                $('#inicio').datepicker('setDate', realDate);
                
                // Termino
                $( "#termino" ).datepicker({
                    changeMonth: true,
                    changeYear: true,
                });
                $('#termino').datepicker($.datepicker.regional['es']);
                $('#termino').datepicker('option', {dateFormat: 'yy-mm-d'});
                var queryDate = '<?=$termino?>',
				dateParts = queryDate.match(/(\d+)/g)
				realDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                $('#termino').datepicker('setDate', realDate);
            });
            </script>
			<?php
			// Auditorias
			$auditoria_extras = 'id="auditoria" onfocus="hover(\'auditoria\')" style="width:200px"';
			$auditorias = array(
				'SIGC'	 => 'Interna SIGC',
				'SIBIB'	 => 'Interna SIBIB'
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
                    'value'		=> $ano,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('ano')",
                    'style'		=> 'width:100px',
                ),
                // Inicio
                'inicio' => array (
                    'name'		=> 'inicio',
                    'id'		=> 'inicio',
                    'value'		=> $inicio,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('inicio')",
                    'style'		=> 'width:100px',
                ),
                // Termino
                'termino' => array (
                    'name'		=> 'termino',
                    'id'		=> 'termino',
                    'value'		=> $termino,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('termino')",
                    'style'		=> 'width:100px',
                ),
            );
            echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
            echo '<table class="tabla_form" width="980">';
            echo '<tr><th class="text_form" width="250">Auditor&iacute;a: </th>';
            echo '<td>'.form_dropdown('auditoria',$auditorias,$auditoria,$auditoria_extras).'</td></tr>';
			echo '<tr><th class="text_form">A&ntilde;o: </th>';
            echo '<td>'.form_input($formulario['ano']).'</td></tr>';
            echo '<tr><th class="text_form">Periodo de la Auditor&iacute;a: </th>';
            echo '<td>del '.form_input($formulario['inicio']).' al '.form_input($formulario['termino']).'</td></tr>';
            echo '</table><br />';
            echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Modificar').'</div>';
            echo form_close();
			
			echo '<br /><br />';
			echo '<table><tr><td><a href="'.base_url().'index.php/admin/auditorias/programa_especifico/'.$ano.'/'.$auditoria.'/'.$estado.'" onmouseover="tip(\'Regresa al Programa Anual de Auditor&iacute;as\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="'.base_url().'index.php/admin/auditorias/programa_especifico/'.$ano.'/'.$auditoria.'/'.$estado.'" onmouseover="tip(\'Regresa al Programa Anual de Auditor&iacute;as\')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>';
            ?>
        </div>
    </div>
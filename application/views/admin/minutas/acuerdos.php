<?php
/****************************************************************************************************
*
*	VIEWS/admin/minutas/acuerdos.php
*
*	Descripción:
*		Acuerdos de la reunión pasada y acuerdos de la reunión actual
*
*	Fecha de Creación:
*		8/Marzo/2012
*
*	Ultima actualización:
*		8/Marzo/2012
*
*	Autor:
*		ISC Rogelio Castañeda Andrade
*		HERE (http://www.webHERE.com.mx)
*		rogeliocas@gmail.com
*
****************************************************************************************************/
?>
    <div class="cont" style="width:970px;">
    	<div class="title"><?=$titulo?><br /><span style="font-size: 14px;"><?=$minuta?></span></div>
        <div class="text">        	
        	<?php
            $formulario = array(
                // * Boton submit
                'boton' => array (
                    'id'		=> 'aceptar',
                    'name'		=> 'aceptar',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'aceptar\')'
                ),
                // * Boton cancelar
                'boton_cancelar' => array (
                    'id'		=> 'cancelar',
                    'name'		=> 'cancelar',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'cancelar\')',
                    'onclick'	=> 'location.href=\''.base_url().'index.php/admin_files/minutas/minutas_comite\'',
                    'style'		=> 'width:160px; height:55px; margin-left:10px',
                ),
                // Acuerdos Anteriores
                'acuerdos_anteriores' => array (
                    'name'		=> 'acuerdos_anteriores',
                    'id'		=> 'acuerdos_anteriores',
                    'value'		=> $acuerdos_anteriores,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('acuerdos_anteriores')",
                    'style'		=> 'height:300px',
                ),
                // Acuerdos
                'acuerdos' => array (
                    'name'		=> 'acuerdos',
                    'id'		=> 'acuerdos',
                    'value'		=> $acuerdos,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('acuerdos')",
                    'style'		=> 'height:300px',
                ),
            );
            echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
            echo '<table class="tabla_form" width="952">';
			echo '<tr><th class="text_form" width="80" valign="top">Acuerdos de la reuni&oacute;n pasada: <br /><br /></th>';
			echo '<td valign="top"><strong>'.$minuta_anterior.'</strong><br />'.form_textarea($formulario['acuerdos_anteriores']).'</td>';
            echo '<tr><th class="text_form" width="80" valign="top">Acuerdos de esta reuni&oacute;n: </th>';
			echo '<td>'.form_textarea($formulario['acuerdos']).'</td>';            
            echo '</table>';
            echo '<div style="width:952px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
            echo form_close();
			?>
			<br /><br />        	
        	<table><tr><td><a href="<?=base_url()?>index.php/admin/minutas/puntos/<?=$per?>/<?=$ano?>" onmouseover="ddrivetip('Regresa al listado de minutas')" onmouseout="hideddrivetip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/admin/minutas/puntos/<?=$per?>/<?=$ano?>" onmouseover="ddrivetip('Regresa al listado de minutas')" onmouseout="hideddrivetip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
        </div>
    </div><div class="btm_sh" style="width:982px; margin:0 0 5px 0"></div>
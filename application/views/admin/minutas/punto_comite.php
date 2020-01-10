<?php
/****************************************************************************************************
*
*	VIEWS/admin/minutas/punto_comite.php
*
*	Descripción:
*		Agrega / modifica información de un punto de la minuta del comité
*
*	Fecha de Creación:
*		24/Abril/2012
*
*	Ultima actualización:
*		24/Abril/2012
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
                // Punto
                'punto' => array (
                    'name'		=> 'punto',
                    'id'		=> 'punto',
                    'value'		=> $punto,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('punto')",
                    'style'		=> 'height:300px',
                ),
            );
            echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
            echo '<table class="tabla_form" width="952">';
            echo '<tr><th class="text_form" width="80" valign="top">'.$titulo.': </th>';
			echo '<td>'.form_textarea($formulario['punto']).'</td>';
            echo '</table>';
            echo '<div style="width:952px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
            echo form_close();
			?>
			<br /><br />
        	<table><tr><td><a href="<?=base_url()?>index.php/admin/minutas/puntos/<?=$per?>/<?=$ano?>" onmouseover="ddrivetip('Regresa al listado de minutas')" onmouseout="hideddrivetip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/admin/minutas/puntos/<?=$per?>/<?=$ano?>" onmouseover="ddrivetip('Regresa al listado de minutas')" onmouseout="hideddrivetip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>	
        </div>
    </div><div class="btm_sh" style="width:982px; margin:0 0 5px 0"></div>
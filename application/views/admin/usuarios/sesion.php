<?php
/****************************************************************************************************
*
*	VIEWS/admin/usuarios/sesion.php
*
*		Descripci�n:
*			Vista para entrar a un area espec�fica
*
*		Fecha de Creaci�n:
*			06/Noviembre/2011
*
*		Ultima actualizaci�n:
*			06/Noviembre/2011
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
			<?php	
            // Area		
            $area_extras = 'id="area" onfocus="hover(\'area\')" ';
            $formulario = array(
                // * Boton submit
                'boton' => array (
                    'id'		=> 'aceptar',
                    'name'		=> 'aceptar',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'aceptar\')'
                ),				
            );
            echo form_open('admin/usuarios/usuario_sesion',array('name' => 'formulario', 'id' => 'formulario', 'target' => '_blank'));
            echo '<table class="tabla_form" width="980">';
            echo '<tr><th class="text_form" width="100">Elige el &Aacute;rea: </th>';
            echo '<td>'.form_dropdown('area',$area_options,set_value('area'),$area_extras).'</td></tr>';
			echo '</table><br />';
			echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Al dar click en el boton aceptar se te redireccionara a la p&aacute;gina principal accediendo como usuario del &aacute;rea elegida. <br />Tendras todos los derechos especiales disponibles.</td></tr></table><br />';
            echo '<div style="width:952px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
            echo form_close();
            ?>
        </div>
    </div>
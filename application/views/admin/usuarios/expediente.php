<?php
/****************************************************************************************************
*
*	VIEWS/admin/usuarios/listado_expedientes.php
*
*		Descripción:
*			Vista que muestra todo el listado de los expedientes de los usuarios
*
*		Fecha de Creación:
*			23/Enero/2013
*
*		Ultima actualización:
*			23/Enero/2013
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
        	echo '<table class="tabla_form" width="980">';
			echo '<tr><th class="text_form" width="80">Usuario: </th>';
            echo '<td>'.$nombre_usuario.'</td></tr>';
			echo '</table><br />';
			
        	if( $usuario_expediente->num_rows() > 0 ) {
        		foreach( $usuario_expediente->result() as $row ) {
        			// obtiene la extensión del documento
					if( substr($row->Ruta,11) == "." ) { 
						$ext = substr($row->Ruta,12);
					}
					else {
						$doc = $row->Ruta;
						$j = 0;
						$k = 0;
						$i = strlen($doc) - 1;
						for ( $i; $i > 0 ; $i-- ) {
							if ( $doc[$i] == "." ){
								$j = $k;
								break;
							}
							$k++;
						}
						$ext = substr($doc,strlen($doc)-$j,$j);
						
						switch( $ext ) {
							case 'docx' : $ext = 'doc'; break;
							case 'xlsx' : $ext = 'xls'; break;
							case 'doc' : break;
							case 'xls' : break;
							case 'pdf' : break;
							default : $ext = 'archivo'; break;
						}
					}
					
					echo '<div style="display:inline-block; width:128px; height:138px; text-align:center; border:1px solid #CCC; padding:10px; margin:10px">';
					echo '	<a href="'.base_url().'includes/docs/expedientes/'.$row->Ruta.'" target="_blank" onmouseover="tip(\'Abrir archivo\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/big/'.$ext.'.png" /></a>';
					echo '  <br />'.$row->Fecha;
					echo '</div>';
        		}
        	}
			else {
                echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Este usuarios no tiene archivos en su expediente dentro de la página</td></tr></table>';
            }
        	?>
        	<br /><br />
			<table><tr><td><a href="<?=base_url()?>index.php/admin/usuarios/<?=$uri?>" onmouseover="tip('Regresa al listado<br />de usuarios')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/admin/usuarios/<?=$uri?>" onmouseover="tip('Regresa al listado<br />de usuarios')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
        </div>
    </div>
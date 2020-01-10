<?php
/****************************************************************************************************
*
*	VIEWS/admin/_estructura/paginas.php
*
*		Descripción:
*			Vista para el control de las páginas
*
*		Fecha de Creación:
*			11/Octubre/2011
*
*		Ultima actualización:
*			11/Octubre/2011
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
	
	$re = base_url().'index.php/'.$controlador;

        echo '<table class="paginas"><tr>';
        if( $pagina != 1 ) {
            echo '<td><a href="'.$re.'1" onMouseover="ddrivetip(\'Primera\')"; onMouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/paginas/first.png" /></a></td>';
            echo '<td><a href="'.$re.( $pagina - 1 ).'" onMouseover="ddrivetip(\'Anterior\')"; onMouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/paginas/prev.png" /></a></td>';
        }
		for( $i = 1; $i <= $num; $i++ ) {
			if ( $pagina == $i )
		        echo '<td class="pag_selec"><a href="'.$re.$i.'" class="a2">'.$i.'</a></td>';
			else
		        echo '<td><a href="'.$re.$i.'" class="a2">'.$i.'</a></td>';
		}
        if( $num != $pagina ) {
            echo '<td><a href="'.$re.( $pagina + 1).'" onMouseover="ddrivetip(\'Siguiente\')"; onMouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/paginas/next.png" /></a></td>';
            echo '<td><a href="'.$re.$num.'" onMouseover="ddrivetip(\'Ultima\')"; onMouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/paginas/last.png" /></a></td>';
        }
        echo '</tr></table>';
		?>
    </div>
</div><div class="btm_sh" style="width:982px; margin:0 0 5px 0"></div>
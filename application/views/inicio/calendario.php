<?php
/****************************************************************************************************
*
*	VIEWS/misc/calendario.php
*
*		Descripci�n:  		  
*			Vista del candelario
*
*		Fecha de Creaci�n:
*			11/Octubre/2011
*
*		Ultima actualizaci�n:
*			11/Octubre/2011
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
$m_next = $m + 1;
$a_next = $ano;
if( $m_next == 13 ){
	$m_next = 1;
	$a_next = $ano + 1;
}
$next = $m_next.'/'.$a_next;

$m_prev = $m - 1;
$a_prev = $ano;
if( $m_prev == 0 ){
	$m_prev = 12;
	$a_prev = $ano - 1;
}
$prev = $m_prev.'/'.$a_prev;
?>
	<div class="content">		
		<div class="cont">
			<div class="titulo">
				<?php
				echo 'Calendario<br />';
				echo ' <span style="font-size:18px">'.$mes.' '.$ano.'</span>';
				?>
			</div>
            <div class="texto">
				<?=$calendario?>
                <table class="paginas">
                    <tr>
                        <td><a href="<?=base_url()?>index.php/inicio/calendario/<?php echo $prev; ?>"><img src="<?=base_url()?>includes/img/paginas/prev.png" /></a></td>
                        <td style="text-align:center"><a href="<?=base_url()?>index.php/inicio/calendario/<?php echo date('m')."/".date('Y'); ?>">Mes Actual</a></td>
                        <td><a href="<?=base_url()?>index.php/inicio/calendario/<?php echo $next; ?>"><img src="<?=base_url()?>includes/img/paginas/next.png" /></a></td>
                    </tr>
                </table>
			</div>
		</div>
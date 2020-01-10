<?php
/****************************************************************************************************
*
*	VIEWS/inicio/noticias.php
*
*		Descripci�n:  		  
*			Vista del listado de las noticias del sistema
*
*		Fecha de Creaci�n:
*			11/Octubre/2011
*
*		Ultima actualizaci�n:
*			11/Octubre/2011
*
*		Autor:
*			ISC Rogelio Casta�eda Andrade
*			HERE (http://www.webHERE.com.mx)
*			rogeliocas@gmail.com
*
****************************************************************************************************/
?>
	<div class="content">		
		<div class="cont">
			<div class="titulo">Noticias</div>
            <div class="texto">
				<?php
                if( $consulta->num_rows() > 0 ) {
                    foreach( $consulta->result() as $row ) :
						echo '<div class="noticia">';
                        echo '<div class="noticia_fecha">';
						switch( substr( $row->Fecha, 5, 2 ) ) {
							case "01" : $mes = "Enero"; break;
							case "02" : $mes = "Febrero"; break;
							case "03" : $mes = "Marzo"; break;
							case "04" : $mes = "Abril"; break;
							case "05" : $mes = "Mayo"; break;
							case "06" : $mes = "Junio"; break;
							case "07" : $mes = "Julio"; break;
							case "08" : $mes = "Agosto"; break;
							case "09" : $mes = "Septiembre"; break;
							case "10" : $mes = "Octubre"; break;
							case "11" : $mes = "Noviembre"; break;
							case "12" : $mes = "Diciembre"; break;					
						}						
						echo substr( $row->Fecha, 8, 2 )." / ".$mes." / ".substr( $row->Fecha, 0, 4 );
                        echo '</div><br />';
						if( $row->Noticia == "" )
                        	echo $row->Resumen;
						else
							echo $row->Noticia;
						echo '</div>';
                    endforeach;
					if( $consulta->num_rows() == 1 ) {
						echo '<div style="width:672px; text-align:center">';
						echo '<a style="margin-right:20px" href="'.base_url().'index.php/inicio/" onMouseover="tip(\'Ir al inicio\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/home.png" /></a>';
						echo '<a href="'.base_url().'index.php/inicio/noticias/1" onMouseover="tip(\'Ver todas las Noticias\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/news.png" /></a>';
						echo '</div>';
					}
                }
                else {
                    echo '<table class="tabla" width="672"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay noticias</td></tr></table>';
                }
                ?>
            </div>
		</div>
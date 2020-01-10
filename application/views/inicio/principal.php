<?php
/****************************************************************************************************
*
*	VIEWS/inicio/principal.php
*
*		Descripción:
*			Inicio del sistema
*
*		Fecha de Creación:
*			06/Octubre/2011
*
*		Ultima actualización:
*			09/Julio/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
?>
	<div class="content">
		<div class="cont">
			<div class="texto" style="padding:0">
				<script type="text/javascript" src="<?=base_url()?>includes/js/slider/easySlider1.7.js"></script>
				<script type="text/javascript" src="<?=base_url()?>includes/js/brwsniff.js"></script>
				<script>
				$(document).ready(function(){
					$("#slider").easySlider({
						auto: true,
						continuous: true
					});
				});
				</script>
				<table style="width:700px; height:300px; overflow:hidden; z-index: 1; font-size: 20px; position: relative; border:1px solid #EEEEEE; margin-bottom: 5px;">

					<tr>
						<td style="padding:5px 10px; text-align:center">
				        	<?php
				            if( $noticias->num_rows() > 0 ) {
				               	echo '<div id="slider"><ul>';
				                foreach( $noticias->result() as $row ) :
				                    echo '<li>';
									echo $row->Resumen;
									if( $row->Noticia != "" )
										echo ' <a href="'.base_url()."index.php/inicio/noticia/".$row->IdNoticia.'"><br />Leer noticia completa</a>';
									echo '</li>';
				                endforeach;
				               	echo '</ul></div>';
				            }
				            else {
				                echo '<div id="slider"><ul><li>&iexcl; Bienvenido a la p&aacute;gina del Sistema Integral de Gesti&oacute;n de Calidad UJED !</li></ul></div>';
				            }
							?>
						</td>
					</tr>
				</table>


				<link rel="stylesheet" type="text/css" href="<?=base_url()?>includes/css/innerfade.css" />
				<script type="text/javascript" src="<?=base_url()?>includes/js/innerfade/jquery.innerfade.js"></script>
				<script type="text/javascript" src="<?=base_url()?>includes/js/innerfade/config.js"></script>

				<div id="innerfade-holder" class="container_16" style="margin-left:-10px; height: 900px;">
				    <div id="slider" class="grid_16">
				        <div class="grid_10 alpha">
				          <ul id="imagenes">
				            <li style="border:1px solid #EEE"><img src="<?=base_url()?>includes/img/pix/53494.png" width="710px" /></li>
										<li style="border:1px solid #EEE"><img src="<?=base_url()?>includes/img/pix/53492.png" width="710px" /></li>
										<li style="border:1px solid #EEE"><img src="<?=base_url()?>includes/img/pix/49604.png" width="710px" /></li>
										<li style="border:1px solid #EEE"><img src="<?=base_url()?>includes/img/pix/49601.png" width="710px" /></li>
										<li style="border:1px solid #EEE"><img src="<?=base_url()?>includes/img/pix/44393.png" width="710px" /></li>
										<li style="border:1px solid #EEE"><img src="<?=base_url()?>includes/img/pix/44392.png" width="710px" /></li>

				          </ul>

				          <ul id="slide_nav">
				            <li class="slide_0" style="margin-left:280px; top: 1500px;"></li>
										<li class="slide_1"></li>
										<li class="slide_2"></li>
										<li class="slide_3"></li>
										<li class="slide_4"></li>
										<li class="slide_5"></li>

				          </ul>
				        </div>
				        <!--<div style="width:700px; height:30px; background-color:#FFF; z-index:100; top:520px; position:absolute; opacity: 0.5;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity: 0.5;"></div>-->
				    </div>
				</div>

				<div style="clear:both"></div>
			</div>
		</div>

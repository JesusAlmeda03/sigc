<?php
/****************************************************************************************************
*
*	VIEWS/_estructura/top.php
*
*		Descripción:
*			Top del sistema
*
*		Fecha de Creación:
*			29/Septiembre/2011
*
*		Ultima actualización:
*			09/Juluio/2011
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
?>

	<body>
		<div id="dhtmltooltip"></div>
		<!-- tooltip -->
		<script type="text/javascript" src="<?=base_url()?>includes/js/tooltip.js"></script>
		<div class="wrapper">
	        <div class="banner">
	        	<table style="width:955px; margin:auto; padding-top:5px;">
	        		<tr>
	        			<td width="68">
	        				<div style="width:40px; height:40px; background-color:#FFF; border:1px solid #EEE; margin-left:8px; padding:5px;">
	        					<img src="<?=base_url()?>includes/img/sigc.png" />
	        				</div>
	        			</td>
	        			<td valign="middle">
							<div id="nombre_titulo" style="font-size:42px; color:#FFF; padding-top:5px">
		               			SISTEMA INTEGRAL DE GESTI&Oacute;N DE CALIDAD UJED
		               		</div>
	        			</td>
	        		</tr>
	        	</table>
	        </div>
	        <div class="menu">
				<div style="width:980px; margin:auto; z-index: 10;">
					<?php
					// obtiene la uri para saber en donde se encuentra
					$uri 	= $this->uri->segment(1);
					$flecha = 'style="background:url('.base_url().'includes/img/arrow.png) no-repeat top center;"';

				// SECCIONES MENU
					// si ya esta logueado muestra las sub-secciones
					if ( $this->session->userdata( 'id_usuario' ) ) {
						// Listados
						$listados = array (
							'listados/quejas'					=> 'Quejas',
							'listados/conformidades'			=> 'No Conformidades',
							'listados/minutas'					=> 'Minutas',
							'listados/solicitudes'				=> 'Solicitudes',
							'listados/capacitacion'				=> 'Cursos de Capacitación',
						);

						// Procesos Automatizados
						$procesos = array (
							'procesos/indicadores'				=> 'Indicadores',
							'procesos/objetivos'				=> 'Objetivos de Calidad',
							'procesos/quejas'					=> 'Quejas',
							'procesos/conformidades'			=> 'No Conformidades',
						);

				// SECCIONES CON PERMISOS DE USUARIO
						// Minutas
						if( $this->session->userdata('MIN') ) {
							$procesos['procesos/minutas'] = 'Minutas';
						}
						// Mantenimiento
						if( $this->session->userdata('MAN') ) {
							$mantenimiento = array (
							'procesos/mantenimiento'				=> 'Agendar Mantenimiento',
							'procesos/agregar'						=> 'Agregar Evidencia',

						);
						}

						//Evaluaciones

						if($this->session->userdata('id_area') == 9){

							$evaluaciones = array (
                                                        'evaluaciones/clima'                            => 'Clima Laboral',
                                                        'evaluaciones/desempeno'                        => 'Desempe&ntilde;o',
                                                        //'evaluaciones/satisfaccion'                   => 'Historico Satisfacci&oacute;n dec Usuarios SIGC',
                                                        //'evaluaciones/nueva_satisfaccion'     => 'Nueva Encuesta de Satisfacci&oacute;n de Usuarios SIGC',
                                                        'evaluaciones/nueva_satisfaccion_sibib' => 'Nueva Encuesta de Satisfacci&oacute;n de Usuarios SIBIB',
                                                        //'evaluaciones/satisfaccion_sibib'     => 'Historico Satisfacci&oacute;n de Usuarios SIBIB',

                                                );
						}else{
							$evaluaciones = array (
							'evaluaciones/clima'				=> 'Clima Laboral',
							'evaluaciones/desempeno'			=> 'Desempe&ntilde;o',
							'evaluaciones/nueva_satisfaccion'	=> 'Nueva Encuesta de Satisfacci&oacute;n de Usuarios SIGC',
							//'evaluaciones/satisfaccion'			=> 'Historico Satisfacci&oacute;n dec Usuarios SIGC',
							//'evaluaciones/nueva_satisfaccion'	=> 'Nueva Encuesta de Satisfacci&oacute;n de Usuarios SIGC',
							//'evaluaciones/satisfaccion_sibib'	=> 'Historico Satisfacci&oacute;n de Usuarios SIBIB',

						);}


				// MENU
						echo '<ul class="sf-menu">';

						// Inicio
						echo '<li><a href="'.base_url().'" class="menu_item">Inicio</a></li>';

						// Identidad
						echo '<li><a href="#" class="menu_item"';
						if( $uri == 'identidad' )
							echo $flecha;
						echo '>Identidad</a>';
						if( $identidad->num_rows() > 0 && $this->session->userdata( 'id_usuario' ) ) {
							echo '<ul class="sub">';
							foreach( $identidad->result() as $row ) {
								echo '<li><a href="'.base_url().'index.php/identidad/texto/'.$row->IdIdentidad.'">'.$row->Titulo.'</a></li>';
							}
								echo '<li><a href="http://scalidad.ujed.mx/includes/alcance.pdf" target="_blank">Alcance y Aplicabilidad del SIGC</a></li>';
								echo '<li><a href="http://scalidad.ujed.mx/includes/alcance_sibib.pdf" target="_blank"> Alcance y Aplicabilidad del SIBIB</a></li>';
								echo '<li><a href="http://scalidad.ujed.mx/includes/alcance_isima.pdf" target="_blank"> Alcance y Aplicabilidad del ISIMA</a></li>';
							echo '</ul>';
						}
						echo '</li>';

						// Documentos
						echo '<li><a href="#" class="menu_item"';
						if( $uri == 'documentos' )
							echo $flecha;
						echo '>Documentos</a>';
						if( $this->session->userdata( 'id_usuario' ) ) {
							echo '<ul class="sub">';
							echo '<li><a href="#"><table><tr><td>Documentos de Uso Com&uacute;n</td><td style="padding-left:3px"><img src="'.base_url().'includes/img/arrow_right.png"></td></tr></table></a>';
							if( $secciones->num_rows() > 0 ) {
								echo '	<ul class="subsub">';
								// documentos de uso común
								foreach( $secciones->result() as $row ) {
									if( $row->Comun ) {
										echo '<li><a href="'.base_url().'index.php/documentos/comun/'.$row->IdSeccion.'">'.$row->Seccion.'</a></li>';
									}
									
								}
								echo '<li><a href="'.base_url().'index.php/documentos/resumen/63/">Expediente de Adutorias</a></li>';
								echo '	</ul>';
								echo '</li>';
								// documentos por áreas
								foreach( $secciones->result() as $row ) {
									if( !$row->Comun ) {
										echo '<li><a href="'.base_url().'index.php/documentos/area/'.$row->IdSeccion.'">'.$row->Seccion.'</a></li>';
									}
								}
							}
							echo '</ul>';
						}
						echo '</li>';

						// Listados
						echo '<li><a href="#" class="menu_item"';
						if( $uri == 'listados' )
							echo $flecha;
						echo '>Listados</a><ul class="sub">';
						$i = 0;
						foreach ( $listados as $enlace => $titulo ) {
							if( !$i ) {
								echo '<li><a href="'.base_url().'index.php/'.$enlace.'">';
								$i++;
							}
							else {
								echo '<li><a href="'.base_url().'index.php/'.$enlace.'">';
							}
							echo $titulo.'</a></li>';
						}
						echo '<li><a href="'.base_url().'index.php/manuales/inicio">Manuales de Usuario</a>';
						echo '</ul></li>';

						// Procesos Automatizados
						echo '<li><a href="#" class="menu_item" style="padding-top:10px"';
						if( $uri == 'procesos' )
							echo $flecha;
						echo '>Procesos<br />Automatizados</a><ul class="sub">';
						foreach ( $procesos as $enlace => $titulo ) {
							echo '<li><a href="'.base_url().'index.php/'.$enlace.'">'.$titulo.'</a></li>';
						}

						//Gestion de Riesgos
						echo '<li><a href="#"><table><tr><td width="180">Gestion de Riesgos</td><td style="padding-left:3px"><img src="'.base_url().'includes/img/arrow_right.png"></td></tr></table></a>';
						echo '	<ul class="subsub">';
						echo '		<li><a href="'.base_url().'index.php/procesos/gestion/index/'.$this->session->userdata('id_usuario').'">Listado de Evidencias</a></li>';
						if( $this->session->userdata('GR') ) {
							
							echo '		<li><a href="'.base_url().'index.php/procesos/gestion/nuevo/'.$this->session->userdata('id_usuario').'">Agregar Evidencia</a></li>';
						}						
						echo '	</ul></li>';

						// Capacitación
						echo '<li><a href="#"><table><tr><td width="180">Capacitación</td><td style="padding-left:3px"><img src="'.base_url().'includes/img/arrow_right.png"></td></tr></table></a>';
						echo '	<ul class="subsub">';
						if( $this->session->userdata('CAP') ) {
							echo '		<li><a href="'.base_url().'index.php/procesos/capacitacion/cursos">Cursos de Capacitación</a></li>';
							echo '		<li><a href="'.base_url().'index.php/procesos/capacitacion/cursos_propuestos">Cursos Propuestos</a></li>';
							echo '		<li><a href="'.base_url().'index.php/procesos/capacitacion/expediente_listado">Expedientes de Usuarios</a></li>';
							echo '		<li><a href="'.base_url().'index.php/procesos/capacitacion/autoevaluados">Usuarios Autoevaluados</a></li>';
							echo '		<li><a href="'.base_url().'index.php/procesos/capacitacion/calendario">Calendario Anual</a></li>';
						}
						//echo '		<li><a href="'.base_url().'index.php/procesos/capacitacion/cursos">Cursos DNC</a></li>';
						echo '		<li><a href="'.base_url().'index.php/procesos/capacitacion/expediente_revisar/'.$this->session->userdata('id_usuario').'">Expediente Personal</a></li>';
						echo '	</ul></li>';

						//mantenimiento
						echo '<li><a href="#"><table><tr><td width="180">Mantenimiento</td><td style="padding-left:3px"><img src="'.base_url().'includes/img/arrow_right.png"></td></tr></table></a>';
						echo '	<ul class="subsub">';
						if( $this->session->userdata('MAN') ) {
							echo '		<li><a href="'.base_url().'index.php/procesos/mantenimiento">Agendar Mantenimiento</a></li>';
							echo '		<li><a href="'.base_url().'index.php/procesos/mantenimiento/evidencia">Agregar Evidencias</a></li>';
							echo '		<li><a href="'.base_url().'index.php/procesos/mantenimiento/ver">Ver Evidencias</a></li>';

						}
						echo '	</ul></li>';
						// Controlador de Documentos
						if( $this->session->userdata('SOL') ) {
							echo '<li><a href="#"><table><tr><td>Solicitudes de Documentos</td><td style="padding-left:3px"><img src="'.base_url().'includes/img/arrow_right.png"></td></tr></table></a>';
							echo '	<ul class="subsub">';
							echo '		<li><a href="'.base_url().'index.php/procesos/solicitudes/alta">Alta</a></li>';
							echo '		<li><a href="'.base_url().'index.php/procesos/solicitudes/documento/baja">Baja</a></li>';
							echo '		<li><a href="'.base_url().'index.php/procesos/solicitudes/documento/modificacion">Modificaci&oacute;n</a></li>';
							echo '	</ul></li>';
						}
						//Encargado de Infraestructura
						echo '<li><a href="#"><table><tr><td>Infraestructura      </td><td style="padding-left:3px"><img src="'.base_url().'includes/img/arrow_right.png"></td></tr></table></a>';
							echo '	<ul class="subsub">';
							echo '		<li><a href="'.base_url().'index.php/procesos/infraestructura/reportes">Reportes</a></li>';
						if( $this->session->userdata('RI') ) {
							echo '		<li><a href="'.base_url().'index.php/procesos/infraestructura/registrar">Registrar</a></li>';

						}
							echo '	</ul></li>';
						echo '</ul></li>';

						// Evaluaciones
						echo '<li><a href="#" class="menu_item"';
						if( $uri == 'evaluaciones' )
							echo $flecha;
						echo '>Evaluaciones</a><ul class="sub">';
						foreach ( $evaluaciones as $enlace => $titulo ) {
							echo '<li><a href="'.base_url().'index.php/'.$enlace.'">'.$titulo.'</a></li>';
						}
						echo '</ul></li>';

						// Áreas Certificadas
						echo '<li><a href="'.base_url().'index.php/areas" class="menu_item" style="padding-top:10px"';
						if( $uri == 'areas' )
							echo $flecha;
						echo '>&Aacute;reas<br />Certificadas</a></li>';

						// Norma
						echo '<li><a href="#" class="menu_item">Normas</a>';
							echo "<ul class='sub'>";
								echo '<li class="menu_item" ><a href="'.base_url().'" target="_blank">En Revision</a></li>';
								/*echo '<li class="menu_item" ><a href="'.base_url().'includes/docs/norma_iso.pdf" target="_blank">Norma ISO 9001-2008</a></li>';
								echo '<li class="menu_item"><a href="'.base_url().'includes/docs/norma_iso19011-2011.pdf" target="_blank">Norma ISO 19011-2011</a></li>';
								echo '<li class="menu_item"><a href="'.base_url().'includes/docs/norma_iso9000_2005.pdf" target="_blank">Norma ISO 9000-2005</a></li>';*/
							echo "<ul>";
						echo '</li>';
						echo '</ul>';
					}
					// si no esta logueado no muestra las sub-secciones del menu
					else {
						$listados = array ();
						$procesos = array ();
						$evaluaciones = array ();
					}

					?>
				</div>
			</div>
			<div class="btm_sh" style="width:100%;"></div>

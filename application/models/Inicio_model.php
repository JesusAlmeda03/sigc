<?php
/****************************************************************************************************
*
*	MODELS/inicio_model.php
*
*		Descripción:
*			Modelo para interaccion con la bd desde el inicio
*
*		Fecha de Creación:
*			13/Febrero/2012
*
*		Ultima actualización:
*			10/Julio/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
class Inicio_model extends CI_Model {
/** Atributos **/
	private $secciones;
	private $identidad;
	private $usuario;
	private $sort_tabla;

/** Propiedades **/
	// get
	public function get_secciones() { return $this->secciones; }
	public function get_identidad() { return $this->identidad; }
	public function get_usuario() { return $this->usuario; }
	public function get_sort() { return $this->sort_tabla; }

	// set
	public function set_secciones() { $this->secciones = $this->get_info_secciones(); }
	public function set_identidad() { $this->identidad = $this->get_info_identidad(); }
	public function set_usuario() { $this->usuario = $this->get_info_usuario(); }
	public function set_sort( $reg ) { $this->sort_tabla = $this->get_info_sort( $reg ); }

/** Constructor **/
	function __construct() {
		parent::__construct();

		// Secciones de Documentos
		$this->set_secciones();

		// Secciones de Identidad
		$this->set_identidad();

		// Datos del Usuario
		$this->set_usuario();
	}

/** Funciones **/
	//
	// get_info_secciones(): Obtiene las secciones activas
	//
	function get_info_secciones() {
		switch( $this->session->userdata( 'id_sistema' ) ) {
			// SIGC
			case 1 :
				$this->db->where( '( IdSistema = 1 OR IdSistema = 3 ) AND Estado = 1' ); // sigc
				break;

			// SIBIB
			case 2 :
				$this->db->where( '( IdSistema = 2 OR IdSistema = 3 ) AND Estado = 1' ); // sigc
				break;

			// SBDC
			case 4 :
				$this->db->where( '( IdSistema = 1 OR IdSistema = 3 OR IdSistema = 4 ) AND Estado = 1' ); // sigc
				break;

			// FECA SBDC
			case 5 :
				$this->db->where( '( IdSistema = 1 OR IdSistema = 3 OR IdSistema = 5 ) AND Estado = 1' ); // sigc
				break;

			// default
			default :
				$this->db->where( '( IdSistema = 1 OR IdSistema = 3 ) AND Estado = 1' ); // sigc
				break;
		}
		$consulta = $this->db->get( 'bc_secciones' );

		return $consulta;
	}

	//
	// get_info_identidad(): Obtiene las secciones de identidad activas
	//
	function get_info_identidad() {
		$this->db->where( array( 'Estado' => '1', 'IdSistema' => '1' ) );
		$this->db->or_where( 'IdSistema', $this->session->userdata( 'id_sistema' ) );
		$consulta = $this->db->get( 'cd_identidad' );

		return $consulta;
	}

	//
	// get_info_usuario(): Obtiene la información del usuario
	//
	public function get_info_usuario() {
		$this->db->trans_start();
		$alerta = false;
		$th = '<table class="tabla"><tr><th style="width:20px; border-right:1px solid #CCC; background-color:#EAEAEA; text-align:center">';
		$th_alert = '<table class="tabla"><tr><th style="width:20px; border-right:1px solid #CCC; background-color: #CC0000; text-align:center">';
		$td = '<td style="width:240px; border:none">';
		$sep = '<div style="width:100%; height:1px; border-top:1px solid #F0F0F0"></div>';
		$usuario = '';

		// si esta logueado
		if( $this->session->userdata('id_usuario') ) {
			$usuario_alerta = $sep.'';

			// panel de administrador
			if( $this->session->userdata('admin') ) {
				$usuario .= $th.'<img src="'.base_url().'includes/img/icons/star_full.png" /></th>'.$td.'<a class="a2" href="'.base_url().'admin" target="_blank" onmouseover="tip(\'Ir al Panel de Administrador\')" onmouseout="cierra_tip()">Panel de Administrador</a></td></tr></table>'.$sep;
			}

			// área del usuario
			$usuario .= $th.'<img src="'.base_url().'includes/img/icons/small/area.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/inicio/area/" onmouseover="tip(\'&Aacute;rea Certificada a la cual perteneces\')" onmouseout="cierra_tip()">'.$this->session->userdata('area').'</a></td></tr></table>'.$sep;

			// datos del usuario
			$usuario .= $th.'<img src="'.base_url().'includes/img/icons/modificar.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/inicio/datos" onmouseover="tip(\'Modificad tus datos\')" onmouseout="cierra_tip()">Datos del Usuario</a></td></tr></table>'.$sep;

			// administración de usuarios
			if( $this->session->userdata('USU') ) {
				$usuario .= $th.'<img src="'.base_url().'includes/img/icons/users.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/inicio/administracion_usuarios" onmouseover="tip(\'Administra los usuarios de tu &Aacute;rea\')" onmouseout="cierra_tip()">Administraci&oacute;n de Usuarios</a></td></tr></table>'.$sep;
			}

			// auditor
			$this->db->from('au_equipos_usuarios');
			$this->db->where('au_equipos_usuarios.IdUsuario = '.$this->session->userdata('id_usuario').' AND au_auditorias.Estado = 1');
			$this->db->join('au_equipos','au_equipos.IdEquipo = au_equipos_usuarios.IdEquipo');
			$this->db->join('au_auditorias','au_auditorias.IdAuditoria = au_equipos.IdAuditoria');
			$consulta = $this->db->count_all_results();
			if( $consulta > 0 && $this->session->userdata('AUD') ) {
				$alerta = true;
				$usuario_alerta .= $th_alert.'<img src="'.base_url().'includes/img/icons/star_full.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/auditoria" onmouseover="tip(\'Administra los usuarios de tu &Aacute;rea\')" onmouseout="cierra_tip()">Actividades de Auditor</a></td></tr></table>'.$sep;
			}

			// listas maestra de documentos para los controladores
			if( $this->session->userdata('SOL') ) {
				$usuario .= $th.'<img src="'.base_url().'includes/img/icons/small/doc.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/inicio/maestra/documentos" onmouseover="tip(\'Lista Maestra de<br />Documentos de tu &Aacute;rea\')" onmouseout="cierra_tip()">Lista Maestra de Documentos</a></td></tr></table>'.$sep;
				$usuario .= $th.'<img src="'.base_url().'includes/img/icons/small/doc.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/inicio/maestra/registros" onmouseover="tip(\'Lista Maestra de<br />Registros de tu &Aacute;rea\')" onmouseout="cierra_tip()">Lista Maestra de Registros</a></td></tr></table>'.$sep;
			}

			// documentos externos controlados del sibib
			if( $this->session->userdata('id_sistema') == '2' ) {
				$usuario .= $th.'<img src="'.base_url().'includes/img/icons/small/doc.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/inicio/maestra/externos" onmouseover="tip(\'Lista Maestra de<br />Documentos Externos Controlados\')" onmouseout="cierra_tip()">Lista Maestra de Documentos Externos Controlados</a></td></tr></table>'.$sep;
			}

			// seguimiento de tus no conformidades
			$consulta = $this->db->from('pa_conformidades')->where('pa_conformidades.IdUsuario = '.$this->session->userdata('id_usuario'))->count_all_results();
			if( $consulta > 0 )
				$usuario .= $th.'<img src="'.base_url().'includes/img/icons/small/doc.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/procesos/conformidades/seguimiento_usuario/pendientes/0" onmouseover="tip(\'Seguimiento de las<br />No Conformidades que has levantado\')" onmouseout="cierra_tip()">Seguimiento de tus No Conformidades</a></td></tr></table>'.$sep;

			// evaluaciones
			$evaluaciones = $this->db->join('en_encuestas','en_encuestas.IdEncuesta = en_evaluacion.IdEncuesta')->get_where('en_evaluacion',array('Estado' => '1'));
			if( $evaluaciones->num_rows() > 0 ) {
				foreach( $evaluaciones->result() as $row ) {
					$preguntas  = $this->db->from('en_preguntas')->where(array('IdEncuesta' => $row->IdEncuesta))->count_all_results();
					switch( $row->IdEncuesta ) {
						// Clima Laboral
						case 1 :
							$this->db->from('en_respuestas_clima');
							$this->db->where(array('en_respuestas_clima.IdEvaluacion' => $row->IdEvaluacion, 'en_respuestas_clima.IdUsuario' => $this->session->userdata('id_usuario')));
							$respuestas = $this->db->count_all_results();
							if( $preguntas > $respuestas && !$this->session->userdata('JEF') ) {
								$alerta = true;
								$usuario_alerta .= $th_alert.'<img src="'.base_url().'includes/img/icons/small/grafica.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/evaluaciones/clima/presentacion" onmouseover="tip(\''.$row->Encuesta.' Pendiente\')" onmouseout="cierra_tip()">'.$row->Encuesta.'</a></td></tr></table>'.$sep;
							}
							break;

						// Desempeño
						case 2 :
							$contestadas = $this->db->from('en_respuestas_desempeno')->where(array('en_respuestas_desempeno.IdEvaluacion' => $row->IdEvaluacion, 'en_respuestas_desempeno.IdUsuario' => $this->session->userdata('id_usuario')))->count_all_results();
							$usuarios = $this->db->join('ab_usuarios','ab_usuarios.IdUsuario = ab_usuarios_mandos.IdUsuarioEvaluado')->from('ab_usuarios_mandos')->where(array('ab_usuarios_mandos.IdUsuarioEvaluador' => $this->session->userdata('id_usuario'),'ab_usuarios.Estado' => 1))->count_all_results();
							if( $usuarios ) {
								$respuestas = $contestadas * $usuarios;
								if( $preguntas > $respuestas ) {
									$alerta = true;
									$usuario_alerta .= $th_alert.'<img src="'.base_url().'includes/img/icons/small/grafica.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/evaluaciones/desempeno/presentacion" onmouseover="tip(\''.$row->Encuesta.' Pendiente\')" onmouseout="cierra_tip()">'.$row->Encuesta.'</a></td></tr></table>'.$sep;
								}
							}
							break;

						// Satisfacción de Usuarios
						case 3 :
							$resultados = $this->db->get_where('en_total_satisfaccion_sigc',array('IdEvaluacion' => $row->IdEvaluacion,'IdArea' => $this->session->userdata('id_area')));
							if( $resultados->num_rows() < 2 && $this->session->userdata('id_sistema') != 2 ) {
								if( $this->session->userdata('SAT') ) {
									$alerta = true;
									$usuario_alerta .= $th_alert.'<img src="'.base_url().'includes/img/icons/small/grafica.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/evaluaciones/satisfaccion/presentacion" onmouseover="tip(\''.$row->Encuesta.' Pendiente\')" onmouseout="cierra_tip()">'.$row->Encuesta.'</a></td></tr></table>'.$sep;
								}
							}
							break;

						default :
							$respuestas = 500;
							break;
					}


				}
			}

			// capacitación
			$consulta = $this->db->get_where('pa_capacitacion_evaluacion', array('Estado' => '1'), 1);
			$mandos = $this->db->group_by('IdUsuarioEvaluador')->select('IdUsuarioEvaluador, COUNT( IdUsuarioEvaluador ) AS Total')->get_where('ab_usuarios_mandos', array('IdUsuarioEvaluador' => $this->session->userdata('id_usuario')));
			if( $consulta->num_rows() > 0 ) {
				foreach( $consulta->result() as $row ) {
					$respuestas = $this->db->group_by('IdUsuarioEvaluado')->get_where('pa_capacitacion_respuestas', array('IdCapacitacionEvaluacion' => $row->IdCapacitacionEvaluacion, 'IdUsuario' => $this->session->userdata('id_usuario')));
					// primero realiza la evaluación personal
					if( $respuestas->num_rows() == 0 ) {
						$alerta = true; $usuario_alerta .= $th_alert.'<img src="'.base_url().'includes/img/icons/small/evaluacion.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/procesos/capacitacion/evaluar/'.$row->IdCapacitacionEvaluacion.'/'.$this->session->userdata('id_usuario').'" onmouseover="tip(\'Detección de Necesidades de Capacitación\')" onmouseout="cierra_tip()">Detección de Necesidades de Capacitación</a></td></tr></table>'.$sep;
					}
					// si ya realizo su evaluación y tiene personal a cargo
					else {
						$respuestas = $this->db->group_by('IdUsuarioEvaluado')->get_where('pa_capacitacion_respuestas', array('IdCapacitacionEvaluacion' => $row->IdCapacitacionEvaluacion, 'IdUsuario' => $this->session->userdata('id_usuario')));
						if( $mandos->num_rows() > 0 ) {
							$capacitacion_usuarios = false;
							foreach( $mandos->result() as $row_mandos ) {
								if( $respuestas->num_rows() < $row_mandos->Total ) {
									$capacitacion_usuarios = true;
									break;
								}
							}
							if( $capacitacion_usuarios ) {
								$alerta = true; $usuario_alerta .= $th_alert.'<img src="'.base_url().'includes/img/icons/small/evaluacion.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/procesos/capacitacion/usuarios/'.$row->IdCapacitacionEvaluacion.'" onmouseover="tip(\'Detección de Necesidades de Capacitación\')" onmouseout="cierra_tip()">Detección de Necesidades de Capacitación</a></td></tr></table>'.$sep;
							}
						}
					}
				}
			}

			// quejas
			$consulta = $this->db->from('pa_quejas')->where(array('pa_quejas.IdArea' => $this->session->userdata('id_area'), 'Estado' => '0'))->count_all_results();
			if( $consulta > 0 ) { $alerta = true; $usuario_alerta .= $th_alert.'<img src="'.base_url().'includes/img/icons/small/doc.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/listados/quejas/pendientes" onmouseover="tip(\'Quejas Pendientes\')" onmouseout="cierra_tip()">Quejas Pendientes ('.$consulta.')</a></td></tr></table>'.$sep; }

			// no conformidades
			$consulta = $this->db->from('pa_conformidades')->where(array('pa_conformidades.IdArea' => $this->session->userdata('id_area'), 'Estado' => '0'))->count_all_results();
			if( $consulta > 0 ) { $alerta = true; $usuario_alerta .= $th_alert.'<img src="'.base_url().'includes/img/icons/small/doc.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/listados/conformidades/sin-atender" onmouseover="tip(\'No Conformidades Sin Atender\')" onmouseout="cierra_tip()">No Conformidades Sin Atender ('.$consulta.')</a></td></tr></table>'.$sep; }

			// evidencia de no conformidades
			$consulta = $this->db->from('pa_conformidades')->where(array('pa_conformidades.IdArea' => $this->session->userdata('id_area'), 'Estado' => '4'))->count_all_results();
			if( $consulta > 0 ) { $alerta = true; $usuario_alerta .= $th_alert.'<img src="'.base_url().'includes/img/icons/small/doc.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/listados/conformidades/evidencias" onmouseover="tip(\'No Conformidades Sin Atender\')" onmouseout="cierra_tip()">Evidencia de No Conformidades Atendidas ('.$consulta.')</a></td></tr></table>'.$sep; }

			// cerrar no conformidades
			$consulta = $this->db->from('pa_conformidades')->where(array('Estado' => '1', 'IdUsuario' => $this->session->userdata('id_usuario')))->count_all_results();
			if( $consulta > 0 ) { $alerta = true; $usuario_alerta .= $th_alert.'<img src="'.base_url().'includes/img/icons/small/doc.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/procesos/conformidades/cerrar" onmouseover="tip(\'No Conformidades para Cerrar\')" onmouseout="cierra_tip()">No Conformidades para Cerrar ('.$consulta.')</a></td></tr></table>'.$sep; }

			// solicitudes por autorizar (solicitador)
			$consulta = $this->db->join('pa_solicitudes','pa_solicitudes.IdSolicitud = pa_solicitudes_distribucion.IdSolicitud')->from('pa_solicitudes_distribucion')->where(array('pa_solicitudes_distribucion.IdUsuario' => $this->session->userdata('id_usuario'), 'pa_solicitudes.Estado' => '0', 'pa_solicitudes.Rechazo' => '0', 'pa_solicitudes_distribucion.Tipo' => '1', 'pa_solicitudes_distribucion.Aceptado' => '0'))->count_all_results();
			if( $consulta > 0 ) { $alerta = true; $usuario_alerta .= $th_alert.'<img src="'.base_url().'includes/img/icons/small/doc.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/procesos/solicitudes/solicitar" onmouseover="tip(\'Autorizar tus Solicitudes\')" onmouseout="cierra_tip()">Revisa tus Solicitudes ('.$consulta.')</a></td></tr></table>'.$sep; }

			// solicitudes por autorizar (autorizador)
			$consulta = $this->db->join('pa_solicitudes','pa_solicitudes.IdSolicitud = pa_solicitudes_distribucion.IdSolicitud')->from('pa_solicitudes_distribucion')->where(array('pa_solicitudes_distribucion.IdUsuario' => $this->session->userdata('id_usuario'), 'pa_solicitudes.Estado' => '1', 'pa_solicitudes.Rechazo' => '0', 'pa_solicitudes_distribucion.Tipo' => '2', 'pa_solicitudes_distribucion.Aceptado' => '0'))->count_all_results();
			if( $consulta > 0 ) { $alerta = true; $usuario_alerta .= $th_alert.'<img src="'.base_url().'includes/img/icons/small/doc.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/procesos/solicitudes/autorizar" onmouseover="tip(\'Autorizar Solicitudes\')" onmouseout="cierra_tip()">Autorizar Solicitudes ('.$consulta.')</a></td></tr></table>'.$sep; }

			// solicitudes por autorizar (lista de distribución)
			$consulta = $this->db->join('pa_solicitudes','pa_solicitudes.IdSolicitud = pa_solicitudes_distribucion.IdSolicitud')->from('pa_solicitudes_distribucion')->where(array('pa_solicitudes_distribucion.IdUsuario' => $this->session->userdata('id_usuario'), 'pa_solicitudes.Estado' => '3', 'pa_solicitudes.Rechazo' => '0', 'pa_solicitudes_distribucion.Tipo' => '0', 'pa_solicitudes_distribucion.Aceptado' => '0'))->count_all_results();
			if( $consulta > 0 ) { $alerta = true; $usuario_alerta .= $th_alert.'<img src="'.base_url().'includes/img/icons/small/doc.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/procesos/solicitudes/revisar" onmouseover="tip(\'Revisar cambios en los Documentos\')" onmouseout="cierra_tip()">Revisar Documentos ('.$consulta.')</a></td></tr></table>'.$sep; }

			// solicitudes rechazadas
			if( $this->session->userdata('SOL') ) {
				$consulta = $this->db->from('pa_solicitudes')->where(array('pa_solicitudes.Estado' => '4', 'pa_solicitudes.IdArea' => $this->session->userdata('id_area')))->count_all_results();
				if( $consulta > 0 ) { $alerta = true; $usuario_alerta .= $th_alert.'<img src="'.base_url().'includes/img/icons/small/doc.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/procesos/solicitudes/rechazadas" onmouseover="tip(\'Solicitudes Rechazadas\')" onmouseout="cierra_tip()">Solicitudes Rechazadas ('.$consulta.')</a></td></tr></table>'.$sep; }
			}

			// cerrar sesión
			if( $alerta )
				$usuario .= $usuario_alerta.$sep.$th.'<img src="'.base_url().'includes/img/icons/small/logout.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/inicio/logout" onmouseover="tip(\'Salir del sistema\')" onmouseout="cierra_tip()">Cerrar Sesi&oacute;n</a></td></tr></table>';
			else
				$usuario .= $sep.$th.'<img src="'.base_url().'includes/img/icons/small/logout.png" /></th>'.$td.'<a class="a2" href="'.base_url().'index.php/inicio/logout" onmouseover="tip(\'Salir del sistema\')" onmouseout="cierra_tip()">Cerrar Sesi&oacute;n</a></td></tr></table>';

			$datos['usuario'] = $usuario;
		}

		// si no esta logueado
		else {
			$datos['usuario'] = false;
		}

		$datos['alerta'] = $alerta;

		$this->db->trans_complete();

		return $datos;
	}

	//
	// get_noticias(): Obtiene las noticias
	//
	function get_noticias() {
		$this->db->order_by( 'IdNoticia', 'DESC' );
		$consulta = $this->db->get_where( 'ef_noticias', array( 'Estado' => '1' ) , 5 );

		return $consulta;
	}

	//
	// login(): Login del usuario
	//
	function login() {
		$this->db->trans_start();
		$this->db->join( 'ab_areas', 'ab_usuarios.IdArea = ab_areas.IdArea' );
		//$this->db->like(array('Usuario' => $datos['usuario'],'Contrasena' => $datos['contrasena'],'Estado' => '1'));
		$this->db->where( 'Usuario LIKE "'.$this->input->post( 'usuario' ).'" AND Contrasena LIKE "'.$this->input->post( 'contrasena' ).'" AND Estado LIKE "1"' );
		$resp = $this->db->get( 'ab_usuarios', 1 );
		// si los datos son correctos
		if ( $resp->num_rows() > 0 ) {
			// genera las variables para la sesión
			foreach ( $resp->result_array() as $row ) {
				$idu = $row['IdUsuario'];
				$ida = $row['IdArea'];
				$ids = $row['IdSistema'];
				$nom = $row['Nombre']." ".$row['Paterno']." ".$row['Materno'];
				$cor = $row['Correo'];
				$are = $row['Area'];
			}
			// si es administrador
			$admin = false;
			$admin_resp = $this->db->get_where('ab_administradores', array('IdUsuario' => $idu));
			if ( $admin_resp->num_rows() > 0 ) {
				$admin = true;
			}

			// guarda los datos de la sesion
			$datos_sesion = array(
			   'id_usuario'	=> $idu,
			   'id_area'	=> $ida,
			   'id_sistema'	=> $ids,
			   'nombre'  	=> $nom,
			   'correo'  	=> $cor,
			   'area' 	 	=> $are,
			   'admin'		=> $admin
			);

			// permisos especialesdel usuario
			$per = $this->db->get_where('ab_usuarios_permisos', array('IdUsuario' => $idu));
			if ( $per->num_rows() > 0 ) {
				foreach( $per->result() as $row ) :
					$datos_sesion[$row->Clave] = $row->Clave;
				endforeach;
			}
			$this->session->set_userdata($datos_sesion);

			// inserta el registro del login del usuario
			$this->db->insert( 'ab_usuarios_acceso', array( 'IdUsuario'	=> $idu ) );

			$this->db->trans_complete();

			return true;
		}
		// si los datos han sido incorrectos
		else {
			$this->db->trans_complete();
			return false;
		}
	}

	//
	// get_areas(): Obtiene las areas para las quejas
	//
	function get_areas() {
		$condicion = array(
			'Area <>' => 'Invitado',
			'PaginaWeb <>' => 2
		);
		$this->db->order_by('Area');
		$consulta = $this->db->get_where( 'ab_areas', $condicion );

		return $consulta;
	}

	//
	// get_departamentos( $id ): Obtiene los departamentos de un area
	//
	function get_departamentos( $id ) {
		$condicion = array(
			'IdArea' => $id
		);
		$this->db->order_by('Departamento');
		$consulta = $this->db->get_where( 'ab_departamentos', $condicion );

		return $consulta;
	}

	//
	// get_noticia( $id ): Obtiene una noticia en base a la id
	//
	function get_noticia( $id ) {
		$condicion = array(
			'IdNoticia' => $id
		);
		$consulta = $this->db->get_where( 'ef_noticias', $condicion, 5 );

		return $consulta;
	}

	//
	// get_enlaces(): Obtiene los enlaces de interes
	//
	function get_enlaces() {
		$consulta = $this->db->get( 'ef_enlaces', 10 );

		return $consulta;
	}

	//
	// get_area( $id ): Obtiene la información de un área
	//
	function get_area( $id ) {
		$condicion = array(
			'IdArea' => $id
		);
		$consulta = $this->db->get_where( 'ab_areas', $condicion, 1 );

		return $consulta;
	}

	//
	// get_datos_usuario( $id ): Obtiene los datos de un usuario
	//
	function get_datos_usuario( $id ) {
		$condicion = array(
			'IdUsuario' => $id
		);
		$consulta = $this->db->get_where( 'ab_usuarios', $condicion, 1 );

		return $consulta;
	}

	//
	// get_eventos(): Obtiene los eventos
	//
	function get_eventos() {
		$consulta = $this->db->get( 'ef_eventos' );

		return $consulta;
	}

	//
	// get_usuarios( $edo ): Obtiene los usuarios del área del usuario
	//
	function get_usuarios( $edo ) {
		$condicion = array();
		$condicion['IdArea'] = $this->session->userdata( 'id_area' );
		switch( $edo ) {
			case 'activos':
				$condicion['Estado'] = '1';
				break;

			case 'inactivos':
				$condicion['Estado'] = '0';
				break;
		}
		$this->db->order_by( 'Nombre' );
		$consulta = $this->db->get_where( 'ab_usuarios', $condicion );

		return $consulta;
	}

	//
	// get_usuario_validar( $tipo ): Valida que no exista un usuario igual
	//
	function get_usuario_validar( $tipo ) {
		switch( $tipo ) {
		// Usuario
			case 'usuario' :
				$condicion = array(
					'Usuario' 		=> $this->input->post('usuario'),
					'IdUsuario <>'	=> $this->session->userdata('id_usuario'),
				);
				$consulta = $this->db->get_where('ab_usuarios', $condicion);
				break;

		// Nombre Exacto
			case 'nombre' :
				$condicion = array(
					'Nombre' 		=> $this->input->post('nombre'),
					'Paterno' 		=> $this->input->post('paterno'),
					'Materno'		=> $this->input->post('materno'),
					'IdUsuario <>'	=> $this->session->userdata('id_usuario'),
				);
				$consulta = $this->db->get_where('ab_usuarios', $condicion);
				break;
		}

		// regresa la respuesta
		if( $consulta->num_rows() > 0 ) {
			return true;
		}
		else {
			return false;
		}
	}

	//
	// get_documentos( $tipo ): Obtiene los documentos para las listas maestras
	//
	function get_documentos( $tipo ) {
		// obtiene los documentos segun el tipo
		switch( $tipo ) {
		// Lista Maestra de Documentos
			case 'documentos' :
				$this->db->group_by('bc_documentos.IdDocumento');
				$this->db->order_by("bc_documentos.Codigo", "ASC");
				$this->db->join('bc_secciones','bc_secciones.IdSeccion = bc_documentos.IdSeccion');
				$this->db->join('bc_documentos_word','bc_documentos_word.IdDocumento = bc_documentos.IdDocumento','LEFT OUTER');
				$this->db->select('bc_documentos.IdDocumento, bc_documentos.IdArea, bc_secciones.Seccion, bc_documentos.IdSeccion, bc_documentos.Codigo, bc_documentos.Edicion, bc_documentos.Nombre, bc_documentos.Ruta, bc_documentos.Fecha, bc_documentos.Estado, bc_documentos_word.Ruta AS RutaWord, bc_documentos_word.FechaElaboracion');
				$consulta = $this->db->get_where('bc_documentos',array('bc_documentos.Estado' => '1', 'bc_documentos.IdArea' => $this->session->userdata('id_area')));
				break;

		// Lista Maestra de Registros
			case 'registros' :
				$this->db->group_by('bc_documentos.IdDocumento');
				$this->db->order_by("bc_documentos.Codigo", "ASC");


				$this->db->join('bc_documentos_registros', 'bc_documentos.IdDocumento=bc_documentos_registros.IdDocumento');
				/*$this->db->join('bc_secciones','bc_secciones.IdSeccion = bc_documentos.IdSeccion');
				$this->db->join('bc_documentos_word','bc_documentos_word.IdDocumento = bc_documentos.IdDocumento','LEFT OUTER');
				$this->db->join('bc_documentos_registros','bc_documentos_registros.IdDocumento = bc_documentos.IdDocumento','left');
				$this->db->select('bc_documentos_registros.Retencion, bc_secciones.Seccion, bc_documentos_registros.Disposicion, bc_documentos.IdDocumento, bc_documentos.IdArea, bc_documentos.IdSeccion, bc_documentos.Codigo, bc_documentos.Edicion, bc_documentos.Nombre, bc_documentos.Ruta, bc_documentos.Fecha, bc_documentos.Estado, bc_documentos_word.Ruta AS RutaWord, bc_documentos_word.FechaElaboracion');*/
				$consulta = $this->db->get_where('bc_documentos',array('bc_documentos.Estado' => '1', 'bc_documentos.IdArea' => $this->session->userdata('id_area')));
			break;

			// Lista maestra de documentos externos controlados
			case 'externos' :
				$consulta = $this->db->get_where('bc_documentos_externos',array('bc_documentos_externos.Estado' => '1', 'bc_documentos_externos.IdArea' => $this->session->userdata('id_area')));
				break;

			default :
				redirect('inicio');
				break;
		}

		return $consulta;
	}

	//
	// set_fecha( $fecha ): Genera el formato de fecha para mostrarlo al usuario
	//
	function set_fecha( $fecha ) {
		switch( substr( $fecha, 5, 2 ) ) {
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

		return substr( $fecha, 8, 2)." / ".$mes." / ".substr( $fecha, 0, 4 );
	}

	//
	// inserta_contacto(): Inserta un mensaje para el administrador
	//
	function inserta_contacto() {
		$inserta = array(
           'Nombre'		=> $this->input->post('nombre'),
           'Mensaje'	=> $this->input->post('mensaje'),
           'Correo'		=> $this->input->post('correo'),
		   'Fecha'		=> date('Y').'-'.date('m').'-'.date('d'),
		   'Estado'		=> '1',
        );

		$resp = $this->db->insert( 'ef_contacto', $inserta );

		return $resp;
	}

	//
	// inserta_usuario(): Inserta un nuevo usuario
	//
	function inserta_usuario() {
		// array para insertar en la bd
		$inserta = array(
		   'IdArea'			=> $this->session->userdata('id_area'),
		   'Nombre'			=> $this->input->post('nombre'),
		   'Paterno'		=> $this->input->post('paterno'),
		   'Materno'		=> $this->input->post('materno'),
		   'Correo'			=> $this->input->post('correo'),
		   'Usuario'		=> $this->input->post('usuario'),
		   'Contrasena'		=> $this->input->post('contrasena'),
		   'Estado'			=> '1', // usuario activo
		);

		// realiza la inserción
		$resp = $this->db->insert('ab_usuarios', $inserta);

		return $resp;
	}

	//
	// modifica_admin_usuario( $id ): Modifica los datos de un usuario
	//
	function modifica_admin_usuario( $id ) {
		// realiza la actualizaci�n definitiva
		$actualiza = array(
			'Nombre'	=> $this->input->post('nombre'),
			'Paterno'	=> $this->input->post('paterno'),
			'Materno'	=> $this->input->post('materno'),
			'Correo'	=> $this->input->post('correo'),
			'Usuario'	=> $this->input->post('usuario'),
		);

		if( $this->input->post('mod_contrasena') ) {
			$actualiza['Contrasena'] = $this->input->post('contrasena');
		}

		$this->db->where( 'IdUsuario', $id );
		$resp = $this->db->update( 'ab_usuarios', $actualiza );

		return $resp;
	}

	//
	// modifica_usaurio( $id ): Modifica la información de un suario
	//
	function modifica_usuario( $id, $pass ) {
		// modifica la contraseña
		if( $pass ) {
			$actualiza = array(
	           'Usuario'	=> $this->input->post('usuario'),
	           'Contrasena'	=> $this->input->post('contrasena'),
	        );
		}
		// modifica los datos
		else {
			$actualiza = array(
	           'Nombre'		=> $this->input->post('nombre'),
	           'Paterno'	=> $this->input->post('paterno'),
	           'Materno'	=> $this->input->post('materno'),
	           'Correo'		=> $this->input->post('correo'),
	        );
		}

		$this->db->where('IdUsuario', $id );
		$resp = $this->db->update('ab_usuarios', $actualiza);

		return $resp;
	}

	//
	// get_info_sort( $reg ): Especificaciones para el sort de la tabla, estableciendo el número de registros a mostrar
	//
	function get_info_sort( $reg ) {
		$sort_tabla = '
			<script type="text/javascript" charset="utf-8">
                $(document).ready(function() {
                    var dontSort = [];
                    $("#tabla thead th").each( function () {
                        if ( $(this).hasClass( "no_sort" )) {
                            dontSort.push( { "bSortable": false } );
                        } else {
                            dontSort.push( null );
                        }
                    } );
                    $("#tabla").dataTable({
						"bJQueryUI": true,
						"sPaginationType": "full_numbers",
                        "aoColumns": dontSort,
                        "iDisplayLength": '.$reg.',
                        "aLengthMenu": [[-1, 10, 25, 50, 100], [ " - Todos los registros - ", "10 registros", "25 registros", "50 registros", "100 registros"]]
                    });
                } );
            </script>
		';

		return $sort_tabla;
	}
}
?>

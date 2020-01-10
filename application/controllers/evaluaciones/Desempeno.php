<?php 
/****************************************************************************************************
*
*	CONTROLLERS/evaluaciones/desempeno.php
*
*		Descripción:
*			Evaluación al Desmpeño 
*
*		Fecha de Creación:
*			03/Octubre/2011
*
*		Ultima actualización:
*			11/Julio/2011
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas 
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Desempeno extends CI_Controller {
	
/** Atributos **/
	private $id_evaluacion;
	private $nom_evaluacion;
	private $nombre_evaluacion;

/** Propiedades **/	
	public function set_id( $id ) { $this->id_evaluacion = $id; }
	public function set_nom( $nom ) { $this->nom_evaluacion = $nom; }
	public function set_nombre( $nombre ) { $this->nombre_evaluacion = $nombre; }
	
/** Constructor **/
	function __construct() {
		parent::__construct();
		
		// si no se ha identificado correctamente
		if( !$this->session->userdata( 'id_usuario' ) ) {
			redirect( 'inicio' );
		}
		else {
			// Modelo
			$this->load->model('evaluaciones/desempeno_model','',TRUE);
			$this->set_id( 2 );
			$this->set_nom( 'desempeno' );
			$this->set_nombre( 'Evaluaci&oacute;n al Desempe&ntilde;o' );
		}
	}
	
/** Funciones **/	
	//
	// index(): Levantar la queja
	//
	function index() {
		// obtiene las variables para mostrar el listado específico
		if( $this->uri->segment(4) ) {
			$edo = $this->uri->segment(4); 
		}
		else {
			$edo = '';
		}
		
		// variables necesarias para la página
		$datos['titulo'] = $this->nombre_evaluacion;
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['evaluacion'] = $this->nom_evaluacion;
		$datos['avance'] = true;
		$resp = true;
		$ide = 2;
		
		$datos['grafica'] = true;
		$datos['preguntas'] = true;
		
		$resp = true;
		$encuesta = $this->db->order_by('en_evaluacion.Fecha','DESC')->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta')->get_where('en_encuestas',array('en_encuestas.IdEncuesta' => $ide),1);
		if( $encuesta->num_rows() > 0 ) {
			foreach( $encuesta->result() as $row ) {
				// preguntas de la encuesta
				$preguntas = $this->db->get_where('en_preguntas', array('en_preguntas.IdEncuesta' => $ide));
				
				// obtiene el listado del personal del área
				$personal = $this->db->group_by('ab_usuarios.IdUsuario')->join('ab_usuarios_mandos','ab_usuarios_mandos.IdUsuarioEvaluador = ab_usuarios.IdUsuario')->get_where('ab_usuarios', array('ab_usuarios.IdArea' => $this->session->userdata('id_area'), 'ab_usuarios.Estado' => 1, 'ab_usuarios.Nombre NOT LIKE' => '%AUDITOR%'));
				if( $personal->num_rows() > 0 ) {
					$porcentaje = 0;
					foreach( $personal->result() as $row_u ) {
						$respuestas_personal = $this->db->get_where('en_respuestas_desempeno', array('en_respuestas_desempeno.IdUsuario' => $row_u->IdUsuario,'en_respuestas_desempeno.IdEvaluacion' => $row->IdEvaluacion));
						$evaluar = $this->db->join('ab_usuarios','ab_usuarios.IdUsuario = ab_usuarios_mandos.IdUsuarioEvaluado')->get_where('ab_usuarios_mandos', array('ab_usuarios_mandos.IdUsuarioEvaluador' => $row_u->IdUsuario, 'ab_usuarios.Estado' => '1'));
						$porcentaje = $porcentaje + round( ( $respuestas_personal->num_rows() * 100 ) / ( $evaluar->num_rows() * $preguntas->num_rows() ) * 100 ) / 100;							
					}
					$datos['porcentaje_avance'] = round( ( $porcentaje / $personal->num_rows() ) * 100 ) / 100;
					if( $datos['porcentaje_avance'] > 100 )
						$datos['porcentaje_avance'] = 100;
				}
			}
		}
		else {					
			$datos['avance'] = false;
		}
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		// Revisa si hay evaluaciones activas
		$encuesta = $this->db->order_by('en_evaluacion.Fecha','DESC')->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta')->get_where('en_encuestas',array('en_encuestas.IdEncuesta' => $ide, 'Estado' => '1'),1);		
		if( $encuesta->num_rows() > 0 ) {
			foreach( $encuesta->result() as $row ) {
				$datos['nombre'] = $row->Nombre;
				$datos['evalua'] = $row->Estado;
				$idv = $row->IdEvaluacion; 
				
				// si es clima o desempeño y esta activa muestra el avance
				if( $row->Estado ) {
					$datos['avance'] = true;
				}
					
				// si esta activa pero ya terminó
				if( $edo == 'termino' ) {
					$datos['evalua'] = false;					
					// msj
					$datos['mensaje_titulo'] = "Evaluaci&oacute;n Terminada";
					$datos['mensaje'] = "Has terminado de evaluar esta encuesta.<br /><strong>Gracias por tu participaci&oacute;n!</strong>";				
					$this->load->view('mensajes/ok',$datos);					
				}

				// si el usuario debe realizar la evaluacion al desempeño
				$condicion = array(
					'ab_usuarios_mandos.IdUsuarioEvaluador' => $this->session->userdata('id_usuario'), 
					'ab_usuarios.IdArea' => $this->session->userdata('id_area'),
					'ab_usuarios.Estado' => '1'
				);
				$this->db->join('ab_usuarios','ab_usuarios.IdUsuario = ab_usuarios_mandos.IdUsuarioEvaluado');
				$consulta = $this->db->get_where('ab_usuarios_mandos', $condicion );
				if( $consulta->num_rows() <= 0 ) {
					$datos['evalua'] = false;
				}
				else {
					$datos['evalua'] = false;
					// revisa a los usuarios para saber si todavia tiene que evaluar
					$consulta = $this->db->join('ab_usuarios','ab_usuarios.IdUsuario = ab_usuarios_mandos.IdUsuarioEvaluado')->get_where('ab_usuarios_mandos',array('ab_usuarios_mandos.IdUsuarioEvaluador' => $this->session->userdata('id_usuario'), 'ab_usuarios.IdArea' => $this->session->userdata('id_area'),'ab_usuarios.Estado' => '1'));
					foreach( $consulta->result() as $row ) {
						$this->db->join('en_encuestas','en_encuestas.IdEncuesta = en_preguntas.IdEncuesta');
						$this->db->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta');
						$preguntas = $this->db->get_where('en_preguntas', array('en_preguntas.IdEncuesta' => $ide, 'en_evaluacion.IdEvaluacion' => $idv));
						$respuestas = $this->db->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_desempeno.IdPregunta')->get_where('en_respuestas_desempeno', array('en_preguntas.IdEncuesta' => $ide, 'en_respuestas_desempeno.IdEvaluacion' => $idv, 'en_respuestas_desempeno.IdUsuarioEvaluado' => $row->IdUsuario));
						if( $preguntas->num_rows() > $respuestas->num_rows() ) {
							$datos['evalua'] = true;
							break;
						}
					}
				}
			}
		}
		else {
			$datos['evalua'] = false;
			
		}
		$i=0;
		$personal = $this->db->group_by('ab_usuarios.IdUsuario')->join('ab_usuarios_mandos','ab_usuarios_mandos.IdUsuarioEvaluador = ab_usuarios.IdUsuario')->get_where('ab_usuarios', array('ab_usuarios.IdArea' => $this->session->userdata('id_area'), 'ab_usuarios.Estado' => 1, 'ab_usuarios.Nombre NOT LIKE' => '%AUDITOR%'));
				if( $personal->num_rows() > 0 ) {
					foreach( $personal->result() as $row_u ) {
						$respuestas_personal = $this->db->get_where('en_respuestas_desempeno', array('en_respuestas_desempeno.IdUsuario' => $row_u->IdUsuario,'en_respuestas_desempeno.IdEvaluacion' => $row->IdEvaluacion));	
						$evaluar   = $this->db->join('ab_usuarios','ab_usuarios.IdUsuario = ab_usuarios_mandos.IdUsuarioEvaluado')->get_where('ab_usuarios_mandos', array('ab_usuarios.IdArea' => $this->session->userdata('id_area'),'ab_usuarios_mandos.IdUsuarioEvaluador' => $row_u->IdUsuario, 'ab_usuarios.Estado' => '1'));
						$porcentaje = round( ( $respuestas_personal->num_rows() * 100 ) / ( $evaluar->num_rows() * $preguntas->num_rows() ) * 100 ) / 100;
						if( $porcentaje > 100 )
							$porcentaje = 100;
						$listado[$i] = array( 
							'Nombre' 		=> $row_u->Nombre." ".$row_u->Paterno." ".$row_u->Materno,
							'Porcentaje' 	=> $porcentaje, 
						);
						$i++;
					}
				}
				$datos['listado'] = $listado;
					$i=0;
					$tabla=0;
					$j=0;
					$total=0;										
					foreach( $listado as $row ) {
					if( $i ) {
						$tabla .= '<tr>';
						$i = 0;
					}
					else {
						$tabla .= '<tr class="odd">';
						$i = 1;
					}
					if( $row['Porcentaje'] == '100' ) {
						$tabla .= '<th><img onmouseover="tip(\'Evaluacion terminada\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/terminada.png" /></th>';
					}
					else {
						$tabla .= '<th><img onmouseover="tip(\'Evaluacion pendiente\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/pendiente.png" /></th>';
					}
					$tabla .= '<td>'.$row['Nombre'].'</td><td>'.$row['Porcentaje'].' %</td></tr>';
					$total = $total + $row['Porcentaje'];
					$j++;
				}				
				$datos['total'] =round( ( $total / $j ) * 100 ) / 100 ;
				$tabla .= '</tbody></table>';
		// estructura de la página (2)	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('evaluaciones/comun/inicio',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}

	//
	// presentacion(): Presentación de la evaluación (si es que tiene)	
	//
	function presentacion() {
		// variables necesarias para la página
		$datos['titulo'] = $this->nombre_evaluacion;
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['evaluacion'] = $this->nom_evaluacion;
		$ide = $this->id_evaluacion;
		$datos['ide'] = $ide;
		$resp = true;
		$main = '';
		
		// Información de la evaluación
		$encuesta = $this->db->order_by('en_evaluacion.IdEvaluacion','DESC')->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta')->get_where('en_encuestas',array('en_encuestas.IdEncuesta' => $ide, 'en_evaluacion.Estado' => '1'),1);
		if( $encuesta->num_rows() > 0 ) {
			foreach( $encuesta->result() as $row ) {
				$idv = $row->IdEvaluacion;				
				$datos['nombre'] = $row->Nombre;
				$idv = $row->IdEvaluacion;
				$main .= '<table class="tabla" width="700"><tr><td>'.$row->Presentacion.'<td></tr></table><br />';
			}
		}
		
		$consulta = $this->db->join('ab_usuarios','ab_usuarios.IdUsuario = ab_usuarios_mandos.IdUsuarioEvaluado')->get_where('ab_usuarios_mandos',array('ab_usuarios_mandos.IdUsuarioEvaluador' => $this->session->userdata('id_usuario'), 'ab_usuarios.IdArea' => $this->session->userdata('id_area'),'ab_usuarios.Estado' => '1'));
		if( $consulta->num_rows() > 0 ) {
			$main .= '<table class="tabla" width="700">';
			$resp = false;								
			$i = 0;
			
			// agrega los usuarios a evaluar
			foreach( $consulta->result() as $row ) {
				$this->db->join('en_encuestas','en_encuestas.IdEncuesta = en_preguntas.IdEncuesta');
				$this->db->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta');
				$preguntas = $this->db->get_where('en_preguntas', array('en_preguntas.IdEncuesta' => $ide, 'en_evaluacion.IdEvaluacion' => $idv));
				$respuestas = $this->db->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_desempeno.IdPregunta')->get_where('en_respuestas_desempeno', array('en_preguntas.IdEncuesta' => $ide, 'en_respuestas_desempeno.IdEvaluacion' => $idv, 'en_respuestas_desempeno.IdUsuarioEvaluado' => $row->IdUsuario));
				
				// revisa los usuarios que ya se evaluaron						
				if( $preguntas->num_rows() > $respuestas->num_rows() ) {
					$resp = true;
																	
					if( $i ) {
						$main .= '<tr class="odd">';
						$i = 0;
					}
					else {
						$main .= '<tr>';
						$i = 1;
					}
					$main .= '<th width="15"><a href="'.base_url().'index.php/evaluaciones/desempeno/contestar/'.$row->IdUsuario.'/'.$idv.'" onmouseover="tip(\'Click para evaluar a esta persona\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/seguimiento.png" /></a></th><td><a href="'.base_url().'index.php/evaluaciones/desempeno/contestar/'.$row->IdUsuario.'/'.$idv.'" onmouseover="tip(\'Click para evaluar a esta persona\')" onmouseout="cierra_tip()" style="color:#333">'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.'</a></td></tr>';
				}
			}
					
			// si ya no hay usuarios para evaluar
			if( !$resp )
				redirect('evaluaciones/desempeno/index/termino');
					
			$main .= '</table>';
		}
		else {
			// si no debe evaluar
			if( !$resp )
				redirect('evaluaciones/desempeno');
		}
		$datos['main'] = $main;
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('evaluaciones/comun/presentacion',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}

	//
	// contestar( $ids, $idv ): Contesta una sección de opciones multiples de la evaluaci�n 
	//
	function contestar( $ids, $idv ) {
		// variables necesarias para la página
		$datos['titulo'] = $this->nombre_evaluacion;
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['evaluacion'] = $this->nom_evaluacion;
		$ide = $this->id_evaluacion;
		
		// nombre de la vista para contestar
		$pagina_contestar = 'contestar_desempeno';
		
		// obtiene el nombre del usuario
		$usuario = $this->db->get_where('ab_usuarios',array('ab_usuarios.IdUsuario' => $ids),1);				
		foreach( $usuario->result() as $row ) {
			$datos['nombre_usuario'] = $row->Nombre." ".$row->Paterno." ".$row->Materno;
		}				
		
		// obtiene la info de la encuesta
		$encuesta = $this->db->join('en_encuestas','en_encuestas.IdEncuesta = en_preguntas.IdEncuesta')->get_where('en_preguntas',array('en_preguntas.IdEncuesta' => $ide),1);				
		if( $encuesta->num_rows() > 0 ) {			
			// obtiene las opciones de cada pregunta			
			foreach( $encuesta->result() as $row ) {
				// la consulta regresa todas las preguntas no respondidas de TODAS las secciones ya que
				// existen problemas con las condiciones del LEFT OUTER JOIN
				$consulta_preguntas = $this->db->join('en_respuestas_desempeno', 'en_respuestas_desempeno.IdPregunta = en_preguntas.IdPregunta', 'LEFT OUTER')->select('en_preguntas.IdPregunta, en_preguntas.IdEncuesta, en_preguntas.IdSeccion, en_preguntas.IdOpcionTipo, en_preguntas.Pregunta')->get_where('en_preguntas');
				if( $consulta_preguntas->num_rows() > 0 ) {							
					$arreglo = array();
					foreach( $consulta_preguntas->result() as $row_p ) {
						// si es de la seccion que se esta evaluando
						if( $row_p->IdEncuesta == $ide ) {
							$consulta_opciones = $this->db->get_where('en_opciones',array('IdOpcionTipo' => $row_p->IdOpcionTipo ));
							if( $consulta_opciones->num_rows() > 0 ) {
								$i = 1;
								foreach( $consulta_opciones->result() as $row_o ) {								
									$arreglo[$row_p->Pregunta]['Opcion '.$i] = array(
											'nombre'	=> $row_o->Opcion,
											'name'		=> 'pregunta_'.$row_p->IdPregunta,
											'value'		=> $row_o->IdOpcion,
											'class'		=> 'in_radio',
									);								
									$i++;
								}
							}
						}
					}
				}
				$datos['consulta'] = $arreglo;				
			}
		}
		else {
			redirect('errores/error_404');
		}
				
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('evaluaciones/desempeno/contestar',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
		
		$resp = false;
		// Guarda las Respuestas
		if( $_POST ) {
			$preguntas = $this->db->get_where('en_preguntas',array('en_preguntas.IdEncuesta' => $ide));
			if( $preguntas->num_rows() > 0 ) {
				$i = 0;
				$inserta = array();						
				foreach( $preguntas->result() as $row ) :
					if( $this->input->post('pregunta_'.$row->IdPregunta) ) {
						$inserta[$i] = array(
							'IdEvaluacion' 		=> $idv,
							'IdOpcion'	 		=> $this->input->post('pregunta_'.$row->IdPregunta),
							'IdPregunta'	 	=> $row->IdPregunta,
							'IdUsuario' 		=> $this->session->userdata('id_usuario'),
							'IdUsuarioEvaluado' => $ids,
						);
					}
					$i++;
				endforeach;
				
				if ( $inserta )
					$resp = $this->db->insert_batch('en_respuestas_desempeno', $inserta); 
				if( $resp ) {
					// msj de éxito
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "Tus respuestas se han guardado";
					$datos['enlace'] = "evaluaciones/desempeno/presentacion";
					$this->load->view('mensajes/ok_redirec',$datos);
				}
			}
		}
	}

	//
	// preguntas(): Muestra el listado de las preguntas de la evaluación
	//
	function preguntas() {
		// variables necesarias para la página
		$datos['titulo'] = $this->nombre_evaluacion;
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['evaluacion'] = $this->nom_evaluacion;
		$ide = $this->id_evaluacion;
				
		// Preguntas
		$datos['preguntas'] = $this->db->order_by('IdSeccion')->get_where('en_preguntas',array('en_preguntas.IdEncuesta' => $ide));
		
		// Secciones
		$datos['secciones'] = $this->db->order_by('IdSeccion')->get_where('en_secciones',array('en_secciones.IdEncuesta' => $ide));
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('evaluaciones/comun/preguntas',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}

	//
	// avance(): Muestra el listado del personal faltante de contestar una evaluación
	//
	function avance() {
		// variables necesarias para la página
		$datos['titulo'] = $this->nombre_evaluacion;
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 50 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();	
		$datos['evaluacion'] = $this->nom_evaluacion;
		$ide = $this->id_evaluacion;
		
		// Información de la encuesta
		$encuesta = $this->db->order_by('en_evaluacion.IdEvaluacion','DESC')->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta')->get_where('en_encuestas',array('en_encuestas.IdEncuesta' => $ide),1);
		if( $encuesta->num_rows() > 0 ) {
			foreach( $encuesta->result() as $row ) {
								
				$i = 0;
				$listado = array();
				
				// preguntas de la encuesta
				$preguntas = $this->db->get_where('en_preguntas', array('en_preguntas.IdEncuesta' => $ide));
				
				// obtiene el listado del personal del área
				$personal = $this->db->group_by('ab_usuarios.IdUsuario')->join('ab_usuarios_mandos','ab_usuarios_mandos.IdUsuarioEvaluador = ab_usuarios.IdUsuario')->get_where('ab_usuarios', array('ab_usuarios.IdArea' => $this->session->userdata('id_area'), 'ab_usuarios.Estado' => 1, 'ab_usuarios.Nombre NOT LIKE' => '%AUDITOR%'));
				if( $personal->num_rows() > 0 ) {
					foreach( $personal->result() as $row_u ) {
						$respuestas_personal = $this->db->get_where('en_respuestas_desempeno', array('en_respuestas_desempeno.IdUsuario' => $row_u->IdUsuario,'en_respuestas_desempeno.IdEvaluacion' => $row->IdEvaluacion));	
						$evaluar   = $this->db->join('ab_usuarios','ab_usuarios.IdUsuario = ab_usuarios_mandos.IdUsuarioEvaluado')->get_where('ab_usuarios_mandos', array('ab_usuarios.IdArea' => $this->session->userdata('id_area'),'ab_usuarios_mandos.IdUsuarioEvaluador' => $row_u->IdUsuario, 'ab_usuarios.Estado' => '1'));
						$porcentaje = round( ( $respuestas_personal->num_rows() * 100 ) / ( $evaluar->num_rows() * $preguntas->num_rows() ) * 100 ) / 100;
						if( $porcentaje > 100 )
							$porcentaje = 100;
						$listado[$i] = array( 
							'Nombre' 		=> $row_u->Nombre." ".$row_u->Paterno." ".$row_u->Materno,
							'Porcentaje' 	=> $porcentaje, 
						);
						$i++;
					}
				}
				$datos['listado'] = $listado;
			}
		}
			
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('evaluaciones/comun/avance',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}

	//
	// resultados(): Muestra el formulario para generar la gráfica
	//
	function resultados() {
		// variables necesarias para la página
		$datos['titulo'] = $this->nombre_evaluacion;
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['evaluacion'] = $this->nom_evaluacion;
		$ide = $this->id_evaluacion;
		
		// Información de la encuesta
		$encuesta = $this->db->order_by('en_evaluacion.IdEvaluacion','DESC')->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta')->get_where('en_encuestas',array('en_encuestas.IdEncuesta' => $ide),1);
		if( $encuesta->num_rows() > 0 ) {
			foreach( $encuesta->result() as $row ) {			
				$datos['titulo'] = $row->Encuesta;
				$datos['titulo_encuesta'] = "Gr&aacute;ficas de Resultados: ".$row->Encuesta;				
			}
		}		
		
		// Evaluaciones
		$evaluaciones = $this->db->order_by('IdEvaluacion', 'DESC')->get_where('en_evaluacion', array('IdEncuesta' => $ide));
		if ($evaluaciones -> num_rows() > 0) {
			$datos['eva'] = array();
			$datos['eva']['all'] = " - Comparativo de las dos &uacute;ltimas evaluaciones - ";
			foreach ($evaluaciones->result() as $row)
				$datos['eva'][$row->IdEvaluacion] = $row->Nombre;
		}
		
		// Áreas
		$areas = $this->db->order_by('Area')->not_like('Area','Invitado')->not_like('Area','Coordinación de Calidad')->get('ab_areas');
		if ($areas -> num_rows() > 0) {
			$datos['areas'] = array();
			$datos['areas']['all'] = " - Todas las &Aacute;reas - ";
			foreach ($areas->result() as $row)
				$datos['areas'][$row -> IdArea] = $row -> Area;
		}
		
		// Secciones
		$sec = $this -> db -> order_by('IdSeccion') -> get_where('en_secciones', array('IdEncuesta' => $ide));
		if ($sec -> num_rows() > 0) {
			$datos['sec'] = array();
			$datos['sec']['all'] = " - Todas las Secciones - ";
			foreach ($sec->result() as $row)
				$datos['sec'][$row -> IdSeccion] = $row -> Seccion;
		}
		
		// Muestra la gráfica
		if( $_POST ) {
			$this->grafica( $ide, $this->input->post('area'), $this->input->post('seccion'), $this->input->post('evaluacion'));
		}
		else {
			// estructura de la página
			$this->load->view('_estructura/header',$datos);	
			$this->load->view('_estructura/top',$datos);
			$this->load->view('evaluaciones/comun/resultados',$datos);
			$this->load->view('_estructura/right');
			$this->load->view('_estructura/footer');
		}
	}

	//
	// grafica( $ida, $ids, $idv ): Muestra la grafica
	//
	function grafica( $ide, $ida, $ids, $idv ) {
		// variables necesarias para la página
		$datos['titulo'] = $this->nombre_evaluacion;
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['evaluacion'] = $this->nom_evaluacion;
		$datos['ide'] = $ide;
		
		// Información de la encuesta
		$encuesta = $this->db->order_by('en_evaluacion.IdEvaluacion','DESC')->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta')->get_where('en_encuestas',array('en_encuestas.IdEncuesta' => $ide),1);
		if( $encuesta->num_rows() > 0 ) {
			foreach( $encuesta->result() as $row ) {			
				$datos['titulo'] = $row->Encuesta;
				$datos['titulo_encuesta'] = "Gr&aacute;ficas de Resultados: ".$row->Encuesta;				
			}
		}
		
		$consulta = array();
		
		// areas		
		if( $ida != "all") {
			$consulta['ab_usuarios.IdArea'] = $ida;
			$consulta_area = $this->db->get_where('ab_areas',array('IdArea' => $ida));
			foreach( $consulta_area->result() as $row )
				$datos['area'] = $row->Area;
		}
		else {
			$datos['area'] = 'Todas las &Aacute;reas';
		}
		
		// secciones
		if( $ids != "all") {
			$consulta['en_preguntas.IdSeccion'] = $ids;
			$consulta_seccion = $this->db->get_where('en_secciones',array('IdSeccion' => $ids));
			foreach( $consulta_seccion->result() as $row )
				$datos['seccion'] = $row->Seccion;
		}
		else {
			$datos['seccion'] = 'Todas las Secciones';
		}		
		
		// inicializa el array de los totales de las evaluaciones
		if( $idv != 'all' ) {
			$evaluaciones = $this->db->order_by('en_evaluacion.IdEvaluacion','DESC')->get_where('en_evaluacion',array('en_evaluacion.IdEvaluacion' => $idv),1);
		}
		else {
			$evaluaciones = $this->db->order_by('en_evaluacion.IdEvaluacion','DESC')->get_where('en_evaluacion',array('en_evaluacion.IdEncuesta' => $ide),2);
		}
		if( $evaluaciones->num_rows() > 0 ) {
			foreach( $evaluaciones->result() as $row_eva ) {
				$total[$row_eva->IdEvaluacion] = 0;
			}
		}
			
		$alto = 10;
	// Resultados Generales( todas las áreas y todas las secciones)		
		if( $ida == 'all' && $ids == 'all' ) {
			$concepto = 'Areas';
			// Tabla de Resultados
			$tabla_renglones = '';
			$grafica_resultado = '';
			$tabla_footer = '<th style="font-size:11px; color:#FFF; text-align:center">TOTAL</th>';
			if($idv<='22'){
			
				$areas = $this->db->order_by('Area')->not_like('Area','Invitado')->not_like('Area','Coordinacion de Calidad')->not_like('Area','Direccion de Telecomunicaciones e Informatica')->get('ab_areas');
			}else{
				$areas = $this->db->order_by('Area')->not_like('Area','Invitado')->not_like('Area','Coordinacion de Calidad')->get('ab_areas');
			}
			
			if( $areas->num_rows() > 0 ) {
				$i = 1;
				$y = 0;
				$tota_factores = array();
				foreach( $areas->result() as $row_are ) {
					$tabla_header = '<tr><th rowspan="2" style="font-weight:normal; font-size:18px; color:#FFF; text-align:center">&Aacute;rea</th><th colspan="2" style="font-weight:normal; font-size:18px; color:#FFF; text-align:center">Seccion</th><th rowspan="2" style="font-weight:normal; font-size:11px; color:#FFF; text-align:center">Total</th></tr><tr>';
					if( $i ) {
						$tabla_renglones .= '<tr class="odd">';
						$i = 0;
					}
					else {
						$tabla_renglones .= '<tr>';
						$i = 1;
					}
					$tabla_renglones .= '<td style="text-align:left; border-right:1px solid #EEE; font-size:10px">'.$row_are->Area.'</td>';
					$secciones = $this->db->get_where('en_secciones', array('en_secciones.IdEncuesta' => $ide));
					if( $secciones->num_rows() > 0 ) {						
						$total_general = 0;
						$x = 0;
						$factor = array('Valoraci&oacute;n<br />de la Persona','Valoraci&oacute;n<br />de la Persona hacia al Puesto');
						foreach( $secciones->result() as $row_sec ) {							
							// evaluaciones de la encuesta
							$evaluaciones = $this->db->order_by('en_evaluacion.IdEvaluacion','DESC')->get_where('en_evaluacion',array('en_evaluacion.IdEncuesta' => $ide),1);
							if( $evaluaciones->num_rows() > 0 ) {											
								foreach( $evaluaciones->result() as $row_eva ) {						
									$tabla_header .= '<th style="font-weight:normal; font-size:12px; color:#FFF; text-align:center">'.$factor[$x].'</th>';
									// resultados de la seccion y de la evaluacion específica
									$consulta['en_respuestas_desempeno.IdEvaluacion'] = $row_eva->IdEvaluacion;
									$consulta['ab_usuarios.IdArea'] 			  = $row_are->IdArea;
									$consulta['en_preguntas.IdSeccion'] 		  = $row_sec->IdSeccion;
									$this->db->select('SUM(en_opciones.Valor) AS Suma, COUNT(en_opciones.Valor) AS Cuenta');
									$this->db->order_by('en_respuestas_desempeno.IdEvaluacion,en_preguntas.IdSeccion');
									$this->db->group_by('en_preguntas.IdSeccion');
									$this->db->join('ab_usuarios','ab_usuarios.IdUsuario = en_respuestas_desempeno.IdUsuario');
									$this->db->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_desempeno.IdPregunta');						
									$this->db->join('en_opciones','en_opciones.IdOpcion = en_respuestas_desempeno.IdOpcion');
									$resultados = $this->db->get_where('en_respuestas_desempeno',$consulta);
									
									if( $resultados->num_rows() > 0 ) {													
										foreach( $resultados->result() as $row_res ) {
											// el 10 es valor máximo de cada pregunta
											$suma = round( ( $row_res->Suma * 100 ) / ( $row_res->Cuenta * 10 ) * 100) / 100;
											$tabla_renglones .= '<td style="font-size:8px; text-align:center; padding:2px; border-right:1px solid #EEE">'.$suma.'<span style="font-size:6px">%</span></td>';
											$total_general = $total_general + $suma;
											$grafica_resultado .= $suma.'],';
											$total_factores[$x][$y] = $suma;
											
										}
									}
									else {
										$tabla_renglones .= '<td style="text-align:center; font-size:8px; font-style:italic">0</td>';
										
									}						
								}
							}							
							$x++;							
						}						
						$total_general = round( $total_general / $secciones->num_rows() * 100) / 100;
						$tabla_renglones .= '<th style="font-weight:normal; padding:2px; font-size:8px; color:#FFF; text-align:center">'.$total_general.'<span style="font-size:6px">%</span></th>';
						//$total_factores[$x] = array( $y => $total );
					}
					$y++;
					$tabla_renglones .= '</tr>';
				}						
				
				foreach( $total_factores as $tot ) {
					$tf = 0;
					foreach( $tot as $t ) {
						$tf = $tf + $t;						
					}
					$tf = round( $tf / $areas->num_rows() * 100) / 100;
					$tabla_footer .= '<th style="font-weight:normal; padding:2px; font-size:8px; color:#FFF; text-align:center">'.$tf.'<span style="font-size:6px">%</span></th>';
				}
				$tabla_footer .= '<th></th>';
			}
		}
		
	// Resultados generales del área
		if( $ida != 'all' && $ids == 'all') {								
			$concepto = 'Secciones';
			// Tabla de Resultados
			$tabla_renglones = '';
			$grafica_resultado = '';
			$tabla_footer = '<th style="font-size:18px; color:#FFF; text-align:center">TOTAL</th>';
			$secciones = $this->db->get_where('en_secciones', array('en_secciones.IdEncuesta' => $ide));
			if( $secciones->num_rows() > 0 ) {
				$i = 1;
				foreach( $secciones->result() as $row_sec ) {
					$alto = $alto + 30;
					$tabla_header = '<tr><th style="font-weight:normal; font-size:18px; color:#FFF; text-align:center">Secci&oacute;n</th>';
					if( $i ) {
						$tabla_renglones .= '<tr class="odd">';
						$i = 0;
					}
					else {
						$tabla_renglones .= '<tr>';
						$i = 1;
					}				
					$tabla_renglones .= '<td>'.$row_sec->Seccion.'</td>';
					$grafica_resultado .= '["'.$row_sec->Seccion.'",';
					// evaluaciones de la encuesta
					if( $evaluaciones->num_rows() > 0 ) {					
						foreach( $evaluaciones->result() as $row_eva ) {						
							$tabla_header .= '<th style="font-weight:normal; font-size:18px; color:#FFF; text-align:center">'.$row_eva->Nombre.'</th>';						
							// resultados de la seccion y de la evaluacion específica
							$consulta['en_respuestas_desempeno.IdEvaluacion'] = $row_eva->IdEvaluacion;
							$consulta['en_preguntas.IdSeccion'] 	= $row_sec->IdSeccion;
							$this->db->select('SUM(en_opciones.Valor) AS Suma, COUNT(en_opciones.Valor) AS Cuenta');						
							$this->db->order_by('en_respuestas_desempeno.IdEvaluacion,en_preguntas.IdSeccion');
							$this->db->group_by('en_preguntas.IdSeccion');
							$this->db->join('ab_usuarios','ab_usuarios.IdUsuario = en_respuestas_desempeno.IdUsuario');
							$this->db->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_desempeno.IdPregunta');						
							$this->db->join('en_opciones','en_opciones.IdOpcion = en_respuestas_desempeno.IdOpcion');
							$resultados = $this->db->get_where('en_respuestas_desempeno',$consulta);
							if( $resultados->num_rows() > 0 ) {													
								foreach( $resultados->result() as $row_res ) {
									// el 10 es valor máximo de cada pregunta															
									$suma = round( ( $row_res->Suma * 100 ) / ( $row_res->Cuenta * 10 ) * 100) / 100;								
									$tabla_renglones .= '<td style="text-align:center">'.$suma.'%</td>';
									$total[$row_eva->IdEvaluacion] = $total[$row_eva->IdEvaluacion] + $suma;
									$grafica_resultado .= $suma.',';
								}
							}
							else {
								$tabla_renglones .= '<td style="text-align:center; font-size:11px; font-style:italic">0</td>';
								$grafica_resultado .= '0,';
							}						
						}
						$grafica_resultado .= '],';
					}
					$tabla_renglones .= '</tr>';
				}
				foreach( $total as $t ) {
					$total_numero = round( $t / $secciones->num_rows() * 100) / 100;
					$tabla_footer .= '<th style="font-weight:normal; font-size:18px; color:#FFF; text-align:center">'.$total_numero.'%</th>';
				}
			}
		}

	// Resultados generales de una seccion
		if( $ida == 'all' && $ids != 'all' ) {
			$concepto = 'Areas';
			$alto = '300';
			$alto_grafica = '200';
			// Tabla de Resultados
			$tabla_renglones = '';
			$grafica_resultado = '';
			$tabla_footer = '<th style="font-size:18px; color:#FFF; text-align:center">TOTAL</th>';
			$areas = $this->db->order_by('Area')->not_like('Area','Invitado')->not_like('Area','Coordinación de Calidad')->get('ab_areas');
			if( $areas->num_rows() > 0 ) {
				$i = 1;
				foreach( $areas->result() as $row_are ) {
					$alto = $alto + 50;
					$tabla_header = '<tr><th style="font-weight:normal; font-size:18px; color:#FFF; text-align:center">Secci&oacute;n</th>';
					if( $i ) {
						$tabla_renglones .= '<tr class="odd">';
						$i = 0;
					}
					else {
						$tabla_renglones .= '<tr>';
						$i = 1;
					}				
					$tabla_renglones .= '<td>'.$row_are->Area.'</td>';
					$grafica_resultado .= '["'.$row_are->Area.'",';
					// evaluaciones de la encuesta
					if( $evaluaciones->num_rows() > 0 ) {					
						foreach( $evaluaciones->result() as $row_eva ) {						
							$tabla_header .= '<th style="font-weight:normal; font-size:18px; color:#FFF; text-align:center">'.$row_eva->Nombre.'</th>';						
							// resultados de la seccion y de la evaluacion específica
							$consulta['en_respuestas_desempeno.IdEvaluacion'] = $row_eva->IdEvaluacion;
							$consulta['ab_usuarios.IdArea']				  = $row_are->IdArea;
							$this->db->select('SUM(en_opciones.Valor) AS Suma, COUNT(en_opciones.Valor) AS Cuenta');						
							$this->db->order_by('en_respuestas_desempeno.IdEvaluacion,en_preguntas.IdSeccion');
							$this->db->group_by('en_preguntas.IdSeccion');
							$this->db->join('ab_usuarios','ab_usuarios.IdUsuario = en_respuestas_desempeno.IdUsuario');
							$this->db->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_desempeno.IdPregunta');						
							$this->db->join('en_opciones','en_opciones.IdOpcion = en_respuestas_desempeno.IdOpcion');
							$resultados = $this->db->get_where('en_respuestas_desempeno',$consulta);
							if( $resultados->num_rows() > 0 ) {													
								foreach( $resultados->result() as $row_res ) {
									// el 10 es valor máximo de cada pregunta															
									$suma = round( ( $row_res->Suma * 100 ) / ( $row_res->Cuenta * 10 ) * 100) / 100;
									$tabla_renglones .= '<td style="text-align:center">'.$suma.'%</td>';
									$total[$row_eva->IdEvaluacion] = $total[$row_eva->IdEvaluacion] + $suma;
									$grafica_resultado .= $suma.',';
									
								}
							}
							else {
								$tabla_renglones .= '<td style="text-align:center; font-size:11px; font-style:italic">0</td>';
								$grafica_resultado .= '0,';
							}
						}
						$grafica_resultado .= '],';
					}
					$tabla_renglones .= '</tr>';
				}
				foreach( $total as $t ) {
					$total_numero = round( $t / $areas->num_rows() * 100) / 100;
					$tabla_footer .= '<th style="font-weight:normal; font-size:18px; color:#FFF; text-align:center">'.$total_numero.'%</th>';
				}
			}
		}
		
	// Resultados de un área y de una sección
		if( $ida != 'all' && $ids != 'all' ) {
			$concepto = 'Area';
			$alto = '300';
			$alto_grafica = '200';
			// Tabla de Resultados
			$tabla_renglones = '';
			$grafica_resultado = '';
			$tabla_footer = '';			
			$areas = $this->db->order_by('Area')->not_like('Area','Invitado')->not_like('Area','Coordinación de Calidad')->get_where('ab_areas',array('IdArea' => $ida));
			if( $areas->num_rows() > 0 ) {
				$alto = $alto + 80;
				$i = 1;
				foreach( $areas->result() as $row_are ) {				
					$tabla_header = '<tr><th style="font-weight:normal; font-size:18px; color:#FFF; text-align:center">Secci&oacute;n</th>';
					if( $i ) {
						$tabla_renglones .= '<tr class="odd">';
						$i = 0;
					}
					else {
						$tabla_renglones .= '<tr>';
						$i = 1;
					}				
					$tabla_renglones .= '<td>'.$row_are->Area.'</td>';
					$grafica_resultado .= '["'.$row_are->Area.'",';
					// evaluaciones de la encuesta
					if( $evaluaciones->num_rows() > 0 ) {					
						foreach( $evaluaciones->result() as $row_eva ) {						
							$tabla_header .= '<th style="font-weight:normal; font-size:18px; color:#FFF; text-align:center">'.$row_eva->Nombre.'</th>';						
							// resultados de la seccion y de la evaluacion específica
							$consulta['en_respuestas_desempeno.IdEvaluacion'] = $row_eva->IdEvaluacion;
							$consulta['ab_usuarios.IdArea']				  = $row_are->IdArea;
							$this->db->select('SUM(en_opciones.Valor) AS Suma, COUNT(en_opciones.Valor) AS Cuenta');						
							$this->db->order_by('en_respuestas_desempeno.IdEvaluacion,en_preguntas.IdSeccion');
							$this->db->group_by('en_preguntas.IdSeccion');
							$this->db->join('ab_usuarios','ab_usuarios.IdUsuario = en_respuestas_desempeno.IdUsuario');
							$this->db->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_desempeno.IdPregunta');						
							$this->db->join('en_opciones','en_opciones.IdOpcion = en_respuestas_desempeno.IdOpcion');
							$resultados = $this->db->get_where('en_respuestas_desempeno',$consulta);
							if( $resultados->num_rows() > 0 ) {													
								foreach( $resultados->result() as $row_res ) {
									
									// el 10 es valor máximo de cada pregunta															
									$suma = round( ( $row_res->Suma * 100 ) / ( $row_res->Cuenta * 10 ) * 100) / 100;
															
									$tabla_renglones .= '<td style="text-align:center">'.$suma.'%</td>';
									$grafica_resultado .= $suma.',';
									
								}
							}
							else {
								$tabla_renglones .= '<td style="text-align:center; font-size:11px; font-style:italic">0</td>';
								$grafica_resultado .= '0,';
							}						
						}
						$grafica_resultado .= '],';
					}
					$tabla_renglones .= '</tr>';
				}
			}
		}
				
		// se llena la tabla con la información
		$datos['tabla'] = '<table class="tabla_form" width="700">'.$tabla_header.'</th>'.$tabla_renglones.'<tr>'.$tabla_footer.'</tr></table>';
				
		// Gráfica
		$num_porcentaje = '';
		foreach( $total as $t )
			$num_porcentaje .= 'data.addColumn("number", "Porcentaje");';
		$alto_canvas = $alto + 100;
		$datos['grafica'] = '
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">			
			  google.load("visualization", "1.0", {"packages":["corechart"]});			  			 
			  google.setOnLoadCallback(drawChart);			  
			  function drawChart() {		
			  var data = new google.visualization.DataTable();
			  data.addColumn("string", "'.$concepto.'");
			  '.$num_porcentaje.'
			  data.addRows(['.$grafica_resultado.']);
			  var options = {
				  width: 700,
				  height: '.$alto_canvas.',
				  fontSize: "12",
				  fontName: "Arial",
				  legend: "none",
				  vAxis: { title: "'.$concepto.'", titleTextStyle: { fontSize: "18", fontName: "Tahoma" } },
				  hAxis: {
				  	title: "Porcentaje de Avance",
				  	viewWindowMode: "pretty",
				  	format:"#\'%\'",
				  	titleTextStyle: {
				  		fontSize: "18",
				  		fontName: "Arial" 
					},					 
					 viewWindowMode: "explicit",
					 viewWindow: {
						 min: 1,
						 max: 100
					 } 
				  },
				  chartArea: { top: 30, left: 100, width: 700, height: '.$alto.' },
				  tooltipTextStyle: { fontSize: "16" },
			  };
			  
			  var formatter = new google.visualization.NumberFormat({suffix: "%",fractionDigits: 0});
			  formatter.format(data, 1); // Apply formatter to second column
  
			  var chart = new google.visualization.BarChart(document.getElementById("chart_div"));
			  chart.draw(data, options);
			}
			</script>
            <div id="chart_div"></div>
		';
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('evaluaciones/desempeno/grafica',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
}

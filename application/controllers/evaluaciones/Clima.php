<?php 
/****************************************************************************************************
*
*	CONTROLLERS/evaluaciones/clima.php
*
*		Descripción:
*			Evaluación al Clima Laboral 
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

class Clima extends CI_Controller {
	
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
			$this->load->model('evaluaciones/clima_model','',TRUE);
			$this->set_id( 1 );
			$this->set_nom( 'clima' );
			$this->set_nombre( 'Evaluaci&oacute;n al Clima Laboral' );
		}
	}
	
/** Funciones **/	
	//
	// index(): Inicio
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
		$ide = $this->id_evaluacion;		
		
		// Revisa si ya se termino de realizar la evaluación y obtiene el personal faltante de contestar
		$datos['grafica'] = true;		
		$datos['preguntas'] = true;
		
		$resp = true;
		$encuesta = $this->db->order_by('en_evaluacion.Fecha','DESC')->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta')->get_where('en_encuestas',array('en_encuestas.IdEncuesta' => $ide, 'Estado' => '1'),1);
		if( $encuesta->num_rows() > 0 ) {
			foreach( $encuesta->result() as $row ) {
				// evaluacion	
				$preguntas = $this->db->get_where('en_preguntas', array('en_preguntas.IdEncuesta' => $ide));
				$respuestas = $this->db->get_where('en_respuestas_clima', array('en_respuestas_clima.IdUsuario' => $this->session->userdata('id_usuario'), 'en_respuestas_clima.IdEvaluacion' => $row->IdEvaluacion));
				if( $preguntas->num_rows() <= $respuestas->num_rows() )
					$resp = false;

				// preguntas de la encuesta
				$preguntas = $this->db->get_where('en_preguntas', array('en_preguntas.IdEncuesta' => $ide));
				
				// obtiene el listado del personal del área
				//$personal = $this->db->get_where('ab_usuarios', array('ab_usuarios.IdArea' => $this->session->userdata('id_area'), 'ab_usuarios.Estado' => 1, 'ab_usuarios.Nombre NOT LIKE' => '%AUDITOR%', 'ab_usuarios.IdUsuario <>' => $this->clima_model->get_jefe()));
				$personal = $this->clima_model->get_usuarios();
				if( $personal->num_rows() > 0 ) {
					$j = 0;
					$porcentaje_total = 0;
					foreach( $personal->result() as $row_u ) {
						$respuestas = $this->db->get_where('en_respuestas_clima', array('en_respuestas_clima.IdUsuario' => $row_u->IdUsuario, 'en_respuestas_clima.IdEvaluacion' => $row->IdEvaluacion));
						$porcentaje = round( ( ($respuestas->num_rows() * 100 ) / $preguntas->num_rows() ) * 100 ) / 100;								
						$porcentaje_total = $porcentaje_total + $porcentaje;
						$j++;  
					}
				}
				
				if( $j )
					$datos['total'] = round($porcentaje_total / $j);
				else
					$datos['porcentaje_avance'] = 0;
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

				// si ya no tiene nada que evaluar
				if( !$resp || $this->session->userdata('JEF') ){
					$datos['evalua'] = false;
				}
			}
		}
		else {
			$datos['evalua'] = false;
		}	
				
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
		$main = '';
		
		// Información de la evaluación
		$encuesta = $this->db->order_by('en_evaluacion.IdEvaluacion','DESC')->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta')->get_where('en_encuestas',array('en_encuestas.IdEncuesta' => $ide, 'en_evaluacion.Estado' => '1'),1);
		if( $encuesta->num_rows() > 0 ) {
			foreach( $encuesta->result() as $row ) {
				$idv = $row->IdEvaluacion;				
				$datos['nombre'] = $row->Nombre;
				$main .= '<table class="tabla" width="700"><tr><td>'.$row->Presentacion.'<td></tr></table><br />';
			}
		}
		
		$consulta = $this->db->join('en_secciones','en_secciones.IdEncuesta = en_encuestas.IdEncuesta')->get_where('en_encuestas',array('en_encuestas.IdEncuesta' => $ide));
		if( $consulta->num_rows() > 0 ) {
			$main .= '<table class="tabla" width="700">';
			$resp = false;								
			$i = 0;
			
			// agrega las secciones a contestar de la encuesta
			foreach( $consulta->result() as $row ) :
				$preguntas = $this->db->get_where('en_preguntas', array('en_preguntas.IdSeccion' => $row->IdSeccion));
				$respuestas = $this->db->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_clima.IdPregunta')->get_where('en_respuestas_clima', array('en_preguntas.IdSeccion' => $row->IdSeccion, 'en_respuestas_clima.IdUsuario' => $this->session->userdata('id_usuario'), 'en_respuestas_clima.IdEvaluacion' => $idv, 'en_respuestas_clima.IdUsuario' => $this->session->userdata('id_usuario') ));
				
				// revisa las secciones que ya se contestaron						
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
					$main .= '<th width="15"><a href="'.base_url().'index.php/evaluaciones/clima/contestar/'.$row->IdSeccion.'/'.$idv.'" onmouseover="tip(\'Click para contestar esta secci&oacute;n\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/seguimiento.png" /></a></th><td><a href="'.base_url().'index.php/evaluaciones/clima/contestar/'.$row->IdSeccion.'/'.$idv.'" onmouseover="tip(\'Click para contestar esta secci&oacute;n\')" onmouseout="cierra_tip()" style="color:#333">'.$row->Seccion.'</a></td></tr>';
				}
			endforeach;
					
			// si ya no hay secciones para contestar
			if( !$resp || $this->session->userdata('JEF') )
				redirect('evaluaciones/clima/index/termino');
					
			$main .= '</table>';
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
		
		// obtiene la info de la encuesta
		$encuesta = $this->db->join('en_encuestas','en_encuestas.IdEncuesta = en_preguntas.IdEncuesta')->join('en_secciones','en_secciones.IdSeccion = en_preguntas.IdSeccion')->get_where('en_preguntas',array('en_preguntas.IdSeccion' => $ids),1);
		if( $encuesta->num_rows() > 0 ) {								
			// obtiene las opciones de cada pregunta			
			foreach( $encuesta->result() as $row ) {
				$datos['titulo_seccion'] = $row->Seccion;
				$arreglo = array();
				// obtiene las preguntas que no se han contestado de la sección
				$preguntas = $this->db->get_where('en_preguntas',array( 'IdSeccion' => $ids, 'IdEncuesta' => $ide ));
				if( $preguntas->num_rows() > 0 ) {							
					foreach( $preguntas->result() as $row_p ) {
						$contestada = true;
						$respuestas = $this->db->get_where('en_respuestas_clima',array( 'IdEvaluacion' => $idv, 'IdUsuario' => $this->session->userdata('id_usuario') ));
						if( $respuestas->num_rows() > 0 ) {
							foreach( $respuestas->result() as $row_r ) {
								// pregunta si ya se contesto la pregunta
								if( $row_p->IdPregunta == $row_r->IdPregunta ) {
									$contestada = false;
								}
							}
							// si no se ha contestado la pregunta por este usuario, la muestra
							if( $contestada ) {
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
						else {
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
		$this->load->view('evaluaciones/clima/contestar',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
		
		$resp = false;
		// Guarda las Respuestas
		if( $_POST ) {
			$preguntas = $this->db->get_where('en_preguntas',array('IdSeccion' => $ids));
			if( $preguntas->num_rows() > 0 ) {
				$i = 0;
				$inserta = array();
				foreach( $preguntas->result() as $row ) :
					if ( $this->input->post('pregunta_'.$row->IdPregunta) ) { 
						$inserta[$i] = array(
							'IdEvaluacion' 	=> $idv,
							'IdOpcion'	 	=> $this->input->post('pregunta_'.$row->IdPregunta),
							'IdPregunta' 	=> $row->IdPregunta,
							'IdUsuario' 	=> $this->session->userdata('id_usuario'),
						);
					}
					$i++;
				endforeach;
				if ( $inserta )
					$resp = $this->db->insert_batch('en_respuestas_clima', $inserta); 
				if( $resp ) {
					// msj de éxito
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "Tus respuestas se han guardado correctamente";
					$datos['enlace'] = "evaluaciones/clima/presentacion/";
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
		$id = $this->id_evaluacion;
				
		// Preguntas
		$datos['preguntas'] = $this->clima_model->get_preguntas( $id );
		
		// Secciones
		$datos['secciones'] = $this->clima_model->get_secciones( $id );
		
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
		$id = $this->id_evaluacion;
		
		// Obtiene la evaluación actual
		$encuesta = $this->clima_model->get_evaluacion( $id );
		if( $encuesta->num_rows() > 0 ) {
			foreach( $encuesta->result() as $row ) {
				$i = 0;
				$listado = array();
							
				// obtiene las preguntas de la encuesta
				$preguntas = $this->clima_model->get_preguntas( $id );
				
				// obtiene el listado del personal del área sin el jefe porque no contesta
				$personal = $this->clima_model->get_usuarios();
				if( $personal->num_rows() > 0 ) {
					foreach( $personal->result() as $row_u ) {
						$respuestas = $this->clima_model->get_respuestas( $row_u->IdUsuario, $row->IdEvaluacion );
						$porcentaje = round( ( ($respuestas->num_rows() * 100 ) / $preguntas->num_rows() ) * 100 ) / 100;								
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
		else {
			redirect( 'evaluaciones/clima' );
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
		$id = $this->id_evaluacion;
		
		// Información de la encuesta
		$encuesta = $this->db->order_by('en_evaluacion.IdEvaluacion','DESC')->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta')->get_where('en_encuestas',array('en_encuestas.IdEncuesta' => $id),1);
		if( $encuesta->num_rows() > 0 ) {
			foreach( $encuesta->result() as $row ) {			
				$datos['titulo'] = $row->Encuesta;
				$datos['titulo_encuesta'] = "Gr&aacute;ficas de Resultados: ".$row->Encuesta;				
			}
		}		
		
		// Evaluaciones
		$evaluaciones = $this->db->order_by('IdEvaluacion', 'DESC')->get_where('en_evaluacion', array('IdEncuesta' => $id));
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
		$sec = $this -> db -> order_by('IdSeccion') -> get_where('en_secciones', array('IdEncuesta' => $id));
		if ($sec -> num_rows() > 0) {
			$datos['sec'] = array();
			$datos['sec']['all'] = " - Todas las Secciones - ";
			foreach ($sec->result() as $row) {
				$datos['sec'][$row -> IdSeccion] = $row -> Seccion;
			}
		}

		// Muestra la gráfica
		if( $_POST ) {
			$this->grafica( $id, $this->input->post('area'), $this->input->post('seccion'), $this->input->post('evaluacion'));
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
		
		// Información de la encuesta
		$encuesta = $this->db->order_by('en_evaluacion.IdEvaluacion','DESC')->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta')->get_where('en_encuestas',array('en_encuestas.IdEncuesta' => $ide),1);
		if( $encuesta->num_rows() > 0 ) {
			foreach( $encuesta->result() as $row ) {			
				$datos['titulo'] = $row->Encuesta;
				$datos['titulo_encuesta'] = "Gr&aacute;ficas de Resultados: ".$row->Encuesta;				
			}
		}
		
		$consulta = array();
		
		
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
			$alto = '600';
			$alto_grafica = '600';
			// Tabla de Resultados
			$tabla_renglones = '';
			$grafica_resultado = '';
			$tabla_footer = '<th style="font-size:11px; color:#FFF; text-align:center">TOTAL</th>';
			$areas = $this->db->order_by('Area')->not_like('Area','Invitado')->not_like('Area','Coordinación de Calidad')->get('ab_areas');
			if( $areas->num_rows() > 0 ) {
				$i = 1;
				$y = 0;
				$tota_factores = array();
				foreach( $areas->result() as $row_are ) {
					$tabla_header = '<tr><th rowspan="2" style="font-weight:normal; font-size:18px; color:#FFF; text-align:center">&Aacute;rea</th><th colspan="16" style="font-weight:normal; font-size:18px; color:#FFF; text-align:center">Factores</th><th rowspan="2" style="font-weight:normal; font-size:11px; color:#FFF; text-align:center">Total</th></tr><tr>';
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
						$factor = array('I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XI','XIII','XIV','XV','XVI');
						foreach( $secciones->result() as $row_sec ) {							
							// evaluaciones de la encuesta	
							if( $idv != 'all' ) {
								$evaluaciones = $this->db->order_by('en_evaluacion.IdEvaluacion','DESC')->get_where('en_evaluacion',array('en_evaluacion.IdEvaluacion' => $idv),1);
							}
							else {
								$evaluaciones = $this->db->order_by('en_evaluacion.IdEvaluacion','DESC')->get_where('en_evaluacion',array('en_evaluacion.IdEncuesta' => $ide),1);
							}
							if( $evaluaciones->num_rows() > 0 ) {											
								foreach( $evaluaciones->result() as $row_eva ) {						
									$tabla_header .= '<th style="font-weight:normal; font-size:12px; color:#FFF; text-align:center">'.$factor[$x].'</th>';
									// resultados de la seccion y de la evaluacion específica
									$consulta['en_respuestas_clima.IdEvaluacion'] = $row_eva->IdEvaluacion;
									$consulta['ab_usuarios.IdArea'] 			  = $row_are->IdArea;
									$consulta['en_preguntas.IdSeccion'] 		  = $row_sec->IdSeccion;									
									$this->db->select('SUM(en_opciones.Valor) AS Suma, COUNT(en_opciones.Valor) AS Cuenta');						
									$this->db->order_by('en_respuestas_clima.IdEvaluacion,en_preguntas.IdSeccion');
									$this->db->group_by('en_preguntas.IdSeccion');
									$this->db->join('ab_usuarios','ab_usuarios.IdUsuario = en_respuestas_clima.IdUsuario');
									$this->db->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_clima.IdPregunta');						
									$this->db->join('en_opciones','en_opciones.IdOpcion = en_respuestas_clima.IdOpcion');
									$resultados = $this->db->get_where('en_respuestas_clima',$consulta);
									if( $resultados->num_rows() > 0 ) {													
										foreach( $resultados->result() as $row_res ) {
											// el 5 es valor máximo de cada pregunta															
											$suma = round( ( $row_res->Suma * 100 ) / ( $row_res->Cuenta * 5 ) * 100) / 100;								
											$tabla_renglones .= '<td style="font-size:8px; text-align:center; padding:2px; border-right:1px solid #EEE">'.$suma.'<span style="font-size:6px">%</span></td>';
											$total_general = $total_general + $suma;
											$grafica_resultado .= $suma.'],';
											$total_factores[$x][$y] = $suma;
										}
									}
									else {
										$tabla_renglones .= '<td style="text-align:center; font-size:8px; font-style:italic">0</td>';
										$grafica_resultado .= '0],';
										$total_factores[$x][$y] = '0';
									}						
								}
							}							
							$x++;							
						}						
						$total_general = round( $total_general / $secciones->num_rows() * 100) / 100;
						$tabla_renglones .= '<th style="font-weight:normal; padding:2px; font-size:8px; color:FFF; text-align:center">'.$total_general.'<span style="font-size:6px">%</span></th>';
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
			$total_numero = 0;
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
					$grafica_resultado .= '["'.substr($row_sec->Seccion,6).'",';
					// evaluaciones de la encuesta
					if( $evaluaciones->num_rows() > 0 ) {					
						foreach( $evaluaciones->result() as $row_eva ) {
							$tabla_header .= '<th style="font-weight:normal; font-size:18px; color:#FFF; text-align:center">'.$row_eva->Nombre.'</th>';						
							// resultados de la seccion y de la evaluacion específica
							$consulta['en_respuestas_clima.IdEvaluacion'] = $row_eva->IdEvaluacion;
							$consulta['en_preguntas.IdSeccion'] 	= $row_sec->IdSeccion;
							$this->db->select('SUM(en_opciones.Valor) AS Suma, COUNT(en_opciones.Valor) AS Cuenta');						
							$this->db->order_by('en_respuestas_clima.IdEvaluacion,en_preguntas.IdSeccion');
							$this->db->group_by('en_preguntas.IdSeccion');
							$this->db->join('ab_usuarios','ab_usuarios.IdUsuario = en_respuestas_clima.IdUsuario');
							$this->db->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_clima.IdPregunta');						
							$this->db->join('en_opciones','en_opciones.IdOpcion = en_respuestas_clima.IdOpcion');
							$resultados = $this->db->get_where('en_respuestas_clima',$consulta);
							if( $resultados->num_rows() > 0 ) {
								foreach( $resultados->result() as $row_res ) {
									// el 5 es valor máximo de cada pregunta															
									$suma = round( ( $row_res->Suma * 100 ) / ( $row_res->Cuenta * 5 ) * 100) / 100;								
									$tabla_renglones .= '<td style="text-align:center">'.$suma.'%</td>';
									$total[$row_eva->IdEvaluacion] = $total[$row_eva->IdEvaluacion] + $suma;
									$grafica_resultado .= $suma.',';
								}
							}
							else {
								$tabla_renglones .= '<td style="text-align:center; font-size:11px; font-style:italic">sin resultados por el momento</td>';
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
			// Tabla de Resultados
			$tabla_renglones = '';
			$total_numero = 0;
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
							$consulta['en_respuestas_clima.IdEvaluacion'] = $row_eva->IdEvaluacion;
							$consulta['ab_usuarios.IdArea']				  = $row_are->IdArea;
							$this->db->select('SUM(en_opciones.Valor) AS Suma, COUNT(en_opciones.Valor) AS Cuenta');						
							$this->db->order_by('en_respuestas_clima.IdEvaluacion,en_preguntas.IdSeccion');
							$this->db->group_by('en_preguntas.IdSeccion');
							$this->db->join('ab_usuarios','ab_usuarios.IdUsuario = en_respuestas_clima.IdUsuario');
							$this->db->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_clima.IdPregunta');						
							$this->db->join('en_opciones','en_opciones.IdOpcion = en_respuestas_clima.IdOpcion');
							$resultados = $this->db->get_where('en_respuestas_clima',$consulta);
							if( $resultados->num_rows() > 0 ) {													
								foreach( $resultados->result() as $row_res ) {
									// el 5 es valor máximo de cada pregunta															
									$suma = round( ( $row_res->Suma * 100 ) / ( $row_res->Cuenta * 5 ) * 100) / 100;								
									$tabla_renglones .= '<td style="text-align:center">'.$suma.'%</td>';
									$total[$row_eva->IdEvaluacion] = $total[$row_eva->IdEvaluacion] + $suma;
									$grafica_resultado .= $suma.',';
								}
							}
							else {
								$tabla_renglones .= '<td style="text-align:center; font-size:11px; font-style:italic">sin resultados por el momento</td>';
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
			// Tabla de Resultados
			$tabla_renglones = '';
			$grafica_resultado = '';
			$tabla_footer = '';			
			$areas = $this->db->order_by('Area')->not_like('Area','Invitado')->not_like('Area','Coordinación de Calidad')->get_where('ab_areas',array('IdArea' => $ida));
			if( $areas->num_rows() > 0 ) {
				$i = 1;
				foreach( $areas->result() as $row_are ) {
					$alto = $alto + 80;				
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
							$consulta['en_respuestas_clima.IdEvaluacion'] = $row_eva->IdEvaluacion;
							$consulta['ab_usuarios.IdArea']				  = $row_are->IdArea;
							$this->db->select('SUM(en_opciones.Valor) AS Suma, COUNT(en_opciones.Valor) AS Cuenta');						
							$this->db->order_by('en_respuestas_clima.IdEvaluacion,en_preguntas.IdSeccion');
							$this->db->group_by('en_preguntas.IdSeccion');
							$this->db->join('ab_usuarios','ab_usuarios.IdUsuario = en_respuestas_clima.IdUsuario');
							$this->db->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_clima.IdPregunta');						
							$this->db->join('en_opciones','en_opciones.IdOpcion = en_respuestas_clima.IdOpcion');
							$resultados = $this->db->get_where('en_respuestas_clima',$consulta);
							if( $resultados->num_rows() > 0 ) {													
								foreach( $resultados->result() as $row_res ) {
									// el 5 es valor máximo de cada pregunta															
									$suma = round( ( $row_res->Suma * 100 ) / ( $row_res->Cuenta * 5 ) * 100) / 100;								
									$tabla_renglones .= '<td style="text-align:center">'.$suma.'%</td>';
									$grafica_resultado .= $suma.',';
								}
							}
							else {
								$tabla_renglones .= '<td style="text-align:center; font-size:11px; font-style:italic">sin resultados por el momento</td>';
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
		$this->load->view('evaluaciones/clima/grafica',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
}
<?php 
/****************************************************************************************************
*
*	CONTROLLERS/admin_files/evaluaciones.php
*
*		Descripción:
*			Controlador de las acciones de las evaluaciones
*
*		Fecha de Creación:
*			30/Octubre/2011
*
*		Ultima actualización:
*			9/Febrero/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			HERE (http://www.webHERE.com.mx)
*			rogeliocas@gmail.com
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evaluaciones extends CI_Controller {
	
/** Atributos **/
	private $menu;
	private $barra;

/** Propiedades **/
	public function set_menu() {
		$this->menu = $this->inicio_admin_model->get_menu( 'evaluaciones' );
	}
	
	public function get_barra( $enlace, $titulo ) {
		return $this->barra = '		
			<a href="'.base_url().'index.php/admin/inicio">Inicio</a>
			<img src="'.base_url().'includes/img/arrow_right.png"/>
			<a href="'.base_url().'index.php/admin/evaluaciones/'.$enlace.'">'.$titulo.'</a>
		';
	}
		
/** Constructor **/	
	function __construct() {
		parent::__construct();
		
		// validacion de administrador
		if ( $this->session->userdata('id_usuario') ) {
			if ( !$this->session->userdata('admin') ) {
				redirect('admin/inicio/login');
			}
			else {
				$this->load->model('admin/inicio_admin_model','',TRUE);
				$this->load->model('admin/evaluaciones_admin_model','',TRUE);
				$this->set_menu();
			}
		}
		else {
			redirect( 'inicio' );
		}
	}
	/** Funciones **/
	//
	// iniciar(): Inicia una evaluación
	//
	function iniciar() {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Iniciar Evaluaci&oacute;n';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$datos['barra'] = $this->get_barra( 'iniciar', $titulo );
						
		// obtiene todas las encuestas
		$encuestas = $this->db->order_by('Encuesta', 'DESC')->get_where('en_encuestas');
		if( $encuestas->num_rows() > 0 ) {
			$datos['encuesta_options'] = array();			
			foreach( $encuestas->result() as $row ) $datos['encuesta_options'][$row->IdEncuesta] = $row->Encuesta;
		}
		
		$evaluaciones = $this->db->get_where('en_evaluacion',array('Estado' => '1'));
		
		$ev = true;	
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/evaluaciones/iniciar',$datos);
		$this->load->view('admin/_estructura/footer');
		// inserta la nueva evaluación
		if( $_POST ){
			// valida que no exista ya una evaluación activa de la misma encuesta
			if( $evaluaciones->num_rows() > 0 ) {
				foreach( $evaluaciones->result() as $row ) {
					if( $row->IdEncuesta == $this->input->post('encuesta') )
						$ev = false;
				}
			}
			else {
				$ev = true;
			}
		
			if( $ev ) {
				$inserta = array(
					'IdEncuesta' 	=> $this->input->post('encuesta'),
					'Nombre'	 	=> $this->input->post('nombre'), 
					'Fecha'		 	=> $this->input->post('fecha'),
					'Observaciones'	=> $this->input->post('observaciones'),
					'Estado'		=> '1', //evaluación activa
				);
				$resp = 1; 
				$this->db->insert('en_evaluacion',$inserta);

				if( $resp ) {
					// msj de éxito
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "La evaluaci&oacute;n se ha iniciado, ahora los usuarios podra contestarla";
					$datos['encuesta'] = $this->input->post('encuesta');
					$datos['nombre'] = $this->input->post('nombre');
					$datos['fecha'] = $this->input->post('fecha');
					$datos['observaciones'] = $this->input->post('observaciones');
					$datos['jefes'] = $this->inicio_admin_model->jefesc();
					$this->load->view("admin/correos/enviar", $datos);
					$datos['enlace'] = "admin/evaluaciones/listado";
					$this->load->view('mensajes/ok_redirec',$datos);
				}
				else {
					// msj de error
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error al guardar, por favor intentalo de nuevo";
					$this->load->view('mensajes/error',$datos);	
				}
			}
			else{
				// msj de error
				$datos['mensaje_titulo'] = "Error de Validaci&oacute;n";
				$datos['mensaje'] = "Solo puede haber una evaluaci&oacute;n activa de cada encuesta.<br />En este momento ya existe una activa";
				$datos['enlace'] = "admin/evaluaciones/listado";
				$this->load->view('mensajes/ok_redirec',$datos);
			}
		}
	}
	
	//
	// listado(): Listado de las evaluaciones
	//
	function listado() {
		// si los datos han sido enviados por post se sobre escribe la variable $ide
		if( $_POST ) {
			$edo = $this->input->post('estado');
		}
		else {
			if( $this->uri->segment(4) ) {
				$edo = $this->uri->segment(4);
			}
			else {
				$edo = "activas";
			}
		}
		$datos['estado'] = $edo;
		
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Listado de Evaluaciones';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$datos['barra'] = $this->get_barra( 'listado', $titulo );
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();		

		// obtiene todas las evaluaciones para validar si se puede activar alguna
		$datos['evaluaciones_all'] = $this->db->get_where('en_evaluacion',array('Estado' => '1'));
				
		if( $edo == 'todos') {
			$datos['evaluaciones'] = $this->db->join('en_encuestas','en_encuestas.IdEncuesta = en_evaluacion.IdEncuesta')->get('en_evaluacion');
		}
		else {
			switch( $edo ) {
				case 'activas' :
					$estado = '1';
					break;
					
				case 'inactivas' :
					$estado = '0';
					break;
					
				default :
					$estado = 'error';
					break;
			}
			$datos['evaluaciones'] = $this->db->join('en_encuestas','en_encuestas.IdEncuesta = en_evaluacion.IdEncuesta')->get_where('en_evaluacion', array('Estado'=> $estado ));
		}
			
		// estructura de la página
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/evaluaciones/listado',$datos);
		$this->load->view('admin/_estructura/footer');
	}




























/**8**/
	//
	// modificar(): Modifica los datos de una evaluación
	//
	function modificar( $idv ) {
		$datos['titulo'] = "Modificar Evaluaci&oacute;n";
		$datos['menu'] = $this->menu;
		$datos['barra'] = '<a href="'.base_url().'index.php/admin_files/adminInicio">Inicio</a> <img src="'.base_url().'includes/img/arrow_right.png"/> <a href="'.base_url().'index.php/admin_files/evaluaciones/modificar">'.$datos['titulo'].'</a>';

		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
						
		$evaluacion = $this->db->join('en_encuestas','en_encuestas.IdEncuesta = en_evaluacion.IdEncuesta')->get_where('en_evaluacion',array('IdEvaluacion' => $idv));
		if( $evaluacion->num_rows() > 0 ) {
			foreach( $evaluacion->result() as $row ) {
				$datos['fec'] = $row->Fecha;
				$datos['obs'] = $row->Observaciones;
				$datos['enc'] = $row->Encuesta;
			}
		}
				
		// inserta la nueva evaluación
		if( $_POST ){			
			$actualiza = array(				
				'Fecha'		 	=> $this->input->post('fecha'),
				'Observaciones'	=> $this->input->post('observaciones'),				
			);
			$resp = $this->db->where('IdEvaluacion', $idv)->update('en_evaluacion',$actualiza);
			if( $resp ) {
				// msj de éxito
				$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
				$datos['mensaje'] = "La evaluaci&oacute;n se ha modificado";
				$datos['enlace'] = "admin_files/evaluaciones/evaluacion/0";
				$this->load->view('mensajes/ok_redirec',$datos);
			}
			else {
				// msj de error
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = "Ha ocurrido un error al guardar, por favor intentalo de nuevo";
				$this->load->view('mensajes/error',$datos);	
			}			
		}
		
		// estructura de la página (2)
		$this->load->view('admin/evaluaciones/modificar',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// avances
	//
	function avances() {
		$datos['titulo'] = "Avances";
		$datos['menu'] = $this->menu;
		$datos['barra'] = '<a href="'.base_url().'index.php/admin_files/adminInicio">Inicio</a> <img src="'.base_url().'includes/img/arrow_right.png"/> <a href="'.base_url().'index.php/admin_files/evaluaciones/avances">'.$datos['titulo'].'</a>';
		$datos['sort_tabla'] = $this->sort_tabla( 25 );

		// obtiene todas las encuestas
		$encuesta = $this->db->get_where('en_encuestas');
		if( $encuesta->num_rows() > 0 ) {
			$datos['encuesta_options'] = array(
				'1'	=> 'Evaluaci&oacute;n Clima Laboral'
			);
		}
		
		// obtiene todas las areas
		$areas = $this->db->order_by('Area')->get_where('ab_areas',array('Area NOT LIKE' => 'Invitado','Area NOT LIKE' => 'Coordinación de Calidad'));
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options']['all'] = " - Todas las &Aacute;reas - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}
		
		// obtiene los avances
		if( $_POST ) {
			$ide = $this->input->post('encuesta');
			$ida = $this->input->post('area');
			$datos['area'] = $ida;
			$datos['encuesta'] = $ide;
		}
		else {
			$ide = 1; // Clima Laboral default
			$ida = false;
			$datos['area'] = 'all';
			$datos['encuesta'] = 1;
		}				
		
		// Información de la encuesta
		$encuesta = $this->db->order_by('en_evaluacion.IdEvaluacion','DESC')->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta')->get_where('en_encuestas',array('en_encuestas.IdEncuesta' => $ide),1);
		if( $encuesta->num_rows() > 0 ) {
			foreach( $encuesta->result() as $row ) {
				switch ( $ide ) {
					// Clima Laboral
					case 1 :
						$i = 0;
						$listado = array();
						
						// preguntas de la encuesta
						$preguntas = $this->db->get_where('en_preguntas', array('en_preguntas.IdEncuesta' => $ide));
						
						// obtiene el listado del personal del área
						if( !$ida ) 
							$personal = $this->db->order_by('ab_areas.Area,ab_usuarios.Nombre')->join('ab_areas','ab_areas.IdArea = ab_usuarios.IdArea')->get_where('ab_usuarios', array('ab_usuarios.Estado' => 1, 'ab_usuarios.Nombre NOT LIKE' => '%AUDITOR%'));
						else
							$personal = $this->db->order_by('ab_areas.Area,ab_usuarios.Nombre')->join('ab_areas','ab_areas.IdArea = ab_usuarios.IdArea')->get_where('ab_usuarios', array('ab_usuarios.IdArea' => $ida, 'ab_usuarios.Estado' => 1, 'ab_usuarios.Nombre NOT LIKE' => '%AUDITOR%'));
														
						if( $personal->num_rows() > 0 ) {
							foreach( $personal->result() as $row_u ) {
								$respuestas = $this->db->get_where('en_respuestas_clima', array('en_respuestas_clima.IdUsuario' => $row_u->IdUsuario, 'en_respuestas_clima.IdEvaluacion' => $row->IdEvaluacion));
								$porcentaje = round( ( ($respuestas->num_rows() * 100 ) / $preguntas->num_rows() ) * 100 ) / 100;								
								$listado[$i] = array( 
									'Nombre' 		=> $row_u->Nombre." ".$row_u->Paterno." ".$row_u->Materno,
									'Porcentaje' 	=> $porcentaje,
									'Area' 			=> $row_u->Area, 
								);
								$i++;
							}
						}
						$datos['listado'] = $listado;
						break;
				
				}
			}
		}

		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/evaluaciones/avances',$datos);
		$this->load->view('admin/_estructura/footer');
	}
	
	//
	// Especificaciones para el sort de la tabla
	//
	function sort_tabla( $reg ) {
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

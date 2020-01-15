<?php 
/****************************************************************************************************
*
*	CONTROLLERS/procesos/gestion.php
*
*		Descripción:
*			Capacitación 
*
*		Fecha de Creación:
*			15/Enero/2020
*
*		Ultima actualización:
*			15/Enero/2020
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas 
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gestion extends CI_Controller {
	
/** Atributos **/

/** Propiedades **/	
	
/** Constructor **/
	function __construct() {
		parent::__construct();
		
		// si no se ha identificado correctamente
		if( !$this->session->userdata( 'id_usuario' ) ) {
			redirect( 'inicio' );
		}
		else {
			// Modelo
			$this->load->model('procesos/Gestion_model','',TRUE);
		}
	}
	
/** Funciones **/
	//
	// usuarios( $id_evaluacion ): Evaluación de detección de necesidades de capacitación
	//
	function index( $id_evaluacion ) {

        // variables necesarias para la página
        $this->Gestion_model->set_sort( 15 );
		$datos['titulo'] = 'Gestion de Riesgos';
		$datos['secciones'] = $this -> Inicio_model -> get_secciones();
		$datos['identidad'] = $this -> Inicio_model -> get_identidad();
		$datos['usuario'] = $this -> Inicio_model -> get_usuario();

		// obtiene todas las areas excepto la de invitado
		$areas = $this -> Inicio_model -> get_areas();
		if ($areas -> num_rows() > 0) {
			$datos['area_options'] = array();
			$datos['area_options'][0] = " - Elige un &Aacute;rea - ";
			foreach ($areas->result() as $row)
				$datos['area_options'][$row -> IdArea] = $row -> Area;
		}

		// estructura de la página (1)
		$this -> load -> view('_estructura/header', $datos);

		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( 'inicio' );
        }

        $datos['evidencias'] = $this->Gestion_model->get_evidencias();
        $datos['sort_tabla'] = $this->Gestion_model->get_sort();

        // estructura de la página (2)
		$this -> load -> view('_estructura/top', $datos);
		$this -> load -> view('procesos/gestion/ver', $datos);
		$this -> load -> view('_estructura/right');
		$this -> load -> view('_estructura/footer');

    }

}
		
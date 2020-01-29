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
		$this->load->model('procesos/Gestion_model','',TRUE);

		/* si no se ha identificado correctamente
		if( !$this->session->userdata( 'id_usuario' ) ) {
			redirect( 'inicio' );
		}
		else {
			// Modelo
			
		}*/
	}
	
/** Funciones **/
	//
	// usuarios( $id_evaluacion ): Evaluación de detección de necesidades de capacitación
	//
	function index() {

        // variables necesarias para la página
        $this->Gestion_model->set_sort( 15 );
		$datos['titulo'] = 'Gestion de Riesgos';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		// obtiene todas las areas excepto la de invitado
		$areas = $this->Inicio_model->get_areas();
		if ($areas -> num_rows() > 0) {
			$datos['area_options'] = array();
			$datos['area_options'][0] = " - Elige un &Aacute;rea - ";
			foreach ($areas->result() as $row)
				$datos['area_options'][$row -> IdArea] = $row -> Area;
		}

		// estructura de la página (1)
		$this -> load -> view('_estructura/header', $datos);

		
        $datos['evidencias'] = $this->Gestion_model->get_evidencias();
        $datos['sort_tabla'] = $this->Gestion_model->get_sort();

		
		// estructura de la página (2)
		$this -> load-> view('_estructura/header',$datos);
		$this -> load -> view('_estructura/top', $datos);
		$this -> load -> view('procesos/gestion/ver', $datos);
		$this -> load -> view('_estructura/right');
		$this -> load -> view('_estructura/footer');

    }


    //
	// nuevo(): Evaluación de detección de necesidades de capacitación
	//



	/*ublic function nuevo(){
		$this->Gestion_model->set_sort( 15 );
		$datos['titulo'] = 'Gestion de Riesgos';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		$datos['evidencias'] = $this->Gestion_model->get_evidencias();
		$datos['sort_tabla'] = $this->Gestion_model->get_sort();
		
		$this->load->view('_estructura/header',$datos);
		$this->load->view('_estructura/top', $datos);
		$this->load->view('procesos/gestion/ver', $datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}*/
	

    public function nuevo(){
        // variables necesarias para la página
        $this->Gestion_model->set_sort( 15 );
        $datos['titulo'] = 'Gestion de Riesgos';
        $datos['titulo2'] = 'Agregar nuevo documento';
		$datos['secciones'] = $this -> Inicio_model -> get_secciones();
		$datos['identidad'] = $this -> Inicio_model -> get_identidad();
		$datos['usuario'] = $this -> Inicio_model -> get_usuario();

		// Obtiene el nombre del usuario
		$usuario = $datos['usuario'];
		

		$this -> load -> view('_estructura/header', $datos);

		if( $_POST ){		
			// configuración del archivos a subir
			$nom_doc = $this->session->userdata('id_area')."substr(md5(uniqid(rand())),0,6)";
			$config['file_name'] = $nom_doc;
			$config['upload_path'] = './includes/docs/expedientes/';
			$config['allowed_types'] = '*';
			$config['max_size']	= '0';
	
			$this->load->library('upload', $config);
	
			if ( !$this->upload->do_upload('archivo') ) {
				// msj de error
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = $this->upload->display_errors();
				$this->load->view('mensajes/error',$datos);
			}
			else {						
				// renombra el documento
				$upload_data = $this->upload->data();
				$nom_doc = $nom_doc.$upload_data['file_ext'];

				// se guarda el documento
				if( $this->gestion_model->inserta_expediente( $id, $nom_doc ) ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "El archivo se ha guardado correctamente<br />¿deseas agregar otro para éste usuario?";
					$datos['enlace_si'] = "procesos/capacitacion/expediente_agregar/".$id;
					$datos['enlace_no'] = "procesos/capacitacion/expediente_listado";
					$this->load->view('mensajes/pregunta_enlaces',$datos);
				}
			}
		}
		
		// estructura de la página (2)
		$this -> load -> view('_estructura/header', $datos);
		$this -> load -> view('_estructura/top', $datos);
		$this -> load -> view('procesos/gestion/agregar', $datos);
		$this -> load -> view('_estructura/right');
		$this -> load -> view('_estructura/footer');
    }
}
		
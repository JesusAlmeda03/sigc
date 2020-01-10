<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manuales extends CI_Controller {
	
/** Atributos **/

/** Propiedades **/
	
/** Constructor **/
	function __construct() {
		parent::__construct();
	}
	
/** Funciones **/
	//
	// Pagina Principal del Sistema
	//
	function inicio() {
		$datos['titulo'] = 'Manuales de Usuario';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		
		// obtiene el texto
		$datos['areas'] = $this->Inicio_model->get_areas();
		
		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'manuales/inicio', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}
}
?>
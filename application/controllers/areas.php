<?php 
/****************************************************************************************************
*
*	CONTROLLERS/areas.php
*
*		Descripción:
*			Áreas Administrativas Certificadas del sistema 
*
*		Fecha de Creación:
*			12/Octubre/2012
*
*		Ultima actualización:
*			12/Octubre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas 
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Areas extends CI_Controller {
	
/** Atributos **/

/** Propiedades **/
	
/** Constructor **/
	function __construct() {
		parent::__construct();
		
		// si no se ha identificado correctamente
		if( !$this->session->userdata( 'id_usuario' ) ) {
			redirect( 'inicio' );
		}
	}
	
/** Funciones **/
	//
	// index(): Muestra las áreas certificadas del sistea
	//
	function index() {		
		// variables necesarias para la página
		$datos['titulo'] = '&Aacute;reas Certificadas';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		
		// obtiene el texto
		$datos['areas'] = $this->Inicio_model->get_areas();
		
		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'areas/inicio', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}
}
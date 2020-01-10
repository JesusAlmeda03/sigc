<?php 
/****************************************************************************************************
*
*	CONTROLLERS/identidad.php
*
*		Descripción:
*			Identidad del Sistema 
*
*		Fecha de Creación:
*			03/Octubre/2011
*
*		Ultima actualización:
*			10/Julio/2011
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas 
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Identidad extends CI_Controller {
	
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
			$this->load->model('identidad_model','',TRUE);
		}
	}
	
/** Funciones **/
	//
	// texto( $id ): Muestra la información en texto solicitada
	//
	function texto( $id ) {
		// obtiene el texto
		$identidad = $this->identidad_model->get_texto( $id );
		$datos['identidad_texto'] = $identidad; 
		
		// si no hay información
		if( !sizeof( $identidad ) ) {
			redirect( 'inicio' );
		} 
		
		// variables necesarias para la página
		$datos['titulo'] = $identidad['titulo'];
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();			

		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'identidad/texto', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}
}
<?php 
/****************************************************************************************************
*
*	CONTROLLERS/documentos.php
*
*		Descripción:
*			Documentos del Sistema - Uso Común / Áreas 
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

class Documentos extends CI_Controller {
	
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
			$this->load->model('documentos_model','',TRUE);
		}
	}
	
/** Funciones **/
	//
	// area( $id ): Muestra los documentos por área
	//
	function area( $id ) {
		// obtiene los documentos
		$datos['documentos'] = $this->documentos_model->get_documentos_area( $id );
		$datos['id'] = $id;
		
		// si no hay información
		$titulo = $this->documentos_model->get_seccion( $id );
		if( $titulo == '' ) {
			redirect( 'inicio/error_404' );
		}
		
		// variables necesarias para la página
		$datos['titulo'] = $titulo;
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();

		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'documentos/area', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}

	//
	// comun( $id ): Muestra los documentos de uso común
	//
	function comun( $id ) {
		// obtiene los documentos
		$datos['documentos'] = $this->documentos_model->get_documentos_comun( $id );
		$datos['id'] = $id;
		
		// si no hay información
		$titulo = $this->documentos_model->get_seccion( $id );
		if( $titulo == '' ) {
			redirect( 'inicio/error_404' );
		} 
		
		// variables necesarias para la página
		$datos['titulo'] = $titulo;
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();			

		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'documentos/comun', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}
}
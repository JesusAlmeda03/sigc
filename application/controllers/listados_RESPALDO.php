<?php 
/****************************************************************************************************
*
*	CONTROLLERS/listados.php
*
*		Descripción:
*			Controlador de los listados generados por los procesos automatizados
*
*		Fecha de Creación:
*			18/Octubre/2011
*
*		Ultima actualización:
*			30/Julio/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listados extends CI_Controller {
	
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
			$this->load->model('listados_model','',TRUE);
		}
	}

/** Funciones **/
	//
	// quejas(): Obtiene el listado de las quejas
	//
	function quejas() {
		// obtiene las variables para mostrar el listado específico
		if( $_POST ) {
			$edo = $this->input->post('estado');
		}
		else {
			if( $this->uri->segment(3) ) {
				$edo = $this->uri->segment(3); 
			}
			else {
				$edo = 'terminadas';
			}
		}
		$datos['edo'] = $edo;
		
		// se obtiene el listado
		$datos['consulta'] = $this->listados_model->get_quejas( $edo );
		
		// variables necesarias para la página
		$datos['titulo'] = 'Listado de Quejas';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
				
		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'mensajes/pregunta_oculta_usuario' );
		$this->load->view( 'listados/quejas', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}
	
	//
	// no conformidades(): Obtiene el listado de las no conformidades
	//
	function conformidades() {
		// obtiene las variables para mostrar el listado específico
		if( $_POST ) {
			$edo = $this->input->post('estado');
		}
		else {
			if( $this->uri->segment(3) ) {
				$edo = $this->uri->segment(3); 
			}
			else {
				$edo = 'atendidas';
			}
		}
		$datos['edo'] = $edo;

		// se obtiene el listado
		$datos['consulta'] = $this->listados_model->get_conformidades( $edo );
		
		// variables necesarias para la página
		$datos['titulo'] = 'Listado de No Conformidades';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
		
		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'mensajes/pregunta_oculta_usuario' );
		$this->load->view( 'listados/conformidades', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}
	
	//
	// minutas(): Obtiene el listado de las minutas
	//
	function minutas() {
		// obtiene las variables para mostrar el listado específico
		if( $_POST ) {
			$edo = $this->input->post('estado');
		}
		else {
			if( $this->uri->segment(3) ) {
				$edo = $this->uri->segment(3); 
			}
			else {
				$edo = 'activas';
			}
		}
		$datos['edo'] = $edo;
		
		// se obtiene el listado
		$datos['consulta'] = $this->listados_model->get_minutas( $edo );
		
		// variables necesarias para la página
		$datos['titulo'] = 'Listado de Minutas';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
				
		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'mensajes/pregunta_oculta_usuario' );
		$this->load->view( 'listados/minutas', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}

	//
	// solicitudes(): Obtiene el listado de las solicitudes
	//
	function solicitudes() {
		// obtiene las variables para mostrar el listado específico
		if( $_POST ) {
			$edo = $this->input->post('estado');
			$tip = $this->input->post('tipo');
		}
		else {
			if( $this->uri->segment(3) || $this->uri->segment(4) ) {
				$edo = $this->uri->segment(3);
				$tip = $this->uri->segment(4); 
			}
			else {
				$edo = 'aceptadas-cc';
				$tip = 'todos';
			}
		}
		$datos['edo'] = $edo;
		$datos['tip'] = $tip;
						
		// variables necesarias para la página
		$datos['titulo'] = 'Listado de Solicitudes';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
		
		// se obtiene el listado
		$datos['consulta'] = $this->listados_model->get_solicitudes( $edo, $tip );
				
		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'mensajes/pregunta_oculta_usuario' );
		$this->load->view( 'listados/solicitudes', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}
	
	//
	// mantenimiento(): Obtiene el listado del mantenimiento de equipo de cómputo
	//
	function mantenimiento() {
		// variables necesarias para la página
		$datos['titulo'] = 'Mantenimiento de Equipo de C&oacute;mputo';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
		
		// obtiene el listado
		$datos['consulta'] = $this->listados_model->get_mantenimiento();
		
		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'mensajes/pregunta_oculta_usuario' );
		$this->load->view( 'listados/mantenimiento', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}
	
	//
	// cambiar_estado( $tipo, $id, $estado, $redirecciona ): Cambia el estado de un registro
	//
	function cambiar_estado( $tipo, $id, $estado, $redirecciona ) {
		// cambia el estado y redirecciona
		if( $this->listados_model->cambia_estado( $tipo, $id, $estado ) ) {
			$redirecciona = str_replace( "-", "/", $redirecciona );
			redirect( $redirecciona );
		}
	}
}
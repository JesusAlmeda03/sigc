<?php 
/****************************************************************************************************
*
*	CONTROLLERS/procesos/auditorias.php
*
*		Descripción:
*			Auditorías del sistema 
*
*		Fecha de Creación:
*			29/Noviembre/2012
*
*		Ultima actualización:
*			29/Noviembre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas 
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auditorias extends CI_Controller {
	
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
			$this->load->model('admin/auditorias_admin_model','',TRUE);
		}
	}
	
/** Funciones **/	
	//
	// especifico( $id ): Programa específico de auditoría
	//
	function especifico( $id ) {		
		if( !$this->uri->segment(4) ) {
			redirect('inicio');
		}

		if( $this->uri->segment(5) || $this->uri->segment(6) || $this->uri->segment(7) ) {
			$ano = $this->uri->segment(5);
			$aud = $this->uri->segment(6);
			$edo = $this->uri->segment(7);
		}
		else {
			$ano = 'elige';
			$aud = 'todos';
			$edo = 'todos';
		}
		$datos['ano'] = $ano;
		$datos['auditoria'] = $aud;
		$datos['estado'] = $edo;

		// variables necesarias para la página
		$datos['titulo'] = 'Programa Espec&iacute;fico de Auditor&iacute;a';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		// obtiene información de la auditoria
		$auditoria = $this->auditorias_admin_model->get_auditoria( $id );
		foreach( $auditoria->result() as $row ) {
			if( !$row->Estado ) {
				if( $row->Alcance == '' || $row->Objetivo == '' || $row->Lider == '') {
					$datos['estado_auditoria'] = 'pendiente';
				}
				else {
					$datos['estado_auditoria'] = 'activar';
					$datos['objetivo'] 	= $row->Objetivo;
					$datos['alcance'] 	= $row->Alcance;
					$datos['lider']		= $row->Lider;
				}
			}
			else {
				$datos['estado_auditoria'] = 'completa';
				$datos['objetivo'] 	= $row->Objetivo;
				$datos['alcance'] 	= $row->Alcance;
				$datos['lider']		= $row->Lider;
			}
		}
		
		// si se van a modificar los datos
		if( $this->uri->segment(8) == 'modificar' ) {
			$datos['estado_auditoria'] = 'modificar';
		}
		
		// obtiene los equipos para esta auditoría
		$datos['equipos'] = $this->auditorias_admin_model->get_equipos( $id );
		
		// obtiene la relacion los equipos y los procesos que van a auditar 
		$datos['equipos_procesos'] = $this->auditorias_admin_model->get_equipos_procesos( $id );
		
		// obtiene los procesos para esta auditoría
		$datos['procesos'] = $this->auditorias_admin_model->get_procesos_auditoria( $id );
		
		// obtiene las relaciones procesos-documentos para obtener las areas
		$datos['procesos_documentos'] = $this->auditorias_admin_model->get_procesos_documentos( $id );
		
		// obtiene los auditores para esta auditoría
		$datos['auditores'] = $this->auditorias_admin_model->get_auditores_equipo( $id );
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'mensajes/pregunta_oculta_usuario' );
		$this->load->view( 'procesos/auditorias/especifico', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}
}
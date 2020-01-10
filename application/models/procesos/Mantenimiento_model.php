<?php 
/****************************************************************************************************
*
*	MODELS/procesos/mantenimiento_model.php
*
*		Descripción:  		  
*			Documentos del sistema 
*
*		Fecha de Creación:
*			13/Febrero/2012
*
*		Ultima actualización:
*			21/Septiembre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
class Mantenimiento_model extends CI_Model {
/** Atributos **/

/** Propiedades **/

/** Constructor **/	
	function __construct() {
		parent::__construct();
	}
	
/** Funciones **/	
	//
	// get_programa(): Revisa si no se ha generado ya esta programación
	//
	function get_programa() {
		$condicion = array(
			'IdArea' 	=> $this->input->post('area'),
			'Periodo' 	=> $this->input->post('periodo'),
			'Ano' 		=> $this->input->post('ano'),
			'Estado' 	=> '1'
		);
		$consulta = $this->db->get_where( 'pa_mtto_programa', $condicion, 1 );
		
		return $consulta;
	}
	
	//
	// get_programa_informacion( $id ): Obtiene la información del programa
	//
	function get_programa_informacion( $id ) {
		$condicion = array(
			'IdPrograma ' => $id
		);
		$this->db->join( 'ab_usuarios','ab_usuarios.IdUsuario = pa_mtto_programa.IdUsuario' );
		$this->db->join( 'ab_areas','ab_areas.IdArea = pa_mtto_programa.IdArea' );
		$consulta = $this->db->get_where( 'pa_mtto_programa', $condicion );

		return $consulta;
	}
	
	//
	// get_equipo( $id ): Obtiene los equipos del área
	//
	function get_equipo( $id ) {
		$condicion = array(
			'IdArea ' => $id
		);
		$consulta = $this->db->get_where( 'pa_mtto_equipo', $condicion );

		return $consulta;
	}
	
	//
	// inserta_programa(): Inserta un nuevo programa de mantenimiento
	//
	function inserta_programa() {
		// array para insertar en la bd
		$inserta = array(
		   'IdArea'		=> $this->input->post('area'),
		   'IdUsuario'	=> $this->session->userdata('id_usuario'),
		   'Periodo'	=> $this->input->post('periodo'),
		   'Ano'		=> $this->input->post('ano'),
		   'Fecha'		=> $this->input->post('fecha'),
		   'Estado'		=> 1, // programa activo
		);
		
		// realiza la inserción
		$resp = $this->db->insert( 'pa_mtto_programa', $inserta );
		if( $resp ) {
			$resp = $this->db->insert_id();
		}
		
		return $resp;
	}
	//Cuidado aqui
	function inserta_evidencia_mtto($area, $periodo,$ano,$nomdoc ) {
		$insert = array(
			'IdArea' 	=> $area,
			'Periodo'	=> $periodo,
			'Ano'		=> $ano,
			'Ruta'		=> $nomdoc,
			'Fecha'		=> date('Y').'/'.date('m').'/'.date('d'),
		);
		$resp = $this->db->insert( 'pa_evidencia_mtto', $insert ); 
		
		return $resp;
	}
	
	function ver_evidencia($area){
		$condicion = array(
			'IdArea'	=> $area,
			);
		$consulta = $this->db->get_where('pa_evidencia_mtto', $condicion);
		return $consulta;
	}	
		
	
}
?>

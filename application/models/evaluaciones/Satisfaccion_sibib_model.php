<?php 
/****************************************************************************************************
*
*	MODELS/evaluaciones/satisfaccion_sibib_model.php
*
*		Descripción:  		  
*			Evaluación a la Satisfacción de Usuarios 
*
*		Fecha de Creación:
*			13/Febrero/2012
*
*		Ultima actualización:
*			11/Julio/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
class Satisfaccion_sibib_model extends CI_Model {
/** Atributos **/

/** Propiedades **/

/** Constructor **/	
	function __construct() {
		parent::__construct();
	}
	
/** Funciones **/
	//
	// get_preguntas(): Obtiene las preguntas de la encuesta
	//
	function get_preguntas( $id ) {
		$consulta = array(
			'en_preguntas.IdEncuesta' => $id
		);
		
		$this->db->order_by('IdSeccion');
		$consulta = $this->db->get_where('en_preguntas', $consulta );
		
		return $consulta;
	}
	
	//
	// get_secciones(): Obtiene las secciones de la encuesta
	//
	function get_secciones( $id ) {
		$consulta = array(
			'en_secciones.IdEncuesta' => $id
		);
		
		$this->db->order_by('IdSeccion');
		$consulta = $this->db->get_where( 'en_secciones', $consulta );
		
		return $consulta;
	}
	
	//
	// get_evaluacion(): Obtiene información de la evaluación
	//
	function get_evaluacion( $id ) {
		$consulta = array(
			'IdEncuesta'	=> $id,
			'Estado'		=> '1',
		);
		
		$this->db->order_by( 'IdEvaluacion','DESC' );
		$consulta = $this->db->get_where( 'en_evaluacion', $consulta, 1 );
		
		return $consulta;
	}
	
	//
	// get_jefe(): Obtiene al jefe, que no contesta clima
	//
	function get_jefe() {
		$consulta = array(
			'ab_usuarios.IdArea' => $this->session->userdata('id_area')
		);
		
		$this->db->join('ab_usuarios','ab_usuarios.IdUsuario = ab_usuarios_jefes.IdUsuario');
		$consulta = $this->db->get_where( 'ab_usuarios_jefes', $consulta, 1 );
		
		$id_jefe = 0;
		if( $consulta->num_rows() > 0 ) {
			foreach ( $consulta->result() as $row ) {
				$id_jefe = $row->IdUsuario; 
			}
		}
		
		return $id_jefe;
	}	
	
	//
	// get_usuarios(): Obtiene el listado del personal del área
	//
	function get_usuarios() {
		$consulta = array(
			'ab_usuarios.IdArea' 			=> $this->session->userdata('id_area'),
			'ab_usuarios.Estado' 			=> 1, 
			'ab_usuarios.Nombre NOT LIKE' 	=> '%AUDITOR%', 
			'ab_usuarios.IdUsuario <>' 		=> $this->get_jefe()
		);
		
		$consulta = $this->db->get_where( 'ab_usuarios', $consulta);
		
		return $consulta;
	}
	
	//
	// get_respuestas( $id_usuario, $id_evaluacion ): Obtiene las secciones de la encuesta
	//
	function get_respuestas( $id_usuario, $id_evaluacion ) {
		$consulta = array(
			'en_respuestas_clima.IdUsuario' 	=> $id_usuario, 
			'en_respuestas_clima.IdEvaluacion' 	=> $id_evaluacion
		);
		
		$consulta = $this->db->get_where( 'en_respuestas_clima', $consulta );
		
		return $consulta;
	}
}
?>

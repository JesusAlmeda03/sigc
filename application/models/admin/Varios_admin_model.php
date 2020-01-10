<?php 
/****************************************************************************************************
*
*	MODELS/admin/varios_admin_model.php
*
*		Descripción:  		  
*			Documentos del sistema 
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
class Varios_admin_model extends CI_Model {
/** Atributos **/

/** Propiedades **/
	
/** Constructor **/			
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
/** Funciones **/	
//
	// get_evaluacion(): Obtiene la evaluación activa
	// 
	function get_evaluacion() {
		$condicion = array(
			'Estado'	=> '1',
		);
		$this->db->order_by('IdCapacitacionEvaluacion', 'DESC');
		$consulta = $this->db->get_where( 'pa_capacitacion_evaluacion', $condicion, 1 );
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) {
				$id_evaluacion = $row->IdCapacitacionEvaluacion;
			}
		} 
		else {
			$id_evaluacion = 0;
		}
		
		return $id_evaluacion;
	}
	
	function get_idcurso() {
		$condicion = array(
			'Estado'	=> '1',
		);
		$consulta=$this->db->order_by('IdCapacitacionCurso', 'ASC');
		$consulta = $this->db->get_where( 'pa_capacitacion_cursos');
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) {
				$id_curso = $row->IdCapacitacionCurso;
			}
		} 
		else {
			$id_curso = 0;
		}
		
		return $id_curso;
	}
	
}
?>

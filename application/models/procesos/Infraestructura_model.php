<?php 
/****************************************************************************************************
*
*	MODELS/inicio_model.php
*
*		Descripción:  		  
*			Modelo para interaccion con la bd desde el inicio 
*
*		Fecha de Creación:
*			13/Febrero/2012
*
*		Ultima actualización:
*			10/Julio/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
class Infraestructura_model extends CI_Model {
/** Atributos **/
	private $secciones;
	private $identidad;
	private $usuario;
	private $sort_tabla;



/** Constructor **/	
	function __construct() {
		parent::__construct();
	}
	
	function periodos(){
		$condicion=array(
			'en_evaluacion.IdEncuesta'	=> 5, 
			'en_evaluacion.Estado'		=>1
		);
		
		$consulta=$this->db->get_where('en_evaluacion', $condicion);
		return $consulta;
		
	}
}
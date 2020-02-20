<?php 
/****************************************************************************************************
*
*	MODELS/documentos_model.php
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
*			ISC Rogelio Castañeda Andradeasd 
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
class Documentos_model extends CI_Model {
/** Atributos **/

/** Propiedades **/

/** Constructor **/	
	function __construct() {
		parent::__construct();
	}
	
/** Funciones **/
	//
	// get_seccion( $id ): Obtiene el nombre de la sección
	//
	function get_seccion( $id ) {
		$titulo = '';
		$condicion = array(
			'IdSeccion' => $id 
		);		
		$seccion = $this->db->get_where( 'bc_secciones', $condicion );
		if ( $seccion->num_rows() > 0 ) {
			foreach( $seccion->result() as $row ) {
				$titulo = $row->Seccion;
			}
		}
				
		return $titulo;
	}
	
	//
	// get_documentos_area( $id ): Obtiene los documentos por área
	//
	function get_documentos_area( $id ) {
		$consulta = array();
				
		// si tiene permisos de controlador
		if( $this->session->userdata('SOL') ) {
			// si son registros
			if( $id == 2 ) {
				$consulta = $this->db->group_by('bc_documentos.IdDocumento')->order_by("bc_documentos.Codigo", "ASC")->join('bc_documentos_word','bc_documentos_word.IdDocumento = bc_documentos.IdDocumento','LEFT OUTER')->join('bc_documentos_registros','bc_documentos_registros.IdDocumento = bc_documentos.IdDocumento','left')->select('bc_documentos_registros.Retencion, bc_documentos_registros.Disposicion, bc_documentos.IdDocumento, bc_documentos.IdArea, bc_documentos.IdSeccion, bc_documentos.Codigo, bc_documentos.Edicion, bc_documentos.Nombre, bc_documentos.Ruta, bc_documentos.Fecha, bc_documentos.Estado, bc_documentos_word.Ruta AS RutaWord, bc_documentos_word.FechaElaboracion')->get_where('bc_documentos',array('bc_documentos.Estado' => '1', 'bc_documentos.IdSeccion' => $id, 'bc_documentos.IdArea' => $this->session->userdata('id_area')));
			}
			// listado de documentos
			else {
				// sibib
				/*if( $this->session->userdata('id_area') == 9 && $id == 1) {
					$consulta = $this->db->group_by('bc_documentos.IdDocumento')->order_by("bc_documentos.Codigo", "ASC")->join('bc_documentos_word','bc_documentos_word.IdDocumento = bc_documentos.IdDocumento','LEFT OUTER')->select('bc_documentos.IdDocumento, bc_documentos.IdArea, bc_documentos.IdSeccion, bc_documentos.Codigo, bc_documentos.Edicion, bc_documentos.Nombre, bc_documentos.Ruta, bc_documentos.Fecha, bc_documentos.Estado, bc_documentos_word.Ruta AS RutaWord, bc_documentos_word.FechaElaboracion')->where('( bc_documentos.Estado = 1 AND bc_documentos.IdSeccion = "'.$id.'" AND bc_documentos.IdArea = '.$this->session->userdata('id_area').' ) OR ( Codigo LIKE "%IT,JDC,01%" AND Estado = 1) OR ( Codigo LIKE "%IT,JDC,02%" AND Estado = 1) ')->get('bc_documentos');
				}
				// todos
				else {*/
					$consulta = $this->db->group_by('bc_documentos.IdDocumento')->order_by("bc_documentos.Codigo", "ASC")->join('pa_solicitudes', 'pa_solicitudes.IdDocumento = bc_documentos.IdDocumento', 'left')->join('bc_documentos_word','bc_documentos_word.IdDocumento = bc_documentos.IdDocumento','LEFT OUTER')->select('bc_documentos.IdDocumento, bc_documentos.IdArea, bc_documentos.IdSeccion,pa_solicitudes.Fecha as FechaS, bc_documentos.Codigo, bc_documentos.Edicion, bc_documentos.Nombre, bc_documentos.Ruta, bc_documentos.Fecha, bc_documentos.Estado, bc_documentos_word.Ruta AS RutaWord, bc_documentos_word.FechaElaboracion')->get_where('bc_documentos',array('bc_documentos.Estado' => '1', 'bc_documentos.IdSeccion' => $id, 'bc_documentos.IdArea' => $this->session->userdata('id_area')));
				//}
			}
		}
		else {
			// si son registros
			if( $id == 2 ){
			$consulta = $this->db->group_by('bc_documentos.IdDocumento')->order_by("bc_documentos.Codigo", "ASC")->join('bc_documentos_registros','bc_documentos_registros.IdDocumento = bc_documentos.IdDocumento','left')->get_where('bc_documentos',array('bc_documentos.Estado' => '1', 'bc_documentos.IdSeccion' => $id, 'bc_documentos.IdArea' => $this->session->userdata('id_area')));
			// listado de documentos
			}else {
				// sibib
				/*if( $this->session->userdata('id_area') == 9 && $id == 1 ) {
					$consulta = $this->db->group_by('bc_documentos.IdDocumento')->order_by("bc_documentos.Codigo", "ASC")->join('bc_documentos_word','bc_documentos_word.IdDocumento = bc_documentos.IdDocumento','LEFT OUTER')->select('bc_documentos.IdDocumento, bc_documentos.IdArea, bc_documentos.IdSeccion, bc_documentos.Codigo, bc_documentos.Edicion, bc_documentos.Nombre, bc_documentos.Ruta, bc_documentos.Fecha, bc_documentos.Estado, bc_documentos_word.Ruta AS RutaWord, bc_documentos_word.FechaElaboracion')->where('( bc_documentos.Estado = 1 AND bc_documentos.IdSeccion = '.$id.' AND bc_documentos.IdArea = '.$this->session->userdata('id_area').' ) OR ( Codigo LIKE "%IT,JDC,01%" AND Estado = 1) OR ( Codigo LIKE "%IT,JDC,02%" AND Estado = 1) ')->get('bc_documentos');
				}
				// all
				else {*/
					$consulta = $this->db->group_by('bc_documentos.IdDocumento')->order_by("bc_documentos.Codigo", "ASC")->join('bc_documentos_word','bc_documentos_word.IdDocumento = bc_documentos.IdDocumento','LEFT OUTER')->select('bc_documentos.IdDocumento, bc_documentos.IdArea, bc_documentos.IdSeccion, bc_documentos.Codigo, bc_documentos.Edicion, bc_documentos.Nombre, bc_documentos.Ruta, bc_documentos.Fecha, bc_documentos.Estado, bc_documentos_word.Ruta AS RutaWord, bc_documentos_word.FechaElaboracion')->get_where('bc_documentos',array('bc_documentos.Estado' => '1', 'bc_documentos.IdSeccion' => $id, 'bc_documentos.IdArea' => $this->session->userdata('id_area')));
				//}
			}
		}

		return $consulta;
	}

	//
	// get_documentos_comun( $id ): Obtiene los documentos de uso común
	//
	function get_documentos_comun( $id ) {
		// si tiene permisos de controlador
		if( $this->session->userdata('SOL') ) {
			$consulta = $this->db->group_by('bc_documentos.IdDocumento')->order_by("bc_documentos.Codigo", "ASC")->join('bc_documentos_word','bc_documentos_word.IdDocumento = bc_documentos.IdDocumento','LEFT OUTER')->select('bc_documentos.IdDocumento, bc_documentos.IdArea, bc_documentos.IdSeccion, bc_documentos.Codigo, bc_documentos.Edicion, bc_documentos.Nombre, bc_documentos.Ruta, bc_documentos.Fecha, bc_documentos.Estado, bc_documentos_word.Ruta AS RutaWord, bc_documentos_word.FechaElaboracion')->get_where('bc_documentos',array('bc_documentos.Estado' => '1', 'bc_documentos.IdSeccion' => $id ));
		}
		else {
			$consulta = $this->db->group_by('bc_documentos.IdDocumento')->order_by("bc_documentos.Codigo", "ASC")->get_where('bc_documentos',array('bc_documentos.Estado' => '1', 'bc_documentos.IdSeccion' => $id ));
		}
		
		return $consulta;
	}

	//
	// get_documentos_comun( $id ): Obtiene los documentos de uso común
	//
	function get_auexpediente( $id ) {
		// si tiene permisos de controlador
		$condicion = array(
			'Estado' => 1,

		);

		$consulta=$this->db->get_where('pa_resumen', $condicion);
		
		return $consulta;
	}
}
?>

<?php 
/****************************************************************************************************
*
*	MODELS/admin/documentos_admin_model.php
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
class Documentos_admin_model extends CI_Model {
/** Atributos **/

/** Propiedades **/
	
/** Constructor **/			
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
/** Funciones **/
	//
	// get_secciones(): Obtiene las secciones
	//
	function get_secciones( $id ) {
		
		switch( $id ) {
		// Documentos
			case 1 :
				$consulta = $this->db->get_where('bc_secciones',array('Comun' => '0','Estado' => '1'));
				break;
				
		// Común SIGC
			case 2 :
				$consulta = $this->db->where('Estado','1')->where('Comun','1')->where('IdSistema','1')->get('bc_secciones');
				break;
		
		// Común SIBIB
			case 3 :
				$consulta = $this->db->where('Estado','1')->where('Comun','1')->where('IdSistema','2')->get('bc_secciones');
				break;
				
		// Común SIGC y SIBIB
			case 4 :
				$consulta = $this->db->where('Estado','1')->where('Comun','1')->where('IdSistema','3')->get('bc_secciones');
				break;
						
		// Todas las seccioens
			case 'todas' :
				$this->db->order_by('bc_secciones.IdSistema,bc_secciones.Comun');
				$this->db->join('cd_sistemas','cd_sistemas.IdSistema = bc_secciones.IdSistema');
				$consulta = $this->db->get_where( 'bc_secciones', array('bc_secciones.Estado' => '1') );
				break;		
		}
		
		return $consulta;
	}
	
	//
	// get_seccion( $id ): Obtiene la seccion en base a una id
	//
	function get_seccion( $id ) {		
		$consulta = $this->db->get_where('bc_secciones',array( 'IdSeccion' => $id ));
		
		return $consulta;
	}

	//
	// get_busqueda( $area ): Obtiene los resultados de una busqueda
	//
	function get_busqueda( $datos ) {
		$this->db->join('ab_areas','ab_areas.IdArea = bc_documentos.IdArea');
		if( $datos['are'] == "todos" ) {
			$condicion = array(
				'IdSeccion' => $datos['sec'],
				'Codigo' 	=> $datos['cod'],
				'Edicion' 	=> $datos['edi'],
				'Nombre'	=> $datos['nom'],
				'Fecha' 	=> $datos['fec'],
				'Estado' 	=> '1'
			);
			$consulta = $this->db->like( $condicion )->get('bc_documentos');
		}
		else {
			$condicion = array(
				'bc_documentos.IdArea'	=> $datos['are'],
				'IdSeccion' 			=> $datos['sec'],
				'Codigo' 				=> $datos['cod'],
				'Edicion' 				=> $datos['edi'],
				'Nombre' 				=> $datos['nom'],
				'Fecha' 				=> $datos['fec'],
				'Estado' 				=> '1'
			); 
			$consulta = $this->db->like( $condicion )->get('bc_documentos');
		}
		
		return $consulta;
	}
	
	//
	// get_documento( $id ): Obtiene un documento en base a una id
	//
	function get_documento( $id ) {
		$consulta = $this->db->get_where( 'bc_documentos',array('IdDocumento' => $id) );
		
		return $consulta;
	}

	//
	// get_registro( $id ): Obtiene un registro en base a una id
	//
	function get_registro( $id ) {
		$consulta = $this->db->get_where( 'bc_documentos_registros',array('IdDocumento' => $id) );
		
		return $consulta;
	}
	
	//
	// get_documentos( $id, $tipo ): Obtiene todos los documentos
	//
	function get_documentos( $id, $tipo ) {
		// obtiene los documentos segun el tipo
		switch( $tipo ) {
		// Lista Maestra de Documentos
			case 'maestra' :
				// muestra el listado de todos los documentos 
				if( $id == "todos" ) {
					$this->db->order_by('bc_documentos.IdArea,bc_documentos.IdSeccion,bc_documentos.Codigo');
					$this->db->join('ab_areas','ab_areas.IdArea = bc_documentos.IdArea');
					$this->db->join('bc_secciones','bc_secciones.IdSeccion = bc_documentos.IdSeccion');
					$consulta = $this->db->get_where('bc_documentos',array('bc_documentos.Estado' => '1','bc_secciones.Estado' => '1'));
				}
				// muestra el listado del estado espec�fico
				else {
					$this->db->order_by('bc_documentos.IdArea,bc_documentos.IdSeccion,bc_documentos.Codigo');
					$this->db->join('ab_areas','ab_areas.IdArea = bc_documentos.IdArea');
					$this->db->join('bc_secciones','bc_secciones.IdSeccion = bc_documentos.IdSeccion');
					$consulta = $this->db->get_where('bc_documentos',array('bc_documentos.IdArea' => $id,'bc_documentos.Estado' => '1','bc_secciones.Estado' => '1','bc_secciones.Estado' => '1'));
				}
				break;
		
		// Lista Maestra de Registros
			case 'registros' :
				// muestra todo el listado
				if( $id == "todos" ) {
					$this->db->order_by('bc_documentos.IdArea,bc_documentos.IdSeccion,bc_documentos.Codigo');
					$this->db->join('ab_areas','ab_areas.IdArea = bc_documentos.IdArea');
					$this->db->join('bc_secciones','bc_secciones.IdSeccion = bc_documentos.IdSeccion');
					$this->db->join('bc_documentos_registros','bc_documentos_registros.IdDocumento = bc_documentos.IdDocumento','LEFT OUTER');
					$this->db->select('bc_documentos.IdDocumento,ab_areas.Area,bc_secciones.Seccion,bc_documentos.Codigo,bc_documentos.Nombre,bc_documentos.Edicion,bc_documentos.Fecha,bc_documentos.Ruta,bc_documentos_registros.Retencion,bc_documentos_registros.Disposicion');
					$consulta = $this->db->get_where('bc_documentos',array('Seccion' => 'Registros', 'bc_documentos.Estado' => '1','bc_secciones.Estado' => '1'));
				}
				// muestra el listado del estado específico
				else {
					$this->db->order_by('bc_documentos.IdArea,bc_documentos.IdSeccion,bc_documentos.Codigo');
					$this->db->join('ab_areas','ab_areas.IdArea = bc_documentos.IdArea');
					$this->db->join('bc_secciones','bc_secciones.IdSeccion = bc_documentos.IdSeccion');
					$this->db->join('bc_documentos_registros','bc_documentos_registros.IdDocumento = bc_documentos.IdDocumento','LEFT OUTER');
					$this->db->select('bc_documentos.IdDocumento,ab_areas.Area,bc_secciones.Seccion,bc_documentos.Codigo,bc_documentos.Nombre,bc_documentos.Edicion,bc_documentos.Fecha,bc_documentos.Ruta,bc_documentos_registros.Retencion,bc_documentos_registros.Disposicion');
					$consulta = $this->db->get_where('bc_documentos',array('bc_documentos.IdArea' => $id,'Comun' => '0', 'Seccion' => 'Registros', 'bc_documentos.Estado' => '1','bc_secciones.Estado' => '1'));
				}
				break;
				 
		// Documentos de Uso Común
			case 'comun' :
				$this->db->order_by('Seccion, Codigo')->join('bc_secciones','bc_secciones.IdSeccion = bc_documentos.IdSeccion');
				$consulta = $this->db->get_where('bc_documentos',array('Comun' => '1','IdSistema !=' => '2', 'bc_documentos.Estado' => '1','bc_secciones.Estado' => '1'));
				break;
				
		// Documentos Inactivos
			case 'inactivos' :
				$this->db->order_by('bc_documentos.IdArea,bc_documentos.IdSeccion,bc_documentos.Codigo');
				$this->db->join('ab_areas','ab_areas.IdArea = bc_documentos.IdArea');
				$this->db->join('bc_secciones','bc_secciones.IdSeccion = bc_documentos.IdSeccion');
				$consulta = $this->db->get_where('bc_documentos',array('bc_documentos.Estado' => '0'));
				break;
		}

		return $consulta;
	}
	
	//
	// get_documentos_listado( $id_seccion, $id_area ): Obtiene todos los documentos de una seccion
	//
	function get_documentos_listado( $id_seccion, $id_area ) {
		$this->db->join("bc_secciones", "bc_secciones.IdSeccion = bc_documentos.IdSeccion");
		// muestra todo el listado
		if( $id_area == "todos" ) {
			if( $id_seccion == 2 )
				$this->db->join('bc_documentos_registros','bc_documentos_registros.IdDocumento = bc_documentos.IdDocumento','LEFT OUTER');
			$this->db->join("ab_areas", "ab_areas.IdArea = bc_documentos.IdArea");
			$consulta = $this->db->get_where('bc_documentos',array('bc_documentos.IdSeccion' => $id_seccion, 'bc_documentos.Estado' => '1','bc_secciones.Estado' => '1'));
		}
		// muestra el listado del estado espec�fico
		else {
			if( $id_seccion == 2 ) {
				$this->db->select( 'bc_documentos.IdDocumento, bc_documentos.Codigo, bc_documentos.Nombre, bc_documentos_registros.Retencion, bc_documentos_registros.Disposicion, bc_documentos.Edicion, bc_documentos.Fecha, bc_documentos.Estado, bc_documentos.IdArea, bc_documentos.Ruta' );
				$this->db->join('bc_documentos_registros','bc_documentos_registros.IdDocumento = bc_documentos.IdDocumento','LEFT OUTER');
			}
			else{
				$this->db->select( 'bc_documentos.IdDocumento, bc_documentos.Codigo, bc_documentos.Nombre, bc_documentos.Edicion, bc_documentos.Fecha, bc_documentos.Estado, bc_documentos.IdArea, bc_documentos.Ruta' );
			}
			$this->db->join("ab_areas", "ab_areas.IdArea = bc_documentos.IdArea");
			$consulta = $this->db->group_by('bc_documentos.IdDocumento')->get_where("bc_documentos",array('bc_documentos.IdSeccion' => $id_seccion, 'bc_documentos.IdArea' => $id_area, 'bc_documentos.Estado' => '1','bc_secciones.Estado' => '1'));
		}
		
		return $consulta;
	}

	//
	//Documentos inactivos: Busca archivos que tiene estado de inactivo
	//

	function get_inactivos(){
		$condicion = array(
			'bc_secciones.Estado' => 0,
			'bc_documentos.Fecha <= ' => '2014-12-31',
		);

		$this->db->join("bc_secciones", "bc_documentos.IdSeccion = bc_secciones.IdSeccion");
		$this->db->join("ab_areas", "ab_areas.IdArea = bc_documentos.IdArea");
		$consulta = $this->db->get_where('bc_documentos', $condicion);
		return $consulta;
	}
	
	//
	// inserta_documento( $nom_doc ): Inserta un nuevo documento
	//
	function inserta_documento( $nom_doc ) {
		$this->db->trans_start();
		// array para insertar en la bd
		$inserta = array(
		   'IdArea'			=> $this->input->post('area'),
		   'IdSeccion'		=> $this->input->post('seccion'),
		   'Codigo'			=> $this->input->post('codigo'),
		   'Edicion'		=> $this->input->post('edicion'),
		   'Nombre'			=> $this->input->post('nombre'),
		   'Ruta'			=> $nom_doc,
		   'Fecha'			=> $this->input->post('fecha'),
		   'Estado'			=> '1', // documento activo
		);
		
		// realiza la inserción
		$resp = $this->db->insert('bc_documentos', $inserta); 
		if( $resp ) {
			// si es un registro
			if(  $this->input->post('seccion') == 2 ) {	
				$idd = $this->db->insert_id();
				$inserta = array(
				   'IdDocumento'	=> $idd,
				   'Retencion'		=> $this->input->post('retencion'),
				   'Disposicion'	=> $this->input->post('disposicion'),
				);
				$resp = $this->db->insert('bc_documentos_registros', $inserta);
			}
		}
		
		$this->db->trans_complete();
		return $resp;
	}

	//
	// inserta_seccion(): Inserta una nueva sección de documentos
	//
	function inserta_seccion() {				
		// array para insertar en la bd
		$inserta = array(
		   'IdSistema'	=> '1',
		   'Seccion'	=> $this->input->post('nombre'),
		   'Comun'		=> $this->input->post('tipo'),
		   'Estado'		=> '1',
		);
		
		// realiza la inserción
		$resp = $this->db->insert('bc_secciones', $inserta); 
				
		return $resp;
	}
	
	//
	// modifica_documento( $id ): Modifica un documento en base a una id
	//
	function modifica_documento( $id, $actualiza, $actualiza_registro, $id_seccion ) {
		$this->db->trans_start();
		$resp = $this->db->where('IdDocumento', $id )->update( 'bc_documentos', $actualiza ); 
		if( $resp ) {
			if( $id_seccion == '2' ) {
				$doc_reg = $this->db->get_where('bc_documentos_registros', array( 'IdDocumento' => $id ));
				if( $doc_reg->num_rows() > 0 ) {
					$resp = $this->db->where('IdDocumento', $id )->update('bc_documentos_registros', $actualiza_registro);
				}
				else {
					$actualiza_registro['IdDocumento']	=  $id;
					$resp = $this->db->insert('bc_documentos_registros', $actualiza_registro );
				}
			}
		}
		
		$this->db->trans_complete();
		return $resp;
	}
	
	//
	// modifica_seccion( $id ): Modifica una seccion
	//
	function modifica_seccion( $id ) {
		// array para insertar en la bd
		$actualiza = array(
		   'Seccion'	=> $this->input->post('nombre'),
		   'Comun'		=> $this->input->post('tipo'),
		);
		
		// realiza la inserci�n
		$this->db->where( 'IdSeccion',$id );
		$resp = $this->db->update( 'bc_secciones', $actualiza );
		
		return $resp;
	}

	function inserta_resumen($tipo, $descripcion, $nom_doc){
		$insert = array(
			'IdSeccion' => 63, 
			'Descripcion' => $descripcion,
			'Tipo' 	=> $tipo,
			'Ruta'	=> $nom_doc, 
			'Fecha' => date('Y-m-d'),
		);

		$this->db->insert('pa_resumen', $insert);

	}
}
?>

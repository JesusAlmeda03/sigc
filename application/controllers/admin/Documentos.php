<?php 
/****************************************************************************************************
*
*	CONTROLLERS/admin/documentos.php
*
*		Descripción:
*			Controlador de los documentos del sistema
*
*		Fecha de Creación:
*			20/Octubre/2011
*
*		Ultima actualización:
*			20/Septiembre/2012
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
	private $menu;
	private $barra;

/** Propiedades **/
	public function set_menu() {
		$this->menu = $this->inicio_admin_model->get_menu( 'documentos' );
	}
	
	public function get_barra( $enlaces ) {
		$this->barra = '<a href="'.base_url().'index.php/admin/inicio">Inicio</a>';
		
		foreach( $enlaces as $enlace => $titulo ) {
			$this->barra .= '
				<img src="'.base_url().'includes/img/arrow_right.png"/>
				<a href="'.base_url().'index.php/admin/documentos/'.$enlace.'">'.$titulo.'</a>
			';
		}
	}
		
/** Constructor **/	
	function __construct() {
		parent::__construct();
		
		// validacion de administrador
		if ( $this->session->userdata('id_usuario') ) {
			if ( !$this->session->userdata('admin') ) {
				redirect('admin/inicio/login');
			}
			else {
				$this->load->model('admin/inicio_admin_model','',TRUE);
				$this->load->model('admin/documentos_admin_model','',TRUE);
				$this->load->model('admin/varios_admin_model','',TRUE);
				$this->set_menu();
			}
		}
		else {
			redirect( 'inicio' );
		}
	}

	/** Funciones **/	
	//
	// resumen_listado(): muestra listado de documentos
	//
	function resumen_listado() {		
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Archivo del Resumen de Auditoria';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$datos['sort_tabla']= $this->inicio_admin_model->set_sort( 20 );
		// genera la barra de dirección
		$this->get_barra( array( 'anadir' => $titulo ) );
		$datos['barra'] = $this->barra;

		// obtiene todas las areas excepto la de invitado
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);

		$condicion = array(
			'IdSeccion' => 63
		);

		
		$listado = $this->db->get_where('pa_resumen', $condicion);
		$datos['listado'] = $listado;
		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/resumen/lista',$datos);
		$this->load->view('admin/_estructura/footer');
		
	}

	//
	// resumen_agregar(): Agrega documentos
	//
	function resumen_agregar() {		
		// variables necesarias para la estructura de la p�gina
		// variables necesarias para la página
		$datos['titulo'] = 'Actualizar Expediente de Usuario';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		
		
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		if( $_POST ){		
			// configuración del archivos a subir
			$nom_doc = $this->input->post('id_area')."63-".substr(md5(uniqid(rand())),0,6);
			$descripcion = $this->input->post('Descripcion');
			$tipo = $this->input->post('Tipo');
			
			$config['file_name'] = $nom_doc;
			$config['upload_path'] = './includes/docs/resumen/';
			$config['allowed_types'] = '*';
			$config['max_size']	= '0';
	
			$this->load->library('upload', $config);
	
			if ( !$this->upload->do_upload('archivo') ) {
				// msj de error
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = $this->upload->display_errors();
				$this->load->view('mensajes/error',$datos);
			}else {						
				// renombra el documento
				$upload_data = $this->upload->data();
				$nom_doc = $nom_doc.$upload_data['file_ext'];
				$this->documentos_admin_model->inserta_resumen( $tipo, $descripcion, $nom_doc );
				$redi = 'admin/documentos/resumen_listado';
				redirect($redi);
			}
			
		}else{
		// estructura de la página (2)
			$this->load->view('_estructura/top',$datos);
			$this->load->view('admin/varios/resumen/formulario',$datos);
			$this->load->view('_estructura/right');
			$this->load->view('_estructura/footer');
		}


	}


	
	//
	// ajax_secciones(): Obtiene las secciones mediante ajax
	//	
	function ajax_secciones(){
		$datos['secciones'] = $this->documentos_admin_model->get_secciones( $this->input->post('id_seccion') );
		$this->load->view('admin/documentos/ajax_secciones', $datos);
	}
	
	//
	// buscar(): Busca documentos
	//
	function buscar() {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Buscar Documento';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		$datos['busqueda'] = false;
		$datos['are'] = "";
		$datos['sec'] = "";
		$datos['cod'] = "";
		$datos['edi'] = "";
		$datos['nom'] = "";
		$datos['fec'] = "";
		
		// genera la barra de dirección
		$this->get_barra( array( 'buscar' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// obtiene todas las areas excepto la de invitado
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options']["todos"] = " - Todas las &Aacute;reas - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}
		
		// revisa si ya se a enviado el formulario por post	
		if( $_POST ){
			$datos['busqueda'] = true;			
			$datos['are'] = $this->input->post('area');
			$datos['sec'] = $this->input->post('seccion');
			$datos['cod'] = $this->input->post('codigo');
			$datos['edi'] = $this->input->post('edicion');			
			$datos['nom'] = $this->input->post('nombre');
			$datos['fec'] = $this->input->post('fecha');			
			$datos['cambiar_tipo'] = 'documento';			
			
			// realiza la busqueda
			$datos['consulta'] = $this->documentos_admin_model->get_busqueda( $datos );
		}
		else {
			$datos['busqueda'] = false;
		}
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/documentos/buscar',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// maestra(): Lista Maestra de Documentos
	//
	function maestra() {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Lista Maestra de Documentos';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
			
		// genera la barra de dirección
		$this->get_barra( array( 'maestra' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// si los datos han sido enviados por post se sobre escribe la variable $are
		if( $_POST ) {
			$area = $this->input->post('area');
		}
		else{
			if( $this->uri->segment(4) ) {
				$area = $this->uri->segment(4);
			}
			else {
				$area = 'elige';
			}
		}
		$datos['area'] = $area;

		// obtiene todas las areas excepto la de invitado
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options'][''] = "";
			$datos['area_options']['todos'] = " - Todas las &Aacute;reas - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}
							
		// obtiene todo el listado
		$datos['consulta'] = $this->documentos_admin_model->get_documentos( $area, 'maestra' );
				
		// estructura de la pagina
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view( 'mensajes/pregunta_oculta' );
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/documentos/maestra',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// maestra_registros(): Lista Maestra de Registros
	//
	function maestra_registros() {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Lista Maestra de Registros';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$this->get_barra( array( 'maestra_registros' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// si los datos han sido enviados por post se sobre escribe la variable $are
		if( $_POST ) {
			$area = $this->input->post('area');
		}
		else{
			if( $this->uri->segment(4) ) {
				$area = $this->uri->segment(4);
			}
			else {
				$area = 'elige';
			}
		}
		$datos['area'] = $area;

		// obtiene todas las areas excepto la de invitado
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options']["todos"] = " - Todas las &Aacute;reas - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}

		// obtiene todo el listado
		$datos['consulta'] = $this->documentos_admin_model->get_documentos( $area, 'registros' );
			
		// estructura de la pagina
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view( 'mensajes/pregunta_oculta' );
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/documentos/maestra_registros',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// comun(): Lista Maestra de Documentos de Uso Com�n
	//
	function comun() {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Documentos  de Uso Com&uacute;n';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$this->get_barra( array( 'comun' => $titulo ));
		$datos['barra'] = $this->barra;
				
		// obtiene todo el listado
		$datos['consulta'] = $this->documentos_admin_model->get_documentos( 'todos', 'comun' );
				
		// estructura de la p�gina
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view( 'mensajes/pregunta_oculta' );
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/documentos/comun',$datos);
		$this->load->view('admin/_estructura/footer');
	}


	function nueva(){
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Documentos  de Uso Com&uacute;n';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$this->get_barra( array( 'comun' => $titulo ));
		$datos['barra'] = $this->barra;
				
		// obtiene todo el listado
		$datos['consulta'] = $this->documentos_admin_model->get_inactivos();
				
		// estructura de la p�gina
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view( 'mensajes/pregunta_oculta' );
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/documentos/ina',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	//
	// listado( $sec ): Listado de documentos por seccion / área
	//
	function listado( $sec ) {		
		// si los datos han sido enviados por post se sobre escribe la variable $are
		$datos['secCon'] = $sec;
		if( $_POST ) {
			$area = $this->input->post('area');
		}
		else{
			if( $this->uri->segment(5) ) {
				$area = $this->uri->segment(5);
			}
			else {
				$area = 'elige';
			}
		}
		$datos['area'] = $area;
		$datos['sec'] = $sec;
		
		// obtiene todas las areas excepto la de invitado
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options'][''] = "";
			$datos['area_options']['todos'] = " - Todas las &Aacute;reas - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}
		
		// obtiene el listado de los documentos
		$datos['consulta'] = $this->documentos_admin_model->get_documentos_listado( $sec, $area );
						
		$sec_nombre = $this->documentos_admin_model->get_seccion( $sec );
		if( $sec_nombre->num_rows() > 0 ) {
			foreach( $sec_nombre->result() as $row ) {
				$titulo = "Documentos: ".$row->Seccion;
				break;
			}
		}
		
		// variables necesarias para la estructura de la p�gina		
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		$datos['seccion'] = $sec;
		
		// genera la barra de dirección
		$this->get_barra( array( 'listado/'.$sec => $titulo ) );
		$datos['barra'] = $this->barra;
				
		// estructura de la pagina
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/documentos/listado',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// inactivos(): Listado de Documentos Inactivos
	//
	function inactivos() {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Documentos Inactivos';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$this->get_barra( array( 'inactivos' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// obtiene todo el listado
		$datos['consulta'] = $this->documentos_admin_model->get_documentos( 'todos', 'inactivos' );
									
		// estructura de la pagina
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view( 'mensajes/pregunta_oculta' );
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/documentos/inactivos',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// anadir_seccion(): Añade Sección
	//
	function anadir_seccion() {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'A&ntilde;adir Secci&oacute;n';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		
		// genera la barra de dirección
		$this->get_barra( array( 'anadir_seccion' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/documentos/anadir_seccion',$datos);
		$this->load->view('admin/_estructura/footer');
		
		if( $_POST ){		
			// reglas de validaci�n
			$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserci�n a la base de datos si todo ha estado bien
			else{
				if( $this->documentos_admin_model->inserta_seccion() ) {
					// msj de �xito
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "La secci&oacute;n se ha guardado, ahora aparecera en el listado de a&ntilde;adir documentos<br />&iquest;Deseas a&ntilde;adir otra?";
					$datos['enlace_si'] = "admin/documentos/anadir_seccion";
					$datos['enlace_no'] = "admin/inicio";
					$this->load->view('mensajes/pregunta_enlaces',$datos);
				}
			}
		}
	}

	//
	// secciones(): Lista de secciones
	//
	function secciones() {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Listado de Secciones';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		
		// genera la barra de dirección
		$this->get_barra( array( 'secciones' => $titulo ) );
		$datos['barra'] = $this->barra;		
		
		// obtiene el listado de las secciones
		$datos['consulta'] = $this->documentos_admin_model->get_secciones( 'todas' );		
				
		// estructura de la p�gina
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view( 'mensajes/pregunta_oculta' );
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/documentos/secciones',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// modificar_documento( $id, $uri ): Modifica un documento
	//
	function modificar_documento( $id, $uri ) {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Modificar Documento';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$datos['ret'] = '';
		$datos['dis'] = '';
		
		$uri_old = $uri;
		// modifica la url 
		$uri = str_replace('-','/',$uri);
		
		// genera la barra de dirección
		$enlaces = array (
			$uri => 'Documentos',
			'modificar_documento/'.$id.'/'.$uri_old => $titulo,
		);
		$this->get_barra( $enlaces );
		$datos['barra'] = $this->barra;
		
		// obtiene los datos del documento
		$documento = $this->documentos_admin_model->get_documento( $id );
		if( $documento->num_rows() > 0 ) {
			foreach( $documento->result() as $row ) {
				$datos['ida'] = $row->IdArea;
				$datos['ids'] = $row->IdSeccion;
				$datos['cod'] = $row->Codigo;
				$datos['edi'] = $row->Edicion;
				$datos['nom'] = $row->Nombre;
				$datos['rut'] = $row->Ruta;
				$datos['fec'] = $row->Fecha;
				$datos['uri'] = 'admin/documentos/'.$uri;
			}
		}
		
		if( $datos['ids'] == '2' ) {
			$documento_registro = $this->documentos_admin_model->get_registro( $id );
			if( $documento_registro->num_rows() > 0 ) {
				foreach( $documento_registro->result() as $row_r ) {
					$datos['ret'] = $row_r->Retencion;
					$datos['dis'] = $row_r->Disposicion;
				}
			}
		}
		
		// áreas
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			foreach( $areas->result() as $row ) {
				$datos['area_options'][$row->IdArea] = $row->Area;
			}
		}
		
		// secciones
		$secciones = $this->documentos_admin_model->get_secciones( 'todas' );
		if( $secciones->num_rows() > 0 ) {
			$datos['seccion_options'] = array();
			foreach( $secciones->result() as $row ) {
				$datos['seccion_options'][$row->IdSeccion] = $row->Seccion;
			}
		}
				
		// estructura de la página
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/documentos/modificar',$datos);
		$this->load->view('admin/_estructura/footer');
		
		if( $_POST ){		
			// reglas de validaci�n
			$this->form_validation->set_rules('area', 'area', 'trim');
			$this->form_validation->set_rules('codigo', 'C&oacute;digo', 'trim');
			$this->form_validation->set_rules('edicion', 'Edici&oacute;n', 'trim');
			$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserci�n a la base de datos si todo ha estado bien
			else{
				$actualiza = array();
				$actualiza_registro = array();
				
				// actualiza seccion
				if( $this->input->post('seccion') ) {
					$actualiza['IdSeccion'] = $this->input->post('seccion');
				}
				// actualiza el archivo
				if( $this->input->post('mod_archivo') ) {
					// configuraci�n de los archivos a subir
					$nom_doc = $this->input->post('area')."-".$this->input->post('seccion')."-".substr(md5(uniqid(rand())),0,6);
					$config['file_name'] = $nom_doc;
					$config['upload_path'] = './includes/docs/';
					$config['allowed_types'] = 'doc|docx|pdf|xls|xlsx|ppt|pptx';
					$config['max_size']	= '0';
			
					$this->load->library('upload', $config);
			
					if ( !$this->upload->do_upload('archivo') ) {
						// msj de error
						$datos['mensaje_titulo'] = "Error";
						$datos['mensaje'] = $this->upload->display_errors();
						$this->load->view('mensajes/error',$datos);
					}
					else {						
						// renombra el documento
						$upload_data = $this->upload->data();
						$nom_doc = $nom_doc.$upload_data['file_ext'];
						$actualiza['Ruta'] = $nom_doc;
					}
				}
				
				// llena el array con la información a actualizar
				$actualiza['IdArea'] 	= $this->input->post('area');
				$actualiza['Codigo'] 	= $this->input->post('codigo');
				$actualiza['Edicion'] 	= $this->input->post('edicion');
				$actualiza['Nombre']	= $this->input->post('nombre');
				$actualiza['Fecha']		= $this->input->post('fecha');
				
				// si es un registro llena el array de registro
				if( $datos['ids'] == '2' ) {
					$actualiza_registro['Retencion']	=  $this->input->post('retencion');
					$actualiza_registro['Disposicion']	=  $this->input->post('disposicion');
				}
				
				// actualiza e documento
				if( $this->documentos_admin_model->modifica_documento( $id, $actualiza, $actualiza_registro, $datos['ids'] ) ) {
					// msj de �xito
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "El documento se ha modificado correctamente";
					$datos['enlace'] = 'admin/documentos/'.$uri;
					$this->load->view('mensajes/ok_redirec',$datos);
				}
			}
		}
	}
				
	//
	// modificar_seccion( $id, $uri): Modifica la Secci�n
	//
	function modificar_seccion( $id, $uri ) {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Modificar Secci&oacute;n';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		
		// genera la barra de dirección
		$enlaces = array (
			'secciones' 						=> 'Secciones',
			'modificar_seccion/'.$id.'/'.$uri	=> $titulo,
		);
		$this->get_barra( $enlaces );
		$datos['barra'] = $this->barra;
		
		// información de la sección
		$seccion = $this->documentos_admin_model->get_seccion( $id );
		if( $seccion->num_rows() > 0 ) {
			foreach( $seccion->result() as $row ) {
				$datos['nom'] = $row->Seccion;
				$datos['com'] = $row->Comun;
				$datos['uri'] = 'admin/documentos/'.$uri;
			}
		}
		
		// estructura de la p�gina(1)
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/documentos/modificar_seccion',$datos);
		$this->load->view('admin/_estructura/footer');
		
		if( $_POST ){		
			// reglas de validaci�n
			$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la modificación a la base de datos si todo ha estado bien
			else{
				if( $this->documentos_admin_model->modifica_seccion( $id ) ) {
					// msj de �xito
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "La secci&oacute;n se ha modificador correctamente";
					$datos['enlace'] = 'admin/documentos/'.$uri;
					$this->load->view('mensajes/ok_redirec',$datos);
				}
			}
		}
	}
}
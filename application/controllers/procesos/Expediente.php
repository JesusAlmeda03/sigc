<?php 
/****************************************************************************************************
*
*	CONTROLLERS/procesos/expediente.php
*
*		Descripción:
*			Expedientes de los usuarios del sistema
*
*		Fecha de Creación:
*			10/Enero/2013
*
*		Ultima actualización:
*			10/Enero/2013
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas 
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expediente extends CI_Controller {
	
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
			$this->load->model('procesos/expediente_model','',TRUE);
		}
	}
	
/** Funciones **/	
	//
	// listado(): Listado de los usuarios del área para poder actualizar / revisar si expediente 
	//
	function listado() {
		// variables necesarias para la página
		$datos['titulo'] = 'Listado de Expedientes de Usuarios';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
		
		// Obtiene a los usuarios del área
		$datos['usuarios'] = $this->expediente_model->get_usuarios();
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/expediente/listado',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
	
	//
	// agregar(): Agregar una evidencia al expediente de un usuario 
	//
	function agregar( $id ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "procesos/expediente/listado" );
		}
		
		// variables necesarias para la página
		$datos['titulo'] = 'Actualizar Expediente de Usuario';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		
		// Obtiene el nombre del usuario
		$usuario = $this->expediente_model->get_usuario( $id );
		foreach( $usuario->result() as $row  ) {
			$datos['nombre_usuario'] = $row->Nombre.' '.$row->Paterno.' '.$row->Materno;
			break;
		}
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		if( $_POST ){		
			// configuración del archivos a subir
			$nom_doc = $this->input->post('id_area')."-".$id."-".substr(md5(uniqid(rand())),0,6);
			//$descripcion = $this->input->post('descripcion');
			$config['file_name'] = $nom_doc;
			$config['upload_path'] = './includes/docs/expedientes/';
			$config['allowed_types'] = '*';
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

				// se guarda el documento
				if( $this->expediente_model->inserta_expediente( $id, $nom_doc ) ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "El archivo se ha guardado correctamente<br />¿deseas agregar otro para éste usuario?";
					$datos['enlace_si'] = "procesos/expediente/agregar/".$id;
					$datos['enlace_no'] = "procesos/expediente/listado";
					$this->load->view('mensajes/pregunta_enlaces',$datos);
				}
			}
		}

		// estructura de la página (2)
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/expediente/agregar',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
	
	//
	// revisar(): Revisa el expediente de un usuario 
	//
	function revisar( $id ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "procesos/expediente/listado" );
		}
		
		// variables necesarias para la página
		$datos['titulo'] = 'Expediente de Usuario';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		
		// Obtiene los datos del usuario
		$usuario_expediente = $this->expediente_model->get_usuario( $id );
		foreach( $usuario_expediente->result() as $row  ) {
			$datos['nombre_usuario'] = $row->Nombre.' '.$row->Paterno.' '.$row->Materno;
			break;
		}
		$datos['usuario_expediente'] = $usuario_expediente;
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/expediente/revisar',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}

	//
	// eliminar(): Revisa el expediente de un usuario 
	//
	function eliminar( $id ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "procesos/expediente/listado" );
		}
		
		// variables necesarias para la página
		$datos['titulo'] = 'Expediente de Usuario';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		
		// Obtiene los datos del usuario
		$usuario_expediente = $this->expediente_model->get_usuario( $id );
		foreach( $usuario_expediente->result() as $row  ) {
			$datos['nombre_usuario'] = $row->Nombre.' '.$row->Paterno.' '.$row->Materno;
			break;
		}

		$this->db->query('DELETE FROM ab_expediente WHERE IdExpediente=$id LIMIT 1');
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/expediente/revisar',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
}
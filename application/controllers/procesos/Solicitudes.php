<?php 
/****************************************************************************************************
*
*	CONTROLLERS/procesos/solicitudes.php
*
*		Descripción:
*			Solicitudes de Documentos
*
*		Fecha de Creación:
*			03/Octubre/2011
*
*		Ultima actualización:
*			14/Noviembre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas 
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Solicitudes extends CI_Controller {
	
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
			$this->load->model('procesos/solicitudes_model','',TRUE);
		}
		$this->session->userdata('id_sistema');
	}
	
/** Funciones **/	
	//
	// altas(): Inicia el proceso de solicitud de alta de documentos
	//
	function alta() {
		// variables necesarias para la página
		$datos['titulo'] = 'Solicitud de Alta de Documentos';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		
		// obtiene las secciones para las solicitudes
		$secciones = $this->solicitudes_model->get_secciones();
		if( $secciones->num_rows() > 0 ) {
			$datos['seccion_options'] = array();
			foreach( $secciones->result() as $row ) {
				$datos['seccion_options'][$row->IdSeccion] = $row->Seccion." (".$row->Abreviatura.")";
			}
		}
		
		// inserta la solicitud
		if( $_POST ){		
			// reglas de validación
			$this->form_validation->set_rules('codigo', 'C&oacute;digo', 'trim');
			$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
			$this->form_validation->set_rules('causas', 'Causas', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserci�n a la base de datos si todo ha estado bien
			else{				
				// configuraci�n de los archivos a subir				
				$nom_doc = $this->session->userdata('id_area')."-".$this->input->post('seccion')."-".substr(md5(uniqid(rand())),0,6);
				$config['file_name'] = $nom_doc;
				$config['upload_path'] = './includes/docs/';
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
					
					// inserta el documento
					$id_sol = $this->solicitudes_model->inserta_alta( $nom_doc );
					if( $id_sol ) {						
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						$datos['mensaje'] = "La solicitud se ha guardado, ahora debes realizar la lista de distribuci&oacute;n";
						$datos['enlace'] = "procesos/solicitudes/lista_distribucion/".$id_sol."/0";
						$this->load->view('mensajes/ok_redirec',$datos);
					}
					else {
						$datos['mensaje_titulo'] = "Error";
						$datos['mensaje'] = "Ha ocurrido un error, la solicitud no se ha guardado";
						$datos['enlace'] = "procesos/solicitudes/alta";
						$this->load->view('mensajes/ok_redirec',$datos);
					}
				}
			}
		}

		// estructura de la página (2)
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/solicitudes/alta',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}

	//
	// documento(): Inicia el proceso de solicitud de baja / modificacion eligiendo el documento
	//
	function documento( $solicitud ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "inicio" );
		}
		
		switch( $solicitud ) {
			// baja
			case "baja" :
				$titulo = "Solicitud de Baja de Documentos";
				break;
				
			// modificacion
			case "modificacion":
				$titulo = "Solicitud de Modificaci&oacute;n de Documentos";
				break;
				
			// error
			default :
				redirect("pagina/error_404");
				break;
		}
		
		// variables necesarias para la página
		$datos['titulo'] = $titulo;
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['solicitud'] = $solicitud;
		$datos['busqueda'] = false;
		$datos['cod'] = '';
		$datos['nom'] = '';
		$datos['sec'] = '';

		// obtiene las secciones para las solicitudes
		$secciones = $this->solicitudes_model->get_secciones();
		if( $secciones->num_rows() > 0 ) {
			$datos['seccion_options'][0] = "";
			foreach( $secciones->result() as $row ) {
					$datos['seccion_options'][$row->IdSeccion] = $row->Seccion." (".$row->Abreviatura.")";	
				
				
			}
		}
		
		// obtiene los documentos de la seccion solicitada
		if( $_POST ){
			$del = 0;
			$datos['busqueda'] = true;			
			$datos['sec'] = $this->input->post('seccion');
			$this->Inicio_model->set_sort( 15 );
			$datos['sort_tabla'] = $this->Inicio_model->get_sort();

			$datos['consulta'] = $this->solicitudes_model->get_documentos( $datos['sec'] );
		}
		else {
			$datos['busqueda'] = false;
		}
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/solicitudes/documento',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');			
	}

	//
	// baja( $idd ): Continua el proceso de solicitud de baja de documentos
	//
	function baja( $idd ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "procesos/solicitudes/documento/baja" );
		}
		
		// variables necesarias para la página
		$datos['titulo'] = 'Solicitud de Baja de Documentos';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		// obtiene los datos del documento
		$consulta = $this->solicitudes_model->get_documento( $idd );
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) {
				$datos['cod'] = $row->Codigo;
				$datos['nom'] = $row->Nombre;
				$datos['sec'] = $row->Seccion;
				$datos['fec'] = $this->Inicio_model->set_fecha( $row->Fecha );
			}
		}
		else {
			redirect( "procesos/solicitudes/documento/baja" );
		}
		
		// inserta la solicitud
		if( $_POST ){		
			// reglas de validación
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
			$this->form_validation->set_rules('causas', 'Causas', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else{
				// realiza las inserciones
				$id_sol = $this->solicitudes_model->inserta_baja( $idd ); 
				if( $id_sol ) {							
					// msj de �xito
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "La solicitud se ha guardado, ahora debes realizar la lista de distribuci&oacute;n";
					$datos['enlace'] = "procesos/solicitudes/lista_distribucion/".$id_sol."/0";
					$this->load->view('mensajes/ok_redirec',$datos);
				}
			}
		}

		// estructura de la página (2)	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/solicitudes/baja',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
	
	//
	// modificaciones( $idd ): Continua el proceso de solicitud de modificacion de documentos
	//
	function modificacion( $idd ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "procesos/solicitudes/documento/modificacion" );
		}
		
		// variables necesarias para la página
		$datos['titulo'] = 'Solicitud de Modificaci&oacute;n de Documentos';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		// obtiene los datos del documento
		$consulta = $this->solicitudes_model->get_documento( $idd );
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row )  {
				$datos['cod'] = $row->Codigo;
				$datos['nom'] = $row->Nombre;
				$datos['sec'] = $row->Seccion;
				$datos['fec'] = $row->Fecha;
				$datos['edi'] = $row->Edicion;
				$datos['ids'] = $row->IdSeccion;
			}
		}
		else {
			redirect( "procesos/solicitudes/documento/modificacion" );
		}
		
		// inserta la solicitud
		if( $_POST ){		
			// reglas de validaci�n
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
			$this->form_validation->set_rules('causas', 'Causas', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserci�n a la base de datos si todo ha estado bien
			else{				
				// configuraci�n de los archivos a subir				
				$nom_doc = $this->session->userdata('id_area')."-".$this->input->post('seccion')."-".substr(md5(uniqid(rand())),0,6);
				$config['file_name'] = $nom_doc;
				$config['upload_path'] = './includes/docs/';
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

					// realiza las inserciones
					$id_sol = $this->solicitudes_model->inserta_modificacion( $idd, $nom_doc );
					if( $id_sol ) {
						// msj de �xito
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						$datos['mensaje'] = "La solicitud se ha guardado, ahora debes realizar la lista de distribuci&oacute;n";
						$datos['enlace'] = "procesos/solicitudes/lista_distribucion/".$id_sol."/0";
						$this->load->view('mensajes/ok_redirec',$datos);
					}
				}
			}
		}
		
		// estructura de la página (2)
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/solicitudes/modificacion',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}

	//
	// lista_distribucion( $ids ): Realiza la lista de distribucion de la solicitud
	//
	function lista_distribucion( $ids, $etapa ) {
		// regresa si no trae las variables
		if( $this->uri->segment(5) === false ) {
			redirect( "inicio" );
		}
		
		if( $this->uri->segment(5) || $this->uri->segment(6) ) {
			$edo = $this->uri->segment(5);
			$tip = $this->uri->segment(6);
		}
		else {
			$edo = "";
			$tip = "";
		}
		$datos['estado'] = $edo;
		$datos['tipo'] = $tip;
		
		// variables necesarias para la página
		$datos['titulo'] = 'Lista de Distribuci&oacute;n';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['id'] = $ids;
		
		// obtiene todos los usuarios activos del area
		$datos['usuarios'] = $this->solicitudes_model->get_usuarios();
		$lista_distribucion = $this->solicitudes_model->get_lista_distribucion( $ids );
		$datos['lista_distribucion'] = $lista_distribucion;
		
		// revisa si la solicitud ya tiene soliciador o autoizador
		$datos['solicitador'] = false;
		$datos['autorizador'] = false;
		if( $lista_distribucion->num_rows() > 0 ) {
			foreach ( $lista_distribucion->result() as $row ) {
				if( $row->Tipo == 1 ) {
					$datos['solicitador'] = true;
				}
				if( $row->Tipo == 2 ) {
					$datos['autorizador'] = true;
				}
			}
		}
		
		// estructura de la p�gina
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/solicitudes/lista_distribucion',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
		
		// realiza la insercion
		if( $_POST ) {
			// reglas de validaci�n
			$this->form_validation->set_rules('distribucion[]', 'la Lista de Distribuci&oacute;n', 'required|trim');
			// si la solicitud ya se ha generado y solo se esta agregando a alguien a la lista de distribución
			if( !$etapa ) {
				$this->form_validation->set_rules('solicitador[]', 'el Solicitador', 'required|trim');
				$this->form_validation->set_rules('autorizador[]', 'el Autorizador', 'required|trim');
			}			
			$this->form_validation->set_message('required', 'Debes elegir <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			else {
				if( $this->solicitudes_model->inserta_lista_distribucion( $ids ) ) {
					// si la solicitud ya se ha generado y solo se esta agregando a alguien a la lista de distribución
					if( $edo != '' || $tip != '' ) {
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						$datos['mensaje'] = "Los cambios en la lista de distribuci&oacute;n se han guardado correctamente";
						$datos['enlace'] = "procesos/solicitudes/ver_lista_distribucion/".$ids."/".$edo."/".$tip;
						$this->load->view('mensajes/ok_redirec',$datos);
					}
					// si se esta generando la solicitud
					else {
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						$datos['mensaje'] = "La lista de distribuci&oacute;n se ha guardado correctamente";
						$datos['enlace'] = "procesos/solicitudes/ver/".$ids;
						$this->load->view('mensajes/ok_redirec',$datos);
					}
				}
			}
		}
	}

	//
	// ver_solicitud( $ids ): Muestra el resumen de la solicitud
	//
	function ver( $ids ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "listados/solicitudes" );
		}
		
		// obtiene las variables para mostrar el listado específico
		if( $this->uri->segment(5) || $this->uri->segment(6) ) {
			$datos['estado'] = $this->uri->segment(5);
			$datos['tipo'] = $this->uri->segment(6);
		}
		else {
			$datos['estado'] = '';
			$datos['tipo'] = '';
		}
		
		// variables necesarias para la página
		$datos['titulo'] = 'Solicitud';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['ids'] = $ids;

		// obtiene la lista
		$consulta = $this->solicitudes_model->get_solicitud( $ids ); 
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) :				
				$datos['doc'] = $row->Ruta;
				switch( substr($row->Fecha,5,2) ) {
					case "01" : $mes = "Enero"; break;
					case "02" : $mes = "Febrero"; break;
					case "03" : $mes = "Marzo"; break;
					case "04" : $mes = "Abril"; break;
					case "05" : $mes = "Mayo"; break;
					case "06" : $mes = "Junio"; break;
					case "07" : $mes = "Julio"; break;
					case "08" : $mes = "Agosto"; break;
					case "09" : $mes = "Septiembre"; break;
					case "10" : $mes = "Octubre"; break;
					case "11" : $mes = "Noviembre"; break;
					case "12" : $mes = "Diciembre"; break;
				}
				$datos['fec'] = substr($row->Fecha,8,2)." / ".$mes." / ".substr($row->Fecha,0,4);
				$datos['tip'] = $row->Solicitud;
				$datos['cau'] = $row->Causas;				
				$datos['cod'] = $row->Codigo;
				$datos['edi'] = $row->Edicion;
				$datos['nom'] = $row->Nombre;
				$datos['titulo'] .= ' de '.$row->Solicitud; 
				if( $row->Observaciones == "" )
					$datos['obs'] = '<label style="font-size:11px; font-style:italic">No hay observaciones</label>';
				else
					$datos['obs'] = $row->Observaciones;
			endforeach;
		} 
		else {
			redirect( "listados/solicitudes" );
		}
		
		if( $datos['tip'] == "Modificacion" ) {
			$consulta = $this->solicitudes_model->get_solicitud_modificacion( $ids ); 
			if( $consulta->num_rows() > 0 ) {
				foreach( $consulta->result() as $row ) {				
					$datos['doc'] = $row->Ruta;						
					$datos['cod'] = $row->Codigo;
					$datos['edi'] = $row->Edicion;
					$datos['nom'] = $row->Nombre;						
				}
			}
		}
		
		// estructura de la p�gina
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/solicitudes/ver',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
	
	//
	// solicitar(): Listado de solicitudes a autorizar por el Solicitador
	//
	function solicitar() {
		// variables necesarias para la página
		$datos['titulo'] = 'Autorizar tus Solicitudes';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
		$datos['autorizador'] = 'solicitar';
		$tipo = 1; // Solicitador

		// obtiene las solicitudes para el solicitador
		$datos['solicitudes'] = $this->solicitudes_model->get_solicitudes( $tipo, '0' );
				
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/solicitudes/autorizar',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
		
		// guarda los datos
		if( $_POST ) {
			// Todas las solicitudes pendientes
			if( $this->input->post('solicitud') ) {
				// msj de guardado
				if( $this->solicitudes_model->modifica_solicitud( $tipo ) ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "Los cambios en las solicitudes se han guardado";
					if( $this->input->post('boton_aceptar') != "" ) {	
						$datos['enlace'] = "listados/solicitudes/aceptadas-solicitador";
					}
					elseif( $this->input->post('boton_rechazar') != "" ) {
						$datos['enlace'] = "listados/solicitudes/rechazadas";
					}
					$this->load->view('mensajes/ok_redirec',$datos);
				}
				// msj de error
				else {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error, no todas las solicitudes se han aceptado. Por favor intentalo de nuevo";
					$datos['enlace'] = "procesos/solicitudes/solicitar";
					$this->load->view('mensajes/ok_redirec',$datos);											
				}
			}
			else{
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = "Debes elegir al menos una Solicitud";				
				$this->load->view('mensajes/error', $datos);
			}
		}
	}

	//
	// autorizar(): Listado de solicitudes a autorizar por el Autorizador
	//
	function autorizar() {
		// variables necesarias para la página
		$datos['titulo'] = 'Autorizar Solicitudes';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
		$datos['autorizador'] = 'autorizar';
		$tipo = 2; // Autorizador

		// obtiene las solicitudes para el solicitador
		$datos['solicitudes'] = $this->solicitudes_model->get_solicitudes( $tipo, '1' );
				
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/solicitudes/autorizar',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
		
		// guarda los datos
		if( $_POST ) {
			// Todas las solicitudes pendientes
			if( $this->input->post('solicitud') ) {
				// Todas las solicitudes pendientes
				if( $this->solicitudes_model->modifica_solicitud( $tipo ) ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "Los cambios en las solicitudes se han guardado";
					if( $this->input->post('boton_aceptar') != "" ) {
						$datos['enlace'] = "listados/solicitudes/aceptadas-autorizador";
					}
					elseif( $this->input->post('boton_rechazar') != "" ) {
						$datos['enlace'] = "listados/solicitudes/rechazadas";
					}
					$this->load->view('mensajes/ok_redirec',$datos);
				}
				// msj de error
				else {				
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error, no todas las solicitudes se han aceptado. Por favor intentalo de nuevo";
					$datos['enlace'] = "procesos/solicitudes/autorizar/".$tipo;
					$this->load->view('mensajes/ok_redirec',$datos);											
				}
			}
			else{
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = "Debes elegir al menos una Solicitud";				
				$this->load->view('mensajes/error', $datos);
			}
		}
	}
	
	//
	// ver_lista_distribucion( $ids ): Muestra la lista de distribucion de la solicitud
	//
	function ver_lista_distribucion( $ids ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "listados/solicitudes" );
		}
		
		// obtiene las variables para mostrar el listado específico
		if( $this->uri->segment(5) || $this->uri->segment(6) ) {
			$datos['estado'] = $this->uri->segment(5);
			$datos['tipo'] = $this->uri->segment(6);
		}
		else {
			$datos['estado'] = '';
			$datos['tipo'] = '';
		}

		// variables necesarias para la página
		$datos['titulo'] = 'Lista de Distribuci&oacute;n';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
		$datos['ids'] = $ids;

		// obtiene la lista
		$datos['usuarios'] = $this->solicitudes_model->get_lista_distribucion_usuarios( $ids ); 
		
		// estructura de la p�gina
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_eliminar_distribucion',$datos);
		$this->load->view('procesos/solicitudes/ver_lista_distribucion',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
	
	//
	// eliminar_lista_distribucion( $id_solicitud, $id_usuario ): Elimina a un usuario de la lista de distribución
	//
	function eliminar_lista_distribucion( $id_solicitud, $id_usuario, $redirecciona ) {
		if( $this->solicitudes_model->eliminar_lista_distribucion( $id_solicitud, $id_usuario ) ) {
			$redirecciona = str_replace( "-", "/", $redirecciona );
			redirect( 'procesos/solicitudes/ver_lista_distribucion/'.$id_solicitud."/".$redirecciona );
		}
	}

	//
	// modificar( $ids ): Modifica las solicitudes
	//
	function modificar( $ids ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "listados/solicitudes" );
		}
		
		// obtiene las variables para mostrar el listado específico
		if( $this->uri->segment(5) || $this->uri->segment(6) ) {
			$edo = $this->uri->segment(5);
			$tip = $this->uri->segment(6);
		}
		else {
			$edo = '';
			$tip = '';
		}
		$datos['estado'] = $edo;
		$datos['tipo'] = $tip;
		
		// variables necesarias para la página
		$datos['titulo'] = 'Modificaci&oacute;n de Solicitud';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['seccion_nombre'] = '<label style="font-style:italic; font-size:11px">No Encontrada</label>';

		// estructura de la p�gina
		$this->load->view('_estructura/header',$datos);
		
		// obtiene la información de la solicitud		
		$solicitud = $this->solicitudes_model->get_solicitud( $ids );
		if( $solicitud->num_rows() > 0 ) {			
			foreach( $solicitud->result() as $row ) {
				$idd = $row->IdDocumento; 
				$tipo = $row->Solicitud;
				$datos['tipo_solicitud'] = $row->Solicitud;
				$datos['codigo'] = $row->Codigo;
				$datos['nombre'] = $row->Nombre;
				$datos['id_seccion'] = $row->IdSeccion;				
				$datos['fecha'] = $row->Fecha;				
				$datos['causas'] = $row->Causas;
				switch( $row->Solicitud ) {
					case "Alta" :
						$datos['ruta'] = $row->Ruta;
						break;
						
					case "Baja" :
						$datos['ruta'] = $row->Ruta;
						break;
						
					case "Modificacion" :
						$doc_sol = $this->solicitudes_model->get_solicitud_modificacion( $ids );
						if( $doc_sol->num_rows() > 0 ) {			
							foreach( $doc_sol->result() as $row_d ) {
								$datos['ruta'] = $row_d->Ruta;
							}
						}
						break;
				}							
			}
		}
		else {
			redirect( "listados/solicitudes" );
		}
		
		// obtiene las secciones para las solicitudes
		$secciones = $this->solicitudes_model->get_secciones();
		if( $secciones->num_rows() > 0 ) {
			$datos['seccion_options'] = array();
			foreach( $secciones->result() as $row ) {
				$datos['seccion_options'][$row->IdSeccion] = $row->Seccion;
				if( $row->IdSeccion == $datos['id_seccion'] )
					$datos['seccion_nombre'] = $row->Seccion;
			}
		}

		// modifica la solicitud
		if( $_POST ){		
			// reglas de validación
			if( $tipo != 'Baja' ) {
				$this->form_validation->set_rules('codigo', 'C&oacute;digo', 'trim');
				$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
			}
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
			$this->form_validation->set_rules('causas', 'Causas', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else {
				$resp = true;
				// si se va a modificar el documento
				if( $this->input->post('mod_archivo') ) {
					// configuración de los archivos a subir				
					$nom_doc = $this->session->userdata('id_area')."-".$this->input->post('seccion')."-".substr(md5(uniqid(rand())),0,6);
					$config['file_name'] = $nom_doc;
					$config['upload_path'] = './includes/docs/';
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
					}										
				}
				else {
					$nom_doc = '';
				}
				
				// modifica los datos del documento y la solicitud
				if( $this->solicitudes_model->modificar( $ids, $idd, $tipo, $nom_doc ) ) {
					// msj de éxito
					$datos['mensaje_titulo'] = "&Eacute;xito al Modificar";
					$datos['mensaje'] = "La solicitud se ha modificado correctamente";
					if( $edo != '' || $tip != '' ) {
						switch( $edo ) {
							default :
								$datos['enlace'] = "listados/solicitudes/".$edo."/".$tip;
								break;
								
							case 'solicitar' :	
								$datos['enlace'] = "procesos/solicitudes/solicitar";
								break;
								
							case 'autorizar' :
								$datos['enlace'] = "procesos/solicitudes/autorizar";
								break;
								
							case 'rechazadas' :
								$datos['enlace'] = "procesos/solicitudes/rechazadas";
								break;
						}
					}
					$this->load->view('mensajes/ok_redirec',$datos);
				}
			}
		}

		// estructura de la p�gina (2)	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_eliminar_distribucion',$datos);
		$this->load->view('procesos/solicitudes/modificar',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}

	//
	// rechazadas(): Muestra las solicitudes rechazadas
	//
	function rechazadas() {
		// variables necesarias para la página
		$datos['titulo'] = 'Solicitudes Rechazadas';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();		

		// obtiene el listado de las solicitudes
		$datos['solicitudes'] = $this->solicitudes_model->get_rechazadas();		
				
		// estructura de la p�gina
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view( 'mensajes/pregunta_oculta_usuario' );
		$this->load->view('procesos/solicitudes/rechazadas',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
		
		// guarda los datos
		if( $_POST ) {
			// Todas las solicitudes pendientes
			if( $this->input->post('solicitud') ) {	
				// msj de guardado
				if( $this->solicitudes_model->rechazar() ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "La solicitud se ha restaurado correctamente";
					$datos['enlace'] = "listados/solicitudes/rechazadas";
					$this->load->view('mensajes/ok_redirec',$datos);
				}
				// msj de error
				else {				
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error, no todas las solicitudes se han restaurado. Por favor intentalo de nuevo";
					$datos['enlace'] = "procesos/solicitudes/autorizar/".$tipo;
					$this->load->view('mensajes/ok_redirec',$datos);											
				}
			}
			else {
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = "Debes elegir al menos una Solicitud";				
				$this->load->view('mensajes/error', $datos);
			}
		}
	}

	//
	// revisar(): La lista de distribución revise los cambios de las solicitudes
	//
	function revisar() {
		// variables necesarias para la página
		$datos['titulo'] = 'Revisar cambios en los Documentos';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
		$datos['autorizador'] = 'revisar';

		// obtiene el listado de las solicitudes
		$datos['solicitudes'] = $this->solicitudes_model->get_revisar();

		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/solicitudes/autorizar',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
		
		// guarda los datos
		if( $_POST ) {
			// Aceptar solicitudes
			if( $this->input->post('boton_aceptar') != "" && $this->input->post('solicitud') ) {
				// msj de guardado
				if( $this->solicitudes_model->revisar() ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "El sistema ha registrado que has revisado los cambios en los documentos";
					$datos['enlace'] = "procesos/solicitudes/revisar";
					$this->load->view('mensajes/ok_redirec',$datos);
				}
				// msj de error
				else {				
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error, no todas las solicitudes se han aceptado. Por favor intentalo de nuevo";
					$datos['enlace'] = "procesos/solicitudes/";
					$this->load->view('mensaje/sok_redirec',$datos);											
				}
			}
			else{
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = "Debes elegir al menos una Solicitud";				
				$this -> load -> view('mensajes/error', $datos);
			}
		}
	}
}
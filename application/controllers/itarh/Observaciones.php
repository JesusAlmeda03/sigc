<?php 
/****************************************************************************************************
*
*	CONTROLLERS/itrh/observaciones.php
*
*		Descripción:
*			Observaciones
*
*		Fecha de Creación:
*			08/Octubre/2012
*
*		Ultima actualización:
*			08/Octubre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Observaciones extends CI_Controller {
	
/** Atributos **/
	private $menu;
	private $barra;

/** Propiedades **/
	public function set_menu() {
		$this->menu = $this->inicio_itarh_model->get_menu( 'observaciones' );
	}

	public function get_barra( $enlaces ) {
		$this->barra = '<a href="'.base_url().'index.php/itarh/inicio">Inicio</a>';
		
		foreach( $enlaces as $enlace => $titulo ) {
			$this->barra .= '
				<img src="'.base_url().'includes/img/arrow_right.png"/>
				<a href="'.base_url().'index.php/itarh/observaciones/'.$enlace.'">'.$titulo.'</a>
			';
		}
	}
		
/** Constructor **/	
	function __construct() {
		parent::__construct();
		
		// validacion de administrador
		if ( $this->session->userdata('id_usuario') ) {
			if ( $this->session->userdata('id_area') != 1 && 
				 $this->session->userdata('id_area') != 4 && 
				 $this->session->userdata('id_area') != 5 && 
				 $this->session->userdata('id_area') != 10 &&
				 $this->session->userdata('id_area') != 11 
				) {
				redirect( 'inicio' );
			}
			else {
				$this->load->model('itarh/inicio_itarh_model','',TRUE);
				$this->load->model('itarh/observaciones_itarh_model','',TRUE);
				$this->set_menu();
			}
		}
		else {
			redirect('itarh/inicio/login');
		}
	}

/** Funciones **/
	//
	// altas(): Añade una nueva observación
	//
	function altas() {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Alta de Observaciones Detectadas';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		
		// genera la barra de dirección
		$this->get_barra( array( 'index' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
			
		// revisa si ya se a enviado el formulario por post	
		if( $_POST ){
			// reglas de validación
			$this->form_validation->set_rules('quincena', 'quincena', 'trim');
			$this->form_validation->set_rules('mes', 'mes', 'trim');
			$this->form_validation->set_rules('ano', 'ano', 'trim');
			$this->form_validation->set_rules('matricula', 'matricula', 'required|trim');
			$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
			$this->form_validation->set_rules('unidad', 'unidad', 'trim');
			$this->form_validation->set_rules('empleado', 'empleado', 'trim');
			$this->form_validation->set_rules('permanencia', 'permanencia', 'trim');
			$this->form_validation->set_rules('contrato', 'contrato', 'trim');
			$this->form_validation->set_rules('sistema', 'sistema', 'trim');
			$this->form_validation->set_rules('contraloria', 'contraloria', 'trim');
			$this->form_validation->set_rules('observacion', 'Observaci&oacute;n', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else{
				if( $this->observaciones_itarh_model->inserta_observacion() ) {
					// msj de éxito
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "La observaci&oacute;n se ha guardado correctamente.<br />&iquest;Deseas agregar otra?";
					$datos['enlace_si'] = "itarh/observaciones/altas";
					$datos['enlace_no'] = "itarh/observaciones/listado/todos/pendientes";
					$this->load->view('mensajes/pregunta_enlaces',$datos);
				}
				else {
					// error
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error al querer guardar la informaci&oacute;n";
					$this->load->view('mensajes/error',$datos);
				}
			}
		}

		// estructura de la página (2)
		$this->load->view('itarh/_estructura/top',$datos);
		$this->load->view('itarh/_estructura/usuario',$datos);
		$this->load->view('itarh/observaciones/altas',$datos);
		$this->load->view('itarh/_estructura/footer');
	}

	//
	// listado(): Listado de las observación
	//
	function listado() {
		// si los datos han sido enviados por post se sobre escribe la variable $are
		if( $_POST ) {
			$quincena = $this->input->post('quincena');
			$estado = $this->input->post('estado');
		}
		else {
			if( $this->uri->segment(4) || $this->uri->segment(5) ) {
				$quincena = $this->uri->segment(4);
				$estado = $this->uri->segment(5);
			}
			else {
				$quincena = 'todos';
				$estado = 'todos';
			}
		}
		$datos['quincena'] = $quincena;
		$datos['estado'] = $estado;
		
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Listado de Observaciones Detectadas';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_itarh_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->inicio_itarh_model->get_sort();
		
		// genera la barra de dirección
		$this->get_barra( array( 'listado' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		 // obtiene el listado de observaciones
		 $datos['consulta'] = $this->observaciones_itarh_model->get_observaciones( $quincena, $estado );
		 
		 // obtiene las quincenas disponibles
		 $consulta = $this->observaciones_itarh_model->get_quincenas();
		 $quincena = array();
		 if( $consulta->num_rows() > 0 ) {
		 	$quincena['todos'] = ' - Todas las Quincenas - ';
		 	foreach( $consulta->result() as $row ) {
		 		$rep = str_replace(' ', '-', $row->Quincena);
		 		$quincena[$rep] = $row->Quincena;
		 	}
		 }
		 $datos['quincena_options'] = $quincena;
		 
		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('itarh/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta_usuario',$datos);
		$this->load->view('itarh/_estructura/usuario',$datos);
		$this->load->view('itarh/observaciones/listado',$datos);
		$this->load->view('itarh/_estructura/footer');
	}
	
	//
	// excel( $quincena, $estado ): Exporta el listado a excel
	//
	function excel( $quincena, $estado) {
		$datos['quincena'] = $quincena;
		
		// obtiene el listado de observaciones
		$datos['consulta'] = $this->observaciones_itarh_model->get_observaciones( $quincena, $estado );		 
		 
		// estructura de la página
		$this->load->view('itarh/observaciones/excel',$datos);
	}

	//
	// resolver( $id ): Resuelve una observación
	//
	function resolver( $id ) {
		// variables del listado
		if( $this->uri->segment(5) ) {
			$enlace = $this->uri->segment(5);
		}
		else {
			$enlace = '';
		}
		$enlace = str_replace('_', '/', $enlace);
		$datos['enlace'] = $enlace;
		
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Resolver Observaciones Detectadas';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		
		// genera la barra de dirección
		$this->get_barra( array( 'resolver/'.$id => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// obtiene la info de la observación 
		$consulta = $this->observaciones_itarh_model->get_observacion( $id );
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) {
				$datos['quincena']		= $row->Quincena;
				$datos['matricula']		= $row->Matricula;
				$datos['nombre']		= $row->Nombre;
				$datos['unidad']		= $row->Unidad;
				$datos['empleado']		= $row->Empleado;
				$datos['permanencia']	= $row->Permanencia;
				$datos['contrato']		= $row->Horas;
				$datos['sistema']		= $row->Sistema;
				$datos['contraloria']	= $row->Contraloria;
				$datos['observacion']	= $row->Observacion;
			}
		}
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
			
		// revisa si ya se a enviado el formulario por post	
		if( $_POST ){
			// reglas de validación
			$this->form_validation->set_rules('accion', 'Acci&oacute;n Correctiva', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else{
				if( $this->observaciones_itarh_model->inserta_resolver( $id ) ) {
					// msj de éxito
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "La acci&oacute;n se ha guardado correctamente.";
					$datos['enlace'] = "itarh/observaciones/listado/".$enlace;
					$this->load->view('mensajes/ok_redirec',$datos);
				}
				else {
					// error
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error al querer guardar la informaci&oacute;n";
					$this->load->view('mensajes/error',$datos);
				}
			}
		}

		// estructura de la página (2)
		$this->load->view('itarh/_estructura/top',$datos);
		$this->load->view('itarh/_estructura/usuario',$datos);
		$this->load->view('itarh/observaciones/resolver',$datos);
		$this->load->view('itarh/_estructura/footer');
	}

	//
	// detalles( $id ): Detalles de la observación solventada
	//
	function detalles( $id ) {
		// variables del listado
		if( $this->uri->segment(5) ) {
			$enlace = $this->uri->segment(5);
		}
		else {
			$enlace = '';
		}
		$enlace = str_replace('_', '/', $enlace);
		$datos['enlace'] = $enlace;
		
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Detalles de la Observaci&oacute;n';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		
		// genera la barra de dirección
		$this->get_barra( array( 'detalles/'.$id => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// obtiene la info de la observación 
		$consulta = $this->observaciones_itarh_model->get_observacion( $id );
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) {
				$datos['quincena']		= $row->Quincena;
				$datos['matricula']		= $row->Matricula;
				$datos['nombre']		= $row->Nombre;
				$datos['unidad']		= $row->Unidad;
				$datos['empleado']		= $row->Empleado;
				$datos['permanencia']	= $row->Permanencia;
				$datos['contrato']		= $row->Horas;
				$datos['sistema']		= $row->Sistema;
				$datos['contraloria']	= $row->Contraloria;
				$datos['observacion']	= $row->Observacion;
				$datos['accion']		= $row->Accion;
			}
		}
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('itarh/_estructura/top',$datos);
		$this->load->view('itarh/_estructura/usuario',$datos);
		$this->load->view('itarh/observaciones/detalles',$datos);
		$this->load->view('itarh/_estructura/footer');
	}

	//
	// modificar( $id ): Modifica una observación
	//
	function modificar( $id ) {
		// variables del listado
		if( $this->uri->segment(5) ) {
			$enlace = $this->uri->segment(5);
		}
		else {
			$enlace = '';
		}
		$enlace = str_replace('_', '/', $enlace);
		$datos['enlace'] = $enlace;
		
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Modificar Observacion';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		
		// genera la barra de dirección
		$this->get_barra( array( 'modificar/'.$id => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// obtiene la info de la observación 
		$consulta = $this->observaciones_itarh_model->get_observacion( $id );
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) {
				$mes = substr($row->Quincena, 20, 3);
				switch( $mes ) {
					case 'Ene' : $datos['mes'] = 'Enero'; break;
					case 'Feb' : $datos['mes'] = 'Febrero'; break;
					case 'Mar' : $datos['mes'] = 'Marzo'; break;
					case 'Abr' : $datos['mes'] = 'Abril'; break;
					case 'May' : $datos['mes'] = 'Mayo'; break;
					case 'Jun' : $datos['mes'] = 'Junio'; break;
					case 'Jul' : $datos['mes'] = 'Julio'; break;
					case 'Ago' : $datos['mes'] = 'Agosto'; break;
					case 'Sep' : $datos['mes'] = 'Septiembre'; break;
					case 'Oct' : $datos['mes'] = 'Octubre'; break;
					case 'Nov' : $datos['mes'] = 'Noviembre'; break;
					case 'Dic' : $datos['mes'] = 'Diciembre'; break;
				}
				$datos['id_usuario']	= $row->IdUsuario;
				$datos['quincena'] 		= substr($row->Quincena, 0, 7);
				$datos['ano'] 			= substr($row->Quincena, -4);
				$datos['matricula']		= $row->Matricula;
				$datos['nombre']		= $row->Nombre;
				$datos['unidad']		= $row->Unidad;
				$datos['empleado']		= $row->Empleado;
				$datos['permanencia']	= $row->Permanencia;
				$datos['contrato']		= $row->Horas;
				$datos['sistema']		= $row->Sistema;
				$datos['contraloria']	= $row->Contraloria;
				$datos['observacion']	= $row->Observacion;
				$datos['accion']		= $row->Accion;
				$datos['estado']		= $row->Estado;
			}
		}

		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
			
		// revisa si ya se a enviado el formulario por post	
		if( $_POST ){
			// reglas de validación
			$this->form_validation->set_rules('quincena', 'quincena', 'trim');
			$this->form_validation->set_rules('mes', 'mes', 'trim');
			$this->form_validation->set_rules('ano', 'ano', 'trim');
			$this->form_validation->set_rules('matricula', 'matricula', 'required|trim');
			$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
			$this->form_validation->set_rules('unidad', 'unidad', 'trim');
			$this->form_validation->set_rules('empleado', 'empleado', 'trim');
			$this->form_validation->set_rules('permanencia', 'permanencia', 'trim');
			$this->form_validation->set_rules('contrato', 'contrato', 'trim');
			$this->form_validation->set_rules('sistema', 'sistema', 'trim');
			$this->form_validation->set_rules('contraloria', 'contraloria', 'trim');
			$this->form_validation->set_rules('observacion', 'Observaci&oacute;n', 'required|trim');
			if( $datos['estado'] == 1 ) {
				$this->form_validation->set_rules('accion', 'Acci&oacute;n Correctiva', 'required|trim');
			}
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else{
				if( $this->observaciones_itarh_model->modificar_observacion( $id, $datos['estado'] ) ) {
					// msj de éxito
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "La observaci&oacute;n se ha modificado correctamente.";
					$datos['enlace'] = "itarh/observaciones/listado/".$enlace;
					$this->load->view('mensajes/ok_redirec',$datos);
				}
				else {
					// error
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error al querer guardar la informaci&oacute;n";
					$this->load->view('mensajes/error',$datos);
				}
			}
		}
		
		// estructura de la página (2)
		$this->load->view('itarh/_estructura/top',$datos);
		$this->load->view('itarh/_estructura/usuario',$datos);
		$this->load->view('itarh/observaciones/modificar',$datos);
		$this->load->view('itarh/_estructura/footer');
	}
}
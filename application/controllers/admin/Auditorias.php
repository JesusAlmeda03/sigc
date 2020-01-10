<?php 
/****************************************************************************************************
*
*	CONTROLLERS/admin/auditorias.php
*
*		Descripción:
*			Controlador de los proceso para automazitar las auditorías
*
*		Fecha de Creación:
*			23/Octubre/2012
*
*		Ultima actualización:
*			23/Octubre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auditorias extends CI_Controller {
	
/** Atributos **/
	private $menu;
	private $barra;

/** Propiedades **/
	public function set_menu() {
		$this->menu = $this->inicio_admin_model->get_menu( 'auditorias' );
	}
	
	public function get_barra( $enlaces ) {
		$this->barra = '<a href="'.base_url().'index.php/admin/inicio">Inicio</a>';
		
		foreach( $enlaces as $enlace => $titulo ) {
			$this->barra .= '
				<img src="'.base_url().'includes/img/arrow_right.png"/>
				<a href="'.base_url().'index.php/admin/auditorias/'.$enlace.'">'.$titulo.'</a>
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
				$this->load->model('admin/auditorias_admin_model','',TRUE);
				
				$this->set_menu();
			}
		}
		else {
			redirect( 'inicio' );
		}
	}

/** Funciones **/
	//
	// generar(): Genera un programa de auditoría
	//
	function generar() {		
		// variables necesarias para la estructura de la página
		$titulo = 'Generar Programa Auditor&iacute;a';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		
		// genera la barra de dirección
		$this->get_barra( array( 'generar' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		// Datos enviados por el usuarios
		if( $_POST ) {
			// reglas de validación
			$this->form_validation->set_rules('ano', 'A&ntilde;o', 'required|trim');
			$this->form_validation->set_rules('inicio', 'el Inicio de la Auditor&iacute;a', 'required|trim');
			$this->form_validation->set_rules('termino', 'el Termino de la Auditor&iacute;a', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else{
				if( $this->auditorias_admin_model->inserta_programa() ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "El Programa de Auditor&iacute;a se ha guardado correctamente";
					$datos['enlace'] = "admin/auditorias/programa_especifico/".$this->input->post('ano')."/".$this->input->post('auditoria');
					$this->load->view('mensajes/ok_redirec',$datos);
				}
				else {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error al guardar los datos";
					$this->load->view('mensajes/error',$datos);
				}
			}
		}
		
		// estructura de la página (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/auditorias/generar',$datos);
		$this->load->view('admin/_estructura/footer');
	}
	
	
	
	//
	// modificar_auditoria( $id ): Modifica una auditoria
	//
	function modificar_auditoria( $id ) {
		if( $this->uri->segment(5) || $this->uri->segment(6) || $this->uri->segment(7) ) {
			$ano = $this->uri->segment(5);
			$aud = $this->uri->segment(6);
			$edo = $this->uri->segment(7);
		}
		else {
			$ano = 'elige';
			$aud = 'todos';
			$edo = 'todos';
		}
		$datos['ano'] = $ano;
		$datos['auditoria'] = $aud;
		$datos['estado'] = $edo;
		
		// variables necesarias para la estructura de la página
		$titulo = 'Modificar Auditor&iacute;a';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		
		// genera la barra de dirección
		$this->get_barra( array( 'modificar_anual' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// obtiene los programas en base al año
		$auditoria = $this->auditorias_admin_model->get_auditoria( $id );
		if( $auditoria->num_rows() > 0 ) {
			foreach( $auditoria->result() as $row ) {
				$datos['ano'] 		= $row->Ano;
				$datos['inicio'] 	= $row->Inicio;
				$datos['termino'] 	= $row->Termino;
				$datos['auditoria'] = $row->Auditoria;
			}
		}
		else {
			redirect('inicio');
		}
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		// Datos enviados por el usuarios
		if( $_POST ) {
			// reglas de validación
			$this->form_validation->set_rules('ano', 'C&oacute;digo', 'trim');
			$this->form_validation->set_rules('inicio', 'el Inicio de la Auditor&iacute;a', 'trim');
			$this->form_validation->set_rules('termino', 'el Termino de la Auditor&iacute;a', 'trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else{
				if( $this->auditorias_admin_model->modifica_auditoria( $id ) ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "La Auditor&iacute;a se ha modificado correctamente";
					$datos['enlace'] = "admin/auditorias/programa_especifico/".$ano."/".$aud."/".$edo;
					$this->load->view('mensajes/ok_redirec',$datos);
				}
				else {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error al guardar los datos";
					$this->load->view('mensajes/error',$datos);
				}
			}
		}
		
		// estructura de la página (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/auditorias/modificar_auditoria',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// procesos( $id ): Asigna procesos a una auditoría
	//
	function procesos( $id ) {
		if( !$this->uri->segment(4) ) {
			redirect('inicio');
		}

		if( $this->uri->segment(5) || $this->uri->segment(6) || $this->uri->segment(7) ) {
			$ano = $this->uri->segment(5);
			$aud = $this->uri->segment(6);
			$edo = $this->uri->segment(7);
		}
		else {
			$ano = 'elige';
			$aud = 'todos';
			$edo = 'todos';
		}
		$datos['ano'] = $ano;
		$datos['auditoria'] = $aud;
		$datos['estado'] = $edo;

		// auditoria
		$auditoria = $this->auditorias_admin_model->get_auditoria( $id );
		foreach( $auditoria->result() as $row ) {
			$periodo = 'del '.$this->Inicio_model->set_fecha( $row->Inicio ).' al '.$this->Inicio_model->set_fecha( $row->Termino );
			if( $ano != 'especifico' ) {
				$ano 	 = $row->Ano;
			}
		}
				
		// variables necesarias para la estructura de la página
		$titulo = 'Procesos a Auditar';
		$datos['titulo'] = $titulo;
		$datos['titulo_pagina'] = $titulo.':<br /><span style="font-size:18px">Auditor&iacute;a '.$periodo.'</span>';
		$datos['menu'] = $this->menu;
		$datos['id_auditoria'] = $id;
		
		// genera la barra de dirección
		$this->get_barra( 
			array(
				'programa_especifico/'.$ano.'/'.$aud.'/'.$edo	=> 'Programa Espec&iacute;fico de Auditor&iacute;as',
				'generar_especifico' 						=> $titulo 
			) 
		);
		$datos['barra'] = $this->barra;
		
		// obtiene los procesos disponibles para esta auditoría
		$datos['procesos'] = $this->auditorias_admin_model->get_procesos( $id );
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		// Datos enviados por el usuarios
		if( $_POST ) {
			// envia mensaje de error si no se cumple con alguna regla
			if( !$this->input->post('procesos') ){
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = "Debes de elegir al menos un proceso";
				$this->load->view('mensajes/error',$datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else {
				if( $this->auditorias_admin_model->inserta_auditoria_procesos( $id ) ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "Los Procesos han sido asignados a esta Auditor&iacute;a";
					if( $ano != 'especifico' ) {
						$datos['enlace'] = "admin/auditorias/programa_especifico/".$ano."/".$aud."/".$edo;
					}
					else {
						$datos['enlace'] = "admin/auditorias/especifico/".$id;
					}
					$this->load->view('mensajes/ok_redirec',$datos);
				}
				else {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error al guardar los datos";
					$this->load->view('mensajes/error',$datos);
				}
			}
		}
		
		// estructura de la página (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/auditorias/procesos',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// equipos( $id ): Genera los equipos de esta auditoría
	//
	function equipos( $id ) {
		if( !$this->uri->segment(4) ) {
			redirect('inicio');
		}

		if( $this->uri->segment(5) || $this->uri->segment(6) || $this->uri->segment(7) ) {
			$ano = $this->uri->segment(5);
			$aud = $this->uri->segment(6);
			$edo = $this->uri->segment(7);
		}
		else {
			$ano = 'elige';
			$aud = 'todos';
			$edo = 'todos';
		}
		$datos['ano'] = $ano;
		$datos['auditoria'] = $aud;
		$datos['estado'] = $edo;

		// auditoria		
		$auditoria = $this->auditorias_admin_model->get_auditoria( $id );
		foreach( $auditoria->result() as $row ) {
			$periodo = 'del '.$this->Inicio_model->set_fecha( $row->Inicio ).' al '.$this->Inicio_model->set_fecha( $row->Termino );
			if( $ano != 'especifico' ) {
				$ano 	 = $row->Ano;
			}
		}
				
		// variables necesarias para la estructura de la página
		$datos['menu'] = $this->menu;
		$datos['id_auditoria'] = $id;
		
		if( $ano == 'especifico' ) {
			// variables necesarias para la estructura de la página
			$titulo = 'Modificar Equipo';
			$datos['titulo'] = $titulo;
			$datos['titulo_pagina'] = $titulo.':<br /><span style="font-size:18px">Auditor&iacute;a '.$periodo.'</span>';
			
			// genera la barra de dirección
			$this->get_barra( 
				array(
					'especifico/'.$id			=> 'Programa Espec&iacute;fico',
					'equipos_modificar/'.$id 	=> $titulo
				)
			);
			$datos['barra'] = $this->barra;
			
			// si es modificación obtiene los datos del equipo
			if( $aud == 'modificar' ) {
				$equipo = $this->auditorias_admin_model->get_equipo( $edo );
				foreach( $equipo->result() as $row ) {
					$datos['equipo'] = $row->Nombre;
				}
			}
		}
		else {
			// variables necesarias para la estructura de la página
			$titulo = 'Generar Equipos: Auditor&iacute;a';
			$datos['titulo'] = $titulo;
			$datos['titulo_pagina'] = $titulo.':<br /><span style="font-size:18px">Auditor&iacute;a '.$periodo.'</span>';
			$datos['equipo'] = '';
			
			// genera la barra de dirección
			$this->get_barra( 
				array(
					'programa_especifico/'.$ano.'/'.$aud.'/'.$edo	=> 'Programa Espec&iacute;fico de Auditor&iacute;as',
					'equipos/'.$id 								=> $titulo
				)
			);
			$datos['barra'] = $this->barra;
		}
		
		// auditories
		$datos['auditores'] = $this->auditorias_admin_model->get_auditores( $id );
		
		// equipos ya formados para esta auditoría
		$datos['equipos'] = $this->auditorias_admin_model->get_auditores_equipo( $id );
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		// Datos enviados por el usuarios
		if( $_POST ) {
			$nuevos_auditores = true;
			// envia mensaje de error si no se cumple con alguna regla
			if( !$this->input->post('usuario') && $ano != 'especifico' ) {
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = "Debes de elegir al menos un auditor";
				$this->load->view('mensajes/error',$datos);
			}
			else {
				if( !$this->input->post('usuario') ) {
					$nuevos_auditores = false;
				}
				$this->form_validation->set_rules('equipo', 'Equipo', 'required|trim');
				$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
				
				// envia mensaje de error si no se cumple con alguna regla
				if( $this->form_validation->run() == FALSE ){
					$this->load->view('mensajes/error_validacion',$datos);
				}
				// realiza la inserción a la base de datos si todo ha estado bien
				else{
					if( $aud == 'modificar' ) {
						$resp = $this->auditorias_admin_model->modificar_auditoria_equipo( $id, $edo, $nuevos_auditores );
						$datos['mensaje'] = "Los cambios se han guardado";
						$vista_mensaje = 'ok_redirec.php';
					}
					else {
						$resp = $this->auditorias_admin_model->inserta_auditoria_equipo( $id );
						$datos['mensaje'] = "Se ha creado un equipo para esta Auditor&iacute;a<br />&iquest;Deseas crear otro?";
						$vista_mensaje = 'pregunta_enlaces';
					}
					if( $resp ) {
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						if( $ano == 'especifico' ) {
							if( $aud == 'modificar' ) {
								$datos['enlace'] = "admin/auditorias/especifico/".$id;
							}
							else {
								$datos['enlace_si'] = "admin/auditorias/equipos/".$id."/".$ano;
								$datos['enlace_no'] = "admin/auditorias/especifico/".$id;
							}
						}
						else {
							$datos['enlace_si'] = "admin/auditorias/equipos/".$id."/".$ano."/".$aud."/".$edo;
							$datos['enlace_no'] = "admin/auditorias/programa_especifico/".$ano."/".$aud."/".$edo;
						}
						$this->load->view('mensajes/'.$vista_mensaje,$datos);
					}
					else {
						$datos['mensaje_titulo'] = "Error";
						$datos['mensaje'] = "Ha ocurrido un error al guardar los datos";
						$this->load->view('mensajes/error',$datos);
					}
				}
			}
		}
		
		// estructura de la página (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/auditorias/equipos',$datos);
		$this->load->view('admin/_estructura/footer');
	}
	
	//
	// programa_especifico(): Listado de los programas especificos de auditorias
	//
	function programa_especifico() {
		if( $_POST ) {
			$ano = $this->input->post( 'ano' );
			$aud = $this->input->post( 'auditoria' );
			$edo = $this->input->post( 'estado' );
		}	
		else {
			if( $this->uri->segment(4) || $this->uri->segment(5) || $this->uri->segment(6) ) {
				$ano = $this->uri->segment(4);
				$aud = $this->uri->segment(5);
				$edo = $this->uri->segment(6);
			}
			else {
				$ano = 'elige';
				$aud = 'todos';
				$edo = 'todos';
			}
		}
		$datos['ano'] = $ano;
		$datos['auditoria'] = $aud;
		$datos['estado'] = $edo;
			
		// variables necesarias para la estructura de la página
		$titulo = 'Programas Espec&iacute;ficos de Auditor&iacute;as';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$this->get_barra( array( 'programa_especifico' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// obtiene los años de los cuales hay programas
		$programa_anos = $this->auditorias_admin_model->get_programa_especifico( 'anos', 'todos', 'todos' );
		if( $programa_anos->num_rows > 0 ) {
			$anos = array();
			$anos['elige'] = ' - Selecciona un a&ntilde;o - ';
			foreach( $programa_anos->result() as $row ) {
				$anos[$row->Ano] = $row->Ano;
			}
			$datos['anos'] = $anos;
		}
		else {
			$datos['anos'] = array();
		}
			
		// obtiene los programas en base al año
		$datos['programa'] = $this->auditorias_admin_model->get_programa_especifico( $ano, $aud, $edo );
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/auditorias/programa_especifico',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// procesos_equipos( $id ): Asigna los procesos a los equipos para una auditoría
	//
	function procesos_equipos( $id ) {		
		if( !$this->uri->segment(4) ) {
			redirect('inicio');
		}

		if( $this->uri->segment(5) || $this->uri->segment(6) || $this->uri->segment(7) ) {
			$ano = $this->uri->segment(5);
			$aud = $this->uri->segment(6);
			$edo = $this->uri->segment(7);
		}
		else {
			$ano = 'elige';
			$aud = 'todos';
			$edo = 'todos';
		}
		$datos['ano'] = $ano;
		$datos['auditoria'] = $aud;
		$datos['estado'] = $edo;

		// auditoria		
		$auditoria = $this->auditorias_admin_model->get_auditoria( $id );
		foreach( $auditoria->result() as $row ) {
			$periodo = 'del '.$this->Inicio_model->set_fecha( $row->Inicio ).' al '.$this->Inicio_model->set_fecha( $row->Termino );
			if( $ano != 'especifico' ) {
				$ano 	 = $row->Ano;
			}
		}

		// variables necesarias para la estructura de la página
		$titulo = 'Asignar Procesos a Equipos';
		$datos['titulo'] = $titulo;
		$datos['titulo_pagina'] = $titulo.':<br /><span style="font-size:18px">Auditor&iacute;a '.$periodo.'</span>';
		$datos['menu'] = $this->menu;
		$datos['id_auditoria'] = $id;
		
		// genera la barra de dirección
		$this->get_barra( 
			array(
				'programa_especifico/'.$ano.'/'.$aud.'/'.$edo	=> 'Programa Espec&iacute;fico de Auditor&iacute;as', 
				'procesos_equipos' => $titulo 
			)
		);
		$datos['barra'] = $this->barra;		
			
		// obtiene los procesos para esta auditoría
		$datos['procesos'] = $this->auditorias_admin_model->get_procesos_disponibles( $id );
		
		// obtiene los equipos para esta auditoría
		$datos['equipos'] = $this->auditorias_admin_model->get_equipos_disponibles( $id );
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		// Datos enviados por el usuarios
		if( $_POST ) {
			// envia mensaje de error si no se cumple con alguna regla
			if( !$this->input->post('proceso') ){
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = "Debes de elegir al menos un proceso";
				$this->load->view('mensajes/error',$datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else{
				$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
				$this->form_validation->set_rules('hora', 'Hora', 'required|trim');
				$this->form_validation->set_message('required', 'Debes elegir el campo <strong>%s</strong>');
				
				// envia mensaje de error si no se cumple con alguna regla
				if( $this->form_validation->run() == FALSE ){
					$this->load->view('mensajes/error_validacion',$datos);
				}
				// realiza la inserción a la base de datos si todo ha estado bien
				else{
					if( $this->auditorias_admin_model->inserta_procesos_equipos( $id ) ) {
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						$datos['mensaje'] = "Se han asignado correctamente los Procesos al Equipo para esta auditor&iacute;a<br />&iquest;Deseas realizar otra asignaci&oacute;n?";
						if( $ano == 'especifico' ) {
							$datos['enlace_si'] = "admin/auditorias/procesos_equipos/".$id."/".$ano."/".$aud."/".$edo;
							$datos['enlace_no'] = "admin/auditorias/especifico/".$id;
						}
						else {
							$datos['enlace_si'] = "admin/auditorias/procesos_equipos/".$id."/".$ano."/".$aud."/".$edo;
							$datos['enlace_no'] = "admin/auditorias/programa_especifico/".$ano."/".$aud."/".$edo;
						}
						$this->load->view('mensajes/pregunta_enlaces',$datos);
					}
					else {
						$datos['mensaje_titulo'] = "Error";
						$datos['mensaje'] = "Ha ocurrido un error al guardar los datos";
						$this->load->view('mensajes/error',$datos);
					}
				}
			}
		}
		
		// estructura de la página (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/auditorias/procesos_equipos',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// especifico( $id ): Programa específico de auditoría
	//
	function especifico( $id ) {		
		if( !$this->uri->segment(4) ) {
			redirect('inicio');
		}

		if( $this->uri->segment(5) || $this->uri->segment(6) || $this->uri->segment(7) ) {
			$ano = $this->uri->segment(5);
			$aud = $this->uri->segment(6);
			$edo = $this->uri->segment(7);
		}
		else {
			$ano = 'elige';
			$aud = 'todos';
			$edo = 'todos';
		}
		$datos['ano'] = $ano;
		$datos['auditoria'] = $aud;
		$datos['estado'] = $edo;

		// variables necesarias para la estructura de la página
		$titulo = 'Programa Espec&iacute;fico de Auditor&iacute;a';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$datos['id_auditoria'] = $id;
		
		// genera la barra de dirección
		$this->get_barra( 
			array(
				'programa_especifico/'.$ano.'/'.$aud.'/'.$edo	=> 'Programa Espec&iacute;fico de Auditor&iacute;as', 
				'especifico' => $titulo 
			)
		);
		$datos['barra'] = $this->barra;		

		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
				
		// Datos enviados por el usuarios
		if( $_POST ) {
			// reglas de validación
			$this->form_validation->set_rules('objetivo', 'Objetivo de la Auditor&iacute;a', 'trim');
			$this->form_validation->set_rules('alcance', 'Alcance de la Auditor&iacute;a', 'trim');
			$this->form_validation->set_rules('lider', 'Auditor Lider', 'trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else{
				if( $this->auditorias_admin_model->actualiza_auditoria( $id ) ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "Los datos de la Auditor&iacute;a Espec&iacute;fica se han guardado";
					$datos['enlace'] = "admin/auditorias/especifico/".$id."/".$ano."/".$aud."/".$edo;
					$this->load->view('mensajes/ok_redirec',$datos);
				}
				else {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error al guardar los datos";
					$this->load->view('mensajes/error',$datos);
				}
			}
		}

		// obtiene información de la auditoria
		$auditoria = $this->auditorias_admin_model->get_auditoria( $id );
		foreach( $auditoria->result() as $row ) {
			if( !$row->Estado ) {
				if( $row->Alcance == '' || $row->Objetivo == '' || $row->Lider == '') {
					$datos['estado_auditoria'] = 'pendiente';
				}
				else {
					$datos['estado_auditoria'] = 'activar';
					$datos['objetivo'] 	= $row->Objetivo;
					$datos['alcance'] 	= $row->Alcance;
					$datos['lider']		= $row->Lider;
				}
			}
			else {
				$datos['estado_auditoria'] = 'completa';
				$datos['objetivo'] 	= $row->Objetivo;
				$datos['alcance'] 	= $row->Alcance;
				$datos['lider']		= $row->Lider;
			}
		}
		
		// si se van a modificar los datos
		if( $this->uri->segment(8) == 'modificar' ) {
			$datos['estado_auditoria'] = 'modificar';
		}
		
		// obtiene los equipos para esta auditoría
		$datos['equipos'] = $this->auditorias_admin_model->get_equipos( $id );
		
		// obtiene la relacion los equipos y los procesos que van a auditar 
		$datos['equipos_procesos'] = $this->auditorias_admin_model->get_equipos_procesos( $id );
		
		// obtiene los procesos para esta auditoría
		$datos['procesos'] = $this->auditorias_admin_model->get_procesos_auditoria( $id );
		
		// obtiene las relaciones procesos-documentos para obtener las areas
		$datos['procesos_documentos'] = $this->auditorias_admin_model->get_procesos_documentos( $id );
		
		// obtiene los auditores para esta auditoría
		$datos['auditores'] = $this->auditorias_admin_model->get_auditores_equipo( $id );
		
		// estructura de la página (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/auditorias/especifico',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// generar(): Genera un programa de auditoría
	//
	function revisar_avances() {		
		if( $_POST ) {
			$ano = $this->input->post( 'ano' );
			$aud = $this->input->post( 'auditoria' );
			$edo = $this->input->post( 'estado' );
		}	
		else {
			if( $this->uri->segment(4) || $this->uri->segment(5) || $this->uri->segment(6) ) {
				$ano = $this->uri->segment(4);
				$aud = $this->uri->segment(5);
				$edo = $this->uri->segment(6);
			}
			else {
				$ano = 'elige';
				$aud = 'todos';
				$edo = 'todos';
			}
		}
		$datos['ano'] = $ano;
		$datos['auditoria'] = $aud;
		$datos['estado'] = $edo;
			
		// variables necesarias para la estructura de la página
		$titulo = 'Revisar Avances de los Procesos';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$this->get_barra( array( 'revisar_avances/'.$ano.'/'.$aud.'/'.$edo => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// obtiene los años de los cuales hay programas
		$programa_anos = $this->auditorias_admin_model->get_programa_especifico( 'anos', 'todos', 'todos' );
		if( $programa_anos->num_rows > 0 ) {
			$anos = array();
			$anos['elige'] = ' - Selecciona un a&ntilde;o - ';
			foreach( $programa_anos->result() as $row ) {
				$anos[$row->Ano] = $row->Ano;
			}
			$datos['anos'] = $anos;
		}
		else {
			$datos['anos'] = array();
		}
			
		// obtiene los programas en base al año
		$datos['programa'] = $this->auditorias_admin_model->get_programa_especifico( $ano, $aud, $edo );
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/auditorias/revisar',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	function revisar_procesos( $id ) {		
		if( !$this->uri->segment(4) ) {
			redirect('inicio');
		}

		if( $this->uri->segment(5) || $this->uri->segment(6) || $this->uri->segment(7) ) {
			$ano = $this->uri->segment(5);
			$aud = $this->uri->segment(6);
			$edo = $this->uri->segment(7);
		}
		
		$datos['ano'] = $ano;
		$datos['auditoria'] = $aud;
		$datos['estado'] = $edo;

		// variables necesarias para la estructura de la página
		$titulo = 'Revisar Procesos';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$datos['id_auditoria'] = $id;
		
		// genera la barra de dirección
		$this->get_barra( 
			array(
				'revisar_avances/'.$ano.'/'.$aud.'/'.$edo	=> 'Revisar Avances de los Procesos', 
				'revisar_procesos/'.$id.'/'.$ano.'/'.$aud.'/'.$edo => $titulo 
			)
		);
		$datos['barra'] = $this->barra;		

		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
				
		
		

		// obtiene información de la auditoria
		$auditoria = $this->auditorias_admin_model->get_auditoria( $id );
		foreach( $auditoria->result() as $row ) {
			if( !$row->Estado ) {
				if( $row->Alcance == '' || $row->Objetivo == '' || $row->Lider == '') {
					$datos['estado_auditoria'] = 'pendiente';
				}
				else {
					$datos['estado_auditoria'] = 'activar';
					$datos['objetivo'] 	= $row->Objetivo;
					$datos['alcance'] 	= $row->Alcance;
					$datos['lider']		= $row->Lider;
				}
			}
			else {
				$datos['estado_auditoria'] = 'completa';
				$datos['objetivo'] 	= $row->Objetivo;
				$datos['alcance'] 	= $row->Alcance;
				$datos['lider']		= $row->Lider;
			}
		}
		
		// si se van a modificar los datos
		if( $this->uri->segment(8) == 'modificar' ) {
			$datos['estado_auditoria'] = 'modificar';
		}
		
		// obtiene los equipos para esta auditoría
		$datos['equipos'] = $this->auditorias_admin_model->get_equipos( $id );
		
		// obtiene la relacion los equipos y los procesos que van a auditar 
		$datos['equipos_procesos'] = $this->auditorias_admin_model->get_equipos_procesos( $id );
		
		// obtiene los procesos para esta auditoría
		$datos['procesos'] = $this->auditorias_admin_model->get_procesos_auditoria( $id );
		
		// obtiene las relaciones procesos-documentos para obtener las areas
		$datos['procesos_documentos'] = $this->auditorias_admin_model->get_procesos_documentos( $id );
		
		// obtiene los auditores para esta auditoría
		$datos['auditores'] = $this->auditorias_admin_model->get_auditores_equipo( $id );
		
		//obtiene los procesos
		$condicion= array(
			'au_auditorias.IdAuditoria' => $id,
		);
		$this->db->join('au_equipos', 'au_auditorias.IdAuditoria=au_equipos.IdAuditoria');
		$this->db->join('au_equipos_procesos', 'au_equipos_procesos.IdEquipo=au_equipos.IdEquipo');
		$this->db->join('au_procesos', 'au_procesos.IdProcesos=au_equipos_procesos.IdProceso');
		$datos['consulta'] = $this->db->get_where('au_auditorias', $condicion);
		
		//No conformidades
		
		$this->db->join('au_equipos', 'au_auditorias.IdAuditoria=au_equipos.IdAuditoria');
		$this->db->join('au_equipos_usuarios', 'au_equipos.IdEquipo=au_equipos_usuarios.IdEquipo');
		$this->db->join('pa_conformidades', 'pa_conformidades.IdUsuario=au_equipos_usuarios.IdUsuario');
		$this->db->join('ab_departamentos', 'ab_departamentos.IdDepartamento=pa_conformidades.IdDepartamento');
		$this->db->join('ab_areas', 'ab_departamentos.IdArea=ab_areas.IdArea');
		
	 	$datos['consulta3'] = $this->db->get_where('au_auditorias', $condicion); //array('au_equipos_usuarios.IdEquipo >'=>0));
		
		//$datos['consulta3']= $this->db->get_where( 'au_auditorias', $condicion);
		// estructura de la página (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/auditorias/revisar_procesos',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	function listas_procesos( $id, $proceso) {		
		if( !$this->uri->segment(4) ) {
			redirect('inicio');
		}

		if( $this->uri->segment(5) || $this->uri->segment(6) || $this->uri->segment(7) ) {
			$ano = $this->uri->segment(5);
			$aud = $this->uri->segment(6);
			$edo = $this->uri->segment(7);
		}
		else {
			$ano = 'elige';
			$aud = 'todos';
			$edo = 'todos';
		}
		$datos['ano'] = $ano;
		$datos['auditoria'] = $aud;
		$datos['estado'] = $edo;

		// variables necesarias para la estructura de la página
		$titulo = 'Lista de Verificaci&oacuten';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$datos['id_auditoria'] = $id;
		$datos['proceso']=$proceso;
		// genera la barra de dirección
		$this->get_barra( 
			array(
				'revisar_avances/'.$ano.'/todos/todos'	=> 'Revisar Avances de los Procesos', 
				'revisar_procesos/'.$id.'/'.$ano.'/'.$aud.'/'.$edo => 'Revisar Procesos', 
				'listas_procesos/'.$id.'/'. $proceso.'/'.'ver/' => 'Lista de Verificaci&oacuten'
			)
		);
		$datos['barra'] = $this->barra;

		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
				
		// Datos enviados por el usuarios
		if( $_POST ) {
			// reglas de validación
			$this->form_validation->set_rules('objetivo', 'Objetivo de la Auditor&iacute;a', 'trim');
			$this->form_validation->set_rules('alcance', 'Alcance de la Auditor&iacute;a', 'trim');
			$this->form_validation->set_rules('lider', 'Auditor Lider', 'trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else{
				if( $this->auditorias_admin_model->actualiza_auditoria( $id ) ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "Los datos de la Auditor&iacute;a Espec&iacute;fica se han guardado";
					$datos['enlace'] = "admin/auditorias/especifico/".$id."/".$ano."/".$aud."/".$edo;
					$this->load->view('mensajes/ok_redirec',$datos);
				}
				else {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error al guardar los datos";
					$this->load->view('mensajes/error',$datos);
				}
			}
		}

		// obtiene información de la auditoria
		$auditoria = $this->auditorias_admin_model->get_auditoria( $id );
		foreach( $auditoria->result() as $row ) {
			if( !$row->Estado ) {
				if( $row->Alcance == '' || $row->Objetivo == '' || $row->Lider == '') {
					$datos['estado_auditoria'] = 'pendiente';
				}
				else {
					$datos['estado_auditoria'] = 'activar';
					$datos['objetivo'] 	= $row->Objetivo;
					$datos['alcance'] 	= $row->Alcance;
					$datos['lider']		= $row->Lider;
				}
			}
			else {
				$datos['estado_auditoria'] = 'completa';
				$datos['objetivo'] 	= $row->Objetivo;
				$datos['alcance'] 	= $row->Alcance;
				$datos['lider']		= $row->Lider;
			}
		}
		
		// si se van a modificar los datos
		if( $this->uri->segment(8) == 'modificar' ) {
			$datos['estado_auditoria'] = 'modificar';
		}
		
		// obtiene los equipos para esta auditoría
		$datos['equipos'] = $this->auditorias_admin_model->get_equipos( $id );
		
		// obtiene la relacion los equipos y los procesos que van a auditar 
		$datos['equipos_procesos'] = $this->auditorias_admin_model->get_equipos_procesos( $id );
		
		// obtiene los procesos para esta auditoría
		$datos['procesos'] = $this->auditorias_admin_model->get_procesos_auditoria( $id );
		
		// obtiene las relaciones procesos-documentos para obtener las areas
		$datos['procesos_documentos'] = $this->auditorias_admin_model->get_procesos_documentos( $id );
		
		// obtiene los auditores para esta auditoría
		$datos['auditores'] = $this->auditorias_admin_model->get_auditores_equipo( $id );
		
		
		//consultas para la lista de VERIFICACION
		$condicion= array(
			'au_lista_verificacion_usuario.IdProceso' => $proceso,
			'au_lista_verificacion_usuario.IdAuditoria' => $id
		);
		$this->db->group_by('au_lista_verificacion.Pregunta');
		$this->db->join('au_lista_verificacion', 'au_lista_verificacion.IdListaVerificacion=au_lista_verificacion_usuario.IdListaVerificacion');
		$datos['consulta'] = $this->db->get_where('au_lista_verificacion_usuario', $condicion);
		
		//procesos
		$condicion2=array(
			'au_procesos.IdProcesos' => $proceso,
		);
		$datos['consulta2']=$this->db->get_where('au_procesos', $condicion2);
		// estructura de la página (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/auditorias/ver',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//Ver no conformiades
	function conformidades( $id, $proceso) {		
		if( !$this->uri->segment(4) ) {
			redirect('inicio');
		}

		if( $this->uri->segment(5) || $this->uri->segment(6) || $this->uri->segment(7) ) {
			$ano = $this->uri->segment(5);
			$aud = $this->uri->segment(6);
			$edo = $this->uri->segment(7);
		}
		else {
			$ano = 'elige';
			$aud = 'todos';
			$edo = 'todos';
		}
		$datos['ano'] = $ano;
		$datos['auditoria'] = $aud;
		$datos['estado'] = $edo;

		// variables necesarias para la estructura de la página
		$titulo = 'Lista de Verificaci&oacuten';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$datos['id_auditoria'] = $id;
		$datos['proceso']=$proceso;
		// genera la barra de dirección
		$this->get_barra( 
			array(
				'revisar_avances/'.$ano.'/todos/todos'	=> 'Revisar Avances de los Procesos', 
				'revisar_procesos/'.$id.'/'.$ano.'/'.$aud.'/'.$edo => 'Revisar Procesos', 
				'conformidades/'.$id.'/'. $proceso.'/'.'ver_conformidad/' => 'No Conformidad',
			)
		);
		$datos['barra'] = $this->barra;

		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
				
		// Datos enviados por el usuarios
		if( $_POST ) {
			// reglas de validación
			$this->form_validation->set_rules('objetivo', 'Objetivo de la Auditor&iacute;a', 'trim');
			$this->form_validation->set_rules('alcance', 'Alcance de la Auditor&iacute;a', 'trim');
			$this->form_validation->set_rules('lider', 'Auditor Lider', 'trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else{
				if( $this->auditorias_admin_model->actualiza_auditoria( $id ) ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "Los datos de la Auditor&iacute;a Espec&iacute;fica se han guardado";
					$datos['enlace'] = "admin/auditorias/especifico/".$id."/".$ano."/".$aud."/".$edo;
					$this->load->view('mensajes/ok_redirec',$datos);
				}
				else {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error al guardar los datos";
					$this->load->view('mensajes/error',$datos);
				}
			}
		}

		// obtiene información de la auditoria
		$auditoria = $this->auditorias_admin_model->get_auditoria( $id );
		foreach( $auditoria->result() as $row ) {
			if( !$row->Estado ) {
				if( $row->Alcance == '' || $row->Objetivo == '' || $row->Lider == '') {
					$datos['estado_auditoria'] = 'pendiente';
				}
				else {
					$datos['estado_auditoria'] = 'activar';
					$datos['objetivo'] 	= $row->Objetivo;
					$datos['alcance'] 	= $row->Alcance;
					$datos['lider']		= $row->Lider;
				}
			}
			else {
				$datos['estado_auditoria'] = 'completa';
				$datos['objetivo'] 	= $row->Objetivo;
				$datos['alcance'] 	= $row->Alcance;
				$datos['lider']		= $row->Lider;
			}
		}
		
		// si se van a modificar los datos
		if( $this->uri->segment(8) == 'modificar' ) {
			$datos['estado_auditoria'] = 'modificar';
		}
		
		// obtiene los equipos para esta auditoría
		$datos['equipos'] = $this->auditorias_admin_model->get_equipos( $id );
		
		// obtiene la relacion los equipos y los procesos que van a auditar 
		$datos['equipos_procesos'] = $this->auditorias_admin_model->get_equipos_procesos( $id );
		
		// obtiene los procesos para esta auditoría
		$datos['procesos'] = $this->auditorias_admin_model->get_procesos_auditoria( $id );
		
		// obtiene las relaciones procesos-documentos para obtener las areas
		$datos['procesos_documentos'] = $this->auditorias_admin_model->get_procesos_documentos( $id );
		
		// obtiene los auditores para esta auditoría
		$datos['auditores'] = $this->auditorias_admin_model->get_auditores_equipo( $id );
		
		
		//consultas para la lista de VERIFICACION
		$condicion= array(
			'pa_conformidades.IdConformidad' => $proceso
		);
		$this->db->group_by('pa_conformidades_acciones.IdConformidad');
		$this->db->join('pa_conformidades_acciones', 'pa_conformidades.IdConformidad=pa_conformidades_acciones.IdConformidad');
		$this->db->join('pa_conformidades_diagrama', 'pa_conformidades.IdConformidad=pa_conformidades_diagrama.IdConformidad');
		$this->db->join('ab_departamentos', 'ab_departamentos.IdDepartamento=pa_conformidades.IdDepartamento');
		$this->db->join('ab_usuarios', 'ab_usuarios.IdUsuario=pa_conformidades.IdUsuario');
		
		$datos['consulta'] = $this->db->get_where('pa_conformidades', $condicion);
		
		
		$condicion2= array(
			'pa_conformidades_seguimiento.IdConformidad' => $proceso
		);
		$datos['consulta2'] = $this->db->get_where('pa_conformidades_seguimiento', $condicion2);
		
		// estructura de la página (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/auditorias/ver_conformidad',$datos);
		$this->load->view('admin/_estructura/footer');
	}
}

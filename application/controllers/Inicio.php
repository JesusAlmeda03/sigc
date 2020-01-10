<?php
/****************************************************************************************************
*
*	CONTROLLERS/inicio.php
*
*		Descripción:
*			Inicio del Sistema de usuario - login
*
*		Fecha de Creación:
*			03/Octubre/2011
*
*		Ultima actualización:
*			09/Julio/2011
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {

/** Atributos **/

/** Propiedades **/

/** Constructor **/
	function __construct() {
		parent::__construct();
	}

/** Funciones **/
	//
	// Pagina Principal del Sistema
	//
	function index() {
		// obtiene las noticias
		$datos['noticias'] = $this->Inicio_model->get_noticias();

		// variables necesarias para la página
		$datos['titulo'] = "Inicio";
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'inicio/principal', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}


	function prueba() {
		echo "todo bien";
	}

	//
	// login(): Login del usuario
	//
	function login() {
		// si ya esta logueado
		if ( $this->session->userdata( 'id_usuario' ) ) {
			redirect( 'inicio' );
		}
		// si no esta logueado como usuario
		else {
			$validacion = $login = true;

			$this->form_validation->set_rules('usuario', 'Usuario', 'required|trim');
			$this->form_validation->set_rules('contrasena', 'Contrasena', 'required|trim|md5');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');

			// validación de los campos
			if( $this->form_validation->run() == FALSE ){
				$validacion = false;
			}
			// si es correcto revisa los datos
			else{
				$resp = $this->Inicio_model->login();

				// si se logueo redirecciona al inicio
				if( $resp ) {
					redirect( 'inicio' );
				}
				// si fallo
				else {
					$login = false;
				}
			}

			// si hubo un error vuelve a cargar la pagina mostrando los errores
			if( !$validacion || !$login ) {
				// variables necesarias para la página
				$datos['titulo'] = "Inicio";

				// obtiene las noticias
				$datos['noticias'] = $this->Inicio_model->get_noticias();

				// estructura de la página
				$this->load->view( '_estructura/header',$datos );
				$this->load->view( '_estructura/top', $datos );
				$this->load->view( 'inicio/principal', $datos );
				$this->load->view( '_estructura/right', $datos );
				$this->load->view( '_estructura/footer' );

				if( !$validacion ) {
					$this->load->view('mensajes/error_validacion');
				}
				elseif( !$login ) {
					$datos['mensaje_titulo'] = "Error de Login";
					$datos['mensaje'] = "Tu <strong>Usuario</strong> o <strong>Contrase&ntilde;a</strong> no son correctos";
					$this->load->view('mensajes/error',$datos);
				}
			}
		}
	}

	//
	// logout(): Logout del usuario
	//
	function logout() {
		$this->session->sess_destroy();
		redirect( 'inicio' );
	}

	//
	// error_404(): Error 404 de que la página no se encuentra
	//
	function error_404() {
		// estructura de la página
		$this->load->view( '_estructura/error_404' );
	}

	//
	// contacto(): Formulario de Contacto con el/los Administradores/Web Master
	//
	function contacto() {
		// variables necesarias para la página
		$datos['titulo'] = "Contacto";
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'inicio/contacto', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );

		// guarda los datos del contacto
		if( $_POST ) {
			$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
			$this->form_validation->set_rules('correo', 'Correo', 'required|trim');
			$this->form_validation->set_rules('mensaje', 'Mensaje', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');

			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			else{
				if( $this->Inicio_model->inserta_contacto() ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "Tu mensaje se ha enviado correctamente";
					$datos['enlace'] = "inicio";
					$this->load->view('mensajes/ok_redirec',$datos);
				}
			}
		}
	}

	//
	// noticias(): Listado de noticias
	//
	function noticias() {
		// variables necesarias para la página
		$datos['titulo'] = "Noticias";
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		// obtiene las noticias
		$datos['consulta'] = $this->Inicio_model->get_noticias();

		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'inicio/noticias', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}

	//
	// noticia( $id ): Muestra solo una noticia
	//
	function noticia( $id ) {
		// variables necesarias para la página
		$datos['titulo'] = "Noticia";
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		// obtiene la noticia
		$datos['consulta'] = $this->Inicio_model->get_noticia( $id );

		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'inicio/noticias', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}

	//
	// calendario( $m, $a ): Calendario
	//
	function calendario( $m, $a ) {
		$mes = '';
		switch( $m ) {
			case 1: $mes = "Enero"; break;
			case 2: $mes = "Febrero"; break;
			case 3: $mes = "Marzo"; break;
			case 4: $mes = "Abril"; break;
			case 5: $mes = "Mayo"; break;
			case 6: $mes = "Junio"; break;
			case 7: $mes = "Julio"; break;
			case 8: $mes = "Agosto"; break;
			case 9: $mes = "Septiembre"; break;
			case 10: $mes = "Octubre"; break;
			case 11: $mes = "Noviembre"; break;
			case 12: $mes = "Diciembre"; break;
		}
		$datos['mes'] = $mes;
		$datos['m'] = $m;
		$datos['ano'] = $a;
		$datos['calendario'] = $this->draw_calendar($m,$a,$this->Inicio_model->get_eventos());

		// variables necesarias para la página
		$datos['titulo'] = "Calendario";
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'inicio/calendario', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}

	//
	// draw_calendar( $month, $year, $consulta ): Genera el Calendario
	//
	function draw_calendar( $month, $year ,$consulta ) {
		$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
		$headings = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
		$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';
		$running_day = date('w',mktime(0,0,0,$month,1,$year));
		$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
		$days_in_this_week = 1;
		$day_counter = 0;
		$dates_array = array();
		$calendar.= '<tr class="calendar-row">';
		for($x = 0; $x < $running_day; $x++):
			$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
			$days_in_this_week++;
		endfor;

		for($list_day = 1; $list_day <= $days_in_month; $list_day++):
			$h_dia = date('j');
			$h_mes = date('m');
			$h_ano = date('Y');
			if( $list_day == $h_dia && $month == $h_mes && $year == $h_ano ) {
				$calendar.= '<td class="calendar-day" valign="top" style="background:#007799;">';
			}
			else{
				$calendar.= '<td class="calendar-day" valign="top">';
			}
			$calendar.= '<div class="day-number">'.$list_day.'</div>';
			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
			if( $consulta->num_rows() > 0 ) {
				foreach( $consulta->result() as $row ) :
					$dia = substr($row->Fecha,8,2);
					$mes = substr($row->Fecha,5,2);
					$ano = substr($row->Fecha,0,4);
					if ( $list_day == $dia && $month == $mes && $year == $ano )
						$calendar .= "<div class='text_day'>".$row->Evento."</div>";
				endforeach;
			}
			$calendar.= str_repeat('<p>&nbsp;</p>',2);
			$calendar.= '</td>';
			if($running_day == 6):
				$calendar.= '</tr>';
				if(($day_counter+1) != $days_in_month):
					$calendar.= '<tr class="calendar-row">';
				endif;
				$running_day = -1;
				$days_in_this_week = 0;
			endif;
			$days_in_this_week++; $running_day++; $day_counter++;
		endfor;

		if($days_in_this_week < 8):
			for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			  $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
			endfor;
		endif;

		$calendar.= '</tr>';
		$calendar.= '</table>';
		return $calendar;
	}

	//
	// enlaces(): Enlaces de Interes
	//
	function enlaces() {
		// variables necesarias para la página
		$datos['titulo'] = "Enlaces de Interes";
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		// obtiene los enlaces
		$datos['consulta'] = $this->Inicio_model->get_enlaces();

		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'inicio/enlaces', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}

	//
	// area(): Áreas específica
	//
	function area() {
		header( 'Location: ../' );
		/* obtiene los datos del area
		$consulta = $this->Inicio_model->get_area( $this->session->userdata('id_area') );
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) {
				$datos['titulo_area'] = $row->Area;
				$datos['paginaweb'] = $row->PaginaWeb;
			}
		}

		// variables necesarias para la página
		$datos['titulo'] = $datos['titulo_area'];
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'inicio/area', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );*/
	}

	//
	// datos(): Datos del Usuario
	//
	function datos() {
		// variables necesarias para la página
		$datos['titulo'] = "Datos del Usuario";
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		// obtiene los datos
		$datos['consulta'] = $this->Inicio_model->get_datos_usuario( $this->session->userdata('id_usuario') );

		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'inicio/datos', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}

	//
	// mod_datos(): Modificar los Datos del Usuario
	//
	function mod_datos() {
		// variables necesarias para la página
		$datos['titulo'] = "Modificar Datos del Usuario";
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		// obtiene los datos del usuario
		$datos['consulta'] = $this->Inicio_model->get_datos_usuario( $this->session->userdata('id_usuario') );

		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'inicio/datos_mod', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );

		if( $_POST ) {
			$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
			$this->form_validation->set_rules('paterno', 'Apellido Paterno', 'required|trim');
			$this->form_validation->set_rules('materno', 'Materno', 'trim');
			$this->form_validation->set_rules('correo', 'Correo', 'trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');

			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			else{
				if( $this->Inicio_model->modifica_usuario( $this->session->userdata('id_usuario'), false ) ) {
					$datos['mensaje_titulo'] = '&Eacute;xito al Guardar';
					$datos['mensaje'] = 'Tus datos se han modificado correctamente.<br />Los cambios se veran reflejados la pr&oacute;xima vez que inicies sesi&oacute;n';
					$datos['enlace'] = 'inicio';
					$this->load->view('mensajes/ok_redirec.php',$datos);
				}
			}
		}
	}

	//
	// mod_datos_contrasena(): Modificar los Datos del Usuario con contrase�a
	//
	function mod_datos_contrasena() {
		// variables necesarias para la página
		$datos['titulo'] = "Modificar Datos del Usuario";
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		// obtiene los datos del usuario
		$datos['consulta'] = $this->Inicio_model->get_datos_usuario( $this->session->userdata('id_usuario') );

		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'inicio/datos_mod_contrasena', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );

		if( $_POST ) {
			$this->form_validation->set_rules('usuario', 'Usuario', 'required|trim');
			$this->form_validation->set_rules('contrasena', 'Contrase&ntilde;a Nueva', 'required|trim|md5');
			$this->form_validation->set_rules('contrasena_o', 'Nueva Contrase&ntilde;a otra vez', 'required|matches[contrasena]|trim|md5');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			$this->form_validation->set_message('matches', 'Los campos de las Contrase&ntilde;as no coinciden');

			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			else{
				// valida que no exista ya ese usuario
				if( $this->Inicio_model->get_usuario_validar( 'usuario' ) ) {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "El nombre del <strong>Usuario</strong> no esta disponible, debes elegir otro";
					$this->load->view('mensajes/ok',$datos);
				}
				else {
					if( $this->Inicio_model->modifica_usuario( $this->session->userdata('id_usuario'), true ) ) {
						$datos['mensaje_titulo'] = '&Eacute;xito al Guardar';
						$datos['mensaje'] = 'Tus datos se han modificado correctamente.<br />Los cambios se veran reflejados la pr&oacute;xima vez que inicies sesi&oacute;n';
						$datos['enlace'] = 'inicio';
						$this->load->view('mensajes/ok_redirec.php',$datos);
					}
				}
			}
		}
	}

	//
	// administracion_usuarios(): Administración de los usuarios del área
	//
	function administracion_usuarios() {
		if( !$this->session->userdata( 'USU' ) ) {
			redirect( 'inicio' );
		}
		else {
			// si los datos han sido enviados por post se sobre escribe la variable $are
			if( $_POST ) {
				$edo = $this->input->post('estado');
			}
			else {
				if( $this->uri->segment(3) ) {
					$edo = $this->uri->segment(3);
				}
				else {
					$edo = 'activos';
				}
			}
			$datos['estado'] = $edo;

			// estados
			$datos['estado_options'] = array(
				'todos' 	=> ' - Todos - ',
				'activos'	=> 'Activos',
				'inactivos'	=> 'Inactivos'
			);

			// obtiene el listado
			$datos['consulta'] = $this->Inicio_model->get_usuarios( $edo );

			// variables necesarias para la página
			$datos['titulo'] = "Administraci&oacute;n de Usuarios";
			$datos['secciones'] = $this->Inicio_model->get_secciones();
			$datos['identidad'] = $this->Inicio_model->get_identidad();
			$datos['usuario'] = $this->Inicio_model->get_usuario();
			$this->Inicio_model->set_sort( 20 );
			$datos['sort_tabla'] = $this->Inicio_model->get_sort();

			// estructura de la página
			$this->load->view( '_estructura/header',$datos );
			$this->load->view( '_estructura/top', $datos );
			$this->load->view('mensajes/pregunta_oculta_usuario');
			$this->load->view( 'inicio/admin_usuarios/listado', $datos );
			$this->load->view( '_estructura/right', $datos );
			$this->load->view( '_estructura/footer' );
		}
	}

	//
	// agregar_usuario(): Agrega un nuevo usuario del área
	//
	function agregar_usuario() {
		if( !$this->session->userdata( 'USU' ) ) {
			redirect( 'inicio' );
		}
		else {
			if( $this->uri->segment(3) ) {
				$edo = $this->uri->segment(3);
			}
			else {
				$edo = '';
			}
			$datos['estado'] = $edo;

			$datos['titulo'] = "Agregar Usuario";
			// variables necesarias para la página
			$datos['secciones'] = $this->Inicio_model->get_secciones();
			$datos['identidad'] = $this->Inicio_model->get_identidad();
			$datos['usuario'] = $this->Inicio_model->get_usuario();

			// estructura de la página (1)
			$this->load->view( '_estructura/header',$datos );

			// revisa si ya se a enviado el formulario por post
			if( $_POST ){
				// reglas de validaci�n
				$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
				$this->form_validation->set_rules('paterno', 'Paterno', 'required|trim');
				$this->form_validation->set_rules('materno', 'materno', 'trim');
				$this->form_validation->set_rules('correo', 'Correo', 'trim');
				$this->form_validation->set_rules('usuario', 'Usuario', 'required|trim');
				$this->form_validation->set_rules('contrasena', 'Contrase&ntilde;a', 'required|trim|md5');
				$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
				$this->form_validation->set_message('valid_email', 'Debes introducir una direccion de correo v&aacute;lida');

				// envia mensaje de error si no se cumple con alguna regla
				if( $this->form_validation->run() == FALSE ){
					$this->load->view('mensajes/error_validacion',$datos);
				}
				// realiza la inserci�n a la base de datos si todo ha estado bien
				else{
					// valida que no exista ya ese usuario
					if( $this->Inicio_model->get_usuario_validar( 'usuario' ) ) {
						$datos['mensaje_titulo'] = "Error";
						$datos['mensaje'] = "El nombre del <strong>Usuario</strong> no esta disponible, debes elegir otro";
						$this->load->view('mensajes/ok',$datos);
					}
					else {
						// valida que no exista un usuario con ese nombre exacto
						if( $this->Inicio_model->get_usuario_validar( 'nombre' ) ) {
							$datos['mensaje_titulo'] = "Error";
							$datos['mensaje'] = "Ya existe un usuario con ese <strong>Nombre</strong> y esos <strong>Apellidos</strong>";
							$this->load->view('mensajes/ok',$datos);
						}
						else {
							if( $this->Inicio_model->inserta_usuario() ) {
								// msj de �xito
								$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
								$datos['mensaje'] = "El usuario se ha a&ntilde;adido correctamente.<br />&iquest;Deseas agregar otro?";
								$datos['enlace_si'] = "inicio/agregar_usuario";
								$datos['enlace_no'] = "inicio/administracion_usuarios";
								$this->load->view('mensajes/pregunta_enlaces',$datos);
							}
						}
					}
				}
			}

			// estructura de la página (2)
			$this->load->view( '_estructura/top', $datos );
			$this->load->view('mensajes/pregunta_oculta_usuario');
			$this->load->view( 'inicio/admin_usuarios/anadir', $datos );
			$this->load->view( '_estructura/right', $datos );
			$this->load->view( '_estructura/footer' );
		}
	}

	//
	// modificar_usuario( $id ): Modificaun usuario del área en base a su id
	//
	function modificar_usuario( $id ) {
		if( !$this->session->userdata( 'USU' ) ) {
			redirect( 'inicio' );
		}
		else {
			if( $this->uri->segment(4) ) {
				$edo = $this->uri->segment(4);
			}
			else {
				$edo = '';
			}
			$datos['estado'] = $edo;

			$datos['titulo'] = "Modificar Usuario";
			// variables necesarias para la página
			$datos['secciones'] = $this->Inicio_model->get_secciones();
			$datos['identidad'] = $this->Inicio_model->get_identidad();
			$datos['usuario'] = $this->Inicio_model->get_usuario();

			// obtiene los datos del usuario
			$documento = $this->Inicio_model->get_datos_usuario( $id );
			if( $documento->num_rows() > 0 ) {
				foreach( $documento->result() as $row ) :
					$datos['nom'] = $row->Nombre;
					$datos['pat'] = $row->Paterno;
					$datos['mat'] = $row->Materno;
					$datos['cor'] = $row->Correo;
					$datos['usu'] = $row->Usuario;
				endforeach;
			}

			// estructura de la página (1)
			$this->load->view( '_estructura/header',$datos );

			// revisa si ya se a enviado el formulario por post
			if( $_POST ){
				// reglas de validaci�n
				$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
				$this->form_validation->set_rules('paterno', 'Paterno', 'required|trim');
				$this->form_validation->set_rules('materno', 'Materno', 'trim');
				$this->form_validation->set_rules('correo', '', 'trim');
				$this->form_validation->set_rules('usuario', 'Usuario', 'required|trim');
				if( $this->input->post('mod_contrasena') ){
				$this->form_validation->set_rules('contrasena', 'Contrase&ntilde;a', 'required|trim|md5');
				$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
				$this->form_validation->set_message('valid_email', 'Debes introducir una direccion de correo v&aacute;lida');
				}
				// envia mensaje de error si no se cumple con alguna regla
				if( $this->form_validation->run() == FALSE ){
					$this->load->view('mensajes/error_validacion',$datos);
				}
				// realiza la inserci�n a la base de datos si todo ha estado bien
				else{
					// valida que no exista ya ese usuario

						// valida que no exista un usuario con ese nombre exacto

							if( $this->Inicio_model->modifica_admin_usuario( $id ) ) {
								// msj de �xito
								$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
								$datos['mensaje'] = "La informaci&oacute;n del usuario se ha modificado correctamente";
								$datos['enlace'] = 'inicio/administracion_usuarios/'.$edo;
								$this->load->view('mensajes/ok_redirec',$datos);
							}

				}
			}

			// estructura de la página (2)
			$this->load->view( '_estructura/top', $datos );
			$this->load->view('mensajes/pregunta_oculta_usuario');
			$this->load->view( 'inicio/admin_usuarios/modificar', $datos );
			$this->load->view( '_estructura/right', $datos );
			$this->load->view( '_estructura/footer' );
		}
	}

	//
	// maestra( $tipo ): Listas maestras de documentos
	//
	function maestra( $tipo ) {
		if( !$this->uri->segment(3) ) {
			redirect('inicio');
		}

		switch( $tipo ) {
			// Lista maestra de documentos
			case 'documentos' :
				$datos['titulo'] = "Lista Maestra de Documentos R7.5.3,A";
				break;

			// Lista maestra de registros
			case 'registros' :
				$datos['titulo'] = "Lista Maestra de Registros R7.5.3,B";
				break;

			// Lista maestra de documentos externos controlados
			case 'externos' :
				$datos['titulo'] = "Lista Maestra de Documentos Externos Controlados";
				break;
		}
		// variables necesarias para la página
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
		$datos['tipo'] = $tipo;

		// obtiene las noticias
		$datos['documentos'] = $this->Inicio_model->get_documentos( $tipo );

		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'inicio/'.$tipo, $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}

	//
	// Obtiene los departamentos del �rea que se mostraran mediante ajax
	//
	function ajax_departamentos() {
		$datos['departamentos'] = $this->Inicio_model->get_departamentos( $this->input->post('id_area') );
		$this->load-> view('inicio/ajax_departamentos', $datos);
	}
}

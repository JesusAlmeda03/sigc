<?php
/****************************************************************************************************
 *
 *	CONTROLLERS/procesos/conformidades.php
 *
 *		Descripción:
 *			Quejas del sistema
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

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Conformidades extends CI_Controller {

	/** Atributos **/

	/** Propiedades **/

	/** Constructor **/
	function __construct() {
		parent::__construct();

		// si no se ha identificado correctamente
		if (!$this -> session -> userdata('id_usuario')) {
			redirect('inicio');
		} else {
			// Modelo
			$this -> load -> model('procesos/conformidades_model', '', TRUE);
		}
	}

	/** Funciones **/
	//
	// index(): Levantar la no conformidad
	//
	function index() {
		// variables necesarias para la página
		$datos['titulo'] = 'No Conformidades';
		$datos['secciones'] = $this -> Inicio_model -> get_secciones();
		$datos['identidad'] = $this -> Inicio_model -> get_identidad();
		$datos['usuario'] = $this -> Inicio_model -> get_usuario();

		// obtiene todas las areas excepto la de invitado
		$areas = $this -> Inicio_model -> get_areas();
		if ($areas -> num_rows() > 0) {
			$datos['area_options'] = array();
			$datos['area_options'][0] = " - Elige un &Aacute;rea - ";
			foreach ($areas->result() as $row)
				$datos['area_options'][$row -> IdArea] = $row -> Area;
		}

		// estructura de la página (1)
		$this -> load -> view('_estructura/header', $datos);

		// revisa si ya se a enviado el formulario por post
		if ($_POST) {
			// obtiene todos los departamentos
			$datos['departamentos'] = $this -> Inicio_model -> get_departamentos($this -> input -> post('area'));

			// reglas de validación
			$this -> form_validation -> set_rules('area', 'area', 'trim');
			$this -> form_validation -> set_rules('fecha', 'Fecha', 'required|trim');
			$this -> form_validation -> set_rules('descripcion', 'Descripci&oacute;n', 'required|trim');
			$this -> form_validation -> set_message('required', 'Debes introducir el campo <strong>%s</strong>');

			// envia mensaje de error si no se cumple con alguna regla
			if ($this -> form_validation -> run() == FALSE) {
				$this -> load -> view('mensajes/error_validacion', $datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else {
				// valida el departamento
				if (!$this -> input -> post('departamento')) {
					$datos['mensaje_titulo'] = "Error de Validaci&oacute;n";
					$datos['mensaje'] = "Has olvidado elegir el departamento del &Aacute;rea ";
					$this -> load -> view('mensajes/error', $datos);
				} else {
					if ($this -> conformidades_model -> inserta_conformidad()) {
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						$datos['mensaje'] = "Tu no conformidad se ha levantado correctamente";
						$datos['enlace'] = "inicio";
						$this -> load -> view('mensajes/ok_redirec', $datos);
					}
				}
			}
		}

		// estructura de la página (2)
		$this -> load -> view('_estructura/top', $datos);
		$this -> load -> view('procesos/conformidades/levantar', $datos);
		$this -> load -> view('_estructura/right');
		$this -> load -> view('_estructura/footer');
	}

	//
	// auditoria( $id ): Levantar la no conformidad
	//
	function auditoria($id) {
		// regresa si no trae las variables
		if ( $this->uri->segment(4) === false) {
			redirect("auditoria");
		}

		// variables necesarias para la página
		$datos['titulo'] = 'No Conformidades de Auditor&iacute;a';
		$datos['secciones'] = $this -> Inicio_model -> get_secciones();
		$datos['identidad'] = $this -> Inicio_model -> get_identidad();
		$datos['usuario'] = $this -> Inicio_model -> get_usuario();

		// obtiene todas las areas excepto la de invitado
		$areas = $this -> Inicio_model -> get_areas();
		if ($areas -> num_rows() > 0) {
			$datos['area_options'] = array();
			$datos['area_options'][0] = " - Elige un &Aacute;rea - ";
			foreach ($areas->result() as $row)
				$datos['area_options'][$row -> IdArea] = $row -> Area;
		}

		// obtiene el hallazgo
		$this -> load -> model('auditoria_model', '', TRUE);
		$hallazgo = $this -> auditoria_model -> get_lista_hallazgo($id);
		if ($hallazgo -> num_rows() > 0) {
			foreach ($hallazgo->result() as $row) {
				$datos['requisito'] = $row -> Requisito;
				$datos['hallazgo'] = $row -> Hallazgo;
				$datos['ida'] = $row -> IdArea;
			}

			// obtiene todos los departamentos
			$departamentos = $this -> Inicio_model -> get_departamentos($datos['ida']);
			if ($departamentos -> num_rows() > 0) {
				$datos['departamento_options'] = array();
				$datos['departamento_options'][0] = " - Elige un &Aacute;rea - ";
				foreach ($departamentos->result() as $row)
					$datos['departamento_options'][$row -> IdDepartamento] = $row -> Departamento;
			}
		} else {
			redirect("auditoria");
		}

		// estructura de la página (1)
		$this -> load -> view('_estructura/header', $datos);

		// revisa si ya se a enviado el formulario por post
		if ($_POST) {
			// obtiene todos los departamentos
			$datos['departamentos'] = $this -> Inicio_model -> get_departamentos($this -> input -> post('area'));

			// reglas de validación
			$this -> form_validation -> set_rules('area', 'area', 'trim');
			$this -> form_validation -> set_rules('fecha', 'Fecha', 'required|trim');
			$this -> form_validation -> set_rules('descripcion', 'Descripci&oacute;n', 'required|trim');
			$this -> form_validation -> set_message('required', 'Debes introducir el campo <strong>%s</strong>');

			// envia mensaje de error si no se cumple con alguna regla
			if ($this -> form_validation -> run() == FALSE) {
				$this -> load -> view('mensajes/error_validacion', $datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else {
				// valida el departamento
				if (!$this -> input -> post('departamento')) {
					$datos['mensaje_titulo'] = "Error de Validaci&oacute;n";
					$datos['mensaje'] = "Has olvidado elegir el departamento del &Aacute;rea ";
					$this -> load -> view('mensajes/error', $datos);
				} else {
					if ($this -> conformidades_model -> inserta_conformidad_auditoria($id)) {
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						$datos['mensaje'] = "Tu no conformidad se ha levantado correctamente";
						$datos['enlace'] = "inicio";
						$this -> load -> view('mensajes/ok_redirec', $datos);
					}
				}
			}
		}

		// estructura de la página (2)
		$this -> load -> view('_estructura/top', $datos);
		$this -> load -> view('procesos/conformidades/auditoria', $datos);
		$this -> load -> view('_estructura/right');
		$this -> load -> view('_estructura/footer');
	}

	//
	// seguimiento( $id, $avance): Seguimiento de la no conformidad
	//
	function seguimiento($id, $avance) {
		// regresa si no trae las variables
		if ($this -> uri -> segment(5) === false) {
			redirect("listados/conformidades/sin-atender");
		}

		// obtiene las variables para mostrar el listado específico
		if ($this -> uri -> segment(6)) {
			$datos['estado'] = $this -> uri -> segment(6);
		} else {
			$datos['estado'] = '';
		}

		// variables necesarias para la página
		$datos['titulo'] = 'Seguimiento No Conformidades';
		$datos['secciones'] = $this -> Inicio_model -> get_secciones();
		$datos['identidad'] = $this -> Inicio_model -> get_identidad();
		$datos['usuario'] = $this -> Inicio_model -> get_usuario();
		$datos['id'] = $id;
		$datos['avance'] = $avance + 1;

		// Datos de la no conformidad
		$conformidad = $this -> conformidades_model -> get_conformidad($id);
		if ($conformidad -> num_rows() > 0) {
			foreach ($conformidad->result() as $row) {
				$datos['are'] = $row -> Area;
				$datos['dep'] = $row -> Departamento;
				$datos['fec'] = $row -> Fecha;
				$datos['ori'] = $row -> Origen;
				$datos['tip'] = $row -> Tipo;
				$datos['des'] = $row -> Descripcion;
			}
		} else {
			redirect("listados/conformidades/sin-atender");
		}

		// estructura de la página
		$this -> load -> view('_estructura/header', $datos);
		$this -> load -> view('_estructura/top', $datos);

		// avance de la no conformidad
		switch( $avance ) {
			// Parte 1: Espinas del pescado
			case 1 :
				// obtiene un array de las categorias para mostrarlo en forma de textareas
				if ($_POST)
					$datos['categorias'] = $this -> input -> post('categoria');
				break;

			// Parte 2: Causas en las espinas del pescado
			case 2 :
				if ($_POST) {
					// desserializa el array
					$categorias_array = unserialize(urldecode(stripslashes($this -> input -> post('array_categorias'))));

					// valida las textareas
					$i = 1;
					foreach ($categorias_array as $row) :
						$this -> form_validation -> set_rules('causa_' . $i, $row, 'required|trim');
						$this -> form_validation -> set_message('required', 'Debes introducir el campo <strong>%s</strong>');
						$i++;
					endforeach;

					// envia mensaje de error si no se cumple con la validación
					if ($this -> form_validation -> run() == FALSE) {
						$datos['avance'] = $avance - 1;
						$this -> load -> view('mensajes/error_validacion', $datos);
					}
					// inserta el pescado
					else {
						if ($this -> conformidades_model -> inserta_pescado($id, $categorias_array, $avance)) {
							$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
							$datos['mensaje'] = "La informaci&oacute;n del <strong>Diagrama de Pescado</strong> se ha guardado, ahora puedes continuar con la No Conformidad";
							$this -> load -> view('mensajes/ok', $datos);
						}
					}
				}
				break;

			// Parte 3: Causa raíz
			case 3 :
				if ($_POST) {
					// valida las textareas
					$this -> form_validation -> set_rules('causa', 'Causa Ra&iacute;z de la No Conformidad', 'required|trim');
					$this -> form_validation -> set_message('required', 'Debes introducir el campo <strong>%s</strong>');

					// envia mensaje de error si no se cumple con la validación
					if ($this -> form_validation -> run() == FALSE) {
						$datos['avance'] = $avance - 1;
						$this -> load -> view('mensajes/error_validacion', $datos);
					}
					// inserta la causa
					else {
						if ($this -> conformidades_model -> inserta_causa($id, $avance)) {
							$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
							$datos['mensaje'] = "La informaci&oacute;n de la <strong>Causa Ra&iacute;z</strong> se ha guardado, ahora puedes continuar con las Acciones Correctivas y/o Preventivas";
							$this -> load -> view('mensajes/ok', $datos);
						}
					}
				}
				break;

			// Parte 4: Acciones correctivas
			case 4 :
				if ($_POST) {
					// valida los campos
					$this -> form_validation -> set_rules('descripcion', 'Descripci&oacute;n', 'required|trim');
					$this -> form_validation -> set_rules('responsable', 'Responsable', 'required|trim');
					$this -> form_validation -> set_message('required', 'Debes introducir el campo <strong>%s</strong>');

					// envia mensaje de error si no se cumple con la validaci�n
					if ($this -> form_validation -> run() == FALSE) {
						$datos['avance'] = $avance - 1;
						$this -> load -> view('mensajes/error_validacion', $datos);
					}
					// inserta las acciones
					else {
						if ($this -> conformidades_model -> inserta_acciones($id, $avance)) {
							$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
							$datos['mensaje'] = "Las acciones se han guardado correctamente, la No Conformidad ha sido atendida";
							$datos['enlace'] = "procesos/conformidades/ver/" . $id . "/listado";
							$this -> load -> view('mensajes/ok_redirec', $datos);
						}
					}
				}
				break;
		}

		// obtiene el diagrama
		$datos['diagrama_pescado'] = $this -> conformidades_model -> get_diagrama($id);

		// obtiene la causa
		$causa = $this -> conformidades_model -> get_seguimiento($id);
		if ($causa -> num_rows() > 0) {
			foreach ($causa->result() as $row) {
				$datos['cau'] = $row -> Causa;
			}
		} else {
			$datos['cau'] = '';
		}

		// estructura de la página
		$this -> load -> view('procesos/conformidades/seguimiento', $datos);
		$this -> load -> view('_estructura/right');
		$this -> load -> view('_estructura/footer');
	}

	//
	// ver( $id ): Muestra la información de la no conformidad
	//
	function ver($id) {
		// regresa si no trae las variables
		if ($this -> uri -> segment(4) === false) {
			redirect("listados/conformidades/atendidas");
		}

		// obtiene las variables para mostrar el listado específico
		if ($this -> uri -> segment(5)) {
			$datos['estado'] = $this -> uri -> segment(5);
		} else {
			$datos['estado'] = '';
		}

		// variables necesarias para la página
		$datos['titulo'] = 'No Conformidad ';
		$datos['secciones'] = $this -> Inicio_model -> get_secciones();
		$datos['identidad'] = $this -> Inicio_model -> get_identidad();
		$datos['usuario'] = $this -> Inicio_model -> get_usuario();
		$datos['id'] = $id;

		// obtiene los datos de la no conformidad
		$conformidad = $this -> conformidades_model -> get_conformidad($id);
		if ($conformidad -> num_rows() > 0) {
			foreach ($conformidad->result() as $row) {
				$ida = $row -> IdArea;
				$edo = $row -> Estado;
				$eda = $row -> EstadoAvance;
				$datos['estado_nc'] = $row -> Estado;
				$datos['are'] = $row -> Area;
				$datos['dep'] = $row -> Departamento;
				$datos['con'] = $row -> Consecutivo;
				$datos['fec'] = $this -> Inicio_model -> set_fecha($row -> Fecha);
				$datos['ori'] = $row -> Origen;
				$datos['tip'] = $row -> Tipo;
				$datos['des'] = $row -> Descripcion;
			}

			// datos del usuario de la no conformidad
			$conformidad_usuario = $this -> conformidades_model -> get_conformidad_usuario($id);
			if ($conformidad_usuario -> num_rows() > 0) {
				foreach ($conformidad_usuario->result() as $row_u) :
					$datos['usu'] = $row_u -> Nombre . ' ' . $row_u -> Paterno . ' ' . $row_u -> Materno;
					$datos['aru'] = '(' . $row_u -> Area . ')';
				endforeach;
			}
		} else {
			redirect("listados/conformidades/atendidas");
		}

		// Obtiene la info segun el estado de la no conformidad
		switch( $edo ) {
			// sin atender
			case 0 :
				$datos['tipo'] = false;
				redirect('_pagina/error_404');
				break;

			// atendida
			case 1 :
				$datos['tipo_title'] = "Atendida";
				$seguimiento = $this -> conformidades_model -> get_seguimiento($id);
				if ($seguimiento -> num_rows() > 0) {
					$datos['seguimiento'] = true;
					foreach ($seguimiento->result() as $row) {
						$datos['cau'] = $row -> Causa;
						$datos['her'] = $row -> Herramienta;
						$datos['aud'] = $row -> Auditor;
					}
					$datos['diagrama'] = $this -> conformidades_model -> get_diagrama($id);
					$datos['acciones'] = $this -> conformidades_model -> get_acciones($id);
					$datos['evidencias'] = $this -> conformidades_model -> get_evidencias($id);
				} else {
					$datos['seguimiento'] = false;
				}
				break;

			// cerrada
			case 2 :
				$datos['tipo_title'] = "Cerrada";
				$seguimiento = $this -> conformidades_model -> get_seguimiento($id);
				if ($seguimiento -> num_rows() > 0) {
					$datos['seguimiento'] = true;
					foreach ($seguimiento->result() as $row) {
						$datos['cau'] = $row -> Causa;
						$datos['her'] = $row -> Herramienta;
						$datos['aud'] = $row -> Auditor;
					}
					$datos['diagrama'] = $this -> conformidades_model -> get_diagrama($id);
					$datos['acciones'] = $this -> conformidades_model -> get_acciones($id);
					$datos['evidencias'] = $this -> conformidades_model -> get_evidencias($id);
				} else {
					$datos['seguimiento'] = false;
				}
				break;

			// eliminada
			case 3 :
				$datos['seguimiento'] = false;
				$datos['tipo_title'] = "Eliminada";
				break;

			// evidencias de no conformidad atendida
			case 4 :
				$datos['tipo_title'] = "Atendida sin Evidencias";
				$seguimiento = $this -> conformidades_model -> get_seguimiento($id);
				if ($seguimiento -> num_rows() > 0) {
					$datos['seguimiento'] = true;
					foreach ($seguimiento->result() as $row) {
						$datos['cau'] = $row -> Causa;
						$datos['her'] = $row -> Herramienta;
						$datos['aud'] = $row -> Auditor;
					}
					$datos['diagrama'] = $this -> conformidades_model -> get_diagrama($id);
					$datos['acciones'] = $this -> conformidades_model -> get_acciones($id);
					$datos['evidencias'] = $this -> conformidades_model -> get_evidencias($id);
				} else {
					$datos['seguimiento'] = false;
				}
				break;
		}

		// estructura de la página (1)
		$this -> load -> view('_estructura/header', $datos);
		// se guardan los datos de la evidencia
		if ($_POST) {
			// configuración de los archivos a subir
			$nom_doc = "evidenciaNC-" . $id . "-" . $this -> input -> post('id_area') . "-" . substr(md5(uniqid(rand())), 0, 4);
			$config['file_name'] = $nom_doc;
			$config['upload_path'] = './includes/docs/';
			$config['allowed_types'] = '*';
			$config['max_size'] = '0';

			$this -> load -> library('upload', $config);

			if (!$this -> upload -> do_upload('archivo')) {
				// msj de error
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = $this -> upload -> display_errors();
				$this -> load -> view('mensajes/error', $datos);
			} else {
				// renombra el documento
				$upload_data = $this -> upload -> data();
				$nom_doc = $nom_doc . $upload_data['file_ext'];

				// inserta la evidencia
				$id_sol = $this -> conformidades_model -> inserta_evidencia($id, $nom_doc);
				if ($id_sol) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "La evidencia se ha guardado<br />&iquest;Deseas agregar otra?";
					$datos['enlace_si'] = "procesos/conformidades/ver/" . $id . "/" . $datos['estado'];
					$datos['enlace_no'] = "listados/conformidades/evidencias";
					$this -> load -> view('mensajes/pregunta_enlaces', $datos);
				} else {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error, la solicitud no se ha guardado";
					$datos['enlace'] = "procesos/solicitudes/alta";
					$this -> load -> view('mensajes/ok_redirec', $datos);
				}
			}
		}
		// estructura de la página (2)
		$this -> load -> view('_estructura/top', $datos);
		$this -> load -> view('procesos/conformidades/ver', $datos);
		$this -> load -> view('_estructura/right');
		$this -> load -> view('_estructura/footer');
	}

	//
	// modificar( $id ): Modifica la no conformidad
	//
	function modificar($id) {
		// regresa si no trae las variables
		if ($this -> uri -> segment(4) === false) {
			redirect("listados/conformidades/atendidas");
		}

		// obtiene las variables para mostrar el listado específico
		if ($this -> uri -> segment(5)) {
			$estado = $this -> uri -> segment(5);
		} else {
			$estado = '';
		}
		$datos['estado'] = $estado;

		// variables necesarias para la página
		$datos['titulo'] = 'Modificar No Conformidad ';
		$datos['secciones'] = $this -> Inicio_model -> get_secciones();
		$datos['identidad'] = $this -> Inicio_model -> get_identidad();
		$datos['usuario'] = $this -> Inicio_model -> get_usuario();
		$datos['cau'] = '';
		$datos['aud'] = '';

		// obtiene todas las areas excepto la de invitado
		$areas = $this -> Inicio_model -> get_areas();
		if ($areas -> num_rows() > 0) {
			$datos['area_options'] = array();
			$datos['area_options'][0] = " - Elige un &Aacute;rea - ";
			foreach ($areas->result() as $row)
				$datos['area_options'][$row -> IdArea] = $row -> Area;
		}

		// Datos de la no conformidad
		$conformidad = $this -> conformidades_model -> get_conformidad($id);
		if ($conformidad -> num_rows() > 0) {
			foreach ($conformidad->result() as $row) {
				$idu = $row -> IdUsuario;
				$datos['ida'] = $row -> IdArea;
				$datos['idu'] = $idu;
				$datos['idd'] = $row -> IdDepartamento;
				$datos['con'] = $row -> Consecutivo;
				$datos['are'] = $row -> Area;
				$datos['dep'] = $row -> Departamento;
				$datos['fec'] = $row -> Fecha;
				$datos['ori'] = $row -> Origen;
				$datos['tip'] = $row -> Tipo;
				$datos['des'] = $row -> Descripcion;
				$edo = $row -> Estado;
				$eda = $row -> EstadoAvance;
				if ($edo == 1 || $edo == 2) {
					$datos['edo'] = true;
					$edo = true;
				} else {
					$datos['edo'] = false;
				}
				$datos['eda'] = $eda;
			}
		} else {
			redirect("listados/conformidades/atendidas");
		}

		// obtiene los datos del seguimiento
		if ($edo) {
			$seguimiento = $this -> conformidades_model -> get_seguimiento($id);
			if ($seguimiento -> num_rows() > 0) {
				foreach ($seguimiento->result() as $row) {
					$datos['cau'] = $row -> Causa;
					$datos['aud'] = $row -> Auditor;
				}
			}
			$datos['diagrama'] = $this -> conformidades_model -> get_diagrama($id);
			$datos['acciones'] = $this -> conformidades_model -> get_acciones($id);
		}

		// obtiene todos los departamentos
		$departamentos = $this -> Inicio_model -> get_departamentos($datos['ida']);
		if ($departamentos -> num_rows() > 0) {
			$datos['departamento_options'] = array();
			$datos['departamento_options'][0] = " - Elige un &Aacute;rea - ";
			foreach ($departamentos->result() as $row)
				$datos['departamento_options'][$row -> IdDepartamento] = $row -> Departamento;
		}

		// estructura de la página
		$this -> load -> view('_estructura/header', $datos);
		$this -> load -> view('_estructura/top', $datos);
		$this -> load -> view('procesos/conformidades/modificar', $datos);
		$this -> load -> view('_estructura/right');
		$this -> load -> view('_estructura/footer');

		// revisa si ya se a enviado el formulario por post
		if ($_POST) {
			// reglas de validación
			$this -> form_validation -> set_rules('area', 'area', 'trim');
			$this -> form_validation -> set_rules('departamento', 'departamento', 'trim');
			$this -> form_validation -> set_rules('fecha', 'Fecha', 'required|trim');
			$this -> form_validation -> set_rules('descripcion', 'Descripci&oacute;n', 'required|trim');
			// si hay seguimiento
			if ($edo == 1 || $edo == 2) {
				$this -> form_validation -> set_rules('causa', 'Causa', 'required|trim');
			}
			$this -> form_validation -> set_message('required', 'Debes introducir el campo <strong>%s</strong>');

			// envia mensaje de error si no se cumple con alguna regla
			if ($this -> form_validation -> run() == FALSE) {
				$this -> load -> view('mensajes/error_validacion', $datos);
			}
			// realiza la actualizacion si todo ha estado bien
			else {
				// valida el departamento
				if (!$this -> input -> post('departamento') && $idu == $this -> session -> userdata('id_usuario')) {
					// msj de error
					$datos['mensaje_titulo'] = "Error de Validaci&oacute;n";
					$datos['mensaje'] = "Has olvidado elegir el departamento del &Aacute;rea ";
					$this -> load -> view('mensajes/error', $datos);
				} else {
					// array para actualizar en la bd
					$resp = $this -> conformidades_model -> modifica_conformidad($id);

					if ($resp) {
						// si hay seguimiento
						if ($edo == 1 || $edo == 2) {
							$resp = $this -> conformidades_model -> modifica_seguimiento($id);
						}

						// si todo ha estado bien manda el mensaje
						if ($resp) {
							// msj de éxito
							$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
							$datos['mensaje'] = "La no conformidad se ha modificado correctamente";
							$datos['enlace'] = 'listados/conformidades/' . $estado;
							$this -> load -> view('mensajes/ok_redirec', $datos);
						}
					}
				}
			}
		}
	}

	//
	// cerrar(): Cerrar la no conformidad
	//
	function cerrar() {
		// variables necesarias para la página
		$datos['titulo'] = 'Cerrar No Conformidad ';
		$datos['secciones'] = $this -> Inicio_model -> get_secciones();
		$datos['identidad'] = $this -> Inicio_model -> get_identidad();
		$datos['usuario'] = $this -> Inicio_model -> get_usuario();
		$this -> Inicio_model -> set_sort(15);
		$datos['sort_tabla'] = $this -> Inicio_model -> get_sort();

		// listado de las no conformidades a cerrar
		$datos['conformidades'] = $this -> conformidades_model -> get_conformidades_cerrar();

		// estructura de la página
		$this -> load -> view('_estructura/header', $datos);
		$this -> load -> view('_estructura/top', $datos);
		$this -> load -> view('procesos/conformidades/cerrar', $datos);
		$this -> load -> view('_estructura/right');
		$this -> load -> view('_estructura/footer');

		// guarda los datos
		if ($_POST) {
			// Cierra las no conformidades
			if ($this -> input -> post('conformidad')) {
				$resp = $this -> conformidades_model -> cierra_no_conformidades();

				// msj de guardado
				if ($resp) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "Las No Conformidades se han cerrado";
					$datos['enlace'] = "procesos/conformidades/cerrar";
					$this -> load -> view('mensajes/ok_redirec', $datos);
				}
				// msj de error
				else {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error, las No Conformidades no se han cerrado. Por favor intentalo de nuevo";
					$datos['enlace'] = "procesos/conformidades/cerrar";
					$this -> load -> view('mensajes/ok_redirec', $datos);
				}
			} else {
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = "Debes elegir al menos una No Conformidad";
				$this -> load -> view('mensajes/error', $datos);
			}
		}
	}

	//
	// eliminar_pescado( $id ): Eliminar el diagrama de pescado
	//
	function eliminar_pescado($id) {
		// regresa si no trae las variables
		if ($this -> uri -> segment(4) === false) {
			redirect("listados/conformidades/atendidas");
		}

		if ($this -> conformidades_model -> elimina_pescado($id)) {
			redirect('procesos/conformidades/seguimiento/' . $id . '/0');
		}
	}

	//
	// seguimiento_usuario(): Seguimiento de las no conformidades
	//
	function seguimiento_usuario() {
		// si los datos han sido enviados por post se sobre escribe la variable $edo
		if ($_POST) {
			$edo = $this -> input -> post('estado');
		} else {
			$edo = 'pendientes';
		}
		$datos['selec'] = $edo;

		// se obtiene el listado
		$datos['consulta'] = $this -> conformidades_model -> get_conformidades_usuario($edo);

		// variables necesarias para la página
		$datos['titulo'] = 'Seguimiento de No Conformidades ';
		$datos['secciones'] = $this -> Inicio_model -> get_secciones();
		$datos['identidad'] = $this -> Inicio_model -> get_identidad();
		$datos['usuario'] = $this -> Inicio_model -> get_usuario();
		$this -> Inicio_model -> set_sort(15);
		$datos['sort_tabla'] = $this -> Inicio_model -> get_sort();
		$datos['selec'] = $edo;

		// estructura de la página
		$this -> load -> view('_estructura/header', $datos);
		$this -> load -> view('_estructura/top', $datos);
		$this -> load -> view('procesos/conformidades/seguimiento_usuario', $datos);
		$this -> load -> view('_estructura/right');
		$this -> load -> view('_estructura/footer');
	}

	/**8**/
	//
	// documento( $idc ): Genera el documento PDF de la conformidad
	//
	function documento($idc) {
		// obtiene los datos de la no conformidad
		$conformidad = $this -> db -> join('ab_areas', 'ab_areas.IdArea = pa_conformidades.IdArea') -> join('ab_departamentos', 'ab_departamentos.IdDepartamento = pa_conformidades.IdDepartamento') -> get_where('pa_conformidades', array('pa_conformidades.IdConformidad' => $idc));
		if ($conformidad -> num_rows() > 0) {
			foreach ($conformidad->result() as $row) :
				$ida = $row -> IdArea;
				$edo = $row -> Estado;
				$eda = $row -> EstadoAvance;
				$area = $row -> Area;
				$departamento = $row -> Departamento;
				$origen = $row -> Origen;
				$tipo = $row -> Tipo;
				$descripcion = $row -> Descripcion;
				switch( substr($row->Fecha,5,2) ) {
					case "01" :
						$mes = "Enero";
						break;
					case "02" :
						$mes = "Febrero";
						break;
					case "03" :
						$mes = "Marzo";
						break;
					case "04" :
						$mes = "Abril";
						break;
					case "05" :
						$mes = "Mayo";
						break;
					case "06" :
						$mes = "Junio";
						break;
					case "07" :
						$mes = "Julio";
						break;
					case "08" :
						$mes = "Agosto";
						break;
					case "09" :
						$mes = "Septiembre";
						break;
					case "10" :
						$mes = "Octubre";
						break;
					case "11" :
						$mes = "Noviembre";
						break;
					case "12" :
						$mes = "Diciembre";
						break;
				}
				$fecha = substr($row -> Fecha, 8, 2) . " / " . $mes . " / " . substr($row -> Fecha, 0, 4);
			endforeach;
			$conformidad_usuario = $this -> db -> join('ab_usuarios', 'ab_usuarios.IdUsuario = pa_conformidades.IdUsuario') -> join('ab_areas', 'ab_areas.IdArea = ab_usuarios.IdArea') -> get_where('pa_conformidades', array('pa_conformidades.IdConformidad' => $idc));
			if ($conformidad_usuario -> num_rows() > 0) {
				foreach ($conformidad_usuario->result() as $row_u) :
					$usuario = $row_u -> Nombre . ' ' . $row_u -> Paterno . ' ' . $row_u -> Materno;
					$area_usuario = '(' . $row_u -> Area . ')';
				endforeach;
			}
		}

		// Obtiene la info segun el estado de la no conformidad
		switch( $edo ) {
			// sin atender
			case 0 :
				redirect('_pagina/error_404');
				break;

			// atendida
			case 1 :
				$seguimiento = $this -> db -> get_where('pa_conformidades_seguimiento', array('pa_conformidades_seguimiento.IdConformidad' => $idc));
				if ($seguimiento -> num_rows() > 0) {
					foreach ($seguimiento->result() as $row) :
						$causas = $row -> Causa;
						$herramienta = $row -> Herramienta;
					endforeach;
					$diagrama = $this -> db -> get_where('pa_conformidades_diagrama', array('pa_conformidades_diagrama.IdConformidad' => $idc));
					$acciones = $this -> db -> get_where('pa_conformidades_acciones', array('pa_conformidades_acciones.IdConformidad' => $idc));
				}
				break;

			// cerrada
			case 2 :
				$seguimiento = $this -> db -> get_where('pa_conformidades_seguimiento', array('pa_conformidades_seguimiento.IdConformidad' => $idc));
				if ($seguimiento -> num_rows() > 0) {
					foreach ($seguimiento->result() as $row) :
						$causas = $row -> Causa;
						$herramienta = $row -> Herramienta;
					endforeach;
					$diagrama = $this -> db -> get_where('pa_conformidades_diagrama', array('pa_conformidades_diagrama.IdConformidad' => $idc));
					$acciones = $this -> db -> get_where('pa_conformidades_acciones', array('pa_conformidades_acciones.IdConformidad' => $idc));
				}
				break;

			// eliminada
			case 3 :
				redirect('_pagina/error_404');
				break;
		}

		$this -> load -> library('fpdf');
		define('FPDF_FONTPATH', $this -> config -> item('fonts_path'));

		$this -> load -> library('fpdf');

		// Inicia el pdf
		$pdf = new FPDF('P', 'mm', 'A4');

		// Genera el pdf
		$pdf -> AddPage();
		$pdf -> SetFont("Arial", "", 12);

		$search = array('&aacute;', '&eacute;', '&iacute;', '&oacute;', '&uacute;', '&Aacute;', '&Eacute;', '&Iacute;', '&Oacute;', '&Uacute;', '&ntilde;', '&Ntilde', '&nbsp;', '&agrave;', '&egrave;', '&igrave;', '&ograve;', '&ugrave;', '&Agrave;', '&Egrave;', '&Igrave;', '&Ograve;', '&Ugrave;', '&ldquo;', '&rdquo;');
		$replace = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', ' ', 'à', 'è', 'í', 'ò', 'ú', 'À', 'È', 'Í', 'Ò', 'ú', '"', '"');

		// Datos de la No Conformidad
		$pdf -> SetLineWidth(.1);
		$pdf -> SetFillColor(198, 34, 35);
		$pdf -> SetTextColor(255);
		$pdf -> SetFont("Arial", "B", 14);
		$pdf -> Cell(190, 10, 'No Conformidad R8.5.2.1 A', 1, 0, 'C', true);
		$pdf -> Ln();
		$pdf -> Ln(1);
		$pdf -> SetFillColor(250, 250, 251);
		$pdf -> SetTextColor(0);

		// usuario
		$pdf -> SetFont("Arial", "B", 12);
		$pdf -> Cell(190, 6, utf8_decode('Usuario que levantó la No Conformidad'), 1, 0, 'L', true);
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "", 12);
		$pdf -> WriteHTML(utf8_decode($usuario));
		$pdf -> Ln();

		// área
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "B", 12);
		$pdf -> Cell(190, 6, utf8_decode('Área'), 1, 0, 'L', true);
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "", 12);
		$pdf -> WriteHTML(iconv("UTF-8", "ISO-8859-1", $area));
		$pdf -> Ln();

		// departamento
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "B", 12);
		$pdf -> Cell(190, 6, 'Departamento', 1, 0, 'L', true);
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "", 12);
		$pdf -> WriteHTML(iconv("UTF-8", "ISO-8859-1", $departamento));
		$pdf -> Ln();

		// fecha
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "B", 12);
		$pdf -> Cell(190, 6, 'Fecha', 1, 0, 'L', true);
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "", 12);
		$pdf -> WriteHTML(iconv("UTF-8", "ISO-8859-1", $fecha));
		$pdf -> Ln();

		// origen
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "B", 12);
		$pdf -> Cell(190, 6, 'Origen', 1, 0, 'L', true);
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "", 12);
		$pdf -> WriteHTML(iconv("UTF-8", "ISO-8859-1", $origen));
		$pdf -> Ln();

		// tipo
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "B", 12);
		$pdf -> Cell(190, 6, 'Tipo', 1, 0, 'L', true);
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "", 12);
		$pdf -> WriteHTML(iconv("UTF-8", "ISO-8859-1", $tipo));
		$pdf -> Ln();

		// descrpición
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "B", 12);
		$pdf -> Cell(190, 6, utf8_decode('Descripción'), 1, 0, 'L', true);
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "", 12);
		$descripcion = str_replace($search, $replace, $descripcion);
		$pdf -> WriteHTML(strip_tags(iconv("UTF-8", "ISO-8859-1", $descripcion)));
		$pdf -> Ln();

		// Datos del Seguimiento
		$pdf -> Ln();
		$pdf -> SetFillColor(198, 34, 35);
		$pdf -> SetTextColor(255);
		$pdf -> SetFont("Arial", "B", 14);
		$pdf -> Cell(190, 10, 'Datos del Seguimiento de la No Conformidad', 1, 0, 'C', true);
		$pdf -> Ln();
		$pdf -> Ln(1);
		$pdf -> SetFillColor(250, 250, 251);
		$pdf -> SetTextColor(0);

		// causa raiz
		$pdf -> SetFont("Arial", "B", 12);
		$pdf -> Cell(190, 6, utf8_decode('Causa Raíz'), 1, 0, 'L', true);
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "", 12);
		$causas = str_replace($search, $replace, $causas);
		$pdf -> WriteHTML(strip_tags(iconv("UTF-8", "ISO-8859-1", $causas)));
		$pdf -> Ln();

		// diagrama de pescado
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "B", 12);
		$pdf -> Cell(190, 6, utf8_decode('Diagrama de Pescado'), 1, 0, 'L', true);
		$pdf -> Ln();
		$pdf -> SetTextColor(0);
		if ($diagrama -> num_rows() > 0) {
			$i = 1;
			foreach ($diagrama->result() as $row) :
				$pdf -> SetFont("Arial", "B", 12);
				$categoria = str_replace($search, $replace, $row -> Categoria);
				$pdf -> WriteHTML(iconv("UTF-8", "ISO-8859-1", $categoria));
				$pdf -> Ln();
				$pdf -> SetFont("Arial", "", 12);
				$causa = str_replace($search, $replace, $row -> Causa);
				$pdf -> WriteHTML(strip_tags(iconv("UTF-8", "ISO-8859-1", $causa)));
				$pdf -> Ln();
				$pdf -> Ln();
			endforeach;
		}

		// Acciones a Tomar
		$pdf -> Ln();
		$pdf -> SetFillColor(198, 34, 35);
		$pdf -> SetTextColor(255);
		$pdf -> SetFont("Arial", "B", 14);
		$pdf -> Cell(190, 10, 'Acciones a Tomar', 1, 0, 'C', true);
		$pdf -> Ln();
		$pdf -> Ln(1);
		$pdf -> SetFillColor(250, 250, 251);
		$pdf -> SetTextColor(0);

		// acciones
		if ($acciones -> num_rows() > 0) {
			$i = 1;
			foreach ($acciones->result() as $row) :
				switch( substr($row->Fecha,5,2) ) {
					case "00" :
						$mes = "";
						break;
					case "01" :
						$mes = "Enero";
						break;
					case "02" :
						$mes = "Febrero";
						break;
					case "03" :
						$mes = "Marzo";
						break;
					case "04" :
						$mes = "Abril";
						break;
					case "05" :
						$mes = "Mayo";
						break;
					case "06" :
						$mes = "Junio";
						break;
					case "07" :
						$mes = "Julio";
						break;
					case "08" :
						$mes = "Agosto";
						break;
					case "09" :
						$mes = "Septiembre";
						break;
					case "10" :
						$mes = "Octubre";
						break;
					case "11" :
						$mes = "Noviembre";
						break;
					case "12" :
						$mes = "Diciembre";
						break;
				}
				$fec_accion = substr($row -> Fecha, 8, 2) . " / " . $mes . " / " . substr($row -> Fecha, 0, 4);

				// numero
				$pdf -> SetFillColor(250, 250, 251);
				$pdf -> SetFont("Arial", "B", 12);
				$pdf -> Cell(190, 6, utf8_decode('Número'), 1, 0, 'L', true);
				$pdf -> Ln();
				$pdf -> SetFont("Arial", "", 12);
				$pdf -> WriteHTML($i);
				$pdf -> Ln();

				// fecha
				$pdf -> Ln();
				$pdf -> SetFont("Arial", "B", 12);
				$pdf -> Cell(190, 6, 'Fecha', 1, 0, 'L', true);
				$pdf -> Ln();
				$pdf -> SetFont("Arial", "", 12);
				$pdf -> WriteHTML(iconv("UTF-8", "ISO-8859-1", $fec_accion));
				$pdf -> Ln();

				// tipo
				$pdf -> Ln();
				$pdf -> SetFont("Arial", "B", 12);
				$pdf -> Cell(190, 6, 'Tipo', 1, 0, 'L', true);
				$pdf -> Ln();
				$pdf -> SetFont("Arial", "", 12);
				$pdf -> WriteHTML(iconv("UTF-8", "ISO-8859-1", $row -> Tipo));
				$pdf -> Ln();

				// responsable
				$pdf -> Ln();
				$pdf -> SetFont("Arial", "B", 12);
				$pdf -> Cell(190, 6, 'Responsable', 1, 0, 'L', true);
				$pdf -> Ln();
				$pdf -> SetFont("Arial", "", 12);
				$pdf -> WriteHTML(iconv("UTF-8", "ISO-8859-1", $row -> Responsable));
				$pdf -> Ln();

				// accion
				$pdf -> Ln();
				$pdf -> SetFont("Arial", "B", 12);
				$pdf -> Cell(190, 6, utf8_decode('Acción'), 1, 0, 'L', true);
				$pdf -> Ln();
				$pdf -> SetFont("Arial", "", 12);
				$accion = str_replace($search, $replace, $row -> Accion);
				$pdf -> WriteHTML(strip_tags(iconv("UTF-8", "ISO-8859-1", $accion)));
				$pdf -> Ln();
				$pdf -> Ln();
				$pdf -> SetFillColor(198, 34, 35);
				$pdf -> Cell(190, 1, '', 1, 0, 'L', true);
				$pdf -> Ln();
				$pdf -> Ln();
				$pdf -> Ln();
				$i++;
			endforeach;
		}

		// Datos del Cumplimiento
		$pdf -> SetFillColor(250, 250, 251);
		$pdf -> SetTextColor(0);

		// auditor
		$pdf -> SetFont("Arial", "B", 12);
		$pdf -> Cell(190, 6, 'Nombre y Puesto del Auditor Responsable de vigilar el cumplimiento', 1, 0, 'L', true);
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "", 12);
		if ($this -> session -> userdata('id_area') == 9)
			$pdf -> WriteHTML("DR. ROBERTO	LIMON	GODINA");
		$pdf -> Ln();

		// seguimiento
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "B", 12);
		$pdf -> Cell(190, 6, 'Seguimiento', 1, 0, 'L', true);
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "", 12);
		$pdf -> WriteHTML(utf8_decode('Cumplió:'));
		$pdf -> Ln();
		$pdf -> WriteHTML('Si()     No()');
		$pdf -> Ln();

		// reprogramar
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "B", 12);
		$pdf -> Cell(190, 6, 'Reprogramar', 1, 0, 'L', true);
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "", 12);
		$pdf -> WriteHTML('Fecha:   /      /  ');
		$pdf -> Ln();
		$pdf -> WriteHTML('Comentarios:');
		$pdf -> Ln();
		$pdf -> Ln();
		$pdf -> Ln();
		$pdf -> Ln();
		$pdf -> Ln();

		// Firmas
		$pdf -> Ln();
		$pdf -> Ln();
		$pdf -> Ln();
		$pdf -> Ln();
		$pdf -> SetFont("Arial", "B", 12);
		$pdf -> SetFillColor(250, 250, 250);
		$pdf -> SetX(50);
		$pdf -> Cell(190, 6, '		_______________________      _______________________', 0, 0, 'L', false);
		$pdf -> Ln();
		$pdf -> SetX(50);
		$pdf -> Cell(190, 6, '          Firma del Auditor                  Firma del Responsable', 0, 0, 'L', false);

		$pdf -> Output();
	}

}

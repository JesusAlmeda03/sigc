<?php
/****************************************************************************************************
*
*	CONTROLLERS/admin/varios.php
*
*		Descripción:
*			Controlador de las acciones varias del administrador
*
*		Fecha de Creación:
*			30/Octubre/2011
*
*		Ultima actualización:
*			2/Febrero/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Varios extends CI_Controller {

/** Atributos **/
	private $menu;
	private $barra;

/** Propiedades **/
	public function set_menu() {
		$this->menu = $this->inicio_admin_model->get_menu( 'varios' );
	}

	public function get_barra( $enlaces ) {
		$this->barra = '<a href="'.base_url().'index.php/admin/inicio">Inicio</a>';

		foreach( $enlaces as $enlace => $titulo ) {
			$this->barra .= '
				<img src="'.base_url().'includes/img/arrow_right.png"/>
				<a href="'.base_url().'index.php/admin/varios/'.$enlace.'">'.$titulo.'</a>
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
	// quejas(): Listado de las quejas
	//
	function quejas() {
		// si los datos han sido enviados por post se sobre escribe la variable $ide
		if( $_POST ) {
			$ida = $this->input->post('area');
			$edo = $this->input->post('estado');
		}else {
			if( $this->uri->segment(4) || $this->uri->segment(5) ) {
				$ida = $this->uri->segment(4);
				$edo = $this->uri->segment(5);
			}else {
				$ida = "elige";
				$edo = "elige";
			}
		}
		$datos['area'] = $ida;
		$datos['estado'] = $edo;

		// obtiene todas las areas
		$areas = $this->db->order_by('Area')->get_where('ab_areas');
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options'][''] = "";
			$datos['area_options']['todos'] = " - Todas las &Aacute;reas - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}
		$datos['estado_options'] = array( 'todos' => ' - Todas - ', '0' => 'Pendientes', '1' => 'Terminadas', '2' => 'Eliminadas' );

		// se obtiene el listado
		$this->db->order_by("IdQueja", "DESC");
		$this->db->join("ab_areas", "ab_areas.IdArea = pa_quejas.IdArea");
		$this->db->join("ab_departamentos", "ab_departamentos.IdDepartamento = pa_quejas.IdDepartamento");
		// muestra todo el listado
		if( $ida == "todos" ) {
			$datos['area'] = 'todos';
			if( $edo == "todos" ) {
				$datos['selec'] = 'todos';
				$datos['consulta'] = $this->db->get('pa_quejas');
			}
			else {
				$datos['selec'] = $edo;
				$datos['consulta'] = $this->db->get_where('pa_quejas',array('pa_quejas.Estado' => $edo));
			}
		}
		// muestra el listado del estado espec�fico
		else {
			$datos['area'] = $ida;
			if( $edo == "todos" ) {
				$datos['selec'] = 'todos';
				$datos['consulta'] = $this->db->get_where('pa_quejas',array('pa_quejas.IdArea' => $ida));
			}
			else {
				$datos['estado'] = $edo;
				$datos['consulta'] = $this->db->get_where('pa_quejas',array('pa_quejas.IdArea' => $ida, 'pa_quejas.Estado' => $edo));
			}
		}

		// variables necesarias para la estructura de la p�gina
		$titulo = 'Quejas';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();

		// genera la barra de dirección
		$this->get_barra( array( 'quejas' => $titulo ) );
		$datos['barra'] = $this->barra;

		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/quejas/listado',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// quejas_ver( $idq ): Muestra una queja específica
	//
	function quejas_ver( $idq ) {

		// variables necesarias para la estructura de la página
		$titulo = 'Ver Queja';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;

		// genera la barra de dirección
		$enlaces = array (
			'quejas' 		=> 'Quejas',
			'quejas_ver' 	=> $titulo
		);
		$this->get_barra( $enlaces );
		$datos['barra'] = $this->barra;

		if( $this->uri->segment(5) || $this->uri->segment(6) ) {
			$area = $this->uri->segment(5);
			$estado = $this->uri->segment(6);
		}
		else {
			$area = '';
			$estado = '';
		}
		$datos['area'] = $area;
		$datos['estado'] = $estado;

		// obtiene los datos de la queja
		$queja = $this->db->join('ab_areas','ab_areas.IdArea = pa_quejas.IdArea')->join('ab_departamentos','ab_departamentos.IdDepartamento = pa_quejas.IdDepartamento')->get_where('pa_quejas',array('IdQueja' => $idq));
		if( $queja->num_rows() > 0 ) {
			foreach( $queja->result() as $row ) {
				$tipo = $row->Estado;
				$datos['idq'] = $row->IdQueja;
				$datos['are'] = $row->Area;
				$datos['dep'] = $row->Departamento;
				$datos['nom'] = $row->Nombre;
				$datos['fec'] = $this->Inicio_model->set_fecha( $row->Fecha );
				$datos['cor'] = $row->Correo;
				$datos['tel'] = $row->Telefono;
				$datos['que'] = $row->Queja;
			}
		}

		// Obtiene la info segun el tipo de queja
		switch( $tipo ) {
			// pendiente
			case 0 :
				$datos['seguimiento'] = false;
				break;

			// terminada
			case 1 :
				$datos['seguimiento'] = true;
				$datos['tipo_title'] = "Terminada";
				$queja = $this->db->join('pa_quejas','pa_quejas.IdQueja = pa_quejas.IdQueja')->get_where('pa_quejas_seguimiento',array('pa_quejas_seguimiento.IdQueja' => $idq));
				if( $queja->num_rows() > 0 ) {
					foreach( $queja->result() as $row ) {
						$datos['res'] = $row->Responsable;
						$datos['des'] = $row->Descripcion;
						$datos['fec_seg'] = $this->Inicio_model->set_fecha( $row->FechaS );
						$datos['obs'] = $row->Observacion;
					}
				}
				break;

			// eliminada
			case 2 :
				$datos['tipo_title'] = "Eliminada";
				$queja = $this->db->join('pa_quejas','pa_quejas.IdQueja = pa_quejas.IdQueja')->get_where('pa_quejas_seguimiento',array('pa_quejas_seguimiento.IdQueja' => $idq));
				if( $queja->num_rows() > 0 ) {
					$datos['seguimiento'] = true;
					foreach( $queja->result() as $row ) {
						$datos['res'] = $row->Responsable;
						$datos['des'] = $row->Descripcion;
						$datos['fec_seg'] = $this->Inicio_model->set_fecha( $row->FechaS );
						$datos['obs'] = $row->Observacion;
					}
				}
				else {
					$datos['seguimiento'] = false;
				}
				break;
		}

		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/quejas/ver',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// quejas_modificar( $ide ): Modifica la queja
	//
	function quejas_modificar( $id ) {
		// carga el modelo de quejas
		$this->load->model('procesos/quejas_model','',TRUE);

		if( $this->uri->segment(5) || $this->uri->segment(6) ) {
			$area = $this->uri->segment(5);
			$estado = $this->uri->segment(6);
		}
		else {
			$area = '';
			$estado = '';
		}
		$datos['area'] = $area;
		$datos['estado'] = $estado;

		// variables necesarias para la página
		$titulo = 'Modificar Quejas';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;

		// genera la barra de dirección
		$enlaces = array (
			'quejas' 			=> 'Quejas',
			'quejas_modificar' 	=> $titulo
		);
		$this->get_barra( $enlaces );
		$datos['barra'] = $this->barra;

		// obtiene todas las areas excepto la de invitado
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options'][0] = " - Elige un &Aacute;rea - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}

		// obtiene los datos de la queja
		$queja = $this->quejas_model->get_queja( $id );
		if( $queja->num_rows() > 0 ) {
			foreach( $queja->result() as $row ) :
				$datos['ida'] = $row->IdArea;
				$datos['idd'] = $row->IdDepartamento;
				$datos['nom'] = $row->Nombre;
				$datos['fec'] = $row->Fecha;
				$datos['cor'] = $row->Correo;
				$datos['tel'] = $row->Telefono;
				$datos['que'] = $row->Queja;
				$datos['edo'] = $row->Estado;
			endforeach;
		}
		// obtiene los datos del seguimiento(si es que tiene)
		$queja_seguimiento = $this->quejas_model->get_seguimiento( $id );
		if( $queja_seguimiento->num_rows() > 0 ) {
			$datos['edo'] = true;
			foreach( $queja_seguimiento->result() as $row ) {
				$datos['res'] = $row->Responsable;
				$datos['des'] = $row->Descripcion;
				$datos['fes'] = $row->FechaS;
				$datos['obs'] = $row->Observacion;
			}
		}
		else {
			$datos['edo'] = false;
			$datos['res'] = '';
			$datos['des'] = '';
			$datos['fes'] = '';
			$datos['obs'] = '';
		}

		// obtiene todos los departamentos
		$departamentos = $this->Inicio_model->get_departamentos( $datos['ida'] );
		if( $departamentos->num_rows() > 0 ) {
			$datos['departamento_options'] = array();
			$datos['departamento_options'][0] = " - Elige un &Aacute;rea - ";
			foreach( $departamentos->result() as $row ) {
				$datos['departamento_options'][$row->IdDepartamento] = $row->Departamento;
			}
		}

		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);

		// revisa si ya se a enviado el formulario por post
		if( $_POST ){
			// reglas de validación
			$this->form_validation->set_rules('area', 'area', 'trim');
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
			$this->form_validation->set_rules('nombre', 'nombre', 'trim');
			$this->form_validation->set_rules('correo', 'Correo', 'required|trim');
			$this->form_validation->set_rules('telefono', 'telefono', 'trim');
			$this->form_validation->set_rules('queja', 'Queja y/o Sugerencia', 'required|trim');
			// si hay seguimiento
			if( $datos['edo'] ) {
				$this->form_validation->set_rules('fecha_seguimiento', 'Fecha', 'required|trim');
				$this->form_validation->set_rules('responsable', 'Responsable', 'required|trim');
				$this->form_validation->set_rules('descripcion', 'Descripci&oacute;n', 'required|trim');
			}
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');

			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la actualizacion si todo ha estado bien
			else{
				// valida el departamento
				if( !$this->input->post('departamento') ) {
					// msj de error
					$datos['mensaje_titulo'] = "Error de Validaci&oacute;n";
					$datos['mensaje'] = "Has olvidado elegir el departamento del &Aacute;rea ";
					$this->load->view('mensajes/error',$datos);
				}
				else {
					if( $this->quejas_model->modifica_queja( $id, $datos['edo'] ) ) {
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						$datos['mensaje'] = "La queja se ha modificado correctamente";
						$datos['enlace'] = 'admin/varios/quejas/'.$area.'/'.$estado;
						$this->load->view('mensajes/ok_redirec',$datos);
					}
				}
			}
		}

		// estructura de la página (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/quejas/modificar',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// conformidades(): Listado de No Conformidades
	//
	function conformidades() {
		// si los datos han sido enviados por post se sobre escribe la variable $ide
		if( $_POST ) {
			$ida = $this->input->post('area');
			$edo = $this->input->post('estado');
		}
		else {
			if( $this->uri->segment(4) || $this->uri->segment(5) ) {
				$ida = $this->uri->segment(4);
				$edo = $this->uri->segment(5);
			}
			else {
				$ida = "elige";
				$edo = "elige";
			}
		}
		$datos['area'] = $ida;
		$datos['estado'] = $edo;

		// obtiene todas las areas
		$areas = $this->db->order_by('Area')->get_where('ab_areas');
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options'][''] = "";
			$datos['area_options']['todos'] = " - Todas las &Aacute;reas - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}
		$datos['estado_options'] = array( 'todos' => ' - Todas - ', '0' => 'Sin Atender', '1' => 'Atendidas', '2' => 'Cerradas', '3' => 'Eliminadas' );

		// se obtiene el listado
		$this->db->order_by("IdConformidad", "DESC");
		$this->db->join("ab_areas", "ab_areas.IdArea = pa_conformidades.IdArea");
		$this->db->join("ab_departamentos", "ab_departamentos.IdDepartamento = pa_conformidades.IdDepartamento");
		// muestra todo el listado
		if( $ida == 'todos' ) {
			$datos['area'] = 'todos';
			if( $edo == 'todos' ) {
				$datos['estado'] = 'todos';
				$datos['consulta'] = $this->db->get('pa_conformidades');
			}
			else {
				$datos['estado'] = $edo;
				$datos['consulta'] = $this->db->get_where('pa_conformidades',array('pa_conformidades.Estado' => $edo));
			}
		}
		// muestra el listado del estado espec�fico
		else {
			$datos['area'] = $ida;
			if( $edo == 'todos' ) {
				$datos['estado'] = 'todos';
				$datos['consulta'] = $this->db->get_where('pa_conformidades',array('pa_conformidades.IdArea' => $ida));
			}
			else {
				$datos['estado'] = $edo;
				$datos['consulta'] = $this->db->get_where('pa_conformidades',array('pa_conformidades.IdArea' => $ida, 'pa_conformidades.Estado' => $edo));
			}
		}

		// variables necesarias para la estructura de la p�gina
		$titulo = 'No Conformidades';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();

		// genera la barra de dirección
		$this->get_barra( array( 'conformidades' => $titulo ) );
		$datos['barra'] = $this->barra;

		// estructura de la p�gina
		$this->load->view('_estructura/header',$datos);
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/conformidades/listado',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// conformidades_modificar( $id ): Modifica la no conformidad
	//
	function conformidades_modificar( $id ) {
		// carga el modelo
		$this->load->model('procesos/conformidades_model','',TRUE);

		if( $this->uri->segment(5) || $this->uri->segment(6) ) {
			$area = $this->uri->segment(5);
			$estado = $this->uri->segment(6);
		}
		else {
			$area = '';
			$estado = '';
		}
		$datos['area'] = $area;
		$datos['estado'] = $estado;

		// variables necesarias para la página
		$titulo = 'Modificar No Conformidad';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$datos['cau'] = '';
		$datos['aud'] = '';

		// genera la barra de dirección
		$enlaces = array (
			'conformidades' 			=> 'No Conformidades',
			'conformidades_modificar' 	=> $titulo
		);
		$this->get_barra( $enlaces );
		$datos['barra'] = $this->barra;

		// obtiene todas las areas excepto la de invitado
		$areas = $this->Inicio_model->get_areas();
		if ($areas -> num_rows() > 0) {
			$datos['area_options'] = array();
			$datos['area_options'][0] = " - Elige un &Aacute;rea - ";
			foreach ($areas->result() as $row)
				$datos['area_options'][$row -> IdArea] = $row -> Area;
		}

		// Datos de la no conformidad
		$conformidad = $this->conformidades_model->get_conformidad( $id );
		if ($conformidad -> num_rows() > 0) {
			foreach ($conformidad->result() as $row) {
				$idu = $row->IdUsuario;
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
				}
				else {
					$datos['edo'] = false;
				}
				$datos['eda'] = $eda;
			}
		}
		else {
			redirect( "listados/conformidades" );
		}

		// obtiene los datos del seguimiento
		if ($edo) {
			$seguimiento = $this->conformidades_model->get_seguimiento( $id );
			if ($seguimiento -> num_rows() > 0) {
				foreach ($seguimiento->result() as $row) {
					$datos['cau'] = $row->Causa;
					$datos['aud'] = $row->Auditor;
				}
			}
			$datos['diagrama']		= $this->conformidades_model->get_diagrama( $id );
			$datos['acciones']		= $this->conformidades_model->get_acciones( $id );
			$datos['contencion']	= $this->conformidades_model->get_contencion( $id );

		}

		// obtiene todos los departamentos
		$departamentos = $this->Inicio_model->get_departamentos( $datos['ida'] );
		if ($departamentos -> num_rows() > 0) {
			$datos['departamento_options'] = array();
			$datos['departamento_options'][0] = " - Elige un &Aacute;rea - ";
			foreach ($departamentos->result() as $row)
				$datos['departamento_options'][$row -> IdDepartamento] = $row -> Departamento;
		}

		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/conformidades/modificar',$datos);
		$this->load->view('admin/_estructura/footer');

		// revisa si ya se a enviado el formulario por post
		if ( $_POST ) {
			// reglas de validación
			$this->form_validation->set_rules('area', 'area', 'trim');
			$this->form_validation->set_rules('departamento', 'departamento', 'trim');
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
			$this->form_validation->set_rules('descripcion', 'Descripci&oacute;n', 'required|trim');
			// si hay seguimiento
			if ( $edo == 1 || $edo == 2 ) {
				$this->form_validation->set_rules('causa', 'Causa', 'required|trim');
			}
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');

			// envia mensaje de error si no se cumple con alguna regla
			if ($this->form_validation->run() == FALSE) {
				$this->load->view('mensajes/error_validacion', $datos);
			}
			// realiza la actualizacion si todo ha estado bien
			else {
				// valida el departamento
				if ( !$this->input->post('departamento') && $idu == $this->session->userdata('id_usuario')) {
					// msj de error
					$datos['mensaje_titulo'] = "Error de Validaci&oacute;n";
					$datos['mensaje'] = "Has olvidado elegir el departamento del &Aacute;rea ";
					$this -> load -> view('mensajes/error', $datos);
				}
				else {
					// array para actualizar en la bd
					$resp = $this->conformidades_model->modifica_conformidad( $id );

					if( $resp ) {
						// si hay seguimiento
						if ( $edo == 1 || $edo == 2 ) {
							$resp = $this->conformidades_model->modifica_seguimiento( $id );
						}

						// si todo ha estado bien manda el mensaje
						if( $resp ) {
							// msj de éxito
							echo $this->input->post('Acciones');
							$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
							$datos['mensaje'] = "La no conformidad se ha modificado correctamente";
							$datos['enlace'] = 'admin/varios/conformidades/'.$area.'/'.$estado;
							$this -> load -> view('mensajes/ok_redirec', $datos);
						}
					}
				}
			}
		}
	}

	//
	// conformidades_ver( $idc ): Muestra una queja específica
	//
	function conformidades_ver( $idc ) {
		// carga el modelo
		$this->load->model('procesos/conformidades_model','',TRUE);

		if( $this->uri->segment(5) || $this->uri->segment(6) ) {
			$area = $this->uri->segment(5);
			$estado = $this->uri->segment(6);
		}
		else {
			$area = '';
			$estado = '';
		}
		$datos['area'] = $area;
		$datos['estado'] = $estado;

		// variables necesarias para la página
		$titulo = 'Ver No Conformidad';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$datos['idc'] = $idc;

		// genera la barra de dirección
		$enlaces = array (
			'conformidades' 	=> 'No Conformidades',
			'conformidades_ver'	=> $titulo
		);
		$this->get_barra( $enlaces );
		$datos['barra'] = $this->barra;

		// obtiene los datos de la no conformidad
		$conformidad = $this -> db -> join('ab_areas', 'ab_areas.IdArea = pa_conformidades.IdArea') -> join('ab_departamentos', 'ab_departamentos.IdDepartamento = pa_conformidades.IdDepartamento') -> get_where('pa_conformidades', array('pa_conformidades.IdConformidad' => $idc));
		if ($conformidad -> num_rows() > 0) {
			foreach ($conformidad->result() as $row) :
				$ida = $row -> IdArea;
				$edo = $row -> Estado;
				$eda = $row -> EstadoAvance;
				$datos['are'] = $row -> Area;
				$datos['dep'] = $row -> Departamento;
				$datos['con'] = $row -> Consecutivo;
				$datos['ori'] = $row -> Origen;
				$datos['tip'] = $row -> Tipo;
				$datos['des'] = $row -> Descripcion;
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
				$datos['fec'] = substr($row -> Fecha, 8, 2) . " / " . $mes . " / " . substr($row -> Fecha, 0, 4);
			endforeach;
			$conformidad_usuario = $this -> db -> join('ab_usuarios', 'ab_usuarios.IdUsuario = pa_conformidades.IdUsuario') -> join('ab_areas', 'ab_areas.IdArea = ab_usuarios.IdArea') -> get_where('pa_conformidades', array('pa_conformidades.IdConformidad' => $idc));
			if ($conformidad_usuario -> num_rows() > 0) {
				foreach ($conformidad_usuario->result() as $row_u) :
					$datos['usu'] = $row_u -> Nombre . ' ' . $row_u -> Paterno . ' ' . $row_u -> Materno;
					$datos['aru'] = '(' . $row_u -> Area . ')';
				endforeach;
			}
		}

		// Obtiene la info segun el estado de la no conformidad
		switch( $edo ) {
			// sin atender
			case 0 :
				$datos['tipo'] = false;
				$datos['seguimiento'] = false;
				break;

			// atendida
			case 1 :
				$datos['tipo_title'] = "Atendida";
				$seguimiento = $this -> db -> get_where('pa_conformidades_seguimiento', array('pa_conformidades_seguimiento.IdConformidad' => $idc));
				if ($seguimiento -> num_rows() > 0) {
					$datos['seguimiento'] = true;
					foreach ($seguimiento->result() as $row) :
						$datos['cau'] = $row -> Causa;
						$datos['her'] = $row -> Herramienta;
					endforeach;
					$datos['diagrama'] = $this -> db -> get_where('pa_conformidades_diagrama', array('pa_conformidades_diagrama.IdConformidad' => $idc));
					$datos['acciones'] = $this -> db -> get_where('pa_conformidades_acciones', array('pa_conformidades_acciones.IdConformidad' => $idc));
				} else {
					$datos['seguimiento'] = false;
				}
				break;

			// cerrada
			case 2 :
				$datos['tipo_title'] = "Cerrada";
				$seguimiento = $this -> db -> get_where('pa_conformidades_seguimiento', array('pa_conformidades_seguimiento.IdConformidad' => $idc));
				if ($seguimiento -> num_rows() > 0) {
					$datos['seguimiento'] = true;
					foreach ($seguimiento->result() as $row) :
						$datos['cau'] = $row -> Causa;
						$datos['her'] = $row -> Herramienta;
					endforeach;
					$datos['diagrama'] = $this -> db -> get_where('pa_conformidades_diagrama', array('pa_conformidades_diagrama.IdConformidad' => $idc));
					$datos['acciones'] = $this -> db -> get_where('pa_conformidades_acciones', array('pa_conformidades_acciones.IdConformidad' => $idc));
				} else {
					$datos['seguimiento'] = false;
				}
				break;

			// eliminada
			case 3 :
				$datos['seguimiento'] = false;
				$datos['tipo_title'] = "Eliminada";
				break;
		}

		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/conformidades/ver',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// indicadores(): Listado de Indicadores
	//
	function indicadores() {
		// si los datos han sido enviados por post se sobre escribe la variable $ide
		if( $_POST ) {
			$ida = $this->input->post('area');
			$edo = $this->input->post('estado');
		}
		else {
			if( $this->uri->segment(4) || $this->uri->segment(5) ) {
				$ida = $this->uri->segment(4);
				$edo = $this->uri->segment(5);
			}
			else {
				$ida = "elige";
				$edo = "1";
			}
		}
		$datos['area'] = $ida;
		$datos['estado'] = $edo;

		// obtiene todas las areas
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options'][''] = "";
			$datos['area_options']['todos'] = " - Todas las &Aacute;reas - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}
		$datos['estado_options'] = array( 'todos' => ' - Todas - ', '1' => 'Activos', '0' => 'Eliminados' );

		// muestra todo el listado
		if( $ida == "todos" ) {
			if( $edo == 'todos' ) {
				$datos['indicadores'] = $this->db->join('ab_areas', 'ab_areas.IdArea = pa_indicadores.IdArea')->get('pa_indicadores');
			}
			else {
				$datos['indicadores'] = $this->db->join('ab_areas', 'ab_areas.IdArea = pa_indicadores.IdArea')->get_where('pa_indicadores', array( 'pa_indicadores.Estado' => $edo ) );
			}
		}
		// muestra el listado del estado específico
		else {
			if( $edo == 'todos' ) {
				$datos['indicadores'] = $this->db->join('ab_areas', 'ab_areas.IdArea = pa_indicadores.IdArea')->get_where('pa_indicadores',array('pa_indicadores.IdArea' => $ida));
			}
			else {
				$datos['indicadores'] = $this->db->join('ab_areas', 'ab_areas.IdArea = pa_indicadores.IdArea')->get_where('pa_indicadores',array('pa_indicadores.IdArea' => $ida, 'pa_indicadores.Estado' => $edo));
			}
		}

		$titulo = 'Indicadores';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();

		// genera la barra de dirección
		$this->get_barra( array( 'indicadores' => $titulo ) );
		$datos['barra'] = $this->barra;

		// estructura de la página
		$datos['area'] = $ida;
		$this->load->view('_estructura/header',$datos);
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/indicadores/listado',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// indicadores(): Listado de Indicadores
	//
	function agregar_indicador($ida) {
		// si los datos han sido enviados por post se sobre escribe la variable $ide

		$titulo = 'Agregar Indicador';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();

		// genera la barra de dirección
		$this->get_barra( array( 'indicadores' => $titulo ) );
		$datos['barra'] = $this->barra;
		$datos['Area']=$this->db->get_where('ab_areas',array('ab_areas.IdArea' => $ida));


		if($_POST){
			$this->form_validation->set_rules('indicador', 'Indicador', 'required|trim');
			$this->form_validation->set_rules('meta', 'Meta', 'required|trim');
			$this->form_validation->set_rules('calculo', 'Calculo', 'required|trim');
			$this->form_validation->set_rules('frecuencia', 'Frecuencia', 'required|trim');
			$this->form_validation->set_rules('responsable', 'Responsable', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			if( $this->form_validation->run() == FALSE ){
				echo "<script>alert('Debes introducir todos los campos');history.back();</script>";
			}
			// array para actualizar en la bd
			$inserta = array(
				'IdArea'		=> $ida,
			   	'Indicador'		=> $this->input->post('indicador'),
				'Calculo'		=> $this->input->post('calculo'),
				'Meta'			=> $this->input->post('meta'),
				'Responsable'	=> $this->input->post('responsable'),
				'Frecuencia'	=> $this->input->post('frecuencia'),
				'Observaciones'	=> $this->input->post('observaciones'),
				'Tipo'			=> 'POR',
				'Estado'		=> '1',
				'Especial'		=> '0',
			);

			// realiza la insercion
			$resp = $this->db->insert( 'pa_indicadores', $inserta );
			echo "<script>if(confirm('Indicador Registrado con Exito, deseas Agregar otro?')){ history.back();}else{location.href='".base_url()."index.php/admin/varios/indicadores/'};</script>";

		}else{
			// estructura de la página
			$datos['area'] = $ida;
			$this->load->view('_estructura/header',$datos);
			$this->load->view('admin/_estructura/top',$datos);
			$this->load->view('mensajes/pregunta_oculta');
			$this->load->view('admin/_estructura/usuario',$datos);
			$this->load->view('admin/varios/indicadores/agregar_indicador',$datos);
			$this->load->view('admin/_estructura/footer');
		}
	}

	//
	// indicadores(): Listado de Indicadores
	//
	function eliminar_indicador($id, $ida) {
		// si los datos han sido enviados por post se sobre escribe la variable $ide
			$update = array(
				'Estado'	=> 0,
			);
			$edo=1;
			// realiza la insercion
			$this->db->where( 'IdIndicador', $id );
			$resp = $this->db->update( 'pa_indicadores', $update );
			echo "<script>";
			echo "if(confirm('Indicador Desactivado, ¿Quieres eliminar otro?')){";
			echo 	"location.href='".base_url()."index.php/admin/varios/indicadores/".$ida."/".$edo."'";
			echo 	"}else{";
			echo 		"location.href='".base_url()."index.php/admin/varios/indicadores/'";
			echo "}";
			echo "</script>";
	}

	function activar_indicador($id, $ida) {
		// si los datos han sido enviados por post se sobre escribe la variable $ide
			$update = array(
				'Estado'	=> 1,
			);
			$edo=0;
			// realiza la insercion
			$this->db->where( 'IdIndicador', $id );
			$resp = $this->db->update( 'pa_indicadores', $update );
			echo "<script>";
			echo "if(confirm('Indicador Activado, ¿Quieres Activar otro?')){";
			echo 	"location.href='".base_url()."index.php/admin/varios/indicadores/".$ida."/".$edo."'";
			echo 	"}else{";
			echo 		"location.href='".base_url()."index.php/admin/varios/indicadores/'";
			echo "}";
			echo "</script>";
	}
		//
	// indicadores_grafica( $id, $ano ): Analiza que tipo de grafica mostrar para el inidcador
	//
	function indicadores_grafica( $id, $ano ) {
		// carga el modelo
		$this->load->model('procesos/indicadores_model','',TRUE);

		if( $this->uri->segment(6) || $this->uri->segment(7) ) {
			$area = $this->uri->segment(6);
			$estado = $this->uri->segment(7);
		}
		else {
			$area = '';
			$estado = '';
		}
		$datos['area'] = $area;
		$datos['estado'] = $estado;

		// variables necesarias para la página
		$titulo = 'Gr&aacute;fica del Indicadores';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();

		// genera la barra de dirección
		$enlaces = array(
			'indicadores/'.$area.'/'.$estado	=> 'Indicadores',
			'indicadores_grafica/'.$id.'/'.$ano => $titulo
		);
		$this->get_barra( $enlaces );
		$datos['barra'] = $this->barra;
		$datos['ano'] = $ano;
		$grafica = true;

		// datos del indicador
		$indicador = $this->indicadores_model->get_indicador( $id );
		$datos['indicador'] = $indicador;
		if( $indicador->num_rows() > 0 ) {
			foreach( $indicador->result() as $row ) {
				if( $row->Tipo == 'DIA' ) {
					$tipo = ' dias';
				}
				else {
					$tipo = '%';
				}
			}
		}

		// obtiene las mediciones del indicador
		$mediciones = $this->indicadores_model->get_mediciones( $id );
		$datos['mediciones'] = $mediciones;
		$mediciones_indicador = '';
		if( $mediciones->num_rows() > 0 ) {
			$alto = 150 + ( $mediciones->num_rows() * 40 );
			$alto_grafica = $alto - 100;
			$ano_array = array();
			$i = 0;
			foreach( $mediciones->result() as $row ) {
				$ano = substr($row->Fecha,0,4);
				$ano_array[$i] = $ano;
				$i++;
				if( $ano == $datos['ano'] || $datos['ano'] == 'todos' ) {
					$num = $row->Medicion;
					switch( substr($row->Fecha,5,2) ) {
						case "01" : $mes = "Ene"; break;
						case "02" : $mes = "Feb"; break;
						case "03" : $mes = "Mar"; break;
						case "04" : $mes = "Abr"; break;
						case "05" : $mes = "May"; break;
						case "06" : $mes = "Jun"; break;
						case "07" : $mes = "Jul"; break;
						case "08" : $mes = "Ago"; break;
						case "09" : $mes = "Sep"; break;
						case "10" : $mes = "Oct"; break;
						case "11" : $mes = "Nov"; break;
						case "12" : $mes = "Dic"; break;
					}
					$mediciones_indicador .= '["'.$mes.' '.$ano.'", '.$num.'],';
				}
			}
			$mediciones_indicador = substr($mediciones_indicador,0,-1);

			// años
			$anos  = '<br /><table class="tabla_form" style="border-collapse:separate"><tr><th>Elige el a&ntilde;o:</th>';
			if( $datos['ano'] == 'todos' ) {
				$anos .= '<td style="background-color:#007799;"><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$id.'/todos" onmouseover="tip(\'Revisar las mediciones<br />de este a&ntilde;o\')" onmouseout="cierra_tip()" style="color:#FFF">Todos</a></td>';
				$ano_tag = 'Todos los años';
			}
			else {
				$anos .= '<td><a href="'.base_url().'index.php/admin/varios/indicadores_grafica/'.$id.'/todos/'.$area.'/'.$estado.'" onmouseover="tip(\'Revisar las mediciones<br />de este a&ntilde;o\')" onmouseout="cierra_tip()">Todos</a></td>';
				$ano_tag = $datos['ano'];
			}
			$ano_temp = 0;
			for( $i = 0; $i < sizeof($ano_array); $i++) {
				if( $ano_temp != $ano_array[$i] ) {
					if( $datos['ano'] == $ano_array[$i] )
						$anos .= '<td style="background-color:#007799;"><a href="'.base_url().'index.php/admin/varios/indicadores_grafica/'.$id.'/'.$ano_array[$i].'/'.$area.'/'.$estado.'" onmouseover="tip(\'Revisar las mediciones<br />de este a&ntilde;o\')" onmouseout="cierra_tip()" style="color:#FFF">'.$ano_array[$i].'</a></td>';
					else
						$anos .= '<td><a href="'.base_url().'index.php/admin/varios/indicadores_grafica/'.$id.'/'.$ano_array[$i].'/'.$area.'/'.$estado.'" onmouseover="tip(\'Revisar las mediciones<br />de este a&ntilde;o\')" onmouseout="cierra_tip()">'.$ano_array[$i].'</a></td>';
					$ano_temp = $ano_array[$i];
				}
			}
			$anos .= '</tr></table>';
			$datos['anos'] = $anos;
		}
		else {
			$grafica = false;
			$ano = 0;
			$alto = 0;
			$alto_grafica = 0;
			$datos['anos'] = '';
			$ano_tag = '';
		}

		// gráfica
		$datos['grafica'] = '
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">
			  google.load("visualization", "1.0", {"packages":["corechart"]});
			  google.setOnLoadCallback(drawChart);
			  function drawChart() {
			  var data = new google.visualization.DataTable();
			  data.addColumn("string", "Fecha");
			  data.addColumn("number", "Avance");
			  data.addRows(['.$mediciones_indicador.']);
			  var options = {
				  width: 950,
				  height: '.$alto.',
				  colors: ["#007799"],
				  fontSize: "12",
				  fontName: "Tahoma",
				  legend: "none",
				  vAxis: { title: "Mediciones '.$ano_tag.'", titleTextStyle: { fontSize: "18", fontName: "Tahoma" } },
				  hAxis: {
							 title: "Porcentaje de Avance",
							 format:"#\'%\'",
							 titleTextStyle: {
								 fontSize: "18",
								 fontName: "Tahoma"
							 },
							 viewWindowMode: "explicit",
							 viewWindow: {
								 min: 1,
								 max: 100
							 }
						  },
				  chartArea: { top: 30, left: 100, width: 900, height: '.$alto_grafica.' },
				  tooltipTextStyle: { fontSize: "16" },
			  };

			  var formatter = new google.visualization.NumberFormat({suffix: "'.$tipo.'",fractionDigits: 0});
			  formatter.format(data, 1); // Apply formatter to second column

			  var chart = new google.visualization.BarChart(document.getElementById("chart_div"));
			  chart.draw(data, options);
			}
			</script>
            <div id="chart_div"></div>
		';
		if( !$grafica ) {
			$datos['grafica'] = '<br /><br /><table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento este indicador no tiene mediciones</td></tr></table>';
		}

		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/indicadores/grafica',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// indicadores_modificar( $id ): Modifica el indicador
	//
	function indicadores_modificar( $id ) {
		// carga el modelo
		$this->load->model('procesos/indicadores_model','',TRUE);

		if( $this->uri->segment(5) || $this->uri->segment(6) ) {
			$area = $this->uri->segment(5);
			$estado = $this->uri->segment(6);
		}
		else {
			$area = '';
			$estado = '';
		}
		$datos['area'] = $area;
		$datos['estado'] = $estado;

		// variables necesarias para la página
		$titulo = 'Modificar Indicador';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;

		// genera la barra de dirección
		$enlaces = array(
			'indicadores/'.$area.'/'.$estado				 => 'Indicadores',
			'indicadores_modificar/'.$id.'/'.$area.'/'.$estado => $titulo
		);
		$this->get_barra( $enlaces );
		$datos['barra'] = $this->barra;
		$datos['id'] = $id;
		$datos['mediciones'] = $this->indicadores_model->get_mediciones( $id );

		// obtiene los datos del indicador
		$consulta = $this->indicadores_model->get_indicador( $id );
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) :
				$datos['ind'] = $row->Indicador;
				$datos['met'] = $row->Meta;
				$datos['cal'] = $row->Calculo;
				$datos['fre'] = $row->Frecuencia;
				$datos['res'] = $row->Responsable;
				$datos['obs'] = $row->Observaciones;
			endforeach;
		}

		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/indicadores/modificar',$datos);
		$this->load->view('admin/_estructura/footer');

		if( $_POST ){
			// reglas de validaci�n
			$this->form_validation->set_rules('indicador', 'Indicador', 'required|trim');
			$this->form_validation->set_rules('meta', 'Meta', 'required|trim');
			$this->form_validation->set_rules('calculo', 'Calculo', 'required|trim');
			$this->form_validation->set_rules('frecuencia', 'Frecuencia', 'required|trim');
			$this->form_validation->set_rules('responsable', 'Responsable', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');

			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserci�n a la base de datos si todo ha estado bien
			else{
				if( $this->indicadores_model->modifica_indicador( $id ) ) {
					// msj de �xito
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "La informaci&oacute;n del indicador se ha modificado correctamente";
					$datos['enlace'] = "admin/varios/indicadores/".$area."/".$estado;
					$this->load->view('mensajes/ok_redirec',$datos);
				}
			}
		}
	}
	//
	// Controlador para agregar eventos al calendario
	//
	function calendario(){
		$datos['titulo'] = 'Calendario';
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		// genera la barra de dirección
		$datos['barra'] = $this->barra;
		$datos['calendario'] = $this->inicio_admin_model->get_calendario();
		if($_POST){
			$fecha = $this->input->post('Fecha');
			$evento = $this->input->post('Evento');
			$this->inicio_admin_model->calendario_agregar($fecha, $evento);
			$redirect = 'Location: '.base_url().'index.php/admin/varios/calendario';
			header($redirect);
		}else{
			// estructura de la pagina
			$this->load->view('_estructura/header',$datos);
			$this->load->view('admin/_estructura/top',$datos);
			$this->load->view('admin/_estructura/usuario',$datos);
			$this->load->view('admin/varios/calendario',$datos);
			$this->load->view('admin/_estructura/footer');
		}
	}

	function dCal($id){
		$this->inicio_admin_model->dCal($id);
		$redirect = 'Location: '.base_url().'index.php/admin/varios/calendario';
		header($redirect);
	}
	//
	// minutas(): Listado de minutas por área
	//
	function minutas() {
		// si los datos han sido enviados por post se sobre escribe la variable $ide
		if( $_POST ) {
			$ida = $this->input->post('area');
			$edo = $this->input->post('estado');
		}
		else {
			if( $this->uri->segment(4) || $this->uri->segment(5) ) {
				$ida = $this->uri->segment(4);
				$edo = $this->uri->segment(5);
			}
			else {
				$ida = "elige";
				$edo = "elige";
			}
		}
		$datos['area'] = $ida;
		$datos['estado'] = $edo;

		// variables necesarias para la estructura de la p�gina
		$titulo = 'Minutas';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();

		$this->get_barra( array( 'minutas' => $titulo ) );
		$datos['barra'] = $this->barra;

		// obtiene todas las areas
		$areas = $this -> db -> order_by('Area') -> get_where('ab_areas', array('Area !=' => 'Invitado'));
		if ($areas -> num_rows() > 0) {
			$datos['area_options'] = array();
			$datos['area_options'][''] = "";
			$datos['area_options']['todos'] = " - Todas las &Aacute;reas - ";
			foreach ($areas->result() as $row)
				$datos['area_options'][$row -> IdArea] = $row -> Area;
		}
		$datos['estado_options'] = array('todos' => ' - Todas - ', '1' => 'Activas', '0' => 'Eliminadas');

		// se obtiene el listado
		$this -> db -> order_by("ab_areas.Area", "ASC");
		$this -> db -> join("ab_areas", "ab_areas.IdArea = mn_minutas.IdArea");
		$this -> db -> join("mn_minutas_puntos", "mn_minutas_puntos.IdMinuta = mn_minutas.IdMinuta");
		// muestra todo el listado
		if ($ida == "todos") {
			$datos['area'] = 'todos';
			if ($edo == "all") {
				$datos['selec'] = 'todos';
				$datos['consulta'] = $this -> db -> get('mn_minutas');
			} else {
				$datos['selec'] = $edo;
				$datos['consulta'] = $this -> db -> get_where('mn_minutas', array('mn_minutas.Estado' => $edo));
			}
		}
		// muestra el listado del estado específica
		else {
			$datos['area'] = $ida;
			if ($edo == "todos") {
				$datos['selec'] = 'todos';
				$datos['consulta'] = $this -> db -> get_where('mn_minutas', array('mn_minutas.IdArea' => $ida));
			} else {
				$datos['estado'] = $edo;
				$datos['consulta'] = $this -> db -> get_where('mn_minutas', array('mn_minutas.IdArea' => $ida, 'mn_minutas.Estado' => $edo));
			}
		}

		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/minutas',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// noticias(): Listado de las noticias
	//
	function noticias() {
		// si los datos han sido enviados por post se sobre escribe la variable $ide
		if( $_POST ) {
			$edo = $this->input->post('estado');
		}
		else {
			if( $this->uri->segment(4) ) {
				$edo = $this->uri->segment(4);
			}
			else {
				$edo = "1";
			}
		}
		$datos['estado'] = $edo;

		$titulo = 'Noticias';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();

		$datos['estado_options'] = array( 'todos' => ' - Todas - ', '1' => 'Activas', '0' => 'Eliminadas' );

		// genera la barra de dirección
		$this->get_barra( array( 'noticias' => $titulo ) );
		$datos['barra'] = $this->barra;

		if( $edo == 'todos' ) {
			$datos['noticias'] = $this->db->order_by('Fecha','DESC')->get('ef_noticias');
		}
		else {
			$datos['noticias'] = $this->db->order_by('Fecha','DESC')->get_where('ef_noticias', array( 'Estado' => $edo ) );
		}

		// estructura de la pagina
		$this->load->view('_estructura/header',$datos);
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/noticias/listado',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// noticias_agregar(): Agrega las noticias
	//
	function noticias_agregar() {
		$titulo = "Agregar Noticia";
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;

		// genera la barra de dirección
		$enlaces = array(
			'noticias'		   => 'Noticias',
			'noticias_agregar' => $titulo
		);
		$this->get_barra( $enlaces );
		$datos['barra'] = $this->barra;

		// estructura de la pagina (1)
		$this->load->view('_estructura/header',$datos);

		// Guarda / Actualiza los datos
		if( $_POST ) {
			$this->form_validation->set_rules('resumen', 'Resumen', 'required|trim');
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');

			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			else {
				$query = array(
					'Fecha' 		=> $this->input->post('fecha'),
					'Resumen'		=> $this->input->post('resumen'),
					'Noticia'		=> $this->input->post('noticia'),
					'Estado'		=> '1' // Noticia activa
				);
				$resp = $this->db->insert('ef_noticias', $query);

				if( $resp ) {
					// msj de éxito
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "La noticia se ha guardado correctamente";
					$datos['enlace'] = "admin/varios/noticias";
					$this->load->view('mensajes/ok_redirec',$datos);
				}
			}

		}

		// estructura de la pagina (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/noticias/agregar',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// noticias_modificar( $id ): Modifica las noticias
	//
	function noticias_modificar( $id ) {
		$titulo = "Modificar Noticia";
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;

		// genera la barra de dirección
		$enlaces = array(
			'noticias'		   => 'Noticias',
			'noticias_modificar/'.$id => $titulo
		);
		$this->get_barra( $enlaces );
		$datos['barra'] = $this->barra;

		$noticia = $this->db->get_where('ef_noticias', array('IdNoticia' => $id));
		if( $noticia->num_rows() > 0 ) {
			foreach( $noticia->result() as $row ) {
				$datos['fec'] = $row->Fecha;
				$datos['res'] = $row->Resumen;
				$datos['not'] = $row->Noticia;
			}
		}

		// estructura de la pagina (1)
		$this->load->view('_estructura/header',$datos);

		// Guarda / Actualiza los datos
		if( $_POST ) {
			$this->form_validation->set_rules('resumen', 'Resumen', 'required|trim');
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');

			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			else {
				$fecha  = substr($this->input->post('fecha'),8,2);
				switch( substr($this->input->post('fecha'),5,2) ) {
					case "01" : $fecha .= " / Enero / "; break;
					case "02" : $fecha .= " / Febrero / "; break;
					case "03" : $fecha .= " / Marzo / "; break;
					case "04" : $fecha .= " / Abril / "; break;
					case "05" : $fecha .= " / Mayo / "; break;
					case "06" : $fecha .= " / Junio / "; break;
					case "07" : $fecha .= " / Julio / "; break;
					case "08" : $fecha .= " / Agosto / "; break;
					case "09" : $fecha .= " / Septiembre / "; break;
					case "10" : $fecha .= " / Octubre / "; break;
					case "11" : $fecha .= " / Noviembre / "; break;
					case "12" : $fecha .= " / Diciembre / "; break;
				}
				$fecha .= substr($this->input->post('fecha'),0,4);

				$query = array(
					'FechaNoticia' 	=> $fecha,
					'Fecha' 		=> $this->input->post('fecha'),
					'Resumen'		=> $this->input->post('resumen'),
					'Noticia'		=> $this->input->post('noticia'),
					'Estado'		=> '1' // Noticia activa
				);
				$this->db->where(array('IdNoticia' => $id));
				$resp = $this->db->update('ef_noticias', $query);

				if( $resp ) {
					// msj de éxito
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "La noticia se ha modificado correctamente";
					$datos['enlace'] = "admin/varios/noticias";
					$this->load->view('mensajes/ok_redirec',$datos);
				}
			}

		}

		// estructura de la pagina (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/noticias/modificar',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// contacto(): Listado de contacto
	//
	function contacto() {
		// si los datos han sido enviados por post se sobre escribe la variable $ide
		if( $_POST ) {
			$edo = $this->input->post('estado');
		}
		else {
			if( $this->uri->segment(4) ) {
				$edo = $this->uri->segment(4);
			}
			else {
				$edo = "1";
			}
		}
		$datos['estado'] = $edo;

		$titulo = "Contacto";
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;

		$datos['estado_options'] = array( 'todos' => ' - Todas - ', '1' => 'Pendientes', '0' => 'Le&iacute;dos' );

		// genera la barra de dirección
		$this->get_barra( array( 'contacto' => $titulo ) );
		$datos['barra'] = $this->barra;

		if( $edo == 'todos' ) {
			$datos['contacto'] = $this->db->order_by('Fecha','DESC')->get('ef_contacto');
		}
		else {
			$datos['contacto'] = $this->db->order_by('Fecha','DESC')->get_where('ef_contacto', array('Estado' => $edo));
		}

		// estructura de la pagina
		$this->load->view('_estructura/header',$datos);
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/contacto',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// contacto_archivar( $id ): Archiva un mensaje de contacto
	//
	function contacto_archivar( $id ) {
		$resp = $this->db->where('IdContacto',$id)->update('ef_contacto', array('Estado' => '0'));

		redirect('admin/varios/contacto');
	}

	//
	// cap_evaluacion(): Inicia / Revisa las evaluaciones de DNC
	//
	function cap_evaluacion() {
		$titulo = "Iniciar Evaluación DNC";
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();

		// genera la barra de dirección
		$this->get_barra( array( 'cap_evaluacion' => $titulo ) );
		$datos['barra'] = $this->barra;

		// obtiene las evaluaciones
		$datos['evaluaciones'] = $this->db->get('pa_capacitacion_evaluacion');

		// estructura de la pagina (1)
		$this->load->view('_estructura/header',$datos);

		// realiza la modificaci�n
		if( $_POST ) {
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');

			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			else {
				$consulta = $this->db->get_where('pa_capacitacion_evaluacion', array('Estado' => 1));
				if( $consulta->num_rows() > 0 ) {
					// msj de �xito
					$datos['mensaje_titulo'] = "Evaluación";
					$datos['mensaje'] = "Antes de crear una nueva evaluación debes de desactivar la que esta activa";
					$this->load->view('mensajes/error',$datos);
				}
				else {
					$inserta = array(
						'Fecha'	 	=> $this->input->post('fecha'),
						'Estado'	=> '1',
					);
					$resp = $this->db->insert('pa_capacitacion_evaluacion', $inserta);
					if( $resp ) {
						// msj de �xito
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						$datos['mensaje'] = "La evaluación se ha iniciado";
						$datos['enlace'] = "admin/varios/cap_evaluacion";
						$this->load->view('mensajes/ok_redirec',$datos);
					}
				}
			}
		}

		// estructura de la pagina (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/capacitacion/evaluacion',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// cap_propuestos(): Cursos Propuestos por las Áreas
	//
	function cap_propuestos() {

		if( $_POST ) {
			$tipo = $this->input->post('tipo');

		}
		$titulo = "Cursos Propuestos por las Áreas";
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();

		$pcondicion = array('Estado' => 1,);
		$periodo =$this->db->get_where('pa_capacitacion_evaluacion', $pcondicion);
		foreach($periodo->result() as $cp){
			$periodo = $cp->IdCapacitacionEvaluacion;
			echo $periodo;
		}

		// genera la barra de dirección
		$this->get_barra( array( 'cap_propuestos' => $titulo ) );
		$datos['barra'] = $this->barra;

		// obtiene todas las areas
		$tipo = $this->db->order_by('Tipo')->get_where('varios');
		$condicion=array(
			'pa_capacitacion_cursos_propuestos.Estado' => '0',
			'pa_capacitacion_cursos.IdCapacitacionEvaluacion ' => $periodo,
		);
		$this->db->order_by( 'pa_capacitacion_cursos_propuestos.Fecha' );
		$this->db->group_by('pa_capacitacion_cursos.Curso');
		$this->db->join('pa_capacitacion_cursos', 'pa_capacitacion_cursos.IdCapacitacionCurso = pa_capacitacion_cursos_propuestos.IdCurso');
		$this->db->join('ab_areas', 'ab_areas.IdArea=pa_capacitacion_cursos_propuestos.IdArea');
		$datos['propuestos']= $this->db->get_where('pa_capacitacion_cursos_propuestos',$condicion);

		// estructura de la pagina (1)
		$this->load->view('_estructura/header',$datos);

		// guarda los datos
		if ($_POST) {

			if ($this -> input -> post('aprobar')) {
				foreach ( $this->input->post('aprobar') as $lista ) {
					$resp = $this->db->where('pa_capacitacion_cursos_propuestos.IdCapacitacionCursoPropuesto', $lista)->update('pa_capacitacion_cursos_propuestos', array('Estado' => '1'));
				}

				// msj de guardado
				if ($resp) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "Las cursos se han aprobado";
					$datos['enlace'] = "admin/varios/cap_propuestos";
					$this -> load -> view('mensajes/ok_redirec', $datos);
				}
				// msj de error
				else {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error. Por favor intentalo de nuevo";
					$datos['enlace'] = "admin/varios/cap_propuestos";
					$this -> load -> view('mensajes/ok_redirec', $datos);
				}
			}
		}

		// estructura de la pagina (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/capacitacion/propuestos', $datos);
	}
	//
	// cap_aprobados(): Cursos Aprobados
	//
	function cap_aprobados() {
		if( $_POST ) {
			$area = $this->input->post('area');
			$eva = $this->input->post('evaluacion');
		}
		else {
			$area = '';
			$eva = '';
		}
		$datos['area'] = $area;
		$datos['evaluacion'] = $eva;

		$titulo = "Cursos Aprobados";
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();

		// genera la barra de dirección
		$this->get_barra( array( 'cap_aprobados' => $titulo ) );
		$datos['barra'] = $this->barra;

		// obtiene todas las areas
		$areas = $this->db->order_by('Area')->get_where('ab_areas');
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options'][''] = " - Elige el Área - ";
			$datos['area_options']['todos'] = " - Todas las &Aacute;reas - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}

		// obtiene las evaluaciones
		$evaluaciones = $this->db->order_by('Fecha')->get_where('pa_capacitacion_evaluacion');
		if( $evaluaciones->num_rows() > 0 ) {
			$datos['evaluacion_options'] = array();
			$datos['evaluacion_options'][''] = " - Elige la Evaluación - ";
			$datos['evaluacion_options']['todos'] = " - Todas las Evaluaciones - ";
			foreach( $evaluaciones->result() as $row ) $datos['evaluacion_options'][$row->IdCapacitacionEvaluacion] = $row->Fecha;
		}

		// obtiene los cursos aprobados
		$this->db->join('pa_capacitacion_cursos','pa_capacitacion_cursos.IdCapacitacionCurso = pa_capacitacion_cursos_propuestos.IdCurso');
		$this->db->join('ab_areas','ab_areas.IdArea = pa_capacitacion_cursos_propuestos.IdArea');
		$this->db->where( array( 'pa_capacitacion_cursos_propuestos.Estado' => '1') );
		$datos['propuestos'] = $this->db->get('pa_capacitacion_cursos_propuestos');

		// estructura de la pagina
		$this->load->view('_estructura/header',$datos);
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/capacitacion/aprobados',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	//	Crear curso por parte de Calidad
	//
	function cap_propuestos2() {

		$titulo = "Crear Curso";
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();

		$id_evaluacion=$this->varios_admin_model->get_evaluacion();

		// genera la barra de dirección
		$this->get_barra( array( 'cap_propuestos2' => $titulo ) );
		$datos['barra'] = $this->barra;


		// estructura de la pagina (1)
		$this->load->view('_estructura/header',$datos);

		// guarda los datos
		if ($_POST) {
			$insert = array(
			'IdCapacitacionEvaluacion'	=> $id_evaluacion,
			'IdUsuario'					=> $this->session->userdata('id_usuario'),
			'Curso'						=> $this->input->post('curso'),
			'Comentarios'				=> $this->input->post('comentarios'),
			'Estado'					=> '1',
		);
		$idCurso=$this->varios_admin_model->get_idcurso();
		$insert2 = array (
			'IdCurso'					=> $idCurso,
			'IdArea'					=> $this->session->userdata('id_area'),
			'Tipo'						=> $this->input->post('tipo'),
			'Fecha'						=> $this->input->post('fecha'),
			'Cantidad'					=> $this->input->post('cantidad'),
			'Observaciones'				=> $this->input->post('comentarios'),
			'Estado'					=> '1',
		);

			$this->db->insert('pa_capacitacion_cursos', $insert );
			$this->db->insert('pa_capacitacion_cursos_propuestos', $insert2);
			redirect('admin/varios/cap_propuestos');
		}

		// estructura de la pagina (2)
		echo $this->input->post('fecha');
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/capacitacion/curso_calidad');
	}

	//
	//solicitudes(): para ver el listado de las solicitudes
	//
	function solicitudes($id){
		$titulo = "Solicitudes de Mantenimiento a la Infrestructura";
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		$datos['barra'] = $this->barra;

		$condicion=array(
			'reg_infra.Respuesta' => 'Inconforme',
			'reg_infra.Periodo'	  => $id,
		);

		$this->db->join('ab_areas',"ab_areas.IdArea=reg_infra.IdArea");
		$this->db->join('ab_departamentos', "ab_departamentos.IdDepartamento=reg_infra.Departamento");
		$datos['consulta']=$this->db->get_where('reg_infra', $condicion);

		$this->load->view('_estructura/header',$datos);
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/infraestructura/infra_solicitudes', $datos);
		$this->load->view('admin/_estructura/footer');


	}
	//
	// identidad( $idi ): Administraci�n de la identidad
	//
	function identidad( $ids, $idi ) {
		// obtiene los datos de la identidad
		$consulta = $this->db->join('cd_identidad_textos','cd_identidad_textos.IdIdentidad = cd_identidad.IdIdentidad')->get_where('cd_identidad',array('cd_identidad_textos.IdSistema' => $ids, 'cd_identidad.Estado' => '1', 'cd_identidad.IdIdentidad' => $idi),1);
		if( $consulta->num_rows() > 0 ) {
			$new = false;
			foreach( $consulta->result() as $row ) :
				$tit = $row->Titulo;
				$datos['tit'] = $row->Titulo;
				$datos['tex'] = $row->Texto;
			endforeach;
		}
		else {
			$new = true;
			$consulta = $this->db->get_where('cd_identidad',array('cd_identidad.IdIdentidad' => $idi),1);
			if( $consulta->num_rows() > 0 )
				foreach( $consulta->result() as $row )
					$tit = $row->Titulo;
			$datos['tit'] = $tit;
			$datos['tex'] = '';
		}
		$consulta = $this->db->get_where('cd_sistemas',array('cd_sistemas.IdSistema' => $ids),1);
		if( $consulta->num_rows() > 0 )
			foreach( $consulta->result() as $row )
				$tit = $tit." ".$row->Abreviatura;

		// variables necesarias para la estructura de la p�gina
		$titulo = 'Identidad: '.$tit;
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;

		// genera la barra de dirección
		$this->get_barra( array( 'identidad/'.$ids.'/'.$idi => $titulo ) );
		$datos['barra'] = $this->barra;

		// estructura de la pagina
		$this->load->view('_estructura/header',$datos);
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/varios/identidad',$datos);
		$this->load->view('admin/_estructura/footer');

		// realiza la modificaci�n
		if( $_POST ) {
			$this->form_validation->set_rules('texto', 'Texto', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');

			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			else {
				// insert
				if( $new ) {
					$inserta = array(
						'IdSistema' 	=> $ids,
						'IdIdentidad'	=> $idi,
						'Texto' 		=> $this->input->post('texto')
					);
					$resp = $this->db->insert('cd_identidad_textos', $inserta);
					if( $resp ) {
						// msj de �xito
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						$datos['mensaje'] = "La informaci&oacute;n se ha guardado correctamente";
						$datos['enlace'] = "admin/inicio";
						$this->load->view('mensajes/ok_redirec',$datos);
					}
				}
				// update
				else {
					$actualiza = array('Texto' => $this->input->post('texto'));
					$this->db->where(array('IdIdentidad' => $idi, 'IdSistema' => $ids));
					$resp = $this->db->update('cd_identidad_textos', $actualiza);
					if( $resp ) {
						// msj de �xito
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						$datos['mensaje'] = "La informaci&oacute;n se ha actualizado correctamente";
						$datos['enlace'] = "admin/inicio";
						$this->load->view('mensajes/ok_redirec',$datos);
					}
				}
			}
		}
	}



	//
	// indicadores(): Muestra los usuarios de las areas con y sin habilidades
	//
	function habilidades() {
		// si los datos han sido enviados por post se sobre escribe la variable $ide
		if( $_POST ) {
			$ida = $this->input->post('area');
			$edo = $this->input->post('estado');
		}
		else {
			if( $this->uri->segment(4) || $this->uri->segment(5) ) {
				$ida = $this->uri->segment(4);
				$edo = $this->uri->segment(5);
			}
			else {
				$ida = "elige";
				$edo = "1";
			}
		}
		$datos['area'] = $ida;
		$datos['estado'] = $edo;

		// obtiene todas las areas
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options'][''] = "";

			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}
		$datos['estado_options'] = array(  '1' => 'Con Habilidades', '0' => 'Sin Habilidades' );
		$titulo = 'Habilidades y Aptitudes';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();

		// genera la barra de dirección
		$this->get_barra( array( 'indicadores' => $titulo ) );
		$datos['barra'] = $this->barra;

		// estructura de la página
		if($_POST){

			$datos['area'] = $this->input->post('area');

			$condicion = array(
					'ab_usuarios.IdArea'	=> $ida,
					'ab_usuarios.Estado'	=> 1,
				);

			//$datos['usuarios']=$this->db->get_where('ab_usuarios', array ('IdArea' => $this->input->post('area'), 'Estado' => 1));
			switch($edo){
				case 1:
					$condicion = array(
						'ab_usuarios.IdArea'	=> $ida,
						'ab_usuarios.Estado'	=> 1,
					);
					$this->db->order_by('ab_usuarios.Paterno', 'ASC');
					$this->db->join('ab_puestos', 'ab_puestos.IdUsuario = ab_usuarios.IdUsuario');
					$datos['usuarios']=$this->db->get_where('ab_usuarios', $condicion );
				break;
				case 0:
					//$a="SELECT * FROM ab_usuarios WHERE Estado = 1 AND NOT EXIST ('SELECT * FROM ab_puestos')";
					$condicion = array(
						'ab_usuarios.IdArea'	=> $ida,
						'ab_usuarios.Estado'	=> 1,
						'ab_puestos.IdUsuario'	=> NULL,
					);
					$this->db->order_by('ab_usuarios.Paterno', 'ASC');
					$this->db->join('ab_puestos', 'ab_puestos.IdUsuario = ab_usuarios.IdUsuario', 'LEFT');
					$this->db->select('ab_usuarios.IdArea, ab_usuarios.IdUsuario,ab_usuarios.Nombre, ab_usuarios.Paterno, ab_usuarios.Materno, ab_puestos.Puesto');
					$datos['usuarios']=$this->db->get_where("ab_usuarios", $condicion);
					//$datos['usuarios']=$this->db->query("SELECT * FROM ab_usuarios LEFT JOIN ab_puestos ON ab_usuarios.IdUsuario= ab_puestos.IdUsuario WHERE ab_usuarios.IdArea = '$ida' AND ab_puestos.IdUsuario = 'NULL' ");
				break;
			}
			$this->load->view('_estructura/header',$datos);
			$this->load->view('admin/_estructura/top',$datos);
			$this->load->view('admin/_estructura/usuario',$datos);
			$this->load->view('admin/varios/habilidades/habilidades',$datos);
			$this->load->view('admin/_estructura/footer');
		}else{
			$this->load->view('_estructura/header',$datos);
			$this->load->view('admin/_estructura/top',$datos);
			$this->load->view('admin/_estructura/usuario',$datos);
			$this->load->view('admin/varios/habilidades/habilidades',$datos);
			$this->load->view('admin/_estructura/footer');
		}
	}
	//
	// Funcion para agregar puesto a los usuarios de cada area: $ida, $IdUsuario
	//
	function habilidades_puesto($ida, $idu){
			$this->inicio_admin_model->set_sort( 20 );
			$datos['titulo'] = "Agregar Puesto";
			$datos['menu'] = $this->menu;

			$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
			$datos['barra'] = $this->barra;

			//Recupera los Datos del Usuario
			$this->db->select('ab_usuarios.Nombre, ab_usuarios.Paterno, ab_usuarios.Materno');
			$datos['nombre']=$this->db->get_where('ab_usuarios', array('IdUsuario' => $idu));
			//agrega el IdUsuario a la tabla puestos
			if($this->input->post('puesto')){
				$inserta = array(
					'IdArea'		=> $ida,
				   	'IdUsuario'		=> $idu,
					'Puesto'		=> $this->input->post('puesto'),
				);
				$this->db->insert('ab_puestos', $inserta);
				echo "<script>location.href='".base_url()."index.php/admin/varios/habilidades_agregar/".$idu."';</script>";
				//$puesto=$this->db->get_where('ab_puestos', array('IdUsuario' => $idu));
				//echo $puesto;
			}else{

			$this->load->view('_estructura/header',$datos);
			$this->load->view('admin/_estructura/top',$datos);
			$this->load->view('admin/_estructura/usuario',$datos);
			$this->load->view('admin/varios/habilidades/puesto',$datos);
			$this->load->view('admin/_estructura/footer');
		}
	}

	//
	// Funcion para agregar puesto a los usuarios de cada area: $ida, $IdUsuario
	//
	function habilidades_agregar($idu){
			$this->inicio_admin_model->set_sort( 20 );
			$datos['titulo'] = "Agregar Habilidades";
			$datos['menu'] = $this->menu;

			$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
			$datos['barra'] = $this->barra;

			//Recupera los Datos del Usuario
			$this->db->order_by('ab_usuarios.Paterno', 'ASC');
			$this->db->join('ab_puestos', 'ab_puestos.IdUsuario = ab_usuarios.IdUsuario');
			$datos['nombre']=$this->db->get_where('ab_usuarios', array ('ab_usuarios.IdUsuario' => $idu) );

			//recupera las habilidades del usuario
			$this->db->join('pa_capacitacion_habilidades', 'pa_capacitacion_habilidades.IdPuesto = ab_puestos.IdPuesto');
			$datos['habilidades'] = $this->db->get_where('ab_puestos', array ('ab_puestos.IdUsuario' => $idu));
			//agrega el IdUsuario a la tabla puestos
			if($this->input->post('habilidad')){
				$insertar = array (
						'IdPuesto' => $this->input->post('puesto'),
						'Habilidad' => $this->input->post('habilidad')
					);
				$this->db->insert('pa_capacitacion_habilidades', $insertar);

				echo "<script>";
			echo "if(confirm('Habilidad Agregada, ¿Quieres Agregar Otra?')){";
			echo 	"location.href='".base_url()."index.php/admin/varios/habilidades_agregar/".$idu."'";
			echo 	"}else{";
			echo 		"location.href='".base_url()."index.php/admin/varios/habilidades/'";
			echo "}";
			echo "</script>";
			}else{
			$this->load->view('_estructura/header',$datos);
			$this->load->view('admin/_estructura/top',$datos);
			$this->load->view('admin/_estructura/usuario',$datos);
			$this->load->view('admin/varios/habilidades/agregar',$datos);
			$this->load->view('admin/_estructura/footer');
		}
	}

	//
	// Funcion para agregar puesto a los usuarios de cada area: $ida, $IdUsuario
	//
	function habilidades_eliminar($idh, $idu){
			//agrega el IdUsuario a la tabla puestos
			$borrar = array (
						'IdcapacitacionHabilidad' => $idh,

				);
				$this->db->delete('pa_capacitacion_habilidades', $borrar);
			echo "<script>";
			echo "if(confirm('Habilidad elimnada,Quieres eliminar otra?')){";
			echo 	"location.href='".base_url()."index.php/admin/varios/habilidades_agregar/".$idu."'";
			echo 	"}else{";
			echo 	"location.href='".base_url()."index.php/admin/varios/habilidades/'";
			echo "}";
			echo "</script>";

	}


	//
	// Funcion para agregar puesto a los usuarios de cada area: $ida, $IdUsuario
	//
	function habilidades_mpuesto($idp){
			$this->inicio_admin_model->set_sort( 20 );
			$datos['titulo'] = "Agregar Puesto";
			$datos['menu'] = $this->menu;

			$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
			$datos['barra'] = $this->barra;

			$this->db->join('ab_usuarios', 'ab_usuarios.IdUsuario = ab_puestos.IdUsuario');
			$datos['nombre']=$this->db->get_where('ab_puestos', array('ab_puestos.IdPuesto' => $idp));

			//agrega el IdUsuario a la tabla puestos
			if($this->input->post('puesto')){
				$idu=$this->input->post('usuario');
				$modifica = array(
					'Puesto'		=> $this->input->post('puesto'),
				);
				$this->db->where('ab_puestos.IdPuesto', $idp);
				$this->db->update('ab_puestos', $modifica);
				echo "<script>location.href='".base_url()."index.php/admin/varios/habilidades_agregar/".$idu."';</script>";
				//$puesto=$this->db->get_where('ab_puestos', array('IdUsuario' => $idu));
				//echo $puesto;
			}else{

			$this->load->view('_estructura/header',$datos);
			$this->load->view('admin/_estructura/top',$datos);
			$this->load->view('admin/_estructura/usuario',$datos);
			$this->load->view('admin/varios/habilidades/mpuesto',$datos);
			$this->load->view('admin/_estructura/footer');
		}
	}

}

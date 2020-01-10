<?php
/****************************************************************************************************
*
*	CONTROLLERS/procesos/infraestructura
*
*		Descripción:
*			Controlador de las acciones del encargado de INFRAESTRUCTURA
*
*		Fecha de Creación:
*			23/octubre/2013
*
*		Ultima actualización:
*			05/Noviembre/2013
*
*		Autor:
*			ISC Jesus Carlos Almeda Macias
*			iscalmeda@gmail.com
*			@chomo1011
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Infraestructura extends CI_Controller {

	/*
	 *reguistrar(): Registra todas la observaciones de cada una de las
	 * 				seccion que conforman la encuesta
	 */

	function registrar(){

		// variables necesarias para la página
		$datos['titulo'] = 'Reporte de Infraestructura';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$area=$this->session->userdata('id_area');


		$this->load->model('procesos/infraestructura_model');

		$condicion=array(
			'en_evaluacion.IdEncuesta'	=> 5,
			'en_evaluacion.Estado'		=> 1,
		);

		$condiciond=array(
			'ab_departamentos.IdArea'	=> $area,
		);

		$datos['periodo']=$this->db->get_where('en_evaluacion', $condicion);
		$datos['departamentos']=$this->db->get_where('ab_departamentos', $condiciond);

		// prepara e inserta los datos del formulario
		if($_POST){
			$query1 = array(
				'IdUsuario'		=>$this->session->userdata('id_usuario'),
				'IdArea'		=>$this->session->userdata('id_area'),
				'Departamento'	=>$this->input->post('Departamento'),
				'Periodo'		=>$this->input->post('Periodo'),
				'Concepto'		=>"Muro",
				'Respuesta'		=>$this->input->post('Muros'),
				'Observacion'	=>$this->input->post('Muro1'),
				'Recurso'		=>$this->input->post('Muro_r'),
				'Recurso'		=>$this->input->post('Muro_r'),
			);

			$query2 = array(
				'IdUsuario'		=>$this->session->userdata('id_usuario'),
				'IdArea'		=>$this->session->userdata('id_area'),
				'Departamento'	=>$this->input->post('Departamento'),
				'Periodo'		=>$this->input->post('Periodo'),
				'Concepto'		=>"Pisos",
				'Respuesta'		=>$this->input->post('Pisos'),
				'Observacion'	=>$this->input->post('Pisos1'),
				'Recurso'		=>$this->input->post('Pisos_r'),

			);

			$query3 = array(
				'IdUsuario'		=>$this->session->userdata('id_usuario'),
				'IdArea'		=>$this->session->userdata('id_area'),
				'Departamento'	=>$this->input->post('Departamento'),
				'Periodo'		=>$this->input->post('Periodo'),
				'Concepto'		=>"Puertas",
				'Respuesta'		=>$this->input->post('Puertas'),
				'Observacion'	=>$this->input->post('Puertas1'),
				'Recurso'		=>$this->input->post('Puertas_r'),
			);
			$query4 = array(
				'IdUsuario'		=>$this->session->userdata('id_usuario'),
				'IdArea'		=>$this->session->userdata('id_area'),
				'Departamento'	=>$this->input->post('Departamento'),
				'Periodo'		=>$this->input->post('Periodo'),
				'Concepto'		=>"Ventanas",
				'Respuesta'		=>$this->input->post('Ventanas'),
				'Observacion'	=>$this->input->post('Ventanas1'),
				'Recurso'		=>$this->input->post('Ventanas_r'),
			);
			$query5 = array(
				'IdUsuario'		=>$this->session->userdata('id_usuario'),
				'IdArea'		=>$this->session->userdata('id_area'),
				'Departamento'	=>$this->input->post('Departamento'),
				'Periodo'		=>$this->input->post('Periodo'),
				'Concepto'		=>"Muebles",
				'Respuesta'		=>$this->input->post('Muebles'),
				'Observacion'	=>$this->input->post('Muebles1'),
				'Recurso'		=>$this->input->post('Muebles_r'),
			);
			$query6 = array(
				'IdUsuario'		=>$this->session->userdata('id_usuario'),
				'IdArea'		=>$this->session->userdata('id_area'),
				'Departamento'	=>$this->input->post('Departamento'),
				'Periodo'		=>$this->input->post('Periodo'),
				'Concepto'		=>"Limpieza",
				'Respuesta'		=>$this->input->post('Limpieza'),
				'Observacion'	=>$this->input->post('Limpieza1'),
				'Recurso'		=>$this->input->post('Limpieza_r'),
			);
			$query7 = array(
				'IdUsuario'		=>$this->session->userdata('id_usuario'),
				'IdArea'		=>$this->session->userdata('id_area'),
				'Departamento'	=>$this->input->post('Departamento'),
				'Periodo'		=>$this->input->post('Periodo'),
				'Concepto'		=>"Orden",
				'Respuesta'		=>$this->input->post('Orden'),
				'Observacion'	=>$this->input->post('Orden1'),
				'Recurso'		=>$this->input->post('Orden_r'),
			);
			$query8 = array(
				'IdUsuario'		=>$this->session->userdata('id_usuario'),
				'IdArea'		=>$this->session->userdata('id_area'),
				'Departamento'	=>$this->input->post('Departamento'),
				'Periodo'		=>$this->input->post('Periodo'),
				'Concepto'		=>"Extintores",
				'Respuesta'		=>$this->input->post('Extintores'),
				'Observacion'	=>$this->input->post('Extintores1'),
				'Recurso'		=>$this->input->post('Extintores_r'),
			);
			$query9 = array(
				'IdUsuario'		=>$this->session->userdata('id_usuario'),
				'IdArea'		=>$this->session->userdata('id_area'),
				'Departamento'	=>$this->input->post('Departamento'),
				'Periodo'		=>$this->input->post('Periodo'),
				'Concepto'		=>"Rutas",
				'Respuesta'		=>$this->input->post('Rutas'),
				'Observacion'	=>$this->input->post('Rutas1'),
				'Recurso'		=>$this->input->post('Rutas_r'),
			);
			$query10 = array(
				'IdUsuario'		=>$this->session->userdata('id_usuario'),
				'IdArea'		=>$this->session->userdata('id_area'),
				'Departamento'	=>$this->input->post('Departamento'),
				'Periodo'		=>$this->input->post('Periodo'),
				'Concepto'		=>"Depositos",
				'Respuesta'		=>$this->input->post('Depositos'),
				'Observacion'	=>$this->input->post('Depositos1'),
				'Recurso'		=>$this->input->post('Depositos_r'),
			);
			$query11 = array(
				'IdUsuario'		=>$this->session->userdata('id_usuario'),
				'IdArea'		=>$this->session->userdata('id_area'),
				'Departamento'	=>$this->input->post('Departamento'),
				'Periodo'		=>$this->input->post('Periodo'),
				'Concepto'		=>"Control",
				'Respuesta'		=>$this->input->post('Control'),
				'Observacion'	=>$this->input->post('Control1'),
				'Recurso'		=>$this->input->post('Control_r'),
			);
			$query12 = array(
				'IdUsuario'		=>$this->session->userdata('id_usuario'),
				'IdArea'		=>$this->session->userdata('id_area'),
				'Departamento'	=>$this->input->post('Departamento'),
				'Periodo'		=>$this->input->post('Periodo'),
				'Concepto'		=>"Iluminacion",
				'Respuesta'		=>$this->input->post('Iluminacion'),
				'Observacion'	=>$this->input->post('Iluminacion1'),
				'Recurso'		=>$this->input->post('Iluminacion_r'),
			);
			$query13 = array(
				'IdUsuario'		=>$this->session->userdata('id_usuario'),
				'IdArea'		=>$this->session->userdata('id_area'),
				'Departamento'	=>$this->input->post('Departamento'),
				'Periodo'		=>$this->input->post('Periodo'),
				'Concepto'		=>"Temperatura",
				'Respuesta'		=>$this->input->post('Temperatura'),
				'Observacion'	=>$this->input->post('Temperatura1'),
				'Recurso'		=>$this->input->post('Temperatura_r'),
			);
			$query14 = array(
				'IdUsuario'		=>$this->session->userdata('id_usuario'),
				'IdArea'		=>$this->session->userdata('id_area'),
				'Departamento'	=>$this->input->post('Departamento'),
				'Periodo'		=>$this->input->post('Periodo'),
				'Concepto'		=>"Humedad",
				'Respuesta'		=>$this->input->post('Humedad'),
				'Observacion'	=>$this->input->post('Humedad1'),
				'Recurso'		=>$this->input->post('Humedad_r'),
			);
			$query15 = array(
				'IdUsuario'		=>$this->session->userdata('id_usuario'),
				'IdArea'		=>$this->session->userdata('id_area'),
				'Departamento'	=>$this->input->post('Departamento'),
				'Periodo'		=>$this->input->post('Periodo'),
				'Concepto'		=>"Ruido",
				'Respuesta'		=>$this->input->post('Ruido'),
				'Observacion'	=>$this->input->post('Ruido1'),
				'Recurso'		=>$this->input->post('Ruido_r'),
			);

			$query16 = array(
				'IdUsuario'		=>$this->session->userdata('id_usuario'),
				'IdArea'		=>$this->session->userdata('id_area'),
				'Departamento'	=>$this->input->post('Departamento'),
				'Periodo'		=>$this->input->post('Periodo'),
				'Concepto'		=>"Arco",
				'Respuesta'		=>$this->input->post('Arco'),
				'Observacion'	=>$this->input->post('Arco1'),
				'Recurso'		=>$this->input->post('Arco_r'),
			);

			$query17 = array (
				'IdUsuario'		=>$this->session->userdata('id_usuario'),
				'IdArea'		=>$this->session->userdata('id_area'),
				'Departamento'	=>$this->input->post('Departamento'),
				'Periodo'		=>$this->input->post('Periodo'),
				'Acciones'		=>$this->input->post('Acciones'),
			);
				$this->db->insert('reg_infra', $query1);
				$this->db->insert('reg_infra', $query2);
				$this->db->insert('reg_infra', $query3);
				$this->db->insert('reg_infra', $query4);
				$this->db->insert('reg_infra', $query5);
				$this->db->insert('reg_infra', $query6);
				$this->db->insert('reg_infra', $query7);
				$this->db->insert('reg_infra', $query8);
				$this->db->insert('reg_infra', $query9);
				$this->db->insert('reg_infra', $query10);
				$this->db->insert('reg_infra', $query11);
				$this->db->insert('reg_infra', $query12);
				$this->db->insert('reg_infra', $query13);
				$this->db->insert('reg_infra', $query14);
				$this->db->insert('reg_infra', $query15);
				$this->db->insert('reg_infra', $query16);
				$this->db->insert('reg_infra_acciones', $query17);
				$datos['mensaje_titulo'] = "Exito";
				$datos['mensaje'] = 'Se Agrego el reporte ';
				$datos['enlace'] = 'inicio';
				$this->load->view('mensajes/ok',$datos);
				redirect('procesos/infraestructura/reportes');
		}

		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/infraestructura/registrar', $datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}

	/*
	 *reportes(): genera los reportes por area dependiendo del periodo
	 */
	function reportes(){
		$datos['titulo'] = 'Reportes de Infraestructura';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$area=$this->session->userdata('id_area');

		$condiciond=array(
				'ab_departamentos.IdArea'	=> $area,
				);
		$datos['departamentos']=$this->db->get_where('ab_departamentos', $condiciond);
		// obtiene el periodo activo
			if($_POST){
				$departamento = $this->input->post('Departamento');
				/*if($departamento == 'General'){
					$condicion2=array(
						'reg_infra.Departamento' => ' ',
						'reg_infra.IdArea'		 => $area,
					);
				}else{*/
				$condicion2=array(
					'reg_infra.Departamento' => $this->input->post('Departamento'),
					'reg_infra.IdArea'		 => $area,
				);
				/*}*/
				$datos['departamento'] = $this->db->get_where('ab_departamentos', array('IdDepartamento' => $this->input->post('Departamento')));

				$datos['reportes']=$this->db->get_where('en_evaluacion', array('en_evaluacion.IdEncuesta' => 5,));
				$datos['consulta'] = $this->db->get_where('reg_infra', $condicion2);
			}
			$this->load->view('_estructura/header',$datos);
			$this->load->view('_estructura/top',$datos);
			$this->load->view('procesos/infraestructura/reportes', $datos);
			$this->load->view('_estructura/right');
			$this->load->view('_estructura/footer');
			//$datos['consulta'] = $this->db->join('reg_infra', 'reg_infra.IdPeriodo = ')

		// estructura de la página

	}

	/*
	 *reportes(): genera los reportes por area dependiendo del periodo
	 */
	function ver($id,$departamento){
		$datos['titulo'] = 'Reportes de Infraestructura: ';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$area=$this->session->userdata('id_area');
			// obtiene el periodo activo
			if($departamento == ''){
				$condicion= array('Periodo' => $id, 'IdArea' => $area, 'Departamento' => '');
			}else{
				$condicion= array('Periodo' => $id, 'IdArea' => $area, 'Departamento' => $departamento);
			}


			$datos['consulta']=$this->db->get_where('reg_infra', $condicion);
			$datos['area']	= $this->db->get_where('ab_areas', array('IdArea' => $area));
			$datos['departamento']= $this->db->get_where('ab_departamentos', array('IdDepartamento' => $departamento));
			$condicion2= array('Periodo' => $id, 'IdArea' => $area);
			$datos['periodo'] = $this->db->get_where('en_evaluacion', array('IdEvaluacion' => $id));
			$datos['consulta2']=$this->db->get_where('reg_infra_acciones', $condicion);
			//$datos['consulta'] = $this->db->join('reg_infra', 'reg_infra.IdPeriodo = ')

			$this->load->view('_estructura/header',$datos);
			$this->load->view('_estructura/top',$datos);
			$this->load->view('procesos/infraestructura/ver', $datos);
			$this->load->view('_estructura/right');
			$this->load->view('_estructura/footer');

		// estructura de la página

	}
}

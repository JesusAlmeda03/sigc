<?php 
/****************************************************************************************************
*
*	MODELS/itarh/Inicio_itarh_model.php
*
*		Descripción:  		  
*			Documentos del sistema 
*
*		Fecha de Creación:
*			08/Octubre/2011
*
*		Ultima actualización:
*			08/Octubre/2011
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
class Inicio_itarh_model extends CI_Model {
/** Atributos **/
	private $menu_observaciones;
	private $bg_inicio;
	private $bg_obs;
	private $sort_tabla;

/** Propiedades **/
	// get
	public function getObservaciones(){ return $this->menu_observaciones; }
	public function get_sort() { return $this->sort_tabla; }
	
	// set
	public function set_sort( $reg ) { $this->sort_tabla = $this->get_info_sort( $reg ); }	
	
/** Constructor **/			
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
/** Funciones **/	
	//
	// Obtiene todo el menu
	//
	public function get_menu( $id ) {
        $datos['titulo_sistema'] = "IT.ARH.01";
		
		$bg = 'style="background:url('.base_url().'includes/img/arrow.png) no-repeat top center;"';
		switch ( $id ) {
			case "inicio" :
				$this->bg_inicio = $bg;
				break;
			case "observaciones" :
				$this->bg_obs = $bg;
				break;
		}
		
		$this->observaciones();
		
		$menu  = '<ul class="sf-menu" style="position:relative">';
		$menu .= '<li><a href="'.base_url().'index.php/itarh/inicio" class="menu_item" '.$this->bg_inicio.'>INICIO</a></li>';
		$menu .= $this->menu_observaciones;
		$menu .= '</ul>';
		
		return $menu;
	}

	//
	// Observaciones
	//	
	public function observaciones () {
		$ruta = base_url().'index.php/itarh/observaciones/';
		$this->menu_observaciones = '
			<li><a href="#" class="menu_item" '.$this->bg_obs.'>OBSERVACIONES</a>
				<ul>
					<li><a href="'.$ruta.'altas">Altas</a></li>
					<li><a href="'.$ruta.'listado">Listado</a></li>
				</ul>
			</li>
		';
	}
	
	//
	// cambia_estado( $tipo, $id, $estado ): Cambia de estado los registros
	//
	function cambia_estado( $tipo, $id, $estado ) {
		// realiza los cambios segun el tipo
		switch( $tipo ) {
		// Documentos
			case 'documentos' :
				$actualiza = array(
					'Estado' => $estado
				);
				$this->db->where( 'IdDocumento', $id );
				$resp = $this->db->update( 'bc_documentos', $actualiza );
				break;
				
		// Secciones
			case 'secciones' :
				$actualiza = array(
					'Estado' => $estado
				);
				$this->db->where( 'IdSeccion', $id );
				$resp = $this->db->update( 'bc_secciones', $actualiza );
				break;
		
		// Usuarios
			case 'usuarios' :
				$actualiza = array(
					'Estado' => $estado
				);
				$this->db->where( 'IdUsuario', $id );
				$resp = $this->db->update( 'ab_usuarios', $actualiza );
				break;
		
		// Usuarios
			case 'usuarios_especiales' :
				$this->db->where( 'IdUsuario', $id );
				$resp = $this->db->delete( 'ab_usuarios_permisos');
				break;
				
		// Quejas
			case 'quejas' :
				$actualiza = array(
					'Estado' => $estado
				);
				$this->db->where( 'IdQueja', $id );
				$resp = $this->db->update( 'pa_quejas', $actualiza );
				if( $resp && $estado == 2 ) {
					$this->db->where( 'IdQueja', $id );
					$resp = $this->db->delete( 'pa_quejas_seguimiento' );
				}
				break;
		
		// No Conformidades
			case 'conformidades' :
				$actualiza = array(
					'Estado' => $estado
				);
				$this->db->where( 'IdConformidad', $id );
				$resp = $this->db->update( 'pa_conformidades', $actualiza );
				if( $resp && $estado == 3 ) {
					$this->db->where( 'IdConformidad', $id );
					$resp = $this->db->delete( 'pa_conformidades_acciones' );
					if( $resp ) {
						$this->db->where( 'IdConformidad', $id );
						$resp = $this->db->delete( 'pa_conformidades_diagrama' );
						if( $resp ) {
							$this->db->where( 'IdConformidad', $id );
							$resp = $this->db->delete( 'pa_conformidades_seguimiento' );
						}
					}
				}
				break;
				
		// Indicadores
			case 'indicadores' :
				$actualiza = array(
					'Estado' => $estado
				);
				$this->db->where( 'IdIndicador', $id );
				$resp = $this->db->update( 'pa_indicadores', $actualiza );
				break;
				
		// Indicadores
			case 'indicadores_medicion' :
				$this->db->where( 'IdIndicadorMedicion', $id );
				$resp = $this->db->delete( 'pa_indicadores_medicion' );
				break;
				
		// Minutas
			case 'minutas' :
				$actualiza = array(
					'Estado' => $estado
				);
				$this->db->where( 'IdMinuta', $id );
				$resp = $this->db->update( 'mn_minutas', $actualiza );
				break;

		// Noticias
			case 'noticias' :
				$actualiza = array(
					'Estado' => $estado
				);
				$this->db->where( 'IdNoticia', $id );
				$resp = $this->db->update( 'ef_noticias', $actualiza );
				break;
				
		// Solicitudes
			case 'solicitudes' :
				$actualiza = array(
					'Estado' => $estado
				);
				if( $estado == 5 ) {
					$actualiza['Observaciones'] = '';
				}
				
				$this->db->where( 'IdSolicitud', $id );
				$resp = $this->db->update( 'pa_solicitudes', $actualiza );
								
				if( $resp && $estado == 5 ) {
					$actualiza = array (
						'Aceptado' => '0'
					);
					$this->db->where( 'IdSolicitud', $id );
					$resp = $this->db->update( 'pa_solicitudes_distribucion', $actualiza );
				}
				break;
				
		// Evaluaciones
			case 'evaluaciones' :
				$actualiza = array(
					'Estado' => $estado
				);
				$this->db->where( 'IdEvaluacion', $id );
				$resp = $this->db->update( 'en_evaluacion', $actualiza );
				break;
		}
		
		return $resp;
	}

	//
	// get_info_sort( $reg ): Especificaciones para el sort de la tabla, estableciendo el número de registros a mostrar
	//
	function get_info_sort( $reg ) {
		$sort_tabla = '
			<script type="text/javascript" charset="utf-8">
                $(document).ready(function() {
                    var dontSort = [];
                    $("#tabla thead th").each( function () {
                        if ( $(this).hasClass( "no_sort" )) {
                            dontSort.push( { "bSortable": false } );
                        } else {
                            dontSort.push( null );
                        }
                    } );
                    $("#tabla").dataTable({
						"bJQueryUI": true,
						"sPaginationType": "full_numbers",
                        "aoColumns": dontSort,
                        "iDisplayLength": '.$reg.',
                        "aLengthMenu": [[-1, 10, 25, 50, 100], [ " - Todos los registros - ", "10 registros", "25 registros", "50 registros", "100 registros"]]
                    });
                } );
            </script>
		';
		
		return $sort_tabla;
	}
}
?>

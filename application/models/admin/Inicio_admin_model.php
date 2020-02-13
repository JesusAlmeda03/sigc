<?php 
/****************************************************************************************************
*
*	MODELS/admin/inicio_admin_model.php
*
*		Descripción:  		  
*			Documentos del sistema 
*
*		Fecha de Creación:
*			13/Febrero/2012
*
*		Ultima actualización:
*			11/Julio/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
class Inicio_admin_model extends CI_Model {
/** Atributos **/
	private $menu_doc;
	private $menu_usu;
	private $menu_var;
	private $menu_sol;
	private $menu_eva;
	private $menu_min;
	private $menu_aud;
	private $bg_in;
	private $bg_do;
	private $bg_us;
	private $bg_va;
	private $bg_so;
	private $bg_ev;
	private $bg_au;
	private $sort_tabla;	

/** Propiedades **/
	// get
	public function getDocumentos(){ return $this->menu_doc; }
	public function getUsuarios(){ return $this->menu_usu; }
	public function getVarios(){ return $this->menu_var; }
	public function getSolicitudes(){ return $this->menu_sol; }
	public function getEvaluaciones(){ return $this->menu_eva; }
	public function getMinutas(){ return $this->menu_min; }
	public function getAuditorias(){ return $this->menu_aud; }
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
        $datos['titulo_sistema'] = "Panel de Administrador";
		
		$bg = 'style="background:url('.base_url().'includes/img/arrow.png) no-repeat top center;"';
		switch ( $id ) {
			/*case "inicio" :
				$this->bg_in = $bg;
				break;*/
			case "documentos" :
				$this->bg_do = $bg;
				break;
			case "usuarios" :
				$this->bg_us = $bg;
				break;
			case "varios" :
				$this->bg_va = $bg;
				break;
			case "solicitudes" :
				$this->bg_so = $bg;
				break;
			case "evaluaciones" :
				$this->bg_en = $bg;
				break;
			case "minutas" :
				$this->bg_en = $bg;
				break;
			case "auditorias" :
				$this->bg_au = $bg;
				break;
		}
		
		$this->documentos();
		$this->usuarios();
		$this->varios();
		$this->solicitudes();
		$this->evaluaciones();
		$this->minutas();
		$this->auditorias();
		
		$menu  = '<ul class="sf-menu" style="position:relative">';
		//$menu .= '<li><a href="'.base_url().'index.php/admin/inicio" class="menu_item" '.$this->bg_in.'>INICIO</a></li>';
		// Administrador invitado
		if( $this->session->userdata( 'ADI' ) ) {
			$menu .= $this->menu_doc;
			$menu .= $this->menu_usu;
		}
		else {
			$menu .= $this->menu_doc;
			$menu .= $this->menu_usu;
			$menu .= $this->menu_var;
			$menu .= $this->menu_sol;
			$menu .= $this->menu_eva;
			$menu .= $this->menu_min;
			$menu .= $this->menu_aud;
		}
		$menu .= '</ul>';
		
		return $menu;
	}

	//
	// Documentos
	//	
	public function documentos () {
		$ruta = base_url().'index.php/admin/documentos/';
		$consulta = $this->db->get_where('bc_secciones',array('Comun' => '0', 'Estado' => '1'));
		if ( $consulta->num_rows() > 0 ) {
			$docs = '';
			foreach( $consulta->result() as $row ) :
				$docs .= '<li><a href="'.$ruta.'listado/'.$row->IdSeccion.'">'.$row->Seccion.'</a></li>';
			endforeach;
		}
		// Administrador invitado
		if( $this->session->userdata( 'ADI' ) ) {
			$this->menu_doc = '
				<li><a href="#" class="menu_item" '.$this->bg_do.'>DOCUMENTOS</a>
					<ul class="sub">
						<li><a href="'.$ruta.'maestra">Lista Maestra de Documentos</a></li>
						<li><a href="'.$ruta.'maestra_registros">Lista Maestra de Registros</a></li>
						<li><a href="'.$ruta.'comun">Uso Com&uacute;n</a></li>
						<li><a href="#"><table><tr><td width="190">Documentos</td><td style="padding-left:3px"><img src="'.base_url().'includes/img/arrow_right.png"></td></tr></table></a>
							<ul>'.$docs.'</ul>
						</li>
					</ul>
				</li>
			';
		}
		else {
			$this->menu_doc = '
				<li><a href="#" class="menu_item" '.$this->bg_do.'>DOCUMENTOS</a>
					<ul class="sub">
						<li><a href="'.$ruta.'anadir" class="first">A&ntilde;adir Documento</a></li>
						<li><a href="'.$ruta.'buscar">Buscar Documento</a></li>
						<li><a href="'.$ruta.'nueva">Documentos Inactivos</a></li>
						<li><a href="'.$ruta.'maestra">Lista Maestra de Documentos</a></li>
						<li><a href="'.$ruta.'maestra_registros">Lista Maestra de Registros</a></li>
						<li><a href="'.$ruta.'comun">Uso Com&uacute;n</a></li>
						<li><a href="#"><table><tr><td width="190">Documentos</td><td style="padding-left:3px"><img src="'.base_url().'includes/img/arrow_right.png"></td></tr></table></a>
							<ul>'.$docs.'</ul>
						</li>
						<li><a href="'.$ruta.'inactivos">Documentos Inactivos</a></li>
						<li><a href="'.$ruta.'anadir_seccion">A&ntilde;adir Secci&oacute;n</a></li>
						<li><a href="'.$ruta.'secciones">Lista de Secciones</a></li>
						<li><a href="#"><table><tr><td width="190">Resumen de Auditorias</td><td style="padding-left:3px"><img src="'.base_url().'includes/img/arrow_right.png"></td></tr></table></a>
							<ul>
								<li><a href="'.$ruta.'resumen_listado/">Ver Archivo</a></li>
								<li><a href="'.$ruta.'resumen_agregar/">Agregar Nuevo</a></li>
							</ul>
						</li>
					</ul>
				</li>
			';
		}
	}
	
	//
	// Usuarios
	//	
	public function usuarios() {
		$ruta = base_url().'index.php/admin/usuarios/';
		// Administrador invitado
		if( $this->session->userdata( 'ADI' ) ) {
			$this->menu_usu = '
				<li><a href="#" class="menu_item" '.$this->bg_us.'>USUARIOS</a>
					<ul class="sub">
						<li><a href="'.$ruta.'listado">Listado de Usuarios</a></li>
						<li><a href="'.$ruta.'sesion">Iniciar Sesi&oacute;n por &Aacute;rea</a></li>
					</ul>
				</li>
			';
		}
		else {
			$this->menu_usu = '
				<li><a href="#" class="menu_item" '.$this->bg_us.'>USUARIOS</a>
					<ul class="sub">
						<li><a href="'.$ruta.'anadir" class="first">A&ntilde;adir Usuario</a></li>
						<li><a href="'.$ruta.'buscar">Buscar Usuario</a></li>
						<li><a href="'.$ruta.'listado">Listado de Usuarios</a></li>
						<li><a href="'.$ruta.'especiales/todos">Usuarios Especiales</a></li>
						<li><a href="'.$ruta.'anadir_especial">Otorgar Permisos a Usuarios</a></li>
						<li><a href="'.$ruta.'jerarquias">Asignar / Revisar Jerarquias</a></li>
						<li><a href="'.$ruta.'sesion">Iniciar Sesi&oacute;n por &Aacute;rea</a></li>
					</ul>
				</li>
			';
		}
	}
	
	//
	// Varios
	//	
	public function varios() {
		$ide = '';
		$ids = 1; // SIGC
		$ruta = base_url().'index.php/admin/varios/';
		
		// Identidad
		$sisetmas = $this->db->get_where('cd_sistemas',array('Estado' => '1','Abreviatura <>' => 'UJED'));
		if ( $sisetmas->num_rows() > 0 ) {
			foreach( $sisetmas->result() as $row_sis ) :
				$ide .= '<li><a href="#"><table><tr><td width="180">Identidad '.$row_sis->Abreviatura.'</td><td style="padding-left:3px"><img src="'.base_url().'includes/img/arrow_right.png"></td></tr></table></a><ul class="sub">';
				$identidad = $this->db->where('IdSistema = ',$ids)->or_where('IdSistema = ',$row_sis->IdSistema)->get('cd_identidad');
				if ( $identidad->num_rows() > 0 ) {
					foreach( $identidad->result() as $row_ide ) :
						$ide .= '<li><a href="'.$ruta.'identidad/'.$row_sis->IdSistema.'/'.$row_ide->IdIdentidad.'">'.$row_ide->Titulo.'</a></li>';
					endforeach;
				}
				$ide .= '</ul></li>';
			endforeach;
		}
		$this->db->order_by('en_evaluacion.IdEvaluacion', 'DESC');
		$this->db->join("en_encuestas", "en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta");
		$this->db->limit(1);
		$solicitudes = $this->db->get_where('en_evaluacion',array('en_evaluacion.IdEncuesta' => '5'));
		if($solicitudes->num_rows() > 0 ){
			foreach($solicitudes -> result() as $row){
				
			}
		}

		$consulta = $this->db->from('ef_contacto')->where(array('Estado' => '1'))->count_all_results();
		$ruta2	= base_url().'index.php/procesos/capacitacion/';
		
		$this->menu_var = '
			<li><a href="#" class="menu_item" '.$this->bg_va.'>VARIOS</a>
				<ul class="sub">
					<li><a href="'.$ruta.'quejas" class="first">Quejas</a></li>
					<li><a href="'.$ruta.'conformidades">No Conformidades</a></li>
					<li><a href="'.$ruta.'indicadores">Indicadores</a></li>
					<li><a href="'.$ruta.'habilidades">Habilidades y Aptitudes</a></li>
					<li><a href="'.$ruta.'minutas">Minutas</a></li>
					<li><a href="'.$ruta.'noticias">Noticias</a></li>
					<li><a href="'.$ruta.'contacto">Contacto</a></li>
					<li><a href="'.$ruta.'calendario">Calendario</a></li>
					<li><a href="#"><table><tr><td width="180">Capacitación</td><td style="padding-left:3px"><img src="'.base_url().'includes/img/arrow_right.png"></td></tr></table></a>
						<ul class="sub">
							<li><a href="'.$ruta.'cap_evaluacion">Iniciar Evaluación DNC</a></li>
							<li><a href="'.$ruta.'cap_propuestos">Cursos Propuestos por las Áreas</a></li>
							<li><a href="'.$ruta.'cap_propuestos2">Crear Curso</a></li>
							<li><a href="'.$ruta2.'calendario">Calendario Anual</a></li>
						</ul>
					</li>
					<li><a href="#"><table><tr><td width="180">Infraestructura</td><td style="padding-left:3px"><img src="'.base_url().'includes/img/arrow_right.png"></td></tr></table></a>
						<ul class="sub">
							<li><a href="'.$ruta.'solicitudes/'.$row->IdEvaluacion.'">Revisar Solicitudes</a></li>
							
						</ul>
					</li>
		';
		$this->menu_var .= '
					'.$ide.'
				</ul>
			</li>
		';
	}
	
	//
	// Solicitudes
	//	
	public function solicitudes() {
		$consulta = $this->db->from('pa_solicitudes')->where(array('Estado' => '2'))->count_all_results();
		
		$ruta = base_url().'index.php/admin/solicitudes/';
		$this->menu_sol = '
			<li><a href="#" class="menu_item" '.$this->bg_so.'>SOLICITUDES</a>
				<ul class="sub">
		';
		if( $consulta > 0 )
			$this->menu_sol .= '<li><a href="'.$ruta.'autorizar/todos/todos" class="first">Autorizar Solicitudes ('.$consulta.')</a></li>';
		$this->menu_sol .= '					
					<li><a href="'.$ruta.'listado">Listado de Solicitudes</a></li>
					<li><a href="'.$ruta.'alta">Alta de Documento</a></li>
					<li><a href="'.$ruta.'documento/baja">Baja de Documento</a></li>
					<li><a href="'.$ruta.'documento/modificacion">Modificaci&oacute;n de Documento</a></li>
				</ul>         
			</li>
		';
	}
	public function get_calendario(){
		$consulta = $this->db->get('ef_eventos');
		return $consulta;
	}

	public function calendario_agregar($fecha, $evento){
		$condicion = array(
			'Fecha' => $fecha, 
			'Evento' => $evento
			);
		$this->db->insert('ef_eventos', $condicion);
	}

	public function dCal($id){
		$condicion = array(
			'IdEvento' => $id
			);
		
		$this->db->delete('ef_eventos', $condicion);
	}
	//
	// Evaluaciones
	//	
	public function evaluaciones() {
		$ruta = base_url().'index.php/admin/evaluaciones/';
		$this->menu_eva = '
			<li><a href="#" class="menu_item" '.$this->bg_ev.'>EVALUACIONES</a>
				<ul class="sub">
					<li><a href="'.$ruta.'iniciar" class="first">Iniciar Evaluaci&oacute;n</a></li>
					<li><a href="'.$ruta.'listado">Listado de Evaluaciones</a></li>
					<li><a href="'.$ruta.'avances">Avances</a></li>
				</ul>
			</li>
		';
	}

	//
	// Minutas
	//	
	public function minutas() {
		$ruta = base_url().'index.php/admin/minutas/';
		$this->menu_min = '
			<li><a href="#" class="menu_item" '.$this->bg_ev.'>MINUTAS</a>
				<ul class="sub">					
                    <li><a href="'.$ruta.'minutas_comite" class="first">Minutas del Comit&eacute; de Calidad</a></li>
				</ul>
			</li>
		';
	}

	//
	// Auditorias
	//	
	public function auditorias() {
		$ruta = base_url().'index.php/admin/auditorias/';
		$this->menu_aud = '
			<li><a href="#" class="menu_item" '.$this->bg_au.'>AUDITOR&Iacute;AS</a>
				<ul class="sub">
					<li><a href="'.$ruta.'generar" class="first">Generar Programa de Auditor&iacute;a</a></li>
					<li><a href="'.$ruta.'programa_especifico">Programas Espec&iacute;ficos de Auditor&iacute;as</a></li>
					<li><a href="'.$ruta.'revisar_avances">Revisar Avance</a></li>
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
				
		// Usuarios Jerarquias
			case 'usuarios_jerarquias' :
				$this->db->where( 'IdUsuarioEvaluado', $id );
				$resp = $this->db->delete( 'ab_usuarios_mandos' );
				break;
				
		// Auditorías
			case 'auditorias' :
				$actualiza = array(
					'Estado' => $estado
				);
				$this->db->where( 'IdAuditoria', $id );
				$resp = $this->db->update( 'au_auditorias', $actualiza );
				break;
				
		// Usuarios de los Equipos de la Auditoría
			case 'usuario_equipo' :
				$ides = explode("_", $id);
				$this->db->where( array( 
						'IdEquipo'  => $ides[0],
						'IdUsuario' => $ides[1],
					) 
				);
				$resp = $this->db->delete( 'au_equipos_usuarios' );
				break;
				
		// Equipos de la Auditoría
			case 'equipo' :
				$this->db->where( 'IdEquipo', $id );
				$resp = $this->db->delete( 'au_equipos' );
				break;
			
		// Procesos de una Auditoría
			case 'proceso_auditoria' :
				$ides = explode("_", $id);
				$this->db->where( array( 
						'IdAuditoria'  	=> $ides[0],
						'IdProceso' 	=> $ides[1],
					) 
				);
				$resp = $this->db->delete( 'au_auditorias_procesos' );
				break;
			
		// Procesos asignados a un Equipo
			case 'proceso_equipo' :
				$ides = explode("_", $id);
				$this->db->where( array( 
						'IdEquipo' 	=> $ides[0],
						'IdProceso'	=> $ides[1],
					) 
				);
				$resp = $this->db->delete( 'au_equipos_procesos' );
				break;
				
			default :
				$resp = false;
				break;
				
		// Evaluaciones de DNC
			case 'evaluacion_dnc' :
				$actualiza = array(
					'Estado' => $estado
				);
				
				$this->db->where( 'IdCapacitacionEvaluacion', $id );
				$resp = $this->db->update( 'pa_capacitacion_evaluacion', $actualiza );
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

	function jefesc(){
		$condicion  = array(
				'ab_usuarios.Estado' => 1
			);
		$this->db->join('ab_usuarios_jefes', 'ab_usuarios.IdUsuario = ab_usuarios_jefes.IdUsuario');
		$consulta = $this->db->get_where('ab_usuarios', $condicion);
		return $consulta;
	}
	
	
}
?>

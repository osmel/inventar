<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct(){ 
		parent::__construct();
		$this->load->model('model_pedido', 'modelo_pedido');
		$this->load->model('modelo', 'modelo'); 
		
		$this->load->model('model_inicio', 'modelo_inicio');
		
		$this->load->model('model_dashboard', 'modelo_dashboard');
		$this->load->model('catalogo', 'catalogo');  
		$this->load->library(array('email')); 
        $this->load->library('Jquery_pagination');//-->la estrella del equipo		
	}


	public function index(){
		if ( $this->session->userdata( 'session' ) !== TRUE ){
			$this->login();
		} else {
			$this->dashboard();
		}
	}


	public function login(){
		$this->load->view( 'login' );
	}


	function validar_login(){
		
		$this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules( 'contrasena', 'Contraseña', 'required|trim|min_length[8]|xss_clean');


		if ( $this->form_validation->run() == FALSE ){
				echo validation_errors('<span class="error">','</span>');
			} else {
				$data['email']		=	$this->input->post('email');
				$data['contrasena']		=	$this->input->post('contrasena');
				$data 				= 	$this->security->xss_clean($data);  

				$login_check = $this->modelo->check_login($data);
				
				if ( $login_check != FALSE ){

					$usuario_historico = $this->modelo->anadir_historico_acceso($login_check[0]);

					$this->session->set_userdata('session', TRUE);
					$this->session->set_userdata('email', $data['email']);
					
					if (is_array($login_check))
						foreach ($login_check as $login_element) {
							$this->session->set_userdata('id', $login_element->id);
							$this->session->set_userdata('id_perfil', $login_element->id_perfil);
							$this->session->set_userdata('perfil', $login_element->perfil);
							$this->session->set_userdata('operacion', $login_element->operacion);
							$this->session->set_userdata('sala', $login_element->sala);
							$this->session->set_userdata('coleccion_id_operaciones', $login_element->coleccion_id_operaciones);
							
							$this->session->set_userdata('nombre_completo', $login_element->nombre.' '.$login_element->apellidos);
						}
					echo TRUE;
				} else {
					echo '<span class="error">¡Ups! tus datos no son correctos, verificalos e intenta nuevamente por favor.</span>';
				}
			}
	}	


	//recuperar constraseña
	function session(){
		if($this->session->userdata('session') === TRUE ){
			$data['id']=$this->session->userdata('id');
			$data['id_perfil']=$this->session->userdata('id_perfil');
			$data['perfil']=$this->session->userdata('perfil');
			$data['coleccion_id_operaciones']=$this->session->userdata('coleccion_id_operaciones');
			$data['nombre_completo']=$this->session->userdata('nombre_completo');
			$data['sala']=$this->session->userdata('sala');
			$data['exito']=true;
	    }	else {
	    	$data['exito']=false;
	    }	
		echo json_encode($data);

	}

	//recuperar constraseña
	function forgot(){
	    //$this->load->view('forgot');
	    $this->load->view('recuperar_password');
	}
	
	
    function validar_recuperar_password(){
		$this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email|xss_clean');

		if ( $this->form_validation->run() == FALSE ){
			echo validation_errors('<span class="error">','</span>');
		} else {
				$data['email']		=	$this->input->post('email');
				$correo_enviar      =   $data['email'];
	            $data 				= 	$this->security->xss_clean($data);  
	    		$usuario_check 		=   $this->modelo->recuperar_contrasena($data);

		        if ( $usuario_check != FALSE ){
						$data= $usuario_check[0] ;  
						$desde = 'contacto@estrategasdigitales.com';
						$this->email->from($desde,'Sistema de administración Estrategas Digitales');
						$this->email->to($correo_enviar);
						$this->email->subject('Recuperación de contraseña del Sistema de administración Estrategas Digitales');
						$this->email->message($this->load->view('correo/envio_contrasena', $data, true));
						if ($this->email->send()) {

				  			echo TRUE;
						} else 
				  			echo false;	
	            } else {
	            	echo '<span class="error">¡Ups! tus datos no son correctos, verificalos e intenta nuevamente por favor.</span>';
	            }
		}
	}		

	//lista de todos los especialistas (colaboradores)
	function listado_usuarios(){
    if($this->session->userdata('session') === TRUE ){
          $id_perfil=$this->session->userdata('id_perfil');

          $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
          if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                $coleccion_id_operaciones = array();
           }   



          switch ($id_perfil) {    
            case 1:
                  ob_start();
                  $this->paginacion_ajax_usuario(0);
                  $initial_content = ob_get_contents();
                  ob_end_clean();    
                  $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
                  $this->load->view( 'paginacion/paginacion',$data);        
                    
              break;
            case 2:
            case 3:
                 if  (in_array(5, $coleccion_id_operaciones))  { 
                     ob_start();
                          $this->paginacion_ajax_usuario(0);
                          $initial_content = ob_get_contents();
                          ob_end_clean();    
                          $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
                          $this->load->view( 'paginacion/paginacion',$data);        
                 }   
              break;


            default:  
              redirect('');
              break;
          }
        }
        else{ 
          redirect('index');
        }
	}


	public function paginacion_ajax_usuario($offset = 0)  {
    	
    	//print $offset;
        //hacemos la configuración de la librería jquery_pagination
        $config['base_url'] = base_url('main/paginacion_ajax_usuario/');  //controlador/funcion

        $config['div'] = '#paginacion';//asignamos un id al contendor general
        $config['anchor_class'] = 'page_link';//asignamos una clase a los links para maquetar
	    $config['show_count'] = false;//en true queremos ver Viendo 1 a 10 de 52
        $config['per_page'] = 20;//-->número de provincias por página
        
        $config['num_links'] = 4;//-->número de links visibles
        
 

            $config['full_tag_open']       = '<ul class="pagination">';  
            $config['full_tag_close']      = '</ul>';
            $config['first_tag_open']      = '<li >'; 
            $config['first_tag_close']     = '</li>';
            $config['first_link']          = 'Primero'; 
            $config['last_tag_open']       = '<li >'; 
            $config['last_tag_close']      = '</li>';
            $config['last_link']           = 'Último';   
            $config['next_tag_open']       = '<li >'; 
            $config['next_tag_close']      = '</li>';
            $config['next_link']           = '&raquo;';  
            $config['prev_tag_open']       = '<li >'; 
            $config['prev_tag_close']      = '</li>';
            $config['prev_link']           = '&laquo;';   
            $config['num_tag_open']        = '<li>';
            $config['num_tag_close']       = '</li>';
            $config['cur_tag_open']        = '<li class="active"><a href="#">';
            $config['cur_tag_close']       = '</a></li>';   

        $config['total_rows'] = $this->modelo->total_usuarios($this->session->userdata('id')); 

        //inicializamos la librería
        $this->jquery_pagination->initialize($config); 

		$data['usuarios']	= $this->modelo->coger_usuarios($config['per_page'], $offset, $this->session->userdata('id') );
		$html = $this->load->view( 'usuarios', $data , true);


        $html = $html.
      	'<div class="container">
		 	<div class="col-xs-12">
		        <div id="paginacion">'.
		        	$this->jquery_pagination->create_links()
		        .'</div>
		    </div>
		</div>';
        echo $html;
 
    }		

   // Creación de especialista o Administrador (Nuevo Colaborador)
	function nuevo_usuario(){
    if($this->session->userdata('session') === TRUE ){
          $id_perfil=$this->session->userdata('id_perfil');

          $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
          if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                $coleccion_id_operaciones = array();
           }   

            	  $data['clientes']   = $this->modelo->coger_catalogo_clientes(2);
                  $data['perfiles']   = $this->modelo->coger_catalogo_perfiles();
                  $data['operaciones'] = $this->modelo->listado_operaciones();          

          switch ($id_perfil) {    
            case 1:
                  $this->load->view( 'usuarios/nuevo_usuario', $data );   
                    
              break;
            case 2:
            case 3:
                 if  (in_array(5, $coleccion_id_operaciones))  { 
                    $this->load->view( 'usuarios/nuevo_usuario', $data );   
                 }   
              break;


            default:  
              redirect('');
              break;
          }
        }
        else{ 
          redirect('index');
        }    

	}

	function validar_nuevo_usuario(){
		if ($this->session->userdata('session') !== TRUE) {
			redirect('');
		} else {

			

			$this->form_validation->set_rules( 'nombre', 'Nombre', 'trim|required|callback_nombre_valido|min_length[3]|max_lenght[180]|xss_clean');
			$this->form_validation->set_rules( 'apellidos', 'Apellido(s)', 'trim|required|callback_nombre_valido|min_length[3]|max_lenght[180]|xss_clean');
			$this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules( 'telefono', 'Teléfono', 'trim|numeric|callback_valid_phone|xss_clean');
			$this->form_validation->set_rules('id_perfil', 'Rol de usuario', 'required|callback_valid_option|xss_clean');
			$this->form_validation->set_rules('id_cliente', 'Cliente Asociado', 'required|callback_valid_option|xss_clean');
			$this->form_validation->set_rules( 'pass_1', 'Contraseña', 'required|trim|min_length[8]|xss_clean');
			$this->form_validation->set_rules( 'pass_2', 'Confirmación de contraseña', 'required|trim|min_length[8]|xss_clean');

			//si el usuario no es un administrador entonces q sea obligatorio asociarlo a operaciones 
      //Esto YA NO HACE FALTA
			if ($this->input->post('id_perfil')!=1) {
				//$this->form_validation->set_rules('coleccion_id_operaciones','Operaciones','required|xss_clean');
				
			}	

			if ($this->form_validation->run() === TRUE){
				if ($this->input->post( 'pass_1' ) === $this->input->post( 'pass_2' ) ){
					$data['email']		=	$this->input->post('email');
					$data['contrasena']		=	$this->input->post('pass_1');
					$data 				= 	$this->security->xss_clean($data);  
					$login_check = $this->modelo->check_correo_existente($data);

					if ( $login_check != FALSE ){		
						$usuario['nombre']   			= $this->input->post( 'nombre' );
						$usuario['apellidos']   		= $this->input->post( 'apellidos' );
						$usuario['email']   			= $this->input->post( 'email' );
						$usuario['contrasena']				= $this->input->post( 'pass_1' );
						$usuario['telefono']   		= $this->input->post( 'telefono' );
						$usuario['id_perfil']   		= $this->input->post( 'id_perfil' );
						$usuario['id_cliente']   		= $this->input->post( 'id_cliente' );
						$usuario['coleccion_id_operaciones']	=	json_encode($this->input->post('coleccion_id_operaciones'));						
						

						$usuario 						= $this->security->xss_clean( $usuario );
						$guardar 						= $this->modelo->anadir_usuario( $usuario );

						if ( $guardar !== FALSE ){

									/*
									$dato['email']   			    = $usuario['email'];   			
									$dato['contrasena']				= $usuario['contrasena'];				


									$desde = 'contacto@estrategasdigitales.com';
									$esp_nuevo = $usuario['email'];
									$this->email->from($desde, 'Sistema de administración control de inventario');
									$this->email->to( $esp_nuevo );
									$this->email->subject('Has sido dado de alta en Sistema de administración control de inventario');
									$this->email->message( $this->load->view('correos/alta_usuario', $dato, TRUE ) );

										 */
									//if ($this->email->send()) {	
									if (true) {
										echo TRUE;
									} else {
										echo '<span class="error"><b>E01</b> - El nuevo usuario no pudo ser agregado</span>';
									}	

						} else {
							echo '<span class="error"><b>E01</b> - El nuevo usuario no pudo ser agregado</span>';
						}
					} else {
						echo '<span class="error">El <b>Correo electrónico</b> ya se encuentra asignado a una cuenta.</span>';
					}
				} else { //fin de coincidencia de contraseña if ( $login_check != FALSE ){	
					echo '<span class="error">No coinciden la Contraseña </b> y su <b>Confirmación</b> </span>';
				}
			} else {	 //fin de la validacion del formulario		
				echo validation_errors('<span class="error">','</span>');
			}
		} //fin del if de la session
	}



	//edicion del especialista o el perfil del especialista o administrador activo
	function actualizar_perfil( $uid = '' ){

    $id=$this->session->userdata('id');

		if ($uid=='') {
			$uid= $id;
		}
      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   


		$id_perfil=$this->session->userdata('id_perfil');
		
    //Administrador con permiso a todo ($id_perfil==1)
    //usuario solo viendo su PERFIL  OR (($id_perfil!=1) and ($id==$uid) )
    //Con permisos de usuarios OR (in_array(5, $coleccion_id_operaciones)) 
		if	( ($id_perfil==1) OR (($id_perfil!=1) and ($id==$uid) ) OR (in_array(5, $coleccion_id_operaciones)) ) {
			$data['perfiles']		= $this->modelo->coger_catalogo_perfiles();
			$data['clientes']   = $this->modelo->coger_catalogo_clientes(2);
			$data['usuario'] = $this->modelo->coger_catalogo_usuario( $uid );

			
			$data['operaciones'] = $this->modelo->listado_operaciones();



	        $data['id']  = $uid;
			if ( $data['usuario'] !== FALSE ){
					$this->load->view('usuarios/editar_usuario',$data);
			} else {
						redirect('');
			}
		} else
		{
			 redirect('');
		}	
	}
	
	function validacion_edicion_usuario(){
		
		if ( $this->session->userdata('session') !== TRUE ) {
			redirect('');
		} else {
			
			$this->form_validation->set_rules( 'nombre', 'Nombre', 'trim|required|callback_nombre_valido|min_length[3]|max_lenght[180]|xss_clean');
			$this->form_validation->set_rules( 'apellidos', 'Apellido(s)', 'trim|required|callback_nombre_valido|min_length[3]|max_lenght[180]|xss_clean');
			$this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules( 'telefono', 'Teléfono', 'trim|numeric|callback_valid_phone|xss_clean');
			$this->form_validation->set_rules('id_perfil', 'Rol de usuario', 'required|callback_valid_option|xss_clean');
			$this->form_validation->set_rules('id_cliente', 'Cliente Asociado', 'required|callback_valid_option|xss_clean');
			$this->form_validation->set_rules( 'pass_1', 'Contraseña', 'required|trim|min_length[8]|xss_clean');
			$this->form_validation->set_rules( 'pass_2', 'Confirmación de contraseña', 'required|trim|min_length[8]|xss_clean');

      //si el usuario no es un administrador entonces q sea obligatorio asociarlo a operaciones 
      //Esto YA NO HACE FALTA
      if ($this->input->post('id_perfil')!=1) {
        //$this->form_validation->set_rules('coleccion_id_operaciones','Operaciones','required|xss_clean');
        
      } 


			if ( $this->form_validation->run() === TRUE ){
				if ($this->input->post( 'pass_1' ) === $this->input->post( 'pass_2' ) ){
					$uid 				=   $this->input->post( 'id_p' ); 
					$data['id']							= $uid;
					$data['email']		=	$this->input->post('email');
					$data 				= 	$this->security->xss_clean($data);  
					$login_check = $this->modelo->check_usuario_existente($data);
					if ( $login_check === TRUE ){
						$usuario['nombre']   					= $this->input->post( 'nombre' );
						$usuario['apellidos']   				= $this->input->post( 'apellidos' );
						$usuario['email']   					= $this->input->post( 'email' );
						$usuario['contrasena']						= $this->input->post( 'pass_1' );
						$usuario['telefono']   				= $this->input->post( 'telefono' );
						$usuario['id_perfil']   				= $this->input->post( 'id_perfil' );
						$usuario['id_cliente']   				= $this->input->post( 'id_cliente' );

						$usuario['coleccion_id_operaciones']	=	json_encode($this->input->post('coleccion_id_operaciones'));						
						

						
						$usuario['id']							= $uid;
						$usuario 								= $this->security->xss_clean( $usuario );
						$guardar 									= $this->modelo->edicion_usuario( $usuario );
						if ( $guardar !== FALSE ){
							echo TRUE;
						} else {
							echo '<span class="error"><b>E02</b> - La información del usuario no puedo ser actualizada no hubo cambios</span>';
						}
					} else {
						echo '<span class="error">El <b>Correo electrónico</b> ya se encuentra asignado a una cuenta.</span>';
					}
				} else {
					echo '<span class="error">La <b>Contraseña</b> y la <b>Confirmación</b> no coinciden, verificalas.</span>';
				}
			} else {			
				echo validation_errors('<span class="error">','</span>');
			}
		}
	}	
	

	function eliminar_usuario($uid = '', $nombrecompleto=''){

    if($this->session->userdata('session') === TRUE ){
          $id_perfil=$this->session->userdata('id_perfil');

          $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
          if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                $coleccion_id_operaciones = array();
           }   



          switch ($id_perfil) {    
            case 1:
                      if ($uid=='') {
                          $uid= $this->session->userdata('id');
                      }   
                      $data['nombrecompleto']   = base64_decode($nombrecompleto);
                      $data['uid']        = $uid;
                      $this->load->view( 'usuarios/eliminar_usuario', $data );                
              break;
            case 2:
            case 3:
                 if  (in_array(5, $coleccion_id_operaciones))  { 
                      if ($uid=='') {
                          $uid= $this->session->userdata('id');
                      }   
                      $data['nombrecompleto']   = $nombrecompleto;
                      $data['uid']        = $uid;

                      $this->load->view( 'usuarios/eliminar_usuario', $data );

                 }   
              break;


            default:  
              redirect('');
              break;
          }
        }
        else{ 
          redirect('');
        }
		
	}


	function validar_eliminar_usuario(){
		if (!empty($_POST['uid_retorno'])){ 
			$uid = $_POST['uid_retorno'];
		}
		$eliminado = $this->modelo->borrar_usuario(  $uid );
		if ( $eliminado !== FALSE ){
			echo TRUE;
		} else {
			echo '<span class="error">No se ha podido eliminar al usuario</span>';
		}
	}

	/////////////hasta aqui toda la gestion de colaboradores////////////	

	/////////////presentacion, filtro y paginador////////////	
	function dashboard(){ 
    if($this->session->userdata('session') === TRUE ){
          $id_perfil=$this->session->userdata('id_perfil');

          $data['nodefinido_todavia']        = '';
          switch ($id_perfil) {    
            case 1:
            case 2:
                $this->load->view( 'principal/dashboard',$data );
              break;

            case 3:
                $data['colores'] =  $this->catalogo->listado_colores(  );
            	$data['estatuss']  = $this->catalogo->listado_estatus(-1,-1,'1');
                $this->load->view( 'principal/inicio',$data );
              break;

            default:  
              redirect('');
              break;
          }
        }
        else{ 
          redirect('');
        }	

	}



	/////////////////////////////Presentacion de la regilla de DASHBOARD////////////////////////////
		//existencia 
	public function procesando_home(){
		$data=$_POST;
		$estatus= $data['extra_search'];
		switch ($estatus) {
			case 'existencia':
			case 'devolucion':
			case 'apartado':
				$busqueda = $this->modelo_dashboard->buscador_entrada_home($data);
			   break;
			case 'baja':
			case 'cero':
				$busqueda = $this->modelo_dashboard->buscador_cero_baja($data);
			   break;
			default:
				break;
		}
		echo $busqueda;
	}

	/////////////////////////////Presentacion de la regilla de INICIO ///////////////////////////////////////
		//devolucion y defecto
	public function procesando_inicio(){
		$data=$_POST;
		$busqueda = $this->modelo_inicio->buscador_inicio($data);
		echo $busqueda;
	}

 

	function detalles_producto($referencia = ''){

 		$id_perfil=$this->session->userdata('id_perfil');
 		switch ($id_perfil) {    
          case 3:
				$data['referencia'] 	= base64_decode($referencia);

				
				$data['el_producto'] = $this->modelo_inicio->el_producto($data);
				$data['los_productos'] = $this->modelo_inicio->los_productos($data);

				$this->load->view( 'principal/detalle_producto', $data );

                break;
                default:
                    redirect('');
                    break;
          }			
	}	


	           //////Marcar o desmarcar Apartado//// (INICIO)

	function marcando_apartado(){

	    if ($this->session->userdata('session') !== TRUE) {
	      redirect('');
	    } else {

	    	$data['id'] = $this->input->post('identificador');

	    	$actualizar = $this->modelo_inicio->marcando_apartado($data);

	    	echo  $actualizar;

		}	
   }



				//////Marcar o desmarcar Apartado/// (INICIO)

	public function procesar_apartados(){

		 if($this->session->userdata('session') === TRUE ){
		      $id_perfil=$this->session->userdata('id_perfil');

			      switch ($id_perfil) {    
			        case 3:
						       $data['val_proveedor']  = $this->modelo_inicio->valores_movimientos_temporal();
						       $data['movimientos']  = $this->modelo_inicio->listado_apartado();
			                   $this->load->view( 'pdfs/apartados/pdfs_view',$data );
			          break;
			        default:  
			          redirect('');
			          break;
			      }
			  } else { 
		          redirect('');
			  }  
	}




				////////Apartar definitivamente para un proveedor/// (INICIO)

	public function apartado_definitivo(){

		

		 if($this->session->userdata('session') === TRUE ){
	
			      $id_perfil=$this->session->userdata('id_perfil');


			      if ($this->input->post('id_cliente')) {
							$data['id_cliente'] =  $this->catalogo->check_existente_proveedor_entrada($this->input->post('id_cliente'));
							if (!($data['id_cliente'])){
								print "El cliente no existe";
							}
				  } else {
				  	$data['id_cliente']=null;
				  	print "Campo cliente obligatorio";
				  }


		 		if  ($data['id_cliente'])  {

							$actualizar = $this->modelo_inicio->apartar_definitivamente($data);

							if ( $actualizar !== FALSE ){
								echo TRUE;
							} else {
								echo '<span class="error">No se han podido apartar los productos</span>';
							}
		
				} else {      
					
	       			 echo validation_errors('<span class="error">aaa','</span>');

	      		}		



		  
		}
	}	


/////////////////////////////Hasta aqui la regilla de INICIO ///////////////////////////////////////





	





/////////////////////////////////////////////////////////////


	public function historicoaccesos(){

		if($this->session->userdata('session') === TRUE ){
			$id_perfil=$this->session->userdata('id_perfil');

	        //creamos la salida del html a la vista con ob_get_contents
	        //que lo que hace es imprimir el html
	        ob_start();
	        $this->paginacion_ajax_acceso(0);
	        $initial_content = ob_get_contents();
	        ob_end_clean();  

	        //asignamos $initial_content al array data para pasarlo a la vista
	        //y así poder mostrar tanto los links como la tabla
	        $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;	        

			switch ($id_perfil) {    
				case 1:		
					$this->load->view( 'paginacion/paginacion',$data);
					break;				
				default:  
					redirect('');
					break;
			}
		}
		else{ 
			redirect('');
		}
	}

 public function paginacion_ajax_acceso($offset = 0)  {
    	
    	//print $offset;
        //hacemos la configuración de la librería jquery_pagination
        $config['base_url'] = base_url('main/paginacion_ajax_acceso/');  //controlador/funcion

        $config['div'] = '#paginacion';//asignamos un id al contendor general
        $config['anchor_class'] = 'page_link';//asignamos una clase a los links para maquetar
	    $config['show_count'] = false;//en true queremos ver Viendo 1 a 10 de 52
        $config['per_page'] = 20;//-->número de provincias por página
        
        $config['num_links'] = 4;//-->número de links visibles
        
 

            $config['full_tag_open']       = '<ul class="pagination">';  
            $config['full_tag_close']      = '</ul>';
            $config['first_tag_open']      = '<li >'; 
            $config['first_tag_close']     = '</li>';
            $config['first_link']          = 'Primero'; 
            $config['last_tag_open']       = '<li >'; 
            $config['last_tag_close']      = '</li>';
            $config['last_link']           = 'Último';   
            $config['next_tag_open']       = '<li >'; 
            $config['next_tag_close']      = '</li>';
            $config['next_link']           = '&raquo;';  
            $config['prev_tag_open']       = '<li >'; 
            $config['prev_tag_close']      = '</li>';
            $config['prev_link']           = '&laquo;';   
            $config['num_tag_open']        = '<li>';
            $config['num_tag_close']       = '</li>';
            $config['cur_tag_open']        = '<li class="active"><a href="#">';
            $config['cur_tag_close']       = '</a></li>';   

        $config['total_rows'] = $this->modelo->total_acceso($config['per_page'], $offset); 
       
            
        
 
        //inicializamos la librería
        $this->jquery_pagination->initialize($config); 
		$data['uuu']='';
		$data['usuario_historico'] = $this->modelo->historico_acceso($data,$config['per_page'], $offset);
		$html = $this->load->view('historico_accesos',$data,true);	

        //$data['unidades']	= $this->unidad->get_unidades($config['per_page'], $offset); //
        //$html = $this->load->view( 'unidades/unidades',$data, true);   //


        $html = $html.
      	'<div class="container">
		 	<div class="col-xs-12">
		        <div id="paginacion">'.
		        	$this->jquery_pagination->create_links()
		        .'</div>
		    </div>
		</div>';
        echo $html;
 
    }	



/////////////////validaciones/////////////////////////////////////////	


	public function valid_cero($str)
	{
		return (  preg_match("/^(0)$/ix", $str)) ? FALSE : TRUE;
	}

	function nombre_valido( $str ){
		 $regex = "/^([A-Za-z ñáéíóúÑÁÉÍÓÚ]{2,60})$/i";
		//if ( ! preg_match( '/^[A-Za-zÁÉÍÓÚáéíóúÑñ \s]/', $str ) ){
		if ( ! preg_match( $regex, $str ) ){			
			$this->form_validation->set_message( 'nombre_valido','<b class="requerido">*</b> La información introducida en <b>%s</b> no es válida.' );
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function valid_phone( $str ){
		if ( $str ) {
			if ( ! preg_match( '/\([0-9]\)| |[0-9]/', $str ) ){
				$this->form_validation->set_message( 'valid_phone', '<b class="requerido">*</b> El <b>%s</b> no tiene un formato válido.' );
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}

	function valid_option( $str ){
		if ($str == 0) {
			$this->form_validation->set_message('valid_option', '<b class="requerido">*</b> Es necesario que selecciones una <b>%s</b>.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function valid_date( $str ){

		$arr = explode('-', $str);
		if ( count($arr) == 3 ){
			$d = $arr[0];
			$m = $arr[1];
			$y = $arr[2];
			if ( is_numeric( $m ) && is_numeric( $d ) && is_numeric( $y ) ){
				return checkdate($m, $d, $y);
			} else {
				$this->form_validation->set_message('valid_date', '<b class="requerido">*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD-MM-YYYY.');
				return FALSE;
			}
		} else {
			$this->form_validation->set_message('valid_date', '<b class="requerido">*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD/MM/YYYY.');
			return FALSE;
		}
	}

	public function valid_email($str)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
	}

////////////////////////////////////////////////////////////////
	//salida del sistema
	public function logout(){
		$this->session->sess_destroy();
		redirect('');
	}	

}

/* End of file main.php */
/* Location: ./app/controllers/main.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Catalogos extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('model_pedido', 'modelo_pedido');
    $this->load->model('catalogo', 'catalogo');  
    $this->load->library(array('email')); 
    $this->load->library('Jquery_pagination');//-->la estrella del equipo 
  }


//***********************Todos los catalogos**********************************//
  public function listado_catalogos(){

    if ( $this->session->userdata('session') !== TRUE ) {
      redirect('');
    } else {
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   
      switch ($id_perfil) {    
        case 1:
              $this->load->view( 'catalogos/catalogos' );
          break;
        case 2:
        case 3:
             if   ((in_array(8, $coleccion_id_operaciones)) 
                  || (in_array(11, $coleccion_id_operaciones)) || (in_array(12, $coleccion_id_operaciones)) 
                  || (in_array(13, $coleccion_id_operaciones)) || (in_array(14, $coleccion_id_operaciones)) 
                  || (in_array(15, $coleccion_id_operaciones)) || (in_array(16, $coleccion_id_operaciones)) 
                  || (in_array(17, $coleccion_id_operaciones)) || (in_array(18, $coleccion_id_operaciones)) 
                  || (in_array(19, $coleccion_id_operaciones)) || (in_array(20, $coleccion_id_operaciones)) 
                  || (in_array(21, $coleccion_id_operaciones)) || (in_array(22, $coleccion_id_operaciones)) 
              )


               { 
                  $this->load->view( 'catalogos/catalogos' );
              }  else  {
                redirect('');
              } 
          break;
        default:  
          redirect('');
          break;
      }
   }   

     
  }

//*********************** Pagina de editar **********************************//
 public function editar(){
                  $this->load->view( 'ediciones/editar' );
  }


//***********************Buscador por catalogos**********************************//
  public function busqueda(){
       $data['elemento']=$_GET['elemento'];


       switch ($data['elemento']) {
          case 'producto':
              $busqueda = $this->catalogo->buscar_productos();
              break;
          case 'color':
              $data['producto']=$_GET['producto'];
              $busqueda = $this->catalogo->buscar_colores($data);
              break;

          case 'composicion':
              $data['producto']=$_GET['producto'];
              $data['color']=$_GET['color'];
              $busqueda = $this->catalogo->buscar_composicion($data);
              break;

          case 'calidad':
              $data['producto']=$_GET['producto'];
              $data['color']=$_GET['color'];
              $data['composicion']=$_GET['composicion'];
              $busqueda = $this->catalogo->buscar_calidad($data);
              break;

          case 'completo':
              $data['producto']=$_GET['producto'];
              $data['color']=$_GET['color'];
              $data['composicion']=$_GET['composicion'];
              $data['calidad']=$_GET['calidad'];
              $busqueda = $this->catalogo->buscar_completo($data);

              break;              

       }     

      print  $busqueda;

  }
  public function buscador(){

    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {

      
       if (isset($_GET['dependiente'])) {
           $data['dependiente']=$_GET['dependiente'];
           print_r($data['dependiente']);
           die;
       }

       $data['key']=$_GET['key'];
       $data['nombre']=$_GET['nombre'];
       
       if (isset($_GET['idproveedor'])) { 
        $data['idproveedor']=$_GET['idproveedor'];
       } 

       switch ($data['nombre']) {

        case 'editar_actividad_comercial':
            $busqueda = $this->catalogo->buscador_actividades($data);
          break;

        case 'editar_unidad_medida':
            $busqueda = $this->catalogo->buscador_medidas($data);
          break;

        case 'editar_ancho':
            $busqueda = $this->catalogo->buscador_anchos($data);
          break;
          

        case 'editar_calidad':
            $busqueda = $this->catalogo->buscador_calidades($data);
          break;


        case 'editar_color':
            $busqueda = $this->catalogo->buscador_colores($data);
          break;

        case 'editar_composicion':
            $busqueda = $this->catalogo->buscador_composiciones($data);
          break;

        case 'editar_operacion':
            $busqueda = $this->catalogo->buscador_operaciones($data);
          break;

        case 'editar_proveedor':
            $busqueda = $this->catalogo->buscador_proveedores($data);
          break;

        case 'editar_proveedor_reporte':
            $busqueda = $this->catalogo->buscador_proveedores($data);
          break;


        case 'editar_prod_inven':
            $busqueda = $this->catalogo->buscador_prod_inven($data); //prod d inventario
          break;

        case 'editar_prod_devolucion':
            $busqueda = $this->catalogo->buscador_prod_devolucion($data); //prod d inventario
          break;

        case 'editar_cargador':
            $busqueda = $this->catalogo->buscador_cargadores($data);
          break;


        case 'editar_producto':
            $busqueda = $this->catalogo->buscador_productos($data);
          break;


       }
       

       echo $busqueda;
    }  
  }



//***********************Unidades de medidas**********************************//

  public function listado_unidades_medidas(){


    if ( $this->session->userdata('session') !== TRUE ) {
      redirect('login');
    } else {
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   
      switch ($id_perfil) {    
        case 1:

              ob_start();
              $this->paginacion_ajax_medida(0); //
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);
          break;
        case 2:
        case 3:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(20, $coleccion_id_operaciones))  ) 

               { 
              ob_start();
              $this->paginacion_ajax_medida(0); //
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);
              }  else  {
                redirect('');
              } 
          break;
        default:  
          redirect('');
          break;
      }
    }
  
  }

  public function paginacion_ajax_medida($offset = 0)  {
        //hacemos la configuración de la librería jquery_pagination
        $config['base_url'] = base_url('catalogos/paginacion_ajax_medida/');  //controlador/funcion

        $config['div'] = '#paginacion';//asignamos un id al contendor general
        $config['anchor_class'] = 'page_link';//asignamos una clase a los links para maquetar
      $config['show_count'] = false;//en true queremos ver Viendo 1 a 10 de 52
        $config['per_page'] = 20;//-->número de medidas por página
        $config['num_links'] = 4;//-->número de links visibles en el pie de la pagina

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
        $config['total_rows'] = $this->catalogo->total_medidas(); 
 
        //inicializamos la librería
        $this->jquery_pagination->initialize($config); 

    $data['medidas']  = $this->catalogo->listado_medidas($config['per_page'], $offset);
    $html = $this->load->view( 'catalogos/medidas',$data ,true);

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

    // crear
  function nuevo_unidad_medida(){
    if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'catalogos/medidas/nuevo_medida');
          break;
        case 2:
        case 3:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(20, $coleccion_id_operaciones))  )   { 
                $this->load->view( 'catalogos/medidas/nuevo_medida');
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

  function validar_nuevo_unidad_medida(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules( 'medida', ' Medida', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
      if ($this->form_validation->run() === TRUE){
          $data['medida']   = $this->input->post('medida');
          $data         =   $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->anadir_medida( $data );
          if ( $guardar !== FALSE ){
            echo true;
          } else {
            echo '<span class="error"><b>E01</b> - La nueva  medida no pudo ser agregada</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }


  // editar
  function editar_unidad_medida( $id = '' ){
if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   



      switch ($id_perfil) {    
        case 1:
              $data['medida'] = $this->catalogo->coger_medida($data);
              if ( $data['medida'] !== FALSE ){
                  $this->load->view( 'catalogos/medidas/editar_medida', $data );
              } else {
                    redirect('');
              }       
        
          break;
        case 2:
        case 3:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(20, $coleccion_id_operaciones))  )   { 
                  $data['medida'] = $this->catalogo->coger_medida($data);
                  if ( $data['medida'] !== FALSE ){
                      $this->load->view( 'catalogos/medidas/editar_medida', $data );
                  } else {
                        redirect('');
                  }       

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


function validacion_edicion_unidad_medida(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules( 'medida', ' Medida', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');

      if ($this->form_validation->run() === TRUE){
            $data['id']           = $this->input->post('id');
          $data['medida']         = $this->input->post('medida');
          $data               = $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->editar_medida( $data );

          if ( $guardar !== FALSE ){
            echo true;

          } else {
            echo '<span class="error"><b>E01</b> - La nueva  medida no pudo ser agregada</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }
  

  // eliminar


  function eliminar_unidad_medida($id = '', $nombrecompleto=''){

      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

            $data['nombrecompleto']   = base64_decode($nombrecompleto);

      switch ($id_perfil) {    
        case 1:
            $data['id']         = $id;
            $this->load->view( 'catalogos/medidas/eliminar_medida', $data );

          break;
        case 2:
        case 3:
              if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(20, $coleccion_id_operaciones))  )   { 
                $data['id']         = $id;
                $this->load->view( 'catalogos/medidas/eliminar_medida', $data );
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


  function validar_eliminar_unidad_medida(){
    if (!empty($_POST['id'])){ 
      $data['id'] = $_POST['id'];
    }
    $eliminado = $this->catalogo->eliminar_medida(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la medida</span>';
    }
  }   


//***********************composiciones**********************************//

  public function listado_composiciones(){

    if ( $this->session->userdata('session') !== TRUE ) {
      redirect('login');
    } else {
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   



      switch ($id_perfil) {    
        case 1:

              ob_start();
              $this->paginacion_ajax_composicion(0); //
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);
            
          break;
        case 2:
        case 3:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )   { 
                 ob_start();
                $this->paginacion_ajax_composicion(0); //
                $initial_content = ob_get_contents();
                ob_end_clean();    
                $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
                $this->load->view( 'paginacion/paginacion',$data);
             }  else  {
                redirect('');
              } 

          break;


        default:  
          redirect('');
          break;
      }


    }
  
  }

 

  public function paginacion_ajax_composicion($offset = 0)  {
        //hacemos la configuración de la librería jquery_pagination
        $config['base_url'] = base_url('catalogos/paginacion_ajax_composicion/');  //controlador/funcion

        $config['div'] = '#paginacion';//asignamos un id al contendor general
        $config['anchor_class'] = 'page_link';//asignamos una clase a los links para maquetar
      $config['show_count'] = false;//en true queremos ver Viendo 1 a 10 de 52
        $config['per_page'] = 20;//-->número de composiciones por página
        $config['num_links'] = 4;//-->número de links visibles en el pie de la pagina

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
        $config['total_rows'] = $this->catalogo->total_composiciones(); 
 
        //inicializamos la librería
        $this->jquery_pagination->initialize($config); 

    $data['composiciones']  = $this->catalogo->listado_composiciones($config['per_page'], $offset);
    $html = $this->load->view( 'catalogos/composiciones',$data ,true);

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

    // crear
  function nuevo_composicion(){
if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'catalogos/composiciones/nuevo_composicion');
          break;
        case 2:
        case 3:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                $this->load->view( 'catalogos/composiciones/nuevo_composicion');
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

  function validar_nuevo_composicion(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules('composicion', 'Composicion', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
      if ($this->form_validation->run() === TRUE){
          $data['composicion']   = $this->input->post('composicion');
          $data         =   $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->anadir_composicion( $data );
          if ( $guardar !== FALSE ){
            echo true;
          } else {
            echo '<span class="error"><b>E01</b> - La nueva  composicion no pudo ser agregada</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }


  // editar
  function editar_composicion( $id = '' ){
     
      if($this->session->userdata('session') === TRUE ){
            $id_perfil=$this->session->userdata('id_perfil');

            $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
            if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                  $coleccion_id_operaciones = array();
             }   


              $data['id']  = $id;
            switch ($id_perfil) {    
              case 1:
                    $data['composicion'] = $this->catalogo->coger_composicion($data);
                    if ( $data['composicion'] !== FALSE ){
                        $this->load->view( 'catalogos/composiciones/editar_composicion', $data );
                    } else {
                          redirect('');
                    }               
                break;
              case 2:
              case 3:
                   if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                      $data['composicion'] = $this->catalogo->coger_composicion($data);
                      if ( $data['composicion'] !== FALSE ){
                          $this->load->view( 'catalogos/composiciones/editar_composicion', $data );
                      } else {
                            redirect('');
                      }       
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


function validacion_edicion_composicion(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules( 'composicion', 'Composicion', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');

      if ($this->form_validation->run() === TRUE){
            $data['id']           = $this->input->post('id');
          $data['composicion']         = $this->input->post('composicion');
          $data               = $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->editar_composicion( $data );

          if ( $guardar !== FALSE ){
            echo true;

          } else {
            echo '<span class="error"><b>E01</b> - La nueva  composicion no pudo ser agregada</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }
  

  // eliminar


  function eliminar_composicion($id = '', $nombrecompleto=''){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

            $data['nombrecompleto']   = base64_decode($nombrecompleto);

      switch ($id_perfil) {    
        case 1:
            $data['id']         = $id;
            $this->load->view( 'catalogos/composiciones/eliminar_composicion', $data );

          break;
        case 2:
        case 3:
              if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                $data['id']         = $id;
                $this->load->view( 'catalogos/composiciones/eliminar_composicion', $data );
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


  function validar_eliminar_composicion(){
    if (!empty($_POST['id'])){ 
      $data['id'] = $_POST['id'];
    }
    $eliminado = $this->catalogo->eliminar_composicion(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la composicion</span>';
    }
  }   
   

//***********************actividades comerciales**********************************//

  public function listado_actividad_comercial(){


  if ( $this->session->userdata('session') !== TRUE ) {
      redirect('login');
    } else {
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   



      switch ($id_perfil) {    
        case 1:

              ob_start();
              $this->paginacion_ajax_actividad(0); //
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);

            
          break;
        case 2:
        case 3:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
              ob_start();
              $this->paginacion_ajax_actividad(0); //
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);

              }  else  {
                redirect('');
              } 

          break;


        default:  
          redirect('');
          break;
      }
   }   
  
  }

  public function paginacion_ajax_actividad($offset = 0)  {
        //hacemos la configuración de la librería jquery_pagination
        $config['base_url'] = base_url('catalogos/paginacion_ajax_actividad/');  //controlador/funcion

        $config['div'] = '#paginacion';//asignamos un id al contendor general
        $config['anchor_class'] = 'page_link';//asignamos una clase a los links para maquetar
      $config['show_count'] = false;//en true queremos ver Viendo 1 a 10 de 52
        $config['per_page'] = 20;//-->número de actividades por página
        $config['num_links'] = 4;//-->número de links visibles en el pie de la pagina

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
        $config['total_rows'] = $this->catalogo->total_actividades(); 
 
        //inicializamos la librería
        $this->jquery_pagination->initialize($config); 

    $data['actividades']  = $this->catalogo->listado_actividades($config['per_page'], $offset);
    $html = $this->load->view( 'catalogos/actividades',$data ,true);

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

    // crear
  function nuevo_actividad_comercial(){
if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'catalogos/actividades/nuevo_actividad');
          break;
        case 2:
        case 3:
             if   ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                $this->load->view( 'catalogos/actividades/nuevo_actividad');
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

  function validar_nuevo_actividad_comercial(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules('actividad', 'Actividad comercial', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
      if ($this->form_validation->run() === TRUE){
          $data['actividad']   = $this->input->post('actividad');
          $data         =   $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->anadir_actividad( $data );
          if ( $guardar !== FALSE ){
            echo true;
          } else {
            echo '<span class="error"><b>E01</b> - La nueva  actividad no pudo ser agregada</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }


  // editar
  function editar_actividad_comercial( $id = '' ){

      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

       $data['id']  = $id;

      switch ($id_perfil) {    
        case 1:
              $data['actividad'] = $this->catalogo->coger_actividad($data);
              if ( $data['actividad'] !== FALSE ){
                  $this->load->view( 'catalogos/actividades/editar_actividad', $data );
              } else {
                    redirect('');
              }       
          break;
        case 2:
        case 3:
              if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                $data['actividad'] = $this->catalogo->coger_actividad($data);
                if ( $data['actividad'] !== FALSE ){
                    $this->load->view( 'catalogos/actividades/editar_actividad', $data );
                } else {
                      redirect('');
              }       
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


function validacion_edicion_actividad_comercial(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules( 'actividad', 'Actividad comercial', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');

      if ($this->form_validation->run() === TRUE){
            $data['id']           = $this->input->post('id');
          $data['actividad']         = $this->input->post('actividad');
          $data               = $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->editar_actividad( $data );

          if ( $guardar !== FALSE ){
            echo true;

          } else {
            echo '<span class="error"><b>E01</b> - La nueva  actividad no pudo ser agregada</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }
  

  // eliminar


  function eliminar_actividad_comercial($id = '', $nombrecompleto=''){

      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

            $data['nombrecompleto']   = base64_decode($nombrecompleto);

      switch ($id_perfil) {    
        case 1:
            $data['id']         = $id;
            $this->load->view( 'catalogos/actividades/eliminar_actividad', $data );

          break;
        case 2:
        case 3:
              if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(13, $coleccion_id_operaciones))  )  { 
                $data['id']         = $id;
                $this->load->view( 'catalogos/actividades/eliminar_actividad', $data );
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


  function validar_eliminar_actividad_comercial(){
    if (!empty($_POST['id'])){ 
      $data['id'] = $_POST['id'];
    }
    $eliminado = $this->catalogo->eliminar_actividad(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la actividad</span>';
    }
  }   




//***********************colores **********************************//

  public function listado_colores(){
  if ( $this->session->userdata('session') !== TRUE ) {
      redirect('login');
    } else {
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   



      switch ($id_perfil) {    
        case 1:

              ob_start();
              $this->paginacion_ajax_color(0);  //
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);

            
          break;
        case 2:
        case 3:
             if ( (in_array(8, $coleccion_id_operaciones))  || (in_array(12, $coleccion_id_operaciones))  )  { 
              ob_start();
              $this->paginacion_ajax_color(0);  //
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);

              }  else  {
                redirect('');
              } 

          break;


        default:  
          redirect('');
          break;
      }
   }   
  
  }

  public function paginacion_ajax_color($offset = 0)  {
        //hacemos la configuración de la librería jquery_pagination
        $config['base_url'] = base_url('catalogos/paginacion_ajax_color/');  //controlador/funcion

        $config['div'] = '#paginacion';//asignamos un id al contendor general
        $config['anchor_class'] = 'page_link';//asignamos una clase a los links para maquetar
      $config['show_count'] = false;//en true queremos ver Viendo 1 a 10 de 52
        $config['per_page'] = 20;//-->número de colores por página
        $config['num_links'] = 4;//-->número de links visibles en el pie de la pagina

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
        $config['total_rows'] = $this->catalogo->total_colores(); 
 
        //inicializamos la librería
        $this->jquery_pagination->initialize($config); 

    $data['colores']  = $this->catalogo->listado_colores($config['per_page'], $offset);

    $html = $this->load->view( 'catalogos/colores',$data ,true);

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

    // crear
  function nuevo_color(){
if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'catalogos/colores/nuevo_color');
          break;
        case 2:
        case 3:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(12, $coleccion_id_operaciones))  )  { 
                $this->load->view( 'catalogos/colores/nuevo_color');
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


  function validar_nuevo_color(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules('color', 'Color', 'trim|required|min_length[3]|max_lenght[80]|xss_clean');
      $this->form_validation->set_rules('hexadecimal_color', 'Color', 'trim|required|min_lenght[3]|max_length[6]|xss_clean');
      if ($this->form_validation->run() === TRUE){
          $data['color']   = $this->input->post('color');
          $data['hexadecimal_color'] = $this->input->post('hexadecimal_color');
          $data         =   $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->anadir_color( $data );
          if ( $guardar !== FALSE ){
            echo true;
          } else {
            echo '<span class="error"><b>E01</b> - La nueva  color no pudo ser agregada</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }


  // editar
  function editar_color( $id = '' ){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

       $data['id']  = $id;

      switch ($id_perfil) {    
        case 1:
                  $data['color'] = $this->catalogo->coger_color($data);
                  if ( $data['color'] !== FALSE ){
                      $this->load->view( 'catalogos/colores/editar_color', $data );
                  } else {
                        redirect('');
                  }       

          break;
        case 2:
        case 3:
              if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(12, $coleccion_id_operaciones))  )  { 
                  $data['color'] = $this->catalogo->coger_color($data);
                  if ( $data['color'] !== FALSE ){
                      $this->load->view( 'catalogos/colores/editar_color', $data );
                  } else {
                        redirect('');
                  }       
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


function validacion_edicion_color(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
        $this->form_validation->set_rules('color', 'Color', 'trim|required|min_length[3]|max_lenght[80]|xss_clean');
        $this->form_validation->set_rules('hexadecimal_color', 'Color', 'trim|required|min_lenght[3]|max_length[6]|xss_clean');


      if ($this->form_validation->run() === TRUE){
            $data['id']           = $this->input->post('id');
          $data['color']         = $this->input->post('color');
          $data['hexadecimal_color'] = $this->input->post('hexadecimal_color');

          $data               = $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->editar_color( $data );

          if ( $guardar !== FALSE ){
            echo true;

          } else {
            echo '<span class="error"><b>E01</b> - La nueva  color no pudo ser agregada</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }
  

  // eliminar



  function eliminar_color($id = '', $nombrecompleto='', $hexadecimal_color=''){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

        $data['nombrecompleto']   = base64_decode($nombrecompleto);
        $data['hexadecimal_color']   = base64_decode($hexadecimal_color);
        $data['id']         = $id;

      switch ($id_perfil) {    
        case 1:
                 $this->load->view( 'catalogos/colores/eliminar_color', $data );

          break;
        case 2:
        case 3:
              if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(12, $coleccion_id_operaciones))  )  { 
                     $this->load->view( 'catalogos/colores/eliminar_color', $data );
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


  function validar_eliminar_color(){
    if (!empty($_POST['id'])){ 
      $data['id'] = $_POST['id'];
    }
    $eliminado = $this->catalogo->eliminar_color(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la color</span>';
    }
  }   

//***********************calidades **********************************//

  public function listado_calidades(){

  if ( $this->session->userdata('session') !== TRUE ) {
      redirect('login');
    } else {
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   



      switch ($id_perfil) {    
        case 1:

              ob_start();
              $this->paginacion_ajax_calidad(0); //
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);

            
          break;
        case 2:
        case 3:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(19, $coleccion_id_operaciones))  )  { 
              ob_start();
              $this->paginacion_ajax_calidad(0);//
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);

              }  else  {
                redirect('');
              } 

          break;


        default:  
          redirect('');
          break;
      }
   }   
  
  }

  public function paginacion_ajax_calidad($offset = 0)  {
        //hacemos la configuración de la librería jquery_pagination
        $config['base_url'] = base_url('catalogos/paginacion_ajax_calidad/');  //controlador/funcion

        $config['div'] = '#paginacion';//asignamos un id al contendor general
        $config['anchor_class'] = 'page_link';//asignamos una clase a los links para maquetar
      $config['show_count'] = false;//en true queremos ver Viendo 1 a 10 de 52
        $config['per_page'] = 20;//-->número de calidades por página
        $config['num_links'] = 4;//-->número de links visibles en el pie de la pagina

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
        $config['total_rows'] = $this->catalogo->total_calidades(); 
 
        //inicializamos la librería
        $this->jquery_pagination->initialize($config); 

    $data['calidades']  = $this->catalogo->listado_calidades($config['per_page'], $offset);

    $html = $this->load->view( 'catalogos/calidades',$data ,true);

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

    // crear
  function nuevo_calidad(){
    if($this->session->userdata('session') === TRUE ){
          $id_perfil=$this->session->userdata('id_perfil');

          $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
          if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                $coleccion_id_operaciones = array();
           }   

          switch ($id_perfil) {    
            case 1:
                $this->load->view( 'catalogos/calidades/nuevo_calidad');
              break;
            case 2:
            case 3:
                 if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(19, $coleccion_id_operaciones))  )  { 
                    $this->load->view( 'catalogos/calidades/nuevo_calidad');
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

  function validar_nuevo_calidad(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules('calidad', 'Calidad', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
      if ($this->form_validation->run() === TRUE){
          $data['calidad']   = $this->input->post('calidad');
          $data         =   $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->anadir_calidad( $data );
          if ( $guardar !== FALSE ){
            echo true;
          } else {
            echo '<span class="error"><b>E01</b> - La nueva calidad no pudo ser agregada</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }


  // editar
  function editar_calidad( $id = '' ){

    if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

       $data['id']  = $id;

      switch ($id_perfil) {    
        case 1:
                $data['calidad'] = $this->catalogo->coger_calidad($data);
                if ( $data['calidad'] !== FALSE ){
                    $this->load->view( 'catalogos/calidades/editar_calidad', $data );
                } else {
                      redirect('');
                }       

          break;
        case 2:
        case 3:
              if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(19, $coleccion_id_operaciones))  )  { 
                    $data['calidad'] = $this->catalogo->coger_calidad($data);
                     if ( $data['calidad'] !== FALSE ){
                       $this->load->view( 'catalogos/calidades/editar_calidad', $data );
                    } else {
                          redirect('');
                    }       
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


function validacion_edicion_calidad(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules( 'calidad', 'Calidad', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');

      if ($this->form_validation->run() === TRUE){
            $data['id']           = $this->input->post('id');
          $data['calidad']         = $this->input->post('calidad');
          $data               = $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->editar_calidad( $data );

          if ( $guardar !== FALSE ){
            echo true;

          } else {
            echo '<span class="error"><b>E01</b> - La nueva calidad no pudo ser agregada</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }
  

  // eliminar


  function eliminar_calidad($id = '', $nombrecompleto=''){
    if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

          $data['nombrecompleto']   = base64_decode($nombrecompleto);
          $data['id']         = $id;

      switch ($id_perfil) {    
        case 1:            
                    $this->load->view( 'catalogos/calidades/eliminar_calidad', $data );
          break;
        case 2:
        case 3:
              if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(19, $coleccion_id_operaciones))  )  {                 
                        $this->load->view( 'catalogos/calidades/eliminar_calidad', $data );
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


  function validar_eliminar_calidad(){
    if (!empty($_POST['id'])){ 
      $data['id'] = $_POST['id'];
    }
    $eliminado = $this->catalogo->eliminar_calidad(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la calidad</span>';
    }
  }   





//***********************anchos **********************************//

  public function listado_anchos(){

  if ( $this->session->userdata('session') !== TRUE ) {
      redirect('login');
    } else {
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      switch ($id_perfil) {    
        case 1:

              ob_start();
              $this->paginacion_ajax_ancho(0);  //
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);

            
          break;
        case 2:
        case 3:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(18, $coleccion_id_operaciones))  )  { 
              ob_start();
              $this->paginacion_ajax_ancho(0); //
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);

              }  else  {
                redirect('');
              } 

          break;


        default:  
          redirect('');
          break;
      }
   }    
  }

  public function paginacion_ajax_ancho($offset = 0)  {
        //hacemos la configuración de la librería jquery_pagination
        $config['base_url'] = base_url('catalogos/paginacion_ajax_ancho/');  //controlador/funcion

        $config['div'] = '#paginacion';//asignamos un id al contendor general
        $config['anchor_class'] = 'page_link';//asignamos una clase a los links para maquetar
      $config['show_count'] = false;//en true queremos ver Viendo 1 a 10 de 52
        $config['per_page'] = 20;//-->número de anchos por página
        $config['num_links'] = 4;//-->número de links visibles en el pie de la pagina

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
        $config['total_rows'] = $this->catalogo->total_anchos(); 
 
        //inicializamos la librería
        $this->jquery_pagination->initialize($config); 

    $data['anchos']  = $this->catalogo->listado_anchos($config['per_page'], $offset);

    $html = $this->load->view( 'catalogos/anchos',$data ,true);

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

    // crear
  function nuevo_ancho(){
    if($this->session->userdata('session') === TRUE ){
          $id_perfil=$this->session->userdata('id_perfil');

          $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
          if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                $coleccion_id_operaciones = array();
           }   

          switch ($id_perfil) {    
            case 1:
                $this->load->view( 'catalogos/anchos/nuevo_ancho');
              break;
            case 2:
            case 3:
                 if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(18, $coleccion_id_operaciones))  )  { 
                    $this->load->view( 'catalogos/anchos/nuevo_ancho');
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

  function validar_nuevo_ancho(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules('ancho', 'Ancho', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
      if ($this->form_validation->run() === TRUE){
          $data['ancho']   = $this->input->post('ancho');
          $data         =   $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->anadir_ancho( $data );
          if ( $guardar !== FALSE ){
            echo true;
          } else {
            echo '<span class="error"><b>E01</b> - La nueva  ancho no pudo ser agregada</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }


  // editar
  function editar_ancho( $id = '' ){

if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

       $data['id']  = $id;

      switch ($id_perfil) {    
        case 1:

                $data['ancho'] = $this->catalogo->coger_ancho($data);
                if ( $data['ancho'] !== FALSE ){
                    $this->load->view( 'catalogos/anchos/editar_ancho', $data );
                } else {
                      redirect('');
                }       

          break;
        case 2:
        case 3:
              if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(18, $coleccion_id_operaciones))  )  { 
                $data['ancho'] = $this->catalogo->coger_ancho($data);
                if ( $data['ancho'] !== FALSE ){
                    $this->load->view( 'catalogos/anchos/editar_ancho', $data );
                } else {
                      redirect('');
                }       
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


function validacion_edicion_ancho(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules( 'ancho', 'Ancho', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');

      if ($this->form_validation->run() === TRUE){
            $data['id']           = $this->input->post('id');
          $data['ancho']         = $this->input->post('ancho');
          $data               = $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->editar_ancho( $data );

          if ( $guardar !== FALSE ){
            echo true;

          } else {
            echo '<span class="error"><b>E01</b> - La nueva  ancho no pudo ser agregada</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }
  

  // eliminar


  function eliminar_ancho($id = '', $nombrecompleto=''){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      $data['nombrecompleto']   = base64_decode($nombrecompleto);
      $data['id']         = $id;
      
      switch ($id_perfil) {    
        case 1:            
                    $this->load->view( 'catalogos/anchos/eliminar_ancho', $data );
          break;
        case 2:
        case 3:
              if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(18, $coleccion_id_operaciones))  )  {                 
                        $this->load->view( 'catalogos/anchos/eliminar_ancho', $data );
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


  function validar_eliminar_ancho(){
    if (!empty($_POST['id'])){ 
      $data['id'] = $_POST['id'];
    }
    $eliminado = $this->catalogo->eliminar_ancho(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la ancho</span>';
    }
  }   



//***********************cargadores **********************************//

  public function listado_cargadores(){

  if ( $this->session->userdata('session') !== TRUE ) {
      redirect('login');
    } else {
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   



      switch ($id_perfil) {    
        case 1:

              ob_start();
              $this->paginacion_ajax_cargador(0);  //
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);

            
          break;
        case 2:
        case 3:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(17, $coleccion_id_operaciones))  )  { 
              ob_start();
              $this->paginacion_ajax_cargador(0); //
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);

              }  else  {
                redirect('');
              } 

          break;


        default:  
          redirect('');
          break;
      }
   }   
  
  }

  public function paginacion_ajax_cargador($offset = 0)  {
        //hacemos la configuración de la librería jquery_pagination
        $config['base_url'] = base_url('catalogos/paginacion_ajax_cargador/');  //controlador/funcion

        $config['div'] = '#paginacion';//asignamos un id al contendor general
        $config['cargadorr_class'] = 'page_link';//asignamos una clase a los links para maquetar
      $config['show_count'] = false;//en true queremos ver Viendo 1 a 10 de 52
        $config['per_page'] = 20;//-->número de cargadores por página
        $config['num_links'] = 4;//-->número de links visibles en el pie de la pagina

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
        $config['total_rows'] = $this->catalogo->total_cargadores(); 
 
        //inicializamos la librería
        $this->jquery_pagination->initialize($config); 

    $data['cargadores']  = $this->catalogo->listado_cargadores($config['per_page'], $offset);

    $html = $this->load->view( 'catalogos/cargadores',$data ,true);

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

    // crear
  function nuevo_cargador(){
    if($this->session->userdata('session') === TRUE ){
          $id_perfil=$this->session->userdata('id_perfil');

          $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
          if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                $coleccion_id_operaciones = array();
           }   

          switch ($id_perfil) {    
            case 1:
                $this->load->view( 'catalogos/cargadores/nuevo_cargador');
              break;
            case 2:
            case 3:
                 if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(17, $coleccion_id_operaciones))  )  { 
                    $this->load->view( 'catalogos/cargadores/nuevo_cargador');
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

  function validar_nuevo_cargador(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
      if ($this->form_validation->run() === TRUE){
          $data['nombre']   = $this->input->post('nombre');
          $data         =   $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->anadir_cargador( $data );
          if ( $guardar !== FALSE ){
            echo true;
          } else {
            echo '<span class="error"><b>E01</b> - El nuevo cargador no pudo ser agregada</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }


  // editar
  function editar_cargador( $id = '' ){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

       $data['id']  = $id;

      switch ($id_perfil) {    
        case 1:

              $data['cargador'] = $this->catalogo->coger_cargador($data);
              if ( $data['cargador'] !== FALSE ){
                  $this->load->view( 'catalogos/cargadores/editar_cargador', $data );
              } else {
                    redirect('');
              }       


          break;
        case 2:
        case 3:
              if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(17, $coleccion_id_operaciones))  )  { 
                    $data['cargador'] = $this->catalogo->coger_cargador($data);
                    if ( $data['cargador'] !== FALSE ){
                        $this->load->view( 'catalogos/cargadores/editar_cargador', $data );
                    } else {
                          redirect('');
                    }       

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


function validacion_edicion_cargador(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules( 'nombre', 'Nombre', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');

      if ($this->form_validation->run() === TRUE){
            $data['id']           = $this->input->post('id');
          $data['nombre']         = $this->input->post('nombre');
          $data               = $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->editar_cargador( $data );

          if ( $guardar !== FALSE ){
            echo true;

          } else {
            echo '<span class="error"><b>E01</b> - El nuevo cargador no pudo ser agregado</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }
  

  // eliminar


  function eliminar_cargador($id = '', $nombrecompleto=''){
    if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      $data['nombrecompleto']   = base64_decode($nombrecompleto);
      $data['id']         = $id;
      
      switch ($id_perfil) {    
        case 1:            
                    $this->load->view( 'catalogos/cargadores/eliminar_cargador', $data );
          break;
        case 2:
        case 3:
              if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(17, $coleccion_id_operaciones))  )  {                 
                        $this->load->view( 'catalogos/cargadores/eliminar_cargador', $data );
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


  function validar_eliminar_cargador(){
    if (!empty($_POST['id'])){ 
      $data['id'] = $_POST['id'];
    }
    $eliminado = $this->catalogo->eliminar_cargador(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la cargador</span>';
    }
  }   



//***********************operaciones**********************************//

  public function listado_operaciones(){
  if ( $this->session->userdata('session') !== TRUE ) {
      redirect('login');
    } else {
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   



      switch ($id_perfil) {    
        case 1:

              ob_start();
              $this->paginacion_ajax_operacion(0); //
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);

            
          break;
        case 2:
        case 3:
             if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(22, $coleccion_id_operaciones))  )  { 
              ob_start();
              $this->paginacion_ajax_operacion(0);//
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);

              }  else  {
                redirect('');
              } 

          break;


        default:  
          redirect('');
          break;
      }
   }     
  }

  public function paginacion_ajax_operacion($offset = 0)  {
        //hacemos la configuración de la librería jquery_pagination
        $config['base_url'] = base_url('catalogos/paginacion_ajax_operacion/');  //controlador/funcion

        $config['div'] = '#paginacion';//asignamos un id al contendor general
        $config['anchor_class'] = 'page_link';//asignamos una clase a los links para maquetar
      $config['show_count'] = false;//en true queremos ver Viendo 1 a 10 de 52
        $config['per_page'] = 20;//-->número de operaciones por página
        $config['num_links'] = 4;//-->número de links visibles en el pie de la pagina

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
        $config['total_rows'] = $this->catalogo->total_operaciones(); 
 
        //inicializamos la librería
        $this->jquery_pagination->initialize($config); 

    $data['operaciones']  = $this->catalogo->listado_operaciones($config['per_page'], $offset);
    $html = $this->load->view( 'catalogos/operaciones',$data ,true);

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

    // crear
  function nuevo_operacion(){
    if($this->session->userdata('session') === TRUE ){
          $id_perfil=$this->session->userdata('id_perfil');

          $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
          if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                $coleccion_id_operaciones = array();
           }   

          switch ($id_perfil) {    
            case 1:
                $this->load->view( 'catalogos/operaciones/nuevo_operacion');
              break;
            case 2:
            case 3:
                 if   ( (in_array(8, $coleccion_id_operaciones))  || (in_array(22, $coleccion_id_operaciones))  )   { 
                    $this->load->view( 'catalogos/operaciones/nuevo_operacion');
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

  function validar_nuevo_operacion(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules( 'operacion', 'Operación', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');

      if ($this->form_validation->run() === TRUE){
          $data['operacion']    = $this->input->post('operacion');
          $data         =   $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->anadir_operacion( $data );
          if ( $guardar !== FALSE ){
            echo true;
          } else {
            echo '<span class="error"><b>E01</b> - La nueva Operación no pudo ser agregada</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }


  // editar
  function editar_operacion( $id = '' ){
    if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

       $data['id']  = $id;

      switch ($id_perfil) {    
        case 1:
                  $data['operacion']  = $this->catalogo->coger_operacion($data);
                  if ( $data['operacion'] !== FALSE ){
                      $this->load->view( 'catalogos/operaciones/editar_operacion', $data );
                  } else {
                        redirect('');
                  }       

          break;
        case 2:
        case 3:
              if   ( (in_array(8, $coleccion_id_operaciones))  || (in_array(22, $coleccion_id_operaciones))  )   { 
                  $data['operacion']  = $this->catalogo->coger_operacion($data);
                  if ( $data['operacion'] !== FALSE ){
                      $this->load->view( 'catalogos/operaciones/editar_operacion', $data );
                  } else {
                        redirect('');
                  }       

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


function validacion_edicion_operacion(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
      $this->form_validation->set_rules( 'operacion', 'Operación', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');

      if ($this->form_validation->run() === TRUE){
            $data['id']           = $this->input->post('id');
          $data['operacion']        = $this->input->post('operacion');
          $data               = $this->security->xss_clean($data);  
          $guardar            = $this->catalogo->editar_operacion( $data );

          if ( $guardar !== FALSE ){
            echo true;

          } else {
            echo '<span class="error"><b>E01</b> - La nueva Operación no pudo ser agregada</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }
  

  // eliminar


  function eliminar_operacion($id = '', $nombrecompleto=''){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      $data['nombrecompleto']   = base64_decode($nombrecompleto);
      $data['id']         = $id;
      
      switch ($id_perfil) {    
        case 1:            
                    $this->load->view( 'catalogos/operaciones/eliminar_operacion', $data );
          break;
        case 2:
        case 3:
              if   ( (in_array(8, $coleccion_id_operaciones))  || (in_array(22, $coleccion_id_operaciones))  )   {                 
                        $this->load->view( 'catalogos/operaciones/eliminar_operacion', $data );
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


  function validar_eliminar_operacion(){
    if (!empty($_POST['id'])){ 
      $data['id'] = $_POST['id'];
    }
    $eliminado = $this->catalogo->eliminar_operacion(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la operacion</span>';
    }
  } 


//***********************proveedores**********************************//
  public function listado_proveedores(){
  if ( $this->session->userdata('session') !== TRUE ) {
      redirect('login');
    } else {
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   



      switch ($id_perfil) {    
        case 1:

              ob_start();
              $this->paginacion_ajax_proveedor(0); //
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);

            
          break;
        case 2:
        case 3:
             if     ( (in_array(8, $coleccion_id_operaciones))  || (in_array(14, $coleccion_id_operaciones))  
                      || (in_array(15, $coleccion_id_operaciones)) || (in_array(16, $coleccion_id_operaciones)) )   { 
              ob_start();
              $this->paginacion_ajax_proveedor(0);//
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);

              }  else  {
                redirect('');
              } 

          break;


        default:  
          redirect('');
          break;
      }
   }   
  
  }

  public function paginacion_ajax_proveedor($offset = 0)  {
        //hacemos la configuración de la librería jquery_pagination
        $config['base_url'] = base_url('catalogos/paginacion_ajax_proveedor/');  //controlador/funcion

        $config['div'] = '#paginacion';//asignamos un id al contendor general
        $config['anchor_class'] = 'page_link';//asignamos una clase a los links para maquetar
      $config['show_count'] = false;//en true queremos ver Viendo 1 a 10 de 52
        $config['per_page'] = 20;//-->número de proveedores por página
        $config['num_links'] = 4;//-->número de links visibles en el pie de la pagina

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
        $config['total_rows'] = $this->catalogo->total_proveedores(); 
 
        //inicializamos la librería
        $this->jquery_pagination->initialize($config); 

        
     //'(LOCATE("3", p.coleccion_id_actividad) >0)'   

                      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
                      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                            $coleccion_id_operaciones = array();
                       }   

                      $identificador ='';
                      if   (in_array(14, $coleccion_id_operaciones))    { 
                          $identificador .='(LOCATE("1", p.coleccion_id_actividad) >0)';
                      }  

                      if   (in_array(15, $coleccion_id_operaciones))    { 
                        if ($identificador!='') {$identificador.=' OR '; }
                         $identificador .='(LOCATE("2", p.coleccion_id_actividad) >0)';
                      }  
                       
                      if   (in_array(16, $coleccion_id_operaciones))    { 
                         if ($identificador!='') {$identificador.=' OR '; }
                             $identificador .='(LOCATE("3", p.coleccion_id_actividad) >0)';
                       }   
                      

    $data['proveedores']  = $this->catalogo->listado_proveedores($config['per_page'], $offset,$identificador);
    $data['actividades']  = $this->catalogo->listado_actividades();

    $html = $this->load->view( 'catalogos/proveedores',$data ,true);

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

    // crear
  function nuevo_proveedor(){

    if($this->session->userdata('session') === TRUE ){
          $id_perfil=$this->session->userdata('id_perfil');
          

          $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
          if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                $coleccion_id_operaciones = array();
           }   

           $data['actividades']  = $this->catalogo->listado_actividades();
          switch ($id_perfil) {    
            case 1:
                
                $this->load->view( 'catalogos/proveedores/nuevo_proveedor',$data);
              break;
            case 2:
            case 3:
                 if   ((in_array(8, $coleccion_id_operaciones))  || (in_array(14, $coleccion_id_operaciones))  
                      || (in_array(15, $coleccion_id_operaciones)) || (in_array(16, $coleccion_id_operaciones)) )   { 
                    
                      
                      $identificador ='';
                      if   (in_array(14, $coleccion_id_operaciones))    { 
                          $identificador .='(a.id=1)';
                      }  

                      if   (in_array(15, $coleccion_id_operaciones))    { 
                        if ($identificador!='') {$identificador.=' OR '; }
                         $identificador .='(a.id=2)';
                      }  
                       
                      if   (in_array(16, $coleccion_id_operaciones))    { 
                         if ($identificador!='') {$identificador.=' OR '; }
                             $identificador .='(a.id=3)';
                       }   
                      
                      if   (!(in_array(8, $coleccion_id_operaciones)))    { 

                        $data['actividades']  = $this->catalogo->listado_actividades(-1,-1, $identificador);                
                      }  


                    $this->load->view( 'catalogos/proveedores/nuevo_proveedor',$data);
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

  function validar_nuevo_proveedor(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {

      $this->form_validation->set_rules( 'codigo', 'Código', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
      $this->form_validation->set_rules( 'nombre', 'Nombre', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
      $this->form_validation->set_rules( 'telefono', 'Télefono', 'trim|min_length[3]|max_lenght[180]|xss_clean');
      $this->form_validation->set_rules( 'direccion', 'Domicilio', 'trim|min_length[3]|max_lenght[180]|xss_clean');

      if ($this->form_validation->run() === TRUE){

          $data['codigo']                   = $this->input->post('codigo');
          $data['nombre']                   = $this->input->post('nombre');
          $data['telefono']                 = $this->input->post('telefono');
          $data['direccion']                = $this->input->post('direccion');
          $data['coleccion_id_actividad']   = json_encode($this->input->post('coleccion_id_actividad'));

          $data         =   $this->security->xss_clean($data);  

          $existe            = $this->catalogo->check_existente_proveedor( $data );

          if ( $existe !== TRUE ){  
            $guardar            = $this->catalogo->anadir_proveedor( $data );
            if ( $guardar !== FALSE ){
              echo true;
            } else {
              echo '<span class="error"><b>E01</b> - El nuevo proveedor no pudo ser agregado</span>';
            }
          } else {
              echo '<span class="error"><b>E01</b> - El nuevo proveedor ya se encuentra agregado</span>';
           }

      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }

  // editar
  function editar_proveedor( $codigo = '' ){

    if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      $data['codigo_ant']  = $codigo;
      $data['codigo']  = $codigo;
        $data['actividades']  = $this->catalogo->listado_actividades();
        $data['proveedor']  = $this->catalogo->coger_proveedor($data);

      switch ($id_perfil) {    
        case 1:
              if ( $data['proveedor'] !== FALSE ){
                  $this->load->view( 'catalogos/proveedores/editar_proveedor', $data );
              } else {
                    redirect('');
              }       


          break;
        case 2:
        case 3:
                 if   ((in_array(8, $coleccion_id_operaciones))  || (in_array(14, $coleccion_id_operaciones))  
                      || (in_array(15, $coleccion_id_operaciones)) || (in_array(16, $coleccion_id_operaciones)) )   { 

                    $this->load->view( 'catalogos/proveedores/editar_proveedor', $data );
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


function validacion_edicion_proveedor(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {

        $this->form_validation->set_rules( 'codigo', 'Código', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
        $this->form_validation->set_rules( 'nombre', 'Nombre', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
        $this->form_validation->set_rules( 'telefono', 'Télefono', 'trim|min_length[3]|max_lenght[180]|xss_clean');
        $this->form_validation->set_rules( 'direccion', 'Domicilio', 'trim|min_length[3]|max_lenght[180]|xss_clean');

      if ($this->form_validation->run() === TRUE){

          $data['codigo_ant']    = $this->input->post('codigo_ant');  
          $data['codigo']                   = $this->input->post('codigo');
          $data['nombre']                   = $this->input->post('nombre');
          $data['telefono']                 = $this->input->post('telefono');
          $data['direccion']                = $this->input->post('direccion');
          $data['coleccion_id_actividad']   = json_encode($this->input->post('coleccion_id_actividad'));


          $data              =  $this->security->xss_clean($data);  
          $existe            =  $this->catalogo->check_existente_proveedor( $data );
        if ( $existe !== TRUE ){  
            $guardar                 =   $this->catalogo->editar_proveedor( $data );
            if ( $guardar !== FALSE ){
              echo true;

            } else {
              echo '<span class="error"><b>E01</b> - El nuevo proveedor no pudo ser agregado</span>';
            }
        } else {
              echo '<span class="error"><b>E01</b> - El proveedor ya se encuentra agregado</span>';
        }           
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }
  

  // eliminar


  function eliminar_proveedor($codigo = '', $nombrecompleto=''){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      $data['nombrecompleto']   = base64_decode($nombrecompleto);
      $data['codigo']         = $codigo;
      
      switch ($id_perfil) {    
        case 1:            
                    $this->load->view( 'catalogos/proveedores/eliminar_proveedor', $data );
          break;
        case 2:
        case 3:
              if  ((in_array(8, $coleccion_id_operaciones))  || (in_array(14, $coleccion_id_operaciones))  
              || (in_array(15, $coleccion_id_operaciones)) || (in_array(16, $coleccion_id_operaciones)) )   { 
                        $this->load->view( 'catalogos/proveedores/eliminar_proveedor', $data );
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


  function validar_eliminar_proveedor(){
    if (!empty($_POST['codigo'])){ 
      $data['codigo'] = $_POST['codigo'];
    }
    $eliminado = $this->catalogo->eliminar_proveedor(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la proveedor</span>';
    }
  } 




//***********************productos**********************************//

  public function listado_productos(){
  if ( $this->session->userdata('session') !== TRUE ) {
      redirect('login');
    } else {
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   



      switch ($id_perfil) {    
        case 1:

              ob_start();
              $this->paginacion_ajax_producto(0); //
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);

            
          break;
        case 2:
        case 3:
             if  ((in_array(8, $coleccion_id_operaciones))  || (in_array(11, $coleccion_id_operaciones)))   { 
              ob_start();
              $this->paginacion_ajax_producto(0);//
              $initial_content = ob_get_contents();
              ob_end_clean();    
              $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
              $this->load->view( 'paginacion/paginacion',$data);

              }  else  {
                redirect('');
              } 

          break;


        default:  
          redirect('');
          break;
      }
   }     
  }

  public function paginacion_ajax_producto($offset = 0)  {
        //hacemos la configuración de la librería jquery_pagination
        $config['base_url'] = base_url('catalogos/paginacion_ajax_producto/');  //controlador/funcion

        $config['div'] = '#paginacion';//asignamos un id al contendor general
        $config['anchor_class'] = 'page_link';//asignamos una clase a los links para maquetar
      $config['show_count'] = false;//en true queremos ver Viendo 1 a 10 de 52
        $config['per_page'] = 20;//-->número de productos por página
        $config['num_links'] = 4;//-->número de links visibles en el pie de la pagina

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
        $config['total_rows'] = $this->catalogo->total_productos(); 
 
        //inicializamos la librería
        $this->jquery_pagination->initialize($config); 

    $data['productos']  = $this->catalogo->listado_productos($config['per_page'], $offset);
    $html = $this->load->view( 'catalogos/productos',$data ,true);

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

    // crear
  function nuevo_producto(){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      $data['colores'] =  $this->catalogo->listado_colores(  );
      $data['composiciones'] =  $this->catalogo->listado_composiciones(  );
      $data['calidades'] =  $this->catalogo->listado_calidades();

      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'catalogos/productos/nuevo_producto',$data);
          break;
        case 2:
        case 3:
             if  ((in_array(8, $coleccion_id_operaciones))  || (in_array(11, $coleccion_id_operaciones)))   { 
                $this->load->view( 'catalogos/productos/nuevo_producto',$data);
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

  function validar_nuevo_producto(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {

      $this->form_validation->set_rules( 'descripcion', 'Descripción', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
      $this->form_validation->set_rules( 'comentario', 'Comentario', 'trim|min_length[3]|max_lenght[180]|xss_clean');             
      $this->form_validation->set_rules( 'minimo', 'Minimo',  'required|callback_valid_cero|xss_clean');   
      $this->form_validation->set_rules( 'precio', 'Precio', 'required|callback_importe_valido|xss_clean');   
      $this->form_validation->set_rules( 'ancho', 'Ancho', 'required|callback_importe_valido|xss_clean');   

      if ($this->form_validation->run() === TRUE){

          //IMPR-AAAAMMDD-ABCD123
          $data['referencia']    =  date('Y').date('m').date('d').random_string('alpha',4).random_string('numeric',3);                
          $data['descripcion']    = $this->input->post('descripcion'); 

          $data['id_composicion']    = $this->input->post('id_composicion'); 
          $data['id_color']    = $this->input->post('id_color'); 


          $data         =   $this->security->xss_clean($data);  
          $existe            = $this->catalogo->check_existente_producto( $data );
          if ( $existe !== TRUE ){
          //if ( TRUE ){


          $config_adjunto['upload_path']    = './uploads/productos/';
          $config_adjunto['allowed_types']  = 'jpg|png|gif|jpeg';
          $config_adjunto['max_size']     = '20480';
          $config_adjunto['file_name']    = 'img_'.$data['referencia'];
          $config_adjunto['overwrite']    = true;

          $this->load->library('upload', $config_adjunto);

          $this->upload->do_upload('archivo_imagen'); 
          $errors = $this->upload->display_errors();


          // if (!(($errors=='') || ($errors=='<p>No ha seleccionado ningún archivo para subir</p>'))) {
          //   echo $this->upload->display_errors('<span class="error">', '</span>');
          //Si la carga del archivo genera algun error
          if ( $errors!='' ) {

            echo $this->upload->display_errors('<span class="error">', '</span>');
            
          } else {

            if ($errors=='') {
              $data['archivo_imagen'] = $this->upload->data();
            } 


               //este es el thumbnail 
               $config2 = array(
                  'image_library' => 'GD',
                  'source_image' => $data['archivo_imagen']['full_path'],
                  'new_image' => './uploads/productos/thumbnail/',
                  'create_thumb' => TRUE,
                  'maintain_ratio' => TRUE,
                  'width' => 50,
                  'height' => 50
                );


                $this->load->library('image_lib', $config2);
                $this->image_lib->resize();
                //http://svn.valueretail.com/COS_NEWSLETTERS/trunk/framework/libraries/Image_lib.php
                //$data['archivo_thumbnail']= $this->image_lib->full_dst_path;
                //print_r($data['archivo_thumbnail']);
               // die;




                $data['minimo']    = $this->input->post('minimo'); 
                $data['precio']    = $this->input->post('precio'); 
                $data['ancho']    = $this->input->post('ancho'); 
                $data['id_composicion']    = $this->input->post('id_composicion'); 
                $data['id_calidad']    = $this->input->post('id_calidad'); 
                $data['comentario']    = $this->input->post('comentario'); 


                $guardar            = $this->catalogo->anadir_producto( $data );
                if ( $guardar !== FALSE ){
                  echo true;
                } else {
                  echo '<span class="error"><b>E01</b> - El nuevo producto no pudo ser agregado</span>';
                }

          }      

          } else {
              //echo '<span class="error"><b>E01</b> - El nuevo producto ya se encuentra agregado</span>';
            echo '<span class="error"><b>E01</b> - El nuevo producto ya se encuentra agregado con (nombre, color y composición)</span>';
            }

      } else {      
         //echo '<span class="error"><b>E01</b> - El nuevo producto ya se encuentra agregado con (nombre, color y composición)</span>';
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }


  // editar
  function editar_producto( $id = '' ){
    if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      $data['id_ant']  =  base64_decode($id);
      $data['id']  =  base64_decode($id);
      $data['colores'] =  $this->catalogo->listado_colores(  );
      $data['composiciones'] =  $this->catalogo->listado_composiciones();
      $data['calidades'] =  $this->catalogo->listado_calidades();
      $data['tabla'] = "catalogo_productos";
      $data['total_archivos']  = $this->catalogo->total_archivos( $data );

      switch ($id_perfil) {    
        case 1:
              $data['producto']  = $this->catalogo->coger_producto($data);
              if ( $data['producto'] !== FALSE ){
                  $this->load->view( 'catalogos/productos/editar_producto', $data );
              } else {
                    redirect('');
              }       


          break;
        case 2:
        case 3:
              if  ((in_array(8, $coleccion_id_operaciones))  || (in_array(11, $coleccion_id_operaciones)))  { 
                $data['producto']  = $this->catalogo->coger_producto($data);
                if ( $data['producto'] !== FALSE ){
                    $this->load->view( 'catalogos/productos/editar_producto', $data );
                } else {
                      redirect('');
                }       

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


function validacion_edicion_producto(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {

      $this->form_validation->set_rules( 'descripcion', 'Descripción', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
      $this->form_validation->set_rules( 'comentario', 'Comentario', 'trim|min_length[3]|max_lenght[180]|xss_clean');             
      $this->form_validation->set_rules( 'minimo', 'Minimo',  'required|callback_valid_cero|xss_clean');      
      $this->form_validation->set_rules( 'precio', 'Precio', 'required|callback_importe_valido|xss_clean');   
      $this->form_validation->set_rules( 'ancho', 'Ancho', 'required|callback_importe_valido|xss_clean');   

      if ($this->form_validation->run() === TRUE){
          
          //IMPR-AAAAMMDD-ABCD123
            $data['id']    =  $this->input->post('id'); 
            $data['referencia']    =  $this->input->post('referencia'); 
            $data['descripcion']    = $this->input->post('descripcion'); 


            $config_adjunto['upload_path']    = './uploads/productos/';
            $config_adjunto['allowed_types']  = 'jpg|png|gif|jpeg';
            $config_adjunto['max_size']     = '20480';
            $config_adjunto['file_name']    = 'img_'.$data['referencia'];
            $config_adjunto['overwrite']    = true;             

            $this->load->library('upload', $config_adjunto);

            $this->upload->do_upload('archivo_imagen'); 
            $errors = $this->upload->display_errors();


            if (!(($errors=='') || ($errors=='<p>No ha seleccionado ningún archivo para subir</p>'))) {
              echo $this->upload->display_errors('<span class="error">', '</span>');
            } else {
                if ($errors=='') {
                  $data['archivo_imagen'] = $this->upload->data();
                } 

                if  (isset($data['archivo_imagen'])) {
                   //este es el thumbnail 
                   $config2 = array(
                      'image_library' => 'GD',
                      'source_image' => $data['archivo_imagen']['full_path'],
                      'new_image' => './uploads/productos/thumbnail/',
                      'create_thumb' => TRUE,
                      'maintain_ratio' => TRUE,
                      'width' => 250,
                      'height' => 250
                    );
                    $this->load->library('image_lib', $config2);
                    $this->image_lib->resize();
                }    


                $data['minimo']    = $this->input->post('minimo'); 
                $data['id_composicion']    = $this->input->post('id_composicion'); 
                $data['id_color']    = $this->input->post('id_color'); 
                $data['precio']    = $this->input->post('precio'); 
                $data['ancho']    = $this->input->post('ancho'); 
                $data['id_composicion']    = $this->input->post('id_composicion'); 
                $data['id_calidad']    = $this->input->post('id_calidad'); 
                $data['comentario']    = $this->input->post('comentario'); 


                $data               = $this->security->xss_clean($data);  
                $guardar            = $this->catalogo->editar_producto( $data );
                if ( $guardar !== FALSE ){
                  echo true;

                } else {
                  echo '<span class="error"><b>E01</b> - El nuevo producto no pudo ser agregado</span>';
                }


            } 
        
        } else {      
          echo validation_errors('<span class="error">','</span>');
        }        
   }
 } 
  

  // eliminar


  function eliminar_producto($id = '', $nombrecompleto=''){
     if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      $data['nombrecompleto']   = base64_decode($nombrecompleto);
      $data['id']         = $id;
      
      switch ($id_perfil) {    
        case 1:            
                    $this->load->view( 'catalogos/productos/eliminar_producto', $data );
          break;
        case 2:
        case 3:
              if  ((in_array(8, $coleccion_id_operaciones))  || (in_array(11, $coleccion_id_operaciones)))  {                 
                        $this->load->view( 'catalogos/productos/eliminar_producto', $data );
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


  function validar_eliminar_producto(){
    if (!empty($_POST['id'])){ 
      $data['id'] = $this->input->post('id'); 
    }
    $eliminado = $this->catalogo->eliminar_producto(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la producto</span>';
    }
  } 



///cambiar precio del producto



  // editar
  function cambiar_producto( $id = '' ){
    if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

      $data['id_ant']  =  base64_decode($id);
      $data['id']  =  base64_decode($id);
      $data['colores'] =  $this->catalogo->listado_colores(  );
      $data['composiciones'] =  $this->catalogo->listado_composiciones();
      $data['calidades'] =  $this->catalogo->listado_calidades();
      $data['tabla'] = "catalogo_productos";
      $data['total_archivos']  = $this->catalogo->total_archivos( $data );

      switch ($id_perfil) {    
        case 1:
              $data['producto']  = $this->catalogo->coger_producto($data);
              if ( $data['producto'] !== FALSE ){
                  $this->load->view( 'catalogos/productos/cambiar_precio', $data );
              } else {
                    redirect('');
              }       


          break;
        case 2:
        case 3:
              if  ((in_array(8, $coleccion_id_operaciones))  || (in_array(11, $coleccion_id_operaciones)))  { 
                $data['producto']  = $this->catalogo->coger_producto($data);
                if ( $data['producto'] !== FALSE ){
                    $this->load->view( 'catalogos/productos/cambiar_precio', $data );
                } else {
                      redirect('');
                }       

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


function validacion_cambio_producto(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {

      $this->form_validation->set_rules( 'precio', 'Precio', 'required|callback_importe_valido|xss_clean');   

      if ($this->form_validation->run() === TRUE){

                $data['id']    =  $this->input->post('id'); 
                $data['referencia']    =  $this->input->post('referencia'); 
                $data['comentario']    = $this->input->post('comentario'); 
                $data['precio']    = $this->input->post('precio'); 

                $data               = $this->security->xss_clean($data);  
                $guardar            = $this->catalogo->cambiar_precio_producto( $data );

                if ( $guardar !== FALSE ){
                  echo true;

                } else {
                  echo '<span class="error"><b>E01</b> - El nuevo producto no pudo ser agregado</span>';
                }

    
        } else {      
          echo validation_errors('<span class="error">','</span>');
        }        
   }
 }   





////////////////////////Modales de catalogos (boton +)/////////////////



function catalogo_modal($catalogo, $uri){

  if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

        $data['catalogo']   = $catalogo;
        $data['uri']    = $uri;
        switch (base64_decode($data['catalogo'])) {
            case "color":
                    $data['hexadecimal_color']   = 'hexadecimal_color';
                break;
        } 
      
      switch ($id_perfil) {    
        case 1:            
                    $this->load->view( 'catalogos/modal/catalogo_modal', $data );
          break;
        case 2:
        case 3:
              if  (in_array(8, $coleccion_id_operaciones))  {                 
                        $this->load->view( 'catalogos/modal/catalogo_modal', $data );
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


  function validar_catalogo_modal(){

  if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {

      $data['catalogo'] = base64_decode($this->input->post('catalogo')); 
      $catal = $data['catalogo'];

        $this->form_validation->set_rules( $catal, 'Descripción de '.$catal, 'trim|required|min_length[3]|max_lenght[80]|xss_clean');
        
        //para el caso de que el catalogo sea color eva
        if ($data['catalogo']=='color') {
            $this->form_validation->set_rules('hexadecimal_color', 'Color', 'trim|required|min_lenght[3]|max_length[6]|xss_clean');
        }

      if ($this->form_validation->run() === TRUE){
          $data[$catal]   = $this->input->post($catal);
          $data         =   $this->security->xss_clean($data); 

          switch ($data['catalogo']) {
              case "color":
                  $data['hexadecimal_color']         = $this->input->post('hexadecimal_color');
                  $guardar              = $this->catalogo->anadir_color( $data );
                  $elementos            = $this->catalogo->listado_colores();
                  $identificador        = 'id_color';
                  break;
              case "composicion":
                   $guardar             = $this->catalogo->anadir_composicion( $data );
                   $elementos           = $this->catalogo->listado_composiciones(); 
                   $identificador       = 'id_composicion'; //id_entidad(unidad)
                  break;
              case "calidad":
                  $guardar            = $this->catalogo->anadir_calidad( $data );
                  $elementos          = $this->catalogo->listado_calidades(); 
                  $identificador      = 'id_calidad';
                  break;
          }         

          
          if ( $guardar !== FALSE ){
            

              $variables = array();
              $todo = array();

               foreach( $elementos as $clave =>$valor ) {

                switch ($data['catalogo']) {
                    case "color":
                      array_push($variables, array('nombre' => $valor->color, 'identificador' => $valor->id)); 
                        break;
                    case "composicion":
                      array_push($variables, array('nombre' => $valor->composicion, 'identificador' => $valor->id)); 
                        break;
                    case "calidad":
                      array_push($variables, array('nombre' => $valor->calidad, 'identificador' => $valor->id)); 
                        break;
                }                 
                    
             }

              $todo = array (
                "estado" => array('exito' => true),
                "dato"  => array('valor'=> $data[$catal], 'catalogo' => $catal, 'identificador' =>  $identificador),
                "catalogo"   => $variables
            );              
             
             echo json_encode($todo);           
             

          } else {
              $todo = array (
                "estado" => array('exito' => false),
                "fallo"  => array('mensaje' => '<span class="error"><b>E01</b> - La nueva $catal no pudo ser agregado</span>'),
            );              
            echo json_encode($todo);            
            //die;  
             
          }
      } else {      
              $todo = array (
                "estado" => array('exito' => false),
                "fallo"  => array('mensaje' => validation_errors('<span class="error">','</span>')),
            );              
            echo json_encode($todo);            

        //echo validation_errors('<span class="error">','</span>');
      }
    }
  }

////////////////////////Fin de Modales de catalogos (boton +)/////////////////

/////////////////validaciones/////////////////////////////////////////  


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
      $this->form_validation->set_message('valid_date', '<b class="requerido">*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD-MM-YYYY.');
      return FALSE;
    }
  }

  public function valid_email($str)
  {
    return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
  } 


}

/* End of file nucleo.php */
/* Location: ./app/controllers/nucleo.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inventario extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('model_pedido', 'modelo_pedido');
    $this->load->model('catalogo', 'catalogo');  
    $this->load->model('model_entradas', 'model_entrada');  
    $this->load->model('model_salida', 'modelo_salida'); 
    $this->load->library(array('email')); 
    $this->load->library('Jquery_pagination');//-->la estrella del equipo 
  }

//////////////////comienzo de tratamiento de dependencia///////////////////////////

  //Filtro La lista que es dependiente a un elemento padre
  function cargar_dependencia(){
    
    $data['campo']        = $this->input->post('campo');

    $data['val_prod']        = $this->input->post('val_prod');
    $data['val_color']        = $this->input->post('val_color');
    $data['val_comp']        = $this->input->post('val_comp');
    $data['val_calida']        = $this->input->post('val_calida');

    $data['dependencia']        = $this->input->post('dependencia');

    switch ($data['dependencia']) {
        case "producto": //nunca será una dependencia
            $elementos  = $this->catalogo->listado_productos();
            break;
        case "color":
            $elementos  = $this->catalogo->lista_colores($data);
            break;

        case "composicion":
            $elementos  = $this->catalogo->lista_composiciones($data);
            break;
        case "calidad":
            $elementos  = $this->catalogo->lista_calidad($data);
            break;

        default:
    }



      $variables = array();
    if ($elementos != false)  {     
         foreach( (json_decode(json_encode($elementos))) as $clave =>$valor ) {
              array_push($variables,array('nombre' => $valor->nombre, 'identificador' => $valor->id)); 
       }
    }  

     echo json_encode($variables);
  }


//////////////////fin de tratamiento de dependencia///////////////////////////

//*********************** Pagina de editar **********************************//
 public function editar_inventario(){

     if($this->session->userdata('session') === TRUE ){
          $id_perfil=$this->session->userdata('id_perfil');

          $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
          if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                $coleccion_id_operaciones = array();
           }   
              $data['medidas']  = $this->catalogo->listado_medidas();
              $data['estatuss']  = $this->catalogo->listado_estatus(-1,-1,'1');
              $data['lotes']  = $this->catalogo->listado_lotes(-1,-1,'1');

              $data['productos'] = $this->catalogo->listado_productos();

          switch ($id_perfil) {    
            case 1:          

                        $this->load->view( 'editar_inventario/editar',$data );
              break;
            case 2:
            case 3:
                  if  (in_array(3, $coleccion_id_operaciones))  {                 
                            $this->load->view( 'editar_inventario/editar',$data );
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



   //esto es para agregar los productos a temporal
  function validar_impresion(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {

     $codigo= '<span class="error"><b>E01</b> - Debe especificar un correcto código de producto</span>';
     if ($this->input->post('codigo')) {
        $codigo =  $this->catalogo->check_existente_codigo($this->input->post('codigo'));
        if ($codigo == false) {
           $codigo = '<span class="error"><b>E01</b> - Debe especificar un correcto código de producto</span>';
        } else 
        {
          $codigo = true;
        }
        
     }
     echo $codigo;

    }
  }




   //esto es para agregar los productos a temporal
  function validar_edicion_producto(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
  
      

     if ($this->input->post('editar_prod_inven')) {
        $data['codigo'] =  $this->catalogo->check_existente_codigo($this->input->post('editar_prod_inven'));
        if (!($data['codigo'])){
          print "el codigo no existe";
        }
       }


     if ($this->input->post('proveedor')) {
        $data['id_proveedor'] =  $this->catalogo->check_existente_proveedor_entrada($this->input->post('proveedor'));
        if (!($data['id_proveedor'])){
          print "el proveedor no existe";
        }
       }

      $this->form_validation->set_rules( 'editar_prod_inven', 'Código Producto', 'required|xss_clean'); //callback_valid_option| 

      $this->form_validation->set_rules( 'proveedor', 'Proveedor', 'required|xss_clean'); //callback_valid_option|
      $this->form_validation->set_rules( 'factura', 'Factura', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');

      $this->form_validation->set_rules( 'producto', 'Producto', 'required|xss_clean'); //callback_valid_option
      $this->form_validation->set_rules( 'color', 'Color', 'required|xss_clean'); 
      $this->form_validation->set_rules( 'composicion', 'Composición', 'required|xss_clean');
      $this->form_validation->set_rules( 'calidad', 'Calidad', 'required|xss_clean');
      
      $this->form_validation->set_rules( 'cantidad_um', 'Cantidad',  'required|callback_valid_cero|callback_importe_valido|xss_clean');
      $this->form_validation->set_rules( 'ancho', 'Ancho',  'required|callback_valid_cero|callback_importe_valido|xss_clean');
      $this->form_validation->set_rules( 'precio', 'Precio', 'required|callback_importe_valido|xss_clean');

      $this->form_validation->set_rules( 'comentario', 'Comentario', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');       

    //print_r($this->input->post('precio'));      

      if (($this->form_validation->run() === TRUE) and ($data['id_proveedor']) and ($data['codigo']) ) {
          
          $data['referencia']   = $this->input->post('referencia');

          $data['fecha_entrada']   = $this->input->post('fecha');
          $data['movimiento']   = $this->input->post('movimiento');
          
          $data['codigo']   = $data['codigo'];
          $data['id_empresa']   = $data['id_proveedor'];
          $data['factura']   = $this->input->post('factura');

          

          $data['id_descripcion']   = $this->input->post('producto');
          $data['id_color']   = $this->input->post('color');
          $data['id_composicion']   = $this->input->post('composicion');
          $data['id_calidad']   = $this->input->post('calidad');
          
          $data['cantidad_um']   = $this->input->post('cantidad_um');
          $data['id_medida']   = $this->input->post('id_medida');
          $data['ancho']   = $this->input->post('ancho');
          $data['precio']   = $this->input->post('precio');

          $data['comentario']   = $this->input->post('comentario');
          $data['id_lote']      = $this->input->post('id_lote');
          $data['id_estatus']   = $this->input->post('id_estatus');
          
          $data         =   $this->security->xss_clean($data);  
          
          $guardar            = $this->model_entrada->actualizar_producto_inventario( $data );
          if ( $guardar !== FALSE ){
            echo true;
          } else {
            echo '<span class="error"><b>E01</b> - El producto no pudo ser agregado</span>';
          }
      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }


  public function procesando_servidor_cambio(){
    $data=$_POST;
    $busqueda = $this->modelo_salida->buscador_cambio($data);
    echo $busqueda;
  }


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
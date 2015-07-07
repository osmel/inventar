<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Entradas extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('model_pedido', 'modelo_pedido');
		$this->load->model('catalogo', 'catalogo');  
		$this->load->model('model_entradas', 'model_entrada');  
		$this->load->library(array('email')); 
		$this->load->library('Jquery_pagination');//-->la estrella del equipo	
	}


//***********************Todos los recepciones**********************************//
	


	public function listado_entradas(){

		 if($this->session->userdata('session') === TRUE ){
		      $id_perfil=$this->session->userdata('id_perfil');

		      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
		      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
		            $coleccion_id_operaciones = array();
		       }   
		       	$data['medidas']  = $this->catalogo->listado_medidas();
		       	$data['estatuss']  = $this->catalogo->listado_estatus(-1,-1,'1');
		       	$data['lotes']  = $this->catalogo->listado_lotes(-1,-1,'1');

		       	$data['consecutivo']  = $this->catalogo->listado_consecutivo(1);
		       	$data['movimientos']  = $this->model_entrada->listado_movimientos_temporal();
		       	$data['val_proveedor']  = $this->model_entrada->valores_movimientos_temporal();
		       	$data['productos'] = $this->catalogo->listado_productos();
		       	
		      switch ($id_perfil) {    
		        case 1:          

		                    $this->load->view( 'entradas/entradas',$data );
		          break;
		        case 2:
		        case 3:
		              if  (in_array(1, $coleccion_id_operaciones))  {                 
		                        $this->load->view( 'entradas/entradas',$data );
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
  function validar_agregar_producto(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
 	
	 	 if ($this->input->post('editar_proveedor')) {
				$data['id_proveedor'] =  $this->catalogo->check_existente_proveedor_entrada($this->input->post('editar_proveedor'));
				if (!($data['id_proveedor'])){
					print "el proveedor no existe";
				}
	     }


      $this->form_validation->set_rules( 'editar_proveedor', 'Proveedor', 'required|xss_clean'); //callback_valid_option|
      $this->form_validation->set_rules( 'factura', 'Factura', 'trim|required|min_length[3]|max_lenght[180]|xss_clean');
      $this->form_validation->set_rules( 'producto', 'Producto', 'required|xss_clean'); //callback_valid_option
      $this->form_validation->set_rules( 'color', 'Color', 'required|xss_clean'); 
      $this->form_validation->set_rules( 'composicion', 'Composición', 'required|xss_clean');
      $this->form_validation->set_rules( 'calidad', 'Calidad', 'required|xss_clean');
      
      $this->form_validation->set_rules( 'cantidad_um', 'Cantidad',  'required|callback_valid_cero|callback_importe_valido|xss_clean');
      $this->form_validation->set_rules( 'cantidad_royo', 'Cantidad por Royo',  'required|callback_valid_cero|callback_importe_valido|xss_clean');
      $this->form_validation->set_rules( 'ancho', 'Ancho',  'required|callback_valid_cero|callback_importe_valido|xss_clean');


	  $this->form_validation->set_rules( 'precio', 'Precio', 'required|callback_importe_valido|xss_clean');

	  $this->form_validation->set_rules( 'comentario', 'Comentario', 'trim|min_length[3]|max_lenght[180]|xss_clean');       

	  //print_r($this->input->post('precio'));      

      if (($this->form_validation->run() === TRUE) and ($data['id_proveedor']) ) {
          
          $data['id_empresa']   = $data['id_proveedor'];
          $data['fecha']   = $this->input->post('fecha');
          $data['movimiento']   = $this->input->post('movimiento');
          $data['factura']   = $this->input->post('factura');


          $data['id_descripcion']   = $this->input->post('producto');
          $data['id_color']   = $this->input->post('color');
          $data['id_composicion']   = $this->input->post('composicion');
          $data['id_calidad']   = $this->input->post('calidad');
          $data['referencia']   = $this->input->post('referencia');

          $data['id_medida']   = $this->input->post('id_medida');

          $data['cantidad_um']   = $this->input->post('cantidad_um');
          $data['cantidad_royo']   = $this->input->post('cantidad_royo');
          $data['ancho']   = $this->input->post('ancho');
          $data['precio']   = $this->input->post('precio');
          $data['comentario']   = $this->input->post('comentario');

          $data['codigo']   = $this->input->post('codigo');
          $data['id_estatus']   = $this->input->post('id_estatus');

          $data['id_lote']   		= $this->input->post('id_lote');
          $data         =   $this->security->xss_clean($data);  
          $guardar            = $this->model_entrada->anadir_producto_temporal( $data );
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


	//1ra Regilla PARA "Pedidos de vendedores"
	public function procesando_productos_temporales(){
		$data=$_POST;
		$busqueda = $this->model_entrada->buscador_productos_temporales($data);
		echo $busqueda;
	}	

	public function eliminar_prod_temporal($id = '', $nombrecompleto=''){


    if ( $this->session->userdata('session') !== TRUE ) {
      redirect('');
    } else {
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
      }   

		$data['nombrecompleto'] 	= base64_decode($nombrecompleto);
		$data['id'] 				= $id;
 
      switch ($id_perfil) {    
        case 1:
				$this->load->view( 'entradas/temporales/eliminar_producto', $data );

          break;
        case 2:
        case 3:
             if  (in_array(1, $coleccion_id_operaciones))  { 

				$this->load->view( 'entradas/temporales/eliminar_producto', $data );
                 
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



	function validar_eliminar_prod_temporal(){
		if (!empty($_POST['id'])){ 
			$data['id'] = $_POST['id'];
		}

		$dato = $this->model_entrada->valores_reordenar($data );
		//print_r($dato);
		$eliminado = $this->model_entrada->eliminar_prod_temporal(  $data );
		$reordenar = $this->model_entrada->reordenar_prod_temporal( $dato );

		
		if ( $eliminado !== FALSE ){
			echo TRUE;
		} else {
			echo '<span class="error">No se ha podido eliminar la recepcion</span>';
		}
	}	


	function inf_ajax_temporal(){
		$data['color'] = $_POST['color'];
		$data['cant_royo'] = $_POST['cant_royo'];
		$data['referencia'] =$_POST['referencia'];
		$data['id_lote'] =$_POST['id_lote'];

		$data['total']  = $this->model_entrada->cant_producto_temporal($data);
		$data['movimientos']  = $this->model_entrada->listado_ajax($data);
		echo json_encode($data);
	}	







	public function procesar_entradas($id_movimiento=-1,$dev=0){

		 if($this->session->userdata('session') === TRUE ){
		      $id_perfil=$this->session->userdata('id_perfil');

		      $id_movimiento= base64_decode($id_movimiento);
		      $data['dev']= base64_decode($dev);
		      

		      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
		      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
		            $coleccion_id_operaciones = array();
		       }  

		      $existe = $this->model_entrada->existencia_temporales();
		     
		      if (($existe) or ($id_movimiento!=-1) ) {

		      		//ESTE ES PARA EL CASO QUE SE ESTA HACIENDO UNA "ENTRADA"
		      		if (($id_movimiento)==-1)	{
		      			$data['num_mov'] = $this->model_entrada->procesando_operacion(1);

				        $this->load->library('ciqrcode');
				        //hacemos configuraciones

						$data['movimientos']  = $this->model_entrada->listado_movimientos_registros($data);

				        
				        foreach ($data['movimientos'] as $key => $value) {
				          
					        $params['data'] = $value->codigo;
					        $params['level'] = 'H';
					        $params['size'] = 30;
					        $params['savename'] = FCPATH.'qr_code/'.$value->codigo.'.png';
					        $this->ciqrcode->generate($params);    
					      
				        }
				        
		      		} else { //ESTE ES PARA EL CASO EN QUE SE VA A LOS DETALLES DE UNA ENTRADA EN "REPORTES-->listado_notas"
		      			$data['num_mov'] = $id_movimiento;
						$data['retorno'] ="listado_notas";


		      		}



			      switch ($id_perfil) {    
			        case 1:          

						       
						       $data['movimientos']  = $this->model_entrada->listado_movimientos_registros($data);
			                   $this->load->view( 'pdfs/pdfs_view',$data );
			          break;
			        case 2:
			        case 3:
			              if  (in_array(1, $coleccion_id_operaciones))  {                 
						       
						       $data['movimientos']  = $this->model_entrada->listado_movimientos_registros($data);
			                   $this->load->view( 'pdfs/pdfs_view',$data );
			             }   
			          break;


			        default:  
			          redirect('');
			          break;
			      }
			  } else { 
		          redirect('entradas');
			  }  

			      
		    }
		    else{ 
		      redirect('');
		    }  
	}



/////////////////validaciones/////////////////////////////////////////	



	public function valid_cero($str)
	{
		
		 $regex = "/^([-0])*$/ix";
		if ( preg_match( $regex, $str ) ){			
			$this->form_validation->set_message( 'valid_cero','<b class="requerido">*</b> El <b>%s</b> no puede ser cero.' );
			return FALSE;
		} else {
			return TRUE;
		}

	}
	

	function importe_valido( $str ){
		 
		if ((trim($str)=="") || (empty($str)) ) {
			$str = "";
			$regex = "/^$/";
		} else
		{
			//$regex =  '/^[-+]?(((\\\\d+)\\\\.?(\\\\d+)?)|\\\\.\\\\d+)([eE]?[+-]?\\\\d+)?$/'; 	
			$regex = "/^[+-]?(\d*\.?\d+([eE]?[+-]?\d+)?|\d+[eE][+-]?\d+)$/";
		}

		if ( ! preg_match( $regex, $str ) ){			
			$this->form_validation->set_message( 'importe_valido','<b class="">*</b> La información introducida en <b>%s</b> no es válida.' );
			return FALSE;
		} else {
			return TRUE;
		}
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
<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

	class model_entradas extends CI_Model {
		
		private $key_hash;
		private $timezone;

		function __construct(){

			parent::__construct();
			$this->load->database("default");
			$this->key_hash    = $_SERVER['HASH_ENCRYPT'];
			$this->timezone    = 'UM1';

      
				//usuarios
			$this->usuarios    = $this->db->dbprefix('usuarios');
				//catalogos			
			$this->actividad_comercial     = $this->db->dbprefix('catalogo_actividad_comercial');
      
      $this->estratificacion_empresa = $this->db->dbprefix('catalogo_estratificacion_empresa');
      
      $this->productos               = $this->db->dbprefix('catalogo_productos');
      $this->proveedores             = $this->db->dbprefix('catalogo_empresas');
      $this->unidades_medidas        = $this->db->dbprefix('catalogo_unidades_medidas');

      $this->operaciones             = $this->db->dbprefix('catalogo_operaciones');
      $this->movimientos               = $this->db->dbprefix('movimientos');
      $this->registros_temporales               = $this->db->dbprefix('temporal_registros');
      $this->registros               = $this->db->dbprefix('registros_entradas');
      $this->registros_cambios               = $this->db->dbprefix('registros_cambios');

      $this->colores                 = $this->db->dbprefix('catalogo_colores');
      $this->unidades_medidas        = $this->db->dbprefix('catalogo_unidades_medidas');
      $this->historico_registros_entradas        = $this->db->dbprefix('historico_registros_entradas');

		}


        //****************este es para obtener proveedor y factura temporal************************************************************
        public function valores_movimientos_temporal(){

          $id_session = $this->session->userdata('id');
          
          $this->db->distinct();          
          $this->db->select('m.id, m.id_empresa, m.factura');
          $this->db->select('p.nombre');
          
          $this->db->from($this->registros_temporales.' as m');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_empresa','LEFT');

          $this->db->where('m.id_usuario',$id_session);
          $this->db->where('id_operacion',1);
           $result = $this->db->get();
        
            if ( $result->num_rows() > 0 )
               return $result->row();
            else
               return False;
            $result->free_result();
        }    

      
        //listado de la regilla
        public function listado_movimientos_temporal(){

          $id_session = $this->session->userdata('id');
                    
          $this->db->select('m.id, m.movimiento,m.id_empresa, m.factura, m.id_descripcion, m.id_operacion,m.devolucion');
          $this->db->select('m.id_color, m.id_composicion, m.id_calidad, m.referencia');
          $this->db->select('m.id_medida, m.cantidad_um, m.cantidad_royo, m.ancho, m.precio, m.codigo, m.comentario');
          $this->db->select('m.id_estatus, m.id_lote, m.consecutivo, m.id_cargador, m.id_usuario, m.fecha_mac fecha');

          $this->db->select('c.hexadecimal_color, u.medida,p.nombre');

          
          $this->db->from($this->registros_temporales.' as m');
          $this->db->join($this->colores.' As c' , 'c.id = m.id_color','LEFT');
          $this->db->join($this->unidades_medidas.' As u' , 'u.id = m.id_medida','LEFT');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_empresa','LEFT');

          $this->db->where('m.id_usuario',$id_session);
          $this->db->where('m.id_operacion',1);
          $this->db->order_by('m.id_lote', 'asc'); 
          $this->db->order_by('m.codigo', 'asc'); 
          $this->db->order_by('m.consecutivo', 'asc'); 

           $result = $this->db->get();
        
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }        




      //****************Añadir un producto a temporal************************************************************
        public function actualizar_producto_inventario( $data ){

              $id_session = $this->session->userdata('id');
              $fecha_hoy = date('Y-m-d H:i:s');  

              //registros de entradas
              $this->db->select('id id_entrada, fecha_entrada, fecha_salida, movimiento, id_empresa, factura, id_descripcion, id_color');
              $this->db->select('id_composicion, id_calidad, referencia, id_medida, cantidad_um, cantidad_royo, ancho, precio');
              $this->db->select('codigo, comentario, id_estatus, id_lote, consecutivo, id_cargador, id_usuario, id_usuario_salida');
              $this->db->select('fecha_mac, id_operacion, estatus_salida, id_apartado, id_usuario_apartado, id_cliente_apartado');
              $this->db->select('fecha_apartado, id_prorroga, fecha_vencimiento, consecutivo_cambio');

              $this->db->from($this->registros);

              $this->db->where('codigo',$data['codigo']);
              $result = $this->db->get();

              $objeto = $result->result();
              //copiar a tabla "registros_cambios"
              foreach ($objeto as $key => $value) {
                $this->db->insert($this->registros_cambios, $value); 
              }              

              ///
  
              $this->db->set( 'consecutivo_cambio', 'consecutivo_cambio+1', FALSE  );
              $this->db->set( 'id_usuario',  $id_session );
              $this->db->set( 'referencia', $data['referencia']);

              
              $this->db->set( 'fecha_entrada', $data['fecha_entrada']  );  
              $this->db->set( 'movimiento', $data['movimiento']);  
              

              $this->db->set( 'codigo', $data['codigo']   );
              $this->db->set( 'id_empresa',  $data['id_empresa'] );    
              $this->db->set( 'factura', $data['factura']   );  


              $this->db->set( 'id_descripcion', $data['id_descripcion']);  
              $this->db->set( 'id_color', $data['id_color']);  
              $this->db->set( 'id_composicion', $data['id_composicion']  );  
              $this->db->set( 'id_calidad', $data['id_calidad']   );  

              
              $this->db->set( 'cantidad_um', $data['cantidad_um']  );  
              $this->db->set( 'id_medida', $data['id_medida']  );  
              $this->db->set( 'ancho', $data['ancho']   );   
              $this->db->set( 'precio', $data['precio']  );  

              $this->db->set( 'comentario', $data['comentario']);  
              $this->db->set( 'id_lote', $data['id_lote']);     
              $this->db->set( 'id_estatus', $data['id_estatus']);

              $this->db->where('codigo',$data['codigo']);

              $this->db->update($this->registros);


            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }  




      //****************Añadir un producto a temporal************************************************************
        public function anadir_producto_temporal( $data ){

          $id_session = $this->session->userdata('id');
          $fecha_hoy = date('Y-m-d H:i:s');  

          $cant=0;

          $this->db->where('id_usuario',$id_session);
          $this->db->where('id_lote',$data['id_lote']);
          $this->db->where('referencia',$data['referencia']);
          $this->db->where('id_operacion',1);

          $this->db->from($this->registros_temporales);
          $cant = $this->db->count_all_results();          

          for ($i=(1+$cant); $i <= ($data['cantidad_royo']+$cant) ; $i++) { 

             
              $this->db->set( 'id_usuario',  $id_session );
              $this->db->set( 'id_empresa',  $data['id_empresa'] );    
              $this->db->set( 'fecha_entrada', $fecha_hoy  );  
              $this->db->set( 'movimiento', $data['movimiento']);  
              $this->db->set( 'factura', $data['factura']   );  


              $this->db->set( 'id_descripcion', $data['id_descripcion']);  
              $this->db->set( 'id_color', $data['id_color']);  
              $this->db->set( 'id_composicion', $data['id_composicion']  );  
              $this->db->set( 'id_calidad', $data['id_calidad']   );  
              $this->db->set( 'referencia', $data['referencia']   );  

              $this->db->set( 'id_medida', $data['id_medida']  );  

              $this->db->set( 'cantidad_um', $data['cantidad_um']  );  
              $this->db->set( 'cantidad_royo', $data['cantidad_royo']);  
              $this->db->set( 'ancho', $data['ancho']   );   
              $this->db->set( 'precio', $data['precio']  );  
              $this->db->set( 'comentario', $data['comentario']);  

              $this->db->set( 'codigo', $data['codigo'].'_'.$i   );
              $this->db->set( 'id_estatus', $data['id_estatus']);

              $this->db->set( 'id_lote', $data['id_lote']);     
              $this->db->set( 'consecutivo', $i);           //data['consecutivo']
              $this->db->set( 'id_operacion', 1);           //data['consecutivo']

              $this->db->where('id_usuario',$id_session);
              $this->db->where('id_lote',$data['id_lote']);
              $this->db->where('referencia',$data['referencia']);
              $this->db->where('id_operacion',1);  //esto significa que es entrada, 

              $this->db->insert($this->registros_temporales);
            
          }
          

            

            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }  





////////////////////////"http://inventarios.dev.com/pedidos"///////////////////////////////////////////////////////////////
    
    // 1ra regilla de "/pedidos"
      public function total_productos_temporales($where){

              $this->db->from($this->registros_temporales.' as m');
              $this->db->where($where);

              $result = $this->db->get();
              $cant = $result->num_rows();
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         

       }     

    public function buscador_productos_temporales($data){

          $cadena = $data['search']['value'];
          $inicio = $data['start'];
          $largo = $data['length'];

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];

      
          switch ($columa_order) {
                   case '1':
                        $columna = 'm.codigo';
                     break;
                   case '2':
                        $columna = 'm.id_descripcion';
                     break;
                   case '3':
                        $columna = 'c.hexadecimal_color';
                     break;
                   case '4':
                        $columna = 'm.cantidad_um, u.medida';
                     break;
                   case '5':
                        $columna = 'm.ancho';
                     break;
                   case '6':
                          $columna = 'p.nombre';
                     break;
                   case '7':
                        $columna = 'm.id_lote, m.consecutivo';
                     break;                     
                   
                   default:
                         $columna = 'm.codigo';
                     break;
                 }                 


                      
          
          $fecha_hoy =  date("Y-m-d h:ia"); 
          $hoy = new DateTime($fecha_hoy);

          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //

                    
          $this->db->select('m.id, m.movimiento,m.id_empresa, m.factura, m.id_descripcion, m.id_operacion');
          $this->db->select('m.id_color, m.id_composicion, m.id_calidad, m.referencia');
          $this->db->select('m.id_medida, m.cantidad_um, m.cantidad_royo, m.ancho, m.precio, m.codigo, m.comentario');
          $this->db->select('m.id_estatus, m.id_lote, m.consecutivo, m.id_cargador, m.id_usuario, m.fecha_mac fecha');
          $this->db->select('c.hexadecimal_color, u.medida,p.nombre');

          $this->db->from($this->registros_temporales.' as m');
          $this->db->join($this->colores.' As c' , 'c.id = m.id_color','LEFT');
          $this->db->join($this->unidades_medidas.' As u' , 'u.id = m.id_medida','LEFT');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_empresa','LEFT');
        
        
          //filtro de busqueda

          $where = '(
                      (
                        ( m.id_usuario = '.$id_session.' ) or ( m.id_operacion = 1 ) 
                      ) 
                      AND
                      (    
                          (m.codigo LIKE  "%'.$cadena.'%") OR ( m.id_descripcion LIKE  "%'.$cadena.'%" ) OR                    
                          (CONCAT(m.id_lote," - ",m.consecutivo) LIKE  "%'.$cadena.'%" ) OR 
                          (m.ancho LIKE  "%'.$cadena.'%") 
                       )   

            )';   

        // OR ( p.nombre  "%'.$cadena.'%" ) 
 


          $where_total = '( m.id_usuario = '.$id_session.' ) or ( m.id_operacion = 1 )  ';

          $this->db->where($where);

          //ordenacion
          $this->db->order_by($columna, $order); 

          //paginacion
          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);


                  foreach ($result->result() as $row) {
                            $dato[]= array(
                                      0=>$row->id,
                                      1=>$row->codigo,
                                      2=>$row->id_descripcion,
                                      3=>'<div style="background-color:#'.$row->hexadecimal_color.';display:block;width:15px;height:15px;margin:0 auto;"></div>',
                                      4=>$row->cantidad_um.' '.$row->medida,
                                      5=>$row->ancho.' cm', 
                                      6=>$row->nombre,
                                      7=>$row->id_lote.' - '.$row->consecutivo, 
                                      8=>$row->id_lote.' - '.$row->consecutivo, 
                                    );
                   }

                      

                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    =>intval( self::total_productos_temporales($where_total) ),  
                        "recordsFiltered" => $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => intval( self::total_productos_temporales($where_total) ),  
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           
      }  








     //reordenar http://mysql.conclase.net/curso/?sqlfun=SUBSTRING

      //****************conformar el listado por ajax  ************************************************************
      public function cant_producto_temporal( $data ){
          $id_session = $this->session->userdata('id');
          $cant=0;
          $this->db->where('id_usuario',$id_session);
          $this->db->where('id_lote',$data['id_lote']);
          $this->db->where('referencia',$data['referencia']);
          $this->db->where('id_operacion',1);

          $this->db->from($this->registros_temporales);
          $cant = $this->db->count_all_results(); 
        
            if ( $cant > 0 )
               return $cant;
            else
               return 0;

      }    


        //Este es para devolver valores para el listado por ajax
         public function listado_ajax($data){
            $id_session = $this->session->userdata('id');
            $this->db->select('m.id,m.id_lote,m.codigo');
            $this->db->select('c.hexadecimal_color');
            $this->db->select('m.id_descripcion,u.medida,m.cantidad_um,m.ancho,p.nombre,m.id_lote, m.consecutivo,');

            $this->db->from($this->registros_temporales.' as m');
            $this->db->join($this->colores.' As c' , 'c.id = m.id_color','LEFT');
            $this->db->join($this->unidades_medidas.' As u' , 'u.id = m.id_medida','LEFT');
            $this->db->join($this->proveedores.' As p' , 'p.id = m.id_empresa','LEFT');

            $this->db->where('m.id_usuario',$id_session);
            $this->db->where('id_lote',$data['id_lote']);
            $this->db->where('referencia',$data['referencia']);
            $this->db->where('id_operacion',1);

            $this->db->order_by('m.consecutivo', 'asc'); 

            $posicion=($data['total']-$data['cant_royo']);
            $this->db->limit($data['cant_royo'],$posicion); 
             $result = $this->db->get();
          
              if ( $result->num_rows() > 0 )
                 return $result->result();
              else
                 return False;
              $result->free_result();
        }     


        //****************eliminar producto temporal************************************************************


        public function eliminar_prod_temporal( $data ){
            $this->db->delete( $this->registros_temporales, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }


        //Este es para devolver valores para el listado por ajax
         public function valores_reordenar($data){

            $this->db->select('m.id,m.id_lote,m.codigo,m.referencia,m.consecutivo');
            $this->db->from($this->registros_temporales.' as m');

            $this->db->where('m.id',$data['id']);
            $this->db->where('m.id_operacion',1);

             $result = $this->db->get();
          
              if ( $result->num_rows() > 0 )
                 return $result->row();
              else
                 return False;
              $result->free_result();
        } 


        //reordenar el producto despues de eliminado http://mysql.conclase.net/curso/?sqlfun=SUBSTRING
        public function reordenar_prod_temporal( $data ){
            $id_session = $this->session->userdata('id');

            $this->db->set( 'codigo', 'CONCAT(mid(codigo, 1, LENGTH(codigo)-1),consecutivo-1)', FALSE  );

            $this->db->set( 'consecutivo', 'consecutivo-1', FALSE  );
            
            $this->db->where('consecutivo >', $data->consecutivo );
            $this->db->where('id_usuario',$id_session);
            $this->db->where('id_lote',$data->id_lote );
            $this->db->where('referencia',$data->referencia);
            $this->db->where('id_operacion',1);


            $this->db->update($this->registros_temporales);
     
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }



        //procesando operaciones
        public function procesando_operacion( $id_operacion ){

          $id_session = $this->session->userdata('id');
          $fecha_hoy = date('Y-m-d H:i:s');  
             
          $this->db->select('movimiento, id_empresa, factura, id_descripcion, id_color, id_composicion, id_calidad, referencia');
          $this->db->select('id_medida, cantidad_um, cantidad_royo, ancho, precio, codigo, comentario, id_estatus, id_lote, consecutivo');
          $this->db->select('id_cargador, id_usuario, fecha_mac, id_operacion');

          $this->db->select('"'.$fecha_hoy.'" AS fecha_entrada',false);
          
         
          $this->db->from($this->registros_temporales);

          $this->db->where('id_usuario',$id_session);
          $this->db->where('id_operacion',$id_operacion);

          $result = $this->db->get();


          $objeto = $result->result();
          //copiar a tabla "registros"
          foreach ($objeto as $key => $value) {
            $this->db->insert($this->registros, $value); 
            $this->db->insert($this->historico_registros_entradas, $value); 
            
            $num_movimiento = $value->movimiento;
          }

          //actualizar (consecutivo) en tabla "operacion" 
          $this->db->set( 'consecutivo', 'consecutivo+1', FALSE  );
          $this->db->set( 'id_usuario', $id_session );
          $this->db->where('id',1);
          $this->db->update($this->operaciones);

          //eliminar los registros en "temporal_registros"
          $this->db->delete($this->registros_temporales, array('id_usuario'=>$id_session,'id_operacion'=>$id_operacion)); 

          return $num_movimiento;

          $result->free_result();          

        }

        public function existencia_temporales(){
            
              $id_session = $this->session->userdata('id');
              $cant=0;

              $this->db->where('id_usuario',$id_session);
              $this->db->where('id_operacion',1);
              $this->db->from($this->registros_temporales);
              $cant = $this->db->count_all_results();          

              if ( $cant > 0 )
                 return true;
              else
                 return false;              

        }      

  

        //listado de movimiento de una entrada, de un movimiento especifico
        public function listado_movimientos_registros($data){

          $id_session = $this->session->userdata('id');
                    
          $this->db->select('m.id, m.movimiento,m.id_empresa, m.factura, m.id_descripcion, m.id_operacion,m.devolucion');
          $this->db->select('m.id_color, m.id_composicion, m.id_calidad, m.referencia');
          $this->db->select('m.id_medida, m.cantidad_um, m.cantidad_royo, m.ancho, m.precio, m.codigo, m.comentario');
          $this->db->select('m.id_estatus, m.id_lote, m.consecutivo, m.id_cargador, m.id_usuario, m.fecha_mac fecha');
          $this->db->select('DATE_FORMAT((m.fecha_mac),"%d-%m-%Y %H:%i") as fecha2', false);

          $this->db->select("( CASE WHEN m.devolucion <> 0 THEN 'red' ELSE 'black' END ) AS color_devolucion", FALSE);
          

          $this->db->select('c.hexadecimal_color, u.medida,p.nombre');

          
          $this->db->from($this->historico_registros_entradas.' as m');
          $this->db->join($this->colores.' As c' , 'c.id = m.id_color','LEFT');
          $this->db->join($this->unidades_medidas.' As u' , 'u.id = m.id_medida','LEFT');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_empresa','LEFT');

/*
                      AND
                      (    
                          (m.codigo LIKE  "%'.$cadena.'%") OR ( m.id_descripcion LIKE  "%'.$cadena.'%" ) OR                    
                          (CONCAT(m.id_lote," - ",m.consecutivo) LIKE  "%'.$cadena.'%" ) OR 
                          (m.ancho LIKE  "%'.$cadena.'%") 
                       )   



          //$this->db->where('m.id_usuario',$id_session);
         // $this->db->where('m.id_operacion',1);
          //$this->db->where('m.movimiento',$data['num_mov']);
*/
          //AND ( m.devolucion = 0 )
          $where = '(
                      (
                        ( m.devolucion = '.$data['dev'].' ) AND ( m.movimiento = '.$data['num_mov'].' ) AND ( m.id_operacion = 1 )
                      ) 

            )';   


          $this->db->where($where);



          $this->db->order_by('m.id_lote', 'asc'); 
          $this->db->order_by('m.codigo', 'asc'); 
          $this->db->order_by('m.consecutivo', 'asc'); 

           $result = $this->db->get();
        
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }        



          //listado de la regilla
        public function listado_movimientos_registros_old($data){

          $id_session = $this->session->userdata('id');
                    
          $this->db->select('m.id, m.movimiento,m.id_empresa, m.factura, m.id_descripcion, m.id_operacion,m.devolucion');
          $this->db->select('m.id_color, m.id_composicion, m.id_calidad, m.referencia');
          $this->db->select('m.id_medida, m.cantidad_um, m.cantidad_royo, m.ancho, m.precio, m.codigo, m.comentario');
          $this->db->select('m.id_estatus, m.id_lote, m.consecutivo, m.id_cargador, m.id_usuario, m.fecha_mac fecha');
          $this->db->select('DATE_FORMAT((m.fecha_mac),"%d-%m-%Y %H:%i") as fecha2', false);

          $this->db->select("( CASE WHEN m.devolucion <> 0 THEN 'red' ELSE 'black' END ) AS color_devolucion", FALSE);
          

          $this->db->select('c.hexadecimal_color, u.medida,p.nombre');

          
          $this->db->from($this->registros.' as m');
          $this->db->join($this->colores.' As c' , 'c.id = m.id_color','LEFT');
          $this->db->join($this->unidades_medidas.' As u' , 'u.id = m.id_medida','LEFT');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_empresa','LEFT');

          $this->db->where('m.id_usuario',$id_session);
          $this->db->where('m.id_operacion',1);
          $this->db->where('m.movimiento',$data['num_mov']);

          $this->db->order_by('m.id_lote', 'asc'); 
          $this->db->order_by('m.codigo', 'asc'); 
          $this->db->order_by('m.consecutivo', 'asc'); 

           $result = $this->db->get();
        
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }        





	} 


?>

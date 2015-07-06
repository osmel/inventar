<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

  class model_pedido extends CI_Model {
    
    private $key_hash;
    private $timezone;

    function __construct(){

      parent::__construct();
      $this->load->database("default");
      $this->key_hash    = $_SERVER['HASH_ENCRYPT'];
      $this->timezone    = 'UM1';

      date_default_timezone_set('America/Mexico_City'); 

      
        //usuarios
      $this->usuarios    = $this->db->dbprefix('usuarios');
        //catalogos     
      $this->actividad_comercial     = $this->db->dbprefix('catalogo_actividad_comercial');
      
      $this->estratificacion_empresa = $this->db->dbprefix('catalogo_estratificacion_empresa');
      
      $this->productos               = $this->db->dbprefix('catalogo_productos');
      $this->proveedores             = $this->db->dbprefix('catalogo_empresas');
      $this->cargadores             = $this->db->dbprefix('catalogo_cargador');
      $this->unidades_medidas        = $this->db->dbprefix('catalogo_unidades_medidas');

      $this->operaciones             = $this->db->dbprefix('catalogo_operaciones');
      $this->movimientos               = $this->db->dbprefix('movimientos');
      $this->registros_temporales               = $this->db->dbprefix('temporal_registros');
      $this->registros               = $this->db->dbprefix('registros_entradas');
      $this->registros_salidas       = $this->db->dbprefix('registros_salidas');

      $this->colores                 = $this->db->dbprefix('catalogo_colores');
      $this->unidades_medidas        = $this->db->dbprefix('catalogo_unidades_medidas');
      
      $this->historico_registros_entradas = $this->db->dbprefix('historico_registros_entradas');
      $this->historico_registros_salidas = $this->db->dbprefix('historico_registros_salidas');
      
      $this->composiciones     = $this->db->dbprefix('catalogo_composicion');
      $this->calidades                 = $this->db->dbprefix('catalogo_calidad');

      $this->registros_entradas               = $this->db->dbprefix('registros_entradas');
      $this->registros_cambios               = $this->db->dbprefix('registros_cambios');

    }



       

////////////////////////"http://inventarios.dev.com/generar_pedidos"///////////////////////////////////////////////////////////////

      //1ra regilla de "/generar_pedidos"
      public function total_pedido_home($where){
              $id_session = $this->session->userdata('id');

              $this->db->from($this->registros.' as m');

              $this->db->where($where);
              $cant = $this->db->count_all_results();          
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         
       }     



      public function buscador_entrada_pedido($data){

          $cadena = $data['search']['value'];
          $inicio = $data['start'];
          $largo = $data['length'];
          

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];

          switch ($columa_order) {
                   case '0':
                        $columna = 'm.codigo';
                     break;
                   case '1':
                        $columna = 'm.id_descripcion';
                     break;
                   case '2':
                        $columna = 'c.color';
                     break;
                   case '3':
                        $columna = 'm.cantidad_um';
                     break;
                   case '4':
                        $columna = 'm.ancho';
                     break;
                   case '5':
                        $columna = 'm.movimiento';
                     break;
                   case '6':
                              $columna= 'p.nombre';
                     break;
                   case '7':
                              $columna= 'm.id_lote, m.consecutivo';  
                     break;
                   
                   default:
                       $columna = 'm.codigo';
                     break;
                 }                 


          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //

          $this->db->select('m.id, m.movimiento,m.id_empresa, m.factura, m.id_descripcion, m.id_operacion');
          $this->db->select('m.id_color, m.id_composicion, m.id_calidad, m.referencia');
          $this->db->select('m.id_medida, m.cantidad_um, m.cantidad_royo, m.ancho, m.precio, m.codigo, m.comentario');
          $this->db->select('m.id_estatus, m.id_lote, m.consecutivo, m.id_cargador, m.id_usuario, m.fecha_mac fecha');

          $this->db->select('c.hexadecimal_color, c.color, u.medida,p.nombre, m.id_apartado');
         
          $this->db->from($this->registros.' as m');
          $this->db->join($this->colores.' As c' , 'c.id = m.id_color','LEFT');
          $this->db->join($this->unidades_medidas.' As u' , 'u.id = m.id_medida','LEFT');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_empresa','LEFT');
          $this->db->join($this->usuarios.' As us' , 'us.id = m.id_usuario_apartado','LEFT');
         
          //filtro de busqueda
        
          $where = '(
                      (
                         
                         (( m.id_apartado = 0 ) AND ( m.id_operacion = "1" ) AND ( m.estatus_salida = "0" ) )
                      ) 
                       AND

                      (
                        ( m.codigo LIKE  "%'.$cadena.'%" ) OR (m.id_descripcion LIKE  "%'.$cadena.'%") OR (c.color LIKE  "%'.$cadena.'%")  OR
                        ( CONCAT(m.cantidad_um," ",u.medida) LIKE  "%'.$cadena.'%" ) OR (CONCAT(m.ancho," cm") LIKE  "%'.$cadena.'%")  OR
                        ( m.movimiento LIKE  "%'.$cadena.'%" ) OR  
                        (p.nombre LIKE  "%'.$cadena.'%") OR  (CONCAT(m.id_lote,"-",m.consecutivo) LIKE  "%'.$cadena.'%")
                       )

            )';   


          $where_total = '( m.id_apartado = 0 ) AND ( m.id_operacion = "1" ) AND ( m.estatus_salida = "0" ) ';


  
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
                                      0=>$row->codigo,
                                      1=>$row->id_descripcion,
                                      2=>$row->color.
                                        '<div style="background-color:#'.$row->hexadecimal_color.';display:block;width:15px;height:15px;margin:0 auto;"></div>',
                                      3=>$row->cantidad_um.' '.$row->medida,
                                      4=>$row->ancho.' cm',
                                      5=>
                                           '<a style="  padding: 1px 0px 1px 0px;" href="'.base_url().'procesar_entradas/'.base64_encode($row->movimiento).'" 
                                               type="button" class="btn btn-success btn-block">'.$row->movimiento.'</a>', 
                                      6=>$row->nombre,
                                      7=>$row->id_lote.'-'.$row->consecutivo,
                                      8=>$row->id,
                                      9=>$row->id_apartado,
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_pedido_home($where_total) ), 
                        "recordsFiltered" => $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  //cuando este vacio la tabla que envie este
                //http://www.datatables.net/forums/discussion/21311/empty-ajax-response-wont-render-in-datatables-1-10
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           

      }  
      



//2da regilla de "/generar_pedidos"
 public function buscador_salida_pedido($data){

          $cadena = $data['search']['value'];
          $inicio = $data['start'];
          $largo = $data['length'];

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];

          switch ($columa_order) {
                   case '0':
                        $columna = 'm.codigo';
                     break;
                   case '1':
                        $columna = 'm.id_descripcion';
                     break;
                   case '2':
                        $columna = 'c.color';
                     break;
                   case '3':
                        $columna = 'm.cantidad_um';
                     break;
                   case '4':
                        $columna = 'm.ancho';
                     break;
                   case '5':
                        $columna = 'm.movimiento';
                     break;
                   case '6':
                              $columna= 'p.nombre';
                     break;
                   case '7':
                              $columna= 'm.id_lote, m.consecutivo';  
                     break;
                   
                   default:
                       $columna = 'm.codigo';
                     break;
                 }                 



          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //

          $this->db->select('m.id, m.movimiento,m.id_empresa, m.factura, m.id_descripcion, m.id_operacion');
          $this->db->select('m.id_color, m.id_composicion, m.id_calidad, m.referencia');
          $this->db->select('m.id_medida, m.cantidad_um, m.cantidad_royo, m.ancho, m.precio, m.codigo, m.comentario');
          $this->db->select('m.id_estatus, m.id_lote, m.consecutivo, m.id_cargador, m.id_usuario, m.fecha_mac fecha');

          $this->db->select('c.hexadecimal_color, c.color, u.medida,p.nombre, m.id_apartado');
         
          $this->db->from($this->registros.' as m');
          $this->db->join($this->colores.' As c' , 'c.id = m.id_color','LEFT');
          $this->db->join($this->unidades_medidas.' As u' , 'u.id = m.id_medida','LEFT');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_empresa','LEFT');
          $this->db->join($this->usuarios.' As us' , 'us.id = m.id_usuario_apartado','LEFT');
         
          //filtro de busqueda
        
          $where = '(
                      (
                         
                         (( m.id_apartado = 4 ) )
                      ) 
                       AND

                      (
                        ( m.codigo LIKE  "%'.$cadena.'%" ) OR (m.id_descripcion LIKE  "%'.$cadena.'%") OR (c.color LIKE  "%'.$cadena.'%")  OR
                        ( CONCAT(m.cantidad_um," ",u.medida) LIKE  "%'.$cadena.'%" ) OR (CONCAT(m.ancho," cm") LIKE  "%'.$cadena.'%")  OR
                        ( m.movimiento LIKE  "%'.$cadena.'%" ) OR  
                        (p.nombre LIKE  "%'.$cadena.'%") OR  (CONCAT(m.id_lote,"-",m.consecutivo) LIKE  "%'.$cadena.'%")
                       )

            )';   
          
          $where_total = '( m.id_apartado = 4 )'; 
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
                                      0=>$row->codigo,
                                      1=>$row->id_descripcion,
                                      2=>$row->color.
                                        '<div style="background-color:#'.$row->hexadecimal_color.';display:block;width:15px;height:15px;margin:0 auto;"></div>',
                                      3=>$row->cantidad_um.' '.$row->medida,
                                      4=>$row->ancho.' cm',
                                      5=>
                                           '<a style="  padding: 1px 0px 1px 0px;" href="'.base_url().'procesar_entradas/'.base64_encode($row->movimiento).'" 
                                               type="button" class="btn btn-success btn-block">'.$row->movimiento.'</a>', 
                                      6=>$row->nombre,
                                      7=>$row->id_lote.'-'.$row->consecutivo,
                                      8=>$row->id
                                    );
                      }

                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_pedido_home($where_total) ),  
                        "recordsFiltered" => $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
              }
              $result->free_result();    
      }  
      
   
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////"http://inventarios.dev.com/pedidos"///////////////////////////////////////////////////////////////
    
    // 1ra regilla de "/pedidos"
      public function total_apartados_pendientes($where){

              $this->db->from($this->registros.' as m');
              $this->db->where($where);
        
              $this->db->group_by("m.id_usuario_apartado, m.id_cliente_apartado");
              $result = $this->db->get();
              $cant = $result->num_rows();
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         

       }     

    public function buscador_apartados_pendientes($data){

          $cadena = $data['search']['value'];
          $inicio = $data['start'];
          $largo = $data['length'];

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];

          switch ($columa_order) {
                   case '0':
                        $columna = 'u.nombre, u.apellidos';
                     break;
                   case '1':
                        $columna = 'pr.nombre';
                     break;
                   case '2':
                        $columna = 'p.nombre';
                     break;
                   case '3':
                        $columna = 'm.fecha_apartado';
                     break;
                   case '4':
                        $columna = 'm.id_apartado';
                     break;
                   case '5':
                          $columna = 'm.fecha_vencimiento';
                     break;
                   
                   default:
                       $columna = 'u.nombre, u.apellidos';
                     break;
                 }                 

          
          $fecha_hoy =  date("Y-m-d h:ia"); 
          $hoy = new DateTime($fecha_hoy);

          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //

          $this->db->select('m.id_usuario_apartado, m.id_cliente_apartado,m.fecha_apartado,id_prorroga,m.fecha_vencimiento');  //fecha falta
          $this->db->select('p.nombre comprador ');  
          $this->db->select('CONCAT(u.nombre,"  ",u.apellidos) as vendedor', FALSE);
          $this->db->select('pr.nombre as dependencia', FALSE);

          $this->db->select('
                        CASE m.id_apartado
                          WHEN "1" THEN "Apartado Individual"
                           WHEN "2" THEN "Apartado Confirmado"
                           WHEN "3" THEN "Disponibilidad Salida"
                           ELSE "No Apartado"
                        END AS tipo_apartado
         ',False);          


          $this->db->select('
                        CASE m.id_apartado
                          WHEN "1" THEN "ab1d1d"
                           WHEN "2" THEN "f1a914"
                           WHEN "3" THEN "14b80f"
                           ELSE "No Apartado"
                        END AS color_apartado
         ',False);  

          
          $this->db->from($this->registros.' as m');
          $this->db->join($this->usuarios.' As u' , 'u.id = m.id_usuario_apartado','LEFT');
          $this->db->join($this->proveedores.' As pr', 'u.id_cliente = pr.id','LEFT');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_cliente_apartado','LEFT');
         
          //filtro de busqueda

          $where = '(
                      (
                        ( m.id_apartado = 2 ) or ( m.id_apartado = 3 ) 
                      ) 
                       AND
                      (
                        ( CONCAT(u.nombre," ",u.apellidos) LIKE  "%'.$cadena.'%" ) OR
                        ( pr.nombre LIKE  "%'.$cadena.'%" ) OR (p.nombre LIKE  "%'.$cadena.'%") OR
                        ((DATE_FORMAT((m.fecha_apartado),"%d-%m-%Y") ) LIKE  "%'.$cadena.'%") OR
                        ( "Apartado Individual" LIKE  "%'.$cadena.'%" ) OR
                        ( "Apartado Confirmado" LIKE  "%'.$cadena.'%" ) OR
                        ( "Disponibilidad Salida" LIKE  "%'.$cadena.'%" ) OR
                        ( "En proceso" LIKE  "%'.$cadena.'%" ) 
                       )
            )';   

          $where_total = '( m.id_apartado = 2 ) or ( m.id_apartado = 3 ) ';

          $this->db->where($where);
          $this->db->order_by($columna, $order); 
          $this->db->group_by("m.id_usuario_apartado, m.id_cliente_apartado");

          //ordenacion

          //paginacion
          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);


                  foreach ($result->result() as $row) {
                        $fecha_venc= date( 'd-m-Y h:ia', strtotime($row->fecha_vencimiento));
                        $actual = new DateTime($fecha_venc);
                        $diferencia_fecha =  date_diff($actual,$hoy);

                        if ($row->id_prorroga==0) {  
                          $mi_vencimiento =    $diferencia_fecha->format('%R%h hrs');
                        } else  
                        {
                          $mi_vencimiento = "En proceso";
                        } 


                            $dato[]= array(
                                      0=>$row->vendedor,
                                      1=>$row->dependencia,
                                      2=>$row->comprador,
                                      3=>date( 'd-m-Y', strtotime($row->fecha_apartado)),
                                      4=>$row->tipo_apartado.'<div style="margin-right: 15px;float:left;background-color:#'.$row->color_apartado.';width:15px;height:15px;"></div>',
                                      5=>$mi_vencimiento, //hora vencimiento


                                      6=>$row->id_usuario_apartado, 
                                      7=>$row->id_cliente_apartado,
                                      8=>$row->id_prorroga
                                    );
                      }


                      

                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_apartados_pendientes($where_total) ),  
                        "recordsFiltered" => $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => intval( self::total_apartados_pendientes($where_total) ),  
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           
      }  


 

 


    //2da regilla de "/pedidos"

      public function total_pedidos_pendientes($where){

              $this->db->from($this->registros.' as m');
              $this->db->where($where);
        
              $this->db->group_by("m.id_usuario_apartado, m.id_cliente_apartado");
              $result = $this->db->get();
              $cant = $result->num_rows();
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         

       }     

    public function buscador_pedidos_pendientes($data){

          $cadena = $data['search']['value'];
          $inicio = $data['start'];
          $largo = $data['length'];


          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];

          switch ($columa_order) {
                   case '0':
                        $columna = 'u.nombre, u.apellidos';
                     break;
                   case '1':
                        $columna = 'pr.nombre';
                     break;
                   case '2':
                        $columna = 'm.id_cliente_apartado';
                     break;
                   case '3':
                        $columna = 'm.fecha_apartado';
                     break;
                   case '4':
                        $columna = 'm.id_apartado';
                     break;
                   case '5':
                          $columna = 'm.fecha_vencimiento';
                     break;
                   
                   default:
                       $columna = 'u.nombre, u.apellidos';
                     break;
                 }                    

          $id_session = $this->db->escape($this->session->userdata('id'));
          $fecha_hoy =  date("Y-m-d h:ia"); 
          $hoy = new DateTime($fecha_hoy);


          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //



          $this->db->select('m.id_usuario_apartado, m.id_cliente_apartado,m.fecha_apartado,m.id_prorroga,m.fecha_vencimiento');  //fecha falta
          $this->db->select('p.nombre comprador ');  
          $this->db->select('CONCAT(u.nombre,"  ",u.apellidos) as vendedor', FALSE);
          $this->db->select('pr.nombre as dependencia', FALSE);

          $this->db->select('
                        CASE m.id_apartado
                          WHEN "4" THEN "Pedido Individual"
                           WHEN "5" THEN "Pedido Confirmado"
                           WHEN "6" THEN "Disponibilidad Salida"
                           ELSE "No Pedido"
                        END AS tipo_apartado
         ',False);          


          $this->db->select('
                        CASE m.id_apartado
                           WHEN "4" THEN "ab1d1d"
                           WHEN "5" THEN "f1a914"
                           WHEN "6" THEN "14b80f"
                           ELSE "No Pedido"
                        END AS color_apartado
         ',False);  

          
          $this->db->from($this->registros.' as m');
          $this->db->join($this->usuarios.' As u' , 'u.id = m.id_usuario_apartado','LEFT');
          $this->db->join($this->proveedores.' As pr', 'u.id_cliente = pr.id','LEFT');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_cliente_apartado','LEFT');
         
          //filtro de busqueda

          $where = '(
                      (
                        ( m.id_apartado = 5 ) or ( m.id_apartado = 6 ) 
                      ) 
                    AND
                      (
                        ( CONCAT(u.nombre," ",u.apellidos) LIKE  "%'.$cadena.'%" ) OR
                        ( pr.nombre LIKE  "%'.$cadena.'%" ) OR (m.id_cliente_apartado LIKE  "%'.$cadena.'%") OR
                        ((DATE_FORMAT((m.fecha_apartado),"%d-%m-%Y") ) LIKE  "%'.$cadena.'%") OR
                        ( "Pedido Individual" LIKE  "%'.$cadena.'%" ) OR
                        ( "Pedido Confirmado" LIKE  "%'.$cadena.'%" ) OR
                        ( "Disponibilidad Salida" LIKE  "%'.$cadena.'%" ) OR
                        ( "En proceso" LIKE  "%'.$cadena.'%" ) 
                       )                     

            )';   

          $where_total = '( m.id_apartado = 5 ) or ( m.id_apartado = 6 )';
          $this->db->where($where);
          $this->db->order_by($columna, $order); 
          $this->db->group_by("m.id_usuario_apartado, m.id_cliente_apartado");

          //ordenacion

          //paginacion
          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);


                  foreach ($result->result() as $row) {

                        $fecha_venc= date( 'd-m-Y h:ia', strtotime($row->fecha_vencimiento));
                        $actual = new DateTime($fecha_venc);
                        $diferencia_fecha =  date_diff($actual,$hoy);

                        if ($row->id_prorroga==0) {  
                          $mi_vencimiento =    $diferencia_fecha->format('%R%h hrs');
                        } else  
                        {
                          $mi_vencimiento = "En proceso";
                        } 


                            $dato[]= array(
                                      0=>$row->vendedor,
                                      1=>$row->dependencia,
                                      2=>$row->id_cliente_apartado,
                                      3=>date( 'd-m-Y', strtotime($row->fecha_apartado)),
                                      4=>$row->tipo_apartado.'<div style="margin-right: 15px;float:left;background-color:#'.$row->color_apartado.';width:15px;height:15px;"></div>',
                                      5=>$mi_vencimiento, //hora vencimiento
                                      6=>$row->id_cliente_apartado,
                                      7=>$row->id_prorroga
                                    );
                      }



                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_pedidos_pendientes($where_total) ),  
                        "recordsFiltered" => $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => intval( self::total_pedidos_pendientes($where_total) ),  
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           
      }  


 
    //3ra regilla de "/pedidos"
      public function total_pedidos_completo($where){

              $this->db->from($this->historico_registros_salidas.' as m');
              $this->db->where($where);
        
              $this->db->group_by("m.mov_salida, m.id_usuario_apartado, m.id_cliente_apartado");
              $result = $this->db->get();
              $cant = $result->num_rows();
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         

       }     

    public function buscador_pedidos_completo($data){

          $cadena = $data['search']['value'];
          $inicio = $data['start'];
          $largo = $data['length'];

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];

          switch ($columa_order) {
                   case '0':
                        $columna = 'u.nombre, u.apellidos';
                     break;
                   case '1':
                        $columna = 'pr.nombre';
                     break;
                   case '2':
                        $columna = 'p.nombre';  //,m.id_cliente_apartado,
                     break;
                   case '3':
                        $columna = 'm.fecha_apartado';
                     break;
                   case '4':
                        $columna = 'm.tipo_salida,m.id_apartado';
                     break;
                   case '5':
                          $columna = 'm.mov_salida';
                     break;
                   
                   default:
                       $columna = 'u.nombre, u.apellidos';
                     break;
                 }            
          

          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //

          $this->db->select('m.id_usuario_apartado, m.id_cliente_apartado,m.fecha_apartado');  //fecha falta
          $this->db->select('p.nombre comprador, m.id_apartado apartado, m.mov_salida ');  
          $this->db->select('CONCAT(u.nombre,"  ",u.apellidos) as vendedor', FALSE);
          $this->db->select('pr.nombre as dependencia', FALSE);

 
          $this->db->select('
                        CASE m.tipo_salida
                           WHEN 1 THEN "Salida Parcial"
                           WHEN 2 THEN "Salida Total"
                           ELSE "xxxx"
                        END AS tipo_apartado
         ',False);  


          $this->db->select('
                        CASE m.id_apartado
                           WHEN "4" THEN "ab1d1d"
                           WHEN "5" THEN "f1a914"
                           WHEN "6" THEN "14b80f"
                           ELSE "No Pedido"
                        END AS color_apartado
         ',False);  

          $this->db->select('
                        CASE m.id_apartado
                           WHEN "3" THEN "(Vendedor)"
                           WHEN "6" THEN "(Tienda)"
                           ELSE "No Pedido"
                        END AS tipo_pedido
         ',False);  


          
          $this->db->from($this->historico_registros_salidas.' as m');
          $this->db->join($this->usuarios.' As u' , 'u.id = m.id_usuario_apartado','LEFT');
          $this->db->join($this->proveedores.' As pr', 'u.id_cliente = pr.id','LEFT');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_cliente_apartado','LEFT');
         

          //filtro de busqueda

          $where = '(
                      (
                        ( m.id_apartado = 3 ) or ( m.id_apartado = 6 ) 
                      ) 
                       AND
                      (
                        ( CONCAT(u.nombre," ",u.apellidos) LIKE  "%'.$cadena.'%" ) OR
                        ( pr.nombre LIKE  "%'.$cadena.'%" ) OR (p.nombre LIKE  "%'.$cadena.'%") OR
                        (m.id_cliente_apartado LIKE  "%'.$cadena.'%") OR 
                        ((DATE_FORMAT((m.fecha_apartado),"%d-%m-%Y") ) LIKE  "%'.$cadena.'%") OR
                        (m.mov_salida LIKE  "%'.$cadena.'%") OR 
                        ( "Salida Parcial" LIKE  "%'.$cadena.'%" ) OR
                        ( "Salida Total" LIKE  "%'.$cadena.'%" ) OR
                        ( "(Vendedor)" LIKE  "%'.$cadena.'%" ) OR
                        ( "(Tienda)" LIKE  "%'.$cadena.'%" ) 
                       )

            )';   


          $this->db->where($where);
          $where_total = '( m.id_apartado = 3 ) or ( m.id_apartado = 6 )';
          $this->db->order_by($columna, $order); 

          $this->db->group_by("m.mov_salida, m.id_usuario_apartado, m.id_cliente_apartado");


          //paginacion
          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);


                  foreach ($result->result() as $row) {

                              if ($row->apartado==3) {
                                 $num=$row->comprador;
                              } else  {
                                 $num= $row->id_cliente_apartado;
                              }   

                            $dato[]= array(
                                      0=>$row->vendedor,
                                      1=>$row->dependencia,
                                      2=>$num, 
                                      3=>date( 'd-m-Y', strtotime($row->fecha_apartado)),
                                      4=>$row->tipo_apartado.$row->tipo_pedido,                                      
                                      5=>$row->mov_salida,
                                      6=>$row->id_apartado,  //$row->id_cliente_apartado,
                                    );
                      }



                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_pedidos_completo($where_total) ), 
                        "recordsFiltered" => $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           
      }  




////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//"Regilla detalle" de la 1ra PARA "Pedidos de vendedores"
  //http://inventarios.dev.com/apartado_detalle/MGNjNTUxMGYtYzQ1Mi0xMWU0LThhZGEtNzA3MWJjZTE4MWMz/MTE=

   //procesando los detalles de un apartado especifico

   public function total_apartado_detalle($where){
              $id_session = $this->session->userdata('id');
              $this->db->from($this->registros.' as m');

              $this->db->where($where);
              $cant = $this->db->count_all_results();          
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         
       }     

   public function buscador_apartados_detalle($data){
          $cadena = $data['search']['value'];
          $inicio = $data['start'];
          $largo = $data['length'];


          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];

          switch ($columa_order) {
                   case '0':
                        $columna = 'm.codigo';
                     break;
                   case '1':
                        $columna = 'm.id_descripcion';
                     break;
                   case '2':
                        $columna = 'c.color';
                     break;
                   case '3':
                        
                        $columna = 'm.cantidad_um';
                     break;
                   case '4':
                        $columna = 'm.movimiento';
                        
                     break;
                   case '5':
                        $columna = 'm.ancho';
                        
                     break;
                   case '6':
                              $columna= 'm.precio';
                     break;
                   case '7':
                              $columna= 'm.id_lote, m.consecutivo';  
                     break;
                   
                   default:
                       $columna = 'm.codigo';
                     break;
                 }              

          $id_usuario = $data['id_usuario'];
          $id_cliente = $data['id_cliente'];

          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //

          //,m.movimiento,m.consecutivo
          $this->db->select('m.id_usuario_apartado, m.id_cliente_apartado');  //fecha falta
          $this->db->select('p.nombre comprador ');  
          $this->db->select('pr.nombre cliente ');  
          $this->db->select('CONCAT(u.nombre,"  ",u.apellidos) as vendedor', FALSE);
          $this->db->select('m.codigo,m.id_descripcion, m.id_lote,m.precio, m.fecha_apartado');  
          $this->db->select('c.hexadecimal_color,c.color nombre_color, m.ancho, um.medida');
          
          $this->db->select("( CASE WHEN m.id_medida = 1 THEN m.cantidad_um ELSE 0 END ) AS metros", FALSE);
          $this->db->select("( CASE WHEN m.id_medida = 2 THEN m.cantidad_um ELSE 0 END ) AS kilogramos", FALSE);
          $this->db->select('
                        CASE m.id_apartado
                          WHEN "1" THEN "Apartado Individual"
                           WHEN "2" THEN "Apartado Confirmado"
                           WHEN "3" THEN "Disponibilidad Salida"
                           ELSE "No Apartado"
                        END AS tipo_apartado
         ',False);          
          $this->db->select('
                        CASE m.id_apartado
                          WHEN "1" THEN "ab1d1d"
                           WHEN "2" THEN "f1a914"
                           WHEN "3" THEN "14b80f"
                           ELSE "No Apartado"
                        END AS color_apartado
         ',False);          

          $this->db->from($this->registros.' as m');
          $this->db->join($this->usuarios.' As u' , 'u.id = m.id_usuario_apartado','LEFT');
          $this->db->join($this->proveedores.' As pr', 'u.id_cliente = pr.id','LEFT');

          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_cliente_apartado','LEFT');
          $this->db->join($this->unidades_medidas.' As um' , 'um.id = m.id_medida','LEFT');
          $this->db->join($this->colores.' As c', 'm.id_color = c.id','LEFT');
          //filtro de busqueda

          $where = '(
                      (
                        ( (m.id_apartado = 2) OR (m.id_apartado = 3) ) AND ( m.id_usuario_apartado = "'.$id_usuario.'" ) AND ( m.id_cliente_apartado = "'.$id_cliente.'" )
                      ) 
                       AND
                      (
                        ( CONCAT(m.cantidad_um," ",um.medida) LIKE  "%'.$cadena.'%" ) OR (CONCAT(m.ancho," cm") LIKE  "%'.$cadena.'%")  OR
                        ( m.codigo LIKE  "%'.$cadena.'%" ) OR (m.id_descripcion LIKE  "%'.$cadena.'%") OR (c.color LIKE  "%'.$cadena.'%")  OR
                         (CONCAT(m.id_lote,"-",m.consecutivo) LIKE  "%'.$cadena.'%") OR ( m.movimiento LIKE  "%'.$cadena.'%" ) OR                    
                         (m.precio LIKE  "%'.$cadena.'%")
                       )
            )';   

          $where_total = '( (m.id_apartado = 2) OR (m.id_apartado = 3) ) AND ( m.id_usuario_apartado = "'.$id_usuario.'" ) AND ( m.id_cliente_apartado = "'.$id_cliente.'" )';

          $this->db->where($where);
          $this->db->order_by($columna, $order); 
          //paginacion
          $this->db->limit($largo,$inicio); 

          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);

                  foreach ($result->result() as $row) {
                          $mi_usuario = $row->vendedor;
                          $mi_cliente = $row->cliente;
                          $mi_comprador = $row->comprador;
                          $tipo_apartado = $row->tipo_apartado;
                          $color_apartado = $row->color_apartado;
                          $mi_fecha = date( 'd-m-Y', strtotime($row->fecha_apartado));
                          $mi_hora = date( 'h:ia', strtotime($row->fecha_apartado));

                            $dato[]= array(
                                      0=>$row->codigo,
                                      1=>$row->id_descripcion,
                                      2=>$row->color.
                                       '<div style="background-color:#'.$row->hexadecimal_color.';display:block;width:15px;height:15px;margin:0 auto;"></div>',
                                      3=>$row->cantidad_um.' '.$row->medida,
                                      4=>
                                           '<a style="  padding: 1px 0px 1px 0px;" href="'.base_url().'procesar_entradas/'.base64_encode($row->movimiento).'" 
                                               type="button" class="btn btn-success btn-block">'.$row->movimiento.'</a>', 
                                      5=>$row->ancho.' cm',
                                      6=>$row->precio,
                                      7=>$row->id_lote.'-'.$row->consecutivo,                                      
                                    );
                      }

                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"     => intval( self::total_apartado_detalle($where_total) ), 
                        "recordsFiltered" => $registros_filtrados, 
                        "data"            =>  $dato,
                         "datos"            =>  array("usuario"=>$mi_usuario, "tipo_apartado"=>$tipo_apartado, "color_apartado"=>$color_apartado, "comprador"=>$mi_comprador, "cliente"=>$mi_cliente, "mi_fecha"=>$mi_fecha, "mi_hora"=>$mi_hora ),
                      ));
              }   
              else {
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => intval( self::total_apartado_detalle($where_total) ), 
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
              }
              $result->free_result();           
      }        

 
    //"Regilla detalle" de la 2da PARA  "Pedidos de tiendas" 
    //http://inventarios.dev.com/pedido_detalle/MjQ=

  public function total_pedido_especifico($where){
              $id_session = $this->session->userdata('id');
              $this->db->from($this->registros.' as m');

              $this->db->where($where);
              $cant = $this->db->count_all_results();          
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         
       }     

    public function buscador_pedido_especifico($data){
          $cadena = $data['search']['value'];
          $inicio = $data['start'];
          $largo = $data['length'];

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];

          switch ($columa_order) {
                   case '0':
                        $columna = 'm.codigo';
                     break;
                   case '1':
                        $columna = 'm.id_descripcion';
                     break;
                   case '2':
                        $columna = 'c.color';
                     break;
                   case '3':
                        
                        $columna = 'm.cantidad_um';
                     break;
                   case '4':
                        $columna = 'm.movimiento';
                        
                     break;
                   case '5':
                        $columna = 'm.ancho';
                        
                     break;
                   case '6':
                              $columna= 'm.precio';
                     break;
                   case '7':
                              $columna= 'm.id_lote, m.consecutivo';  
                     break;
                   
                   default:
                       $columna = 'm.codigo';
                     break;
                 }                       

          $num_mov = $data['num_mov'];
          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //

          $this->db->select('m.id_usuario_apartado, m.id_cliente_apartado');  //fecha falta
          $this->db->select('pr.nombre dependencia ');  
          $this->db->select('CONCAT(u.nombre,"  ",u.apellidos) as cliente', FALSE);
          $this->db->select('m.codigo,m.id_descripcion, m.id_lote,m.precio, m.fecha_apartado');  
          $this->db->select('c.hexadecimal_color,c.color nombre_color, m.ancho, um.medida');
          
          $this->db->select("( CASE WHEN m.id_medida = 1 THEN m.cantidad_um ELSE 0 END ) AS metros", FALSE);
          $this->db->select("( CASE WHEN m.id_medida = 2 THEN m.cantidad_um ELSE 0 END ) AS kilogramos", FALSE);

          $this->db->select('
                        CASE m.id_apartado
                          WHEN "4" THEN "Pedido Individual"
                           WHEN "5" THEN "Pedido Confirmado"
                           WHEN "6" THEN "Disponibilidad Salida"
                           ELSE "No Pedido"
                        END AS tipo_apartado
         ',False);          
          $this->db->select('
                        CASE m.id_apartado
                           WHEN "4" THEN "ab1d1d"
                           WHEN "5" THEN "f1a914"
                           WHEN "6" THEN "14b80f"
                           ELSE "No Pedido"
                        END AS color_apartado
         ',False);  
          $this->db->from($this->registros.' as m');
          $this->db->join($this->usuarios.' As u' , 'u.id = m.id_usuario_apartado','LEFT');
          $this->db->join($this->proveedores.' As pr', 'u.id_cliente = pr.id','LEFT');
          $this->db->join($this->unidades_medidas.' As um' , 'um.id = m.id_medida','LEFT');
          $this->db->join($this->colores.' As c', 'm.id_color = c.id','LEFT');

          //filtro de busqueda

          $where = '(
                      (
                        (( m.id_apartado = 5 ) or ( m.id_apartado = 6 ) ) AND ( m.id_cliente_apartado = "'.$num_mov.'" )
                      ) 
                       AND
                      (
                        ( CONCAT(m.cantidad_um," ",um.medida) LIKE  "%'.$cadena.'%" ) OR (CONCAT(m.ancho," cm") LIKE  "%'.$cadena.'%")  OR
                        ( m.codigo LIKE  "%'.$cadena.'%" ) OR (m.id_descripcion LIKE  "%'.$cadena.'%") OR (c.color LIKE  "%'.$cadena.'%")  OR
                         (CONCAT(m.id_lote,"-",m.consecutivo) LIKE  "%'.$cadena.'%") OR ( m.movimiento LIKE  "%'.$cadena.'%" ) OR                    
                         (m.precio LIKE  "%'.$cadena.'%")
                       )
            )';   

          $this->db->where($where);

          $this->db->order_by($columna, $order); 

          $where_total ='(( m.id_apartado = 5 ) or ( m.id_apartado = 6 ) ) AND ( m.id_cliente_apartado = "'.$num_mov.'" )';

          //paginacion
          $this->db->limit($largo,$inicio); 

          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);
                  foreach ($result->result() as $row) {

                            $mi_cliente = $row->cliente;
                            $mi_dependencia = $row->dependencia;

                            $tipo_apartado = $row->tipo_apartado;
                            $color_apartado = $row->color_apartado;
                            $mi_fecha = date( 'd-m-Y', strtotime($row->fecha_apartado));
                            $mi_hora = date( 'h:ia', strtotime($row->fecha_apartado));

                               $dato[]= array(
                                      0=>$row->codigo,
                                      1=>$row->id_descripcion,
                                      2=>$row->color.
                                       '<div style="background-color:#'.$row->hexadecimal_color.';display:block;width:15px;height:15px;margin:0 auto;"></div>',
                                      3=>$row->cantidad_um.' '.$row->medida,
                                      4=>
                                           '<a style="  padding: 1px 0px 1px 0px;" href="'.base_url().'procesar_entradas/'.base64_encode($row->movimiento).'" 
                                               type="button" class="btn btn-success btn-block">'.$row->movimiento.'</a>', 
                                      5=>$row->ancho.' cm',
                                      6=>$row->precio,
                                      7=>$row->id_lote.'-'.$row->consecutivo,                                      
                                    );

                      }
                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_pedido_especifico($where_total) ), 
                        "recordsFiltered" => $registros_filtrados, 
                        "data"            =>  $dato, 
                        "datos"            =>  array("num_mov"=>$num_mov, "tipo_apartado"=>$tipo_apartado, "color_apartado"=>$color_apartado, "dependencia"=>$mi_dependencia, "cliente"=>$mi_cliente, "mi_fecha"=>$mi_fecha, "mi_hora"=>$mi_hora ),
                      ));
                    
              }   
              else {
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => intval( self::total_pedido_especifico($where_total) ), 
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
              }
              $result->free_result();           
      }    

  
    //"Regilla detalle" de la 3ra PARA "Historico de Pedidos"
    //http://inventarios.dev.com/pedido_completado_detalle/NTA=/Ng==


  public function total_completo_especifico($where){
              
              $this->db->from($this->historico_registros_salidas.' as m');

              $this->db->where($where);
              $cant = $this->db->count_all_results();          
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         
       }     


    public function buscador_completo_especifico($data){

          $cadena = $data['search']['value'];
          $inicio = $data['start'];
          $largo = $data['length'];

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];

          switch ($columa_order) {
                   case '0':
                        $columna = 'm.codigo';
                     break;
                   case '1':
                        $columna = 'm.id_descripcion';
                     break;
                   case '2':
                        $columna = 'c.color';
                     break;
                   case '3':
                        
                        $columna = 'm.cantidad_um';
                     break;
                   case '4':
                        $columna = 'm.ancho';
                        
                     break;
                   case '5':
                              $columna= 'm.precio';
                     break;
                   case '6':
                              $columna= 'm.id_lote, m.consecutivo';  
                     break;
                   
                   default:
                       $columna = 'm.codigo';
                     break;
                 }                       


          $mov_salida = $data['mov_salida'];
          $id_apartado = $data['id_apartado'];
          

          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //

          $this->db->select('m.id_usuario_apartado, m.id_cliente_apartado');  //fecha falta
          $this->db->select('pr.nombre dependencia ');  
          $this->db->select('CONCAT(u.nombre,"  ",u.apellidos) as cliente', FALSE);
          $this->db->select('CONCAT(u.nombre,"  ",u.apellidos) as vendedor', FALSE);

          $this->db->select('m.codigo,m.id_descripcion, m.id_lote,m.precio, m.fecha_apartado, m.consecutivo');  
          $this->db->select('c.hexadecimal_color,c.color nombre_color, m.ancho, um.medida');
          
          $this->db->select("( CASE WHEN m.id_medida = 1 THEN m.cantidad_um ELSE 0 END ) AS metros", FALSE);
          $this->db->select("( CASE WHEN m.id_medida = 2 THEN m.cantidad_um ELSE 0 END ) AS kilogramos", FALSE);

          $this->db->select('p.nombre comprador , m.id_apartado');  

          $this->db->select('
                        CASE m.id_apartado
                           WHEN "3" THEN "Vendedor"
                           WHEN "6" THEN "Tienda"
                           ELSE "No Pedido"
                        END AS tipo_apartado
         ',False);          


          $this->db->select('
                        CASE m.tipo_salida
                           WHEN 1 THEN "(Salida Parcial)"
                           WHEN 2 THEN "(Salida Total)"
                           ELSE "xxxx"
                        END AS tipo_pedido
         ',False);  



          $this->db->select('
                        CASE m.id_apartado
                           WHEN "3" THEN "ab1d1d"
                           WHEN "6" THEN "14b80f"
                           ELSE "No Pedido"
                        END AS color_apartado
         ',False);  

          $this->db->from($this->historico_registros_salidas.' as m');
          $this->db->join($this->usuarios.' As u' , 'u.id = m.id_usuario_apartado','LEFT');
          $this->db->join($this->proveedores.' As pr', 'u.id_cliente = pr.id','LEFT');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_cliente_apartado','LEFT');
          $this->db->join($this->unidades_medidas.' As um' , 'um.id = m.id_medida','LEFT');
          $this->db->join($this->colores.' As c', 'm.id_color = c.id','LEFT');

          //filtro de busqueda

          $where = '(
                      (
                        ( m.id_apartado =  '.$id_apartado.' )  AND ( m.mov_salida = '.$mov_salida.' )
                      ) 
                   AND
                      (
                        ( CONCAT(m.cantidad_um," ",um.medida) LIKE  "%'.$cadena.'%" ) OR (CONCAT(m.ancho," cm") LIKE  "%'.$cadena.'%")  OR
                        ( m.codigo LIKE  "%'.$cadena.'%" ) OR (m.id_descripcion LIKE  "%'.$cadena.'%") OR (c.color LIKE  "%'.$cadena.'%")  OR
                         (CONCAT(m.id_lote,"-",m.consecutivo) LIKE  "%'.$cadena.'%") OR 
                         (m.precio LIKE  "%'.$cadena.'%")
                       )
            )';   



          $this->db->where($where);

          $where_total = '( m.id_apartado =  '.$id_apartado.' )  AND ( m.mov_salida = '.$mov_salida.' )';

          $this->db->order_by($columna, $order); 



          

          //paginacion
          $this->db->limit($largo,$inicio); 
          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);

                  foreach ($result->result() as $row) {

                              if ($row->id_apartado==3) {
                                $mi_cliente = $row->comprador; 
                                $num_mov = $row->cliente; 
                                
                              } else  {
                                 $mi_cliente = $row->cliente; 
                                 $num_mov = $row->id_cliente_apartado;
                              }   

                            $tipo_pedido   = $row->tipo_pedido;
                            $mi_dependencia = $row->dependencia;

                            $tipo_apartado = $row->tipo_apartado;
                            $color_apartado = $row->color_apartado;
                            $mi_fecha = date( 'd-m-Y', strtotime($row->fecha_apartado));
                            $mi_hora = date( 'h:ia', strtotime($row->fecha_apartado));

                            $dato[]= array(
                                      0=>$row->codigo,
                                      1=>$row->id_descripcion,
                                      2=>
                                      $row->nombre_color.'<div style="margin-right: 15px;float:left;background-color:#'.$row->hexadecimal_color.';width:15px;height:15px;"></div>',
                                      3=>$row->cantidad_um.' '.$row->medida, //metros,
                                      4=>$row->ancho.' cm',
                                      5=>$row->precio,
                                      6=>$row->id_lote.'-'.$row->consecutivo,                                      
                                    );
                      }

                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_completo_especifico($where_total) ), 
                        "recordsFiltered" => $registros_filtrados, 
                        "data"            =>  $dato, 
                        "datos"            =>  array("tipo_pedido"=>$tipo_pedido, "num_mov"=>$num_mov, "tipo_apartado"=>$tipo_apartado, "color_apartado"=>$color_apartado, "dependencia"=>$mi_dependencia, "cliente"=>$mi_cliente, "mi_fecha"=>$mi_fecha, "mi_hora"=>$mi_hora ),
                      ));
                    
              }   
              else {
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => intval( self::total_completo_especifico($where_total) ), 
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
              }
              $result->free_result();           
      }  

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////


      public function total_registros(){
              $id_session = $this->session->userdata('id');
              $this->db->from($this->registros.' as m');
              $this->db->where('m.id_usuario',$id_session);
              $this->db->where('m.id_operacion',1);
              $this->db->where('m.estatus_salida',0);

              $cant = $this->db->count_all_results();          
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         
       }   




        public function marcando_prorroga_venta( $data ){
              
                $id_session = $this->session->userdata('id');
                $this->db->set( 'id_prorroga', '(1 XOR id_prorroga)', FALSE );
                $this->db->where('id_usuario_apartado', $data['id_usuario_apartado'] );
                $this->db->where('id_cliente_apartado', $data['id_cliente_apartado'] );

                $this->db->update($this->registros );
                $this->db->select( 'id_prorroga' );
                $this->db->where('id_usuario_apartado', $data['id_usuario_apartado'] );
                $this->db->where('id_cliente_apartado', $data['id_cliente_apartado'] );

                $colo_prorroga = $this->db->get($this->registros );

               $prorroga = $colo_prorroga->row();
               return $prorroga->id_prorroga;

        
        }     

        public function marcando_prorroga_tienda( $data ){
              
                $id_session = $this->session->userdata('id');
                $this->db->set( 'id_prorroga', '(1 XOR id_prorroga)', FALSE );
                $where = '(
                          (
                            (( id_apartado = 5 ) or ( id_apartado = 6 ) ) AND ( id_cliente_apartado = '.$data['id_cliente_apartado'].' )
                          ) 

                      )';   

                $this->db->where($where);    


                $this->db->update($this->registros );

                //$this->db->distinct();
                $this->db->select( 'id_prorroga' );
                $where = '(
                          (
                            (( id_apartado = 5 ) or ( id_apartado = 6 ) ) AND ( id_cliente_apartado = '.$data['id_cliente_apartado'].' )
                          ) 

                      )';   

                $this->db->where($where);   

                $colo_prorroga = $this->db->get($this->registros );

               $prorroga = $colo_prorroga->row();
               return $prorroga->id_prorroga;

        
        }                        
   


    public function actualizar_pedido( $data ){
           
            $id_session = $this->db->escape($this->session->userdata('id'));
            
            $fecha_hoy = date('Y-m-d H:i:s');  

            $this->db->set( 'id_usuario_apartado', $id_session, FALSE  );
            $this->db->set( 'id_apartado', 4);
            $this->db->set( 'fecha_apartado', $fecha_hoy);  
            $this->db->set( 'id_cliente_apartado', $data['id_movimiento']);
            $this->db->where('id',$data['id']);
            $this->db->update($this->registros);
     
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
            
        }

    public function quitar_pedido( $data ){
           
            $id_session = $this->db->escape($this->session->userdata('id'));
            $fecha_hoy = date('Y-m-d H:i:s');  
                
            $this->db->set( 'precio_anterior', 'precio', FALSE  );
            $this->db->set( 'precio', 'precio_cambio', FALSE  );
            
            $this->db->set( 'id_usuario_apartado', ''  );
            $this->db->set( 'id_apartado', 0);
            $this->db->set( 'fecha_apartado', $fecha_hoy);  
            $this->db->set( 'id_cliente_apartado', 0);
            $this->db->where('id',$data['id']);
            $this->db->update($this->registros);
     
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
            
        }

public function valores_movimientos_temporal(){

          $id_session = $this->session->userdata('id');
          
          $this->db->distinct();          
          $this->db->select('m.id, m.id_cliente, m.id_cargador, m.factura');
          $this->db->select('p.nombre, ca.nombre cargador');
          
          $this->db->from($this->registros_salidas.' as m');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_cliente','LEFT');
          $this->db->join($this->cargadores.' As ca' , 'ca.id = m.id_cargador','LEFT');

          $this->db->where('m.id_usuario',$id_session);
          $this->db->where('id_operacion',2);
           $result = $this->db->get();
        
            if ( $result->num_rows() > 0 )
               return $result->row();
            else
               return False;
            $result->free_result();
        }   


        //cambiar estatus de unidad
        public function pedido_definitivamente( $data ){
              
                $id_session = $this->session->userdata('id');
                $fecha_hoy = date('Y-m-d H:i:s');  

                $this->db->set( 'fecha_vencimiento', $fecha_hoy  );
                $this->db->set( 'fecha_apartado', $fecha_hoy  );  
                $this->db->set( 'id_cliente_apartado',  $data['num_mov'] ); //numero de mov.
                $this->db->set( 'id_apartado', 5 , FALSE );
                
                $this->db->where('id_usuario_apartado', $id_session );
                $this->db->where('id_apartado', 4 );

                $this->db->update($this->registros );



              //actualizar (consecutivo) en tabla "operacion"   == "generar_pedido"
              $this->db->set( 'consecutivo', 'consecutivo+1', FALSE  );
              $this->db->set( 'id_usuario', $id_session );
              $this->db->where('id',4);
              $this->db->update($this->operaciones);


                if ($this->db->affected_rows() > 0) {
                  return TRUE;
                }  else
                   return FALSE;
       
        }    
        

        //cambiar estatus de unidad
        public function cancelar_apartados_detalle( $data ){
              
                $id_session = $this->session->userdata('id');
                $fecha_hoy = date('Y-m-d H:i:s');  

                $this->db->set( 'precio_anterior', 'precio', FALSE  );
                $this->db->set( 'precio', 'precio_cambio', FALSE  );

                $this->db->set( 'fecha_vencimiento', '' ); 
                $this->db->set( 'id_prorroga', 0);
                
                $this->db->set( 'fecha_apartado', '' );  
                $this->db->set( 'id_cliente_apartado', 0 );
                $this->db->set( 'id_apartado', 0);
                $this->db->set( 'id_usuario_apartado', '');

                $this->db->where('id_usuario_apartado',$data['id_usuario']);
                $this->db->where('id_cliente_apartado',$data['id_cliente']);
                $this->db->where('id_apartado', 2 );

                $this->db->update($this->registros );

                if ($this->db->affected_rows() > 0) {
                  return TRUE;
                }  else
                   return FALSE;
       
        }   



            //cambiar estatus de unidad
        public function incluir_apartado( $data ){
              
                $this->db->set( 'id_apartado', $data['id_apartado']);

                $where = '(
                          (
                            (( id_apartado = 2 ) or ( id_apartado = 3 ) ) AND ( id_cliente_apartado = "'.$data['id_cliente'].'" ) AND ( id_usuario_apartado = "'.$data['id_usuario'].'" )
                          ) 
                      )';   

                $this->db->where($where);
                $this->db->update($this->registros );
                if ($this->db->affected_rows() > 0) {
                  return TRUE;
                }  else
                   return FALSE;

        
        }   


                    //cambiar estatus de unidad
        public function incluir_pedido( $data ){
              
                $this->db->set( 'id_apartado', $data['id_apartado']);
                
                $where = '(
                          (
                            (( id_apartado = 5 ) or ( id_apartado = 6 ) ) AND ( id_cliente_apartado = "'.$data['num_mov'].'" )
                          ) 

                      )';   

                $this->db->where($where);
                $this->db->update($this->registros );
                if ($this->db->affected_rows() > 0) {
                  return TRUE;
                }  else
                   return FALSE;

        }   



        //cambiar estatus de pedidos
        public function cancelar_pedido_detalle( $data ){
              
                $id_session = $this->session->userdata('id');
                $fecha_hoy = date('Y-m-d H:i:s');  

                
                $this->db->set( 'precio_anterior', 'precio', FALSE  );
                $this->db->set( 'precio', 'precio_cambio', FALSE  );

                $this->db->set( 'fecha_vencimiento', '' ); 
                $this->db->set( 'id_prorroga', 0);
                $this->db->set( 'fecha_apartado', '' );  
                $this->db->set( 'id_cliente_apartado', 0 );
                $this->db->set( 'id_apartado', 0);
                $this->db->set( 'id_usuario_apartado', '');

                $where = '(
                          (
                            (( id_apartado = 5 ) or ( id_apartado = 6 ) ) AND ( id_cliente_apartado = "'.$data['num_mov'].'" )
                          ) 

                      )';   

                $this->db->where($where);                

                $this->db->update($this->registros );

                if ($this->db->affected_rows() > 0) {
                  return TRUE;
                }  else
                   return FALSE;
       
        }   








        public function total_apartados_detalles($id_usuario,$id_cliente){

              $id_session = $this->session->userdata('id');
              $this->db->from($this->registros.' as m');
              $this->db->where('m.id_apartado',2);
              $this->db->where('m.id_usuario_apartado',$id_usuario);
              $this->db->where('m.id_cliente_apartado',$id_cliente);
              
              $cant = $this->db->count_all_results();          
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         

       }  














//////////////////////////////Procesando apartados pendientes



















        public function total_pedidos_especifico($num_mov){

              $id_session = $this->session->userdata('id');
              $this->db->from($this->registros.' as m');
              $this->db->where('m.id_usuario_apartado',$num_mov);
              $this->db->group_by("m.id_cliente_apartado");
              $result = $this->db->get();
              $cant = $result->num_rows();
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         

       }      









  } 






?>

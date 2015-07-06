<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

	class modelo_reportes extends CI_Model{
		
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
      $this->cargadores             = $this->db->dbprefix('catalogo_cargador');
      
      $this->estratificacion_empresa = $this->db->dbprefix('catalogo_estratificacion_empresa');
      
      $this->productos               = $this->db->dbprefix('catalogo_productos');
      $this->proveedores             = $this->db->dbprefix('catalogo_empresas');
      $this->unidades_medidas        = $this->db->dbprefix('catalogo_unidades_medidas');

      $this->operaciones             = $this->db->dbprefix('catalogo_operaciones');
      $this->movimientos               = $this->db->dbprefix('movimientos');
      $this->registros_temporales               = $this->db->dbprefix('temporal_registros');
      $this->registros               = $this->db->dbprefix('registros_entradas');

      $this->colores                 = $this->db->dbprefix('catalogo_colores');
      
      $this->historico_registros_salidas = $this->db->dbprefix('historico_registros_salidas');

      $this->registros_salidas       = $this->db->dbprefix('registros_salidas');
      
      $this->historico_registros_entradas = $this->db->dbprefix('historico_registros_entradas');
      
      
      $this->composiciones     = $this->db->dbprefix('catalogo_composicion');
      $this->calidades                 = $this->db->dbprefix('catalogo_calidad');

      $this->registros_entradas               = $this->db->dbprefix('registros_entradas');
      $this->registros_cambios               = $this->db->dbprefix('registros_cambios');


      


		}
     
        
//////////////////////Auxiliar 
        public function check_existente_proveedor_entrada($descripcion){
            $this->db->select("pro.id", FALSE);         
            $this->db->from($this->proveedores.' as pro ');
            $this->db->where('pro.nombre',$descripcion);  
           
            
            $login = $this->db->get();
            if ($login->num_rows() > 0) {
                $fila = $login->row(); 
                return $fila->id;
            }    
            else
                return false;
            $login->free_result();
    }     

  
//////////////////////////entrada


      public function total_registros_entrada_home($where){

              $this->db->from($this->registros.' as m');
              //$this->db->join($this->usuarios.' As us' , 'us.id = m.id_usuario_apartado','LEFT');

              $this->db->where($where);

              $cant = $this->db->count_all_results();          
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         
       }      



      public function total_campos_entrada_home($where){

              $this->db->select("SUM((id_medida =1) * cantidad_um) as metros", FALSE);
              $this->db->select("SUM((id_medida =2) * cantidad_um) as kilogramos", FALSE);
              $this->db->select("COUNT(m.id_medida) as 'pieza'");
              
             
              $this->db->from($this->registros.' as m');
              $this->db->join($this->usuarios.' As us' , 'us.id = m.id_usuario_apartado','LEFT');

              $this->db->where($where);

             $result = $this->db->get();
          
              if ( $result->num_rows() > 0 )
                 return $result->row();
              else
                 return False;
              $result->free_result();              
       }       



    public function buscador_entrada_home($data){

          $cadena = $data['search']['value'];
          $inicio = $data['start'];
          $largo = $data['length'];
          $estatus= $data['extra_search'];
          $id_estatus= $data['id_estatus'];
          $id_empresa= $data['proveedor'];


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
                          if ($estatus=="apartado") {
                              $columna= 'pr.nombre';
                          }  else {
                              $columna= 'p.nombre';
                          }  
                     break;
                   case '7':
                          if ($estatus=="apartado") {
                              $columna= 'm.id_apartado';
                          }  else {
                              $columna= 'm.id_lote, m.consecutivo';  
                          }  
                     break;
                   case '8':
                        $columna = 'm.fecha_entrada';
                     break;
                   
                   default:
                       $columna = 'm.codigo';
                     break;
                 }                 

          $fechas = ' ';
          if  ( ($data['fecha_inicial'] !="") and  ($data['fecha_final'] !="")) {
                           $fecha_inicial = date( 'Y-m-d', strtotime( $data['fecha_inicial'] ));
                           $fecha_final = date( 'Y-m-d', strtotime( $data['fecha_final'] ));
                          
                          if ($estatus=="apartado") {
                            $fechas .= ' AND ( ( DATE_FORMAT((m.fecha_apartado),"%Y-%m-%d")  >=  "'.$fecha_inicial.'" )  AND  ( DATE_FORMAT((m.fecha_apartado),"%Y-%m-%d")  <=  "'.$fecha_final.'" ) )'; 
                          }  else {
                            $fechas .= ' AND ( ( DATE_FORMAT((m.fecha_entrada),"%Y-%m-%d")  >=  "'.$fecha_inicial.'" )  AND  ( DATE_FORMAT((m.fecha_entrada),"%Y-%m-%d")  <=  "'.$fecha_final.'" ) )'; 
                          }  

          } else {
           $fechas .= ' ';
          }



          $donde = '';
         if ($id_empresa!="") {
              $id_empre =  self::check_existente_proveedor_entrada($id_empresa);

              if ($estatus=="apartado") {
                  $donde .= ' AND ( us.id_cliente  =  '.$id_empre.' ) '; //id_cliente_apartado, id_usuario_apartado
              }    else {
                  $donde .= ' AND ( m.id_empresa  =  '.$id_empre.' ) ';
              }

        } else 
        {
           $donde .= ' ';
        }


          //productos
          $id_descripcion= $data['id_descripcion'];
          $id_color= $data['id_color'];
          $id_composicion= $data['id_composicion'];
          $id_calidad= $data['id_calidad'];


          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); 

          $this->db->select('m.id, m.movimiento,m.id_empresa, m.factura, m.id_descripcion, m.id_operacion');
          $this->db->select('m.id_color, m.id_composicion, m.id_calidad, m.referencia');
          $this->db->select('m.id_medida,  m.cantidad_royo, m.ancho, m.precio, m.codigo, m.comentario');
          $this->db->select('m.id_estatus, m.id_lote, m.consecutivo, m.id_cargador, m.id_usuario, m.fecha_mac fecha, m.fecha_entrada,fecha_apartado');
          $this->db->select('c.hexadecimal_color, c.color, p.nombre');
          $this->db->select('DATE_FORMAT(m.fecha_entrada,"%d/%m/%Y") as ppp',false);


          
          
          if ($estatus=="apartado") {
              $this->db->select('pr.nombre as dependencia', FALSE);
          }

          $this->db->select('m.cantidad_um, u.medida');

          $this->db->select('
                        CASE m.id_apartado
                          WHEN "1" THEN "ab1d1d"
                           WHEN "2" THEN "f1a914"
                           WHEN "3" THEN "14b80f"
                           
                           WHEN "4" THEN "ab1d1d"
                           WHEN "5" THEN "f1a914"
                           WHEN "6" THEN "14b80f"

                           ELSE "No Apartado"
                        END AS apartado
            ',False);

          $this->db->select("( CASE WHEN m.id_medida = 1 THEN m.cantidad_um ELSE 0 END ) AS metros", FALSE);
          $this->db->select("( CASE WHEN m.id_medida = 2 THEN m.cantidad_um ELSE 0 END ) AS kilogramos", FALSE);
          $this->db->select("( CASE WHEN m.devolucion <> 0 THEN 'red' ELSE 'black' END ) AS color_devolucion", FALSE);

         
          $this->db->from($this->registros.' as m');
          $this->db->join($this->colores.' As c' , 'c.id = m.id_color','LEFT');
          $this->db->join($this->unidades_medidas.' As u' , 'u.id = m.id_medida','LEFT');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_empresa','LEFT');


          if ($estatus=="apartado") {
              $this->db->join($this->usuarios.' As us' , 'us.id = m.id_usuario_apartado','LEFT');
              $this->db->join($this->proveedores.' As pr', 'us.id_cliente = pr.id','LEFT');

          }    

          if ($estatus=="apartado") {
            $cond= ' (pr.nombre LIKE  "%'.$cadena.'%") OR  ( m.id_apartado LIKE  "%'.$cadena.'%" )';                 
          } else {
            $cond= ' (p.nombre LIKE  "%'.$cadena.'%") OR  (CONCAT(m.id_lote,"-",m.consecutivo) LIKE  "%'.$cadena.'%") ';//' OR (m.consecutivo LIKE  "%'.$cadena.'%") ';
          }

          $where = '(
                      (
                         ( m.estatus_salida = "0" )  and ( m.id_estatus =  '.$id_estatus.' )
                      ) 
                       AND
                      (
                        ( m.codigo LIKE  "%'.$cadena.'%" ) OR (m.id_descripcion LIKE  "%'.$cadena.'%") OR (c.color LIKE  "%'.$cadena.'%")  OR
                        ( CONCAT(m.cantidad_um," ",u.medida) LIKE  "%'.$cadena.'%" ) OR (CONCAT(m.ancho," cm") LIKE  "%'.$cadena.'%")  OR
                        ( m.movimiento LIKE  "%'.$cadena.'%" ) OR ((DATE_FORMAT((m.fecha_entrada),"%d-%m-%Y") ) LIKE  "%'.$cadena.'%") OR '.$cond.' 
                       )

            ) ' ;                     
          

          $where_total = '( ( m.estatus_salida = "0" )  and ( m.id_estatus =  '.$id_estatus.' ) )';

          if ($estatus=="devolucion") {
              $where .= ' AND ( m.id_estatus = "13" ) ' ;   
              $where_total .= ' AND ( m.id_estatus = "13" ) ' ;   
          }    

          if ($estatus=="apartado") {
              $where .= ' AND ( m.id_apartado != 0 ) ' ;   
              $where_total .= ' AND ( m.id_apartado != 0 ) ' ;      
          }    else {
              $where .= ' AND ( m.id_apartado = 0 ) ' ;   
              $where_total .= ' AND ( m.id_apartado = 0 ) ' ;   
          }


          if ( (($id_calidad!="0") AND ($id_calidad!="") AND ($id_calidad!= null))
            and (($id_composicion!="0") AND ($id_composicion!="") AND ($id_composicion!= null))
            and (($id_color!="0") AND ($id_color!="") AND ($id_color!= null))
            and (($id_descripcion!="0") AND ($id_descripcion!="") AND ($id_descripcion!= null)) 
            ) {
              $where .= ' AND ( m.id_descripcion  =  "'.$id_descripcion.'" ) AND  ( m.id_color  =  '.$id_color.' )';
              $where .= ' AND ( m.id_composicion  =  '.$id_composicion.' ) AND  ( m.id_calidad  =  '.$id_calidad.' )';
              $where_total .= ' AND ( m.id_descripcion  =  "'.$id_descripcion.'" ) AND  ( m.id_color  =  '.$id_color.' )';
              $where_total .= ' AND ( m.id_composicion  =  '.$id_composicion.' ) AND  ( m.id_calidad  =  '.$id_calidad.' )';
          }    

          elseif
           ( 
               (($id_composicion!="0") AND ($id_composicion!="") AND ($id_composicion!= null))
            and (($id_color!="0") AND ($id_color!="") AND ($id_color!= null))
            and (($id_descripcion!="0") AND ($id_descripcion!="") AND ($id_descripcion!= null)) 
            ) {
              $where .= ' AND ( m.id_descripcion  =  "'.$id_descripcion.'" ) AND  ( m.id_color  =  '.$id_color.' )';
              $where .= ' AND ( m.id_composicion  =  '.$id_composicion.' ) ';
              $where_total .= ' AND ( m.id_descripcion  =  "'.$id_descripcion.'" ) AND  ( m.id_color  =  '.$id_color.' )';
              $where_total .= ' AND ( m.id_composicion  =  '.$id_composicion.' ) ';
          }  

          elseif 
           ( (($id_color!="0") AND ($id_color!="") AND ($id_color!= null))
            and (($id_descripcion!="0") AND ($id_descripcion!="") AND ($id_descripcion!= null)) 
            ) {
              $where .= ' AND ( m.id_descripcion  =  "'.$id_descripcion.'" ) AND  ( m.id_color  =  '.$id_color.' )';
              $where_total .= ' AND ( m.id_descripcion  =  "'.$id_descripcion.'" ) AND  ( m.id_color  =  '.$id_color.' )';
          }  

          elseif  (($id_descripcion!="0") AND ($id_descripcion!="") AND ($id_descripcion!= null)) {
              $where .= ' AND ( m.id_descripcion  =  "'.$id_descripcion.'" )';
              $where_total  .= ' AND ( m.id_descripcion  =  "'.$id_descripcion.'" )';
          }  


          $where_total.= $donde.$fechas; //$donde.



          $this->db->where($where.$donde.$fechas); //
    
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
                           

                          if ($estatus=="apartado") {
                              $fecha= $row->fecha_apartado;
                              if (($row->id_apartado) >=4) {
                                $tip_apart= " (Tienda)";
                              } else {
                                $tip_apart= " (Vendedor)";
                              }  
                              $columna6= $row->dependencia.$tip_apart;
                              $columna7= 
                              '<div style="background-color:#'.$row->apartado.';display:block;width:15px;height:15px;margin:0 auto;"></div>';
                          }  else {
                              $fecha= $row->fecha_entrada;
                              $columna7=$row->id_lote.'-'.$row->consecutivo; 
                              $columna6= $row->nombre;
                          }  

                           

                           $dato[]= array(
                                      0=>$row->codigo,
                                      1=>$row->id_descripcion,
                                      2=> $row->color.
                                        '<div style="background-color:#'.$row->hexadecimal_color.';display:block;width:15px;height:15px;margin:0 auto;"></div>',
                                      3=>$row->cantidad_um.' '.$row->medida,
                                      4=>$row->ancho.' cm',
                                      5=>
                                           '<a style="  padding: 1px 0px 1px 0px;" href="'.base_url().'procesar_entradas/'.base64_encode($row->movimiento).'" 
                                               type="button" class="btn btn-success btn-block">'.$row->movimiento.'</a>', 
                                      6=>$columna6,
                                      7=>$columna7,
                                      8=> date( 'd-m-Y', strtotime($fecha)),
                                      9=>$row->metros,
                                      10=>$row->kilogramos,
                                      11=>$row->color_devolucion,

                                    );                    
                      }

                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_registros_entrada_home($where_total) ),  
                        "recordsFiltered" => $registros_filtrados, 
                        "data"            =>  $dato, 
                        "totales"            =>  array("pieza"=>intval( self::total_campos_entrada_home($where_total)->pieza ), "metro"=>intval( self::total_campos_entrada_home($where_total)->metros ), "kilogramo"=>intval( self::total_campos_entrada_home($where_total)->kilogramos )), 

                      ));
                    
              }   
              else {
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array(),
                  "totales"            =>  array("pieza"=>intval( self::total_campos_entrada_home($where_total)->pieza ), "metro"=>intval( self::total_campos_entrada_home($where_total)->metros ), "kilogramo"=>intval( self::total_campos_entrada_home($where_total)->kilogramos )), 
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           

      }  


///////////////////////////////////////HOME//////////////////////////////////




////////////////////////////////////////Salida/////////////////////////////////////

    
      public function total_campos_salida_home($where) {

              $this->db->select("SUM((id_medida =1) * cantidad_um) as metros", FALSE);
              $this->db->select("SUM((id_medida =2) * cantidad_um) as kilogramos", FALSE);
              $this->db->select("COUNT(m.id_medida) as 'pieza'");
              
             
              $this->db->from($this->historico_registros_salidas.' as m');
              $this->db->where($where);

             $result = $this->db->get();
          
              if ( $result->num_rows() > 0 )
                 return $result->row();
              else
                 return False;
              $result->free_result();              

       }  


     public function total_salida_home($where){
              $id_session = $this->session->userdata('id');
              $this->db->from($this->historico_registros_salidas.' as m');
              $this->db->where($where);
              $cant = $this->db->count_all_results();          
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         
       }           
   public function buscador_salida_home($data){

          $cadena = $data['search']['value'];
          $inicio = $data['start'];
          $largo = $data['length'];
          $estatus= $data['extra_search'];
          $id_estatus= $data['id_estatus'];
          $id_empresa= $data['proveedor'];


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
                        $columna = 'm.mov_salida';
                     break;
                   case '6':
                              $columna= 'p.nombre';
                     break;
                   case '7':
                              $columna= 'm.id_lote, m.consecutivo';  
                     break;
                   case '8':
                        $columna = 'm.fecha_salida';
                     break;
                   
                   default:
                       $columna = 'm.codigo';
                     break;
                 }       


          $donde = '';
         if ($id_empresa!="") {
            $id_empre =  self::check_existente_proveedor_entrada($id_empresa);
            $donde .= ' AND ( m.id_cliente  =  '.$id_empre.' ) ';
        } else 
        {
           $donde .= ' ';
        }

          $fechas = ' ';
          if  ( ($data['fecha_inicial'] !="") and  ($data['fecha_final'] !="")) {
                          
                           $fecha_inicial = date( 'Y-m-d', strtotime( $data['fecha_inicial'] ));
                           $fecha_final = date( 'Y-m-d', strtotime( $data['fecha_final'] ));
                          
                           $fechas .= ' AND ( ( DATE_FORMAT((m.fecha_salida),"%Y-%m-%d")  >=  "'.$fecha_inicial.'" )  AND  ( DATE_FORMAT((m.fecha_salida),"%Y-%m-%d")  <=  "'.$fecha_final.'" ) )'; 
                          
          } else {
           $fechas .= ' ';
          }


          //productos
          $id_descripcion= $data['id_descripcion'];
          $id_color= $data['id_color'];
          $id_composicion= $data['id_composicion'];
          $id_calidad= $data['id_calidad'];


          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); 

          $this->db->select('m.id, m.mov_salida,m.id_empresa, m.factura, m.id_descripcion, m.id_operacion');
          $this->db->select('m.id_color, m.id_composicion, m.id_calidad, m.referencia');
          $this->db->select('m.id_medida,  m.cantidad_royo, m.ancho, m.precio, m.codigo, m.comentario');
          $this->db->select('m.id_estatus, m.id_lote, m.consecutivo, m.id_cargador, m.id_usuario, m.fecha_mac fecha, m.fecha_entrada');
          $this->db->select('c.hexadecimal_color, c.color , p.nombre');
          $this->db->select('m.cliente, m.cargador');
          
          if ($estatus=="apartado") {
              $this->db->select('pr.nombre as dependencia', FALSE);
          }

          $this->db->select('m.cantidad_um, u.medida');

          $this->db->select('
                        CASE m.id_apartado
                          WHEN "1" THEN "ab1d1d"
                           WHEN "2" THEN "f1a914"
                           WHEN "3" THEN "14b80f"
                           
                           WHEN "4" THEN "ab1d1d"
                           WHEN "5" THEN "f1a914"
                           WHEN "6" THEN "14b80f"

                           ELSE "No Apartado"
                        END AS apartado
            ',False);

          $this->db->select("( CASE WHEN m.id_medida = 1 THEN m.cantidad_um ELSE 0 END ) AS metros", FALSE);
          $this->db->select("( CASE WHEN m.id_medida = 2 THEN m.cantidad_um ELSE 0 END ) AS kilogramos", FALSE);
          
          $this->db->select("( CASE WHEN m.devolucion <> 0 THEN 'red' ELSE 'black' END ) AS color_devolucion", FALSE);
         
          $this->db->from($this->historico_registros_salidas.' as m');
          $this->db->join($this->colores.' As c' , 'c.id = m.id_color','LEFT');
          $this->db->join($this->unidades_medidas.' As u' , 'u.id = m.id_medida','LEFT');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_cliente','LEFT');


          if ($estatus=="apartado") {
              $this->db->join($this->usuarios.' As us' , 'us.id = m.id_usuario_apartado','LEFT');
              $this->db->join($this->proveedores.' As pr', 'us.id_cliente = pr.id','LEFT');

          }    
          
          $where = '(
                      (
                         ( m.estatus_salida = "0" )  and ( m.id_estatus =  '.$id_estatus.' )
                      ) 
                       AND
                      (
                        ( m.codigo LIKE  "%'.$cadena.'%" ) OR (m.id_descripcion LIKE  "%'.$cadena.'%") OR (c.color LIKE  "%'.$cadena.'%")  OR
                        ( CONCAT(m.cantidad_um," ",u.medida) LIKE  "%'.$cadena.'%" ) OR (CONCAT(m.ancho," cm") LIKE  "%'.$cadena.'%")  OR
                        ( m.mov_salida LIKE  "%'.$cadena.'%" ) OR ((DATE_FORMAT((m.fecha_salida),"%d-%m-%Y") ) LIKE  "%'.$cadena.'%") OR 
                        (p.nombre LIKE  "%'.$cadena.'%") OR  (CONCAT(m.id_lote,"-",m.consecutivo) LIKE  "%'.$cadena.'%") 
                       )
            ) ' ;   


          $where_total = '( m.estatus_salida = "0" )  and ( m.id_estatus =  '.$id_estatus.' )';

           if ( (($id_calidad!="0") AND ($id_calidad!="") AND ($id_calidad!= null))
            and (($id_composicion!="0") AND ($id_composicion!="") AND ($id_composicion!= null))
            and (($id_color!="0") AND ($id_color!="") AND ($id_color!= null))
            and (($id_descripcion!="0") AND ($id_descripcion!="") AND ($id_descripcion!= null)) 
            ) {
              $where .= ' AND ( m.id_descripcion  =  "'.$id_descripcion.'" ) AND  ( m.id_color  =  '.$id_color.' )';
              $where .= ' AND ( m.id_composicion  =  '.$id_composicion.' ) AND  ( m.id_calidad  =  '.$id_calidad.' )';
              $where_total .= ' AND ( m.id_descripcion  =  "'.$id_descripcion.'" ) AND  ( m.id_color  =  '.$id_color.' )';
              $where_total .= ' AND ( m.id_composicion  =  '.$id_composicion.' ) AND  ( m.id_calidad  =  '.$id_calidad.' )';
          }    

          elseif
           ( 
               (($id_composicion!="0") AND ($id_composicion!="") AND ($id_composicion!= null))
            and (($id_color!="0") AND ($id_color!="") AND ($id_color!= null))
            and (($id_descripcion!="0") AND ($id_descripcion!="") AND ($id_descripcion!= null)) 
            ) {
              $where .= ' AND ( m.id_descripcion  =  "'.$id_descripcion.'" ) AND  ( m.id_color  =  '.$id_color.' )';
              $where .= ' AND ( m.id_composicion  =  '.$id_composicion.' ) ';
              $where_total .= ' AND ( m.id_descripcion  =  "'.$id_descripcion.'" ) AND  ( m.id_color  =  '.$id_color.' )';
              $where_total .= ' AND ( m.id_composicion  =  '.$id_composicion.' ) ';
          }  

          elseif 
           ( (($id_color!="0") AND ($id_color!="") AND ($id_color!= null))
            and (($id_descripcion!="0") AND ($id_descripcion!="") AND ($id_descripcion!= null)) 
            ) {
              $where .= ' AND ( m.id_descripcion  =  "'.$id_descripcion.'" ) AND  ( m.id_color  =  '.$id_color.' )';
              $where_total .= ' AND ( m.id_descripcion  =  "'.$id_descripcion.'" ) AND  ( m.id_color  =  '.$id_color.' )';
          }  

          elseif  (($id_descripcion!="0") AND ($id_descripcion!="") AND ($id_descripcion!= null)) {
              $where .= ' AND ( m.id_descripcion  =  "'.$id_descripcion.'" )';
              $where_total  .= ' AND ( m.id_descripcion  =  "'.$id_descripcion.'" )';
          }  


          $where_total .= $donde.$fechas;

          $this->db->where($where.$donde.$fechas); //

    
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
                           

                          if ($estatus=="apartado") {

                              if (($row->id_apartado) >=4) {
                                $tip_apart= " (Tienda)";
                              } else {
                                $tip_apart= " (Vendedor)";
                              }  
                              $columna6= $row->dependencia.$tip_apart;
                              $columna7= 
                              '<div style="background-color:#'.$row->apartado.';display:block;width:15px;height:15px;margin:0 auto;"></div>';
                          }  else {
                              $columna7=$row->id_lote.'-'.$row->consecutivo; 
                              $columna6= $row->nombre;
                          }  

                           

                           $dato[]= array(
                                      0=>$row->codigo,
                                      1=>$row->id_descripcion,
                                      2=> $row->color.
                                        '<div style="background-color:#'.$row->hexadecimal_color.';display:block;width:15px;height:15px;margin:0 auto;"></div>',
                                      3=>$row->cantidad_um.' '.$row->medida,
                                      4=>$row->ancho.' cm',
                                      5=>
                                          '<a style="padding: 1px 0px 1px 0px;" href="'.base_url().'detalle_salidas/'.base64_encode($row->mov_salida).'/'.base64_encode($row->cliente).'/'.base64_encode($row->cargador).'" 
                                          type="button" class="btn btn-success btn-block">'.$row->mov_salida.'</a>',
                                      6=>$columna6,
                                      7=>$columna7,
                                      8=> date( 'd-m-Y', strtotime($row->fecha_salida)),
                                      9=>$row->metros,
                                      10=>$row->kilogramos,
                                      11=>$row->color_devolucion,
                                    );                    
                      }

                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_salida_home($where_total) ),  
                        "recordsFiltered" => $registros_filtrados, 
                        "data"            =>  $dato, 
                        "totales"            =>  array("pieza"=>intval( self::total_campos_salida_home($where_total)->pieza ), "metro"=>intval( self::total_campos_salida_home($where_total)->metros ), "kilogramo"=>intval( self::total_campos_salida_home($where_total)->kilogramos )), 

                      ));
                    
              }   
              else {
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array(),
                  "totales"            =>  array("pieza"=>intval( self::total_campos_salida_home($where_total)->pieza ), "metro"=>intval( self::total_campos_salida_home($where_total)->metros ), "kilogramo"=>intval( self::total_campos_salida_home($where_total)->kilogramos )), 
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           

      }  
 


///////////////////////////////devolucion_Home////////////////////////////

      public function total_cero_baja($where, $where_cond){
              $id_session = $this->session->userdata('id');

              $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); 

              $this->db->select("p.referencia,p.descripcion, p.minimo, p.imagen, p.precio, c.hexadecimal_color,c.color,co.composicion,ca.calidad");
              $this->db->select("COUNT(m.referencia) as 'suma'");
              $this->db->select("p.id_color, p.id_composicion, p.id_calidad");

              $this->db->from($this->productos.' as p');
              $this->db->join($this->colores.' As c', 'p.id_color = c.id','LEFT');
              $this->db->join($this->composiciones.' As co', 'p.id_composicion = co.id','LEFT');
              $this->db->join($this->calidades.' As ca', 'p.id_calidad = ca.id','LEFT');
              $this->db->join($this->registros.' As m', 'p.referencia = m.referencia','LEFT');

              if  ($where_cond!='') {
                $this->db->where($where_cond);
              }  

              $this->db->group_by("p.referencia,p.descripcion, p.minimo, p.imagen, p.precio, c.hexadecimal_color,c.color,co.composicion,ca.calidad");
              
              $this->db->having($where);


             $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {
                  $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                  $found_rows = $cantidad_consulta->row(); 
                  $registros_filtrados =  ( (int) $found_rows->cantidad);
              }  
              
              $cant = $registros_filtrados;
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         
       }

    public function buscador_cero_baja($data){

          $cadena = $data['search']['value'];
          $inicio = $data['start'];
          $largo = $data['length'];
          $estatus= $data['extra_search'];

                   //productos
          $id_descripcion= $data['id_descripcion'];
          $id_color= $data['id_color'];
          $id_composicion= $data['id_composicion'];
          $id_calidad= $data['id_calidad'];

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];

          switch ($columa_order) {
                   case '0':
                        $columna = 'p.referencia';
                     break;
                   case '1':
                        $columna = 'p.descripcion';
                     break;
                   case '2':
                        $columna = 'suma'; // y suma = COUNT(m.referencia) p.minimo
                     break;
                   case '3':
                        $columna = 'p.imagen'; //
                     break;
                   case '4':
                        $columna = 'c.color';
                     break;
                   case '5':
                        $columna = 'p.comentario';
                     break;
                   case '6':
                              $columna= 'co.composicion';
                     break;
                   case '7':
                              $columna= 'ca.calidad';
                     break;
                   case '8':
                        $columna = 'p.precio';
                     break;
                   
                   default:
                       $columna = 'p.referencia';
                     break;
                 }           


          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); 

           $this->db->select('p.referencia, p.comentario');
          $this->db->select('p.descripcion, p.minimo, p.imagen, p.precio');
          $this->db->select('c.hexadecimal_color,c.color nombre_color');
          $this->db->select("co.composicion", FALSE);  
          $this->db->select("ca.calidad", FALSE);  
          $this->db->select("COUNT(m.referencia) as 'suma'");

          $this->db->select("( CASE WHEN m.id_medida = 1 THEN m.cantidad_um ELSE 0 END ) AS metros", FALSE);
          $this->db->select("( CASE WHEN m.id_medida = 2 THEN m.cantidad_um ELSE 0 END ) AS kilogramos", FALSE);

          $this->db->from($this->productos.' as p');
          $this->db->join($this->colores.' As c', 'p.id_color = c.id','LEFT');
          $this->db->join($this->composiciones.' As co', 'p.id_composicion = co.id','LEFT');
          $this->db->join($this->calidades.' As ca', 'p.id_calidad = ca.id','LEFT');
          $this->db->join($this->registros.' As m', 'p.referencia = m.referencia','LEFT');


          //(CONCAT("Reales:",count(m.referencia)) LIKE  "%'.$cadena.'%")  OR  no se puede
          $where = '(
                      
                      (
                        ( p.referencia LIKE  "%'.$cadena.'%" ) OR (p.descripcion LIKE  "%'.$cadena.'%") OR (CONCAT("Optimo:",p.minimo) LIKE  "%'.$cadena.'%")  OR
                        (c.color LIKE  "%'.$cadena.'%") OR (p.comentario LIKE  "%'.$cadena.'%")  OR
                        (co.composicion LIKE  "%'.$cadena.'%")  OR
                        ( ca.calidad LIKE  "%'.$cadena.'%" )  OR 
                        ( p.precio LIKE  "%'.$cadena.'%" ) 
                       )

            ) ' ; 


         $where_cond ='';


         /*
          
          if ($id_descripcion!="") {
              $where .= ' AND ( p.descripcion  =  "'.$id_descripcion.'" ) AND  ( p.id_color  =  '.$id_color.' )';
              $where .= ' AND ( p.id_composicion  =  '.$id_composicion.' ) AND  ( p.id_calidad  =  '.$id_calidad.' )';

              $where_cond .= '( ( p.descripcion  =  "'.$id_descripcion.'" ) AND  ( p.id_color  =  '.$id_color.' )';
              $where_cond .= ' AND ( p.id_composicion  =  '.$id_composicion.' ) AND  ( p.id_calidad  =  '.$id_calidad.' ) )';
          }

          */
          
         if ( (($id_calidad!="0") AND ($id_calidad!="") AND ($id_calidad!= null))
            and (($id_composicion!="0") AND ($id_composicion!="") AND ($id_composicion!= null))
            and (($id_color!="0") AND ($id_color!="") AND ($id_color!= null))
            and (($id_descripcion!="0") AND ($id_descripcion!="") AND ($id_descripcion!= null)) 
            ) {

              $where .= ' AND ( p.descripcion  =  "'.$id_descripcion.'" ) AND  ( p.id_color  =  '.$id_color.' )';
              $where .= ' AND ( p.id_composicion  =  '.$id_composicion.' ) AND  ( p.id_calidad  =  '.$id_calidad.' )';
              $where_cond = '( p.descripcion  =  "'.$id_descripcion.'" ) AND  ( p.id_color  =  '.$id_color.' )';
              $where_cond .= ' AND ( p.id_composicion  =  '.$id_composicion.' ) AND  ( p.id_calidad  =  '.$id_calidad.' )';
          }    
          elseif
           ( 
               (($id_composicion!="0") AND ($id_composicion!="") AND ($id_composicion!= null))
            and (($id_color!="0") AND ($id_color!="") AND ($id_color!= null))
            and (($id_descripcion!="0") AND ($id_descripcion!="") AND ($id_descripcion!= null)) 
            ) {
              $where .= ' AND ( p.descripcion  =  "'.$id_descripcion.'" ) AND  ( p.id_color  =  '.$id_color.' )';
              $where .= ' AND ( p.id_composicion  =  '.$id_composicion.' ) ';
              $where_cond = '( p.descripcion  =  "'.$id_descripcion.'" ) AND  ( p.id_color  =  '.$id_color.' )';
              $where_cond .= ' AND ( p.id_composicion  =  '.$id_composicion.' ) ';
          }  

          elseif 
           ( (($id_color!="0") AND ($id_color!="") AND ($id_color!= null))
            and (($id_descripcion!="0") AND ($id_descripcion!="") AND ($id_descripcion!= null)) 
            ) {
              $where .= ' AND ( p.descripcion  =  "'.$id_descripcion.'" ) AND  ( p.id_color  =  '.$id_color.' )';
              $where_cond = '( p.descripcion  =  "'.$id_descripcion.'" ) AND  ( p.id_color  =  '.$id_color.' )';
          }  

          elseif  (($id_descripcion!="0") AND ($id_descripcion!="") AND ($id_descripcion!= null)) {
              $where .= ' AND ( p.descripcion  =  "'.$id_descripcion.'" )';
              $where_cond  = '( p.descripcion  =  "'.$id_descripcion.'" )';
          }            
        
    
          

          $this->db->where($where);

          $this->db->order_by($columna, $order); 

          $this->db->group_by("p.referencia,p.descripcion, p.minimo, p.imagen, p.precio, c.hexadecimal_color,c.color,co.composicion,ca.calidad");
          //paginacion


         if ($estatus=="cero") {
              $this->db->having('suma <= 0');
              $where_total = 'suma <= 0';
          }   

          if ($estatus=="baja") {
              $this->db->having('suma <= p.minimo');
              $where_total = 'suma <= p.minimo';
          }             
          
 

          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);


                  foreach ($result->result() as $row) {
                           $dato[]= array(
                                      0=>$row->referencia, 
                                      1=>$row->descripcion,
                                      2=>'Optimo:'.$row->minimo.'<br/>  Reales:'. $row->suma,
                                      3=>
                                        '<img src="'.base_url().'uploads/productos/'.$row->imagen.'" border="0" width="75" height="75">',
                                      4=>$row->nombre_color.                                      
                                        '<div style="background-color:#'.$row->hexadecimal_color.';display:block;width:15px;height:15px;margin:0 auto;"></div>',
                                      5=> $row->comentario, 
                                      6=>$row->composicion,
                                      7=>$row->calidad,
                                      8=>$row->precio,
                                      9=>$row->metros,
                                      10=>$row->kilogramos,
                                      11=>"black",
                                    );                    

                      }

                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_cero_baja($where_total,$where_cond) ),  
                        "recordsFiltered" => $registros_filtrados, 
                        "data"            =>  $dato, 
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


///////////////////buscador top

     public function total_top(){

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); 

          $this->db->select("p.referencia,p.descripcion, p.minimo, p.imagen, p.precio, c.hexadecimal_color,c.color,co.composicion,ca.calidad");
          $this->db->select("COUNT(m.referencia) as 'suma'");
          $this->db->select("p.id_color, p.id_composicion, p.id_calidad");

          $this->db->from($this->productos.' as p');
          $this->db->join($this->colores.' As c', 'p.id_color = c.id','LEFT');
          $this->db->join($this->composiciones.' As co', 'p.id_composicion = co.id','LEFT');
          $this->db->join($this->calidades.' As ca', 'p.id_calidad = ca.id','LEFT');
          $this->db->join($this->historico_registros_salidas.' As m', 'p.referencia = m.referencia','LEFT');

          $this->db->group_by("p.referencia,p.descripcion, p.minimo, p.imagen, p.precio, c.hexadecimal_color,c.color,co.composicion,ca.calidad");

          $result = $this->db->get();

          if ( $result->num_rows() > 0 ) {

                $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                $found_rows = $cantidad_consulta->row(); 
                $registros_filtrados =  ( (int) $found_rows->cantidad);
          }   

           $cant = $registros_filtrados;
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         
       }      


    public function buscador_top($data){

          $cadena = $data['search']['value'];
          $inicio = $data['start'];
          $largo = $data['length'];
          $estatus= $data['extra_search'];

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];

          switch ($columa_order) {
                   case '0':
                        $columna = 'p.referencia';
                     break;
                   case '1':
                        $columna = 'p.descripcion';
                     break;
                   case '2':
                        $columna = 'suma'; // y suma = COUNT(m.referencia) p.minimo
                     break;
                   case '3':
                        $columna = 'p.imagen'; //
                     break;
                   case '4':
                        $columna = 'c.color';
                     break;
                   case '5':
                        $columna = 'p.comentario';
                     break;
                   case '6':
                              $columna= 'co.composicion';
                     break;
                   case '7':
                              $columna= 'ca.calidad';
                     break;
                   case '8':
                        $columna = 'p.precio';
                     break;
                   
                   default:
                       $columna = 'p.referencia';
                     break;
                 }           

 

          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); 

           $this->db->select('p.referencia, p.comentario');
          $this->db->select('p.descripcion, p.minimo, p.imagen, p.precio');
          $this->db->select('c.hexadecimal_color,c.color nombre_color');
          $this->db->select("co.composicion", FALSE);  
          $this->db->select("ca.calidad", FALSE);  



         $fechas = ' ';
          if  ( ($data['fecha_inicial'] !="") and  ($data['fecha_final'] !="")) {
                           $fecha_inicial = date( 'Y-m-d', strtotime( $data['fecha_inicial'] ));
                           $fecha_final = date( 'Y-m-d', strtotime( $data['fecha_final'] ));
                          
                            $fechas .= ' AND ( ( DATE_FORMAT((m.fecha_salida),"%Y-%m-%d")  >=  "'.$fecha_inicial.'" )  AND  ( DATE_FORMAT((m.fecha_salida),"%Y-%m-%d")  <=  "'.$fecha_final.'" ) )'; 


                          
          } else {
           $fechas .= ' ';
          }

          $this->db->select("COUNT(m.referencia) as 'suma'");
          

          $this->db->select("( CASE WHEN m.id_medida = 1 THEN m.cantidad_um ELSE 0 END ) AS metros", FALSE);
          $this->db->select("( CASE WHEN m.id_medida = 2 THEN m.cantidad_um ELSE 0 END ) AS kilogramos", FALSE);

          $this->db->from($this->productos.' as p');
          $this->db->join($this->colores.' As c', 'p.id_color = c.id','LEFT');
          $this->db->join($this->composiciones.' As co', 'p.id_composicion = co.id','LEFT');
          $this->db->join($this->calidades.' As ca', 'p.id_calidad = ca.id','LEFT');
          $this->db->join($this->historico_registros_salidas.' As m', 'p.referencia = m.referencia'.$fechas.'','LEFT');

          $where = '(
                      
                      (
                        ( p.referencia LIKE  "%'.$cadena.'%" ) OR (p.descripcion LIKE  "%'.$cadena.'%") OR 
                        (c.color LIKE  "%'.$cadena.'%") OR (p.comentario LIKE  "%'.$cadena.'%")  OR
                        (co.composicion LIKE  "%'.$cadena.'%")  OR
                        ( ca.calidad LIKE  "%'.$cadena.'%" )  OR 
                        ( p.precio LIKE  "%'.$cadena.'%" ) 
                       )

            ) ' ; 


          $this->db->where($where);

          $this->db->order_by($columna, $order); 

          $this->db->group_by("p.referencia,p.descripcion, p.minimo, p.imagen, p.precio, c.hexadecimal_color,c.color,co.composicion,ca.calidad");
          //paginacion

          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);


                  foreach ($result->result() as $row) {
                           $dato[]= array(
                                      0=>$row->referencia, 
                                      1=>$row->descripcion,
                                      2=>$row->suma,
                                      3=>
                                        '<img src="'.base_url().'uploads/productos/'.$row->imagen.'" border="0" width="75" height="75">',
                                      4=>$row->nombre_color.                                      
                                        '<div style="background-color:#'.$row->hexadecimal_color.';display:block;width:15px;height:15px;margin:0 auto;"></div>',
                                      5=> $row->comentario, 
                                      6=>$row->composicion,
                                      7=>$row->calidad,
                                      8=>$row->precio,
                                      9=>$row->metros,
                                      10=>$row->kilogramos,
                                      11=>"black",
                                    );                    

                      }

                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_top() ),  
                        "recordsFiltered" => $registros_filtrados, 
                        "data"            =>  $dato, 
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



//////////////////////////////////////////////////fin de reportes presentaciones/////////////////////////////////////////////////////////////////

        public function listado_entradas( $data ){

          $id_session = $this->session->userdata('id');
                    
          $this->db->distinct();                    
          $this->db->select('m.movimiento,m.id_empresa,p.nombre, m.factura, m.id_operacion,m.devolucion');
		      $this->db->select("(DATE_FORMAT(m.fecha_entrada,'%d-%m-%Y %H:%i')) as fecha",false);
          $this->db->select("( CASE WHEN m.devolucion <> 0 THEN 'red' ELSE 'black' END ) AS color_devolucion", FALSE);
		  
          $this->db->from($this->historico_registros_entradas.' as m');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_empresa','LEFT');

          $this->db->where('m.id_usuario',$id_session);
          $this->db->where('m.id_operacion',$data['id_operacion']);

          $this->db->order_by('m.movimiento', 'desc'); 

           $result = $this->db->get();
        
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }        

        public function listado_salidas( $data ){

          $id_session = $this->session->userdata('id');
                    
          $this->db->distinct();                    
          $this->db->select('m.mov_salida ,p.nombre cliente, ca.nombre cargador, m.factura');   //movimiento  id_empresa  p.nombre, , m.id_operacion
          $this->db->select("(DATE_FORMAT(m.fecha_salida,'%d-%m-%Y')) as fecha",false);

      
          $this->db->from($this->historico_registros_salidas.' as m');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_cliente','LEFT');
          $this->db->join($this->cargadores.' As ca' , 'ca.id = m.id_cargador','LEFT');


          $this->db->where('m.id_usuario',$id_session);
          $this->db->where('m.id_operacion',$data['id_operacion']);

          $this->db->order_by('m.mov_salida', 'desc'); 

           $result = $this->db->get();
        
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }  



































//////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Reportes/////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

    
 



	} 
?>
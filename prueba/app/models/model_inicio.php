<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

  class model_inicio extends CI_Model {
    
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





/////////////////////////////////////////////////////INICIO vendedores////////////////////////////////////////////////





    public function buscador_inicio($data){

          $cadena = $data['search']['value'];
          $inicio = $data['start'];
          $largo = $data['length'];

          $id_estatus= $data['id_estatus'];
            $id_color= $data['id_color'];


          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //

           $this->db->select('p.referencia');
          $this->db->select('p.descripcion, p.minimo, p.imagen, p.precio');
          $this->db->select('c.hexadecimal_color,c.color nombre_color');
          $this->db->select("co.composicion", FALSE);  
          $this->db->select("ca.calidad", FALSE);  
          $this->db->select("COUNT(m.referencia) as 'suma'");

          $this->db->from($this->productos.' as p');
          $this->db->join($this->colores.' As c', 'p.id_color = c.id','LEFT');
          $this->db->join($this->composiciones.' As co', 'p.id_composicion = co.id','LEFT');
          $this->db->join($this->calidades.' As ca', 'p.id_calidad = ca.id','LEFT');
          $this->db->join($this->registros.' As m', 'p.referencia = m.referencia','LEFT');

          //filtro de busqueda
          $where = '(
                      
                      
                      (
                        ( p.referencia LIKE  "%'.$cadena.'%" ) OR (p.descripcion LIKE  "%'.$cadena.'%") OR (p.minimo LIKE  "%'.$cadena.'%")  OR
                        ( p.precio LIKE  "%'.$cadena.'%" ) OR (c.color LIKE  "%'.$cadena.'%") OR (co.composicion LIKE  "%'.$cadena.'%")  OR
                        ( ca.calidad LIKE  "%'.$cadena.'%" ) 
                       )

            ) ' ;   

          if ($id_estatus!=-1) {
              $where .= ' AND ( m.id_estatus = '.$id_estatus.' ) ' ;   
          }    

          if ($id_color!=-1) {
              $where .= ' AND ( m.id_color = '.$id_color.' ) ' ;   
          }    


          $this->db->where($where);


          $this->db->group_by("p.referencia,p.descripcion, p.minimo, p.imagen, p.precio, c.hexadecimal_color,c.color,co.composicion,ca.calidad");

          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);

                  $i=0;  $j=-1;  
                  //$datos[]= $array();
                  foreach ($result->result() as $row) {

                           $j= $j+ ((intval(($i % 4) ==0))*1); 
                           $x= intval($i % 4) ; 
                           if ($x==0) {
                              $dato[0]="";$dato[1]="";$dato[2]="";$dato[3]="";
                           }

                           $dato[$x][0]=  $row->imagen; //substr($row->imagen,0,-4).'_thumb'.substr($row->imagen,-4);
                           $dato[$x][1]=  $row->descripcion;
                           $dato[$x][2]=  $row->nombre_color;
                           $dato[$x][3]=  $row->hexadecimal_color;
                           $dato[$x][4]=  $row->referencia;
                           $dato[$x][5]=  ( self::cantidad_metro($row->referencia) );  

                           /*'<div class="col-lg-11 col-md-11 col-xs-11 thumb">
                                           <a class="thumbnail col-md-12 col-lg-12 col-xs-12" data-toggle="modal" data-target="#myModal">
                                                <img class="img-responsive" src="'.base_url().'uploads/productos/thumbnail/'.substr($row->imagen,0,-4).'_thumb'.substr($row->imagen,-4).'" alt="" border="0" width="260" height="195">
                                                <span class="col-xs-12 col-md-12 col-lg-12 nombre">'.$row->descripcion.'</span>
                                                <span class="col-xs-12 col-md-12 col-lg-12 color">'.$row->nombre_color.
                                                    '<div style="background-color:#'.$row->hexadecimal_color.';display:block;width:15px;height:15px;margin:0 auto;"></div>
                                                </span>
                                                <span class="col-xs-12 col-md-12 col-lg-12 text-right cantidadtotal">250 mtrs disponibles</span>
                                            </a>
                                          </div>';    */
                           $datas[$j] = $dato;
                        $i++;
                      }

                      $datos=$datas;
                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_productos_vendedor() ),  
                        "recordsFiltered" => $registros_filtrados, 
                        "data"            =>  $datas, 
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


    public function cantidad_metro($referencia){


          $id_session = $this->session->userdata('id');

          $this->db->select('u.medida, SUM(m.cantidad_um) as total');

          //$this->db->select("CONCAT(m.id_medida,' ',u.medida) AS cantidad", FALSE);
         
          $this->db->from($this->registros.' as m');
          $this->db->join($this->unidades_medidas.' As u' , 'u.id = m.id_medida','LEFT');

          $where = '(
                        (
                          ( ( m.id_usuario_apartado = "'.$id_session.'" )  AND  (m.id_apartado = 1) ) OR (m.id_apartado = 0)
                          
                        ) 
                       AND
                      (
                        ( m.referencia = "'.$referencia.'")  AND (estatus_salida  = "0")
                       )

                    )';   

          $this->db->where($where);
          
          $this->db->group_by("u.medida");
          $this->db->order_by('u.medida', 'desc'); 
          
          //filtro de busqueda

          $result = $this->db->get();
          if ($result->num_rows() > 0) {

                $valor =''; 
                foreach ($result->result() as $filas)
                  {                   
                     $valor .=    $filas->total.' '.$filas->medida.'<br/>' ;
                  }
                  return 'Disponibilidad: '.$valor;
          }

            
          else 
             return 'Productos sin existencia';
            $result->free_result();    

      }        





      public function total_productos_vendedor(){
              $id_session = $this->session->userdata('id');
              $this->db->from($this->productos.' as p');
              $cant = $this->db->count_all_results();          
     
              if ( $cant > 0 )
                 return $cant;
              else
                 return 0;         
       }


   /////////////////////////////////////////Detalles del producto

 public function el_producto($data){

          $id_session = $this->db->escape($this->session->userdata('id'));


          $this->db->select('p.referencia');
          $this->db->select('p.descripcion, p.minimo, p.imagen, p.precio');
          $this->db->select('c.hexadecimal_color,c.color nombre_color');
          $this->db->select("co.composicion", FALSE);  
          $this->db->select("ca.calidad", FALSE);  

          $this->db->from($this->productos.' as p');
          $this->db->join($this->colores.' As c', 'p.id_color = c.id','LEFT');
          $this->db->join($this->composiciones.' As co', 'p.id_composicion = co.id','LEFT');
          $this->db->join($this->calidades.' As ca', 'p.id_calidad = ca.id','LEFT');

          $this->db->where('p.referencia', $data['referencia']);

          $result = $this->db->get();
          if ($result->num_rows() > 0)
              return $result->row();
          else 
              return FALSE;
          $result->free_result();
}             


    public function los_productos($data){


          $id_session = $this->session->userdata('id');

          $this->db->select('m.id, m.movimiento,m.id_empresa, m.factura, m.id_descripcion, m.id_operacion, m.id_apartado');
          $this->db->select('m.id_color, m.id_composicion, m.id_calidad, m.referencia');
          $this->db->select('m.id_medida,  m.cantidad_royo, m.ancho, m.precio, m.codigo, m.comentario');
          $this->db->select('m.id_estatus, m.id_lote, m.consecutivo, m.id_cargador, m.id_usuario, m.fecha_mac fecha, m.fecha_entrada');
          $this->db->select('c.hexadecimal_color, c.color, u.medida,p.nombre');

          $this->db->select("CONCAT(m.id_medida,' ',u.medida) AS cantidad", FALSE);
         
          $this->db->from($this->registros.' as m');
          $this->db->join($this->colores.' As c' , 'c.id = m.id_color','LEFT');
          $this->db->join($this->unidades_medidas.' As u' , 'u.id = m.id_medida','LEFT');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_empresa','LEFT');

          $where = '(
                        (
                          ( ( m.id_usuario_apartado = "'.$id_session.'" )  AND  (m.id_apartado = 1) ) OR (m.id_apartado = 0)
                          
                        ) 
                       AND
                      (
                        ( m.referencia = "'.$data['referencia'].'")  AND (estatus_salida  = "0")
                       )

                    )';   

          $this->db->where($where);
  
          //filtro de busqueda

          $result = $this->db->get();
          if ($result->num_rows() > 0)
              return $result->result();
          else 
              return FALSE;
          $result->free_result();    

      }  


            //cambiar estatus de unidad
        public function marcando_apartado( $data ){
              
                $id_session = $this->session->userdata('id');


              $this->db->set( 'precio_anterior', '((precio*id_apartado)+(precio_anterior*(1 XOR id_apartado)) )', FALSE  );
              $this->db->set( 'precio', '((precio_cambio*id_apartado)+(precio*(1 XOR id_apartado)) )', FALSE  );

              //$this->db->set( 'precio', 'precio_cambio', FALSE  );



                $this->db->set( 'id_usuario_apartado',  $id_session );
                $this->db->set( 'id_apartado', '(1 XOR id_apartado)', FALSE );
                $this->db->where('id', $data['id'] );
                $this->db->update($this->registros );



                $this->db->select( 'id_apartado' );
                $this->db->where('id', $data['id'] );
                $colo_apartar = $this->db->get($this->registros );

               $apartado = $colo_apartar->row();
               return $apartado->id_apartado;

        
        }     




        //****************este es para obtener proveedor y factura temporal************************************************************

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



    //listado de los productos apartados para un usuario

        public function listado_apartado(){

          $id_session = $this->session->userdata('id');
                    
          $this->db->select('m.id,  m.factura, m.id_descripcion, m.id_operacion');
          $this->db->select('m.id_color, m.id_composicion, m.id_calidad, m.referencia');
          $this->db->select('m.id_medida, m.cantidad_um, m.cantidad_royo, m.ancho, m.precio, m.codigo, m.comentario');
          $this->db->select('m.id_estatus, m.id_lote, m.consecutivo, m.id_cargador, m.id_usuario, m.fecha_mac fecha');

          $this->db->select('c.hexadecimal_color, u.medida');

          $this->db->from($this->registros.' as m');
          $this->db->join($this->colores.' As c' , 'c.id = m.id_color','LEFT');
          $this->db->join($this->unidades_medidas.' As u' , 'u.id = m.id_medida','LEFT');

          $this->db->where('m.id_usuario_apartado',$id_session);
          $this->db->where('m.id_apartado',1);

           $result = $this->db->get();
        
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }        



        //cambiar estatus de unidad
        public function apartar_definitivamente( $data ){
              
                $id_session = $this->session->userdata('id');
                $fecha_hoy = date('Y-m-d H:i:s');  

                $this->db->set( 'fecha_vencimiento', $fecha_hoy  );  
                $this->db->set( 'fecha_apartado', $fecha_hoy  );  
                $this->db->set( 'id_cliente_apartado',  $data['id_cliente'] );
                $this->db->set( 'id_apartado', 2, FALSE );
                
                $this->db->where('id_usuario_apartado', $id_session );
                $this->db->where('id_apartado', 1 );

                $this->db->update($this->registros );

                if ($this->db->affected_rows() > 0) {
                  return TRUE;
                }  else
                   return FALSE;
       
        }         
   

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







  } 






?>

<?php 
class Pdfs_model extends CI_Model
{
    function __construct()
    {
        
        parent::__construct();
            $this->load->database("default");
            $this->key_hash    = $_SERVER['HASH_ENCRYPT'];
            $this->timezone    = 'UM1';

            $this->registros_temporales               = $this->db->dbprefix('temporal_registros');
                $this->productos               = $this->db->dbprefix('catalogo_productos');
                  $this->proveedores             = $this->db->dbprefix('catalogo_empresas');
                  $this->unidades_medidas        = $this->db->dbprefix('catalogo_unidades_medidas');

                  $this->operaciones             = $this->db->dbprefix('catalogo_operaciones');
                  $this->movimientos               = $this->db->dbprefix('movimientos');
                  $this->colores                 = $this->db->dbprefix('catalogo_colores');
                  $this->composiciones                 = $this->db->dbprefix('catalogo_composicion');
                  $this->unidades_medidas        = $this->db->dbprefix('catalogo_unidades_medidas');
                  $this->registros               = $this->db->dbprefix('registros_entradas');
                  $this->registros_salidas       = $this->db->dbprefix('registros_salidas');
                  $this->cargadores             = $this->db->dbprefix('catalogo_cargador');

                  $this->historico_registros_entradas = $this->db->dbprefix('historico_registros_entradas');
                  $this->historico_registros_salidas = $this->db->dbprefix('historico_registros_salidas');


                    //usuarios
                  $this->usuarios    = $this->db->dbprefix('usuarios');


    }
  
    public function listado_registros($data){

          $id_session = $this->session->userdata('id');
                    
          $this->db->select('m.id, m.movimiento,m.id_empresa, m.factura, m.id_descripcion');
          $this->db->select('m.id_color, m.id_composicion, m.id_calidad, m.referencia');
          $this->db->select('m.id_medida, m.cantidad_um, m.cantidad_royo, m.ancho, m.precio, m.codigo, m.comentario');
          $this->db->select('m.id_estatus, m.id_lote, m.consecutivo, m.id_cargador, m.id_usuario, m.fecha_mac fecha');

          $this->db->select('c.hexadecimal_color, c.color, u.medida,p.nombre');
          $this->db->select('co.composicion');

          
          $this->db->from($this->historico_registros_entradas.' as m');
          $this->db->join($this->colores.' As c' , 'c.id = m.id_color','LEFT');
          $this->db->join($this->unidades_medidas.' As u' , 'u.id = m.id_medida','LEFT');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_empresa','LEFT');
          $this->db->join($this->composiciones.' As co' , 'co.id = m.id_composicion','LEFT');

          $this->db->where('m.id_usuario',$id_session);
          $this->db->where('m.movimiento',$data['id_movimiento']);
          $this->db->where('m.devolucion',$data['dev']);


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



    public function listado_salida($data){

          $id_session = $this->session->userdata('id');
                    
          $this->db->select('m.id, m.mov_salida, m.movimiento,m.id_empresa, m.factura, m.id_descripcion, m.id_operacion');
          $this->db->select('m.id_color, m.id_composicion, m.id_calidad, m.referencia');
          $this->db->select('m.id_medida, m.cantidad_um, m.cantidad_royo, m.ancho, m.precio, m.codigo, m.comentario');
          $this->db->select('m.id_estatus, m.id_lote, m.consecutivo, m.id_cargador, m.id_usuario, m.fecha_mac fecha');

          $this->db->select('c.hexadecimal_color,c.color, u.medida,p.nombre cliente, ca.nombre cargador');

          $this->db->from($this->historico_registros_salidas.' as m');
          $this->db->join($this->colores.' As c' , 'c.id = m.id_color','LEFT');
          $this->db->join($this->unidades_medidas.' As u' , 'u.id = m.id_medida','LEFT');
          $this->db->join($this->proveedores.' As p' , 'p.id = m.id_cliente','LEFT');
          $this->db->join($this->cargadores.' As ca' , 'ca.id = m.id_cargador','LEFT');

          $this->db->where('m.id_usuario',$id_session);
          $this->db->where('m.id_operacion',2);
          $this->db->where('m.mov_salida',$data['id_movimiento']);

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


 public function etiqueta_codigo($data){

          $id_session = $this->session->userdata('id');
                    
          $this->db->select('m.id,  m.movimiento,m.id_empresa, m.factura, m.id_descripcion, m.id_operacion,m.devolucion');
          $this->db->select('m.id_color, m.id_composicion, m.id_calidad, m.referencia');
          $this->db->select('m.id_medida, m.cantidad_um, m.cantidad_royo, m.ancho, m.precio, m.codigo, m.comentario');
          $this->db->select('m.id_estatus, m.id_lote, m.consecutivo, m.id_cargador, m.id_usuario, m.fecha_mac fecha,  co.composicion');

          $this->db->select('c.hexadecimal_color,c.color, u.medida, ca.nombre cargador');

          $this->db->from($this->registros.' as m');
          $this->db->join($this->colores.' As c' , 'c.id = m.id_color','LEFT');
          $this->db->join($this->unidades_medidas.' As u' , 'u.id = m.id_medida','LEFT');
          $this->db->join($this->cargadores.' As ca' , 'ca.id = m.id_cargador','LEFT');
          $this->db->join($this->composiciones.' As co' , 'co.id = m.id_composicion','LEFT');


          $this->db->where('m.codigo',$data['codigo']);

           $result = $this->db->get();
        
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();

  }  






    public function pedido_especifico_vendedor($data){

          $num_mov = $data['num_mov'];
          $id_session = $this->db->escape($this->session->userdata('id'));

          //$this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //

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
            )';   

          $this->db->where($where);

  
           $result = $this->db->get();
        
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
         
      }    






    public function pedido_especifico_tienda($data){
          
          $id_usuario = $data['num_mov'];
          $id_cliente = $data['id_cliente'];

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
            )';   


          $this->db->where($where);

  
           $result = $this->db->get();
        
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();

         
      }  








    public function pedido_especifico_completo($data){

          $mov_salida = $data['num_mov'];
          $id_apartado = $data['id_cliente'];          
          

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
            )';   


       $this->db->where($where);

  
           $result = $this->db->get();
        
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();

         
      }  










}

<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

	class catalogo extends CI_Model {
		
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
			$this->composiciones     = $this->db->dbprefix('catalogo_composicion');
      $this->colores                 = $this->db->dbprefix('catalogo_colores');
      $this->anchos                 = $this->db->dbprefix('catalogo_ancho');
      $this->cargadores                 = $this->db->dbprefix('catalogo_cargador');
      $this->calidades                 = $this->db->dbprefix('catalogo_calidad');

      $this->proveedores             = $this->db->dbprefix('catalogo_empresas');
      $this->actividad_comercial     = $this->db->dbprefix('catalogo_actividad_comercial');
      $this->operaciones             = $this->db->dbprefix('catalogo_operaciones');
      $this->estatuss             = $this->db->dbprefix('catalogo_estatus');
      $this->lotes             = $this->db->dbprefix('catalogo_lotes');

      $this->productos               = $this->db->dbprefix('catalogo_productos');
      
      $this->unidades_medidas        = $this->db->dbprefix('catalogo_unidades_medidas');

      $this->registros_entradas               = $this->db->dbprefix('registros_entradas');

      $this->historico_registros_salidas               = $this->db->dbprefix('historico_registros_salidas');



		}




//////////////////////////dependencia//////////////////////////////


        /*
    $data['val_prod']
    $data['val_color']
    $data['val_comp'] 
    $data['val_calida']  
    */

        public function lista_colores($data){

            $this->db->select("c.color nombre", FALSE);  
            $this->db->select("c.id", FALSE);  
            $this->db->from($this->productos.' as p');
            $this->db->join($this->colores.' As c', 'p.id_color = c.id','LEFT');
            $this->db->where('p.descripcion', $data['val_prod']);
            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }    

        public function lista_composiciones($data){
            //distinct

            $this->db->select("c.composicion nombre", FALSE);  
            $this->db->select("c.id", FALSE);  
            $this->db->from($this->productos.' as p');
            $this->db->join($this->composiciones.' As c', 'p.id_composicion = c.id','LEFT');
            $this->db->where('p.descripcion', $data['val_prod']);
            $this->db->where('p.id_color', $data['val_color']);
            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }   

        public function lista_calidad($data){
            //distinct

            $this->db->select("c.calidad nombre", FALSE);  
            $this->db->select("c.id", FALSE);  
            $this->db->from($this->productos.' as p');
            $this->db->join($this->calidades.' As c', 'p.id_calidad = c.id','LEFT');
            $this->db->where('p.descripcion', $data['val_prod']);
            $this->db->where('p.id_color', $data['val_color']);
            $this->db->where('p.id_composicion', $data['val_comp']);
            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }    


        public function refe_producto($data){
            //distinct

            $this->db->select("p.referencia,p.comentario,p.imagen,p.precio,p.ancho", FALSE);  
            $this->db->from($this->productos.' as p');
            $this->db->where('p.descripcion', $data['val_prod']);
            $this->db->where('p.id_color', $data['val_color']);
            $this->db->where('p.id_composicion', $data['val_comp']);
            $this->db->where('p.id_calidad', $data['val_calida']);
            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->row();
            else
               return False;
            $result->free_result();
        }            

//////////////////////fin de dependencia//////////////////////////////////////
//////////////////////fin de dependencia//////////////////////////////////////
    

    //checar si el codigo de producto existe para entrada


    public function check_existente_codigo($descripcion){
            $this->db->select("codigo", FALSE);         
            $this->db->from($this->registros_entradas);
            $this->db->where('codigo',$descripcion);  
            
            $login = $this->db->get();
            if ($login->num_rows() > 0) {
                $fila = $login->row(); 
                return $fila->codigo;
            }    
            else
                return false;
            $login->free_result();
    } 


    //checar si el proveedor existe para entrada


    public function check_existente_proveedor_entrada($descripcion){
            $this->db->select("id", FALSE);         
            $this->db->from($this->proveedores);
            $this->db->where('nombre',$descripcion);  
           
            
            $login = $this->db->get();
            if ($login->num_rows() > 0) {
                $fila = $login->row(); 
                return $fila->id;
            }    
            else
                return false;
            $login->free_result();
    } 

    
    //checar si el cargador existe para entrada
    public function check_existente_cargador_entrada($descripcion){
            $this->db->select("id", FALSE);         
            $this->db->from($this->cargadores);
            $this->db->where('nombre',$descripcion);  
           
            
            $login = $this->db->get();
            if ($login->num_rows() > 0) {
                $fila = $login->row(); 
                return $fila->id;
            }    
            else
                return false;
            $login->free_result();
    }     

  //-----------consecutivo------------------
        public function listado_consecutivo($id=-1){

          $this->db->select('o.id, o.operacion, o.consecutivo');
          $this->db->from($this->operaciones .' as o');

          if ($id!=-1) {
              $this->db->where('id',$id);  
          } 
          

          $result = $this->db->get();

            if ( $result->num_rows() > 0 )
               return $result->row();
            else
               return False;
            $result->free_result();
        } 


  //-----------estatus------------------

        public function listado_estatus($limit=-1, $offset=-1,$tipo=-1){

          $this->db->select('a.id, a.estatus');
          $this->db->from($this->estatuss.' as a');

          if ($tipo!=-1) {
              $this->db->where('tipo',$tipo);  
          } 
          
          if ($limit!=-1) {
              $this->db->limit($limit, $offset); 
          } 

          $result = $this->db->get();

            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        } 
			
   //-----------lotes------------------

        public function listado_lotes($limit=-1, $offset=-1,$tipo=-1){

          $this->db->select('l.id, l.lote');
          $this->db->from($this->lotes.' as l');
          
          if ($limit!=-1) {
              $this->db->limit($limit, $offset); 
          } 

          $result = $this->db->get();

            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        } 

      //-----------medidas------------------

        public function total_medidas(){
           $this->db->from($this->unidades_medidas);
           $medidas = $this->db->get();            
           return $medidas->num_rows();
        }

        public function listado_medidas($limit=-1, $offset=-1){

          $this->db->select('a.id, a.medida');
          $this->db->from($this->unidades_medidas.' as a');
          
          if ($limit!=-1) {
              $this->db->limit($limit, $offset); 
          } 
          $result = $this->db->get();

            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }        



      public function buscador_medidas($data){
            $this->db->select( 'id' );
            $this->db->select("medida", FALSE);  
            $this->db->from($this->unidades_medidas);
            $this->db->like("medida" ,$data['key'],FALSE);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) 
                      {
                            $dato[]= array("value"=>$row->medida,
                                       "key"=>$row->id
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
      }    

    
    //checar si el medida ya existe
    public function check_existente_medida($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->unidades_medidas);
            $this->db->where('medida',$data['medida']);  
            $this->db->where('estatus',"0");
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 



     public function coger_medida( $data ){
              
            $this->db->select("a.id, a.medida");         
            $this->db->from($this->unidades_medidas.' As a');
            $this->db->where('a.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  

      //crear
        public function anadir_medida( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'medida', $data['medida'] );  

            $this->db->insert($this->unidades_medidas );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }          


        //editar
        public function editar_medida( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );

          $this->db->set( 'medida', $data['medida'] );  
          $this->db->where('id', $data['id'] );
          $this->db->update($this->unidades_medidas );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return FALSE;
                $result->free_result();
        }   


        //eliminar medida
        public function eliminar_medida( $data ){
            $this->db->delete( $this->unidades_medidas, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }


      //-----------composiciones------------------

        public function total_composiciones(){
           $this->db->from($this->composiciones);
           $composiciones = $this->db->get();            
           return $composiciones->num_rows();
        }

        public function listado_composiciones($limit=-1, $offset=-1){

          $this->db->select('c.id, c.composicion');
          $this->db->from($this->composiciones.' as c');
          
          if ($limit!=-1) {
              $this->db->limit($limit, $offset); 
          } 
          $result = $this->db->get();

            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }        



      public function buscador_composiciones($data){
            $this->db->select( 'id' );
            $this->db->select("composicion", FALSE);  
            $this->db->from($this->composiciones);
            $this->db->like("composicion" ,$data['key'],FALSE);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) 
                      {
                            $dato[]= array("value"=>$row->composicion,
                                       "key"=>$row->id
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
      }    

    
    //checar si el composicion ya existe
    public function check_existente_composicion($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->composiciones);
            $this->db->where('composicion',$data['composicion']);  
            $this->db->where('estatus',"0");
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 



     public function coger_composicion( $data ){
              
            $this->db->select("c.id, c.composicion");         
            $this->db->from($this->composiciones.' As c');
            $this->db->where('c.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  

      //crear
        public function anadir_composicion( $data ){
          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'composicion', $data['composicion'] );  

            $this->db->insert($this->composiciones );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }          


        //editar
        public function editar_composicion( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );

          $this->db->set( 'composicion', $data['composicion'] );  
          $this->db->where('id', $data['id'] );
          $this->db->update($this->composiciones );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return FALSE;
                $result->free_result();
        }   


        //eliminar composicion
        public function eliminar_composicion( $data ){
            $this->db->delete( $this->composiciones, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }     



      //-----------actividades------------------

        public function total_actividades(){
           $this->db->from($this->actividad_comercial);
           $actividades = $this->db->get();            
           return $actividades->num_rows();
        }

        public function listado_actividades($limit=-1, $offset=-1,$id=""){

          $this->db->select('a.id, a.actividad');
          $this->db->from($this->actividad_comercial.' as a');

          if ($id!="") {
              $this->db->where($id); 
          } 
          
          if ($limit!=-1) {
              $this->db->limit($limit, $offset); 
          } 
          $result = $this->db->get();

            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }        



      public function buscador_actividades($data){
            $this->db->select( 'id' );
            $this->db->select("actividad", FALSE);  
            $this->db->from($this->actividad_comercial);
            $this->db->like("actividad" ,$data['key'],FALSE);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) 
                      {
                            $dato[]= array("value"=>$row->actividad,
                                       "key"=>$row->id
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
      }    

    
    //checar si el actividad ya existe
    public function check_existente_actividad($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->actividad_comercial);
            $this->db->where('actividad',$data['actividad']);  
            $this->db->where('estatus',"0");
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 



     public function coger_actividad( $data ){
              
            $this->db->select("a.id, a.actividad");         
            $this->db->from($this->actividad_comercial.' As a');
            $this->db->where('a.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  

      //crear
        public function anadir_actividad( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'actividad', $data['actividad'] );  

            $this->db->insert($this->actividad_comercial );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }          


        //editar
        public function editar_actividad( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );

          $this->db->set( 'actividad', $data['actividad'] );  
          $this->db->where('id', $data['id'] );
          $this->db->update($this->actividad_comercial );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return FALSE;
                $result->free_result();
        }   


        //eliminar actividad
        public function eliminar_actividad( $data ){
            $this->db->delete( $this->actividad_comercial, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }     





   //-----------colores------------------

        public function total_colores(){
           $this->db->from($this->colores);
           $colores = $this->db->get();            
           return $colores->num_rows();
        }


        public function listado_colores($limit=-1, $offset=-1){

          $this->db->select('c.id, c.color, c.hexadecimal_color');
          $this->db->from($this->colores.' as c');
          
          if ($limit!=-1) {
              $this->db->limit($limit, $offset); 
          } 
          $result = $this->db->get();

            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }        



      public function buscador_colores($data){
            $this->db->distinct();
            $this->db->select("c.hexadecimal_color");
            $this->db->select("c.color", FALSE);  
            $this->db->select("p.descripcion", FALSE);  
            $this->db->from($this->productos.' as p');
            $this->db->join($this->colores.' As c', 'p.id_color = c.id','LEFT');
            $this->db->like("p.descripcion" ,$data['dependiente']);
            $this->db->like("c.color" ,$data['key']);
            //$this->db->or_like("c.color" ,$data['key'],FALSE);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) {
                            $dato[]= array(
                                      "descripcion"=>$row->descripcion,
                                      "color"=>$row->color,
                                      "hexadecimal_color"=>$row->hexadecimal_color
                                    );
                      }
                      return json_encode($dato);
                      //return '[ {"nombre":"Jhon", "apellido":"calderón"}, {"nombre":"jean", "apellido":"calderón"}]';
              }   
              else 
                 return False;
              $result->free_result();
      }   

      /*
      public function buscador_colores($data){
            $this->db->select( 'id' );
            $this->db->select("color", FALSE);  
            $this->db->select("hexadecimal_color", FALSE);  
            $this->db->from($this->colores);
            $this->db->like("color" ,$data['key'],FALSE);
            $this->db->or_like("hexadecimal_color",$data['key'],FALSE);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) 
                      {
                            $dato[]= array("value"=>$row->color." | #".$row->hexadecimal_color,
                                       "key"=>$row->id
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
      }    
  */
    
    //checar si el color ya existe
    public function check_existente_color($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->colores);
            $this->db->where('color',$data['color']);  
            $this->db->where('estatus',"0");
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 



     public function coger_color( $data ){
              
            $this->db->select("c.id, c.color, c.hexadecimal_color");         
            $this->db->from($this->colores.' As c');
            $this->db->where('c.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  

      //crear
        public function anadir_color( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'color', $data['color'] );  
          $this->db->set( 'hexadecimal_color', $data['hexadecimal_color'] );  


            $this->db->insert($this->colores );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }          


        //editar
        public function editar_color( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'color', $data['color'] );  
          $this->db->set( 'hexadecimal_color', $data['hexadecimal_color'] );  
          $this->db->where('id', $data['id'] );
          $this->db->update($this->colores );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return FALSE;
                $result->free_result();
        }   


        //eliminar color
        public function eliminar_color( $data ){
            $this->db->delete( $this->colores, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }     

//-----------calidades------------------

        public function total_calidades(){
           $this->db->from($this->calidades);
           $calidades = $this->db->get();            
           return $calidades->num_rows();
        }

        public function listado_calidades($limit=-1, $offset=-1){

          $this->db->select('c.id, c.calidad');
          $this->db->from($this->calidades.' as c');
          
          if ($limit!=-1) {
              $this->db->limit($limit, $offset); 
          } 
          $result = $this->db->get();

            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }        



      public function buscador_calidades($data){
            $this->db->select( 'id' );
            $this->db->select("calidad", FALSE);  
            $this->db->from($this->calidades);
            $this->db->like("calidad" ,$data['key'],FALSE);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) 
                      {
                            $dato[]= array("value"=>$row->calidad,
                                       "key"=>$row->id
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
      }    

    
    //checar si el calidad ya existe
    public function check_existente_calidad($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->calidades);
            $this->db->where('calidad',$data['calidad']);  
            
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 



     public function coger_calidad( $data ){
              
            $this->db->select("c.id, c.calidad");         
            $this->db->from($this->calidades.' As c');
            $this->db->where('c.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  

      //crear
        public function anadir_calidad( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'calidad', $data['calidad'] );  

            $this->db->insert($this->calidades );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }          


        //editar
        public function editar_calidad( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );

          $this->db->set( 'calidad', $data['calidad'] );  
          $this->db->where('id', $data['id'] );
          $this->db->update($this->calidades );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return FALSE;
                $result->free_result();
        }   


        //eliminar calidad
        public function eliminar_calidad( $data ){
            $this->db->delete( $this->calidades, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }     

        //-----------cargadores------------------

        public function total_cargadores(){
           $this->db->from($this->cargadores);
           $cargadores = $this->db->get();            
           return $cargadores->num_rows();
        }

        public function listado_cargadores($limit=-1, $offset=-1){
          
          $this->db->select('c.id, c.nombre, c.estatus');
          $this->db->from($this->cargadores.' as c');
          
          if ($limit!=-1) {
              $this->db->limit($limit, $offset); 
          } 
          $result = $this->db->get();

            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }        



      public function buscador_cargadores($data){
            $this->db->select( 'id' );
            $this->db->select("nombre", FALSE);  
            $this->db->from($this->cargadores);
            
            $this->db->like("id" ,$data['key'],FALSE);
            $this->db->or_like("nombre" ,$data['key'],FALSE);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) 
                      {
                            $dato[]= array(
                                       "value"=>$row->id." | ".$row->nombre,
                                       "key"=>$row->id,
                                       "descripcion"=>$row->nombre
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
      }    







    
    //checar si el cargador ya existe
    public function check_existente_cargador($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->cargadores);
            $this->db->where('nombre',$data['nombre']);  
            //$this->db->where('estatus',"0");
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 



     public function coger_cargador( $data ){
              
            $this->db->select("c.id, c.nombre,c.estatus");         
            $this->db->from($this->cargadores.' As c');
            $this->db->where('c.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  

      //crear
        public function anadir_cargador( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'nombre', $data['nombre'] );  
          //$this->db->set( 'estatus', $data['estatus'] );  

            $this->db->insert($this->cargadores );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }          


        //editar
        public function editar_cargador( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'nombre', $data['nombre'] );  
          //$this->db->set( 'estatus', $data['estatus'] );  
          $this->db->where('id', $data['id'] );
          $this->db->update($this->cargadores );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return FALSE;
                $result->free_result();
        }   


        //eliminar cargador
        public function eliminar_cargador( $data ){
            $this->db->delete( $this->cargadores, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }   

 //-----------anchos------------------

        public function total_anchos(){
           $this->db->from($this->anchos);
           $anchos = $this->db->get();            
           return $anchos->num_rows();
        }

        public function listado_anchos($limit=-1, $offset=-1){

          $this->db->select('c.id, c.ancho');
          $this->db->from($this->anchos.' as c');
          
          if ($limit!=-1) {
              $this->db->limit($limit, $offset); 
          } 
          $result = $this->db->get();

            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }        



      public function buscador_anchos($data){
            $this->db->select( 'id' );
            $this->db->select("ancho", FALSE);  
            $this->db->from($this->anchos);
            $this->db->like("ancho" ,$data['key'],FALSE);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) 
                      {
                            $dato[]= array("value"=>$row->ancho,
                                       "key"=>$row->id
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
      }    

    
    //checar si el ancho ya existe
    public function check_existente_ancho($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->anchos);
            $this->db->where('ancho',$data['ancho']);  
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 



     public function coger_ancho( $data ){
              
            $this->db->select("c.id, c.ancho");         
            $this->db->from($this->anchos.' As c');
            $this->db->where('c.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  

      //crear
        public function anadir_ancho( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'ancho', $data['ancho'] );  

            $this->db->insert($this->anchos );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }          


        //editar
        public function editar_ancho( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );

          $this->db->set( 'ancho', $data['ancho'] );  
          $this->db->where('id', $data['id'] );
          $this->db->update($this->anchos );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return FALSE;
                $result->free_result();
        }   


        //eliminar ancho
        public function eliminar_ancho( $data ){
            $this->db->delete( $this->anchos, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }   

      //-----------operaciones------------------

        public function total_operaciones(){
           $this->db->from($this->operaciones);
           $operaciones = $this->db->get();            
           return $operaciones->num_rows();
        }

        public function listado_operaciones($limit=-1, $offset=-1){

          $this->db->select('a.id, a.operacion');
          $this->db->from($this->operaciones.' as a');
          
          if ($limit!=-1) {
              $this->db->limit($limit, $offset); 
          } 
          $result = $this->db->get();

            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }        



      public function buscador_operaciones($data){
            $this->db->select( 'id' );
            $this->db->select("operacion", FALSE);  
            $this->db->from($this->operaciones);
            $this->db->like("operacion" ,$data['key'],FALSE);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) 
                      {
                            $dato[]= array("value"=>$row->operacion,
                                       "key"=>$row->id
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
      }    

    
    //checar si el operacion ya existe
    public function check_existente_operacion($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->operaciones);
            $this->db->where('operacion',$data['operacion']);  
            $this->db->where('estatus',"0");
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 



     public function coger_operacion( $data ){
              
            $this->db->select("a.id, a.operacion");         
            $this->db->from($this->operaciones.' As a');
            $this->db->where('a.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  

      //crear
        public function anadir_operacion( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'operacion', $data['operacion'] );  

            $this->db->insert($this->operaciones );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }          


        //editar
        public function editar_operacion( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );

          $this->db->set( 'operacion', $data['operacion'] );  
          $this->db->where('id', $data['id'] );
          $this->db->update($this->operaciones );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return FALSE;
                $result->free_result();
        }   


        //eliminar operacion
        public function eliminar_operacion( $data ){
            $this->db->delete( $this->operaciones, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }     





////////////////////Productos devolucion
     public function buscador_prod_devolucion($data){
            $this->db->select('m.codigo');
            $this->db->select('m.referencia');
            $this->db->select('m.id_descripcion,c.color,m.id_color, co.composicion, ca.calidad');
            $this->db->select('m.id_composicion,m.id_calidad'); //m.id_color,
            
            $this->db->select('m.movimiento, m.fecha_entrada, p.nombre proveedor, m.factura, m.cantidad_um');
            $this->db->select('m.id_medida, m.ancho,m.precio, m.id_estatus, m.id_lote, m.id ');

            $this->db->from($this->historico_registros_salidas.' as m');
            $this->db->join($this->colores.' As c' , 'c.id = m.id_color','LEFT');
            $this->db->join($this->composiciones.' As co' , 'co.id = m.id_composicion','LEFT');
            $this->db->join($this->calidades.' As ca' , 'ca.id = m.id_calidad','LEFT');
            $this->db->join($this->proveedores.' As p' , 'p.id = m.id_empresa','LEFT');
            //$this->db->join($this->unidades_medidas.' As um' , 'um.id = m.id_medida','LEFT'); //um.medida


            //OR (m.referencia LIKE  "%'.$data['key'].'%") 

            $where = '(
                        (
                          ( m.id_apartado = 0 ) AND  ( m.estatus_salida = "0" ) AND  ( m.devolucion = 0 ) 
                        ) 
                         AND
                        (
                          ( m.codigo LIKE  "%'.$data['key'].'%" ) 
                         )

              )';   

  
            $this->db->where($where);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) 
                      {
                            $dato[]= array(
                                       "value"=>$row->codigo." | ".$row->referencia,
                                       "key"=>$row->codigo,
                                       "descripcion"=>$row->codigo,
                                       "id_descripcion"=>$row->id_descripcion,
                                       "id_color"=>$row->id_color,
                                       "id_composicion"=>$row->id_composicion,
                                       "id_calidad"=>$row->id_calidad,
                                       "id_movimiento"=>$row->movimiento,
                                       "fecha_entrada"=>$row->fecha_entrada,
                                       "proveedor"=>$row->proveedor,
                                       "factura"=>$row->factura,
                                       "cantidad_um"=>$row->cantidad_um,
                                       "id_medida"=>$row->id_medida,
                                       "ancho"=>$row->ancho,
                                       "precio"=>$row->precio,
                                       "id_estatus"=>13, //$row->id_estatus,
                                       "id_lote"=>$row->id_lote,
                                       "id"=>$row->id,

                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
      }    


   ////////////////////Productos del inventario
     public function buscador_prod_inven($data){
            $this->db->select('m.codigo');
            $this->db->select('m.referencia');
            $this->db->select('m.id_descripcion,c.color,m.id_color, co.composicion, ca.calidad');
            $this->db->select('m.id_composicion,m.id_calidad'); //m.id_color,
            
            $this->db->select('m.movimiento, m.fecha_entrada, p.nombre proveedor, m.factura, m.cantidad_um');
            $this->db->select('m.id_medida, m.ancho,m.precio, m.id_estatus, m.id_lote, m.id ');

            $this->db->from($this->registros_entradas.' as m');
            $this->db->join($this->colores.' As c' , 'c.id = m.id_color','LEFT');
            $this->db->join($this->composiciones.' As co' , 'co.id = m.id_composicion','LEFT');
            $this->db->join($this->calidades.' As ca' , 'ca.id = m.id_calidad','LEFT');
            $this->db->join($this->proveedores.' As p' , 'p.id = m.id_empresa','LEFT');
            //$this->db->join($this->unidades_medidas.' As um' , 'um.id = m.id_medida','LEFT'); //um.medida

            $where = '(
                        (
                          ( m.id_apartado = 0 ) AND  ( m.estatus_salida = "0" ) 
                        ) 
                         AND
                        (
                          ( m.codigo LIKE  "%'.$data['key'].'%" ) OR (m.referencia LIKE  "%'.$data['key'].'%") 
                         )

              )';   

  
            $this->db->where($where);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) 
                      {
                            $dato[]= array(
                                       "value"=>$row->codigo." | ".$row->referencia,
                                       "key"=>$row->codigo,
                                       "descripcion"=>$row->codigo,
                                       "id_descripcion"=>$row->id_descripcion,
                                       "id_color"=>$row->id_color,
                                       "id_composicion"=>$row->id_composicion,
                                       "id_calidad"=>$row->id_calidad,
                                       "id_movimiento"=>$row->movimiento,
                                       "fecha_entrada"=>$row->fecha_entrada,
                                       "proveedor"=>$row->proveedor,
                                       "factura"=>$row->factura,
                                       "cantidad_um"=>$row->cantidad_um,
                                       "id_medida"=>$row->id_medida,
                                       "ancho"=>$row->ancho,
                                       "precio"=>$row->precio,
                                       "id_estatus"=>$row->id_estatus,
                                       "id_lote"=>$row->id_lote,
                                       "id"=>$row->id,

                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
      }    


      //-----------proveedores------------------

        public function total_proveedores(){
           $this->db->from($this->proveedores);
           $proveedores = $this->db->get();            
           return $proveedores->num_rows();
        }

        public function listado_proveedores($limit=-1, $offset=-1,$id=""){

          /*
          Datos de la empresa

          id, uid, codigo, nombre,  direccion, telefono, cliente, proveedor,  id_usuario, fecha_mac
          */          


          $this->db->select('p.id, p.uid, p.codigo, p.nombre,  p.direccion, p.telefono,  p.coleccion_id_actividad, p.id_usuario, p.fecha_mac'); 
          $this->db->from($this->proveedores.' as p');

          //$this->db->select("( CASE WHEN ( LOCATE('3', p.coleccion_id_actividad) >0) THEN 'Si' ELSE '' END ) AS guiada", FALSE);       

          //$this->db->where('LOCATE("3", p.coleccion_id_actividad) >0');

          if ($id!="") {
              $this->db->where($id); 
          } 
          
          if ($limit!=-1) {
              $this->db->limit($limit, $offset); 
          } 
          $result = $this->db->get();

            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }        



      public function buscador_proveedores($data){
            $this->db->select( 'codigo' );
            $this->db->select("nombre", FALSE);  
            $this->db->from($this->proveedores);
            
            
          $where = '(
                      (
                        (LOCATE("'.$data['idproveedor'].'", coleccion_id_actividad) >0)
                      ) 
                       AND
                      (
                        ( codigo LIKE  "%'.$data['key'].'%" ) OR (nombre LIKE  "%'.$data['key'].'%") 
                       )

            )';   


  
          $this->db->where($where);

          /*
            $this->db->where('(LOCATE("'.$data['idproveedor'].'", coleccion_id_actividad) >0)' );
          */
              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) 
                      {
                            $dato[]= array(
                                       "value"=>$row->codigo." | ".$row->nombre,
                                       "key"=>$row->codigo,
                                       "descripcion"=>$row->nombre
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
      }    

    
    //checar si el proveedor ya existe
    public function check_existente_proveedor($data){
            $this->db->select("codigo", FALSE);         
            $this->db->from($this->proveedores);
            $this->db->where('codigo',$data['codigo']);  
            if (isset($data['codigo_ant'])) {
              $this->db->where('codigo !=', $data['codigo_ant']);
            }
            
            
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 



     public function coger_proveedor( $data ){
          $this->db->select('p.id, p.uid, p.codigo, p.nombre,  p.direccion, p.telefono,  p.coleccion_id_actividad, p.id_usuario, p.fecha_mac'); 
          $this->db->from($this->proveedores.' as p');

            $this->db->where('p.codigo',$data['codigo']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  

      //crear
        public function anadir_proveedor( $data ){

          //id, uid, codigo, nombre,  direccion, telefono,  coleccion_id_actividad, id_usuario, fecha_mac'); 


          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );

          //$this->db->set( 'id', $data['id'] ); // autoincrementable
          //$this->db->set( 'uid', $data['uid'] );  
          $this->db->set( 'codigo', $data['codigo'] );  
          $this->db->set( 'nombre', $data['nombre'] );            
          $this->db->set( 'direccion', $data['direccion'] );  
          $this->db->set( 'telefono', $data['telefono'] );  
          $this->db->set( 'coleccion_id_actividad', $data['coleccion_id_actividad'] );  


            $this->db->insert($this->proveedores );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }          


        //editar
        public function editar_proveedor( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );

          //$this->db->set( 'uid', $data['uid'] );  
          $this->db->set( 'codigo', $data['codigo'] );  
          $this->db->set( 'nombre', $data['nombre'] );            
          $this->db->set( 'direccion', $data['direccion'] );  
          $this->db->set( 'telefono', $data['telefono'] );  
          $this->db->set( 'coleccion_id_actividad', $data['coleccion_id_actividad'] );  

          $this->db->where('codigo', $data['codigo_ant'] );
          $this->db->update($this->proveedores );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return FALSE;
                $result->free_result();
        }   


        //eliminar proveedor
        public function eliminar_proveedor( $data ){
            $this->db->delete( $this->proveedores, array( 'codigo' => $data['codigo'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }     




      //-----------productos------------------

        public function total_productos(){
           $this->db->from($this->productos);
           $productos = $this->db->get();            
           return $productos->num_rows();
        }

        public function listado_productos($limit=-1, $offset=-1){
          $this->db->select('p.id, p.uid, p.referencia,  p.comentario');
          $this->db->select('p.descripcion, p.minimo, p.imagen, p.id_composicion, p.id_color,p.id_calidad,p.precio,p.ancho');
          $this->db->select('p.id_usuario, p.fecha_mac, c.hexadecimal_color,c.color nombre_color');

          $this->db->from($this->productos.' as p');
          $this->db->join($this->colores.' As c', 'p.id_color = c.id','LEFT');
          
          
          if ($limit!=-1) {
              $this->db->limit($limit, $offset); 
          } 
          $result = $this->db->get();

            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }        

/////////////////////////////////////////////
      public function buscar_productos(){
            $this->db->distinct();
            $this->db->select("p.descripcion", FALSE);  
            $this->db->from($this->productos.' as p');

            $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) {
                            $dato[]= array(
                                      "descripcion"=>$row->descripcion,
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
      }   


      public function buscar_colores($data){
            $this->db->distinct();
            
            $this->db->select("p.id_color", FALSE);  
            $this->db->select("c.color", FALSE);  

            $this->db->from($this->productos.' as p');
            $this->db->join($this->colores.' As c', 'p.id_color = c.id','LEFT');
            
            $this->db->like("p.descripcion" ,$data['producto'],FALSE);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) {
                            $dato[]= array(
                                      "color"=>$row->color,
                                      "id_color"=>$row->id_color
                                    );
                      }
                      return json_encode($dato);
                      
              }   
              else 
                 return False;
              $result->free_result();
      }   


      public function buscar_composicion($data){
            $this->db->distinct();
            $this->db->select("p.id_composicion", FALSE);  
            $this->db->select("co.composicion", FALSE);  
            
            $this->db->from($this->productos.' as p');
            $this->db->join($this->composiciones.' As co', 'p.id_composicion = co.id','LEFT');
            $this->db->like("p.descripcion" ,$data['producto'],FALSE);
            $this->db->like("p.id_color" ,$data['color'],FALSE);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) {
                            $dato[]= array(
                                      "id_composicion"=>$row->id_composicion,
                                      "composicion"=>$row->composicion
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
      }       


     public function buscar_calidad($data){
            $this->db->distinct();
            $this->db->select("p.id_calidad", FALSE);  
            $this->db->select("ca.calidad", FALSE);  
            $this->db->from($this->productos.' as p');
            $this->db->join($this->calidades.' As ca', 'p.id_calidad = ca.id','LEFT');

            $this->db->like("p.descripcion" ,$data['producto'],FALSE);
            $this->db->like("p.id_color" ,$data['color'],FALSE);
            $this->db->like("p.id_composicion" ,$data['composicion'],FALSE);


              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) {
                            $dato[]= array(
                                      "id_calidad"=>$row->id_calidad,
                                      "calidad"=>$row->calidad,
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
      }    



      public function buscar_completo($data){
            
           // $this->db->distinct();
            $this->db->select("p.id", FALSE);  
            $this->db->select("p.referencia", FALSE);  
            $this->db->select("p.precio,p.comentario,p.ancho");  
            
            $this->db->from($this->productos.' as p');
            

            $this->db->like("p.descripcion" ,$data['producto'],FALSE);
            $this->db->like("p.id_color" ,$data['color'],FALSE);
            $this->db->like("p.id_composicion" ,$data['composicion'],FALSE);
            $this->db->like("p.id_calidad" ,$data['calidad'],FALSE);


              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) {
                            $dato[]= array(
                                      "id"=>$row->id,
                                      "referencia"=>$row->referencia,
                                      "comentario"=>$row->comentario,
                                      "precio"=>$row->precio,
                                      "ancho"=>$row->ancho,
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
      }                



/////////////////////////////////////////////


      public function buscador_productos($data){
            $this->db->distinct();
            $this->db->select("c.hexadecimal_color");
            $this->db->select("c.color", FALSE);  
            $this->db->select("p.descripcion", FALSE);  
            $this->db->from($this->productos.' as p');
            $this->db->join($this->colores.' As c', 'p.id_color = c.id','LEFT');
            $this->db->like("p.descripcion" ,$data['key'],FALSE);
            //$this->db->or_like("c.color" ,$data['key'],FALSE);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) {
                            $dato[]= array(
                                      "descripcion"=>$row->descripcion,
                                      "color"=>$row->color,
                                      "hexadecimal_color"=>$row->hexadecimal_color
                                    );
                      }
                      return json_encode($dato);
                      //return '[ {"nombre":"Jhon", "apellido":"calderón"}, {"nombre":"jean", "apellido":"calderón"}]';
              }   
              else 
                 return False;
              $result->free_result();
      }   

/*       
      public function buscador_productos($data){
            $this->db->select("id");
            $this->db->select("referencia");  
            $this->db->select("descripcion", FALSE);  
            $this->db->from($this->productos);
            $this->db->like("referencia" ,$data['key'],FALSE);
            $this->db->or_like("descripcion" ,$data['key'],FALSE);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) {
                            $dato[]= array(
                                      "value"=>$row->referencia." | ".$row->descripcion,
                                       "key"=>base64_encode($row->id) //
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
      }    
      */
    
    
    //checar si el producto ya existe
    public function check_existente_producto($data){
            $this->db->select("descripcion", FALSE);         
            $this->db->from($this->productos);
    
            $this->db->where('descripcion',$data['descripcion']);  
            $this->db->where('id_color',$data['id_color']);  
            $this->db->where('id_composicion',$data['id_composicion']);  
    
            if (isset($data['producto_ant'])) {
              //$this->db->where('producto !=', $data['producto_ant']);
            }
            

            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 
    



     public function coger_producto( $data ){

          $this->db->select('p.id, p.uid, p.referencia,p.comentario');
          $this->db->select('p.descripcion, p.minimo, p.imagen, p.id_composicion, p.id_color,p.id_calidad,p.precio,p.ancho');
          $this->db->select('p.id_usuario, p.fecha_mac');

          $this->db->from($this->productos.' as p');
          
            $this->db->where('p.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  

      //crear
        public function anadir_producto( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );

          //$this->db->set( 'id', $data['id'] );   //No porq es autoincrementable
           //$this->db->set( 'uid', $data['uid'] );   
           $this->db->set( 'referencia', $data['referencia'] );   
           $this->db->set( 'descripcion', $data['descripcion'] );  
           $this->db->set( 'minimo', $data['minimo'] );  

           $this->db->set( 'precio', $data['precio'] );  
           $this->db->set( 'ancho', $data['ancho'] );  

           $this->db->set( 'precio_anterior', $data['precio'] );  

           $this->db->set( 'id_composicion', $data['id_composicion'] );  
           $this->db->set( 'id_color', $data['id_color'] );  

           $this->db->set( 'id_calidad', $data['id_calidad'] );  
           $this->db->set( 'comentario', $data['comentario'] );  

          if  (isset($data['archivo_imagen'])) {
            $this->db->set( 'imagen', $data['archivo_imagen']['file_name']);          
          }  



            $this->db->insert($this->productos );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }          


        //editar
        public function editar_producto( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );

          //$this->db->set( 'uid', $data['uid'] );   
          //$this->db->set( 'referencia', $data['referencia'] );   
          $this->db->set( 'descripcion', $data['descripcion'] );  
          $this->db->set( 'minimo', $data['minimo'] );  
          $this->db->set( 'precio', $data['precio'] );  
          $this->db->set( 'ancho', $data['ancho'] );  
          
          $this->db->set( 'id_composicion', $data['id_composicion'] );  
          $this->db->set( 'id_color', $data['id_color'] );  
          $this->db->set( 'id_calidad', $data['id_calidad'] );  
          $this->db->set( 'comentario', $data['comentario'] );  

          if  (isset($data['archivo_imagen'])) {
            $this->db->set( 'imagen', $data['archivo_imagen']['file_name']);          
          }  

          $this->db->where('id', $data['id'] );
          $this->db->update($this->productos );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return FALSE;
                $result->free_result();
        }   


      //editar
        public function cambiar_precio_producto( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );

          $this->db->set( 'precio_anterior', 'precio', FALSE  );
          $this->db->set( 'precio', $data['precio'] );  
          $this->db->set( 'comentario', $data['comentario'] );  
          $this->db->where('id', $data['id'] );
          $this->db->update($this->productos );



          //actualizando precio de todos los productos
          $this->db->set( 'precio_anterior', 'precio', FALSE  );
          $this->db->set( 'precio', $data['precio'] );  

          $this->db->where('referencia', $data['referencia'] );
          $this->db->where('id_apartado', 0 );    //LOS QUE ESTAN APARTADOS
          $this->db->where('estatus_salida', '0' ); //LOS QUE ESTAN EN SALIDAS
          
          $this->db->update($this->registros_entradas );


          //actualizando "cambio de precios para todos los q pertenecen a la referencia"
          $this->db->set( 'precio_cambio', $data['precio'] );  
          $this->db->where('referencia', $data['referencia'] );
          $this->db->update($this->registros_entradas );

          
          return true;
          $result->free_result();

        }   


          /*
            caso de apartados 
              Pedidos de vendedores: 2 y 3
                  $where_total = '( m.id_apartado = 2 ) or ( m.id_apartado = 3 ) ';
                    **eliminar_apartado_detalle (precios actuales)

              Pedidos de tiendas: 5 y 6
                  $where_total = '( m.id_apartado = 5 ) or ( m.id_apartado = 6 ) ';
                  **eliminar_pedido_detalle (precios actuales)

                 Nota: va a los precios actuales cuando se quiten
                 
          



           Generar pedido: 4
                  $where_total = '(( m.id_apartado = 4 ) )';
                  **quitar_pedido (precios actuales)

            
            .apartar(este es el caso de cuando apartan los vendedores)
                $where_total = '(( m.id_apartado = 1 ) )';
                ** .quitar



          salida
              'estatus_salida', '1'

             **.quitar

          */



        //eliminar producto
        public function eliminar_producto( $data ){
            $this->db->delete( $this->productos, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }     


        public function total_archivos($data){

            $this->db->select("( CASE WHEN imagen = '' THEN 0 ELSE 1 END ) AS cantidad", FALSE);
            $this->db->select('imagen archivo');
            
            $this->db->where('id', $data['id'] );

            $result = $this->db->get( $this->db->dbprefix($data['tabla']) );
            return $result->row();
            $result->free_result();
        }



	} 


?>

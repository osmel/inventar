$(function(){

  window.MY_Socket = {

    
  // Instanciar al "cliente Socket.IO" y conectar con el servidor
    socket : io.connect('http://localhost:8080'),
    
  // Configurar los controladores de eventos iniciales para el cliente Socket.IO

  // estos son los que inicializan los controladores para cada evento que ocurra,
  //en este caso esta escuchando constantemente si sucede
  // una  this.socket.on('conexion' : para disparar el mensaje de "estoy trabajando"
    bindEvents : function() {
      
      this.socket.on('conexion',MY_Socket.conexionMessage);   //llama a la funcion  conexionMessage
      
      //cuando le transmiten el nuevo mensaje, al equipo del que envia el mensaje
      this.socket.on('broadcastNewPost',MY_Socket.updateMessages);
    },

  // Esto sólo indica que una conexión Socket.IO ha comenzado.
    conexionMessage : function(data) {
      console.log(data.message);   //variable message fue la que envio
    },


  // En la actualización 'broadcastNewPost' la lista de mensajes de otros usuarios
    updateMessages : function(data) {
    // Debido a que el "mensaje se transmite(broadcasted)" dos veces (una para el equipo "team" y  nuevamente por los "administradores")
       // Necesitamos Asegurarnos que sólo se muestra una vez si el administrador está también en el mismo
       // Equipo como el remitente(sender).

		//jQuery('#etiq_conteo').val(  data.message);
		var hash_url = window.location.pathname;

    $('#etiq_conteo').text(data.message);


    mensaje_notif ='';

    if  ( (hash_url=="/pedidos")  ) {
        $('#tabla_apartado').dataTable().fnDraw();
        $('#tabla_pedido').dataTable().fnDraw();

       
          switch(data.tipo) {
              case "conf_apartado":
                     mensaje_notif=  "Nuevo pedido de vendedor";
                     caja_notificacion = '.notif-bot-vendedor';
                  break;
              case "conf_pedido":
                     mensaje_notif=  "Nuevo pedido de tienda";
                     caja_notificacion = '.notif-bot-tienda';
                  break;

              case "form_apartado":
                     mensaje_notif=  "Eliminado apartado de vendedor";
                     caja_notificacion = '.notif-bot-vendedor';
                  break;


              case "form_pedido":
                     mensaje_notif=  "Eliminado apartado de tienda";
                     caja_notificacion = '.notif-bot-tienda';
                  break;

                  
              default:
                  mensaje_notif=  "notificación";

             //http://www.webcodo.net/simple-live-notifications-with-jquery/#.VZofI3Wlyko     
          }

    }    

    if  ( (hash_url=="/salidas")  ) {
        $('#tabla_entrada').dataTable().fnDraw();
        //$('#tabla_salida').dataTable().fnDraw();

          switch(data.tipo) {
              case "conf_apartado":
                     mensaje_notif=  "Nuevo pedido de vendedor actualizo inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;
              case "conf_pedido":
                     mensaje_notif=  "Nuevo pedido de tienda actualizo inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;

              case "form_apartado":
                     mensaje_notif=  "Eliminado apartado de vendedor actualizo inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;


              case "form_pedido":
                     mensaje_notif=  "Eliminado apartado de tienda actualizo inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;     


              //salida    
              case "agregar":
                     mensaje_notif=  "Pendiente de salida actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;     

              case "quitar":
                     mensaje_notif=  "Liberado del estado pendiente de salida actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;     

              case "proc_salida":
                     mensaje_notif=  "Se realizo una salida actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;   

              //generar_pedido
              case "agregar_pedido":
                     mensaje_notif=  "Pendiente de ser pedido por la tienda actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;  

              case "quitar_pedido":
                     mensaje_notif=  "Liberado de Pendiente de pedido por la tienda actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;                                        

             //apartado de vendedores en el home de vendedor
              case "apartar":
                     mensaje_notif=  "Pendiente de ser apartado por el vendedor actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;                                        


              case "noapartar":
                     mensaje_notif=  "Liberado de Pendiente de apartado por el vendedor actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;                                        


              default:
                  mensaje_notif=  "notificación";
          }


    }    


    if  ( (hash_url=="/generar_pedidos")  ) {
        $('#pedido_entrada').dataTable().fnDraw();
        //$('#pedido_salida').dataTable().fnDraw();

          switch(data.tipo) {
              case "conf_apartado":
                     mensaje_notif=  "Nuevo pedido de vendedor actualizo inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;
              case "conf_pedido":
                     mensaje_notif=  "Nuevo pedido de tienda actualizo inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;
              case "form_apartado":
                     mensaje_notif=  "Eliminado apartado de vendedor actualizo inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;


              case "form_pedido":
                     mensaje_notif=  "Eliminado apartado de tienda actualizo inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break; 


             //salida    
              case "agregar":
                     mensaje_notif=  "Pendiente de salida actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;     

              case "quitar":
                     mensaje_notif=  "Liberado del estado pendiente de salida actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;     

              case "proc_salida":
                     mensaje_notif=  "Se realizo una salida actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;   

              //generar_pedido
              case "agregar_pedido":
                     mensaje_notif=  "Pendiente de ser pedido por la tienda actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;  

              case "quitar_pedido":
                     mensaje_notif=  "Liberado de Pendiente de pedido por la tienda actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;                      
      
             //apartado de vendedores en el home de vendedor
              case "apartar":
                     mensaje_notif=  "Pendiente de ser apartado por el vendedor actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;                                        


              case "noapartar":
                     mensaje_notif=  "Liberado de Pendiente de apartado por el vendedor actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;                                        




              default:
                  mensaje_notif=  "notificación";
          }

    }    


    if  ( (hash_url=="/reportes")  ) {
        $('#tabla_reporte').dataTable().fnDraw();

          switch(data.tipo) {
              case "conf_apartado":
                     mensaje_notif=  "Nuevo pedido de vendedor actualizo inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;
              case "conf_pedido":
                     mensaje_notif=  "Nuevo pedido de tienda actualizo inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;
              case "form_apartado":
                     mensaje_notif=  "Eliminado apartado de vendedor actualizo inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;
              case "form_pedido":
                     mensaje_notif=  "Eliminado apartado de tienda actualizo inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;                  

             //salida    
              case "agregar":
                     mensaje_notif=  "Pendiente de salida actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;     

              case "quitar":
                     mensaje_notif=  "Liberado del estado pendiente de salida actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;     

              case "proc_salida":
                     mensaje_notif=  "Se realizo una salida actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;   

              //generar_pedido
              case "agregar_pedido":
                     mensaje_notif=  "Pendiente de ser pedido por la tienda actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;  

              case "quitar_pedido":
                     mensaje_notif=  "Liberado de Pendiente de pedido por la tienda actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;                                        

             //apartado de vendedores en el home de vendedor
              case "apartar":
                     mensaje_notif=  "Pendiente de ser apartado por el vendedor actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;                                        


              case "noapartar":
                     mensaje_notif=  "Liberado de Pendiente de apartado por el vendedor actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;                                        




              default:
                  mensaje_notif=  "notificación";
          }        
    }    



    //home 
    if  ( (hash_url=="/")  ) {
        $('#tabla_home').dataTable().fnDraw();
        $('#tabla_inicio').dataTable().fnDraw();

          switch(data.tipo) {
              case "conf_apartado":
                     mensaje_notif=  "Nuevo pedido de vendedor actualizo inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;
              case "conf_pedido":
                     mensaje_notif=  "Nuevo pedido de tienda actualizo inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;
              case "form_apartado":
                     mensaje_notif=  "Eliminado apartado de vendedor actualizo inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;


              case "form_pedido":
                     mensaje_notif=  "Eliminado apartado de tienda actualizo inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;     


             //salida    
              case "agregar":
                     mensaje_notif=  "Pendiente de salida actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;     

              case "quitar":
                     mensaje_notif=  "Liberado del estado pendiente de salida actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;     

              case "proc_salida":
                     mensaje_notif=  "Se realizo una salida actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;   

              //generar_pedido
              case "agregar_pedido":
                     mensaje_notif=  "Pendiente de ser pedido por la tienda actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;  

              case "quitar_pedido":
                     mensaje_notif=  "Liberado de Pendiente de pedido por la tienda actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;                                        


             //apartado de vendedores en el home de vendedor
              case "apartar":
                     mensaje_notif=  "Pendiente de ser apartado por el vendedor actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;                                        


              case "noapartar":
                     mensaje_notif=  "Liberado de Pendiente de apartado por el vendedor actualizó inventario";
                     caja_notificacion = '.notif-bot-pedidos';
                  break;                                        
                          



              default:
                  mensaje_notif=  "notificación";
          }        
    }    


    //mensaje de notificacion
    if (mensaje_notif !='') {
        $('<div/>', {  //texto de notificacion
          id: 'notif-bot', //id q debe estar mal
          class : 'notif-bot alert alert-info', //las clases q se le anaden
          text: mensaje_notif //'Texto de notificacion!' 
          }).appendTo(caja_notificacion)  //dentro del div que se agrega
            .delay(5000)
            .fadeOut();
    }




        //console.log(data);

      if( ( !userIsAnAdmin() && data.team != 'admin') ||
          ( userIsAnAdmin() && data.team === 'admin') ){

    // Envía el html parcial con el nuevo mensaje a la función jQuery que lo mostrará.
       // App.showBroadcastedMessage(data.message);
      }
    },


  // Esta emitirá un html parcial que contiene un mensaje nuevo,
    // Más el ID del equipo(teamId) del usuario que envía el mensaje.
    //sendNewPost : function(msg,team) {
    sendNewPost : function(msg,tipo) {  
      var sessionId = readCookie('inven_session');
      MY_Socket.socket.emit('newPost',msg,sessionId,tipo);
          /*
                jQuery.ajax({
                          url : 'session',
                          data : { 
                            tipo: 'nada',
                          },
                          type : 'POST',
                          dataType : 'json',
                          success : function(data) {  
                            if (data.exito == true) {
                                //alert('osmel');
                                console.log(msg+' - '+data.sala);
                                MY_Socket.socket.emit('newPost',msg,data.sala);
                            } else 
                            {
                              console.log('no hay datos');
                            }
                              
                          }
                });         
      */
    },

  // Únase(Join) a un socket.io 'room' basado en el equipo del usuario
    joinRoom : function(){
    // Obtener la sessionID de CodeIgniter de la cookie
      var sessionId = readCookie('inven_session');
      //console.log(sessionId);
      if(sessionId) {
    // Envía el "sessionID" al servidor Node en un esfuerzo para unirse a un "room"
        //console.log(sessionId);
                  MY_Socket.socket.emit('joinRoom',sessionId);
/*

                jQuery.ajax({
                          url : 'session',
                          data : { 
                            tipo: 'nada',
                          },
                          type : 'POST',
                          dataType : 'json',
                          success : function(data) {  
                            if (data.exito == true) {
                               console.log(data.sala);
                                MY_Socket.socket.emit('joinRoom',data.sala);

                            } else 
                            {
                              console.log('no hay datos');
                            }
                              
                          }
                });   


*/


        
      } else {
    // Si no existe sessionID, no trata de unirse a un room.
        console.log('No session id found. Broadcast disabled.');
    // esperamos cerrar la sesión url? (//forward to logout url?)
      }
    }

  } // end window.MY_Socket
  

  // Comenzando !! Start it up!
  
  MY_Socket.bindEvents();

  //Provoco el evento joinRoom para obtener la "sessionID"
  MY_Socket.joinRoom();

  //MY_Socket.sendNewPost( "mi primer mensaje", "3");
  //MY_Socket.sendNewPost( "mi primer mensaje");

  // Read a cookie. http://www.quirksmode.org/js/cookies.html#script
  function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
  }
   
/* Este buscará la insignia(badge) 'Admin' en la ventana actual.
   Este es un método super-hacky "para determinar si el usuario es un administrador"
   Para que los mensajes desde el usuario del mismo equipo que el administrador no se
   dupliquen en el flujo de mensajes(message stream). */
   
  function userIsAnAdmin(){
    var val = false;
    $('.userTeamBadge').children().each(function(i,el){
       if ($(el).text() == 'Admin'){
         val = true;
       }
    });
    return val;
    
  }
});

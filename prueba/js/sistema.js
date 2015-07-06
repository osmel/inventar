jQuery(document).ready(function($) {

////////////////////////////Escaneo de codigos QR////////////////////////////////////////////////

/*
    jQuery('#reader').html5_qrcode(function(data){
        //  Hacer algo cuando se lee el código (do something when code is read)
            alert(data);
            jQuery('#read').html(data);
        },
        function(error){
        	console.log('error');
            //Mostrar errores de lectura 
           // jQuery('#read_error').html(error);
        }, function(videoError){
            // El flujo de vídeo se ha podido abrir (the video stream could be opened)
            //jQuery('#vid_error').html(videoError);
        }
    );

    */
 

////////////////////////////Para los botones de agregar catalogo Modales///////////////////////////////


  jQuery("#id_lote").on('change', function(e) {
		
 		 var val_prod = jQuery('#producto').val();
 		 var val_color = jQuery('#color').val();  
 		 var val_comp = jQuery('#composicion').val();  		  
 		 var val_calida = jQuery('#calidad').val();  		  


    		if  ((val_calida != "0") && (val_calida != "") && (val_calida != null)) 
    		{
    		
				//entradas

				var id_cliente = jQuery('.buscar_proveedor').typeahead('val');
				var url = 'id_proveedor';	
				jQuery.ajax({  //para tomar la referencia del producto
				        url : 'refe_producto',
					    data:{
					        	id_cliente : id_cliente,
					        	val_prod:val_prod,
					        	val_color:val_color,
					        	val_comp:val_comp,
					        	val_calida:val_calida,
					        },
					        type : 'POST',
					        dataType : 'json',
				        success : function(dato) {
				        	
							codigo_proveedor =dato.cliente_id;
						        		lote =jQuery('#id_lote option:selected').text();
						        
						          referencia =dato.ref_prod.referencia; 
						          comentario =dato.ref_prod.comentario; 
						              precio =dato.ref_prod.precio; 
						              ancho =dato.ref_prod.ancho; 


				        	codigo=codigo_proveedor+referencia+lote+fecha_formateada;
				        		//codigo
				        	jQuery('#codigo').val(codigo);
								
								//referencia
							jQuery('#referencia').attr('value',referencia);
								//ancho
							jQuery('#ancho').attr('value',ancho);
								//precio
							jQuery('#precio').attr('value',precio);
								//comentario
							jQuery('#comentario').text(comentario); //attr('text',comentario);


						},
				        error : function(jqXHR, status, error) {
				        },
				        complete : function(jqXHR, status) {
				            
				        }											        	
				});					

			


			}	


 

     });


//////////////////////////////////////////////////////////////////////////////////////
//////////////////Comienzo de tratamiento de dependencia///////////////////////////

    jQuery("#producto, #color, #composicion, #calidad").on('change', function(e) {

		var campo = jQuery(this).attr("name");   
 		 var val_prod = jQuery('#producto').val();  		  //elemento** id
 		 var val_color = jQuery('#color').val();  		  //elemento** id
 		 var val_comp = jQuery('#composicion').val();  		  //elemento** id
 		 var val_calida = jQuery('#calidad').val();  		  //elemento** id


         var dependencia = jQuery(this).attr("dependencia"); //color composicion
         var nombre = jQuery(this).attr("nombre");           //color composicion
        //alert(valor);
    	if (dependencia !="") {	    
	        //limpiar la dependencia
	        jQuery("#"+dependencia).html(''); 
	        //cargar la dependencia
	        cargarDependencia(campo,val_prod,val_color,val_comp,val_calida,dependencia,nombre);
        }



        //reportes
		var hash_url = window.location.pathname;
		if  ( (hash_url=="/entradas") && (hash_url=="/editar_inventario") )   {  //sino es entrada
				var oTable =jQuery('#tabla_reporte').dataTable();
				oTable._fnAjaxUpdate();
    	}	

		if  ( (hash_url=="/devolucion") )   {  //actualizar la regilla de abajo
				var oTable =jQuery('#tabla_devolucion').dataTable();
				oTable._fnAjaxUpdate();
    	}	


    	//entradas

		if ((campo == 'calidad') && ( (hash_url=="/entradas") || (hash_url=="/editar_inventario") || (hash_url=="/devolucion") ) ) { //si calidad cambio de valor
    		if  ((val_calida != "0") && (val_calida != "") && (val_calida != null)) 
    		{

    		
				var id_cliente = jQuery('.buscar_proveedor').typeahead('val');
				var url = 'id_proveedor';	
				jQuery.ajax({  //para tomar la referencia del producto
				        url : 'refe_producto',
					    data:{
					        	id_cliente : id_cliente,
					        	val_prod:val_prod,
					        	val_color:val_color,
					        	val_comp:val_comp,
					        	val_calida:val_calida,
					        },
					        type : 'POST',
					        dataType : 'json',
				        success : function(dato) {

				        	//console.log(hash_url+' **  '+campo);

				        	codigo_proveedor =dato.cliente_id;
						        		lote =jQuery('#id_lote option:selected').text();
						        
						          referencia =dato.ref_prod.referencia; 
						          comentario =dato.ref_prod.comentario; 
						          	  precio =dato.ref_prod.precio; 
						          	  ancho =dato.ref_prod.ancho; 



				        	codigo=codigo_proveedor+referencia+lote+fecha_formateada;
				        		//codigo
				        		//console.log(dato);
				        		//alert(precio);

				        	jQuery('#codigo').val(codigo);
								//referencia
							jQuery('#referencia').val(referencia);
								//ancho
							jQuery('#ancho').val(ancho);
								//precio
							jQuery('#precio').val(precio);
								//comentario
							jQuery('#comentario').val(comentario); //attr('text',comentario);


						},
				        error : function(jqXHR, status, error) {
				        },
				        complete : function(jqXHR, status) {
				            
				        }											        	
				});					

			


			}	
		}


     });


	function cargarDependencia(campo,val_prod,val_color,val_comp,val_calida,dependencia,nombre) {
		
		var url = 'cargar_dependencia';	

		jQuery.ajax({
		        url : 'cargar_dependencia',
		        data:{
		        	campo:campo,
		        	
		        	val_prod:val_prod,
		        	val_color:val_color,
		        	val_comp:val_comp,
		        	val_calida:val_calida,

		        	dependencia:dependencia
		        },


		        type : 'POST',
		        dataType : 'json',
		        success : function(data) {
		        		
		        	 //jQuery("#"+dependencia).trigger('change');
	                 jQuery("#"+dependencia).append('<option value="0" >Seleccione un '+nombre+'</option>');
                    
					if (data != "[]") {

                        jQuery.each(data, function (i, valor) {
                            if (valor.nombre !== null) {
                                 jQuery("#"+dependencia).append('<option value="' + valor.identificador + '">' + valor.nombre + '</option>');     
                            }
                        });

	                } 	
						
					if (jQuery('#oculto_producto').val() == 'si') {
						if (dependencia=='color') {
							jQuery('#color').val(jQuery('#oculto_producto').attr('color'));	
						}

						if (dependencia=='composicion') {
							//jQuery('#composicion').val("2");	
							jQuery('#composicion').val(jQuery('#oculto_producto').attr('composicion'));	
						}

						if (dependencia=='calidad') {
							jQuery('#calidad').val(jQuery('#oculto_producto').attr('calidad'));	
							jQuery('#oculto_producto').val('no');
						}
					}	
					

					jQuery("#"+dependencia).trigger('change');
	                //
	               // jQuery('#color').change();
                    return false;
		        },
		        error : function(jqXHR, status, error) {
		        },
		        complete : function(jqXHR, status) {
		            
		        }
		    }); 
	}

//////////////////fin de tratamiento de dependencia///////////////////////////




var comienzo =false;
jQuery.fn.dataTable.Api.register( 'column().data().sum()', function () {
	return this.reduce( function (a, b) {
		var x = parseFloat( a ) || 0;
		var y = parseFloat( b ) || 0;
		return x + y;
	} );
} );


		var salida = ['Código', 'Nombre tela', 'Color', 'Cantidad',  'Ancho', 'No. Movimiento','Cliente', 'Lote', 'Egreso'];
		var existencia = ['Código', 'Nombre tela', 'Color', 'Cantidad',  'Ancho', 'No. Movimiento','Proveedor', 'Lote', 'Ingreso'];
		//var apartado = ['apartado', 'Descripción', 'Color', 'Pieza', 'U.M', 'Ancho', 'Dependencia', 'Tipo Apartado', 'Ingreso'];
		var apartado = ['Código', 'Nombre tela', 'Color', 'Cantidad',  'Ancho', 'No. Movimiento', 'Dependencia', 'Tipo Apartado', 'Fecha'];

		var devolucion = ['Código', 'Nombre tela', 'Color', 'Cantidad',  'Ancho', 'No. Movimiento','Proveedor', 'Lote', 'Ingreso'];
		//var devolucion = ['devolucion', 'Descripción', 'Color', 'U.M', 'Kilogramos', 'Ancho', 'Proveedor', 'Lote', 'Ingreso'];
		
    	var cero = ['Referencia', 'Nombre tela', 'Existencias', 'Imagen', 'Color', 'Especificaciones', 'Composición', 'Calidad', 'Precio'];
    	var baja = ['Referencia', 'Nombre tela', 'Existencias', 'Imagen', 'Color', 'Especificaciones', 'Composición', 'Calidad', 'Precio'];
    	var top = ['Referencia', 'Nombre tela', 'Rollos Vendidos', 'Imagen', 'Color', 'Especificaciones', 'Composición', 'Calidad', 'Precio'];

    	var arr_apartado_detalle = ['Código', 'Nombre tela', 'Color', 'Cantidad',   'No. Movimiento','Ancho', 'Precio', 'Lote'];
    	var arr_pedido_detalle = ['Código', 'Nombre tela', 'Color', 'Cantidad',   'No. Movimiento','Ancho', 'Precio', 'Lote'];
    	var arr_completo_detalle = ['Código', 'Nombre tela', 'Color', 'Cantidad', 'Ancho', 'Precio', 'Lote'];
		
		var apartado_pendiente = ['Vendedor', 'Dependencia','Comprador', 'Fecha','Tipo Apartado','Vencimiento','Detalles','Cancelar','Prorrogar'];
		var pedido_pendiente = ['Cliente', 'Dependencia','Núm. Pedido', 'Fecha','Tipo Apartado','Vencimiento','Detalles','Cancelar','Prorrogar']; 
		var pedido_completo = ['Pedido realizado por:', 'Dependencia','Comprador/Núm. Pedido', 'Fecha','Tipo Apartado','Núm. Salida','Detalles']; 
    	

///////////////////////////////////////////////////////////////////////////////
///////////////////////////DEVOLUCION////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////




	/////////////////////////buscar producto_devolucion (buscar_prod_inven)


	// busqueda de prod_inven
	var consulta_prod_devolucion = new Bloodhound({
	   datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nombre'),
	   queryTokenizer: Bloodhound.tokenizers.whitespace,
	   remote:'catalogos/buscador?key=%QUERY&nombre='+jQuery('.buscar_prod_devolucion').attr("name")+'&idprodinven='+jQuery('.buscar_prod_devolucion').attr("idprodinven"),
	});

    //consulta_prod_devolucion.clear();
	consulta_prod_devolucion.initialize();

	jQuery('.buscar_prod_devolucion').typeahead(
		{
			   hint: true,
		  highlight: true,
		  minLength: 1
		},

		 {
	  
	  name: 'buscar_prod_devolucion',
	  displayKey: 'descripcion', //
	  source: consulta_prod_devolucion.ttAdapter(),
	   templates: {
				
			    suggestion: function (data) {  
			    	//alert('una');   			
					return '<p><strong>' + data.descripcion + '</strong></p>'+
					 '<div style="background-color:'+ '#'+data.hexadecimal_color + ';display:block;width:15px;height:15px;margin:0 auto;"></div>';

		   }
	    
	  }
	});

	jQuery('.buscar_prod_devolucion').on('typeahead:selected', function (e, datum,otro) {
	    jQuery('#producto').val(datum.id_descripcion);
	    jQuery('#codigo_original').val(datum.key)

	    jQuery('#oculto_producto').attr('color',datum.id_color );
	    jQuery('#oculto_producto').attr('composicion',datum.id_composicion );
	    jQuery('#oculto_producto').attr('calidad',datum.id_calidad );

	    //provocar el evento
	    jQuery('#oculto_producto').val('si');
	    jQuery('#producto').change();



	   	jQuery('#movimiento').val(datum.id_movimiento);
	   	jQuery('#proveedor').val(datum.proveedor);
	   	jQuery('#fecha').val(datum.fecha_entrada);
	   	jQuery('#factura').val(datum.factura);
	   	jQuery('#cantidad_um').val(datum.cantidad_um);
	   	jQuery('#id_medida').val(datum.id_medida);
	   	jQuery('#ancho').val(datum.ancho);
	   	jQuery('#precio').val(datum.precio);

	   	jQuery('#id_estatus').val(datum.id_estatus);
	   	jQuery('#id_lote').val(datum.id_lote);

	   	//jQuery('#tabla_cambio').dataTable().fnDraw();
	    

	});	

	jQuery('.buscar_prod_devolucion').on('typeahead:closed', function (e) {
		//jQuery('#tabla_entrada').dataTable().fnDraw();
	});	

///tabla_devoluciones

jQuery('#tabla_devolucion').dataTable( {
	
		"pagingType": "full_numbers",
		"processing": true,
		"serverSide": true,
		"ajax": {
	            	"url" : "procesando_servidor_devolucion",
	         		"type": "POST",
	         		 "data": function ( d ) {
	     				  // d.codigo = jQuery("#codigo_original").val(); 
	    			 }
	     },   
 
		"infoCallback": function( settings, start, end, max, total, pre ) {

			if (settings.json.data) {
				jQuery("#cod_devolucion").val(settings.json.data[0][8]);
				jQuery("fieldset.disableddev").attr('disabled', true);					
			} else {
				jQuery("#cod_devolucion").val('');
				jQuery("fieldset.disableddev").attr('disabled', false);					

			}
			

		    return pre;
	  	} ,   	     


		"language": {  //tratamiento de lenguaje
			"lengthMenu": "Mostrar _MENU_ registros por paginas",
			"zeroRecords": "No hay registros - disculpe",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
			"emptyTable":     "No hay disponibles datos en la tabla",
			"infoPostFix":    "",
			"thousands":      ",",
			"loadingRecords": "Leyendo...",
			"processing":     "Procesando...",
			"search":         "Buscar:",
			"paginate": {
				"first":      "Primero",
				"last":       "Ultimo",
				"next":       "Próximo",
				"previous":   "Anterior"
			},
			"aria": {
				"sortAscending":  ": Activando para ordenar columnas ascendentes",
				"sortDescending": ": Activando para ordenar columnas descendentes"
			},
		},


		"columnDefs": [

			    	{ 
		                "render": function ( data, type, row ) {
		                		return 'A'+data;
		                },
		                "targets": [0]
		            },
			    	{ 
		                "render": function ( data, type, row ) {
		                		return data;
		                },
		                "targets": [1,2,3,4,5,6,7]
		            },
		            {
		                "render": function ( data, type, row ) {
    					 texto='<td><a href="quitar_devolucion/'+jQuery.base64.encode(row[0])+'/'+jQuery.base64.encode(row[1])+ '"';  //+jQuery.base64.encode(row[6])+'" '; 
						 	texto+=' class="btn btn-danger btn-block" data-toggle="modal" data-target="#modalMessage">';
						 	texto+=' Quitar';
						 texto+='</a></td>';
							return texto;	
		                },
		                "targets": 8
		            }
		            /*{ 
		                 "visible": true,
		                "targets": [8]
		            }*/	
		        ],
		});	



	//Agregar producto a la regilla
	jQuery("#form_editar_devolucion").submit(function(e){
		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);
		jQuery(this).ajaxSubmit({
			success: function(data){
				if(data != true){
					spinner.stop();
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','block');
					jQuery('#messages').addClass('alert-danger');
					jQuery('#messages').html(data);
					jQuery('html,body').animate({
						'scrollTop': jQuery('#messages').offset().top
					}, 1000);
				}else{
					spinner.stop();
					//borrar el mensaje q quedo	
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','none');


					//desabilito proveedor y factura
					//jQuery("fieldset.disabledme").attr('disabled', true);
					//vuelve a los valores por defecto, producto, color, composicion y calidad

					//
					jQuery("#fecha").val('');
					jQuery("#movimiento").val('');

					jQuery("#proveedor").val('');
					jQuery("#factura").val('');
					//jQuery("#cod_devolucion").val('');

					jQuery("fieldset.disableddev").attr('disabled', true);					

					jQuery("#editar_prod_devolucion").val('');
					jQuery("#codigo").val('');
					jQuery("#cantidad_um").val('');
					jQuery("#cantidad_royo").val('');
					jQuery("#ancho").val('');
					jQuery("#precio").val('');
					jQuery("#comentario").val('');

					jQuery('#calidad option:eq(0)').prop('selected', 'selected');
					jQuery('#composicion option:eq(0)').prop('selected', 'selected');
					jQuery('#color option:eq(0)').prop('selected', 'selected');
					jQuery('#producto option:eq(0)').prop('selected', 'selected');

					jQuery('#producto').trigger( "change" );
					

					//um y estatus sus valores por defectos

					jQuery('#id_medida option:eq(0)').prop('selected', 'selected');
					jQuery('#id_estatus option:eq(0)').prop('selected', 'selected');
					jQuery('#id_lote option:eq(0)').prop('selected', 'selected');
					
					jQuery('#tabla_devolucion').dataTable().fnDraw();
					//tuve q usar este porque no se puede reinicializar el selector
					$catalogo = e.target.name;
					window.location.href = '/'+$catalogo;	
			

				}
			} 
		});
		return false;
	});	


	//Quitar el producto de la regilla
    jQuery('body').on('submit','#form_devolucion', function (e) {
		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);
		jQuery(this).ajaxSubmit({
			success: function(data){
				if(data != true){
					
					spinner.stop();
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','block');
					jQuery('#messages').addClass('alert-danger');
					jQuery('#messages').html(data);
					jQuery('html,body').animate({
						'scrollTop': jQuery('#messages').offset().top
					}, 1000);
				

				}else{
					    $catalogo = e.target.name;
						spinner.stop();
						jQuery('#foo').css('display','none');


						
						jQuery('#tabla_devolucion').dataTable().fnDraw();
						window.location.href = '/'+$catalogo;	

						//return false;						

						
				}
			} 
		});
		return false;
	});	


///////////////////////////////////////////////////////////////////////////////
///////////////////////////FIN DE DEVOLUCION////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////




/////////////////////////////////////////////////////reportes/////////////////////////////////////////////////////////


//fecha
			  

              jQuery('.fecha_reporte').daterangepicker(
              	  { 
				    locale: { cancelLabel: 'Cancelar',
				    		  applyLabel: 'Aceptar',
				    		  fromLabel : 'Desde',
				    		  toLabel: 'Hasta',
				    		  monthNames : "ene._feb._mar_abr._may_jun_jul._ago_sep._oct._nov._dec.".split("_"),
				    		  daysOfWeek: "Do_Lu_Ma_Mi_Ju_Vi_Sa".split("_"),
				     } , 
				    separator: ' / ',
				    format: 'DD-MM-YYYY',
				    //startDate: fecha_hoy, //'2014/09/01',
				    //endDate: fecha_hoy //'2014/12/31'
				  }
              );

jQuery('.fecha_reporte').on('apply.daterangepicker', function(ev, picker) {
	comienzo=true; //para indicar que start comience en 0;
	var oTable =jQuery('#tabla_reporte').dataTable();
	oTable._fnAjaxUpdate();

});



jQuery('#id_estatuss').change(function(e) {
		var oTable =jQuery('#tabla_reporte').dataTable();
		oTable._fnAjaxUpdate();
});

jQuery('#exportar_reporte').click(function (e) {

		   

	var fecha = (jQuery('.fecha_reporte').val()).split(' / ');



	jQuery.ajax({
		        url : 'exportar_reporte',
		        data : { 
					extra_search 	: jQuery("#botones").val(), 
					id_estatus 	 	: jQuery("#id_estatuss").val(), 
					id_descripcion 	: jQuery("#producto").val(),
					id_color 		: jQuery("#color").val(), 
					id_composicion 	: jQuery("#composicion").val(),
					id_calidad 		: jQuery("#calidad").val(),
					proveedor 		: jQuery("#editar_proveedor_reporte").val(),
					fecha_inicial 	: fecha[0],
					fecha_final 	: fecha[1]
		        },
		        type : 'POST',
		        dataType : 'json',
		        success : function(data) {	
		        	console.log(data);
		        }
	});						        

     				   

});
/////////////////////////////////////////////////


	//Agregar entrada temporal 
	jQuery("#form_editar_inventario").submit(function(e){
		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);
		jQuery(this).ajaxSubmit({
			success: function(data){
				if(data != true){
					spinner.stop();
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','block');
					jQuery('#messages').addClass('alert-danger');
					jQuery('#messages').html(data);
					jQuery('html,body').animate({
						'scrollTop': jQuery('#messages').offset().top
					}, 1000);
				}else{
					spinner.stop();
					//borrar el mensaje q quedo	
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','none');
					jQuery('#tabla_cambio').dataTable().fnDraw();

				}
			} 
		});
		return false;
	});	


////cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.min.js
//https://editor.datatables.net/examples/advanced/exportButtons.html

jQuery('#tabla_reporte').dataTable( {
		dom: 'T<"clear">lfrtip',
		tableTools: {
			sRowSelect: "os",
			sSwfPath: "../../../js/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
                    sExtends: "collection",
                    sButtonText: "Exportar",
                    sButtonClass: "save-collection",
                    aButtons: [ 'csv', 'xls' ]
                 }   
			]
		},


	  "pagingType": "full_numbers",
      "fnPreDrawCallback": function (oSettings) {
		if (comienzo) {
			oSettings._iDisplayStart = 0;  //comienza en cero siempre q cambia de botones
			comienzo=false;
		}
      },

	"processing": true,
	"serverSide": true,
	"ajax": {
            	"url" : "procesando_reporte",
         		"type": "POST",
         		 "data": function ( d ) {
         		 	   if (comienzo) {
         		 	   	 d.start=0;	 //comienza en cero siempre q cambia de botones
         		 	   }
     				   d.extra_search = jQuery("#botones").val(); 
     				   d.id_estatus = jQuery("#id_estatuss").val(); 

     				   //datos del producto
     				   d.id_descripcion = jQuery("#producto").val(); 
     				   d.id_color = jQuery("#color").val(); 
     				   d.id_composicion = jQuery("#composicion").val(); 
     				   d.id_calidad = jQuery("#calidad").val(); 
						
					   d.proveedor = jQuery("#editar_proveedor_reporte").val(); 	   

						var fecha = (jQuery('.fecha_reporte').val()).split(' / ');
						d.fecha_inicial = fecha[0];
						d.fecha_final = fecha[1];
     				   
    			 }
     },   
	"infoCallback": function( settings, start, end, max, total, pre ) {
	    if (settings.json.totales) {
		    jQuery('#total_pieza').html( 'Total de piezas:'+ settings.json.totales.pieza);
		    jQuery('#total_kg').html( 'Total de Kgs:'+settings.json.totales.kilogramo);
			jQuery('#total_metro').html('Total de mtrs:'+ settings.json.totales.metro);
		}	
	    return pre
  	} ,    
	"footerCallback": function( tfoot, data, start, end, display ) {
	   var api = this.api(), data;
			var intVal = function ( i ) {
				return typeof i === 'string' ?
					i.replace(/[\$,]/g, '')*1 :
					typeof i === 'number' ?
						i : 0;
			};
		if  (data.length>0) {   
				total_metro = api
					.column( 9 )
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					} );
				total_kilogramo = api
					.column( 10)
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					} );
				total_pieza = (end-start);	
			switch(jQuery("#botones").val()) {
			    case "salida":
			    case "existencia":
			    case "devolucion":
			    case "apartado":
			        jQuery('#pieza').html( 'Total de piezas:'+ total_pieza);
			        jQuery('#kg').html( 'Total de Kgs:'+total_kilogramo);
			        jQuery('#metro').html('Total de mtrs:'+ total_metro);
			        break;
			    default:
			        jQuery('#pieza').html( '');
			        jQuery('#metro').html('');
					jQuery('#kg').html( '');			        

			        jQuery('#total_pieza').html( '');
			        jQuery('#total_metro').html('');
					jQuery('#total_kg').html( '');			        
	              break;
			}
		} else 
		{
			        jQuery('#pieza').html( '');
			        jQuery('#metro').html('');
					jQuery('#kg').html( '');

			        jQuery('#total_pieza').html( '');
			        jQuery('#total_metro').html('');
					jQuery('#total_kg').html( '');			        
		}	
    
    },
   "columnDefs": [
    			{ 
	                "render": function ( data, type, row ) {
						return data;	
	                },
	                "targets": [0,1,2,3,4,5,6,7,8]
	            },
    			{ 
	                 "visible": false,
	                "targets": [9,10,11]
	            }
	],
/*

$this->db->select("( CASE WHEN m.devolucion <> 0 THEN 'red' ELSE 'black' END ) AS color_devolucion", FALSE);
11=>$row->color_devolucion,
*/
 "rowCallback": function( row, data ) {
	    // Bold the grade for all 'A' grade browsers
	    if ( data[11] == "red" ) {
	      jQuery('td', row).addClass( "danger" );
	    }

	  },		

    "fnHeaderCallback": function( nHead, aData, iStart, iEnd, aiDisplay ) {
		switch(jQuery("#botones").val()) {
		    case "salida":
		        var arreglo =salida;
		        break;

		    case "existencia":
		        var arreglo =existencia;
		        break;
		    case "devolucion":
		          var arreglo =devolucion;
		        break;
		    case "apartado":
		        var arreglo =apartado;
		        break;
		    case "cero":
		        var arreglo =cero;
		        break;
		    case "baja":
		        var arreglo =baja;
		        break;
		    case "top":
		        var arreglo =top;
		        break;

		    default:
		}
		for (var i=0; i<=arreglo.length-1; i++) { //cant_colum
    		nHead.getElementsByTagName('th')[i].innerHTML = arreglo[i]; 
    	}
	},
	"language": {  
		"lengthMenu": "Mostrar _MENU_ registros por paginas",
		"zeroRecords": "No hay registros - disculpe",
		"info": "Mostrando pagina _PAGE_ de _PAGES_",
		"infoEmpty": "No hay registros disponibles",
		"infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
		"emptyTable":     "No hay disponibles datos en la tabla",
		"infoPostFix":    "",
		"thousands":      ",",
		"loadingRecords": "Leyendo...",
		"processing":     "Procesando...",
		"search":         "Buscar:",
		"paginate": {
			"first":      "Primero",
			"last":       "Ultimo",
			"next":       "Próximo",
			"previous":   "Anterior"
		},
		"aria": {
			"sortAscending":  ": Activando para ordenar columnas ascendentes",
			"sortDescending": ": Activando para ordenar columnas descendentes"
		},
	},
});	

jQuery("#foco").focusout(function (e) {
 //alert('sadasd');

 	comienzo=true; //para indicar que start comience en 0;
	var oTable =jQuery('#tabla_reporte').dataTable();
	oTable._fnAjaxUpdate();

}
	);

jQuery('#existencia_reporte').click(function (e) {
	comienzo=true;  //para indicar que start comience en 0;
	jQuery('#label_reporte').text("Reportes de entradas");
	jQuery('#estatus_id').css('display','block');
	jQuery('#proveedor_id').css('display','block');

	jQuery('#fecha_id').css('display','block');

	jQuery('#example2').css('display','block');
	
	
	
	

	jQuery('#calidad option:eq(0)').prop('selected', 'selected');
	jQuery('#composicion option:eq(0)').prop('selected', 'selected');
	jQuery('#color option:eq(0)').prop('selected', 'selected');
	jQuery('#producto option:eq(0)').prop('selected', 'selected');


	jQuery('#label_proveedor').text("Proveedor");
	jQuery('#editar_proveedor_reporte').typeahead("val",'');
	jQuery('#editar_proveedor_reporte').attr('idproveedor','1');

	jQuery('.leyenda').css('display','none');
	jQuery('.leyenda_devolucion').css('display','none');
	//leyenda_devolucion

	var oTable =jQuery('#tabla_reporte').dataTable();
	jQuery('#botones').val('existencia');
	oTable._fnAjaxUpdate();
});

jQuery('#salida_reporte').click(function (e) {
	jQuery('#label_reporte').text("Reportes de salidas");
	jQuery('#estatus_id').css('display','block');
	jQuery('#proveedor_id').css('display','block');

	jQuery('#fecha_id').css('display','block');
	jQuery('#example2').css('display','block');
	

	jQuery('#calidad option:eq(0)').prop('selected', 'selected');
	jQuery('#composicion option:eq(0)').prop('selected', 'selected');
	jQuery('#color option:eq(0)').prop('selected', 'selected');
	jQuery('#producto option:eq(0)').prop('selected', 'selected');


	jQuery('#label_proveedor').text("Cliente");
	jQuery('#editar_proveedor_reporte').typeahead("val",'');
	jQuery('#editar_proveedor_reporte').attr('idproveedor','2');

	jQuery('.leyenda').css('display','none');
	jQuery('.leyenda_devolucion').css('display','block');


	comienzo=true; //para indicar que start comience en 0;
	var oTable =jQuery('#tabla_reporte').dataTable();
	jQuery('#botones').val('salida');
	oTable._fnAjaxUpdate();
});


jQuery('#apartado_reporte').click(function (e) {
	jQuery('#label_reporte').text("Reportes de apartados");
	jQuery('#estatus_id').css('display','block');
	jQuery('#proveedor_id').css('display','block');

	jQuery('#fecha_id').css('display','block');
	jQuery('#example2').css('display','block');


	jQuery('#calidad option:eq(0)').prop('selected', 'selected');
	jQuery('#composicion option:eq(0)').prop('selected', 'selected');
	jQuery('#color option:eq(0)').prop('selected', 'selected');
	jQuery('#producto option:eq(0)').prop('selected', 'selected');

	jQuery('.leyenda').css('display','block');
	jQuery('.leyenda_devolucion').css('display','none');

	jQuery('#label_proveedor').text("Cliente");
	jQuery('#editar_proveedor_reporte').typeahead("val",'');
	jQuery('#editar_proveedor_reporte').attr('idproveedor','2');



	comienzo=true;  //para indicar que start comience en 0;
	var oTable =jQuery('#tabla_reporte').dataTable();
	jQuery('#botones').val('apartado');
	oTable._fnAjaxUpdate();
});

jQuery('#cero_reporte').click(function (e) {
	jQuery('#label_reporte').text("Reportes de existencia cero");
	jQuery('#estatus_id').css('display','none');
	jQuery('#proveedor_id').css('display','none');

	jQuery('#fecha_id').css('display','none');
	jQuery('#example2').css('display','block');


	jQuery('#calidad option:eq(0)').prop('selected', 'selected');
	jQuery('#composicion option:eq(0)').prop('selected', 'selected');
	jQuery('#color option:eq(0)').prop('selected', 'selected');
	jQuery('#producto option:eq(0)').prop('selected', 'selected');

	jQuery('.leyenda').css('display','none');
	jQuery('.leyenda_devolucion').css('display','none');

	jQuery('#label_proveedor').text("Proveedor");
	jQuery('#editar_proveedor_reporte').typeahead("val",'');
	jQuery('#editar_proveedor_reporte').attr('idproveedor','1');

	

	comienzo=true;  //para indicar que start comience en 0;
	var oTable =jQuery('#tabla_reporte').dataTable();
	jQuery('#botones').val('cero');
	oTable._fnAjaxUpdate();
});

jQuery('#baja_reporte').click(function (e) {
	jQuery('#label_reporte').text("Reportes de existencia baja");
	jQuery('#estatus_id').css('display','none');
	jQuery('#proveedor_id').css('display','none');

	jQuery('#fecha_id').css('display','none');
	jQuery('#example2').css('display','block');


	jQuery('#calidad option:eq(0)').prop('selected', 'selected');
	jQuery('#composicion option:eq(0)').prop('selected', 'selected');
	jQuery('#color option:eq(0)').prop('selected', 'selected');
	jQuery('#producto option:eq(0)').prop('selected', 'selected');

	jQuery('.leyenda').css('display','none');	
	jQuery('.leyenda_devolucion').css('display','none');

	jQuery('#label_proveedor').text("Proveedor");
	jQuery('#editar_proveedor_reporte').typeahead("val",'');
	jQuery('#editar_proveedor_reporte').attr('idproveedor','1');


	

	comienzo=true; //para indicar que start comience en 0;
	var oTable =jQuery('#tabla_reporte').dataTable();
	jQuery('#botones').val('baja');
	oTable._fnAjaxUpdate();
});


jQuery('#top_reporte').click(function (e) {
	jQuery('#label_reporte').text("Reportes de Top 10");
	jQuery('#estatus_id').css('display','none');
	jQuery('#proveedor_id').css('display','none');

	jQuery('#fecha_id').css('display','block');
	jQuery('#example2').css('display','none');
	jQuery('.leyenda').css('display','none');
	jQuery('.leyenda_devolucion').css('display','none');

	/*
	jQuery('#label_proveedor').text("Proveedor");
	jQuery('#editar_proveedor_reporte').typeahead("val",'');
	jQuery('#editar_proveedor_reporte').attr('idproveedor','1');
	*/

	

	comienzo=true; //para indicar que start comience en 0;
	var oTable =jQuery('#tabla_reporte').dataTable();
	jQuery('#botones').val('top');
	oTable._fnAjaxUpdate();
});





/////////////////////////buscar proveedores reportes

	// busqueda de proveedors reportes
	var consulta_proveedor_reporte = new Bloodhound({
	   datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nombre'),
	   queryTokenizer: Bloodhound.tokenizers.whitespace,
	   //remote:'catalogos/buscador?key=%QUERY&nombre='+jQuery('.buscar_proveedor_reporte').attr("name")+'&idproveedor='+jQuery('.buscar_proveedor_reporte').attr("idproveedor"),

	  remote: {
	        url: 'catalogos/buscador?key=%QUERY',
	        replace: function () {
	            var q = 'catalogos/buscador?key='+encodeURIComponent(jQuery('.buscar_proveedor_reporte').typeahead("val"));
					q += '&nombre='+encodeURIComponent(jQuery('.buscar_proveedor_reporte.tt-input').attr("name"));
				    q += '&idproveedor='+encodeURIComponent(jQuery('.buscar_proveedor_reporte.tt-input').attr("idproveedor"));
	            
	            return  q;
	        }
	    },   

	});



	consulta_proveedor_reporte.initialize();

	jQuery('.buscar_proveedor_reporte').typeahead(
		{
			  hint: true,
		  highlight: true,
		  minLength: 1
		},

		 {
	  
	  name: 'buscar_proveedor_reporte',
	  displayKey: 'descripcion', //
	  source: consulta_proveedor_reporte.ttAdapter(),
	   templates: {
	   			//header: '<h4>'+jQuery('.buscar_proveedor_reporte').attr("name")+'</h4>',
			    suggestion: function (data) {  
					return '<p><strong>' + data.descripcion + '</strong></p>'+
					 '<div style="background-color:'+ '#'+data.hexadecimal_color + ';display:block;width:15px;height:15px;margin:0 auto;"></div>';

		   }
	    
	  }
	});

	jQuery('.buscar_proveedor_reporte').on('typeahead:selected', function (e, datum,otro) {
	    key = datum.key;
		var oTable =jQuery('#tabla_reporte').dataTable();
		oTable._fnAjaxUpdate();


	});	

	jQuery('.buscar_proveedor_reporte').on('typeahead:closed', function (e) {
		var oTable =jQuery('#tabla_reporte').dataTable();
		oTable._fnAjaxUpdate();

	});	



////////////////// Fin de reportes////////////////////////////////////////////////////////////

////////////////// Aqui comienza DASHBOARD////////////////////////////////////////////////////////////


jQuery('#tabla_home').dataTable( {
	  "pagingType": "full_numbers",
      "fnPreDrawCallback": function (oSettings) {
		if (comienzo) {
			oSettings._iDisplayStart = 0;  //comienza en cero siempre q cambia de botones
			comienzo=false;
		}
      },

	"processing": true,
	"serverSide": true,
	"ajax": {
            	"url" : "procesando_home",
         		"type": "POST",
         		 "data": function ( d ) {
         		 	   if (comienzo) {
         		 	   	 d.start=0;	 //comienza en cero siempre q cambia de botones
         		 	   }
         		 	   
     				   d.extra_search = jQuery("#botones").val(); //$('#extra').val();
    			 }
         		
     },   


"infoCallback": function( settings, start, end, max, total, pre ) {
    if (settings.json.totales) {
	    jQuery('#total_pieza').html( 'Total de piezas:'+ settings.json.totales.pieza);
	    jQuery('#total_kg').html( 'Total de Kgs:'+settings.json.totales.kilogramo);
		jQuery('#total_metro').html('Total de mtrs:'+ settings.json.totales.metro);
	}	
    return pre;
  } ,    

 "footerCallback": function( tfoot, data, start, end, display ) {
		   var api = this.api(), data;
			var intVal = function ( i ) {
				return typeof i === 'string' ?
					i.replace(/[\$,]/g, '')*1 :
					typeof i === 'number' ?
						i : 0;
			};

		if  (data.length>0) {   
				total_metro = api
					.column( 9 )
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					} );

				total_kilogramo = api
					.column( 10)
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					} );

				total_pieza = (end-start);	

			switch(jQuery("#botones").val()) {
			    case "existencia":
			    case "devolucion":
			    case "apartado":
			        jQuery('#pieza').html( 'Total de piezas:'+ total_pieza);
			        jQuery('#kg').html( 'Total de Kgs:'+total_kilogramo);
			        jQuery('#metro').html('Total de mtrs:'+ total_metro);

			        break;
			    default:
			        jQuery('#pieza').html( '');
			        jQuery('#metro').html('');
					jQuery('#kg').html( '');			        

			        jQuery('#total_pieza').html( '');
			        jQuery('#total_metro').html('');
					jQuery('#total_kg').html( '');			        
	              break;
			}
		} else 
		{
			        jQuery('#pieza').html( '');
			        jQuery('#metro').html('');
					jQuery('#kg').html( '');

			        jQuery('#total_pieza').html( '');
			        jQuery('#total_metro').html('');
					jQuery('#total_kg').html( '');			        
		}	
    
  },

   "columnDefs": [
    			{ 
	                "render": function ( data, type, row ) {

						return data;	
	                },
	                "targets": [0,1,2,3,4,5,6,7,8]
	            },

    			{ 
	                 "visible": false,
	                "targets": [9,10]
	            }

	            ],
         
"fnHeaderCallback": function( nHead, aData, iStart, iEnd, aiDisplay ) {
	
		switch(jQuery("#botones").val()) {
		    case "existencia":
		        var arreglo =existencia;
		        break;
		    case "devolucion":
		          var arreglo =devolucion;
		        break;
		    case "apartado":
		        var arreglo =apartado;
		        break;
		    case "cero":
		        var arreglo =cero;
		        break;
		    case "baja":
		        var arreglo =baja;
		        break;
		    default:
		        //default 
		}

	for (var i=0; i<=arreglo.length-1; i++) { 
    		nHead.getElementsByTagName('th')[i].innerHTML = arreglo[i]; 
    	}
	 
},
	"language": {  
		"lengthMenu": "Mostrar _MENU_ registros por paginas",
		"zeroRecords": "No hay registros - disculpe",
		"info": "Mostrando pagina _PAGE_ de _PAGES_",
		"infoEmpty": "No hay registros disponibles",
		"infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
		"emptyTable":     "No hay disponibles datos en la tabla",
		"infoPostFix":    "",
		"thousands":      ",",
		"loadingRecords": "Leyendo...",
		"processing":     "Procesando...",
		"search":         "Buscar:",
		"paginate": {
			"first":      "Primero",
			"last":       "Ultimo",
			"next":       "Próximo",
			"previous":   "Anterior"
		},
		"aria": {
			"sortAscending":  ": Activando para ordenar columnas ascendentes",
			"sortDescending": ": Activando para ordenar columnas descendentes"
		},
	},
				
});	



jQuery('#existencia_home').click(function (e) {
	comienzo=true;  //para indicar que start comience en 0;
	var oTable =jQuery('#tabla_home').dataTable();
	jQuery('#botones').val('existencia');
	oTable._fnAjaxUpdate();
});


jQuery('#devolucion_home').click(function (e) {
	comienzo=true;  //para indicar que start comience en 0;
	var oTable =jQuery('#tabla_home').dataTable();
	jQuery('#botones').val('devolucion');
	oTable._fnAjaxUpdate();
});

jQuery('#apartado_home').click(function (e) {
	comienzo=true;  //para indicar que start comience en 0;
	var oTable =jQuery('#tabla_home').dataTable();
	jQuery('#botones').val('apartado');
	oTable._fnAjaxUpdate();
});

jQuery('#cero_home').click(function (e) {
	comienzo=true;  //para indicar que start comience en 0;
	var oTable =jQuery('#tabla_home').dataTable();
	jQuery('#botones').val('cero');
	oTable._fnAjaxUpdate();
});

jQuery('#baja_home').click(function (e) {
	comienzo=true; //para indicar que start comience en 0;
	var oTable =jQuery('#tabla_home').dataTable();
	jQuery('#botones').val('baja');
	oTable._fnAjaxUpdate();
});

////////////////// hasta aqui la de DashBoard////////////////////////////////////////////////////////////


////////////////// Comienza Inicio////////////////////////////////////////////////////////////

jQuery('#tabla_inicio').dataTable( {
	"pagingType": "full_numbers",
	"processing": true,
	"serverSide": true,
	"ajax": {
            	"url" : "procesando_inicio",
         		"type": "POST",
				"data": function ( d ) {
				     d.id_estatus = jQuery("#id_estatus").val();  
				       d.id_color = jQuery("#id_color").val();  
				 }


     },   
	"infoCallback": function( settings, start, end, max, total, pre ) {
	    return pre
	},    
   "columnDefs": [
			    { 
	                "render": function ( data, type, row ) {
	                	if (data) {
										prod='<div class="col-lg-11 col-md-11 col-xs-11 thumb">';
                                        prod+= '<a href="detalles_producto/'+jQuery.base64.encode(data[4])+'" class="thumbnail col-md-12 col-lg-12 col-xs-12" data-toggle="modal" data-target="#myModal">';
                                        prod+=        '<img class="img-responsive" src="uploads/productos/'+data[0]+'" alt="" border="0" width="260" height="195">';
                                        prod+=       '<span class="col-xs-12 col-md-12 col-lg-12 nombre">'+data[1]+'</span>';
                                        prod+=       '<span class="col-xs-12 col-md-12 col-lg-12 color">'+data[2];
                                        prod+=          '<div style="background-color:#'+data[3]+';display:block;width:15px;height:15px;margin:0 auto;"></div>';
                                        prod+=       '</span>';
                                        prod+=       '<span class="col-xs-12 col-md-12 col-lg-12 text-right cantidadtotal">'+data[5]+'</span>';
                                        prod+='</a>';
                                        prod+= '</div>';
                                     return prod;  
						   }
						else
							return "";
	                },
	                "targets": [ 0,1,2,3 ],
	            }
	],

	"language": {  //tratamiento de lenguaje
		"lengthMenu": "Mostrar _MENU_ registros por paginas",
		"zeroRecords": "No hay registros - disculpe",
		"info": "Mostrando pagina _PAGE_ de _PAGES_",
		"infoEmpty": "No hay registros disponibles",
		"infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
		"emptyTable":     "No hay disponibles datos en la tabla",
		"infoPostFix":    "",
		"thousands":      ",",
		"loadingRecords": "Leyendo...",
		"processing":     "Procesando...",
		"search":         "Buscar:",
		"paginate": {
			"first":      "Primero",
			"last":       "Ultimo",
			"next":       "Próximo",
			"previous":   "Anterior"
		},
		"aria": {
			"sortAscending":  ": Activando para ordenar columnas ascendentes",
			"sortDescending": ": Activando para ordenar columnas descendentes"
		},
	},
});	


////////////////////////Pedidos de Apartados /////////////////////////////////////
jQuery('body').on('click','.prorrogar_venta', function (e) {
	
	id_usuario_apartado = (jQuery(this).attr('id_usuario_apartado'));
	id_cliente_apartado = (jQuery(this).attr('id_cliente_apartado'));

	jQuery.ajax({
		        url : 'marcando_prorroga_venta',
		        data : { 
		        	id_usuario_apartado: id_usuario_apartado,
		        	id_cliente_apartado: id_cliente_apartado

		        },
		        type : 'POST',
		        dataType : 'json',
		        success : function(data) {	
		        	   jQuery('#tabla_apartado').dataTable().fnDraw();
		        }
	});						        
});


jQuery('#myModal').on('hide.bs.modal', function(e) {
    jQuery(this).removeData('bs.modal');
});	


jQuery('body').on('click','.apartar', function (e) {

	identificador = (jQuery(this).attr('identificador'));

	jQuery.ajax({
		        url : 'marcando_apartado',
		        data : { 
		        	identificador: identificador,

		        },
		        type : 'POST',
		        dataType : 'json',
		        success : function(data) {	
						if(data != true){
							jQuery("."+identificador).removeClass("danger");

								jQuery.ajax({
									        url : 'conteo_tienda',
									        data : { 
									        	tipo: 'tienda',
									        },
									        type : 'POST',
									        dataType : 'json',
									        success : function(data) {	
									        	MY_Socket.sendNewPost(data.vendedor+' - '+data.tienda,'noapartar');
												return false;	
									        }
								});	

							 
						}else{
							jQuery("."+identificador).addClass( "danger" );
								jQuery.ajax({
									        url : 'conteo_tienda',
									        data : { 
									        	tipo: 'tienda',
									        },
									        type : 'POST',
									        dataType : 'json',
									        success : function(data) {	
									        	MY_Socket.sendNewPost(data.vendedor+' - '+data.tienda,'apartar');
												return false;	
									        }
								});	
						}
		        }
	});						        
});


jQuery('body').on('click','#conf_apartado', function (e) {

	proveedor=jQuery('.buscar_proveedor').typeahead("val");

		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);


	jQuery.ajax({
		        url : 'apartado_definitivo',
		        data : { 
		        	id_cliente: proveedor,
		        },
		        type : 'POST',
		       // dataType : 'json',
		        success : function(data) {	
		        
						if(data != true){
								
								spinner.stop();
								jQuery('#foo').css('display','none');
								jQuery('#messages').css('display','block');
								jQuery('#messages').addClass('alert-danger');
								jQuery('#messages').html(data);
								jQuery('html,body').animate({
									'scrollTop': jQuery('#messages').offset().top
								}, 1000);
						}else{

							spinner.stop();
							jQuery('#foo').css('display','none');


								jQuery.ajax({
									        url : 'conteo_tienda',
									        data : { 
									        	tipo: 'tienda',
									        },
									        type : 'POST',
									        dataType : 'json',
									        success : function(data) {	
									        	MY_Socket.sendNewPost(data.vendedor+' - '+data.tienda,'conf_apartado');
									        	window.location.href = '/';
									        }
								});										
							
							  

							// 
							 //return false;
						}
		        }
	});						        
});

jQuery('body').on('click','#ver_dis', function (e) {
  jQuery( "#cont_tab" ).animate({height: 'toggle'});
});


jQuery('#id_estatus, #id_color').change(function(e) {
	var hash_url = window.location.pathname;
	if  ( (hash_url!="/entradas") )  {  //sino es entrada
		var oTable =jQuery('#tabla_inicio').dataTable();
		oTable._fnAjaxUpdate();
	}	
});

//////////



jQuery('#tabla_apartado').dataTable( {
	"pagingType": "full_numbers",
	"processing": true,
	"serverSide": true,
	"ajax": {
            	"url" : "procesando_apartado_pendiente",
         		"type": "POST"
     },   
	"infoCallback": function( settings, start, end, max, total, pre ) {
	    return pre
	},    

	 "rowCallback": function( row, data ) {
	    // Bold the grade for all 'A' grade browsers
	    if ( data[8] == 1 ) {
	      jQuery('td', row).addClass( "danger" );
	    }

	    if ( data[8] == 0 ) {
	      jQuery('td', row).removeClass( "danger" );
	    }

	  },	

   "columnDefs": [
    			{ 
	                "render": function ( data, type, row ) {
						return data;	
	                },
	                "targets": [0,1,2,3,4,5]
	            },
    			{ 
	                "render": function ( data, type, row ) {
    					 texto='<td><a href="apartado_detalle/'+jQuery.base64.encode(row[6])+'/'+jQuery.base64.encode(row[7])+'" '; 
						 	texto+=' class="btn btn-success btn-block">';
						 	texto+=' Detalles';
						 texto+='</a></td>';


						return texto;	
	                },
	                "targets": [6]
	            },
    			{ 
	                "render": function ( data, type, row ) {

						texto='<td><a href="eliminar_apartado_detalle/'+jQuery.base64.encode(row[6])+'/'+jQuery.base64.encode(row[7])+'" '; 
							texto+='class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalMessage">';
							texto+='<span class="glyphicon glyphicon-remove"></span>';
						texto+='</a></td>';
						
						return texto;	

	                },
	                "targets": [7]
	            },
    			{ 
	                "render": function ( data, type, row ) {

						texto='<td><button type="button"  id_usuario_apartado="'+jQuery.base64.encode(row[6])+'" id_cliente_apartado="'+jQuery.base64.encode(row[7])+'" class="btn btn-warning btn-sm btn-block prorrogar_venta ">';
						texto+=' <span class="glyphicon glyphicon-time"></span>';
						texto+='</button></td>';	

						return texto;	

	                },
	                "targets": [8]
	            }		            	            

	],	

	"fnHeaderCallback": function( nHead, aData, iStart, iEnd, aiDisplay ) {
		var arreglo =apartado_pendiente;
		for (var i=0; i<=arreglo.length-1; i++) { //cant_colum
	    		nHead.getElementsByTagName('th')[i].innerHTML = arreglo[i]; 
	    	}
	},	

	"language": {  //tratamiento de lenguaje
		"lengthMenu": "Mostrar _MENU_ registros por paginas",
		"zeroRecords": "No hay registros - disculpe",
		"info": "Mostrando pagina _PAGE_ de _PAGES_",
		"infoEmpty": "No hay registros disponibles",
		"infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
		"emptyTable":     "No hay disponibles datos en la tabla",
		"infoPostFix":    "",
		"thousands":      ",",
		"loadingRecords": "Leyendo...",
		"processing":     "Procesando...",
		"search":         "Buscar:",
		"paginate": {
			"first":      "Primero",
			"last":       "Ultimo",
			"next":       "Próximo",
			"previous":   "Anterior"
		},
		"aria": {
			"sortAscending":  ": Activando para ordenar columnas ascendentes",
			"sortDescending": ": Activando para ordenar columnas descendentes"
		},
	},
});	


	/*
	jQuery('#modalMessage').on('hide.bs.modal', function(e) {
	    jQuery(this).removeData('bs.modal');
	});	
	*/

	//gestion de usuarios (crear, editar y eliminar )
	//jQuery("#form_apartado").submit(function(e){

    jQuery('body').on('submit','#form_apartado', function (e) {


		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);
		jQuery(this).ajaxSubmit({
			success: function(data){
				if(data != true){
					
					spinner.stop();
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','block');
					jQuery('#messages').addClass('alert-danger');
					jQuery('#messages').html(data);
					jQuery('html,body').animate({
						'scrollTop': jQuery('#messages').offset().top
					}, 1000);
				

				}else{
					    $catalogo = e.target.name;
					    
						spinner.stop();
						jQuery('#foo').css('display','none');



								jQuery.ajax({
									        url : 'conteo_tienda',
									        data : { 
									        	tipo: 'tienda',
									        },
									        type : 'POST',
									        dataType : 'json',
									        success : function(data) {	
									        	MY_Socket.sendNewPost(data.vendedor+' - '+data.tienda,'form_apartado');
									        	//alert('este');
									        	window.location.href = '/'+$catalogo;	
									        }
								});		



						//window.location.href = '/'+$catalogo;	
				}
			} 
		});
		return false;
	});	



jQuery('body').on('submit','#form_pedido', function (e) {


		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);
		jQuery(this).ajaxSubmit({
			success: function(data){
				if(data != true){
					
					spinner.stop();
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','block');
					jQuery('#messages').addClass('alert-danger');
					jQuery('#messages').html(data);
					jQuery('html,body').animate({
						'scrollTop': jQuery('#messages').offset().top
					}, 1000);
				

				}else{
					    $catalogo = e.target.name;
					    
						spinner.stop();
						jQuery('#foo').css('display','none');



								jQuery.ajax({
									        url : 'conteo_tienda',
									        data : { 
									        	tipo: 'tienda',
									        },
									        type : 'POST',
									        dataType : 'json',
									        success : function(data) {	
									        	MY_Socket.sendNewPost(data.vendedor+' - '+data.tienda,'form_pedido');
									        	//alert('este');
									        	window.location.href = '/'+$catalogo;	
									        }
								});		



						//window.location.href = '/'+$catalogo;	
				}
			} 
		});
		return false;
	});	


////////////////////////Pedidos de Apartados /////////////////////////////////////

jQuery('#tabla_detalle').dataTable( {
	"pagingType": "full_numbers",
	"processing": true,
	"serverSide": true,
	"ajax": {
            	"url" : "/procesando_detalle",
         		"type": "POST",
         		 "data": function ( d ) {
     				   d.id_usuario = jQuery("#id_usuario_apartado").val();  //"0cc5510f-c452-11e4-8ada-7071bce181c3"; //
     				   d.id_cliente = jQuery("#id_cliente_apartado").val();  //3; //
    			 } 

     },   


	"infoCallback": function( settings, start, end, max, total, pre ) {
	    if (settings.json.datos) {
		    jQuery('#etiq_usuario').val(  settings.json.datos.usuario);
		    jQuery('#etiq_cliente').val(  settings.json.datos.cliente);
			jQuery('#etiq_comprador').val(  settings.json.datos.comprador);

		    jQuery('#etiq_fecha').val(  settings.json.datos.mi_fecha);
		    jQuery('#etiq_hora').val(  settings.json.datos.mi_hora);
		    jQuery('#etiq_tipo_apartado').html(  settings.json.datos.tipo_apartado);
		    jQuery('#etiq_color_apartado').html('<div style="margin-right: 15px;float:left;background-color:#'+settings.json.datos.color_apartado+';width:15px;height:15px;"></div>');

		}	
	    return pre
	},    

   "columnDefs": [
    			{ 
	                "render": function ( data, type, row ) {
						return data;	
	                },
	                "targets": [0,1,2,3,4,5,6,7],
	            }

	],	

	"fnHeaderCallback": function( nHead, aData, iStart, iEnd, aiDisplay ) {
		var arreglo =arr_apartado_detalle;
		for (var i=0; i<=arreglo.length-1; i++) { //cant_colum //
	    		nHead.getElementsByTagName('th')[i].innerHTML = arreglo[i]; 
	    	}
	},	

	"language": {  //tratamiento de lenguaje
		"lengthMenu": "Mostrar _MENU_ registros por paginas",
		"zeroRecords": "No hay registros - disculpe",
		"info": "Mostrando pagina _PAGE_ de _PAGES_",
		"infoEmpty": "No hay registros disponibles",
		"infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
		"emptyTable":     "No hay disponibles datos en la tabla",
		"infoPostFix":    "",
		"thousands":      ",",
		"loadingRecords": "Leyendo...",
		"processing":     "Procesando...",
		"search":         "Buscar:",
		"paginate": {
			"first":      "Primero",
			"last":       "Ultimo",
			"next":       "Próximo",
			"previous":   "Anterior"
		},
		"aria": {
			"sortAscending":  ": Activando para ordenar columnas ascendentes",
			"sortDescending": ": Activando para ordenar columnas descendentes"
		},
	},
});	



jQuery('body').on('click','#incluir_salida', function (e) {

		
	 id_usuario = jQuery("#id_usuario_apartado").val();  //"0cc5510f-c452-11e4-8ada-7071bce181c3"; //
     id_cliente = jQuery("#id_cliente_apartado").val();  //3; //

	jQuery.ajax({
		        url : '/incluir_apartado',
		        data : { 
		        	id_usuario: id_usuario,
		        	id_cliente: id_cliente,
		        },
		        type : 'POST',
		        dataType : 'json',
		        success : function(data) {	
						if(data != true){
						     jQuery('#etiq_tipo_apartado').html('Disponibilidad Salida');
						     jQuery('#etiq_color_apartado').html('<div style="margin-right: 15px;float:left;background-color:#14b80f;width:15px;height:15px;"></div>');

							 return false;	
						}else{
						     jQuery('#etiq_tipo_apartado').html('Disponibilidad Salida');
						     jQuery('#etiq_color_apartado').html('<div style="margin-right: 15px;float:left;background-color:#14b80f;width:15px;height:15px;"></div>');

							 return false;
						}
		        }
	});						        
});


jQuery('body').on('click','#excluir_salida', function (e) {

		
	 id_usuario = jQuery("#id_usuario_apartado").val();  //"0cc5510f-c452-11e4-8ada-7071bce181c3"; //
     id_cliente = jQuery("#id_cliente_apartado").val();  //3; //

	jQuery.ajax({
		        url : '/excluir_apartado',
		        data : { 
		        	id_usuario: id_usuario,
		        	id_cliente: id_cliente,
		        },
		        type : 'POST',
		        dataType : 'json',
		        success : function(data) {	
						if(data != true){
							 jQuery('#etiq_tipo_apartado').html('Apartado Confirmado');
						     jQuery('#etiq_color_apartado').html('<div style="margin-right: 15px;float:left;background-color:#f1a914;width:15px;height:15px;"></div>');

							 return false;	
						}else{
							 jQuery('#etiq_tipo_apartado').html('Apartado Confirmado');
						     jQuery('#etiq_color_apartado').html('<div style="margin-right: 15px;float:left;background-color:#f1a914;width:15px;height:15px;"></div>');

							 return false;
						}
		        }
	});						        
});





/////////////////////////////Modulo de salida////////////////////////////////////////////////////


jQuery('body').on('click','#proc_salida', function (e) {


	jQuery('#foo').css('display','block');
	var spinner = new Spinner(opts).spin(target);

	id_cliente = jQuery('.buscar_proveedor').typeahead("val");
	id_cargador = jQuery('.buscar_cargador').typeahead("val");
	factura = jQuery("#factura").val();

	 var url = 'confirmar_salida_sino';

	jQuery.ajax({
		        url : url,
		        type : 'POST',
		       	data : { 
		        	id_cliente: id_cliente,
		        	id_cargador: id_cargador,
		        	factura: factura
		        },
		        dataType : 'json',
		        success : function(data) {	
						if(data.exito != true){
								spinner.stop();
								jQuery('#foo').css('display','none');
								jQuery('#messages').css('display','block');
								jQuery('#messages').addClass('alert-danger');
								jQuery('#messages').html(data.error);
								jQuery('#messages').append(data.errores);
								jQuery('html,body').animate({
									'scrollTop': jQuery('#messages').offset().top
								}, 1000);
						}else{

							spinner.stop();
							jQuery('#foo').css('display','none');



								jQuery.ajax({
									        url : 'conteo_tienda',
									        data : { 
									        	tipo: 'tienda',
									        },
									        type : 'POST',
									        dataType : 'json',
									        success : function(data) {	
									        	MY_Socket.sendNewPost(data.vendedor+' - '+data.tienda,'proc_salida');

												valor= jQuery.base64.encode(data.valor);

												var url = "pro_salida/"+valor+'/'+data.id_cliente;
											
												jQuery('#modalMessage').modal({
													  show:'true',
													remote:url,
												}); 									        	
									        }
								});	


						}
		        }

		        
	});						        
});



//Agregar las estradas a salidas
jQuery('table').on('click','.agregar', function (e) {

	identificador = (jQuery(this).attr('identificador'));
	proveedor = jQuery('.buscar_proveedor').typeahead("val");
	cargador = jQuery('.buscar_cargador').typeahead("val");
	factura = jQuery("#factura").val();
	movimiento = jQuery("#movimiento").val();
 
	jQuery.ajax({
		        url : 'agregar_prod_salida',
		        data : { 
		        	identificador: identificador,
		        	id_cliente:proveedor,
		        	id_cargador:cargador,
		        	factura: factura,
		        	movimiento: movimiento
		        },
		        type : 'POST',
		        dataType : 'json',
		        success : function(data) {	
						if(data != true){
							//aqui es donde va el mensaje q no se ha copiado
						}else{
							jQuery("fieldset.disabledme").attr('disabled', true);

							jQuery('#tabla_salida').dataTable().fnDraw();
							jQuery('#tabla_entrada').dataTable().fnDraw();


								jQuery.ajax({
									        url : 'conteo_tienda',
									        data : { 
									        	tipo: 'tienda',
									        },
									        type : 'POST',
									        dataType : 'json',
									        success : function(data) {	
									        	MY_Socket.sendNewPost(data.vendedor+' - '+data.tienda,'agregar');
									        	return false;	
									        }
								});	

							//return false;
						}
		        }
	});						        
});



jQuery('#tabla_entrada').dataTable( {
 /*
 "sDom": 'T<"clear">lfrtip',
        "oTableTools": {
            "sRowSelect": "single"
        },
      */  
	"processing": true, //	//tratamiento con base de datos
	"serverSide": true,
	"ajax": {
            	"url" : "procesando_servidor",
         		"type": "POST",
         		 "data": function ( d ) {
     				   if  (jQuery('.buscar_proveedor').typeahead("val")) {
     				   		d.id_cliente = jQuery('.buscar_proveedor').typeahead("val");
     				   	} else {
     				   		d.id_cliente = jQuery('#id_proveedor').val();	
     				   	}	
    				    
    			 } 
     }, 
	"language": {  //tratamiento de lenguaje
		"lengthMenu": "Mostrar _MENU_ registros por paginas",
		"zeroRecords": "No hay registros - disculpe",
		"info": "Mostrando pagina _PAGE_ de _PAGES_",
		"infoEmpty": "No hay registros disponibles",
		"infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
		"emptyTable":     "No hay disponibles datos en la tabla",
		"infoPostFix":    "",
		"thousands":      ",",
		"loadingRecords": "Leyendo...",
		"processing":     "Procesando...",
		"search":         "Buscar:",
		"paginate": {
			"first":      "Primero",
			"last":       "Ultimo",
			"next":       "Próximo",
			"previous":   "Anterior"
		},
		"aria": {
			"sortAscending":  ": Activando para ordenar columnas ascendentes",
			"sortDescending": ": Activando para ordenar columnas descendentes"
		},
	},
		 "rowCallback": function( row, data ) {
		    // Bold the grade for all 'A' grade browsers
		    if ( data[9] == 3 ) {
		      jQuery('td', row).addClass( "danger" );
		    }

		    if ( data[9] == 6 ) {
		      jQuery('td', row).addClass( "success" );
		    }

		  },
	"columnDefs": [
	    		{ 
	                "render": function ( data, type, row ) {
	                		return data;
	                },
	                "targets": [0,1,2,3,4,5,6,7]
	            },
	            {
	                "render": function ( data, type, row ) {
						texto='<td><button'; 
							texto+='type="button" class="btn btn-success btn-block agregar '+data+'" identificador="'+data+'" >';
							texto+='<span  class="">Agregar</span>';
						texto+='</button></td>';
						return texto;	
	                },
	                "targets": 8
	            },
	        ],
});	
 
//Quitar las salidas y retornarlas a estradas 
jQuery('table').on('click','.quitar', function (e) {
	identificador = (jQuery(this).attr('identificador'));
	jQuery.ajax({
		        url : 'quitar_prod_salida', //
		        data : { 
		        	identificador: identificador
		        },
		        type : 'POST',
		        dataType : 'json',
		        success : function(data) {	
						if(data.exito != true){
							//aqui es donde va el mensaje q no se ha copiado
						}else{
							if(data.total == 0){
								jQuery("fieldset.disabledme").attr('disabled', false);
							}	
							jQuery('#tabla_entrada').dataTable().fnDraw();
							jQuery('#tabla_salida').dataTable().fnDraw();

								jQuery.ajax({
									        url : 'conteo_tienda',
									        data : { 
									        	tipo: 'tienda',
									        },
									        type : 'POST',
									        dataType : 'json',
									        success : function(data) {	
									        	MY_Socket.sendNewPost(data.vendedor+' - '+data.tienda,'quitar');
									     		return false;
									        }
								});	

							//return false;
						}
		        }
	});						        
});

jQuery('#tabla_salida').dataTable( {
	"scrollY": "200px",
	"paging": false,
	"ordering": false,
	"info":     false,
	"searching": false,

	"processing": true, 	//tratamiento con base de datos
	"serverSide": true,
	"ajax": "procesando_servidor_salida",  //
	"language": {  //tratamiento de lenguaje
		"lengthMenu": "Mostrar _MENU_ registros por paginas",
		"zeroRecords": "No hay registros - disculpe",
		"info": "Mostrando pagina _PAGE_ de _PAGES_",
		"infoEmpty": "No hay registros disponibles",
		"infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
		"emptyTable":     "No hay disponibles datos en la tabla",
		"infoPostFix":    "",
		"thousands":      ",",
		"loadingRecords": "Leyendo...",
		"processing":     "Procesando...",
		"search":         "Buscar:",
		"paginate": {
			"first":      "Primero",
			"last":       "Ultimo",
			"next":       "Próximo",
			"previous":   "Anterior"
		},
		"aria": {
			"sortAscending":  ": Activando para ordenar columnas ascendentes",
			"sortDescending": ": Activando para ordenar columnas descendentes"
		},
	},


	 "rowCallback": function( row, data ) {
	    // Bold the grade for all 'A' grade browsers
	    if ( data[9] == 3 ) {
	      jQuery('td', row).addClass( "danger" );
	    }

	    if ( data[9] == 6 ) {
	      jQuery('td', row).addClass( "success" );
	    }

	  },	
	  
	"columnDefs": [
		    	
		    	{ 
	                "render": function ( data, type, row ) {
	                		return data;
	                },
	                "targets": [0,1,2,3,4,5,6,7]
	            },
	            
	            {
	                "render": function ( data, type, row ) {
						texto='<td><button'; 
							texto+='type="button" identificador="'+data+'" class="btn btn-danger btn-block quitar">';
							texto+='<span class="glyphicon btn-danger">Quitar</span>';
						texto+='</button></td>';
						return texto;	
	                },
	                "targets": 8
	            }
	        ],
});	




/////////////////////////////////////////////////PEDIDO Completado///////////////////////////////////////////////////////////

jQuery('#pedido_completo_detalle').dataTable( {
	"pagingType": "full_numbers",
	"processing": true,
	"serverSide": true,
	"ajax": {
            	"url" : "/procesando_completo_detalle",
         		"type": "POST",
         		 "data": function ( d ) {
     				   d.mov_salida = jQuery("#mov_salida").val();  //numero_mov del pedido
     				   d.id_apartado = jQuery("#id_apartado").val();  //numero_mov del pedido
    			 } 

     },   


	"infoCallback": function( settings, start, end, max, total, pre ) {
	    
	    if (settings.json.datos) {
			
			if (settings.json.datos.tipo_apartado=="Vendedor") {
				jQuery('#label_cliente').text("Comprador");
				jQuery('#label_vendedor').text("Vendedor");
				
			} else {
				jQuery('#label_cliente').text("Cliente");
				jQuery('#label_vendedor').text("Num. Mov");
			}
				

			jQuery('#etiq_num_mov').val(  settings.json.datos.num_mov);
	    	
		    
		    jQuery('#etiq_cliente').val(  settings.json.datos.cliente);
			jQuery('#etiq_dependencia').val(  settings.json.datos.dependencia);

		    jQuery('#etiq_fecha').val(  settings.json.datos.mi_fecha);
		    jQuery('#etiq_hora').val(  settings.json.datos.mi_hora);

		    jQuery('#etiq_tipo_apartado').html(  settings.json.datos.tipo_apartado+' '+settings.json.datos.tipo_pedido  );
		    jQuery('#etiq_color_apartado').html('<div style="margin-right: 15px;float:left;background-color:#'+settings.json.datos.color_apartado+';width:15px;height:15px;"></div>');
			
		}	
		
	    return pre
	},    

   "columnDefs": [
    			{ 
	                "render": function ( data, type, row ) {
						return data;	
	                },
	                "targets": [0,1,2,3,4,5,6],
	            }

	],	

	"fnHeaderCallback": function( nHead, aData, iStart, iEnd, aiDisplay ) {
		var arreglo =arr_completo_detalle;
		for (var i=0; i<=arreglo.length-1; i++) { //cant_colum //
	    		nHead.getElementsByTagName('th')[i].innerHTML = arreglo[i]; 
	    	}
	},	

	"language": {  //tratamiento de lenguaje
		"lengthMenu": "Mostrar _MENU_ registros por paginas",
		"zeroRecords": "No hay registros - disculpe",
		"info": "Mostrando pagina _PAGE_ de _PAGES_",
		"infoEmpty": "No hay registros disponibles",
		"infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
		"emptyTable":     "No hay disponibles datos en la tabla",
		"infoPostFix":    "",
		"thousands":      ",",
		"loadingRecords": "Leyendo...",
		"processing":     "Procesando...",
		"search":         "Buscar:",
		"paginate": {
			"first":      "Primero",
			"last":       "Ultimo",
			"next":       "Próximo",
			"previous":   "Anterior"
		},
		"aria": {
			"sortAscending":  ": Activando para ordenar columnas ascendentes",
			"sortDescending": ": Activando para ordenar columnas descendentes"
		},
	},
});	


jQuery('#tabla_pedido_completado').dataTable( {
	"pagingType": "full_numbers",
	"processing": true,
	"serverSide": true,
	"ajax": {
            	"url" : "procesando_pedido_completo",
         		"type": "POST"
     },   
	"infoCallback": function( settings, start, end, max, total, pre ) {
	    return pre
	},    

   "columnDefs": [
    			{ 
	                "render": function ( data, type, row ) {
						return data;	
	                },
	                "targets": [0,1,2,3,4,5]
	            },

    			{ 
	                "render": function ( data, type, row ) {
    					 texto='<td><a href="pedido_completado_detalle/'+jQuery.base64.encode(row[5])+'/'+jQuery.base64.encode(row[6])+'" ';  //+jQuery.base64.encode(row[6])+'" '; 
						 	texto+=' class="btn btn-success btn-block">';
						 	texto+=' Detalles';
						 texto+='</a></td>';


						return texto;	
	                },
	                "targets": [6]
	            }

	],	

	"fnHeaderCallback": function( nHead, aData, iStart, iEnd, aiDisplay ) {
		var arreglo =pedido_completo;
		for (var i=0; i<=arreglo.length-1; i++) { //cant_colum
	    		nHead.getElementsByTagName('th')[i].innerHTML = arreglo[i]; 
	    	}
	},	

	"language": {  //tratamiento de lenguaje
		"lengthMenu": "Mostrar _MENU_ registros por paginas",
		"zeroRecords": "No hay registros - disculpe",
		"info": "Mostrando pagina _PAGE_ de _PAGES_",
		"infoEmpty": "No hay registros disponibles",
		"infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
		"emptyTable":     "No hay disponibles datos en la tabla",
		"infoPostFix":    "",
		"thousands":      ",",
		"loadingRecords": "Leyendo...",
		"processing":     "Procesando...",
		"search":         "Buscar:",
		"paginate": {
			"first":      "Primero",
			"last":       "Ultimo",
			"next":       "Próximo",
			"previous":   "Anterior"
		},
		"aria": {
			"sortAscending":  ": Activando para ordenar columnas ascendentes",
			"sortDescending": ": Activando para ordenar columnas descendentes"
		},
	},
});	




/////////////////////////////////////////////////PEDIDO///////////////////////////////////////////////////////////

jQuery('body').on('click','#incluir_pedido', function (e) {
	 
     num_mov = jQuery("#num_mov").val();  //3; //
 	 jQuery.ajax({
		        url : '/incluir_pedido',
		        data : { 
		        	num_mov: num_mov,
		        },
		        type : 'POST',
		        dataType : 'json',
		        success : function(data) {	
						if(data != true){
						     jQuery('#etiq_tipo_apartado').html('Disponibilidad Salida');
						     jQuery('#etiq_color_apartado').html('<div style="margin-right: 15px;float:left;background-color:#14b80f;width:15px;height:15px;"></div>');
							 return false;	
						}else{
						     jQuery('#etiq_tipo_apartado').html('Disponibilidad Salida');
						     jQuery('#etiq_color_apartado').html('<div style="margin-right: 15px;float:left;background-color:#14b80f;width:15px;height:15px;"></div>');
							 return false;
						}
		        }
	});						        
});


jQuery('body').on('click','#excluir_pedido', function (e) {

num_mov = jQuery("#num_mov").val();  //3; //

	jQuery.ajax({
		        url : '/excluir_pedido',
		        data : { 
		        	num_mov: num_mov,
		        	
		        },
		        type : 'POST',
		        dataType : 'json',
		        success : function(data) {	
						if(data != true){
							 jQuery('#etiq_tipo_apartado').html('Apartado Confirmado');
						     jQuery('#etiq_color_apartado').html('<div style="margin-right: 15px;float:left;background-color:#f1a914;width:15px;height:15px;"></div>');

							 return false;	
						}else{
							 jQuery('#etiq_tipo_apartado').html('Apartado Confirmado');
						     jQuery('#etiq_color_apartado').html('<div style="margin-right: 15px;float:left;background-color:#f1a914;width:15px;height:15px;"></div>');

							 return false;
						}
		        }
	});						        
});





jQuery('#pedido_detalle').dataTable( {
	"pagingType": "full_numbers",
	"processing": true,
	"serverSide": true,
	"ajax": {
            	"url" : "/procesando_pedido_detalle",
         		"type": "POST",
         		 "data": function ( d ) {
     				   d.num_mov = jQuery("#num_mov").val();  //numero_mov del pedido
    			 } 

     },   


	"infoCallback": function( settings, start, end, max, total, pre ) {
	    
	    if (settings.json.datos) {

			jQuery('#etiq_num_mov').val(  settings.json.datos.num_mov);
	    	
		    
		    jQuery('#etiq_cliente').val(  settings.json.datos.cliente);
			jQuery('#etiq_dependencia').val(  settings.json.datos.dependencia);

		    jQuery('#etiq_fecha').val(  settings.json.datos.mi_fecha);
		    jQuery('#etiq_hora').val(  settings.json.datos.mi_hora);

		    jQuery('#etiq_tipo_apartado').html(  settings.json.datos.tipo_apartado);
		    jQuery('#etiq_color_apartado').html('<div style="margin-right: 15px;float:left;background-color:#'+settings.json.datos.color_apartado+';width:15px;height:15px;"></div>');
			
		}	
		
	    return pre
	},    

   "columnDefs": [
    			{ 
	                "render": function ( data, type, row ) {
						return data;	
	                },
	                "targets": [0,1,2,3,4,5,6,7],
	            }

	],	

	"fnHeaderCallback": function( nHead, aData, iStart, iEnd, aiDisplay ) {
		var arreglo =arr_pedido_detalle;
		for (var i=0; i<=arreglo.length-1; i++) { //cant_colum //
	    		nHead.getElementsByTagName('th')[i].innerHTML = arreglo[i]; 
	    	}
	},	

	"language": {  //tratamiento de lenguaje
		"lengthMenu": "Mostrar _MENU_ registros por paginas",
		"zeroRecords": "No hay registros - disculpe",
		"info": "Mostrando pagina _PAGE_ de _PAGES_",
		"infoEmpty": "No hay registros disponibles",
		"infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
		"emptyTable":     "No hay disponibles datos en la tabla",
		"infoPostFix":    "",
		"thousands":      ",",
		"loadingRecords": "Leyendo...",
		"processing":     "Procesando...",
		"search":         "Buscar:",
		"paginate": {
			"first":      "Primero",
			"last":       "Ultimo",
			"next":       "Próximo",
			"previous":   "Anterior"
		},
		"aria": {
			"sortAscending":  ": Activando para ordenar columnas ascendentes",
			"sortDescending": ": Activando para ordenar columnas descendentes"
		},
	},
});	


jQuery('body').on('click','.prorrogar_tienda', function (e) {
	
	id_cliente_apartado = (jQuery(this).attr('id_cliente_apartado'));

	jQuery.ajax({
		        url : 'marcando_prorroga_tienda',
		        data : { 
		        	id_cliente_apartado: id_cliente_apartado
		        },
		        type : 'POST',
		        dataType : 'json',
		        success : function(data) {	
		        	   jQuery('#tabla_pedido').dataTable().fnDraw();
		        }
	});						        
});


jQuery('#tabla_pedido').dataTable( {
	"pagingType": "full_numbers",
	"processing": true,
	"serverSide": true,
	"ajax": {
            	"url" : "procesando_pedido_pendiente",
         		"type": "POST"
     },   
	"infoCallback": function( settings, start, end, max, total, pre ) {
	    return pre
	},    
	 
	 "rowCallback": function( row, data ) {
	    // Bold the grade for all 'A' grade browsers
	    if ( data[7] == 1 ) {
	      jQuery('td', row).addClass( "danger" );
	    }

	    if ( data[7] == 0 ) {
	      jQuery('td', row).removeClass( "danger" );
	    }
	  },	

   "columnDefs": [
    			{ 
	                "render": function ( data, type, row ) {
						return data;	
	                },
	                "targets": [0,1,2,3,4,5]
	            },
    			{ 
	                "render": function ( data, type, row ) {
    					 texto='<td><a href="pedido_detalle/'+jQuery.base64.encode(row[6])+'" '; 
						 	texto+=' class="btn btn-success btn-block">';
						 	texto+=' Detalles';
						 texto+='</a></td>';


						return texto;	
	                },
	                "targets": [6]
	            },
    			{ 
	                "render": function ( data, type, row ) {

						texto='<td><a href="eliminar_pedido_detalle/'+jQuery.base64.encode(row[6])+'" '; 
							texto+='class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalMessage">';
							texto+='<span class="glyphicon glyphicon-remove"></span>';
						texto+='</a></td>';
						
						return texto;	

	                },
	                "targets": [7]
	            },	  
    			{ 
	                "render": function ( data, type, row ) {

						texto='<td><button type="button"  id_cliente_apartado="'+jQuery.base64.encode(row[6])+'"  class="btn btn-warning btn-sm btn-block prorrogar_tienda ">';
						texto+=' <span class="glyphicon glyphicon-time"></span>';
						texto+='</button></td>';	

						return texto;	


						return texto;	

	                },
	                "targets": [8]
	            }	 	                      

	],	

	"fnHeaderCallback": function( nHead, aData, iStart, iEnd, aiDisplay ) {
		var arreglo =pedido_pendiente;
		// ['Cliente', 'Dependencia','Consecutivo', 'Fecha','Tipo Apartado','Detalles','Cancelar']; 
		for (var i=0; i<=arreglo.length-1; i++) { //cant_colum
	    		nHead.getElementsByTagName('th')[i].innerHTML = arreglo[i]; 
	    	}
	},	

	"language": {  //tratamiento de lenguaje
		"lengthMenu": "Mostrar _MENU_ registros por paginas",
		"zeroRecords": "No hay registros - disculpe",
		"info": "Mostrando pagina _PAGE_ de _PAGES_",
		"infoEmpty": "No hay registros disponibles",
		"infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
		"emptyTable":     "No hay disponibles datos en la tabla",
		"infoPostFix":    "",
		"thousands":      ",",
		"loadingRecords": "Leyendo...",
		"processing":     "Procesando...",
		"search":         "Buscar:",
		"paginate": {
			"first":      "Primero",
			"last":       "Ultimo",
			"next":       "Próximo",
			"previous":   "Anterior"
		},
		"aria": {
			"sortAscending":  ": Activando para ordenar columnas ascendentes",
			"sortDescending": ": Activando para ordenar columnas descendentes"
		},
	},
});	



jQuery('body').on('click','#conf_pedido', function (e) {

	num_mov=jQuery('#movimiento').val();

	jQuery('#foo').css('display','block');
	var spinner = new Spinner(opts).spin(target);


	jQuery.ajax({
		        url : 'pedido_definitivo',
		        data : { 
		        	num_mov: num_mov,
		        },
		        type : 'POST',
		       // dataType : 'json',
		        success : function(data) {	
		        
						if(data != true){
								spinner.stop();
								jQuery('#foo').css('display','none');
								jQuery('#messages').css('display','block');
								jQuery('#messages').addClass('alert-danger');
								jQuery('#messages').html(data);
								jQuery('html,body').animate({
									'scrollTop': jQuery('#messages').offset().top
								}, 1000);
						}else{

							spinner.stop();
							jQuery('#foo').css('display','none');

								jQuery.ajax({
									        url : 'conteo_tienda',
									        data : { 
									        	tipo: 'tienda',
									        },
									        type : 'POST',
									        dataType : 'json',
									        success : function(data) {	
									        	MY_Socket.sendNewPost(data.vendedor+' - '+data.tienda,'conf_pedido');
									        	//alert('este');
									        	window.location.href = '/';
									        }
								});		

							// window.location.href = '/';
							 //return false;
						}
		        }
	});						        
});


jQuery('#pedido_entrada').dataTable( {
	
	"processing": true,
	"serverSide": true,
	"ajax": {
            	"url" : "procesando_pedido_entrada",
         		"type": "POST",
     }, 

	"language": {  
		"lengthMenu": "Mostrar _MENU_ registros por paginas",
		"zeroRecords": "No hay registros - disculpe",
		"info": "Mostrando pagina _PAGE_ de _PAGES_",
		"infoEmpty": "No hay registros disponibles",
		"infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
		"emptyTable":     "No hay disponibles datos en la tabla",
		"infoPostFix":    "",
		"thousands":      ",",
		"loadingRecords": "Leyendo...",
		"processing":     "Procesando...",
		"search":         "Buscar:",
		"paginate": {
			"first":      "Primero",
			"last":       "Ultimo",
			"next":       "Próximo",
			"previous":   "Anterior"
		},
		"aria": {
			"sortAscending":  ": Activando para ordenar columnas ascendentes",
			"sortDescending": ": Activando para ordenar columnas descendentes"
		},
	},

	"columnDefs": [
	    		{ 
	                "render": function ( data, type, row ) {
	                		return data;
	                },
	                "targets": [0,1,2,3,4,5,6,7]
	            },
	            {
	                "render": function ( data, type, row ) {
						texto='<td><button'; 
							texto+='type="button" identificador="'+data+'" class="btn btn-success btn-block agregar_pedido '+data+'">';
							texto+='<span  class="">Agregar</span>';
						texto+='</button></td>';

						return texto;	
	                },
	                "targets": 8
	            },
	        ],
});	



jQuery('#pedido_salida').dataTable( {
	"processing": true,
	"serverSide": true,
	"ajax": {
            	"url" : "procesando_pedido_salida",
         		"type": "POST",
     }, 

	"language": {  
		"lengthMenu": "Mostrar _MENU_ registros por paginas",
		"zeroRecords": "No hay registros - disculpe",
		"info": "Mostrando pagina _PAGE_ de _PAGES_",
		"infoEmpty": "No hay registros disponibles",
		"infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
		"emptyTable":     "No hay disponibles datos en la tabla",
		"infoPostFix":    "",
		"thousands":      ",",
		"loadingRecords": "Leyendo...",
		"processing":     "Procesando...",
		"search":         "Buscar:",
		"paginate": {
			"first":      "Primero",
			"last":       "Ultimo",
			"next":       "Próximo",
			"previous":   "Anterior"
		},
		"aria": {
			"sortAscending":  ": Activando para ordenar columnas ascendentes",
			"sortDescending": ": Activando para ordenar columnas descendentes"
		},
	},

	"columnDefs": [
	    		{ 
	                "render": function ( data, type, row ) {
	                		return data;
	                },
	                "targets": [0,1,2,3,4,5,6,7]
	            },	
	            {
	                "render": function ( data, type, row ) {
						
						texto='<td><button'; 
							texto+='type="button" identificador="'+data+'" class="btn btn-danger btn-block quitar_pedido">';
							texto+='<span class="glyphicon btn-danger">Quitar</span>';
						texto+='</button></td>';
						return texto;	
	                },
	                "targets": 8
	            }
	        ],
});	


//Agregar las estradas a salidas
jQuery('table').on('click','.agregar_pedido', function (e) {
	identificador = (jQuery(this).attr('identificador'));
	movimiento = jQuery("#movimiento").val();

	jQuery.ajax({
		        url : 'agregar_prod_pedido',
		        data : { 
		        	identificador: identificador,
		        	movimiento: movimiento
		        },
		        type : 'POST',
		        dataType : 'json',
		        success : function(data) {	
						if(data.exito != true){
							//aqui es donde va el mensaje q no se ha copiado

						}else{

							jQuery('#pedido_salida').dataTable().fnDraw();
							jQuery('#pedido_entrada').dataTable().fnDraw();

								jQuery.ajax({
									        url : 'conteo_tienda',
									        data : { 
									        	tipo: 'tienda',
									        },
									        type : 'POST',
									        dataType : 'json',
									        success : function(data) {	
									        	MY_Socket.sendNewPost(data.vendedor+' - '+data.tienda,'agregar_pedido');
												return false;
									        }
								});								
							 
						}
		        }
	});						        
});

 
//Quitar las salidas y retornarlas a estradas 
jQuery('table').on('click','.quitar_pedido', function (e) {
	identificador = (jQuery(this).attr('identificador'));
	jQuery.ajax({
		        url : 'quitar_prod_pedido', //
		        data : { 
		        	identificador: identificador
		        },
		        type : 'POST',
		        dataType : 'json',
		        success : function(data) {	
						if(data.exito != true){
							//aqui es donde va el mensaje q no se ha copiado
						}else{
							jQuery('#pedido_salida').dataTable().fnDraw();
							jQuery('#pedido_entrada').dataTable().fnDraw();

								jQuery.ajax({
									        url : 'conteo_tienda',
									        data : { 
									        	tipo: 'tienda',
									        },
									        type : 'POST',
									        dataType : 'json',
									        success : function(data) {	
									        	MY_Socket.sendNewPost(data.vendedor+' - '+data.tienda,'quitar_pedido');
									        	return false;
	
									        }
								});								
							 
						}


		        }
	});						        

});


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function centerModal() {
    jQuery(this).css('display', 'block');
    var $dialog = jQuery(this).find(".modal-dialog");
    var offset = (jQuery(window).height() - $dialog.height()) / 2;
    // Center modal vertically in window
    $dialog.css("margin-top", offset);
}

jQuery('.modal').on('show.bs.modal', centerModal);
jQuery(window).on("resize", function () {
    jQuery('.modal:visible').each(centerModal);
});

	//logueo y recuperar contraseña
	jQuery("#form_login").submit(function(e){
		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);
		jQuery(this).ajaxSubmit({
			success: function(data){
				if(data != true){
					spinner.stop();
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','block');
					jQuery('#messages').addClass('alert-danger');
					jQuery('#messages').html(data);
					jQuery('html,body').animate({
						'scrollTop': jQuery('#messages').offset().top
					}, 1000);
				}else{
						spinner.stop();
						jQuery('#foo').css('display','none');
						window.location.href = '';						
				}
			} 
		});
		return false;
	});

jQuery('.datepicker').datepicker({
    format: 'mm/dd/yyyy',
    startDate: '-3d'
});

  ////////////////////////////catalogos////////////////////////////////////////////////

	jQuery('#modalMessage').on('hide.bs.modal', function(e) {
	    jQuery(this).removeData('bs.modal');
	});	

	//gestion de usuarios (crear, editar y eliminar )
	jQuery("#form_catalogos").submit(function(e){
		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);
		jQuery(this).ajaxSubmit({
			success: function(data){
				if(data != true){
					
					spinner.stop();
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','block');
					jQuery('#messages').addClass('alert-danger');
					jQuery('#messages').html(data);
					jQuery('html,body').animate({
						'scrollTop': jQuery('#messages').offset().top
					}, 1000);
				

				}else{
					    $catalogo = e.target.name;
						spinner.stop();
						jQuery('#foo').css('display','none');
						window.location.href = '/'+$catalogo;	
				}
			} 
		});
		return false;
	});	


	//Agregar entrada temporal 
	jQuery("#form_entradas").submit(function(e){

		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);
		jQuery(this).ajaxSubmit({
			success: function(data){
				if(data != true){
					spinner.stop();
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','block');
					jQuery('#messages').addClass('alert-danger');
					jQuery('#messages').html(data);
					jQuery('html,body').animate({
						'scrollTop': jQuery('#messages').offset().top
					}, 1000);
				}else{
					spinner.stop();
					//borrar el mensaje q quedo	
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','none');
					


					color=jQuery('#color').val();
					cant_royo=jQuery('#cantidad_royo').val();
					referencia = jQuery('#referencia').val();
					id_lote = jQuery('#id_lote option:selected').val(); 

					jQuery.ajax({
						        url : 'inf_ajax_temporal',
						        data : { color: color, 
						        		cant_royo:cant_royo,
						        		referencia:referencia,
										id_lote:id_lote						        		

						        },
						        type : 'POST',
						        dataType : 'json',
						        success : function(data) {	
						        	
						        	jQuery.each(data.movimientos, function (i, valor) {
										producto=jQuery('#producto').val();
										medida=jQuery('#id_medida option:selected').text();
										cantidad=jQuery('#cantidad_um').val();
										ancho=jQuery('#ancho').val();
										proveedor=jQuery('.buscar_proveedor').typeahead("val");

										texto='<tr><td class="text-center">'+valor.codigo+'</td><td class="text-center">'+valor.id_descripcion+'</td>';
										
										texto+='<td class="text-center">';
											texto+='<div style="background-color:#'+valor.hexadecimal_color+';display:block;width:15px;height:15px;margin:0 auto;"></div>';
										texto+='</td>';																														

										texto+='</td><td class="text-center">'+valor.cantidad_um+' '+valor.medida+'</td>';
										
										texto+='</td><td class="text-center">'+valor.ancho+' Mtrs</td>';
										
										texto+='<td class="text-center">'+valor.nombre+'</td>';
										texto+='<td class="text-center">'+valor.id_lote+' - '+valor.consecutivo+'</td>';

										texto+='<td><a href="eliminar_prod_temporal/'+valor.id+'/'+jQuery.base64.encode(valor.codigo)+'" '; 
											texto+='class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalMessage">';
											texto+='<span class="glyphicon glyphicon-remove"></span>';
										texto+='</a></td>';
										
										texto+='</tr>';
										jQuery(".table tbody tr:last-child").after(texto);

				                    		
				                    });
						        },
						        error : function(jqXHR, status, error) {
						        },
						        complete : function(jqXHR, status) {
						            
						        }
					});



					//desabilito proveedor y factura
					jQuery("fieldset.disabledme").attr('disabled', true);
					//vuelve a los valores por defecto, producto, color, composicion y calidad

					//
					jQuery("#codigo").val('');
					jQuery("#cantidad_um").val('');
					jQuery("#cantidad_royo").val('');
					jQuery("#ancho").val('');
					jQuery("#precio").val('');
					jQuery("#comentario").val('');

					jQuery('#calidad option:eq(0)').prop('selected', 'selected');
					jQuery('#composicion option:eq(0)').prop('selected', 'selected');
					jQuery('#color option:eq(0)').prop('selected', 'selected');
					jQuery('#producto option:eq(0)').prop('selected', 'selected');

					jQuery('#producto').trigger( "change" );
					

					//um y estatus sus valores por defectos

					jQuery('#id_medida option:eq(0)').prop('selected', 'selected');
					jQuery('#id_estatus option:eq(0)').prop('selected', 'selected');
					jQuery('#id_lote option:eq(0)').prop('selected', 'selected');
					
					//para el caso en que no se hubiesen agredado productos antes. quitar ese primer tr del body



					if (jQuery(".table tbody .noproducto")) {
						jQuery(".table tbody .noproducto > td").remove();
					}	
				}
			} 
		});
		return false;
	});	




//Agregar las estradas a salidas
jQuery('body').on('click','#impresion', function (e) {
	

	codigo = jQuery("#editar_prod_inven").val(); 
	


		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);
		jQuery.ajax({
		        url : 'validar_impresion',
		        data : { 
		        	codigo: codigo,
		        },
		        type : 'POST',
		       // dataType : 'json',
		        success : function(data) {	
				if(data != true){
							spinner.stop();
							jQuery('#foo').css('display','none');
							jQuery('#messages').css('display','block');
							jQuery('#messages').addClass('alert-danger');
							jQuery('#messages').html(data);
							jQuery('html,body').animate({
								'scrollTop': jQuery('#messages').offset().top
							}, 1000);
						}else{
							spinner.stop();
							//borrar el mensaje q quedo	
							jQuery('#foo').css('display','none');
							jQuery('#messages').css('display','none');

							window.open('impresion_etiquetas/'+jQuery.base64.encode(codigo), '_blank');
							 return false;
						}
		        }
	});						        
	
});




	jQuery('#tabla_cambio').dataTable( {
		
		"scrollY": "200px",
		"paging": false,
		"ordering": false,
		"info":     false,
		"searching": false,
	

		//"pagingType": "full_numbers",
		"processing": true,
		"serverSide": true,
		"ajax": {
	            	"url" : "procesando_servidor_cambio",
	         		"type": "POST",
	         		 "data": function ( d ) {
	     				   d.codigo = jQuery("#codigo_original").val(); 
	    			 }
	     },   


		"language": {  //tratamiento de lenguaje
			"lengthMenu": "Mostrar _MENU_ registros por paginas",
			"zeroRecords": "No hay registros - disculpe",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(Mostrando _TOTAL_ de _MAX_ registros totales)",  
			"emptyTable":     "No hay disponibles datos en la tabla",
			"infoPostFix":    "",
			"thousands":      ",",
			"loadingRecords": "Leyendo...",
			"processing":     "Procesando...",
			"search":         "Buscar:",
			"paginate": {
				"first":      "Primero",
				"last":       "Ultimo",
				"next":       "Próximo",
				"previous":   "Anterior"
			},
			"aria": {
				"sortAscending":  ": Activando para ordenar columnas ascendentes",
				"sortDescending": ": Activando para ordenar columnas descendentes"
			},
		},


		"columnDefs": [
			    	
			    	{ 
		                "render": function ( data, type, row ) {
		                		return data;
		                },
		                "targets": [0,1,2,3,4,5,6,7]
		            },
		            
		        ],
	});	



	//Agregar entrada temporal 
	jQuery("#form_editar_inventario").submit(function(e){
		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);
		jQuery(this).ajaxSubmit({
			success: function(data){
				if(data != true){
					spinner.stop();
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','block');
					jQuery('#messages').addClass('alert-danger');
					jQuery('#messages').html(data);
					jQuery('html,body').animate({
						'scrollTop': jQuery('#messages').offset().top
					}, 1000);
				}else{
					spinner.stop();
					//borrar el mensaje q quedo	
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','none');
					jQuery('#tabla_cambio').dataTable().fnDraw();
				

				}
			} 
		});
		return false;
	});	

////////////////////////////ordenar////////////////////////////////////////////////


	jQuery(".tabla_ordenadas").tablesorter(); 
	jQuery("#tablahome1").tablesorter(); 
	jQuery("#tablahome2").tablesorter(); 
	jQuery("#tablahome3").tablesorter(); 








	/////////////////////////buscar producto_inventario (buscar_prod_inven)


	// busqueda de prod_inven
	var consulta_prod_inven = new Bloodhound({
	   datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nombre'),
	   queryTokenizer: Bloodhound.tokenizers.whitespace,
	   remote:'catalogos/buscador?key=%QUERY&nombre='+jQuery('.buscar_prod_inven').attr("name")+'&idprodinven='+jQuery('.buscar_prod_inven').attr("idprodinven"),
	});

	consulta_prod_inven.initialize();

	jQuery('.buscar_prod_inven').typeahead(
		{
			  hint: true,
		  highlight: true,
		  minLength: 1
		},

		 {
	  
	  name: 'buscar_prod_inven',
	  displayKey: 'descripcion', //
	  source: consulta_prod_inven.ttAdapter(),
	   templates: {
	   			//header: '<h4>'+jQuery('.buscar_prod_inven').attr("name")+'</h4>',
			    suggestion: function (data) {  
					return '<p><strong>' + data.descripcion + '</strong></p>'+
					 '<div style="background-color:'+ '#'+data.hexadecimal_color + ';display:block;width:15px;height:15px;margin:0 auto;"></div>';

		   }
	    
	  }
	});

	jQuery('.buscar_prod_inven').on('typeahead:selected', function (e, datum,otro) {
	    jQuery('#producto').val(datum.id_descripcion);
	    jQuery('#codigo_original').val(datum.key)

	    jQuery('#oculto_producto').attr('color',datum.id_color );
	    jQuery('#oculto_producto').attr('composicion',datum.id_composicion );
	    jQuery('#oculto_producto').attr('calidad',datum.id_calidad );

	    //provocar el evento
	    jQuery('#oculto_producto').val('si');
	    jQuery('#producto').change();



	   	jQuery('#movimiento').val(datum.id_movimiento);
	   	jQuery('#proveedor').val(datum.proveedor);
	   	jQuery('#fecha').val(datum.fecha_entrada);
	   	jQuery('#factura').val(datum.factura);
	   	jQuery('#cantidad_um').val(datum.cantidad_um);
	   	jQuery('#id_medida').val(datum.id_medida);
	   	jQuery('#ancho').val(datum.ancho);
	   	jQuery('#precio').val(datum.precio);


	   	jQuery('#id_estatus').val(datum.id_estatus);
	   	jQuery('#id_lote').val(datum.id_lote);

	   	jQuery('#tabla_cambio').dataTable().fnDraw();
	    

	});	

	jQuery('.buscar_prod_inven').on('typeahead:closed', function (e) {
		//jQuery('#tabla_entrada').dataTable().fnDraw();
	});	




	/////////////////////////buscar proveedores

	// busqueda de proveedors
	var consulta_proveedor = new Bloodhound({
	   datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nombre'),
	   queryTokenizer: Bloodhound.tokenizers.whitespace,
	   remote:'catalogos/buscador?key=%QUERY&nombre='+jQuery('.buscar_proveedor').attr("name")+'&idproveedor='+jQuery('.buscar_proveedor').attr("idproveedor"),
	});

	consulta_proveedor.initialize();

	jQuery('.buscar_proveedor').typeahead(
		{
			  hint: true,
		  highlight: true,
		  minLength: 1
		},

		 {
	  
	  name: 'buscar_proveedor',
	  displayKey: 'descripcion', //
	  source: consulta_proveedor.ttAdapter(),
	   templates: {
	   			//header: '<h4>'+jQuery('.buscar_proveedor').attr("name")+'</h4>',
			    suggestion: function (data) {  
					return '<p><strong>' + data.descripcion + '</strong></p>'+
					 '<div style="background-color:'+ '#'+data.hexadecimal_color + ';display:block;width:15px;height:15px;margin:0 auto;"></div>';

		   }
	    
	  }
	});

	jQuery('.buscar_proveedor').on('typeahead:selected', function (e, datum,otro) {
	    key = datum.key;
	    jQuery('#tabla_entrada').dataTable().fnDraw();
	});	

	jQuery('.buscar_proveedor').on('typeahead:closed', function (e) {
		jQuery('#tabla_entrada').dataTable().fnDraw();
	});	


	/////////////////////////buscar Cargadores/////////////////

	// busqueda de proveedors
	var consulta_cargador = new Bloodhound({
	   datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nombre'),
	   queryTokenizer: Bloodhound.tokenizers.whitespace,
	   remote:'catalogos/buscador?key=%QUERY&nombre='+jQuery('.buscar_cargador').attr("name"),
	});

	consulta_cargador.initialize();
	jQuery('.buscar_cargador').typeahead(
		{
			  hint: true,
		  highlight: true,
		  minLength: 1
		},

		 {
	  
	  name: 'buscar_cargador',
	  displayKey: 'descripcion', //
	  source: consulta_cargador.ttAdapter(),
	   templates: {
	   			//header: '<h4>'+jQuery('.buscar_cargador').attr("name")+'</h4>',
			    suggestion: function (data) {  
					return '<p><strong>' + data.descripcion + '</strong></p>'+
					 '<div style="background-color:'+ '#'+data.hexadecimal_color + ';display:block;width:15px;height:15px;margin:0 auto;"></div>';

		   }
	    
	  }
	  
	});



	jQuery('.buscar_proveedor').on('typeahead:selected', function (e, datum,otro) {
	    key = datum.key;
	});	


	jQuery('.buscar_proveedor').on('typeahead:closed', function (e) {

	});		
/////////////////////////////////////////////////////////////////////////////////////////////////////

// busqueda de colores  http://jsfiddle.net/Fresh/kLLCy/
//var p = jQuery('.buscar_proveedor').typeahead('val');
//var p = jQuery('.buscar_proveedor option:selected').val();
var consulta_producto = new Bloodhound({
   datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nombre'),
   queryTokenizer: Bloodhound.tokenizers.whitespace,
   //remote:'catalogos/buscador?key=%QUERY&nombre='+jQuery('.buscar_producto').attr("name")+'&dependiente=', //typeahead('val')
   
   remote: {
        url: 'catalogos/buscador?key=%QUERY',
        replace: function () {
            var q = 'catalogos/buscador?key='+encodeURIComponent(jQuery('.buscar_producto').typeahead("val"));
				q += '&nombre='+encodeURIComponent(jQuery('.buscar_producto.tt-input').attr("name"));
			    q += '&dependiente='+encodeURIComponent(jQuery('.buscar_proveedor').typeahead("val"));
            
            return  q;
        }
    },   
   
});

//finalmente el celular, esta bloqueado, al parecer cuando se debio poner la contraseña, el intento fue fallido varias veces, y ahora pide el PIN, le puse el pin y el PUK, pero no pude desbloquearlo

consulta_producto.initialize();
jQuery('.buscar_producto').typeahead(
	{
	  hint: true,
	  highlight: true,
	  minLength: 1
	},

	 {
  
  name: 'buscar_producto', //nombre del conjunto de datos. Esto se añadirá a tt-dataset- 
						//para formar el nombre de la clase del elemento DOM que contiene
  displayKey: 'descripcion', //// if not set, will default to 'value',
  
  
  source: consulta_producto.ttAdapter(),
   templates: {
   			//header: '<h4>'+jQuery('.buscar_producto').attr("name")+'</h4>',
	   suggestion: function (data) {  
			return '<p><strong>' + data.descripcion + '</strong></p>'+
			 '<div style="background-producto:'+ '#'+data.hexadecimal_producto + ';display:block;width:15px;height:15px;margin:0 auto;"></div>';

	   }
    
  }
  
  
});
////////////////////************



	var opts = {
		lines: 13, 
		length: 20, 
		width: 10, 
		radius: 30, 
		corners: 1, 
		rotate: 0, 
		direction: 1, 
		color: '#E8192C',
		speed: 1, 
		trail: 60,
		shadow: false,
		hwaccel: false,
		className: 'spinner',
		zIndex: 2e9, 
		top: '50%', // Top position relative to parent
		left: '50%' // Left position relative to parent		
	};

	jQuery(".navigacion").change(function()
	{
	    document.location.href = jQuery(this).val();
	});




   

	var target = document.getElementById('foo');

	//tratamiento de fechas
	var fecha_actual = new Date();
	
	var fecha_anterior = new Date( fecha_actual.getTime() - (30 * 24 * 3600 * 1000));

	var dd = fecha_actual.getDate();
	var dd_anterior = fecha_anterior.getDate();

	var mm = fecha_actual.getMonth()+1;
	var mm_anterior = fecha_anterior.getMonth()+1;
	if(dd<10) {
    	dd='0'+dd;
	} 
	if(dd_anterior<10) {
    	dd_anterior='0'+dd_anterior;
	} 

	if(mm<10) {
	    mm='0'+mm;
	} 

	if(mm_anterior<10) {
	    mm_anterior='0'+mm_anterior;
	} 


	//var fecha_actual = new Date('December 25, 2005 23:15:00');
	var yyyy = fecha_actual.getFullYear();
	var yyyy_anterior = fecha_anterior.getFullYear();
	
	var fecha_formateada = dd+mm+yyyy;		

	var fecha_ayer = yyyy_anterior+'/'+mm_anterior+'/'+dd_anterior;
	var fecha_hoy = dd+'/'+mm+'/'+yyyy;	

	var fecha_hoy_uno = dd+'/'+mm+'/'+yyyy;	


 	jQuery('.fecha').datepicker({ format: 'dd-mm-yyyy'});

								



////////////////////////////Para los botones de agregar catalogo Modales///////////////////////////////


//gestion de usuarios (crear, editar y eliminar )
	jQuery("#form_modales").submit(function(e){
		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);
		jQuery(this).ajaxSubmit({
			dataType : 'json',
			success: function(data){
				
				if(data.estado.exito != true){
					spinner.stop();
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','block');
					jQuery('#messages').addClass('alert-danger');
					jQuery('#messages').html(data.fallo.mensaje);
					jQuery('html,body').animate({
						'scrollTop': jQuery('#messages').offset().top
					}, 1000);
				

				}else{
					e.preventDefault();

					if (data.catalogo != "[]") {
						jQuery("#"+data.dato.identificador).html('');
	                   //jQuery("#"+data.dato.identificador).append('<option value="-1" selected >Seleccione un elemento</option>');
                        jQuery.each(data.catalogo, function (i, valor) {
                            if (valor.nombre !== null) {
                            	 if (valor.nombre == data.dato.valor) {
                            	 	jQuery("#"+data.dato.identificador).append('<option value="' + valor.identificador + '" selected >' + valor.nombre + '</option>');     
                            	 } else {
                                 	jQuery("#"+data.dato.identificador).append('<option value="' + valor.identificador + '">' + valor.nombre + '</option>');     
                                 }
                            }
                        });
	                }					 
					 spinner.stop();
					 jQuery('#foo').css('display','none');
					 $("#modalMessage").modal('hide');
					 return false;



					/*
									   			"estado" => array('exito' => true),
											    "dato"  => array('valor'=> $data[$catal], 'catalogo' => $catal, 'identificador' =>  $identificador),
											    "catalogo"   => $variables

					*/

					 
				}
			} 
		});
		return false;
	});		

////////////////////////////fin de boton modal para catalogos////////////////////////////////////////////////


//////////////////////tratamiento catalogo colores////////////////////////////////////
/*
 jQuery('#addcolor_form').submit(function(){
    jQuery('#foo').css('display','block');
    var spinner = new Spinner(opts).spin(target);
    jQuery(this).ajaxSubmit({
      success: function(data){
        if(data != true){
          jQuery('#messages').html(data);
          jQuery('#messages').hide().slideDown("slow");
          jQuery("#messages").delay(2500).slideUp(800, function(){
            spinner.stop();
            jQuery('#foo').css('display','none');
            jQuery("#messages").html("");
          });
        }else{
          data = "<span class='success'>El color se ha editado satisfactoriamente.</span>";
          jQuery('#messages').css({'background-color':'#83bc37'});
          jQuery('#messages').html(data);
          jQuery('#messages').hide().slideDown("slow");
          jQuery("#messages").delay(2500).slideUp(800, function(){
            spinner.stop();
            jQuery('#foo').css('display','none');
            jQuery("#messages").html("");
            window.location.reload();
          });
        }
      }
    });
    return false;
  });
*/

/*
  jQuery('#agregar_color').click(function(){
    jQuery('#lista_colores option:selected').appendTo(jQuery('#colores_seleccionados'));
    return false;
  });

  jQuery('#quitar_color').click(function(){
    jQuery('#colores_seleccionados option:selected').appendTo(jQuery('#lista_colores'));
    return false;
  });
  */


  jQuery('#hexadecimal_color').ColorPicker({
    color: '#ffffff',
    onShow: function(colpkr){
    	//alert('sadsa');
      jQuery(colpkr).fadeIn(500);
      return false;
    },
    onHide: function(colpkr){
      jQuery(colpkr).fadeOut(500);
      return false;
    },
    onChange: function(hsb, hex, rgb){
      jQuery('#hexadecimal_color').val(hex);
      jQuery('#hexadecimal_color').css('backgroundColor', '#' + hex);
    }
  });
  

//////////////////////fin tratamiento catalogo colores////////////////////////////////////


	//gestion de usuarios (crear, editar y eliminar )
	jQuery("#form_usuarios").submit(function(e){
		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);
		jQuery(this).ajaxSubmit({
			success: function(data){
				if(data != true){
					
					spinner.stop();
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','block');
					jQuery('#messages').addClass('alert-danger');
					jQuery('#messages').html(data);
					jQuery('html,body').animate({
						'scrollTop': jQuery('#messages').offset().top
					}, 1000);
				

				}else{

						spinner.stop();
						jQuery('#foo').css('display','none');
						window.location.href = '/usuarios';						
				}
			} 
		});
		return false;
	});	


	//gestion de usuarios (crear, editar y eliminar )
	jQuery("#form_respaldo").submit(function(e){
		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);
		jQuery(this).ajaxSubmit({
			success: function(data){
				if(data != true){
					
					spinner.stop();
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','block');
					jQuery('#messages').addClass('alert-danger');
					jQuery('#messages').html(data);
					jQuery('html,body').animate({
						'scrollTop': jQuery('#messages').offset().top
					}, 1000);
				

				}else{

						spinner.stop();
						jQuery('#foo').css('display','none');
						window.location.href = '/usuarios';						
				}
			} 
		});
		return false;
	});




//gestion de usuarios (crear, editar y eliminar )
	jQuery("#form_mantenimiento").submit(function(e){
		jQuery('#foo').css('display','block');
		var spinner = new Spinner(opts).spin(target);
		jQuery(this).ajaxSubmit({
			dataType : 'json',
			success: function(data){
				
				if(data.estado.exito != true){
					
					spinner.stop();
					jQuery('#foo').css('display','none');
					jQuery('#messages').css('display','block');
					jQuery('#messages').addClass('alert-danger');
					jQuery('#messages').html(data.fallo.mensaje);
					jQuery('html,body').animate({
						'scrollTop': jQuery('#messages').offset().top
					}, 1000);
				}else{
					e.preventDefault();
					 
					 spinner.stop();
					 jQuery('#foo').css('display','none');
					 $("#modalMessage35").modal('hide');

					 window.location.href = '/'+data.dato.valor+'#mante';	
					 window.location.reload();
					 return false;
					 
				}
			} 
		});
		return false;
	});		





    //Filtro La lista de colaboradores que es dependiente de categorias 
    jQuery( ".dependiente" ).change(function(e) {
        var valor_padre = jQuery(this).val();  
        var depende = e.target.name;
         switch(depende) {
		    case "id_marca":
		         var  elem_hijo=  "#id_linea";
		        break;
		    /*case "id_linea":
		        var  elem_hijo=  "#id_sublinea";
		        break;*/
		    default:
		        
		}
        jQuery(elem_hijo).html('');
        cargardependientes(valor_padre,elem_hijo);
     });



	function cargardependientes(valor_padre,elem_hijo) {

		var url = '/unidades/cargar_elemhijo';	
		//alert(elem_hijo);

		jQuery.ajax({
		        url : url+'/'+valor_padre+'/'+(elem_hijo.substring(1)),
		        type : 'GET',
		        dataType : 'json',
		        success : function(data) {
					if (data != "[]") {
                        jQuery(elem_hijo).append('<option value="-1" selected >Seleccione un elemento</option>');
                        jQuery.each(data, function (i, valor) {
                            if (valor.nombre !== null) {
                                 jQuery(elem_hijo).append('<option value="' + valor.identificador + '">' + valor.nombre + '</option>');     
                            }
                        });
	                }
                    return false;
		        },
		        error : function(jqXHR, status, error) {
		        },
		        complete : function(jqXHR, status) {
		            
		        }
		    }); 
	}

    if($(".ttip").length > 0){
        $(".ttip").tooltip();
    }


    if($("#movimiento").length > 0){
        $("#movimiento").tooltip();
    }
});

jQuery(document).ready(function($) {

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

$('.datepicker').datepicker({
    format: 'mm/dd/yyyy',
    startDate: '-3d'
})

  ////////////////////////////catalogos////////////////////////////////////////////////

	$('#modalMessage').on('hide.bs.modal', function(e) {
	    $(this).removeData('bs.modal');
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

////////////////////////////ordenar////////////////////////////////////////////////

	jQuery(".tabla_ordenadas").tablesorter(); 
	jQuery("#tablahome1").tablesorter(); 
	jQuery("#tablahome2").tablesorter(); 
	jQuery("#tablahome3").tablesorter(); 




	/////////////////////////buscar proveedores



	// busqueda de proveedors
	var consulta_proveedor = new Bloodhound({
	   datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nombre'),
	   queryTokenizer: Bloodhound.tokenizers.whitespace,
	   remote:'catalogos/buscador?key=%QUERY&nombre='+jQuery('.buscar_proveedor').attr("name"),
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
	   			header: '<h4>'+jQuery('.buscar_proveedor').attr("name")+'</h4>',
			    suggestion: function (data) {  
					return '<p><strong>' + data.descripcion + '</strong></p>'+
					 '<div style="background-color:'+ '#'+data.hexadecimal_color + ';display:block;width:15px;height:15px;margin:0 auto;"></div>';

		   }
	    
	  }
	  
	});







		function viewmodel() {
				this.phones = ko.observableArray([]);
				this.loading = ko.observable(false);
			}

			var 
				example2 = new viewmodel();				
				ko.applyBindings(example2, document.getElementById('example2'));
	
			// Example 2
			jQuery('#example2').cascadingDropdown({
				selectBoxes: [
					{
						selector: '.producto',
						source: function(request, response) {
							jQuery.getJSON('catalogos/busqueda?elemento=producto', request, function(data) {
								var selectOnlyOption = data.length <= 1;
								response(jQuery.map(data, function(item, index) {
									return {
										label: item.descripcion,
										value: item.descripcion,
										selected: selectOnlyOption
									};
								}));
								
							});
						}
					},
					{
						selector: '.color',
						requires: ['.producto'],
						source: function(request, response) {
							jQuery.getJSON('catalogos/busqueda?elemento=color', request, function(data) {
								var selectOnlyOption = data.length <= 1;
								response(jQuery.map(data, function(item, index) {
									
									return {
										label: item.color,
										value: item.id_color,
										selected: index == 0
										//selected: selectOnlyOption
									};
								}));
							});
							
						}
					},
					{
						selector: '.composicion',
						requires: ['.producto', '.color'],
						requireAll: true,
						source: function(request, response) {
							jQuery.getJSON('catalogos/busqueda?elemento=composicion', request, function(data) {
								response(jQuery.map(data, function(item, index) {
									return {
										label: item.composicion,
										value: item.id_composicion,
										selected: index == 0
										//selected: selectOnlyOption
										
									};
								}));
							});
						},
					},
					{	
						
						selector: '.calidad',
						requires: ['.producto', '.color', '.composicion'],
						requireAll: true,
						source: function(request, response) {
							jQuery.getJSON('catalogos/busqueda?elemento=calidad', request, function(data) {
								response(jQuery.map(data, function(item, index) {
									return {
										label: item.calidad,
										value: item.id_calidad,
										//selected: selectOnlyOption
										selected: index == 0
									};
								}));
							});
						},
						
						
						onChange: function(event, value, requiredValues, requirementsMet) {
							if(!requirementsMet) return;

							example2.loading(true);

							var ajaxData = requiredValues;
							
							ajaxData[this.el.attr('name')] = value;
							//console.log(ajaxData);
							jQuery.getJSON('catalogos/busqueda?elemento=completo', ajaxData, function(data) {
								//example2.phones(data);

								jQuery('#codigo').attr('value',data[0].referencia+' -----'+jQuery('.buscar_proveedor').val());
								console.log(data[0].referencia);	
								//console.log(data.id);	
								//console.log(data.referencia);	



								example2.loading(false);
								
							});
						}
						
					}
				]
			});
			














//busqueda nueva
/*
var mio1 = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nombre'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  //prefetch: 'datos/hijos.json',
  remote:'catalogos/buscador?key=%QUERY&nombre='+jQuery('.busqueda_propia').attr("name"),
  //remote: 'datos/hijos/%QUERY.json'
});
mio1.initialize();


 {
  name: 'ddd', //- El nombre del conjunto de datos. Esto se añadirá a tt-dataset- para formar el nombre de la clase del elemento DOM que contiene. 
  				//. Por defecto es un número aleatorio.		
  displayKey: 'descripcion', //'id'  //Lo que se quiere mostrar en el input. dado el resultado. El valor predeterminado es el value 
  source: consulta.ttAdapter(),
   templates: {
	      header: '<h4>Descripción</h4>',
          
   
	   suggestion: function (data) {   //https://github.com/twitter/typeahead.js/issues/1031 personalizando sin Handlebars
			//return '<p><strong>' + data.referencia + '</strong> - ' + data.descripcion + '</p>';
			
			return '<div style="background-color:'+ '#'+data.hexadecimal_color + ';display:block;width:15px;height:15px;margin:0 auto;"></div>';
			//return '<p><strong>' + '#'+data.hexadecimal_color + '</strong></p>';


	   }
    
  },  
}

 //https://github.com/twitter/typeahead.js/issues/1031 personalizando sin Handlebars
//http://jsfiddle.net/Fresh/kLLCy/

//name: jQuery('.busqueda_propia').attr("name"),

  			 //- El nombre del conjunto de datos. Esto se añadirá a tt-dataset- para formar el nombre de la clase del elemento DOM que contiene. 
  				//. Por defecto es un número aleatorio.		
  displayKey: 'descripcion', //'id'  //Lo que se quiere mostrar en el input. dado el resultado. El valor predeterminado es el value 


*/




// busqueda de colores  http://jsfiddle.net/Fresh/kLLCy/
var consulta_color = new Bloodhound({
   datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nombre'),
   queryTokenizer: Bloodhound.tokenizers.whitespace,
   remote:'catalogos/buscador?key=%QUERY&nombre='+jQuery('.buscar_color').attr("name")+'&dependiente='+jQuery('#producto1').text,
});

consulta_color.initialize();
jQuery('.buscar_color').typeahead(
	{
	  hint: true,
	  highlight: true,
	  minLength: 1
	},

	 {
  
  name: 'buscar_color',
  displayKey: 'descripcion', //
  source: consulta_color.ttAdapter(),
   templates: {
   			header: '<h4>'+jQuery('.buscar_color').attr("name")+'</h4>',
	   suggestion: function (data) {  
			return '<p><strong>' + data.descripcion + '</strong></p>'+
			 '<div style="background-color:'+ '#'+data.hexadecimal_color + ';display:block;width:15px;height:15px;margin:0 auto;"></div>';

	   }
    
  }
  
});





////////////////////////////Buscar////////////////////////////////////////////////
jQuery('.buscar_codigo').typeahead(
    {
	        name: jQuery('.buscar_codigo').attr("name"),
	        displayKey: 'team',
	        remote:'catalogos/buscador?key=%QUERY&nombre='+jQuery('.buscar_codigo').attr("name"),
	        limit : 3, // items
	},
	{
	        name: jQuery('.buscar_codigo').attr("name"),
	        displayKey: 'team',
	        remote:'catalogos/buscador?key=%QUERY&nombre='+jQuery('.buscar_codigo').attr("name"),
	        limit : 3, // items
	}
);

	jQuery('.buscar_codigo').on('typeahead:selected', function (e, datum,otro) {
		$ir=e.currentTarget.name;
		$id=e.currentTarget.id;
	    elemento = datum.value;
	    key = datum.key;
	    descripcion = datum.descripcion;
 		 jQuery("#"+$id).val(key);  //datum["value"]
 		 jQuery("#desc_"+$id).text(descripcion);  //datum["value"]

	});

	jQuery('.buscar_codigo').on('typeahead:cursorchanged', function (e, datum) {
	    console.log(datum);
	});


////////////////////////////Buscar////////////////////////////////////////////////
jQuery('.buscar_palabra').typeahead( 
	{
	        name: jQuery('.buscar_palabra').attr("name"),
	        remote:'catalogos/buscador?key=%QUERY&nombre='+jQuery('.buscar_palabra').attr("name"),
	        //name: jQuery('.buscar_palabra').typeahead('name'),
	        //remote:'catalogos/buscador?key=%QUERY&nombre='+jQuery(this).attr("name"),

	        limit : 3, // items
	}
);

	jQuery('.buscar_palabra').on('typeahead:selected', function (e, datum,otro) {
		$ir=e.currentTarget.name;
	    elemento = datum.value;
	    key = datum.key;
	    //console.log(this.name);
	    document.location.href = $ir+'/'+key;
	});

	jQuery('.buscar_palabra').on('typeahead:cursorchanged', function (e, datum) {
	    console.log(datum);
	});


////////////////////////////Escaneo de codigos QR////////////////////////////////////////////////
/*
    jQuery('#reader').html5_qrcode(function(data){
        //  Hacer algo cuando se lee el código (do something when code is read)
            alert(data);
            jQuery('#read').html(data);
        },
        function(error){
            //Mostrar errores de lectura 
           // jQuery('#read_error').html(error);
        }, function(videoError){
            // El flujo de vídeo se ha podido abrir (the video stream could be opened)
            //jQuery('#vid_error').html(videoError);
        }
    );
 */	

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

	var yyyy = fecha_actual.getFullYear();
	var yyyy_anterior = fecha_anterior.getFullYear();

	var fecha_ayer = yyyy_anterior+'/'+mm_anterior+'/'+dd_anterior;
	var fecha_hoy = yyyy+'/'+mm+'/'+dd;	

	var fecha_hoy_uno = dd+'/'+mm+'/'+yyyy;	


 	jQuery('.fecha').datepicker({ format: 'dd-mm-yyyy'});
	

//fecha
              jQuery('.reservation').daterangepicker(
              	  { 
				    locale: { cancelLabel: 'Cancelar',
				    		  applyLabel: 'Aceptar',
				    		  fromLabel : 'Desde',
				    		  toLabel: 'Hasta',
				    		  monthNames : "ene._feb._mar_abr._may_jun_jul._ago_sep._oct._nov._dec.".split("_"),
				    		  daysOfWeek: "Do_Lu_Ma_Mi_Ju_Vi_Sa".split("_"),
				     } , 
				    format: 'YYYY/MM/DD',
				    startDate: fecha_ayer, //'2014/09/01',
				    endDate: fecha_hoy //'2014/12/31'

				  }

              );

	 //Exportar
    jQuery( ".exportar" ).click(function(e) {

    	//console.log(e.currentTarget.name);
    	$nombre = e.currentTarget.name;

    	//alert($nombre);
        var fecha = (jQuery(".reservation[name='"+$nombre+"']").val()).split(" - ");
        if (fecha!='') {
			var fecha_inicial = fecha[0];
			var fecha_final = fecha[1];
			var fecha_inicial1 = fecha_inicial.replace(/\//gi, '-');
			var fecha_final1 = fecha_final.replace(/\//gi, '-');
			//alert(fecha_inicial1+'/'+fecha_final1);
			window.location.href = '/exportar/exporto/'+$nombre+'/'+fecha_inicial1+'/'+fecha_final1;
			//window.location.href = '/sistema/exportar/exporto/'+la_categoria+'/'+el_colaborador+'/'+el_estatus+'/'+fecha_inicial1+'/'+fecha_final1;
		}     
     });


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



});
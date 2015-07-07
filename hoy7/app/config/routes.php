<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller']	 		= 'Main';
$route['404_override'] 					= '';


$route['login']							= 'main/login';
$route['forgot']						= 'main/forgot';
$route['session']						= 'main/session';



///////////////////////////////catalogos///////////////////////////////////////
$route['respaldar']					= 'respaldo/respaldar';
//catalogos modales
$route['catalogo_modal/(:any)/(:any)']					    = 'catalogos/catalogo_modal/$1/$2';
$route['validar_catalogo_modal']    						= 'catalogos/validar_catalogo_modal';
//listado de reportes
$route['reportes']						= 'nucleo/listado_reportes';

//Listado de todos los catalogos
$route['catalogos']						= 'catalogos/listado_catalogos';



/*

composicion

unidades_medidas
colores

operaciones

proveedores
productos

*/

//proveedores
$route['proveedores']					     = 'catalogos/listado_proveedores';

$route['nuevo_proveedor']                  = 'catalogos/nuevo_proveedor';
$route['validar_nuevo_proveedor']          = 'catalogos/validar_nuevo_proveedor';

$route['editar_proveedor/(:any)']      = 'catalogos/editar_proveedor/$1';
$route['validacion_edicion_proveedor']     = 'catalogos/validacion_edicion_proveedor';

$route['eliminar_proveedor/(:any)/(:any)'] = 'catalogos/eliminar_proveedor/$1/$2';
$route['validar_eliminar_proveedor']       = 'catalogos/validar_eliminar_proveedor';




//actividad_comercial
$route['actividades_comerciales']					     = 'catalogos/listado_actividad_comercial';

$route['nuevo_actividad_comercial']                  = 'catalogos/nuevo_actividad_comercial';
$route['validar_nuevo_actividad_comercial']          = 'catalogos/validar_nuevo_actividad_comercial';

$route['editar_actividad_comercial/(:any)']			 = 'catalogos/editar_actividad_comercial/$1';
$route['validacion_edicion_actividad_comercial']     = 'catalogos/validacion_edicion_actividad_comercial';

$route['eliminar_actividad_comercial/(:any)/(:any)'] = 'catalogos/eliminar_actividad_comercial/$1/$2';
$route['validar_eliminar_actividad_comercial']    	 = 'catalogos/validar_eliminar_actividad_comercial';



//unidades_medidas Ok
$route['unidades_medidas']					     = 'catalogos/listado_unidades_medidas';

$route['nuevo_unidad_medida']                  = 'catalogos/nuevo_unidad_medida';
$route['validar_nuevo_unidad_medida']          = 'catalogos/validar_nuevo_unidad_medida';

$route['editar_unidad_medida/(:any)']			 = 'catalogos/editar_unidad_medida/$1';
$route['validacion_edicion_unidad_medida']     = 'catalogos/validacion_edicion_unidad_medida';

$route['eliminar_unidad_medida/(:any)/(:any)'] = 'catalogos/eliminar_unidad_medida/$1/$2';
$route['validar_eliminar_unidad_medida']    	 = 'catalogos/validar_eliminar_unidad_medida';

//color
$route['colores']					     = 'catalogos/listado_colores';

$route['nuevo_color']                  = 'catalogos/nuevo_color';
$route['validar_nuevo_color']          = 'catalogos/validar_nuevo_color';

$route['editar_color/(:any)']			 = 'catalogos/editar_color/$1';
$route['validacion_edicion_color']     = 'catalogos/validacion_edicion_color';

$route['eliminar_color/(:any)/(:any)/(:any)'] = 'catalogos/eliminar_color/$1/$2/$3';
$route['validar_eliminar_color']    	 = 'catalogos/validar_eliminar_color';

//calidad
$route['calidades']              = 'catalogos/listado_calidades';

$route['nuevo_calidad']                  = 'catalogos/nuevo_calidad';
$route['validar_nuevo_calidad']          = 'catalogos/validar_nuevo_calidad';

$route['editar_calidad/(:any)']      = 'catalogos/editar_calidad/$1';
$route['validacion_edicion_calidad']     = 'catalogos/validacion_edicion_calidad';

$route['eliminar_calidad/(:any)/(:any)'] = 'catalogos/eliminar_calidad/$1/$2';
$route['validar_eliminar_calidad']       = 'catalogos/validar_eliminar_calidad';

//composicion
$route['composiciones']					     = 'catalogos/listado_composiciones';

$route['nuevo_composicion']                  = 'catalogos/nuevo_composicion';
$route['validar_nuevo_composicion']          = 'catalogos/validar_nuevo_composicion';

$route['editar_composicion/(:any)']			 = 'catalogos/editar_composicion/$1';
$route['validacion_edicion_composicion']     = 'catalogos/validacion_edicion_composicion';

$route['eliminar_composicion/(:any)/(:any)'] = 'catalogos/eliminar_composicion/$1/$2';
$route['validar_eliminar_composicion']    	 = 'catalogos/validar_eliminar_composicion';

//ancho de tela
$route['anchos']					     = 'catalogos/listado_anchos';

$route['nuevo_ancho']                  = 'catalogos/nuevo_ancho';
$route['validar_nuevo_ancho']          = 'catalogos/validar_nuevo_ancho';

$route['editar_ancho/(:any)']			 = 'catalogos/editar_ancho/$1';
$route['validacion_edicion_ancho']     = 'catalogos/validacion_edicion_ancho';

$route['eliminar_ancho/(:any)/(:any)'] = 'catalogos/eliminar_ancho/$1/$2';
$route['validar_eliminar_ancho']    	 = 'catalogos/validar_eliminar_ancho';

//cargador
$route['cargadores']					     = 'catalogos/listado_cargadores';

$route['nuevo_cargador']                  = 'catalogos/nuevo_cargador';
$route['validar_nuevo_cargador']          = 'catalogos/validar_nuevo_cargador';

$route['editar_cargador/(:any)']			 = 'catalogos/editar_cargador/$1';
$route['validacion_edicion_cargador']     = 'catalogos/validacion_edicion_cargador';

$route['eliminar_cargador/(:any)/(:any)'] = 'catalogos/eliminar_cargador/$1/$2';
$route['validar_eliminar_cargador']    	 = 'catalogos/validar_eliminar_cargador';

//operaciones
$route['operaciones']					     = 'catalogos/listado_operaciones';

$route['nuevo_operacion']                  = 'catalogos/nuevo_operacion';
$route['validar_nuevo_operacion']          = 'catalogos/validar_nuevo_operacion';

$route['editar_operacion/(:any)']			 = 'catalogos/editar_operacion/$1';
$route['validacion_edicion_operacion']     = 'catalogos/validacion_edicion_operacion';

$route['eliminar_operacion/(:any)/(:any)'] = 'catalogos/eliminar_operacion/$1/$2';
$route['validar_eliminar_operacion']    	 = 'catalogos/validar_eliminar_operacion';



//productos
$route['productos']					       = 'catalogos/listado_productos';

$route['nuevo_producto']                  = 'catalogos/nuevo_producto';
$route['validar_nuevo_producto']          = 'catalogos/validar_nuevo_producto';

$route['editar_producto/(:any)']          = 'catalogos/editar_producto/$1';
$route['cambiar_producto/(:any)']          = 'catalogos/cambiar_producto/$1';

$route['validacion_edicion_producto']     = 'catalogos/validacion_edicion_producto';
$route['validacion_cambio_producto']     = 'catalogos/validacion_cambio_producto';

$route['eliminar_producto/(:any)/(:any)'] = 'catalogos/eliminar_producto/$1/$2';
$route['validar_eliminar_producto']       = 'catalogos/validar_eliminar_producto';


//catalogos modales
$route['catalogo_modal/(:any)/(:any)']					    = 'catalogos/catalogo_modal/$1/$2';
$route['validar_catalogo_modal']    						= 'catalogos/validar_catalogo_modal';



///////////////////////////////usuarios///////////////////////////////////////


$route['detalle_historico/(:any)/(:any)/(:any)/(:any)']    = 'unidades/detalle_historico/$1/$2/$3/$4';

$route['historicoaccesos']                 = 'main/historicoaccesos';

$route['usuarios']						= 'main/listado_usuarios';

$route['nuevo_usuario']                 = 'main/nuevo_usuario';
$route['validar_nuevo_usuario']         = 'main/validar_nuevo_usuario';

$route['eliminar_usuario/(:any)/(:any)']		= 'main/eliminar_usuario/$1/$2';
$route['validando_eliminar_usuario']    = 'main/validar_eliminar_usuario';

$route['actualizar_perfil']		         = 'main/actualizar_perfil';
$route['editar_usuario/(:any)']			= 'main/actualizar_perfil/$1';
$route['validacion_edicion_usuario']    = 'main/validacion_edicion_usuario';

$route['salir']							= 'main/logout';
$route['validar_login']					= 'main/validar_login';
$route['validar_recuperar_password']	= 'main/validar_recuperar_password';


/////////////////////////////////////////////Listado de todas las salidas
$route['salidas']						= 'salidas/listado_salidas';
//ventas, ofertas, transferencia_enviada, devolucion_compra, ajuste_negativo

/////////////////////////////////////////////Listado de todas las entradas
$route['entradas']						= 'entradas/listado_entradas';
//recepcion, devolucion_venta, transferencia_salida, ajuste_positivo

//operaciones de entradas

$route['validar_agregar_producto']          = 'entradas/validar_agregar_producto';
$route['listado_temporal']          = 'entradas/listado_temporal';


$route['recepciones']					     = 'entradas/listado_recepciones';
$route['nuevo_recepcion']                  = 'entradas/nuevo_recepcion';
$route['editar_recepcion/(:any)']      = 'entradas/editar_recepcion/$1';
$route['validacion_edicion_recepcion']     = 'entradas/validacion_edicion_recepcion';


$route['procesando_productos_temporales']    		= 'entradas/procesando_productos_temporales';

$route['eliminar_prod_temporal/(:any)/(:any)']       = 'entradas/eliminar_prod_temporal/$1/$2';
$route['validar_eliminar_prod_temporal']    = 'entradas/validar_eliminar_prod_temporal';
$route['inf_ajax_temporal']    = 'entradas/inf_ajax_temporal';

//procesamiento de entrada
$route['procesar_entradas/(:any)/(:any)']    = 'entradas/procesar_entradas/$1/$2';


$route['generar_etiquetas/(:any)/(:any)']    = 'pdfs/generar_etiquetas/$1/$2';
$route['generar_notas/(:any)/(:any)']    = 'pdfs/generar_notas/$1/$2';

$route['pdfs']    = 'pdfs/index';



///////////////////salidas///////////////////////
$route['procesando_servidor']    		= 'salidas/procesando_servidor';
$route['agregar_prod_salida']    		= 'salidas/agregar_prod_salida';

$route['procesando_servidor_salida']    = 'salidas/procesando_servidor_salida';
$route['quitar_prod_salida']		    = 'salidas/quitar_prod_salida';

$route['generar_salida/(:any)']    = 'pdfs/generar_salida/$1';



$route['detalle_salidas/(:any)/(:any)/(:any)']    = 'salidas/detalle_salidas/$1/$2/$3';
$route['procesar_salidas']    = 'salidas/procesar_salidas';

$route['confirmar_salida_sino']    = 'salidas/confirmar_salida_sino';
$route['validar_confirmar_salida_sino']    = 'salidas/validar_confirmar_salida_sino';


/////////////////////////////////////////HOME///////////////////
$route['procesando_home']    		= 'main/procesando_home';
$route['procesando_inicio']    		= 'main/procesando_inicio';

$route['detalles_producto/(:any)']   = 'main/detalles_producto/$1';





$route['marcando_apartado']    		= 'main/marcando_apartado';

$route['procesar_apartados']    		= 'main/procesar_apartados';

$route['apartado_definitivo']    		= 'main/apartado_definitivo';




/////////////////////////////////////////////Listado de todos los pedidos
// conteo con notificacion push
$route['conteo_tienda']   			= 'pedidos/conteo_tienda';
////

$route['pedidos']						= 'pedidos/listado_apartados';

$route['apartado_detalle/(:any)/(:any)'] = 'pedidos/apartado_detalle/$1/$2';
$route['pedido_detalle/(:any)']    			= 'pedidos/pedido_detalle/$1';
$route['pedido_completado_detalle/(:any)/(:any)']    			= 'pedidos/pedido_completado_detalle/$1/$2';


$route['eliminar_apartado_detalle/(:any)/(:any)']    	= 'pedidos/eliminar_apartado_detalle/$1/$2';
$route['validar_eliminar_apartado_detalle']    			= 'pedidos/validar_eliminar_apartado_detalle';


$route['eliminar_pedido_detalle/(:any)']    			= 'pedidos/eliminar_pedido_detalle/$1';
$route['validar_eliminar_pedido_detalle']    			= 'pedidos/validar_eliminar_pedido_detalle';

////////

$route['procesando_pedido_pendiente']       = 'pedidos/procesando_pedido_pendiente';
$route['generar_pedidos']						= 'pedidos/listado_pedidos';
$route['pedido_definitivo']						= 'pedidos/pedido_definitivo';
$route['procesando_pedido_detalle']    			= 'pedidos/procesando_pedido_detalle';
$route['incluir_pedido']    			= 'pedidos/incluir_pedido';
$route['excluir_pedido']    			= 'pedidos/excluir_pedido';
$route['incluir_apartado']    			= 'pedidos/incluir_apartado';
$route['excluir_apartado']    			= 'pedidos/excluir_apartado';
$route['procesando_apartado_pendiente'] = 'pedidos/procesando_apartado_pendiente';
$route['procesando_detalle'] = 'pedidos/procesando_detalle';

$route['id_proveedor']    			= 'salidas/id_proveedor';
$route['refe_producto']    			= 'salidas/refe_producto';



/////////////////////////////////////////////Listado de todos los pedidos completados
$route['procesando_pedido_completo']       = 'pedidos/procesando_pedido_completo';


$route['procesando_completo_detalle']    			= 'pedidos/procesando_completo_detalle';



///////////////////Pedidos salidas///////////////////////
///nose

//$route['pedidodetalle']					= 'pedidos/detalle_pedidos';
//$route['pedidocompleto']				= 'pedidos/detalle_completo';


$route['procesando_pedido_entrada']    		= 'pedidos/procesando_pedido_entrada';

$route['procesando_pedido_salida']    		= 'pedidos/procesando_pedido_salida';

$route['agregar_prod_pedido']    				= 'pedidos/agregar_prod_pedido';
$route['quitar_prod_pedido']		    		= 'pedidos/quitar_prod_pedido';

$route['marcando_prorroga_venta']    			= 'pedidos/marcando_prorroga_venta';
$route['marcando_prorroga_tienda']    			= 'pedidos/marcando_prorroga_tienda';


$route['generar_pedido_especifico/(:any)/(:any)/(:any)']    = 'pdfs/generar_pedido_especifico/$1/$2/$3';


//////////****************Aqui para las impresiones**************////////////////////

$route['pdf_pedido/(:any)']    		= 'pdfs/pdf_pedido/$1';
$route['pdf_apartado/(:any)']   	= 'pdfs/pdf_apartado/$1';
$route['pdf_historico/(:any)']    	= 'pdfs/pdf_historico/$1';


$route['pro_salida/(:any)/(:any)']    			= 'salidas/pro_salida/$1/$2';

///////////////////////////////////DEVOLUCIONES//////////////////////////////////////////////

$route['devolucion']										= 'devoluciones/devolucion';
$route['validar_devolucion_producto']						= 'devoluciones/validar_devolucion_producto';

$route['quitar_devolucion/(:any)/(:any)']					= 'devoluciones/quitar_devolucion/$1/$2';

$route['validar_quitar_devolucion']						    = 'devoluciones/validar_quitar_devolucion';


$route['procesar_devoluciones/(:any)']    = 'devoluciones/procesar_devoluciones/$1';
//$route['generar_etiquetas/(:any)']    = 'pdfs/generar_etiquetas/$1';
//$route['generar_notas/(:any)']    = 'pdfs/generar_notas/$1';


//$route['eliminar_prod_temporal/(:any)/(:any)']       = 'entradas/eliminar_prod_temporal/$1/$2';
//$route['validar_eliminar_prod_temporal']    = 'entradas/validar_eliminar_prod_temporal';




$route['procesando_servidor_devolucion']			= 'devoluciones/procesando_servidor_devolucion';  

///////////////////////////////////EDITAR INVENTARIO///////////////////////////////////////////////////

$route['editar_inventario']						= 'inventario/editar_inventario';
$route['validar_edicion_producto']				= 'inventario/validar_edicion_producto';
$route['procesando_servidor_cambio']			= 'inventario/procesando_servidor_cambio';

$route['validar_impresion']						= 'inventario/validar_impresion';


$route['impresion_etiquetas/(:any)']    = 'pdfs/impresion_etiquetas/$1';





/////////////////////////////////////////////Listado de todas las reportes
$route['reportes']						= 'reportes/listado_reportes';
$route['procesando_reporte']    		= 'reportes/procesando_reporte';

$route['listado_notas']    = 'reportes/listado_notas';
$route['listado_salidas']    = 'reportes/listado_salidas';

$route['exportar_reporte']    = 'reportes/exportar_reporte';



/////////////////////////////dependencias////////////////////////

$route['cargar_dependencia']   = 'inventario/cargar_dependencia';



/* End of file routes.php */
/* Location: ./application/config/routes.php */
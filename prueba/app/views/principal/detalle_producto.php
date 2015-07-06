<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
 	if (!isset($retorno)) {
      	$retorno ="";
    }

 $hidden = array('referencia'=>$referencia); ?>
<?php //echo form_open('validar_eliminar_actividad_comercial', array('class' => 'form-horizontal','id'=>'form_catalogos','name'=>$retorno, 'method' => 'POST', 'role' => 'form', 'autocomplete' => 'off' ) ,   $hidden ); ?>

		        			<!-- Encabezado -->
		         <div class="modal-header col-xs-12 col-md-12 col-lg-12">
		            <button type="button" class="close" 
		               data-dismiss="modal" aria-hidden="true">
		                  &times;
		            </button>
		            <h4 class="modal-title" id="myModalLabel">
		               Catálogo de productos
		            </h4>
		         </div>
		         
						         <!-- Contenido -->
		         <div class="modal-body col-xs-12 col-md-12 col-lg-12">
		         	
				         	<div class="col-xs-12 col-md-12 col-lg-12">         	
						        <!--<img src="uploads/productos/thumbnail/<?php echo (substr($el_producto->imagen,0,-4).'_thumb'.substr($el_producto->imagen,-4)); ?>" class="img-responsive col-xs-9 col-md-9 col-lg-9"> -->
						        <img src="uploads/productos/<?php echo $el_producto->imagen; ?>" class="img-responsive col-xs-9 col-md-9 col-lg-9"> 
								
															        
					         	<span class="col-xs-12 col-md-3 col-lg-3 nombre"><?php echo $el_producto->descripcion?></span>
							    <span class="col-xs-12 col-md-3 col-lg-3 color"><?php echo $el_producto->nombre_color?></span> 
							    <span class="col-xs-12 col-md-3 col-lg-3 cantidadtotal"><?php echo $el_producto->composicion?></span>
							    <span class="col-xs-12 col-md-3 col-lg-3 preciocatalogo"><?php echo $el_producto->precio?> pesos</span>
							</div>
							<div id="disponibilidad" class="col-xs-12 col-md-12 col-lg-12" style="padding: 20px 10px 15px 15px;">  
									 <input id="ver_dis" style="padding:1px;" type="submit" class="btn btn-success btn-block" value="Ver Disponibilidad"/>
							</div>

						


							<div class="col-xs-12 col-md-12 col-lg-12 " id="cont_tab">      
								<table class="table table-striped table-bordered table-responsive tabla_ordenadas" style="max-height:200px;">
									<thead>	
										<tr>
											<th class="text-center cursora" style="width: 42%;">Código<i class="glyphicon glyphicon-sort"></i></th>
											<th class="text-center cursora" style="width: 12%;">Lote <i class="glyphicon glyphicon-sort"></i></th>
											<th class="text-center cursora" style="width: 15%;">Cantidad<i class="glyphicon glyphicon-sort"></i></th>
											<th class="text-center cursora" style="width: 14%;">Ancho <i class="glyphicon glyphicon-sort"></i></th>
											<th class="text-center cursora">Entrada<i class="glyphicon glyphicon-sort"></i></th>		
											<th class="text-center cursora">Apartar<i class="glyphicon glyphicon-sort"></i></th>														
										</tr>
									</thead>		


									<?php if ( isset($los_productos) && !empty($los_productos) ): ?>
										<?php foreach( $los_productos as $producto ): ?>
											<?php
													if  ($producto->id_apartado==1){
														$valor=' danger';
													} else
													{
														$valor='';
													}
														 

											?>
											<tr class="<?php echo $producto->id; ?><?php echo $valor; ?>" >
												<td class="text-center"><?php echo $producto->codigo; ?></td>
												<td class="text-center"><?php echo $producto->id_lote; ?></td>
												<td class="text-center"><?php echo $producto->cantidad; ?></td>
												<td class="text-center"><?php echo $producto->ancho; ?></td>
												<td class="text-center"><?php echo date( 'd-m-Y', strtotime($producto->fecha_entrada)); ?></td>
												<td>
													<button type="button"  identificador="<?php echo $producto->id; ?>" class="btn btn-success btn-block apartar <?php echo $producto->id; ?>">
														<span class="glyphicon glyphicon-add">Apartar</span>
													</button>
												</td>						


											</tr>
										<?php endforeach; ?>
									<?php else : ?>
											<tr>
												<td colspan="6">No hay piezas en existencias</td>
											</tr>
									<?php endif; ?>	
								
								</table>
							</div>



		         </div>
		         				<!-- pie -->
		         <div class="modal-footer">
		            <button type="button" class="btn btn-default" 
		               data-dismiss="modal">Cerrar
		            </button>
		         </div>


<?php //echo form_close(); ?>



<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('header'); ?>
<?php 

	
   $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
   if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
        $coleccion_id_operaciones = array();
   }   

 	if (!isset($retorno)) {
      	$retorno ="";
    }

  $fecha_hoy = date('j-m-Y');

$attr = array('class' => 'form-horizontal', 'id'=>'form_entradas','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
echo form_open('validar_agregar_producto', $attr);
?>		
<div class="container">

<br>



<div class="row">
	<div class="col-sm-8 col-md-8">
		<div class="col-sm-6 col-md-6 row"><h4>Registro de Entrada</h4></div>
	</div>

	<input type="hidden" id="oculto_producto" name="oculto_producto" value="" color="" composicion="" calidad="">

	<div class="col-sm-2 col-md-2">
		<fieldset disabled>
			<div class="form-group">
				<label for="fecha" class="col-sm-12 col-md-12">Fecha</label>
				<div class="col-sm-12 col-md-12">
					<input value="<?php echo $fecha_hoy; ?>"  type="text" class="form-control" id="fecha" name="fecha" placeholder="Fecha">

				</div>
			</div>
		</fieldset>	
	</div>

	<div class="col-sm-2 col-md-2">
		<fieldset disabled>
			<div class="form-group">
				<label for="movimiento" class="col-sm-12 col-md-12">No. Movimiento</label>
				<div class="col-sm-12 col-md-12">
					<input type="text" title="Movimiento" value="<?php echo $consecutivo->consecutivo+1; ?>" class="form-control" id="movimiento" name="movimiento" placeholder="No. Movimiento">
				</div>
			</div>
		</fieldset>			
	</div>
</div>
<div class="row">
	<div class="col-sm-12 col-md-4">
		<?php if ($val_proveedor) { ?>
			<fieldset class="disabledme" disabled>							
		<?php } else { ?>
			<fieldset class="disabledme">						
		<?php } ?>

				<div class="form-group">
					<label for="descripcion" class="col-sm-12 col-md-12">Proveedor</label>
					<div class="col-sm-12 col-md-12">
							<?php if ($val_proveedor) { ?>
								<input value="<?php echo $val_proveedor->nombre; ?>" type="text" name="editar_proveedor" idproveedor="1" class="form-control buscar_proveedor" autocomplete="off" spellcheck="false" placeholder="Buscar Proveedor...">
							<?php } else { ?>
								<input  type="text" name="editar_proveedor" idproveedor="1" class="form-control buscar_proveedor" autocomplete="off" spellcheck="false" placeholder="Buscar Proveedor...">
							<?php } ?>
					</div>
				</div>
		
			</fieldset>							
		
	</div>

	<div class="col-sm-2 col-md-2">
		<?php if ($val_proveedor) { ?>
			<fieldset class="disabledme" disabled>							
		<?php } else { ?>
			<fieldset class="disabledme">						
		<?php } ?>

			<div class="form-group">
				<label for="factura" class="col-sm-12 col-md-12">Factura/Remisión</label>
				<div class="col-sm-12 col-md-12">
							<?php if ($val_proveedor) { ?>
								<input value="<?php echo $val_proveedor->factura; ?>" type="text" class="form-control" id="factura" name="factura" placeholder="Factura">							
							<?php } else { ?>
								<input type="text" class="form-control" id="factura" name="factura" placeholder="Factura">
							<?php } ?>				
				</div>
			</div>
		
			</fieldset>							
		
	
	</div>

</div>


<div class="col-sm-12 col-md-12 row">
	<div class="container row">
		<div class="panel panel-primary">
			<div class="panel-heading">Nuevo producto</div>
			<div class="panel-body">


				<div class="row">

	                  <div class="col-sm-4 col-md-4">
	                     <div class="form-group">
							<label for="descripcion" class="col-sm-12 col-md-12">Producto</label>
							<div class="col-sm-12 col-md-12">

		                          <select class="col-sm-12 col-md-12 form-control" name="producto" id="producto" dependencia="color" nombre="color">
		                            <option value="">Selecciona un producto</option>
		                            <?php if($productos){ ?>
		                              <?php foreach($productos as $producto){ ?>
		                                <option value="<?php echo $producto->descripcion; ?>"><?php echo $producto->descripcion; ?></option>
		                              <?php } ?>
		                            <?php } ?>
		                          </select>
	                        </div>  
	                          
	                     </div>
	                  </div>

	                  <div class="col-sm-3 col-md-3">
	                     <div class="form-group">
							<label for="descripcion" class="col-sm-12 col-md-12">Color</label>
							<div class="col-sm-12 col-md-12">

		                          <select class="col-sm-12 col-md-12 form-control" name="color" id="color"  dependencia="composicion" nombre="composición" style="padding-right:0px">
		                            <option value="0">Selecciona un color</option>
		                          </select>
	                        </div>  
	                          
	                     </div>
	                  </div>
	                  
	                  <div class="col-sm-3 col-md-3">
	                     <div class="form-group">
							<label for="descripcion" class="col-sm-12 col-md-12">Composición</label>
							<div class="col-sm-12 col-md-12">

		                          <select class="col-sm-12 col-md-12 form-control" name="composicion" id="composicion" dependencia="calidad" nombre="calidad" style="padding-right:0px">
		                            <option value="0">Selecciona una composición</option>
		                          </select>
	                        </div>  
	                          
	                     </div>
	                  </div>



	                  <div class="col-sm-2 col-md-2">
	                     <div class="form-group">
							<label for="descripcion" class="col-sm-12 col-md-12">Calidad</label>
							<div class="col-sm-12 col-md-12">
		                          <select class="col-sm-12 col-md-12 form-control" name="calidad" id="calidad" dependencia="" nombre="" style="padding-right:0px">
		                            <option value="0">Seleccione una calidad</option>
		                          </select>
	                        </div>  
	                          
	                     </div>
	                  </div>
	            </div>      





						<input type="hidden" id="referencia" name="referencia" value="">

				


					<!--2da linea -->
				<div class="row">
					<div class="col-sm-2 col-md-2">
						<div class="form-group">
							<label for="cantidad_um" class="col-sm-12 col-md-12">Cantidad (en m o kg)</label>
							<div class="col-sm-12 col-md-12">
								<input type="text" class="form-control" id="cantidad_um" name="cantidad_um" placeholder="# de Mtrs/Kg">
							</div>
						</div>
					</div>				

					<div class="col-sm-3 col-md-3">
						<div class="form-group">
							<label for="descripcion" class="col-sm-12 col-md-12">Metros/Kg</label>
							<div class="col-sm-12 col-md-12">
								<select name="id_medida" id="id_medida" class="form-control">
										<?php foreach ( $medidas as $medida ){ ?>
												<option value="<?php echo $medida->id; ?>"><?php echo $medida->medida; ?></option>
										<?php } ?>
								</select>
							</div>
						</div>
					</div>		

					<div class="col-sm-2 col-md-2">
						<div class="form-group">
							<label for="cantidad_royo" class="col-sm-12 col-md-12">Cantidad de Rollos</label>
							<div class="col-sm-12 col-md-12">
								<input type="text" class="form-control" id="cantidad_royo" name="cantidad_royo" placeholder="Cant. de rollos">
							</div>
						</div>
					</div>				




					<div class="col-sm-2 col-md-2">
						<fieldset disabled>
							<div class="form-group">
								<label for="ancho" class="col-sm-12 col-md-12">Ancho (en cm)</label>
								<div class="col-sm-12 col-md-12">
									<input type="text" class="form-control" id="ancho" name="ancho" placeholder="Ancho">
								</div>
							</div>
						</fieldset>	
					</div>	

					<div class="col-sm-3 col-md-3">
						<fieldset disabled>
							<div class="form-group">
								<label for="precio" class="col-sm-12 col-md-12">Precio</label>
								<div class="col-sm-12 col-md-12">
									<input type="text" class="form-control" id="precio" name="precio" placeholder="Precio">

								</div>
							</div>
						</fieldset>		
					</div>	
				</div>
					<!--3ta linea -->

				<div class="row">	
						<div class="col-sm-3 col-md-3">
							<fieldset disabled>
								<div class="form-group">
									<label for="codigo" class="col-sm-12 col-md-12">Código</label>
									
										<div class="col-sm-12 col-md-12">
											<input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código">

										</div>


								</div>
							</fieldset>
						</div>	
						

					<div class="col-sm-5 col-md-5">
						<div class="form-group">
							<label for="comentario" class="col-sm-12 col-md-12">Comentarios</label>
							<div class="col-sm-12 col-md-12">
								<textarea class="form-control" name="comentario" id="comentario" rows="5" placeholder="Comentarios"></textarea>
							</div>
						</div>
					</div>					

						

						<div class="col-sm-4 col-md-4">
							<div class="form-group">
								<label for="descripcion" class="col-sm-12 col-md-12">Lote</label>
								<div class="col-sm-12 col-md-12">
									<select name="id_lote" id="id_lote" class="form-control">
											<?php foreach ( $lotes as $lote ){ ?>
													<option value="<?php echo $lote->id; ?>"><?php echo $lote->lote; ?></option>
											<?php } ?>
									</select>
								</div>
							</div>
						</div>	

						<div class="col-sm-4 col-md-4">
							<div class="form-group">
								<label for="descripcion" class="col-sm-12 col-md-12">Estatus</label>
								<div class="col-sm-12 col-md-12">
									<select name="id_estatus" id="id_estatus" class="form-control">
											<?php foreach ( $estatuss as $estatus ){ ?>
													<option value="<?php echo $estatus->id; ?>"><?php echo $estatus->estatus; ?></option>
											<?php } ?>
									</select>
								</div>
							</div>
						</div>							


<br>
						<div class="col-sm-4 col-md-4"></div>
									<div class="col-sm-4 col-md-4">
										<input style="padding:8px;" type="submit" class="btn btn-success btn-block" value="Agregar"/>
									</div>
						</div>
<br>
  					</div>

  				</div>

  						
		</div>


		<!-- Regilla-->

	</div>




<?php echo form_close(); ?>




		<div class="row">
			<div class="col-md-12">
				<h4>Productos</h4>
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-responsive tabla_ordenadas" >
					<thead>	
						<tr>
							<th class="text-center cursora" width="15%">Código <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="15%">Descripción <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="5%">Color <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="10%"> Medida <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="5%">Ancho <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="15%">Proveedor <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="5%">Lote - consecutivo <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center " width="10%"><strong>Eliminar</strong></th>


						</tr>
					</thead>		

					<tbody>	
					<?php if ( isset($movimientos) && !empty($movimientos) ): ?>
						<?php foreach( $movimientos as $movimiento ): ?>
							<tr>
								<td class="text-center"><?php echo $movimiento->codigo; ?></td>								
								<td class="text-center"><?php echo $movimiento->id_descripcion; ?></td>

								<td class="text-center">
									<div style="background-color:#<?php echo $movimiento->hexadecimal_color; ?>;display:block;width:15px;height:15px;margin:0 auto;"></div>
								</td>																														

								
								<td class="text-center"><?php echo $movimiento->cantidad_um; ?> <?php echo $movimiento->medida; ?></td>
								<td class="text-center"><?php echo $movimiento->ancho; ?> cm</td>
								<td class="text-center"><?php echo $movimiento->nombre; ?></td>
								<td class="text-center"><?php echo $movimiento->id_lote; ?> - <?php echo $movimiento->consecutivo; ?></td>
								

								<td>
									<a href="<?php echo base_url(); ?>eliminar_prod_temporal/<?php echo $movimiento->id; ?>/<?php echo base64_encode($movimiento->codigo) ; ?>"  
										class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalMessage">
										<span class="glyphicon glyphicon-remove"></span>
									</a>
								</td>								

							</tr>
								
						<?php endforeach; ?>
					

					<?php else : ?>
							<tr class="noproducto">
								<td colspan="10">No se han agregado producto</td>
							</tr>

					<?php endif; ?>		

					</tbody>		
				</table>
			</div>

			</div>
		</div>

			<!-- Fin de la Regilla-->


		<br>
		<div class="row">
			<div class="col-sm-4 col-md-4"></div>
			<div class="col-sm-4 col-md-4">
				<a href="<?php echo base_url(); ?><?php echo $retorno; ?>" type="button" class="btn btn-danger btn-block">Regresar</a>
			</div>
			<div class="col-sm-4 col-md-4">
				<a style="padding:8px;" href="<?php echo base_url(); ?>procesar_entradas/<?php echo base64_encode("-1") ; ?>" type="button" class="btn btn-success btn-block">Procesar</a>
			</div>
		</div>
<br>
	</div>	
</div>

<div class="modal fade bs-example-modal-lg" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>	
<?php $this->load->view('footer'); ?>
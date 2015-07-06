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

$attr = array('class' => 'form-horizontal', 'id'=>'form_editar_inventario','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
echo form_open('validar_edicion_producto', $attr);
?>		
<div class="container">

<br>
<div class="row">
	<div class="col-sm-8 col-md-8">
		<div class="col-sm-6 col-md-6 row"><h4>Editar Producto Inventario</h4></div>
	</div>

	<div class="col-sm-2 col-md-2">
		<fieldset disabled>
			<div class="form-group">
				<label for="fecha" class="col-sm-12 col-md-12">Fecha Entrada</label>
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
					<input type="text" value="" class="form-control" id="movimiento" name="movimiento" placeholder="No. Movimiento">
				</div>
			</div>
		</fieldset>			
	</div>
</div>
<div class="row">
	<input type="hidden" id="oculto_producto" name="oculto_producto" value="no" color="" composicion="" calidad="">
	<div class="col-sm-12 col-md-4">
	
		<div class="form-group">
			<label for="descripcion" class="col-sm-12 col-md-12">Producto</label>
			<div class="col-sm-12 col-md-12">
						<input  type="text" name="editar_prod_inven" id="editar_prod_inven" idprodinven="1" class="form-control buscar_prod_inven" autocomplete="off" spellcheck="false" placeholder="Buscar producto...">
			</div>
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<fieldset disabled>
				<div class="form-group">
					<label for="proveedor" class="col-sm-12 col-md-12">Proveedor</label>
					<div class="col-sm-12 col-md-12">
						<input type="text" value="" class="form-control" id="proveedor" name="proveedor" placeholder="Proveedor">
					</div>
				</div>
		</fieldset>			
		
	</div>

	
	

	<div class="col-sm-2 col-md-2">
			<fieldset class="disabledme" disabled>							

			<div class="form-group">
				<label for="factura" class="col-sm-12 col-md-12">Factura/Remisión</label>
				<div class="col-sm-12 col-md-12">
								<input type="text" class="form-control" id="factura" name="factura" placeholder="Factura">
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
							<label id="label_color" class="col-sm-12 col-md-12">Color</label>
							<div class="col-sm-12 col-md-12">
		                          <select class="col-sm-12 col-md-12 form-control" name="color" id="color"  dependencia="composicion" nombre="composición" style="padding-right:0px">
		                            <option value="0">Selecciona un color</option>
		                            <option value="1">Selecciona un color</option>
		                            <option value="2">Selecciona un color</option>
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
						<input type="hidden" id="codigo_original" name="codigo_original" value="">



					<!--2da linea -->
				<div class="row">
					<div class="col-sm-3 col-md-3">
						<div class="form-group">
							<label for="cantidad_um" class="col-sm-12 col-md-12">Cantidad</label>
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



					<div class="col-sm-3 col-md-3">
						<div class="form-group">
							<label for="ancho" class="col-sm-12 col-md-12">Ancho</label>
							<div class="col-sm-12 col-md-12">
								<input type="text" class="form-control" id="ancho" name="ancho" placeholder="Ancho">

							</div>
						</div>
					</div>	

					<div class="col-sm-3 col-md-3">
						<div class="form-group">
							<label for="precio" class="col-sm-12 col-md-12">Precio</label>
							<div class="col-sm-12 col-md-12">
								<input type="text" class="form-control" id="precio" name="precio" placeholder="Precio">

							</div>
						</div>
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
							<label for="comentario" class="col-sm-12 col-md-12">Reportes de Cambios</label>
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



						
								
				</div>
<br>				

				<div class="row">
						<div class="col-sm-4 col-md-4"></div>	
						
						<div class="col-sm-4 col-md-4">
							<a style="padding:8px;" id="impresion" type="button" class="btn btn-success btn-block">Imprimir Etiqueta</a>
						</div>
					    

						<div class="col-sm-4 col-md-4">
							<input style="padding:8px;" type="submit" class="btn btn-success btn-block" value="Cambiar caracteristicas"/>
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
		<br>
		<h4>Histórico de Ediciones</h4>	
		<br>	
		<div class="table-responsive">
			<section>
				<table id="tabla_cambio" class="display table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Código</th>
							<th>Descripción</th>
							<th>Color</th>
							<th>Composición</th>
							<th>Calidad</th>
							<th>Pieza</th>
							<th>Consecutivo</th>
							<th>Comentario</th>

						</tr>
					</thead>
				</table>
			</section>
		</div>
	</div>
</div>


			<!-- Fin de la Regilla-->


		<br>
		<div class="row">
			<div class="col-sm-8 col-md-8"></div>
			<div class="col-sm-4 col-md-4">
				<a href="<?php echo base_url(); ?><?php echo $retorno; ?>" type="button" class="btn btn-danger btn-block">Regresar</a>
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
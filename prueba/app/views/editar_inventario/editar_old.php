<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
	
<div class="container margenes">
		<div class="panel panel-primary">
			<div class="panel-heading">Editar</div>
			<div class="panel-body">
				<div class="container row">					
					<div class="col-md-12">	
						
							<div class="col-sm-4 col-md-4">

									<div class="form-group">
										<label for="descripcion" class="col-sm-12 col-md-12">Producto</label>
										<div class="col-sm-12 col-md-12">
													<input  type="text" name="editar_prod_inven" idprodinven="1" class="form-control buscar_prod_inven" autocomplete="off" spellcheck="false" placeholder="Buscar producto...">
										</div>
									</div>


							</div>
							<div class="col-sm-2 col-md-2">
								<label for="descripcion" class="col-sm-12 col-md-12"></label>
								<a href="#" type="button" class="btn btn-success btn-block">Buscar</a>
							</div>
							<div class="col-sm-2 col-md-2">
								<label for="descripcion" class="col-sm-12 col-md-12"></label>
								<a href="#" type="button" class="btn btn-success btn-block">Escanear</a>
							</div>
							
						
					</div>
				</div>
				<hr>




				<div class="container row">
					
					


					<div id="example2" class="col-sm-12 col-md-12 " style="margin-bottom:10px">
						<div class="row">
							
							<div class="col-sm-4 col-md-4">
								<div class="form-group">
									<label for="descripcion" class="col-sm-12 col-md-12">Producto</label>
									<div class="col-sm-12 col-md-12">
											<select class="producto col-sm-12 col-md-12 form-control" id="producto" name="producto">
												<option value="">Productos</option>
											</select>

									</div>
								</div>
							</div>

							<div class="col-sm-3 col-md-3">
								<div class="form-group">
									<label for="descripcion" class="col-sm-12 col-md-12">Color</label>
									<div class="col-sm-12 col-md-12">
										<select class="color col-sm-12 col-md-12 form-control" name="color" id="color">
												<option value="">Colores</option>
										</select>
									</div>
								</div>
							</div>						


							<div class="col-sm-3 col-md-3">
								<div class="form-group">
									<label for="descripcion" class="col-sm-12 col-md-12">Composición</label>
									<div class="col-sm-12 col-md-12">
										<select class="composicion col-sm-12 col-md-12 form-control" name="composicion" id="composicion">
											<option value="">Composiciones</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-sm-2 col-md-2">
								<div class="form-group">
									<label for="descripcion" class="col-sm-12 col-md-12">Calidad</label>
									<div class="col-sm-12 col-md-12">
											<select class="calidad col-sm-12 col-md-12 form-control" name="calidad" id="calidad">
												<option value="">calidades</option>
											</select>	
									</div>
								</div>
							</div>	
					</div>


							<input type="hidden" id="referencia" name="referencia" value="">

					</div>







					<div class="col-sm-12 col-md-12">

					<div class="row">
						<div class="col-sm-2 col-md-2">
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


						<div class="col-sm-2 col-md-2">
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



						<div class="col-sm-8 col-md-8">
							<div class="form-group">
								<label for="descripcion" class="col-sm-12 col-md-12">Comentarios</label>
								<div class="col-sm-12 col-md-12">
									<textarea class="form-control" name="comentario" id="comentario" rows="5" placeholder="Comentarios"></textarea>
								</div>
							</div>
						</div>	
					
						
				</div>	
			</div>



			<hr>
<div class="col-md-12">	
<div class="row">
	<div class="col-sm-4 col-md-4">
		<a href="#" type="button" class="btn btn-success btn-block">Imprimir etiqueta</a>
	</div>
	<div class="col-sm-4 col-md-4"></div>
	<div class="col-sm-4 col-md-4">
		<a href="#" type="button" class="btn btn-danger btn-block">Regresar</a>
	</div>	
</div>
</div>				
		</div>
	</div>
</div>
<?php $this->load->view( 'footer' ); ?>
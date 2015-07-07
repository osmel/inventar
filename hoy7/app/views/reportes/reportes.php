<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>


<div class="container margenes">
	<div class="panel panel-primary">
		<div id="label_reporte" class="panel-heading">Reportes de entradas</div>
			<div class="container">	
				<br>

				<div class="col-sm-12 col-md-12" style="margin-bottom:10px">						
					<div class="col-sm-2 col-md-2">
						<button id="existencia_reporte" type="button" class="btn btn-danger btn-block">Entradas</button>							
					</div>						
					<div class="col-sm-2 col-md-2">
						
						<button id="salida_reporte" type="button" class="btn btn-danger btn-block">Salidas</button>							
					</div>

					<div class="col-sm-2 col-md-2 marginbuttom">
						<button  id="apartado_reporte" type="button" class="btn btn-danger btn-block">Apartados</button>
					</div>

					<div class="col-sm-2 col-md-2 marginbuttom">
						<button  id="cero_reporte" type="button" class="btn btn-danger btn-block">Existencias Cero</button>
					</div>

					<div class="col-sm-2 col-md-2 marginbuttom">
						<button  id="baja_reporte" type="button" class="btn btn-danger btn-block">Existencias Bajas</button>
					</div>

					<div class="col-sm-2 col-md-2 marginbuttom">
						<button  id="top_reporte" type="button" class="btn btn-danger btn-block">TOP 10</button>
					</div>
					
					<div class="col-sm-2 col-md-2">
						<label for="descripcion" class="col-sm-12 col-md-12"></label>
						<a href="<?php echo base_url(); ?>listado_notas"  
							type="button" class="btn btn-info btn-block">Histórico de Entradas
						</a>
					</div>

					<div class="col-sm-2 col-md-2">
						<label for="descripcion" class="col-sm-12 col-md-12"></label>
						<a href="<?php echo base_url(); ?>listado_salidas" type="button" class="btn btn-info btn-block">
							Histórico de Salidas
						</a>
					</div>
				</div>

				<br>	
				<div class="row">	
					<div class="col-md-12">	
					
						<div class="table-responsive">

                           <div class="col-md-4 leyenda_devolucion"  style="display: none;"><span> Productos Devueltos</span><div style="margin-right: 15px;float:left;background-color:#ab1d1d;width:15px;height:15px;"></div> </div>
	
                           <div class="col-md-4 leyenda"  style="display: none;"><span> Apartado Individual</span><div style="margin-right: 15px;float:left;background-color:#ab1d1d;width:15px;height:15px;"></div> </div>
                           <div class="col-md-4 leyenda" style="display: none;" ><span> Apartado Confirmado</span><div style="margin-right: 15px;float:left;background-color:#f1a914;width:15px;height:15px;"></div></div>
						   <div class="col-md-4 leyenda" style="display: none;" ><span> Disponibilidad Salida</span><div style="margin-right: 15px;float:left;background-color:#14b80f;width:15px;height:15px;"></div></div>
						   <hr/>
						   	<div class="notif-bot-pedidos"></div>
							<section>
								<table id="tabla_reporte" class="display table table-striped table-bordered table-responsive " cellspacing="0" width="100%">
									<!--
	
									-->
							

								</table>
							</section>
						</div>
						
					</div>	
				</div>	
				<br>
				<hr>
				
		
				<div class="row">						
					<div class="col-md-6">								
					</div>	
					<div class="col-md-2">	
						<span id="pieza">Total de piezas: 6</span>			
					</div>	
					<div class="col-md-2">	
						<span id="metro">Total de mtrs: 450.5</span>			
					</div>	
					<div class="col-md-2">	
						<span id="kg" >Total de Kgs: 6</span>				
					</div>	
				</div>			

				<div class="row">						
					<div class="col-md-6">								
					</div>	
					<div class="col-md-2">	
						<span id="total_pieza">Total de piezas: 6</span>			
					</div>	
					<div class="col-md-2">	
						<span id="total_metro">Total de mtrs: 450.5</span>			
					</div>	
					<div class="col-md-2">	
						<span id="total_kg" >Total de Kgs: 6</span>				
					</div>	
				</div>


				<div class="col-md-12">	
					<hr>
				</div>	




				<div class="col-md-12">		
						<br>
						<h4>Filtros</h4>	
						<br>

					

	                    <!-- 
						<div class="col-sm-12 col-sm-12 col-md-2">
							<div class="form-group">
								<label for="descripcion" class="col-sm-12 col-md-12">Desde:</label>
								
									<input class="datepicker" data-date-format="mm/dd/yyyy">
								
							</div>
						</div>

						<div class="col-sm-12 col-sm-6 col-md-2">
							<div class="form-group">
								<label for="descripcion" class="col-sm-12 col-md-12">Hasta:</label>
									<input class="datepicker" data-date-format="mm/dd/yyyy">
							</div>
						</div>
					
						-->
					
						<div id="estatus_id" class="col-sm-4 col-md-4">
							<div class="form-group">
								<label for="estatus" class="col-sm-12 col-md-12">Estatus</label>
								<div class="col-sm-12 col-md-12">
									<select name="id_estatuss" id="id_estatuss" class="form-control">
											<?php foreach ( $estatuss as $estatus ){ ?>
													<option value="<?php echo $estatus->id; ?>"><?php echo $estatus->estatus; ?></option>
											<?php } ?>
									</select>
								</div>
							</div>
						</div>							

												
						<div id="proveedor_id" class="col-sm-4 col-md-4">

									<div class="form-group">
										<label id="label_proveedor" for="descripcion" class="col-sm-12 col-md-12">Proveedor</label>
										<div class="col-sm-12 col-md-12">
											 <input  type="text" name="editar_proveedor_reporte" id="editar_proveedor_reporte" idproveedor="1" class="form-control buscar_proveedor_reporte" autocomplete="off" spellcheck="false" placeholder="Buscar...">
										</div>
									</div>
							
						</div>						

						<div id="fecha_id" class="col-sm-12 col-sm-12 col-md-4">
							<label id="label_proveedor" for="descripcion" class="col-sm-12 col-md-12">Rango de fecha</label>
							<div class="input-prepend input-group  form-group">
	                       		<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
								<input id="foco" type="text" name="permisos"  class="form-control col-sm-12 col-md-12 fecha_reporte" value="" format = "DD-MM-YYYY"/> 
							</div>	
	                     </div>

							
						<div class="col-md-12">	
							<!-- <hr> -->
						</div>	






					<div id="example2" class="row">
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
					<input type="hidden" id="codigo_original" name="codigo_original" value="">

						

						<div class="row">

								<input type="hidden" id="botones" name="botones" value="existencia">
						</div>
						<br><br>

						
						<div class="row">
							<div class="col-sm-8 col-md-8"></div>
							<div class="col-sm-4 col-md-4">
								<a href="#" type="button" class="btn btn-danger btn-block">Regresar</a>
							</div>
							
						</div>
						<br/>


				</div>


			</div>

	</div>

</div>


<?php $this->load->view( 'footer' ); ?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<div class="container margenes">
		

		<div class="panel panel-primary">
			<div class="panel-heading">Detalles de pedido</div>
			<div class="panel-body">
				
		<div class="container row">

					<div class="col-sm-12 col-md-12 control" style="margin-bottom:10px">						
						<div class="col-sm-2 col-md-2">
							<div class="form-group">
								<label for="descripcion" class="col-sm-12 col-md-12">Num. Mov</label>
								<div class="col-sm-12 col-md-12">
									<input type="text" disabled class="form-control" id="etiq_num_mov" name="etiq_num_mov" placeholder="">
								</div>
							</div>
						</div>		

						<div class="col-sm-4 col-md-4">
							<div class="form-group">
								<label for="descripcion" class="col-sm-12 col-md-12">Cliente</label>
								<div class="col-sm-12 col-md-12">
									<input type="text" disabled class="form-control" id="etiq_cliente" name="etiq_cliente" placeholder="34534534554">
								</div>
							</div>
						</div>							



						<div class="col-sm-5 col-md-5">
							<div class="form-group">
								<label for="descripcion" class="col-sm-12 col-md-12">Dependencia</label>
								<div class="col-sm-12 col-md-12">
									<input type="text" disabled class="form-control" id="etiq_dependencia" name="etiq_dependencia" placeholder="">
								</div>
							</div>
						</div>
					
						<div class="col-sm-2 col-md-2">
							<div class="form-group">
								<label for="descripcion" class="col-sm-12 col-md-12">Fecha</label>
								<div class="col-sm-12 col-md-12">
									<input type="text" disabled class="form-control" id="etiq_fecha" name="etiq_fecha" placeholder="10/10/15">
								</div>
							</div>
						</div>
						<div class="col-sm-2 col-md-2">
							<div class="form-group">
								<label for="descripcion" class="col-sm-12 col-md-12">Hora</label>
								<div class="col-sm-12 col-md-12">
									<input type="text" disabled class="form-control" id="etiq_hora" name="etiq_hora" placeholder="9:05am">
								</div>
							</div>
						</div>		


						<div class="col-sm-2 col-md-2">
							<div class="form-group">
								<label for="descripcion" class="col-sm-12 col-md-12">
									<span id="etiq_tipo_apartado" ></span>
								</label>
								<div class="col-sm-12 col-md-12" id="etiq_color_apartado">
									
								</div>
							</div>
						</div>									




				</div>		
	</div>


	<hr/>



	<div class="container row">					
		<div class="col-md-12">		
					  
						<input type="hidden" id="num_mov" value="<?php echo $num_mov ; ?>">

						<div class="table-responsive">
							<section>
								<table id="pedido_detalle" class="display table table-striped table-bordered table-responsive " cellspacing="0" width="100%">
								</table>
							</section>
						</div>		
								<hr/>

						<div class="col-md-12">	
							<div class="row">
								<div class="col-sm-3 col-md-3">
									<label for="descripcion" class="col-sm-12 col-md-12"></label>
									<a href="<?php echo base_url(); ?>generar_pedido_especifico/<?php echo base64_encode($num_mov); ?>/<?php echo base64_encode(1); ?>/<?php echo base64_encode(0); ?>"  
										type="button" class="btn btn-success btn-block" target="_blank">Imprimir
									</a>
								</div>

								
								
								<div class="col-sm-3 col-md-3">
									<button type="button"  class="btn btn-success btn-block" id="excluir_pedido">
										<span>Excluir de la Salida</span>
									</button>
								</div>	
								<div class="col-sm-3 col-md-3">
									<button type="button"  class="btn btn-success btn-block" id="incluir_pedido">
										<span>Incluir en la Salida</span>
									</button>
								</div>			
								<div class="col-sm-3 col-md-3">
									<a href="<?php echo base_url(); ?>pedidos" type="button" class="btn btn-danger btn-block">Regresar</a>
								</div>	
	
							</div>	
						</div>

		</div>
	</div>

</div>
</div>
<?php $this->load->view( 'footer' ); ?>
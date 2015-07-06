<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<style>

</style>
	<div class="container margenes">


		<div class="col-sm-12 col-md-12 control blanco" style="margin-bottom:10px;padding: 10px 10px 10px 10px;">
			<div class="col-sm-4 col-md-4" style="padding:15px;">				
				<a style="padding:8px;" href="<?php echo base_url(); ?>procesar_apartados" type="button" class="btn btn-success btn-block">Procesar Apartados</a>
			</div>

			<!--status -->				
			<div class="col-sm-1 col-md-3 col-xs-12"></div>
			<div class=" col-sm-6 col-md-2">
				<div class="form-group">
					<label for="descripcion" class="col-sm-12 col-md-12">Estatus</label>
					<div class="col-sm-12 col-md-12">
						<select name="id_estatus" id="id_estatus" class="form-control">
							    <option value="-1">Ninguno</option>
								<?php foreach ( $estatuss as $estatus ){ ?>
										<option value="<?php echo $estatus->id; ?>"><?php echo $estatus->estatus; ?></option>
								<?php } ?>
						</select>
					</div>
				</div>
			</div>	


			<!--colores -->
			<div class="col-sm-1 col-md-1 col-xs-12"></div>
			<div class=" col-sm-4 col-md-2">
					<div class="form-group">
							<label for="descripcion" class="col-sm-12 col-md-12">Color</label>
							<div class="col-sm-12 col-md-12">
								<select name="id_color" id="id_color" class="form-control">
									    <option value="-1">Ninguno</option>
										<?php foreach ( $colores as $color ){ ?>
												<option value="<?php echo $color->id; ?>"><?php echo $color->color; ?></option>
										<?php } ?>
								</select>
							</div>
					</div>
			</div>		

		</div>		
		
		<!-- cuerpo todas las imagenes-->
		

		<div class="col-sm-12 col-md-12 control sin-margen" style="margin-bottom:10px">						
			<div class="container blanco" style="padding:22px">




						<div class="table-responsive">
						 <div class="notif-bot-pedidos"></div>
							<section>
								<div class="ventana">
								<table id="tabla_inicio" class="display table table-striped table-bordered table-responsive " cellspacing="0" width="100%">
									
									<!--      -->
							

								</table>
								</div>
							</section>
						</div>		        	

		        
			</div>
		</div>

	</div>
	

<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="margin-top:70px !important">
        <div class="modal-content"></div>
    </div>
</div>	


<?php $this->load->view( 'footer' ); ?>
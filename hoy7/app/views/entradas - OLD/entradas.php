<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
	
<div class="container">
	<div class="row">
		<div class="col-sm-8 col-md-8"><h4>Movimientos de entradas</h4></div>
	</div>
	<div class="row">
		<div class="col-md-3"></div>

			<div class="col-md-6">
				<a href="<?php echo base_url(); ?>recepciones" type="button" class="btn btn-primary btn-lg btn-block">Recepción</a>
			</div>

		<div class="col-md-3"></div>
	</div>
	<br>

	<div class="row">
		<div class="col-md-3"></div>
			<div class="col-md-6">
				<a href="<?php echo base_url(); ?>devolucion_venta" type="button" class="btn btn-primary btn-lg btn-block">Devolución de ventas</a>
			</div>
		<div class="col-md-3"></div>
	</div>
	<br>	
	<div class="row">
		<div class="col-md-3"></div>
			<div class="col-md-6">
				<a href="<?php echo base_url(); ?>transferencia_recibida" type="button" class="btn btn-primary btn-lg btn-block" >Transferencias recibidas</a>
			</div>
		<div class="col-md-3"></div>
	</div>
	<br>	
	<div class="row">
		<div class="col-md-3"></div>
			<div class="col-md-6">
				<a href="<?php echo base_url(); ?>ajuste_positivo" type="button" class="btn btn-primary btn-lg btn-block" >Ajustes Positivos</a>
			</div>
		<div class="col-md-3"></div>
	</div>	

	<br>
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<a href="<?php echo base_url(); ?>" type="button" class="btn btn-danger btn-lg btn-block"><i class="glyphicon glyphicon-backward"></i> Regresar 

			</a>
		</div>
		<div class="col-md-3"></div>
	</div>	

</div>
<?php $this->load->view( 'footer' ); ?>
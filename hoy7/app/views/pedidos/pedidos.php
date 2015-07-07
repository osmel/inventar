<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<div class="container margenes">
		<div class="panel panel-primary">
			<div class="panel-heading">Gestión de pedidos</div>
			<div class="panel-body">
				
		<div class="container row">		
 


		<div class="table-responsive">
			<br>
			<h4>Pedidos de vendedores</h4>	
			<br>			
				<div class="notif-bot-vendedor"></div>
			<section>
				<table id="tabla_apartado" class="display table table-striped table-bordered table-responsive " cellspacing="0" width="100%">

				</table>
			</section>
		</div>

		<div class="table-responsive">
			<br>
			<h4>Pedidos de tiendas</h4>	
			<br>			
			   <div class="notif-bot-tienda"></div>
			<section>
				<table id="tabla_pedido" class="display table table-striped table-bordered table-responsive " cellspacing="0" width="100%">

				</table>
			</section>
		</div>		


		<div class="table-responsive">
			<br>
			<h4>Historico de Pedidos</h4>	
			<br>			

			<section>
				<table id="tabla_pedido_completado" class="display table table-striped table-bordered table-responsive " cellspacing="0" width="100%">

				</table>
			</section>
		</div>		

	
</div>
<hr>
<div class="col-md-12">	
<div class="row">
	<div class="col-sm-8 col-md-8"></div>

	<div class="col-sm-4 col-md-4">
		<a href="<?php echo base_url(); ?>" type="button" class="btn btn-danger btn-block">Regresar</a>
	</div>	
	
</div>
</div>
</div>
</div>

<div class="modal fade bs-example-modal-lg" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>	



<?php $this->load->view( 'footer' ); ?>
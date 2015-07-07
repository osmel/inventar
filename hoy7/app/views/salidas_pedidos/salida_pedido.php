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
?>	
<div class="container margenes">
<div class="panel panel-primary">
<div class="panel-heading">Generar Pedidos</div>
<div class="panel-body">				
<div class="row">
	<div class="col-md-2">
		<fieldset disabled>
		<div class="form-group">
			<label for="fecha">Fecha</label>
			<div>
				<input value="<?php echo $fecha_hoy; ?>"  type="text" class="form-control" id="fecha" name="fecha" placeholder="Fecha">
			</div>
		</div>
		</fieldset>	
	</div>
	<div class="col-md-2">
		<fieldset disabled>
			<div class="form-group">
				<label for="movimiento">No. Movimiento</label>
				<div>
					<input type="text" value="<?php echo $consecutivo->consecutivo+1; ?>" class="form-control" id="movimiento" name="movimiento" placeholder="No. Movimiento">
				</div>
			</div>
		</fieldset>			
	</div>
	
</div>
<br><br>
<div class="row">					
	<div class="col-md-12">	
		<div class="table-responsive">
		<div class="notif-bot-pedidos"></div>
		<section>
			<table id="pedido_entrada" class="display table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th style="width:25%;">Código</th>
					<th style="width:15%;">Nombre tela</th>
					<th style="width:15%;">Color</th>
					<th style="width:5%;">Cantidad</th>
					<th style="width:5%;">Ancho</th>
					<th style="width:5%;">No. Movimiento Entrada</th>			
					<th style="width:15%;">Proveedor</th>
					<th style="width:5%;">Lote</th>
					<th style="width:15%;">Agregar</th>


				</tr>
			</thead>
			</table>
		</section>
		</div>			
	</div>
</div>
<br><br>

<div class="row">					
	<div class="col-md-12">		
		<br>
		<h4>Histórico de Pedidos</h4>	
		<br>	
		<div class="table-responsive">
			<section>
				<table id="pedido_salida" class="display table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th style="width:25%;">Código</th>
							<th style="width:15%;">Nombre tela</th>
							<th style="width:15%;">Color</th>
							<th style="width:5%;">Cantidad</th>
							<th style="width:5%;">Ancho</th>
							<th style="width:5%;">No. Movimiento Entrada</th>			
							<th style="width:15%;">Proveedor</th>
							<th style="width:5%;">Lote</th>
							<th style="width:15%;">Quitar</th>
						</tr>
					</thead>
				</table>
			</section>
		</div>
	</div>
</div>
<br>
<div class="col-md-12">	
	<div class="row">
		<div class="col-sm-4 col-md-4">
		</div>
		<div class="col-sm-4 col-md-4">
		<a href="<?php echo base_url(); ?>" type="button" class="btn btn-danger btn-block">Regresar</a>
		</div>

			<div class="col-sm-4 col-md-4">
				<button id="conf_pedido" type="button"  class="btn btn-success btn-block">
					<span class="glyphicon glyphicon-add">Confirmación de pedidos</span>
				</button>
			</div>

	</div>
</div>
</div>
</div>
</div>
<?php $this->load->view( 'footer' ); ?>
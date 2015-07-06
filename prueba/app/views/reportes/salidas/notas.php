<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>

<?php
 	if (!isset($retorno)) {
      	$retorno ="reportes";
    }
?>   
<div class="container margenes">
		<div class="container margenes">
			<div class="panel panel-primary">
			<div class="panel-heading">Listado de salidas</div>
			<div class="panel-body">	
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-responsive tabla_ordenadas" >
					<thead>	
						<tr>
							<th class="text-center cursora" width="15%" style="width:15%">Movimiento  <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="30%">Cliente  <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="30%">Cargador  <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="20%">Fecha  <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="25%">Factura  <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center " width="20%"><strong>Detalles</strong></th>
						</tr>
					</thead>		
					<?php if ( isset($salidas ) && !empty($salidas ) ): ?>
						<?php foreach( $salidas  as $salida  ): ?>
							<tr>
								
								<td class="text-center"><?php echo $salida->mov_salida ; ?></td>
								<td class="text-center"><?php echo $salida->cliente ; ?></td>
								<td class="text-center"><?php echo $salida->cargador; ?></td>
								<td class="text-center"><?php echo $salida->fecha ; ?></td>
								<td class="text-center"><?php echo $salida->factura ; ?></td>
								 <td>
									<a style="  padding: 1px 0px 1px 0px;" href="<?php echo base_url(); ?>detalle_salidas/<?php echo base64_encode($salida->mov_salida); ?>/<?php echo base64_encode($salida->cliente); ?>/<?php echo base64_encode($salida->cargador); ?>" 
									type="button" class="btn btn-success btn-block">
										Detalles
									</a>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
							<tr>
								<td colspan="5">No existen salidas</td>
							</tr>
					<?php endif; ?>						

				</table>
			</div>

			</div>
		</div>




		

	
<hr>
<div class="col-md-12">	
		<div class="row">

			<div class="col-md-9"></div>
			<div class="col-md-3">
				<a href="<?php echo base_url(); ?><?php echo $retorno; ?>" class="btn btn-danger btn-block"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
			</div>
		</div>
</div>
</div>
</div>
<?php $this->load->view( 'footer' ); ?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/sistema.js"></script>
<?php
 	if (!isset($retorno)) {
      	$retorno ="catalogos";
    }
?>    

	<div class="container">
		<br>
		<div class="row">
			<div class="col-md-3">
				<a href="<?php echo base_url(); ?>nuevo_composicion" type="button" class="btn btn-success btn-block">Nueva composición</a>
			</div>
		</div>
		<br>
		<div class="container row">
		<div class="panel panel-primary">
			<div class="panel-heading">Listado de composiciones</div>
			<div class="panel-body">
			<div class="col-md-12">				
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-responsive tabla_ordenadas" >
					<thead>	
						<tr>
							<th class="text-center cursora" style="width:90%">Composición  <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center" style="width:5%"><strong>Editar</strong></th>
							<th class="text-center" style="width:5%"><strong>Eliminar</strong></th>

						</tr>
					</thead>		
					<?php if ( isset($composiciones ) && !empty($composiciones ) ): ?>
						<?php foreach( $composiciones  as $composicion  ): ?>
							<tr>
								
								<td class="text-center"><?php echo $composicion ->composicion ; ?></td>
								 <td>
									<a href="<?php echo base_url(); ?>editar_composicion/<?php echo $composicion ->id; ?>" type="button" 
									class="btn btn-warning btn-sm btn-block" >
										<span class="glyphicon glyphicon-edit"></span>
									</a>
								</td>
								<td>
									<a href="<?php echo base_url(); ?>eliminar_composicion/<?php echo $composicion ->id; ?>/<?php echo base64_encode($composicion ->composicion ) ; ?>"  
										class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalMessage">
										<span class="glyphicon glyphicon-remove"></span>
										
									</a>
								</td>						
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
							<tr>
								<td colspan="5">No existen composiciones </td>
							</tr>
					<?php endif; ?>						

				</table>
			</div>

			</div>
		</div>
		</div>
		<br>
		<div class="row">

			<div class="col-md-9"></div>
			<div class="col-md-3">
				<a href="<?php echo base_url(); ?>catalogos" class="btn btn-danger btn-block"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
			</div>
		</div>
	</div>

<div class="modal fade bs-example-modal-lg" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>	


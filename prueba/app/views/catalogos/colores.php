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
				<a href="<?php echo base_url(); ?>nuevo_color" type="button" class="btn btn-success btn-block">Nuevo color</a>
			</div>
		</div>
		<br>
		<div class="container row">
		<div class="panel panel-primary">
			<div class="panel-heading">Listado de colores</div>
			<div class="panel-body">
			<div class="col-md-12">
				
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-responsive tabla_ordenadas" >
					<thead>	
						<tr>
							<th class="text-center cursora" width="70%">Color   <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="70%">Muestra   <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center " width="10%"><strong>Editar</strong></th>
							<th class="text-center " width="10%"><strong>Eliminar</strong></th>

						</tr>
					</thead>		
					<?php if ( isset($colores) && !empty($colores  ) ): ?>
						<?php foreach( $colores   as $color   ): ?>
							<tr>
								
								<td class="text-center"><?php echo $color->color  ; ?></td>
								<td>
										<div style="background-color:#<?php echo $color->hexadecimal_color; ?>;display:block;width:15px;height:15px;margin:0 auto;"></div>
								</td>								
								 <td>
									<a href="<?php echo base_url(); ?>editar_color/<?php echo $color->id; ?>" type="button" 
									class="btn btn-warning btn-sm btn-block" >
										<span class="glyphicon glyphicon-edit"></span>
									</a>
								</td>
								<td>
									<a href="<?php echo base_url(); ?>eliminar_color/<?php echo $color->id; ?>/<?php echo base64_encode($color->color) ; ?>/<?php echo base64_encode($color->hexadecimal_color) ; ?>"  
										class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalMessage">
										<span class="glyphicon glyphicon-remove"></span>
									</a>
								</td>						
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
							<tr>
								<td colspan="5">No existen colores  </td>
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
				<a href="<?php echo base_url(); ?><?php echo $retorno; ?>" class="btn btn-danger btn-block"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
			</div>
		</div>
	</div>

<div class="modal fade bs-example-modal-lg" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>	


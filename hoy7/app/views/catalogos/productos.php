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
				<a href="<?php echo base_url(); ?>nuevo_producto" type="button" class="btn btn-success btn-block">Nuevo producto</a>
			</div>
		</div>
		<br>
		<div class="container row">
		<div class="panel panel-primary">
			<div class="panel-heading">Datos del Usuario</div>
			<div class="panel-body">
			<div class="col-md-12">
				<h4>Listado de productos</h4>
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-responsive tabla_ordenadas" >
					<thead>	
						<tr> 
							<th class="text-center cursora" width="15%">Nombre de Tela <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="10%">Referencia <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="6%">Mínimo <i class="glyphicon glyphicon-sort"></i></th>
							
							<th class="text-center cursora" width="15%">Imagen <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="15%">Nombre color <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="5%">color <i class="glyphicon glyphicon-sort"></i></th>
							

							<th class="text-center " width="5%"><strong>Editar</strong></th>
							<th class="text-center " width="5%"><strong>Eliminar</strong></th>
							<th class="text-center " width="5%"><strong>Cambio Precio</strong></th>

						</tr>
					</thead>		
					<?php if ( isset($productos) && !empty($productos) ): ?>
						<?php foreach( $productos as $producto ): ?>
							<tr>
								
								<td class="text-center"><?php echo $producto->descripcion; ?></td>
								<td class="text-center"><?php echo $producto->referencia; ?></td>
								<td class="text-center"><?php echo $producto->minimo; ?></td>
								<!-- <img src="<?php echo base_url(); ?>uploads/productos/thumbnail/<?php echo substr($producto->imagen,0,-4).'_thumb'.substr($producto->imagen,-4); ?>" border="0" width="75" height="75">-->	
								<td class="text-center">
									<img src="<?php echo base_url(); ?>uploads/productos/<?php echo $producto->imagen; ?>" border="0" width="75" height="75">
								</td>

								<td class="text-center"><?php echo $producto->nombre_color; ?></td>

								<td class="text-center">
									<div style="background-color:#<?php echo $producto->hexadecimal_color; ?>;display:block;width:15px;height:15px;margin:0 auto;"></div>
								</td>																														
								
								 <td>
									<a href="<?php echo base_url(); ?>editar_producto/<?php echo base64_encode($producto->id); ?>" type="button" 
									class="btn btn-warning btn-sm btn-block" >
										<span class="glyphicon glyphicon-edit"></span>
									</a>
								</td>
								<td>
									<a href="<?php echo base_url(); ?>eliminar_producto/<?php echo $producto->id; ?>/<?php echo base64_encode($producto->descripcion) ; ?>"  
										class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalMessage">
										<span class="glyphicon glyphicon-remove"></span>
										
									</a>
								</td>						
								<td>
									<a href="<?php echo base_url(); ?>cambiar_producto/<?php echo base64_encode($producto->id); ?>" type="button" 
									class="btn btn-warning btn-sm btn-block" >
										<span class="glyphicon glyphicon-edit"></span>
									</a>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
							<tr>
								<td colspan="8">No existen productos</td>
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
</div>
<div class="modal fade bs-example-modal-lg" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>	


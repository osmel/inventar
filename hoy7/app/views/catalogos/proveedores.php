<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/sistema.js"></script>
<?php
 	if (!isset($retorno)) {
      	$retorno ="catalogos";
    }


	  $perfil= $this->session->userdata('id_perfil'); 
	  $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
	  
	  if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) )  {
	  			$coleccion_id_operaciones = array();
	  } 	

?>	

	<div class="container">
		<br>
		<div class="row">
			<div class="col-md-3">
				<a href="<?php echo base_url(); ?>nuevo_proveedor" type="button" class="btn btn-success btn-block">Nuevo proveedor</a>
			</div>
		</div>
		<br>
		<div class="container row">
		<div class="panel panel-primary">
			<div class="panel-heading">Listado de proveedores</div>
			<div class="panel-body">
			<div class="col-md-12">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-responsive tabla_ordenadas" >
					<thead>	
						<tr>
							<th class="text-center cursora" width="15%">Código<i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="20%">Proveedor <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="15%">Teléfono<i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="15%">Actividad comercial <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center " width="5%"><strong>Editar</strong></th>
							<th class="text-center " width="5%"><strong>Eliminar</strong></th>

						</tr>
					</thead>		
					<?php if ( isset($proveedores) && !empty($proveedores) ): ?>
						<?php foreach( $proveedores as $proveedor ): ?>
							<tr>
								<td class="text-center"><?php echo $proveedor->codigo; ?></td>								
								<td class="text-center"><?php echo $proveedor->nombre; ?></td>
								<td class="text-center"><?php echo $proveedor->telefono; ?></td>


								<td class="text-center">


								



									<?php 
										$desabilitar = '';
										foreach ( $actividades as $actividad ){ 

											
											$activ_id_array =(json_decode($proveedor->coleccion_id_actividad) );				
											if (count($activ_id_array)==0) {  //si el valor esta vacio
												$activ_id_array = array();
											}
											if (!($activ_id_array)) {
												$activ_id_array = array();	
											}
											if (in_array($actividad->id, $activ_id_array)) {echo $actividad->actividad.'<br/>'; }
								   
									}



											//si el 8 no pertenece a la colleccion que tengo
											// o perfil no es 1
											//y actividad no esta en la colleccion que tengo 
											//pues entonces q desabilite ese	
									
									foreach ( $activ_id_array as $identifica ){ 
											if  ( (!( ( $perfil == 1 ) || (in_array(8, $coleccion_id_operaciones)) ) )
													  and (!(in_array($identifica+13, $coleccion_id_operaciones))) ) { 
												$desabilitar = 'disabled';
											}
									}				

									 ?>



								</td>
								

								 <td>
									<a href="<?php echo base_url(); ?>editar_proveedor/<?php echo $proveedor->codigo; ?>" type="button" 
									class="btn btn-warning btn-sm btn-block" >
										<span class="glyphicon glyphicon-edit"></span>
									</a>
								</td>
								<td>


									<fieldset <?php echo $desabilitar?> >
										<a href="<?php echo base_url(); ?>eliminar_proveedor/<?php echo $proveedor->codigo; ?>/<?php echo base64_encode($proveedor->nombre); ?>"  
											class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalMessage">
											<span class="glyphicon glyphicon-remove"></span>
										</a>
									</fieldset>	
									
								</td>						
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
							<tr>
								<td colspan="6">No existen proveedores</td>
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


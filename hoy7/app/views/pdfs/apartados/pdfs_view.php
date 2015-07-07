<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('header'); ?>
<?php 

 	if (!isset($retorno)) {
      	$retorno ="";
    }

  

$attr = array('class' => 'form-horizontal', 'id'=>'form_entradas1','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
echo form_open('pdfs/generar', $attr );
?>		
<div class="container">


		

			<div class="col-md-3" style="margin-top:20px">
				<?php if ($val_proveedor) { ?>
				<fieldset class="disabledme" disabled>							
				<?php } else { ?>
				<fieldset class="disabledme">						
				<?php } ?>
					<div class="form-group" style="margin-right: 0px; margin-left: 0px;">
						<label for="descripcion">Cliente</label>
						<div class="input-group col-md-12 col-sm-12 col-xs-12">
							<?php if ($val_proveedor) { ?>
							<input identificador="" value="<?php echo $val_proveedor->nombre; ?>" type="text" name="editar_proveedor" idproveedor="3" class="buscar_proveedor form-control typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="Buscar Comprador...">
							<?php } else { ?>
							<input  identificador="" type="text" name="editar_proveedor" idproveedor="3" class="buscar_proveedor form-control typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="Buscar Comprador...">
							<?php } ?>
						</div>
					</div>
				</fieldset>	
			</div>


			<div class="col-md-12">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-responsive tabla_ordenadas" >
					<thead>	
						<tr>
							<th class="text-center cursora" style="width:45%">Código<i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" style="width:15%">Descripción <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" style="width:10%">Color<i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" style="width:10%">Cantidad<i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" style="width:10%">Ancho <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora">Lote<i class="glyphicon glyphicon-sort"></i></th>
							
						</tr>
					</thead>		

					<tbody>	
					<?php if ( isset($movimientos) && !empty($movimientos) ): ?>
						<?php foreach( $movimientos as $movimiento ): ?>
							<tr>
								<td class="text-center"><?php echo $movimiento->codigo; ?></td>								
								<td class="text-center"><?php echo $movimiento->id_descripcion; ?></td>								
								<td class="text-center">
									<div style="background-color:#<?php echo $movimiento->hexadecimal_color; ?>;display:block;width:15px;height:15px;margin:0 auto;"></div>
								</td>	
								<td class="text-center"><?php echo $movimiento->cantidad_um; ?> <?php echo $movimiento->medida; ?></td>
								
								<td class="text-center"><?php echo $movimiento->ancho; ?> cm</td>
								<td class="text-center"><?php echo $movimiento->id_lote; ?>-<?php echo $movimiento->consecutivo;?></td>
								

					

							</tr>
								
						<?php endforeach; ?>
					

					<?php else : ?>
							<tr class="noproducto">
								<td colspan="10">No se han agregado producto</td>
							</tr>

					<?php endif; ?>		

					</tbody>		
				</table>
			</div>

			</div>
		
		
		<br>
		<div class="row">

			<div class="col-md-4"></div>
			<div class="col-md-4">
				<a href="<?php echo base_url(); ?><?php echo $retorno; ?>" class="btn btn-danger btn-block">
					<i class="glyphicon glyphicon-backward"></i> Regresar
				</a>
			</div>

			<div class="col-sm-4 col-md-4" style="padding-bottom:15px">
				<a id="conf_apartado" type="button"  class="btn btn-success btn-block">
					Confirmación de Apartados
				</a>				
			</div>

		</div>	


</div>

<div class="modal fade bs-example-modal-lg" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>	


<?php echo form_close(); ?>

<?php $this->load->view('footer'); ?>



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

  
$hidden = array('id_movimiento'=>$num_mov); 
$attr = array('class' => 'form-horizontal', 'id'=>'form_entradas1','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
echo form_open('pdfs/generar', $attr,$hidden );
?>		
<div class="container margenes">
			<div class="panel panel-primary">
			<div class="panel-heading">Número de Movimiento: <?php echo $num_mov; ?></div>
			<div class="panel-body">		
					
					
				<div class="col-sm-6 col-md-6">
				</div>	
				<div class="col-sm-3 col-md-3">
					<label for="descripcion" class="col-sm-12 col-md-12"></label>
					<a href="<?php echo base_url(); ?>generar_etiquetas/<?php echo base64_encode($num_mov); ?>"  
						type="button" class="btn btn-success btn-block" target="_blank">Imprimir etiquetas
						
					</a>
				</div>
				<div class="col-sm-3 col-md-3">
					<label for="descripcion" class="col-sm-12 col-md-12"></label>
					<a href="<?php echo base_url(); ?>generar_notas/<?php echo base64_encode($num_mov); ?>"  
						type="button" class="btn btn-success btn-block" target="_blank">Imprimir nota
					</a>
				</div>



			<div class="col-md-12" style="margin-top:20px;">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-responsive tabla_ordenadas" >
					<thead>	
						<tr>
							<th class="text-center cursora" style="width:15%">Código<i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" style="width:15%">Descripción <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" style="width:8%">Color<i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" style="width:9%">Medida<i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" style="width:7%">Ancho <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" style="width:15%">Proveedor<i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" style="width:5%">Lote<i class="glyphicon glyphicon-sort"></i></th>
							
						</tr>
					</thead>		

					<tbody>	
					<?php if ( isset($movimientos) && !empty($movimientos) ): ?>
						<?php foreach( $movimientos as $movimiento ): ?>
							<tr style="color:<?php echo $movimiento->color_devolucion?>">
								<td class="text-center"><?php echo $movimiento->codigo; ?></td>								
								<td class="text-center"><?php echo $movimiento->id_descripcion; ?></td>

								<td class="text-center">
									<div style="background-color:#<?php echo $movimiento->hexadecimal_color; ?>;display:block;width:15px;height:15px;margin:0 auto;"></div>
								</td>	
								<td class="text-center"> <?php echo $movimiento->cantidad_um; ?> <?php echo $movimiento->medida; ?></td>
								<td class="text-center"><?php echo $movimiento->ancho; ?> cm</td>
								<td class="text-center"><?php echo $movimiento->nombre; ?></td>
								<td class="text-center"><?php echo $movimiento->id_lote; ?> - <?php echo $movimiento->consecutivo; ?></td>
								

					

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

		
		
		
		<br>
		<div class="row">

			<div class="col-md-9"></div>
			<div class="col-md-3" style="margin-bottom:25px;">
				<a href="<?php echo base_url(); ?><?php echo $retorno; ?>" class="btn btn-danger btn-block"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
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



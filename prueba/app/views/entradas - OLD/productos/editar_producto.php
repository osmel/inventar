<meta charset="UTF-8">
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view('header'); ?>
<?php 

 	if (!isset($retorno)) {
      	$retorno ="productos";
    }

  $hidden = array('producto_ant'=>$producto_ant);
  $attr = array('class' => 'form-horizontal', 'id'=>'form_catalogos','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
  echo form_open('validacion_edicion_producto', $attr,$hidden);
?>	
<div class="container">
		<br>
	<div class="row">
		<div class="col-sm-8 col-md-8"><h4>Edición de producto</h4></div>
	</div>
	<br>
	<div class="container row">


		<div class="panel panel-primary">
			<div class="panel-heading">Datos del producto</div>
			<div class="panel-body">
				<div class="col-sm-6 col-md-6">

					<div class="form-group">
						<label for="producto" class="col-sm-12 col-md-12">Producto</label>
						<div class="col-sm-12 col-md-12">
							<?php 
								$nomb_nom='';
								if (isset($producto->producto)) 
								 {	$nomb_nom = $producto->producto;}
							?>
							<input value="<?php echo  set_value('producto',$nomb_nom); ?>" type="text" class="form-control" id="producto" name="producto" placeholder="Producto">
						</div>
					</div>

					<div class="form-group">
						<label for="descripcion" class="col-sm-12 col-md-12">Descripción</label>
						<div class="col-sm-12 col-md-12">
							<?php 
								$nomb_nom='';
								if (isset($producto->descripcion)) 
								 {	$nomb_nom = $producto->descripcion;}
							?>
							<input value="<?php echo  set_value('descripcion',$nomb_nom); ?>" type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripción">
						</div>
					</div>

					<div class="form-group">
						<label for="color" class="col-sm-12 col-md-12">Color</label>
						<div class="col-sm-12 col-md-12">
							<?php 
								$nomb_nom='';
								if (isset($producto->color)) 
								 {	$nomb_nom = $producto->color;}
							?>
							<input value="<?php echo  set_value('color',$nomb_nom); ?>" type="text" class="form-control" id="color" name="color" placeholder="Color">
						</div>
					</div>

					<div class="form-group">
						<label for="ancho" class="col-sm-12 col-md-12">Ancho</label>
						<div class="col-sm-12 col-md-12">
							<?php 
								$nomb_nom='';
								if (isset($producto->ancho)) 
								 {	$nomb_nom = $producto->ancho;}
							?>
							<input value="<?php echo  set_value('ancho',$nomb_nom); ?>" type="text" class="form-control" id="ancho" name="ancho" placeholder="Ancho">
						</div>
					</div>

					<div class="form-group">
						<label for="composicion" class="col-sm-12 col-md-12">Composición</label>
						<div class="col-sm-12 col-md-12">
							<?php 
								$nomb_nom='';
								if (isset($producto->composicion)) 
								 {	$nomb_nom = $producto->composicion;}
							?>
							<input value="<?php echo  set_value('composicion',$nomb_nom); ?>" type="text" class="form-control" id="composicion" name="composicion" placeholder="Composición">
						</div>
					</div>

					<div class="form-group">
						<label for="cant_metro" class="col-sm-12 col-md-12">Cantidad en metro</label>
						<div class="col-sm-12 col-md-12">
							<?php 
								$nomb_nom='';
								if (isset($producto->cant_metro)) 
								 {	$nomb_nom = $producto->cant_metro;}
							?>
							<input value="<?php echo  set_value('cant_metro',$nomb_nom); ?>" type="text" class="form-control" id="cant_metro" name="cant_metro" placeholder="Cantidad en metro">
						</div>
					</div>

					<div class="form-group">
						<label for="cant_peso" class="col-sm-12 col-md-12">Cantidad en peso</label>
						<div class="col-sm-12 col-md-12">
							<?php 
								$nomb_nom='';
								if (isset($producto->cant_peso)) 
								 {	$nomb_nom = $producto->cant_peso;}
							?>
							<input value="<?php echo  set_value('cant_peso',$nomb_nom); ?>" type="text" class="form-control" id="cant_peso" name="cant_peso" placeholder="Cantidad en peso">
						</div>
					</div>					



				</div>


				<div class="col-sm-6 col-md-6">


					<div class="form-group">
						<label for="precio_metro" class="col-sm-12 col-md-12">Precio en metro</label>
						<div class="col-sm-12 col-md-12">
							<?php 
								$nomb_nom='';
								if (isset($producto->precio_metro)) 
								 {	$nomb_nom = $producto->precio_metro;}
							?>
							<input value="<?php echo  set_value('precio_metro',$nomb_nom); ?>" type="text" class="form-control" id="precio_metro" name="precio_metro" placeholder="Precio en metro">
						</div>
					</div>
					<div class="form-group">
						<label for="precio_peso" class="col-sm-12 col-md-12">Precio en peso</label>
						<div class="col-sm-12 col-md-12">
							<?php 
								$nomb_nom='';
								if (isset($producto->precio_peso)) 
								 {	$nomb_nom = $producto->precio_peso;}
							?>
							<input value="<?php echo  set_value('precio_peso',$nomb_nom); ?>" type="text" class="form-control" id="precio_peso" name="precio_peso" placeholder="Precio en peso">
						</div>
					</div>



					<div class="form-group">
						<label for="ubicacion" class="col-sm-12 col-md-12">Ubicación dentro del almacén</label>
						<div class="col-sm-12 col-md-12">
							<?php 
								$nomb_nom='';
								if (isset($producto->ubicacion)) 
								 {	$nomb_nom = $producto->ubicacion;}
							?>
							<input value="<?php echo  set_value('ubicacion',$nomb_nom); ?>" type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Ubicación">
						</div>
					</div>

					<div class="form-group">
						<label for="observacion" class="col-sm-12 col-md-12">Observaciones</label>
						<div class="col-sm-12 col-md-12">
							<?php 
								$nomb_nom='';
								if (isset($producto->observacion)) 
								 {	$nomb_nom = $producto->observacion;}
							?>	
							<textarea class="form-control" name="observacion" id="observacion" rows="8" placeholder="Observaciones"><?php echo  set_value('observacion',$nomb_nom); ?></textarea>
						</div>
					</div>	


				</div>


			</div>
		</div>
		






		
		<br>

		<div class="row">
			<div class="col-sm-4 col-md-4"></div>
			<div class="col-sm-4 col-md-4">
				<a href="<?php echo base_url(); ?><?php echo $retorno; ?>" type="button" class="btn btn-danger btn-block">Cancelar</a>
			</div>
			<div class="col-sm-4 col-md-4">
				<input style="padding:8px;" type="submit" class="btn btn-success btn-block" value="Guardar"/>
			</div>
		</div>
		
	</div></div>
  <?php echo form_close(); ?>
<?php $this->load->view('footer'); ?>
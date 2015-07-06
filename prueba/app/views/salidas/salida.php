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

<?php if (isset($val_proveedor->nombre)) { 
	 $mi_proveedor = $val_proveedor->nombre;
  } else {
  	 $mi_proveedor = '';
  }
  ?>

<input type="hidden" id="id_proveedor" value="<?php echo $mi_proveedor; ?>">

<div class="container margenes">
<div class="panel panel-primary">
<div class="panel-heading">Registro de Salidas</div>
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
	<div class="col-md-3">
		<?php if ($val_proveedor) { ?>
		<fieldset class="disabledme" disabled>							
		<?php } else { ?>
		<fieldset class="disabledme">						
		<?php } ?>
			<div class="form-group">
				<label for="descripcion">Cliente</label>
				<div class="input-group col-md-12 col-sm-12 col-xs-12">
					<?php if ($val_proveedor) { ?>
					<input identificador="" id="editar_proveedor" value="<?php echo $val_proveedor->nombre; ?>" type="text" name="editar_proveedor" idproveedor="2" class="buscar_proveedor form-control typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="Buscar Cliente...">
					<?php } else { ?>
					<input  identificador="" id="editar_proveedor" type="text" name="editar_proveedor" idproveedor="2" class="buscar_proveedor form-control typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="Buscar Cliente...">
					<?php } ?>
				</div>
			</div>
		</fieldset>	
	</div>
	<div class="col-md-3">
		<?php if ($val_proveedor) { ?>
		<fieldset class="disabledme" disabled>							
		<?php } else { ?>
		<fieldset class="disabledme">						
		<?php } ?>
			<div class="form-group">
				<label for="descripcion">Cargador</label>
				<div class="input-group col-md-12 col-sm-12 col-xs-12">
					<?php if ($val_proveedor) { ?>
					<input value="<?php echo $val_proveedor->cargador; ?>" type="text" name="editar_cargador" class="buscar_cargador form-control typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="Buscar Cargador...">
					<?php } else { ?>
					<input  type="text" name="editar_cargador" class="buscar_cargador form-control typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="Buscar Cargador...">
					<?php } ?>
				</div>
			</div>
		</fieldset>	
	</div>
	<div class="col-md-2">
		<?php if ($val_proveedor) { ?>
		<fieldset class="disabledme" disabled>							
		<?php } else { ?>
		<fieldset class="disabledme">						
		<?php } ?>
			<div class="form-group">
			<label for="factura">Factura/Remisión</label>
				<div>
					<?php if ($val_proveedor) { ?>
					<input value="<?php echo $val_proveedor->factura; ?>" type="text" class="form-control" id="factura" name="factura" placeholder="Factura">							
					<?php } else { ?>
					<input type="text" class="form-control" id="factura" name="factura" placeholder="Factura">
					<?php } ?>				
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
			<table id="tabla_entrada" class="display table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
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
	<div class="col-sm-12 col-md-12">
		<input style="padding:8px;" type="submit" class="btn btn-success btn-block" value="Escanear producto"/>
	</div>
</div>
<div class="row">					
	<div class="col-md-12">		
		<br>
		<h4>Orden de salida</h4>	
		<br>	
		<div class="table-responsive">
			<section>
				<table id="tabla_salida" class="display table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
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

			<!--	
				<a href="<?php echo base_url(); ?>eliminar_actividad_comercial/<?php echo $actividad ->id; ?>/<?php echo base64_encode($actividad ->actividad ) ; ?>"  
					class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalMessage">
					<span class="glyphicon glyphicon-remove"></span>
					
				</a>
			-->

				<button id="proc_salida" type="button"  class="btn btn-success btn-block">
					<span class="">Procesar Salida</span>
				</button>
			    
			</div>


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




<!-- Modal -->
<div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 	<div class="modal-dialog">
        <div class="modal-content">
    
			  <div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			    <h3 id="myModalLabel">Modal header</h3>
			  </div>
			  <div class="modal-body">
			    <p>One fine body…</p>
			  </div>
			  <div class="modal-footer">
			    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			    <button class="btn btn-primary">Save changes</button>
			  </div>

		</div>  
	</div>	  
</div>


<div id="miModal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Modal header</h3>
  </div>
  <div class="modal-body">
    <p>One fine body…</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Save changes</a>
  </div>
</div>

<?php $this->load->view( 'footer' ); ?>
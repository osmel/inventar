<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>

<div class="container margenes">
	<div class="panel panel-primary">
		<div class="panel-heading">Buscador de productos</div>
			<div class="container">	
			<br>	
				<div class="row">	
					<div class="col-md-12">	
					
						<div class="table-responsive">

                           <div class="col-md-4"><span> Apartado Individual</span><div style="margin-right: 15px;float:left;background-color:#ab1d1d;width:15px;height:15px;"></div> </div>
                           <div class="col-md-4"><span> Apartado Confirmado</span><div style="margin-right: 15px;float:left;background-color:#f1a914;width:15px;height:15px;"></div></div>
						   <div class="col-md-4"><span> Disponibilidad Salida</span><div style="margin-right: 15px;float:left;background-color:#14b80f;width:15px;height:15px;"></div></div>
						   <hr/>

   						   	<div class="notif-bot-pedidos"></div>
							<section>
								<table id="tabla_home" class="display table table-striped table-bordered table-responsive " cellspacing="0" width="100%">
									<!--
	
									-->
							

								</table>
							</section>
						</div>


                

					</div>	
				</div>	
				<br>
				<hr>
				
		
				<div class="row">						
					<div class="col-md-6">								
					</div>	
					<div class="col-md-2">	
						<span id="pieza">Total de piezas: 6</span>			
					</div>	
					<div class="col-md-2">	
						<span id="metro">Total de mtrs: 450.5</span>			
					</div>	
					<div class="col-md-2">	
						<span id="kg" >Total de Kgs: 6</span>				
					</div>	
				</div>			

				<div class="row">						
					<div class="col-md-6">								
					</div>	
					<div class="col-md-2">	
						<span id="total_pieza">Total de piezas: 6</span>			
					</div>	
					<div class="col-md-2">	
						<span id="total_metro">Total de mtrs: 450.5</span>			
					</div>	
					<div class="col-md-2">	
						<span id="total_kg" >Total de Kgs: 6</span>				
					</div>	
				</div>

				<hr>					
				<div class="row">
					<div class="col-sm-2 col-md-2 marginbuttom">
						<button id="existencia_home" type="button" class="btn btn-danger btn-block">Existencias</button>
					</div>
					<div class="col-sm-2 col-md-2 marginbuttom">
						<button  id="devolucion_home" type="button" class="btn btn-danger btn-block">Defecto/devoluciones</button>
					</div>
					<div class="col-sm-2 col-md-2 marginbuttom">
						<button  id="apartado_home" type="button" class="btn btn-danger btn-block">Apartados</button>
					</div>
					<div class="col-sm-2 col-md-2 marginbuttom">
						<button  id="cero_home" type="button" class="btn btn-danger btn-block">Existencias Cero</button>
					</div>
					<div class="col-sm-2 col-md-2 marginbuttom">
						<button  id="baja_home" type="button" class="btn btn-danger btn-block">Existencias Bajas</button>
					</div>
						<input type="hidden" id="botones" name="botones" value="existencia">
				</div>
				<br><br>
			</div>
	</div>
</div>
<?php $this->load->view( 'footer' ); ?>
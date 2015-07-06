<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<style>

</style>
	<div class="container margenes">
		<div class="col-sm-12 col-md-12 control blanco" style="margin-bottom:10px;padding: 10px 10px 10px 10px;">
			<div class="col-sm-4 col-md-4">
				<div class="form-group">
					<label for="descripcion" class="col-sm-12 col-md-12">Buscador</label>
					<div class="col-sm-12 col-md-12">
						<input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Proveedor">
					</div>
				</div>
			</div>
			<div class="col-sm-2 col-md-4 col-xs-12">
			</div>
			<div class=" col-sm-6 col-md-2">
				<div class="form-group">
					<label for="descripcion">Producto</label>					
						<select class="form-control">
							<option>Todos</option>
							<option>Normal</option>
							<option>Devolución</option>
							<option>Pieza con defecto</option>
						</select>					
				</div>
			</div>
			<div class="col-sm-6 col-md-2">
				<div class="form-group">
					<label for="descripcion">Color</label>					
						<select class="form-control">
							<option>Todos</option>
							<option>Impacto Textil</option>
							<option>Ditecsa</option>				
						</select>					
				</div>
			</div>
		</div>		
		<div class="col-sm-12 col-md-12 control sin-margen" style="margin-bottom:10px">						
			<div class="container">
		        <div class="row">    
		            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
		                <a class="thumbnail col-md-12 col-lg-12 col-xs-12" data-toggle="modal" data-target="#myModal">
		                    <img class="img-responsive" src="http://placehold.it/400x300" alt="">
		                    <span class="col-xs-12 col-md-12 col-lg-12 nombre">Ambassador</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 color">Azul cielo</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 text-right cantidadtotal">250 mtrs disponibles</span>
		                </a>
		            </div>
		            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
		                <a class="thumbnail col-md-12 col-lg-12 col-xs-12" data-toggle="modal" data-target="#myModal">
		                    <img class="img-responsive" src="http://placehold.it/400x300" alt="">
		                    <span class="col-xs-12 col-md-12 col-lg-12 nombre">Ambassador</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 color">Coral</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 text-right cantidadtotal">80 mtrs disponibles</span>
		                    <!-- <span class="col-xs-12 col-md-6 col-lg-6 text-right">Disponible</span> -->
		                </a>
		            </div>
		            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
		                <a class="thumbnail col-md-12 col-lg-12 col-xs-12" data-toggle="modal" data-target="#myModal">
		                    <img class="img-responsive" src="http://placehold.it/400x300" alt="">
		                    <span class="col-xs-12 col-md-12 col-lg-12 nombre">Ambassador</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 color">Gris</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 text-right cantidadtotal">130 mtrs disponibles</span>
		                    <!-- <span class="col-xs-12 col-md-6 col-lg-6 text-right">Disponible</span> -->
		                </a>
		            </div>
		            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
		                <a class="thumbnail col-md-12 col-lg-12 col-xs-12" data-toggle="modal" data-target="#myModal">
		                    <img class="img-responsive" src="http://placehold.it/400x300" alt="">
		                    <span class="col-xs-12 col-md-12 col-lg-12 nombre">Ambassador</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 color">Rosa</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 text-right cantidadtotal">25 mtrs disponibles</span>
		                    <!-- <span class="col-xs-12 col-md-6 col-lg-6 text-right">Disponible</span> -->
		                </a>
		            </div>
		            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
		                <a class="thumbnail col-md-12 col-lg-12 col-xs-12" data-toggle="modal" data-target="#myModal">
		                    <img class="img-responsive" src="http://placehold.it/400x300" alt="">
		                    <span class="col-xs-12 col-md-12 col-lg-12 nombre">Ambassador</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 color">Azul cielo</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 text-right cantidadtotal">65 mtrs disponibles</span>
		                    <!-- <span class="col-xs-12 col-md-6 col-lg-6 text-right">Disponible</span> -->
		                </a>
		            </div>
		            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
		                <a class="thumbnail col-md-12 col-lg-12 col-xs-12" data-toggle="modal" data-target="#myModal">
		                    <img class="img-responsive" src="http://placehold.it/400x300" alt="">
		                    <span class="col-xs-12 col-md-12 col-lg-12 nombre">Ambassador</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 color">Azul cielo</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 text-right cantidadtotal">250 mtrs disponibles</span>
		                    <!-- <span class="col-xs-12 col-md-6 col-lg-6 text-right">Disponible</span> -->
		                </a>
		            </div>
		            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
		                <a class="thumbnail col-md-12 col-lg-12 col-xs-12" data-toggle="modal" data-target="#myModal">
		                    <img class="img-responsive" src="http://placehold.it/400x300" alt="">
		                    <span class="col-xs-12 col-md-12 col-lg-12 nombre">Ambassador</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 color">Coral</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 text-right cantidadtotal">80 mtrs disponibles</span>
		                    <!-- <span class="col-xs-12 col-md-6 col-lg-6 text-right">Disponible</span> -->
		                </a>
		            </div>
		            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
		                <a class="thumbnail col-md-12 col-lg-12 col-xs-12" data-toggle="modal" data-target="#myModal">
		                    <img class="img-responsive" src="http://placehold.it/400x300" alt="">
		                    <span class="col-xs-12 col-md-12 col-lg-12 nombre">Ambassador</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 color">Gris</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 text-right cantidadtotal">130 mtrs disponibles</span>
		                    <!-- <span class="col-xs-12 col-md-6 col-lg-6 text-right">Disponible</span> -->
		                </a>
		            </div>
		            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
		                <a class="thumbnail col-md-12 col-lg-12 col-xs-12" data-toggle="modal" data-target="#myModal">
		                    <img class="img-responsive" src="http://placehold.it/400x300" alt="">
		                    <span class="col-xs-12 col-md-12 col-lg-12 nombre">Ambassador</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 color">Rosa</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 text-right cantidadtotal">25 mtrs disponibles</span>
		                    <!-- <span class="col-xs-12 col-md-6 col-lg-6 text-right">Disponible</span> -->
		                </a>
		            </div>
		            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
		                <a class="thumbnail col-md-12 col-lg-12 col-xs-12" data-toggle="modal" data-target="#myModal">
		                    <img class="img-responsive" src="http://placehold.it/400x300" alt="">
		                    <span class="col-xs-12 col-md-12 col-lg-12 nombre">Ambassador</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 color">Azul cielo</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 text-right cantidadtotal">65 mtrs disponibles</span>
		                    <!-- <span class="col-xs-12 col-md-6 col-lg-6 text-right">Disponible</span> -->
		                </a>
		            </div>
		            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
		                <a class="thumbnail col-md-12 col-lg-12 col-xs-12" data-toggle="modal" data-target="#myModal">
		                    <img class="img-responsive" src="http://placehold.it/400x300" alt="">
		                    <span class="col-xs-12 col-md-12 col-lg-12 nombre">Ambassador</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 color">Azul cielo</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 text-right cantidadtotal">65 mtrs disponibles</span>
		                    <!-- <span class="col-xs-12 col-md-6 col-lg-6 text-right">Disponible</span> -->
		                </a>
		            </div>
		            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
		                <a class="thumbnail col-md-12 col-lg-12 col-xs-12" data-toggle="modal" data-target="#myModal">
		                    <img class="img-responsive" src="http://placehold.it/400x300" alt="">
		                    <span class="col-xs-12 col-md-12 col-lg-12 nombre">Ambassador</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 color">Azul cielo</span>
		                    <span class="col-xs-12 col-md-12 col-lg-12 text-right cantidadtotal">65 mtrs disponibles</span>
		                    <!-- <span class="col-xs-12 col-md-6 col-lg-6 text-right">Disponible</span> -->
		                </a>
		            </div>
		        </div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header col-xs-12 col-md-12 col-lg-12">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
               Catálogo de productos
            </h4>
         </div>
         <div class="modal-body col-xs-12 col-md-12 col-lg-12">
         	<div class="col-xs-12 col-md-12 col-lg-12">         	
	            <img src="http://www.dcs.bbk.ac.uk/~keith/img/lab/400x400.png" style="width:350px" class="img-responsive col-xs-9 col-md-9 col-lg-9">
	         	<span class="col-xs-12 col-md-3 col-lg-3 nombre">Ambassador</span>
			    <span class="col-xs-12 col-md-3 col-lg-3 color">Azul cielo</span>
			    <span class="col-xs-12 col-md-3 col-lg-3 cantidadtotal">100% Poliester</span>
			    <span class="col-xs-12 col-md-3 col-lg-3 preciocatalogo">$500 pesos</span>
			</div>
			<div class="col-xs-12 col-md-12 col-lg-12" style="padding: 20px 10px 15px 15px;">  
			 <input id="ver_dis" style="padding:1px;" type="submit" class="btn btn-success btn-block" value="Ver Disponibilidad"/>
			</div>
			<div class="col-xs-12 col-md-12 col-lg-12 " id="cont_tab">      
				<table class="table table-striped table-bordered table-responsive tabla_ordenadas" style="max-height:200px;">
					<thead>	
						<tr>
							<th class="text-center cursora" width="15%">Código<i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="20%">Lote <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="10%">Metros<i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="5%">Ancho <i class="glyphicon glyphicon-sort"></i></th>
							<th class="text-center cursora" width="5%">Entrada<i class="glyphicon glyphicon-sort"></i></th>		
							<th class="text-center cursora" width="10%">Apartar<i class="glyphicon glyphicon-sort"></i></th>														
						</tr>
					</thead>		
						<td class="text-center">012556546546 1</td>	
						<td class="text-center">001</td>	
						<td class="text-center">150</td>	
						<td class="text-center">2</td>	
						<td class="text-center">20/10/14</td>
						<td class="text-center"><input style="padding:1px;" type="submit" class="btn btn-success btn-block" value="Apartar"/></td>	
					</tr>
					<tr>
						<td class="text-center">012556546546 1</td>	
						<td class="text-center">001</td>	
						<td class="text-center">150</td>	
						<td class="text-center">2</td>	
						<td class="text-center">20/10/14</td>
						<td class="text-center"><input style="padding:1px;" type="submit" class="btn btn-success btn-block" value="Apartar"/></td>
					</tr>
					<tr>
						<td class="text-center">012556546546 1</td>	
						<td class="text-center">001</td>	
						<td class="text-center">150</td>	
						<td class="text-center">2</td>	
						<td class="text-center">20/10/14</td>
						<td class="text-center"><input style="padding:1px;" type="submit" class="btn btn-success btn-block" value="Apartar"/></td>
					</tr>
					<tr>
						<td class="text-center">012556546546 1</td>	
						<td class="text-center">001</td>	
						<td class="text-center">150</td>	
						<td class="text-center">2</td>	
						<td class="text-center">20/10/14</td>	
						<td class="text-center"><input style="padding:1px;" type="submit" class="btn btn-success btn-block" value="Apartar"/></td>					
					</tr>
					<tr>
						<td class="text-center">012556546546 1</td>	
						<td class="text-center">001</td>	
						<td class="text-center">150</td>	
						<td class="text-center">2</td>	
						<td class="text-center">20/10/14</td>
						<td class="text-center"><input style="padding:1px;" type="submit" class="btn btn-success btn-block" value="Apartar"/></td>							
					</tr>
					<tr>
						<td class="text-center">012556546546 1</td>	
						<td class="text-center">001</td>	
						<td class="text-center">150</td>	
						<td class="text-center">2</td>	
						<td class="text-center">20/10/14</td>
						<td class="text-center"><input style="padding:1px;" type="submit" class="btn btn-success btn-block" value="Apartar"/></td>
					</tr>
					<tr>
						<td class="text-center">012556546546 1</td>	
						<td class="text-center">001</td>	
						<td class="text-center">150</td>	
						<td class="text-center">2</td>	
						<td class="text-center">20/10/14</td>	
						<td class="text-center"><input style="padding:1px;" type="submit" class="btn btn-success btn-block" value="Apartar"/></td>					
					</tr>
					<tr>
						<td class="text-center">012556546546 1</td>	
						<td class="text-center">001</td>	
						<td class="text-center">150</td>	
						<td class="text-center">2</td>	
						<td class="text-center">20/10/14</td>
						<td class="text-center"><input style="padding:1px;" type="submit" class="btn btn-success btn-block" value="Apartar"/></td>							
					</tr>
				</table>
			</div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">Cerrar
            </button>
            
         </div>
      </div><!-- /.modal-content -->
</div><!-- /.modal -->
<?php $this->load->view( 'footer' ); ?>
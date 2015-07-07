<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
	  $perfil= $this->session->userdata('id_perfil'); 
	  $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 

	  //if (isset($params['level']) && in_array($params['level'], array('L','M','Q','H'))) $level = $params['level'];
	  //if (!in_array($condition{0},array('>', '<', '='))) {
	  //$colab_id_array =

	  if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) )  
	  		{
	  			$coleccion_id_operaciones = array();
	  		} 	




			$where_total = '( m.id_apartado = 2 ) or ( m.id_apartado = 3 ) ';
			$dato['vendedor'] = (string)$this->modelo_pedido->total_apartados_pendientes($where_total);

			$where_total = '( m.id_apartado = 5 ) or ( m.id_apartado = 6 ) ';
			$dato['tienda'] = (string)$this->modelo_pedido->total_pedidos_pendientes($where_total);  
			
			$conteos =  '<span title="Pedidos Vendedores" class="ttip">'.$dato['vendedor'].'</span><span> - </span><span title="Pedidos Tiendas" class="ttip">'.$dato['tienda'].'</span>';




?>	

<div class="row-fluid">
	<div class="navbar navbar-default navbar-custom" role="navigation">
		<div class="container">
			
	 <?php  if ($this->session->userdata('session')) {  ?>
				<div class="navbar-brand">
					<a href="<?php echo base_url(); ?>" style="color: #ffffff;"><i class="glyphicon glyphicon-home"></i></a>
				</div>
				<?php if ( ( $perfil == 1 ) || (in_array(10, $coleccion_id_operaciones)) ) { ?>
					<div class="navbar-brand">
						<a href="<?php echo base_url(); ?>pedidos" style="color: #ffffff;"><i class="glyphicon glyphicon-bullhorn"></i></a>
						<span id="etiq_conteo"><?php echo $conteos; ?></span>			
					</div>

				<?php } ?>	

				<div class="navbar-header">
				<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#main-navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
				<div class="collapse navbar-collapse" id="main-navbar">
					<ul class="nav navbar-nav navbar-left" id="menu_opciones">

					 <?php if ( ( $perfil == 1 ) || (in_array(1, $coleccion_id_operaciones)) ) { ?>
						<li>
							<a href="<?php echo base_url(); ?>entradas" class="color-blanco">Entradas</a> 
						</li>
					<?php } ?>	

					<?php if ( ( $perfil == 1 ) || (in_array(23, $coleccion_id_operaciones)) ) { ?>
						<li>
							<a href="<?php echo base_url(); ?>devolucion" class="color-blanco">Devoluciones</a> 
						</li>
					<?php } ?>	


					 <?php if ( ( $perfil == 1 ) || (in_array(2, $coleccion_id_operaciones)) ) { ?>
						<li>
							<a href="<?php echo base_url(); ?>salidas" class="color-blanco">Salidas</a> 
						</li>
					<?php } ?>		

					 <?php if ( ( $perfil == 1 ) || (in_array(4, $coleccion_id_operaciones)) ) { ?>
						<li>
							<a href="<?php echo base_url(); ?>generar_pedidos" class="color-blanco">Pedido</a> 
						</li>
					<?php } ?>	

					 <?php if ( ( $perfil == 1 ) || (in_array(3, $coleccion_id_operaciones)) ) { ?>
						<li>
							<a href="<?php echo base_url(); ?>editar_inventario" class="color-blanco">Editar</a> 
						</li>
					<?php } ?>						


					 <?php if ( ( $perfil == 1 ) || (in_array(9, $coleccion_id_operaciones)) ) { ?>
						<li>
							<a href="<?php echo base_url(); ?>reportes" class="color-blanco">Reportes</a> 
						</li>
					<?php } ?>	


					 <?php if ( ( $perfil == 1 ) || (in_array(8, $coleccion_id_operaciones)) 
					 		|| (in_array(11, $coleccion_id_operaciones)) || (in_array(12, $coleccion_id_operaciones)) 
					 		|| (in_array(13, $coleccion_id_operaciones)) || (in_array(14, $coleccion_id_operaciones)) 
					 		|| (in_array(15, $coleccion_id_operaciones)) || (in_array(16, $coleccion_id_operaciones)) 
					 		|| (in_array(17, $coleccion_id_operaciones)) || (in_array(18, $coleccion_id_operaciones)) 
					 		|| (in_array(19, $coleccion_id_operaciones)) || (in_array(20, $coleccion_id_operaciones)) 
					 		|| (in_array(21, $coleccion_id_operaciones)) || (in_array(22, $coleccion_id_operaciones)) 
					 ) { ?>
						<li>
							<a href="<?php echo base_url(); ?>catalogos" class="color-blanco">Catálogos</a> 
						</li>
					<?php } ?>					



					<?php if ( ( $perfil == 1 ) || (in_array(5, $coleccion_id_operaciones)) ) { ?>		 
						<li>
							<a href="<?php echo base_url(); ?>usuarios" class="color-blanco">Usuarios</a>
						</li>
					 <?php } ?>						

						<li>
							<a href="<?php echo base_url(); ?>salir" class="color-blanco">Salir <i class="glyphicon glyphicon-log-out"></i></a>
						</li>
					</ul>
				</div>
	 <?php } ?>
		</div>
	</div>
</div>
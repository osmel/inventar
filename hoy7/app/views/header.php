<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es_MX">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sistema de almacén Iniciativa textil</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<?php echo link_tag('css/sistema.css'); ?>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>
	<div class="container-fluid">
		<div id="foo"></div>
		<header class="row">
			<div class="banner">
				<div>
					<div class="container header-content">
						<div class="col-md-6 col-lg-6 col-sm-6 col-xs-3">
							<a href="<?php echo base_url(); ?>">
								<div class="header-logo col-md-1"></div>
							</a>
						</div>
						
							<!-- <a href="<?php echo base_url(); ?>pedidos">
								<div class="logo_no col-md-12"></div><span class="notispan">Notificaciones</span>
							</a> -->
						
						<div class="col-md-6 col-lg-6 col-sm-6 col-xs-9">
							<div class="header-titulo text-right">Sistema control de inventario</div>
							<div class="text-right" style="color:#104A5A !important"> Bienvenid@: <a href="<?php echo base_url(); ?>actualizar_perfil" style="#104A5A"><?php echo $this->session->userdata( 'nombre_completo' ); ?></a>
						</div>
					</div>
				</div>
				<?php $this->load->view( 'navbar' ); ?>
			</div>
			<div class="barra-verde"></div>
		</header>
		<div class="row-fluid" id="wrapper">
			<div class="alert" id="messages"></div>
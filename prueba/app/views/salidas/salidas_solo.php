<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>

	<div class="container">
		<section>
			<table id="tabla_salida" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Código</th>
						<th>Descripción</th>
						<th>Color</th>
						<th>Pieza</th>
						<th>Metro</th>
						<th>Ancho</th>
						<th>Proveedor</th>
						<th>Lote</th>
						<th>Agregar</th>
					<!--
						<th>Start date</th>
						<th>Salary</th>
					-->
					</tr>
				</thead>
			</table>

			
		
		</section>
	</div>

<?php $this->load->view( 'footer' ); ?>
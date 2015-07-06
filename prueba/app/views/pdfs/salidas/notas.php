<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="container">
	<div>
		<div>
			<table style="width: 100%; border: 2px solid #222222;">
				<tbody>
					<tr>
						<td>
							<p style="font-size: 15px; line-height: 20px; padding: 0px; margin-bottom: 0px;">
								<span><b>Cliente: </b> <?php echo $movimientos[0]->cliente; ?></span><br>
								<span><b>Cargador: </b> <?php echo $movimientos[0]->cargador; ?></span><br>
								<span><b>Fecha y hora: </b> <?php echo $movimientos[0]->fecha; ?></span><br>
								<span><b>Movimiento: </b><?php echo $movimientos[0]->mov_salida; ?></span><br>
								<span><b>Factura: </b> <?php echo $movimientos[0]->factura; ?></span><br>
							</p>
						</td>
						<td style="text-align: right;">
							<p>&nbsp;</p>
							<?php echo '<img src="'.base_url().'img/unnamed.png" width="93px" height="50px"/>'; ?>
						</td>
					</tr>
				</tbody>
			</table>
			<table style="width: 100%; border: 2px solid #222222; font-size: 12px;">
				<thead>
					<tr>
						<th colspan="9">
							<p><b>Productos</b></p>
						</th>
					</tr>
					<tr>
						<th width="20%">Código</th>
						<th width="20%">Descripción</th>
						<th width="14%">Color</th>
						<th width="10%">UM</th>
						<th width="8%">Cant.</th>
						<th width="8%">Ancho</th>
						<th width="10%">Lote</th>
						<th width="10%">Núm. Consec.</th>
					</tr>
				</thead>
				<tbody>
				<?php if ( isset($movimientos) && !empty($movimientos) ): ?>
					<?php foreach( $movimientos as $movimiento ): ?>
						<tr>
							<td width="20%" style="border-top: 1px solid #222222;"><?php echo $movimiento->codigo; ?></td>								
							<td width="20%" style="border-top: 1px solid #222222;"><?php echo $movimiento->id_descripcion; ?></td>
							<td width="14%" style="border-top: 1px solid #222222;"><?php echo $movimiento->color; ?></td>
							<td width="10%" style="border-top: 1px solid #222222;"><?php echo $movimiento->medida; ?></td>
							<td width="8%" style="border-top: 1px solid #222222;"><?php echo $movimiento->cantidad_um; ?></td>
							<td width="8%" style="border-top: 1px solid #222222;"><?php echo $movimiento->ancho; ?></td>
							<td width="10%" style="border-top: 1px solid #222222;"><?php echo $movimiento->id_lote; ?></td>
							<td width="10%" style="border-top: 1px solid #222222;"><?php echo $movimiento->consecutivo; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
						<tr class="noproducto">
							<td colspan="9">No se han agregado producto</td>
						</tr>
				<?php endif; ?>	
				</tbody>		
			</table>
		</div>
	</div>
</div>
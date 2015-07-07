<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="container">
	<div>
		<div>
			<table style="width: 100%; border: 2px solid #222222;">
				<tbody>
					<tr>
						<td>
							<p style="font-size: 15px; line-height: 20px; padding: 0px; margin-bottom: 0px;">
								<span><b>Tipo Aparatdo: </b> <?php echo $movimientos[0]->tipo_pedido.'-'.$movimientos[0]->tipo_apartado; ?></span><br>

								<?php if ( $movimientos[0]->tipo_apartado=='Vendedor' ) { ?>

								<span><b>Comprador: </b> <?php echo $movimientos[0]->comprador; ?></span><br>
								<span><b>Fecha: </b><?php echo $movimientos[0]->fecha_apartado; ?></span><br>

								<?php } else { ?>

								<span><b>Movimiento: </b> <?php echo $movimientos[0]->id_cliente_apartado; ?></span><br>
								<span><b>Vendedor: </b> <?php echo $movimientos[0]->vendedor; ?></span><br>
								<span><b>Dependencia: </b> <?php echo $movimientos[0]->dependencia; ?></span><br>
								<span><b>Fecha: </b> <?php echo $movimientos[0]->fecha_apartado; ?></span><br>

								<?php } ?>
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
						<th width="15%">Código</th>
						<th width="20%">Descripción</th>
						<th width="20%">Color</th>
						<th width="10%">Cantidad</th>
						<th width="10%">Ancho</th>
						<th width="20%">Proveedor</th>
						<th width="5%">Lote</th>
					</tr>
				</thead>	
				<tbody>	
				<?php if ( isset($movimientos) && !empty($movimientos) ): ?>
					<?php foreach( $movimientos as $movimiento ): ?>
						<tr>
							<td width="15%" style="border-top: 1px solid #222222;"><?php echo $movimiento->codigo; ?></td>								
							<td width="20%" style="border-top: 1px solid #222222;"><?php echo $movimiento->id_descripcion; ?></td>
							<td width="20%" style="border-top: 1px solid #222222;"><?php echo $movimiento->hexadecimal_color.' '.$movimiento->nombre_color; ?></td>
							<td width="10%" style="border-top: 1px solid #222222;"><?php echo $movimiento->medida; ?></td>
							<td width="10%" style="border-top: 1px solid #222222;"><?php echo $movimiento->ancho; ?></td>
							<td width="20%" style="border-top: 1px solid #222222;"><?php echo $movimiento->vendedor; ?></td>
							<td width="5%" style="border-top: 1px solid #222222;"><?php echo $movimiento->id_lote; ?></td>
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
<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

			<div class="block">
				<div class="table-responsive">
					<table class="table table-sm table-bordered" id="encabezado">
						<tbody>
							<tr>
								<td>Folio</td>
								<td><?=$pedido->folio?></td>
								<td>Proveedor:</td>
								<td colspan="3"><?=$pedido->proveedor?></td>
							</tr>
							<tr>
								<td>Fecha</td>
								<td><?=$pedido->fecha.' '.$pedido->hora?></td>
								<td>Nota/Factura:</td>
								<td><?=$pedido->no_referencia?></td>
								<td>Fecha compra:</td>
								<td><?=$pedido->fecha_compra?></td>
							</tr>
						</tbody>
					</table>
					<br>

					<table class="table table-sm table-bordered" id="partidas">
						<thead>
							<tr>
								<th>Clave</th>
								<th>Descripción</th>
								<th>Precio Compra</th>
								<th>Cantidad</th>
								<th>Importe</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							foreach ($partidas->result() as $row)
							{ ?>
							<tr>
								<td><?=$row->clave_art?></td>
								<td><?=$row->descrip?></td>
								<td class="text-right">
								<?=number_format($row->precio, 4)?>
								</td>
								<td class="text-right">
								<?=number_format($row->cantidad, 2)?>
								</td>
								<td class="text-right">
								<?=number_format($row->cantidad * $row->precio, 4)?></td>
							</tr>
							<?php }
							?>						
						</tbody>
						<tfoot>
						<tr>
						<th>
						<a href="<?=base_url()?>compra" class="btn btn-primary btn-sm">Regresar</a>
						</th>
						<th></th>
						<th></th>
						<th>TOTAL</th>
						<th class="text-right">$ <?=$pedido->total?></th>
						</tr>
						</tfoot>
					</table>

					
				</div>
			</div>
			</div>
		</div>
	</div>
</section>

<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
						<h3>Compras por producto</h3>
						<p><?=$producto->clave_art.' - '.$producto->codigo_b?></p>
						<p><b><?=$producto->descrip?></b></p>
						<div class="table-responsive">
						<table class="table table-sm table-bordered">
							<tr>
								<th>Existencias</th>
								<th>Costo</th>
								<th>Venta</th>
								<th>Fecha Alta</th>
								<th>Ult. Venta</th>
							</tr>
							<tr>
								<td class="text-right"><?=number_format($producto->existencias, 2)?></td>
								<td class="text-right"><?=number_format($producto->precio_compra, 2)?></td>
								<td class="text-right"><?=number_format($producto->precio_venta, 2)?></td>
								<td class="text-center"><?= is_null($producto->fecha_alta) ? '' : date_format(date_create($producto->fecha_alta), 'Y-m-d')?></td>
								<td class="text-center"><?= is_null($producto->ult_vta) ? '' : date_format(date_create($producto->ult_vta), 'Y-m-d')?></td>
							</tr>
						</table>
						</div>
						<div class="table-responsive">
						<table id="dtRegistros" class="table table-sm table-hover datatable">
							<thead>
								<tr class="bg-dark">
									<th>#</th>
									<th>Doc</th>
									<th>Folio</th>
									<th>Estado</th>
									<th>Fecha</th>
									<th>Precio</th>
									<th>Cantidad</th>
									<th>Importe</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$i = 0;
							$total = 0;
							$cant_prod = 0;
							foreach($ventas->result() as $item): 
								$i++;
								$cantidad = $item->doc == 'COM' ? $item->cantidad : $item->cantidad*-1;
								$total += $cantidad * $item->precio;
								$cant_prod += $cantidad;
								?>
							<tr>
								<td><?=$i?></td>
								<td><?=$item->doc?></td>
								<td><?=$item->folio?></td>
								<td><?=$item->estado?></td>
								<td><?=$item->fecha?></td>
								<td class="text-right"><?=number_format($item->precio, 2)?></td>
								<td class="text-right"><?=number_format($cantidad, 2)?></td>
								<td class="text-right"><?=number_format($cantidad*$item->precio, 2)?></td>
							</tr>
							<?php endforeach; ?>	
							</tbody>
							<tfoot>
								<tr>
									<th colspan="5"></th>
									<th>TOTAL</th>
									<th class="text-right"><?=number_format($cant_prod,2)?></th>
									<th class="text-right"><?=number_format($total,2)?></th>
								</tr>
							</tfoot>
						</table>
						</div>
					
				</div>
				<!-- table de categorias -->

			</div>
		</div>
	</div>
</section>

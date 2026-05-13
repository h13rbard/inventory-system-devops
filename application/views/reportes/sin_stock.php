<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					<h3>Productos sin stock</h3>
					<p>Productos activos sin existencia y que se indico cantidad minima.</p>
						<div class="table-responsive">
						<table id="dtRegistros" class="table table-sm table-hover table-bordered datatable">
							<thead>
								<tr class="bg-dark">
									<th>Clasif.</th>
									<th>Clave</th>
									<th>Cod. Prov.</th>
									<th>Proveedor</th>
									<th>Descripción</th>
									<th>Compra</th>
									<th>Venta</th>
									<th>Existencia</th>
									<th>Minimo</th>
									<th>Diferencia</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$i = 0;
							foreach($productos->result() as $item): 
								$i++;
								?>
							<tr>
								<td><?=$item->clasif?></td>
								<td><?=$item->clave_art?></td>
								<td><?=$item->clave_prov?></td>
								<td><?=$item->proveedor?></td>
								<td><?=$item->descrip?></td>
								<td class="text-right"><?= number_format($item->precio_compra, 2) ?></td>
								<td class="text-right"><?= number_format($item->precio_venta, 2) ?></td>
								<td class="text-right"><?= number_format($item->existencias, 2) ?></td>
								<td class="text-right"><?= number_format($item->minimo, 2) ?></td>
								<td class="text-right"><?= number_format($item->minimo - $item->existencias, 2) ?></td>
							</tr>
							<?php endforeach; ?>	
							</tbody>
							<tfoot>
								<tr>
									<th colspan="9">No. Productos: <?=$i?></th>
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

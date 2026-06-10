<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					<h3>Sin venta</h3>
					<p>Productos sin venta</p>
						<div class="table-responsive">
						<table id="dtRegistros" class="table table-sm table-hover table-bordered datatable">
							<thead>
								<tr class="bg-dark">
									<th>Clave</th>
									<th>Descripción</th>
									<th>Costo</th>
									<th>Venta</th>
									<th>Existencias</th>
									<th>Importe</th>
									<th>Fecha alta</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$i = 0;
							foreach($productos->result() as $item): 
								$i++;
								?>
							<tr>
								<td><?=$item->clave_art?></td>
								<td><?=$item->descrip?></td>
								<td class="text-right"><?=number_format($item->precio_compra,2)?></td>
								<td class="text-right"><?=number_format($item->precio_venta,2 )?></td>
								<td class="text-right"><?=number_format($item->existencias,2 )?></td>
								<td class="text-right"><?=number_format($item->importe,2 )?></td>
								<td><?=$item->fecha_alta?></td>
							</tr>
							<?php endforeach; ?>	
							</tbody>
							<tfoot>
								<tr>
									<th colspan="7">No. Productos: <?=$i?></th>
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

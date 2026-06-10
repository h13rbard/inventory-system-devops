<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
						<h3>Productos por fecha de actualización de precios</h3>
						<div class="table-responsive">
						<table id="dtRegistros" class="table table-sm table-hover datatable">
							<thead>
								<tr class="bg-dark">
									<th>#</th>
									<th>Clave</th>
									<th>Cod. Prov.</th>
									<th>Descripción</th>
									<th>Compra</th>
									<th>Venta</th>
									<th>Existencias</th>
									<th>Fecha</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$i = 0;
							$total = 0;
							foreach($productos->result() as $item): 
								$i++;
								$total += $item->existencias * $item->precio_compra;
								?>
							<tr>
								<td><?=$i?></td>
								<td><?=$item->clave_art?></td>
								<td><?=$item->clave_prov?></td>
								<td><?=$item->descrip?></td>
								<td class="text-right"><?=number_format($item->precio_compra, 2)?></td>
								<td class="text-right"><?=number_format($item->precio_venta, 2)?></td>
								<td class="text-right"><?=number_format($item->existencias, 2)?></td>
								<td><?=$item->act_pre?></td>
							</tr>
							<?php endforeach; ?>	
							</tbody>
							<tfoot>
								<tr>
									<th colspan="5">No. Productos: <?=$i?></th>
									<th></th>
									<th colspan="2" class="text-right"></th>
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

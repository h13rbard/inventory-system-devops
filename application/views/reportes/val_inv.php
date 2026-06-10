<section class="no-padding-bottom">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="card">
				<div class="card-header">
					<h5>Valuación del Inventario</h5>
				</div>
				<div class="card-body">
						<div class="table-responsive">
						<table id="dtRegistros" class="table table-sm table-hover datatable">
							<thead>
								<tr class="bg-dark">
									<th>Clave</th>
									<th>Cod. Prov.</th>
									<th>Cod. Barras</th>
									<th>Descripción</th>
									<th>Costo</th>
									<th>Existencias</th>
									<th>Importe</th>
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
								<td><?=$item->clave_art?></td>
								<td><?=$item->clave_prov?></td>
								<td><?=$item->codigo_b?></td>
								<td><?=$item->descrip?></td>
								<td class="text-right"><?=number_format($item->precio_compra, 2)?></td>
								<td class="text-right"><?=number_format($item->existencias, 2)?></td>
								<td class="text-right"><?=number_format($item->existencias * $item->precio_compra, 2)?></td>
							</tr>
							<?php endforeach; ?>	
							</tbody>
							<tfoot>
								<tr class="bg-dark">
									<th colspan="4">No. Productos: <?=number_format($i)?></th>
									<th>TOTAL</th>
									<th colspan="2" class="text-right">$ <?=number_format($total, 2);?></th>
								</tr>
							</tfoot>
						</table>
						</div>
					</div>
					
				</div>
				<!-- table de categorias -->

			</div>
		</div>
	</div>
</section>

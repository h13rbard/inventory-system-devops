<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					<h3>Productos por proveeedor</h3>
						<div class="table-responsive">

						<table id="dtRegistros" class="table table-sm table-hover datatable">
						<thead>
							<tr class="bg-dark">
							<th>Proveedor</th>
							<th>No. Productos</th>
							<th>Importe</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$num = 0;
						$importe = 0;
						foreach($proveedores->result() as $item): 
						$num += $item->num;
						$importe += $item->importe;
						?>
						<tr>
						<td><?= $item->nombre ?></td>
						<td align="right"><?= number_format($item->num, 0) ?></td>
						<td align="right"><?= number_format($item->importe, 2); ?></td>
						</tr>
						<?php endforeach; ?>
						<tr>
						<td></td>
						<td align="right"><?= number_format($num, 0) ?></td>
						<td align="right"><?= number_format($importe, 2); ?></td>
						</tr>
						</tbody>
						</table>
						
						</div>					
				</div>
				<!-- table de categorias -->

			</div>
		</div>
	</div>
</section>

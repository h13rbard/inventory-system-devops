<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					<h3>Sin existencia</h3>
					<p>Productos activos con existencia = 0</p>
						<div class="table-responsive">
						<table id="dtRegistros" class="table table-sm table-hover datatable">
							<thead>
								<tr class="bg-dark">
									<th>Clasif.</th>
									<th>Clave</th>
									<th>Cod. Prov.</th>
									<th>Cod. Barras</th>
									<th>Descripción</th>
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
								<td><?=$item->codigo_b?></td>
								<td><?=$item->descrip?></td>
							</tr>
							<?php endforeach; ?>	
							</tbody>
							<tfoot>
								<tr>
									<th colspan="4">No. Productos: <?=$i?></th>
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

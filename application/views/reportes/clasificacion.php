<section class="no-padding-bottom">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="card">
				<div class="card-header">
					<h5>Clasificación de Productos</h5>
				</div>
				<div class="card-body">
						<div class="table-responsive">
						<table id="dtRegistros" class="table table-sm table-hover datatable">
							<thead>
								<tr class="bg-dark">
									<th>Clas</th>
									<th>Clave</th>
									<th>Cod. Prov.</th>
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
							$j =0;
							$clasif = '';
							$clasificacion = [
								'A' => 0,
								'B' => 0,
								'BMAS' => 0,
								'BMENOS' => 0,
								'C' => 0,
								'D' => 0,
							];
							foreach($productos->result() as $item): 
								$i++;
								$total += $item->existencias * $item->precio_compra;
								if ($clasif != $item->clasif) {
									$j =0;
									// echo '<tr><td class="bg-info text-center text-white" colspan="9">CLASIFICACION '.$item->clasif.'</td></tr>';
								}
								switch($item->clasif) {
									case 'A':
										$clasificacion['A']++;
									break;
									case 'B':
										$clasificacion['B']++;
									break;
									case 'B+':
										$clasificacion['BMAS']++;
									break;
									case 'B-':
										$clasificacion['BMENOS']++;
									break;
									case 'C':
										$clasificacion['C']++;
									break;
									case 'D':
										$clasificacion['D']++;
									break;
								}
								$j++;
								$clasif = $item->clasif;
								?>
							<tr>
								<td><?=$item->clasif?></td>	
								<td><?=$item->clave_art?></td>
								<td><?=$item->clave_prov?></td>
								<td><?=$item->descrip?></td>
								<td class="text-right"><?=number_format($item->precio_compra, 2)?></td>
								<td class="text-right"><?=number_format($item->existencias, 2)?></td>
								<td class="text-right"><?=number_format($item->existencias * $item->precio_compra, 2)?></td>
							</tr>
							<?php endforeach; ?>	
							</tbody>
							<tfoot>
								<tr class="bg-dark">
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
								</tr>
							</tfoot>
						</table>
						</div>

					    <br>
						<div class="table-responsive">
						<table class="table table-sm table-bordered table-hover">
						<tr><th>CLASIFICACION</th><th>NO. PRODUCTOS</th><th>% PORCENTAJE</th></tr>
						<tr><td>A</td><td class="text-right"><?=$clasificacion['A']?></td><td class="text-right"><?=number_format( ($clasificacion['A']/$i)*100 , 2)?></td></tr>
						<tr><td>B+</td><td class="text-right"><?=$clasificacion['BMAS']?></td><td class="text-right"><?=number_format( ($clasificacion['BMAS']/$i)*100 , 2)?></td></tr>
						<tr><td>B</td><td class="text-right"><?=$clasificacion['B']?></td><td class="text-right"><?=number_format( ($clasificacion['B']/$i)*100 , 2)?></td></tr>
						<tr><td>B-</td><td class="text-right"><?=$clasificacion['BMENOS']?></td><td class="text-right"><?=number_format( ($clasificacion['BMENOS']/$i)*100 , 2)?></td></tr>
						<tr><td>C</td><td class="text-right"><?=$clasificacion['C']?></td><td class="text-right"><?=number_format( ($clasificacion['C']/$i)*100 , 2)?></td></tr>
						<tr><td>D</td><td class="text-right"><?=$clasificacion['D']?></td><td class="text-right"><?=number_format( ($clasificacion['D']/$i)*100 , 2)?></td></tr>
						<tr><th></th><th class="text-right"><?=number_format($i)?></th><th class="text-right">100</th></tr>
						</table>
						</div>
					</div>
				</div>
				<!-- table de categorias -->

			</div>
		</div>
	</div>
</section>

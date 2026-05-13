<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">

			<div class="col-md-3 col-lg-3 col-sm-12">
				<div class="card">
					<div class="card-header">Clasificación - Productos</div>
					<div class="card-body">
						<canvas id="clasif-productos" width="400" height="400"></canvas>
					</div>
				</div>
			</div>

			<div class="col-md-3 col-lg-3 col-sm-12">
				<div class="card">
					<div class="card-header">Clasificación - Importe</div>
					<div class="card-body">
						<canvas id="clasif-importe" width="400" height="400"></canvas>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-lg-6 col-sm-12">
				<div class="card">
					<div class="card-header">Clasificación</div>
					<div class="card-body">
						<table class="table table-sm" id="dtRegistrosClasif">
							<thead>
								<tr>
									<th>Clasif</th>
									<th>Productos</th>
									<th>Importe</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($data_clasif as $item): 
									if($item->baja == 1) continue;
									?>
									<tr>
										<td><?=$item->clasif?></td>
										<td class="text-right"><?=$item->productos?></td>
										<td class="text-right"><?=number_format($item->importe, 2)?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-md-3 col-lg-3 col-sm-12">
				<div class="card">
					<div class="card-header">Grupos - Productos</div>
					<div class="card-body">
						<canvas id="grupo-productos" width="400" height="400"></canvas>
					</div>
				</div>	
			</div>

			<div class="col-md-3 col-lg-3 col-sm-12">
				<div class="card">
					<div class="card-header">Grupos - Importe</div>
					<div class="card-body">
						<canvas id="grupo-importe" width="400" height="400"></canvas>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-lg-6 col-sm-12">
				<div class="card">
					<div class="card-header">Productos</div>
					<div class="card-body">
						<table class="table table-sm" id="dtRegistrosGrupos">
							<thead>
								<tr>
									<th>id</th>
									<th>Grupo</th>
									<th>Productos</th>
									<th>Importe</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($data as $item): 
									if($item->baja == 1) continue;
									?>
									<tr>
										<td><?=$item->grupo_id?></td>
										<td><?=$item->nombre?></td>
										<td class="text-right"><?=$item->productos?></td>
										<td class="text-right"><?=number_format($item->importe, 2)?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>

		<div class="row">

			<div class="col-md-3 col-lg-3 col-sm-12">
				<div class="card">
					<div class="card-header">Proveedores - Productos</div>
					<div class="card-body">
						<canvas id="proveedores-productos" width="400" height="400"></canvas>
					</div>
				</div>
			</div>

			<div class="col-md-3 col-lg-3 col-sm-12">
				<div class="card">
					<div class="card-header">Proveedores - Importe</div>
					<div class="card-body">
						<canvas id="proveedores-importe" width="400" height="400"></canvas>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-lg-6 col-sm-12">
				<div class="card">
					<div class="card-header">Proveedores</div>
					<div class="card-body">
						<table class="table table-sm" id="dtRegistrosProveedores">
							<thead>
								<tr>
									<th>Proveedor</th>
									<th>Productos</th>
									<th>Importe</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($data_proveedores as $item): 
									if($item->baja == 1) continue;
									?>
									<tr>
										<td><?=$item->nombre?></td>
										<td class="text-right"><?=$item->productos?></td>
										<td class="text-right"><?=number_format($item->importe, 2)?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>

	</div>
</section>

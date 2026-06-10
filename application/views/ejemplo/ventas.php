<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
		<div class="col-lg-4">
			<!-- Totales -->
			<div class="stats-2-block block d-flex">  
			<div class="stats-1 d-flex">
			<div class="stats-2-arrow height"><i class="fa fa-caret-up"></i></div>
			<div class="stats-2-content"><strong class="d-block">$ <?=number_format($ventasDic, 2)?></strong><span class="d-block">Diciembre</span>
				<div class="progress progress-template progress-small">
				<div role="progressbar" style="width: 100%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template progress-bar-small dashbg-3"></div>
				</div>
			</div>
			</div>
			</div>
			<!-- fin totales -->
			<!-- Venta promedio -->
			<div class="stats-2-block block d-flex">
			<div class="stats-1 d-flex">
				<div class="stats-2-content"><strong class="d-block">$ <?=number_format($ventaMensualPromedio, 2)?></strong><span class="d-block">Promedio</span>
				<div class="progress progress-template progress-small">
					<div role="progressbar" style="width: 100%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template progress-bar-small dashbg-2"></div>
				</div>
				</div>
			</div>
			</div>
			<!-- Fin venta promedio -->
			<!-- Vendedores -->
			<div class="stats-2-block block d-flex">
			
			<div class="stats-2 d-flex">
			<div class="stats-2-content"><strong class="d-block">8</strong><span class="d-block">Vendedores</span>
			</div>
			</div>
			<div class="stats-2 d-flex">
			<div class="stats-2-content"><h5 class="d-block">$ <?=number_format($metaVendedor, 2)?></h5><span class="d-block">Objetivo venta</span>
			</div>
			</div>
		</div>
		<!-- Fin vendedores -->
		</div>
		<div class="col-lg-8">
			<div class="block">
				<div id="chr-ventas"></div>
			</div>
		</div>
		</div>
	</div>
</section>
<section class="no-padding-bottom">
	<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<!-- Vendedores -->
			<div class="block">
			<div class="title"><strong>Ventas Diciembre</strong></div>
			<div class="table-responsive"> 
			<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th>#</th>
						<th>Nombre</th>
						<th>Importe</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php
				$n = 0;
				foreach($ventasPorVendedor->result() as $row) : 
				$n++;
				?>
				<tr>
					<th scope="row"><?=$n?></th>
					<td><?=$row->nombre?></td>
					<td><?=number_format($row->total, 2)?></td>
					<td>
						<?= ($row->total > $metaVendedor) ?
						'<span class="text-success"><i class="fa fa-caret-up"></i></span>' :
						'<span class="text-danger"><i class="fa fa-caret-down"></i></span>' ?>
					</td>
				</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			</div>
		</div>
		<!-- Fin vendedores -->
		</div>
		<div class="col-lg-6">
			<div id="chr-vendedores"></div>
		</div>
		</div>
	</div>
</section>

<section class="no-padding-bottom">
	<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<!-- Productos -->
			<div class="block">
			<div class="title"><strong>Productos</strong></div>
			<div class="table-responsive"> 
			<table id="example" class="table table-striped table-sm">
				<thead>
					<tr>
						<th class="col-8">Nombre</th>
						<th class="col-2">Precio</th>
						<th class="col-2">Stock</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			</div>
		</div>
		<!-- Fin Productos -->
		</div>
		<div class="col-lg-6">

			<div class="row">
				<div class="col">
					<!-- Valor del inventario -->
					<div class="stats-2-block block d-flex">  
					<div class="stats-1 d-flex">
					<div class="stats-2-arrow height"><i class="fa fa-dollar"></i></div>
					<div class="stats-2-content"><strong class="d-block"><?=number_format($inv[0]->valor, 2)?></strong><span class="d-block">Valor del inventario</span>
						<div class="progress progress-template progress-small">
						<div role="progressbar" style="width: 100%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template progress-bar-small dashbg-3"></div>
						</div>
					</div>
					</div>
					</div>
					<!-- fin Valor del inventario -->
				</div>
				<div class="col">
					<!-- No Productos -->
					<div class="stats-2-block block d-flex">  
					<div class="stats-1 d-flex">
					<div class="stats-2-arrow height"><i class="fa fa-barcode"></i></div>
					<div class="stats-2-content"><strong class="d-block"><?=number_format($inv[0]->num)?></strong><span class="d-block">Productos</span>
						<div class="progress progress-template progress-small">
						<div role="progressbar" style="width: 100%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template progress-bar-small dashbg-3"></div>
						</div>
					</div>
					</div>
					</div>
					<!-- fin No Productos -->
				</div>
			</div>

			<div id="chr-ventas"></div>

		</div>
		</div>

		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-header">
					<span class="text-success"><i class="fa fa-caret-up"></i></span> Stock alto
					</div>
					<div id="stock-alto"></div>
				</div>
			</div>
			<div class="col">
				<div class="card">
					<div class="card-header">
					<span class="text-danger"><i class="fa fa-caret-down"></i></span> Stock bajo
					</div>
					<div id="stock-bajo"></div>
				</div>
			</div>
		</div>
	</div>
</section>

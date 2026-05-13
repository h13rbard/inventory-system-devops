<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block table-responsive">
					<div class="title row">
						<div class="col-sm-12 col-md-6">
						Cobranza
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="text-right">
								<a href="../ticket_estado/<?=$cliente_id?>" target="_blank" class="btn btn-sm btn-primary">Estado de cuenta</a>
								<a href="../abonar/<?=$cliente_id?>" class="btn btn-sm btn-secondary">Abonar</a>
							</div>
						</div>
					</div>
					
						<div class="">
						<table id="dtRegistros" class="table table-sm datatable">
							<thead>
								<tr class="bg-dark">
									<th>id</th>
									<th>Folio</th>
									<th>Fecha</th>
									<th>Estado</th>
									<th>Cliente</th>
									<th>Importe</th>
									<th>Resta</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody></tbody>
							<tfoot>
								<tr class="bg-dark">
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th>Total</th>
									<th><?=$saldo != null ? number_format($saldo->total, 2) : '' ?></th>
									<th><?=$saldo != null ? number_format($saldo->resta, 2) : '' ?></th>
									<th></th>
								</tr>
							</tfoot>
							<tbody></tbody>
						</table>
						</div>
					
				</div>
				<!-- table de categorias -->

			</div>
		</div>
	</div>
</section>

<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">

			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="block">
					<h5>Dashboard Ventas</h5>
						<div class="table-responsive">
						<form id="form">
						<table class="table table-sm">
							<tbody>
								<tr>
									<td>Inicio</td>
									<td><input type="date" name="inicio" id="" class="form-control" required value="<?=date('Y-m-d')?>"></td>
									<td>Fin</td>
									<td><input type="date" name="fin" id="" class="form-control" required value="<?=date('Y-m-d')?>"></td>
								</tr>
								<tr>
									<td></td>
									<td colspan="3">
										<button type="button" class="btn btn-success btn-sm" onclick="clientes()">Clientes</button>
										<button type="button" class="btn btn-success btn-sm" onclick="productos()">Productos</button>
										<button type="button" class="btn btn-success btn-sm" onclick="formaPago()">Forma Pago</button>
										<button type="button" class="btn btn-success btn-sm" onclick="grupos()">Grupos</button>
									</td>
								</tr>
							</tbody>
						</table>
						</form>
						</div>					
				</div>
			</div>

			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="statistic-block block">
					<h5>Clientes</h5>
					<div id="res-clientes"></div>
				</div>
			</div>

			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="statistic-block block">
					<h5>Productos</h5>
					<div id="res-productos"></div>
				</div>
			</div>

			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="statistic-block block">
					<h5>Forma de pago</h5>
					<div id="res-formapago"></div>
				</div>
			</div>

			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="statistic-block block">
					<h5>Grupos</h5>
					<div id="res-grupos"></div>
				</div>
			</div>

		</div>
	</div>
</section>

<section class="no-padding-bottom">
	<div class="container">
		
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<form action="" id="form-consulta">
					<table class="table table-sm">
						<tbody>
							<tr>
								<td>Inicio:</td>
								<td><input type="date" name="inicio" id="inicio" class="form-control" required value="<?=date('Y')?>-01-01" autocomplete="off"></td>
								<td>Fin:</td>
								<td><input type="date" name="fin" id="fin" class="form-control" required value="<?=date('Y-m-d')?>" autocomplete="off"></td>
								<td><button type="submit" class="btn btn-primary">Consultar</button></td>
								<td><button type="button" class="btn btn-secondary" onclick="grafica()">Grafica</button></td>
							</tr>
						</tbody>
					</table>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-header">
					<h5>Reporte Ventas</h5>
				</div>
				<div class="card-body" id="resultados"></div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-9 col-lg-9 col-sm-9">
			<div class="card">
				<div class="card-header">
					<h5>Reporte Ventas</h5>
				</div>
				<div class="card-body m-9" >
					<canvas id="myChart" width="200" height="100"></canvas>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-lg-3 col-sm-3">
			<div class="card">
				<div class="card-header">
					<h5>Totales</h5>
				</div>
				<div class="card-body m-9" >
					<div id="totales"></div>
				</div>
			</div>
		</div>
	</div>

	</div>
</section>

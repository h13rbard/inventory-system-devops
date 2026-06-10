<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					<h3>Reporte importe de productos vendidos por periodos</h3>
						<div class="table-responsive">
						<form id="reporte">
						<table id="periodo" class="table table-sm">
							<tbody>
								<tr>
									<td>Inicio:</td>
									<td>Fin:</td>
									<td></td>
								</tr>
								<tr>
									<td><input type="date" name="inicio1" id="inicio" class="form-control" required></td>
									<td><input type="date" name="fin1" id="fin" class="form-control" required></td>
									<td></td>
								</tr>
								<tr>
									<td><input type="date" name="inicio2" id="inicio" class="form-control" required></td>
									<td><input type="date" name="fin2" id="fin" class="form-control" required></td>
									<td></td>
								</tr>
								<tr>
									<td><input type="date" name="inicio3" id="inicio" class="form-control" required></td>
									<td><input type="date" name="fin3" id="fin" class="form-control" required></td>
									<td><button type="submit" class="btn btn-success">Generar</button></td>
								</tr>
							</tbody>
						</table>
						</form>
						</div>

						<div id="resultado"></div>
					
				</div>
				<!-- table de categorias -->

			</div>
		</div>
	</div>
</section>

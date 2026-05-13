<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<div class="block">
					<h3>Ventas por semana</h3>
						<div class="table-responsive">
						<form id="reporte">
						<table id="periodo" class="table table-sm">
							<tbody>
								<tr>
									<td>Fecha:</td>
									<td></td>
								</tr>
								<tr>
									<td><input type="date" name="fecha" id="fecha" class="form-control" required value="<?=date('Y-m-d')?>"></td>
									<td><button type="submit" class="btn btn-success">Consultar</button></td>
								</tr>
							</tbody>
						</table>
						</form>
						</div>

						<div id="resultado"></div>
					
				</div>

			</div>
		</div>
	</div>
</section>

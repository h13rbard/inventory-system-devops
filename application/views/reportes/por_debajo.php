<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de porcentaje -->
				<div class="block">
				<h3>Precios por debajo del X %</h3>
						<div class="table-responsive">
						<form id="reporte">
						<table id="periodo" class="table table-sm">
							<tbody>
								<tr>
									<td>Porcentaje %:</td>
									<td><input type="number" name="porcentaje" id="porcentaje" class="form-control" required value="20" min="0" max="100"></td>
									<td><button type="submit" class="btn btn-success">Consultar</button></td>
								</tr>
							</tbody>
						</table>
						</form>
						</div>					
				</div>
				<!-- table de porcentaje -->

				<div class="block table-responsive">
					<div id="resultado"></div>
				</div>

				
			</div>
		</div>
	</div>
</section>

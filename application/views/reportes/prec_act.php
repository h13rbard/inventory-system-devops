<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					<h3>Precios actualizados</h3>
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
									<td><button type="submit" class="btn btn-success">Generar</button></td>
								</tr>
							</tbody>
						</table>
						</form>
						</div>

						<div class="table-responsive">
						<div id="resultado"></div>
						</div>
					
				</div>
				<!-- table de categorias -->

			</div>
		</div>
	</div>
</section>

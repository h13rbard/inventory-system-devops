<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					<h3>Reporte de Ventas vs Compras</h3>
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
									<td><input type="date" name="inicio" id="inicio" class="form-control" required value="<?=date('Y-m-d')?>" autocomplete="off"></td>
									<td><input type="date" name="fin" id="fin" class="form-control" required value="<?=date('Y-m-d')?>" autocomplete="off"></td>
									<td><button type="submit" class="btn btn-success">Generar</button></td>
								</tr>
							</tbody>
						</table>
						</form>
						</div>					
				</div>
				<!-- table de categorias -->

				<div class="block table-responsive">
					<div id="resultado"></div>
				</div>

			</div>
		</div>
	</div>
</section>

<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block table-responsive">
					<h3>Control de caja</h3>
						<div class="">
						<form id="form">
						<table class="table table-sm datatable datble-bordered">
							<tbody>
								<tr class="bg-dark">
									<td>Tipo:</td>
									<td></td>
									<td>Concepto:</td>
									<td>Importe:</td>
									<td></td>
								</tr>
								<tr>
									<td><select name="tipo" id="tipo" class="form-control">
									<option value="I">Ingreso</option>
									<option value="E">Egreso</option>
									</select>
									</td>
									<td>
									<select name="proceso" id="proceso" class="form-control">
									<option value="OTR">---</option>
									<option value="COM">Compra</option>
									<option value="GTS">Gastos</option>
									<option value="GTS">Sueldo</option>
									<option value="RET">Retiro</option>
									</select>
									</td>
									<td><input type="text" name="concepto" autocomplete="off" id="concepto" class="form-control" required></td>
									<td><input type="number" step="0.01" autocomplete="off" name="importe" id="importe" lang="en" class="form-control" required></td>
									<td><button type="submit" class="btn btn-success">Guardar</button></td>
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

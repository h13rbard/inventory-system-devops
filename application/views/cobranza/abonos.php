<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					<h3>Cobranza</h3>
						<div class="table-responsive">
						<form id="form">
						<input type="hidden" name="venta_id" value="<?=$venta_id?>">
						<input type="hidden" name="cliente_id" value="<?=$cliente->id?>">
						<table class="table table-sm">
							<tbody>
								<tr class="bg-dark">
									<td>Movimieno:</td>
									<td>Concepto:</td>
									<td>Cliente:</td>
									<td>Importe:</td>
									<td></td>
								</tr>
								<tr>
									<td><select name="movimiento" id="movimiento" class="form-control">
									<option value="A">ABONO</option>
									</select></td>
									<td><select name="concepto" id="concepto" class="form-control">
									<option value="EFE">EFECTIVO</option>
									<option value="DVC">DEVOLUCION / CREDITO</option>
									</select></td>
									<td><input type="text" name="cliente" autocomplete="off" id="cliente" class="form-control" required value="<?=$cliente->nombre?>"></td>
									<td><input type="number" step="0.01" min="0.01" autocomplete="off" name="importe" id="importe" lang="en" class="form-control" required></td>
									<td>
									<button type="submit" class="btn btn-success">Guardar</button>
									<a href="../ticket/<?=$venta_id?>" class="btn btn-secondary">Imprimir</a>
									</td>
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

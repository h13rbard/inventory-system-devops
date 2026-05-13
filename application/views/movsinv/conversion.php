<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de conversion -->
				<div class="block">
						<h3>Conversión</h3>
						<div class="table-responsive">
						
						<form id="form">
						<table class="table table-sm">
							<tr>
							<td>Producto origen</td>
							<td>Cantidad</td>
							<td></td>
							<td>Producto detino</td>
							<td>Cantidad</td>
							<td></td>
							</tr>
							<tr>
							<td><input type="text" name="producto1" id="producto1" class="form-control" required placeholder="Clave Producto" autocomplete="off"></td>
							<td><input type="number" name="cantidad1" id="cantidad1" class="form-control" required placeholder="Cantidad" lang="en" min="0"></td>
							<td><select name="operador" id="operador" class="form-control">
							<option value="1">*</option>
							<option value="2">/</option>
							</select></td>
							<td><input type="text" name="producto2" id="producto2" class="form-control" required placeholder="Clave Producto" autocomplete="off"></td>
							<td><input type="number" name="cantidad2" id="cantidad2" class="form-control" required placeholder="Cantidad" lang="en" min="0"></td>
							<td><button type="submit" class="btn btn-success">Calcular</button></td>
							</tr>
						</table>
						</form>
						
						</div>
					
				</div>
				<!-- table de conversion -->

				<div class="block table-responsive">
					<div id="resultado"></div>
				</div>

			</div>
		</div>
	</div>
</section>

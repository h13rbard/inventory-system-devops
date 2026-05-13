<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					<h3>Actualizar precios</h3>
						<div class="table-responsive">
						<form id="reporte">
						<table id="periodo" class="table table-sm datatable">
							<tbody>
								<tr class="bg-dark">
									<td>Proveedor</td>
									<td>Porcentaje (%):</td>
									<td>Precio compra (>=):</td>
									<td>Precio compra (<=):</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>
									<select class="form-control form-control-sm" id="proveedor_id" name="proveedor_id" required>
									<?php foreach($proveedores->result() as $item):?>
									<option value="<?=$item->id?>"><?=$item->nombre?></option>
									<?php endforeach; ?>
									</select>
									</td>
									<td><input type="number" lang="en" name="porcentaje" id="porcentaje" class="form-control form-control-sm" value="20" min="0" required autocomplete="off"></td>
									<td><input type="number" lang="en" name="inicio" id="inicio" class="form-control form-control-sm" value="0" min="0" required autocomplete="off"></td>
									<td><input type="number" lang="en" name="fin" id="fin" class="form-control form-control-sm" value="0" min="0" required autocomplete="off"></td>
									<td><button type="button" id="previsualizar" class="btn btn-sm btn-secondary">Previsualizar</button></td>
									<td><button id="actualizar" type="button" class="btn btn-sm btn-success">Actualizar</button></td>
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

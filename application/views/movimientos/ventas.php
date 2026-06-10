<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 col-lg-6 col-sm-12">

				<!-- table de categorias -->
				<div class="card">
					<div class="card-header">
						Ventas
					</div>
					<form id="form">
					<div class="card-body">
						<div class="form-group">
							<label for="fecha">Fecha</label>
							<input type="date" class="form-control" id="fecha" name="fecha" autocomplete="off" placeholder="Fecha" value="<?=$date->format('Y-m-d')?>" required>
						</div>
						<div class="form-group">
							<label for="formapago_id">Forma de pago</label>
							<select class="form-control" id="formapago_id" name="formapago_id">
							<?php foreach ($formaspago->result() as $item):?>
								<option value="<?= $item->id?>" ><?= $item->nombre?></option>
							<?php endforeach;?>
							</select>
						</div>
						<div class="form-group">
							<label for="concepto_id">Concepto</label>
							<select class="form-control" id="concepto_id" name="concepto_id">
							<?php foreach ($conceptos->result() as $item):?>
								<option value="<?= $item->id?>" ><?= $item->categoria.' - '.$item->nombre?></option>
							<?php endforeach;?>
							</select>
						</div>
						<div class="form-group">
							<label for="total">Total</label>
							<input type="number" step="0.01" min="0" lang="en" class="form-control" id="total" name="total" autocomplete="off" placeholder="Total" required>
						</div>
						<div class="form-group">
							<label for="observacion">Observación</label>
							<textarea class="form-control" id="observacion" rows="2" name="observacion" maxlength="200" required></textarea>
						</div>
					</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
					</form>
				</div>
				<!-- table de categorias -->

			</div>

			<div class="col-md-6 col-lg-6 col-sm-12">
				<div class="card">
					<div class="card-header">
					<button type="button" class="btn btn-success" onclick="loadmovimientos()">Cargar</button>
					Movimientos <span id="fecha-mov"></span>
					</div>
					<div class="card-body">
					<div class="table-responsive">
					<table class="table table-sm table-striped table-hover">
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Concepto</th>
							<th>Observación</th>
							<th>Total</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody id="registros"></tbody>
					</table>
					<br>
					<h4 class="text-center text-success">Total: <b class="" id="resultado"></b></h4>

					</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

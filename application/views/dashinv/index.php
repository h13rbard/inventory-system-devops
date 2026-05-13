<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">

			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="statistic-block block">
					<h5>Valor del Inventario</h5>
					<button type="button" class="btn btn-sm btn-primary" onclick="valor_inv()">Consulta</button>
					<div id="res-valinv"></div>
				</div>
			</div>

			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="statistic-block block">
					<h5>Productos por clasificación</h5>
					<button type="button" class="btn btn-sm btn-primary" onclick="clasificacion()">Consulta</button>
					<div id="res-clas"></div>
				</div>
			</div>

			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="statistic-block block">
					<h5>Productos por grupos</h5>
					<button type="button" class="btn btn-sm btn-primary" onclick="grupos()">Consulta</button>
					<div id="res-grupos"></div>
				</div>
			</div>

			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="statistic-block block">
					<h5>Filtrar productos </h5>
					<form id="form-filtrar">
					<table class="table">
						<tr>
							<td>Clasificación:</td>
							<td>
								<select class="form-control" name="clasificacion" id="clasificacion">
									<option value="0">TODOS</option>
									<option value="1">A</option>
									<option value="2">B+</option>
									<option value="3">B</option>
									<option value="4">B-</option>
									<option value="5">C</option>
									<option value="6">D</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Estado:</td>
							<td>
								<select class="form-control" name="estado" id="estado">
									<option value="0">TODOS</option>
									<option value="1">ACTIVOS</option>
									<option value="2">BAJA</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Existencias:</td>
							<td>
								<select class="form-control" name="existencias" id="existencias">
									<option value="0">TODOS</option>
									<option value="1">CON EXISTENCIAS</option>
									<option value="2">SIN EXISTENCIAS</option>
								</select>
							</td>
						</tr>
						<tr>
							<td></td>
							<td><button type="button" class="btn  btn-success" onclick="filtrar()">Filtrar</button></td>
						</tr>
					</table>
					</form>
					<div id="res-filtrar"></div>
				</div>
			</div>

		</div>
	</div>
</section>

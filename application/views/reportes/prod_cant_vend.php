<?php date_default_timezone_set('America/Mexico_City'); ?>
<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					<h3>Reporte de cantidad de productos vendidos por periodos</h3>
					<p>Actualiza la clasificación de los productos.</p>
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
									<td><input type="date" name="inicio1" id="inicio" class="form-control" required value="<?=date('Y-m-d', strtotime("-83 days"))?>"></td>
									<td><input type="date" name="fin1" id="fin" class="form-control" required value="<?=date('Y-m-d', strtotime("-56 days"))?>"></td>
									<td></td>
								</tr>
								<tr>
									<td><input type="date" name="inicio2" id="inicio" class="form-control" required value="<?=date('Y-m-d', strtotime("-55 days"))?>"></td>
									<td><input type="date" name="fin2" id="fin" class="form-control" required value="<?=date('Y-m-d', strtotime("-28 days"))?>"></td>
									<td></td>
								</tr>
								<tr>
									<td><input type="date" name="inicio3" id="inicio" class="form-control" required value="<?=date('Y-m-d', strtotime("-27 days"))?>"></td>
									<td><input type="date" name="fin3" id="fin" class="form-control" required value="<?=date('Y-m-d')?>"></td>
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

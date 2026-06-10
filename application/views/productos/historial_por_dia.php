<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					<div class="title">
					
					
						<div class="table-responsive">
						<form id="reporte" method="post">
						<table class="table table-sm">
							
							<tbody>
							<tr>
							<td>Fecha:</td>
							<td>
							<input type="date" name="fecha" id="fecha" value="<?=date('Y-m-d')?>"required class="form-control">
							</td>
							<td>
							<button type="submit" id="consultar" class="btn btn-success">Consultar</button>
							</td>
							</tr>

							</tbody>
							
						</table>
						</form>
						</div>
					
				</div>
				<!-- table de categorias -->

			</div>


			<div class="block">
				<div id="resultado"></div>
			</div>

		</div>
	</div>
</section>

<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block table-responsive">
					<div class="title">
					
					
						<div class="">
						<form id="reporte" method="post">
						<table class="table table-sm">
							
							<tbody>
							
							<tr>
							<td>Grupo:</td>
							<td></td>
							</tr>
							<tr>
							<td>
							<select name="grupo" id="grupo" required class="form-control">
							<?php foreach($grupos->result() as $item) :?>
							<option value="<?=$item->id?>"><?=$item->nombre?></option>
							<?php endforeach; ?>
							</select>
							</td>
							<td>
							<button type="submit" id="todos" class="btn btn-success">Todos</button>
							<button type="submit" id="existencia" class="btn btn-success">Con existencia</button>
							</td>
							</tr>

							</tbody>
							
						</table>
						</form>
						</div>
					
				</div>
				<!-- table de categorias -->

			</div>


			<div class="block table-responsive">
				<div id="resultado"></div>
			</div>

		</div>
	</div>
</section>

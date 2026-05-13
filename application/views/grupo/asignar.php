<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block table-responsive">
					<div class="title">
					
					
						<div class="">
						<form id="form" method="post">
						<table id="dtRegistros" class="table table-sm">
							
							<tbody>
							
							<tr>
							<td>Grupo:</td>
							<td>Clave Articulo:</td>
							<td></td>
							</tr>
							<tr>
							<td>
							<select name="grupo" id="grupo" required class="form-control" >
							<?php foreach($grupos->result() as $item) :?>
							<option value="<?=$item->id?>"><?=$item->nombre?></option>
							<?php endforeach; ?>
							</select>
							</td>
							<td>
							<input type="text" name="clave" id="clave" required maxlength="50" autocomplete="off" class="form-control">
							</td>
							<td><button type="submit" class="btn btn-primary">Guardar</button></td>
							</tr>

							</tbody>
							
						</table>
						</form>
						</div>
					
				</div>
				<!-- table de categorias -->

			</div>
		</div>
	</div>
</section>



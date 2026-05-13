<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<div class="block">
					<h3>Empresa</h3>
						<div class="table-responsive">
						<form id="form">
						<table class="table table-sm">
							<tbody>
								<tr>
									<td>Nombre</td>
									<td><input type="text" name="nombre" autocomplete="off" id="nombre" class="form-control"  maxlength="200" required value="<?=htmlspecialchars($empresa->nombre)?>"></td>
								</tr>
								<tr>
									<td>Eslogan</td>
									<td><input type="text" name="eslogan" autocomplete="off" id="eslogan" class="form-control" maxlength="100" required value="<?=htmlspecialchars($empresa->eslogan)?>"></td>
								</tr>
								<tr>
									<td>Dirección</td>
									<td><input type="text" name="direccion" autocomplete="off" id="direccion" class="form-control" maxlength="200" required value="<?=htmlspecialchars($empresa->direccion)?>"></td>
								</tr>
								<tr>
									<td>Ciudad</td>
									<td><input type="text" name="ciudad" autocomplete="off" id="ciudad" class="form-control" maxlength="100" required value="<?=htmlspecialchars($empresa->ciudad)?>"></td>
								</tr>
								<tr>
									<td>Correo</td>
									<td><input type="email" name="correo" autocomplete="off" id="correo" class="form-control" maxlength="50" required value="<?=$empresa->correo?>"></td>
								</tr>
								<tr>
									<td></td>
									<td><button type="submit" class="btn btn-success">Guardar</button></td>
								</tr>
							</tbody>
						</table>
						</form>
						</div>					
				</div>

				<div class="block">
				<form method="post" id="formimagen" action="<?=site_url('empresa/logo')?>" enctype="multipart/form-data">
					<h3>Logo</h3>
					<?php if (is_null($empresa->logo)) { ?>
						<h4>Sin logo.</h4>
					<?php } else { ?>
						<img id="logo" name="logo" src="<?=base_url().$empresa->logo?>" class="img-thumbnail" alt="Logo">
					<?php } ?>
					<div class="form-group">
						<label for="imagen1" class="col-form-label">Imagen:</label>
						<input name="imagen1" id="imagen1" class="form-control" type="file" size="190" >
					</div>
					<button type="submit" class="btn btn-success">Guardar</button>
				</form>
				</div>

			</div>
		</div>
	</div>
</section>

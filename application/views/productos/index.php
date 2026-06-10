<section class="no-padding-bottom">
	<div class="container-fluid" id="lista-prod">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block table-responsive">
					<div class="title row">
						<div class="col-sm-12 col-md-6">
							Productos
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="text-right">
								<button class="btn btn-primary" onclick="add()">Agregar</button>
							</div>
						</div>
					</div>
						<div class="row pb-3">
							<div class="col">
								<h5>Existencia: <strong class="text-success" id="exis_id"></strong></h5>
							</div>
							<div class="col">
							</div>
							<div class="col text-center">
								<h5><strong class="text-success" id="pvta_id"></strong></h5>
							</div>
						</div>
						<div class="">
						<table id="dtRegistros" class="table table-sm dataTable">
							<thead>
								<tr class="bg-dark">
									<th>id</th>
									<th>Clave Art.</th>
									<th>Codigo Prov.</th>
									<th>Codigo Barras</th>
									<th>Descripción</th>
									<th>Precio</th>
									<th>Localizacion</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody></tbody>
							<tfoot>
								<tr class="bg-dark">
									<th>id</th>
									<th>Clave Art.</th>
									<th>Codigo Prov.</th>
									<th>Codigo Barras</th>
									<th>Descripción</th>
									<th>Precio</th>
									<th>Localizacion</th>
									<th>Acciones</th>
								</tr>
							</tfoot>
						</table>
						</div>
					
				</div>
				<!-- table de categorias -->

			</div>
		</div>
	</div>



<!-- Modal -->
<div class="container-fluid" id="form-prod">
<div class="row">
  <div class="col">
    <div class="card">
	  
	  <div class="card-header">
        <h5 class="modal-title" id="exampleModalLabel">Producto</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
	  </div>

	  <form method="post" id="form">
      <div class="card-body">
	  <input type="hidden" value="" name="id"/>
	  
		  <div class="row">
		  	  <div class="col">
				<div class="form-group">
					<label for="clave_art" class="col-form-label">Clave art:</label>
					<input type="text" class="form-control form-control-sm" id="clave_art" name="clave_art" autocomplete="off" readonly maxlength="50">
				</div>
			  </div>
			  <div class="col">
				<div class="form-group">
					<label for="codigo_b" class="col-form-label">Codigo barras:</label>
					<input type="text" class="form-control form-control-sm" id="codigo_b" name="codigo_b" autocomplete="off" required maxlength="50">
				</div>
			  </div>
			  <div class="col">
				<div class="form-group">
					<label for="clave_prov" class="col-form-label">Codigo prov.:</label>
					<input type="text" class="form-control form-control-sm" id="clave_prov" name="clave_prov" autocomplete="off" maxlength="50">
				</div>
			  </div>
		  </div>

		  <div class="form-group">
            <label for="descrip" class="col-form-label">Descripción:</label>
            <input type="text" class="form-control form-control-sm" id="descrip" name="descrip" autocomplete="off" required>
          </div>

		  <div class="row">
		  	  <div class="col">
				<div class="form-group">
					<label for="precio_compra" class="col-form-label">Costo:</label>
					<input type="text" class="form-control form-control-sm" id="precio_compra" name="precio_compra" autocomplete="off" required value="0">
				</div>
			  </div>
			  <div class="col">
				<div class="form-group">
					<label for="precio_uni" class="col-form-label">Precio ultima compra:</label>
					<input type="text" class="form-control form-control-sm" id="precio_uni" name="precio_uni" autocomplete="off" required value="0">
				</div>
			  </div>
			  <div class="col">
				<div class="form-group">
					<label for="precio_venta_aux" class="col-form-label">Precio venta referencia:</label>
					<input type="text" class="form-control form-control-sm" id="precio_venta_aux" name="precio_venta_aux" autocomplete="off" required value="0">
				</div>
			  </div>
			  <div class="col">
				<div class="form-group">
					<label for="precio_venta" class="col-form-label">Precio venta:</label>
					<input type="text" class="form-control form-control-sm" id="precio_venta" name="precio_venta" autocomplete="off" required value="0">
				</div>
			  </div>
		  </div>

		  <div class="row">
			<div class="col">
					<div class="form-group">
						<label for="proveedor_id" class="col-form-label">Proveedor:</label>
						<select class="form-control form-control-sm" id="proveedor_id" name="proveedor_id" required>
						<?php foreach($proveedores->result() as $item):?>
						<option value="<?=$item->id?>"><?=$item->nombre?></option>
						<?php endforeach; ?>
						</select>
					</div>  
			</div>
			  <div class="col">
				<div class="form-group">
					<label for="marca" class="col-form-label">Marca:</label>
					<input type="text" class="form-control form-control-sm" id="marca" name="marca" autocomplete="off" maxlength="25">
				</div>
			  </div>
			  <div class="col">
				<div class="form-group">
					<label for="unidad" class="col-form-label">Unidad:</label>
					<input type="text" class="form-control form-control-sm" id="unidad" name="unidad" autocomplete="off" maxlength="25">
				</div>
			  </div>
		  </div>

		  <div class="row">
			  
			  <div class="col">
				<div class="form-group">
					<label for="minimo" class="col-form-label">Minimo:</label>
					<input type="number" class="form-control form-control-sm" id="minimo" name="minimo" autocomplete="off" min="0" step="1" lang="en" value="0" required>
				</div>
			  </div>
			  <div class="col">
				<div class="form-group">
					<label for="localizacion" class="col-form-label">Localización:</label>
					<input type="text" class="form-control form-control-sm" id="localizacion" name="localizacion" autocomplete="off" maxlength="25">
				</div>
			  </div>
			  <div class="col">
				<div class="form-group">
					<label for="existencias" class="col-form-label">Existencias:</label>
					<input type="text" class="form-control form-control-sm" id="existencias" name="existencias" autocomplete="off" required value="0">
				</div>
			  </div>
		  </div>

		  <div class="row">
		  	  <div class="col">
				<div class="form-group">
					<label for="url" class="col-form-label">URL:</label>

					<div class="input-group mb-3">
					<input type="text" class="form-control form-control-sm" id="url" name="url" autocomplete="off" >
					<div class="input-group-append">
						<button class="btn btn-sm btn-outline-secondary" type="button" onclick="visitarPag()" id="button-addon2">Go!</button>
					</div>
					</div>

				</div>
			  </div>
			  <div class="col">
				<div class="form-group">
					<label for="act_pre" class="col-form-label">Fecha actualizacion precio:</label>
					<input type="text" class="form-control form-control-sm" id="act_pre" name="act_pre" autocomplete="off" readonly>
				</div>
			  </div>
			  <div class="col">
				<div class="form-group">
					<label for="actualiza" class="col-form-label">Actualiza:</label>
					<select class="form-control form-control-sm" id="actualiza" name="actualiza">
					<option value="1">SI</option>
					<option value="0">NO</option>
					</select>
				</div>
			  </div>
			  <div class="col">
				<div class="form-group" id="pnlbaja">
					<label for="baja" class="col-form-label">Baja:</label>
					<select class="form-control form-control-sm" id="baja" name="baja">
					<option value="0">NO</option>
					<option value="1">SI</option>					
					</select>
				</div>
			  </div>
		  </div>	  
        
      </div>
      <div class="card-footer text-right">
		<div class="btn-group float-left" role="group" id="consultas">
			<button id="btnGroupDrop1" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Consulta
			</button>
			<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
			<a href="#" class="dropdown-item" id="btn-ventas" onclick="ventas()">Ventas</a>
			<a href="#" class="dropdown-item" id="btn-compras" onclick="compras()">Compras</a>
			<a href="#" class="dropdown-item" id="btn-kardex" onclick="kardex()">Kardex</a>
			<a href="#" class="dropdown-item" onclick="image2()" >Imagen</a>
			</div>
		</div>
		<button type="button" class="btn btn-secondary" onclick="cancelar()">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
	  </div>
	  </form>

    </div>
  </div>
</div>
</div>

</section>

<!-- Modal image -->
<div class="modal fade" id="modal_form_image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	  
	  <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Imagen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
	  </div>

	  <form method="post" id="formimagen">
      <div class="modal-body">
	  <input type="hidden" value="" name="id"/>
	  
	      <div class="form-group">
                      <div class="col-sm-12">
                        <img id="imageproducto" name="imageproducto"    src="" class="img-thumbnail" alt="sinImagen">
                      </div>
          </div>

          
		  <div class="form-group">
            <label for="localizacion" class="col-form-label">Imagen:</label>
            <input name="imagen1" class="form-control" type="file" size="190" >
          </div>
		  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
	  </div>
	  </form>

    </div>
  </div>
</div>

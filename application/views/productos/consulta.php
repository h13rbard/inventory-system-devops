<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					<div class="title">
						Productos
						<h5>Exist.: <strong class="text-success" id="exis_id"></strong></h5>
					</div>
					
						<div class="table-responsive">
						<table id="dtRegistros" class="table table-sm datatable">
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
							<tbody></tbody>
						</table>
						</div>
					
				</div>
				<!-- table de categorias -->

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

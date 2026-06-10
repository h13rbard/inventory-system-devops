<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-11 col-lg-11 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					<div class="title">
						<button class="btn btn-primary" onclick="add()">Agregar</button>
						Categorias
					</div>
					
						<div class="table-responsive">
						<table id="dtRegistros" class="table table-striped table-sm">
							<thead>
								<tr>
									<th>id</th>
									<th>Nombre</th>
									<th>Tipo</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
						</div>
					
				</div>
				<!-- table de categorias -->

			</div>
		</div>
	</div>
</section>


<!-- Modal -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	  
	  <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
	  </div>

	  <form method="post" id="form">
      <div class="modal-body">
	  <input type="hidden" value="" name="id"/>
          <div class="form-group">
            <label for="nombre" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off" required maxlength="100">
          </div>
					<div class="form-group">
            <label for="tipo" class="col-form-label">Tipo:</label>
            <select class="form-control" name="tipo" id="tipo">
							<option value="I" >Ingreso</option>
							<option value="E" >Egreso</option>
						</select>
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

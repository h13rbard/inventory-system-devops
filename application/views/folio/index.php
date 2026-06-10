<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block table-responsive">
					<div class="title row">
						<div class="col-sm-12 col-md-6">
						Folio
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="text-right">
								<button class="btn btn-primary" onclick="add()">Agregar</button>
							</div>
						</div>
					</div>
					
						<div class="">
						<table id="dtRegistros" class="table table-sm datatable">
							<thead>
								<tr class="bg-dark">
									<th>id</th>
									<th>Serie</th>
									<th>Proceso</th>
									<th>Descripción</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody></tbody>
							<tfoot>
								<tr class="bg-dark">
									<th>id</th>
									<th>Serie</th>
									<th>Proceso</th>
									<th>Descripción</th>
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


<!-- Modal -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
	  
	  <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Concepto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
	  </div>

	  <form method="post" id="form">
      <div class="modal-body">
	  <input type="hidden" value="" name="id"/>
	  
	  	  <div class="form-group">
            <label for="serie" class="col-form-label">Serie:</label>
            <input type="text" class="form-control form-control-sm" id="serie" name="serie" maxlength="10" autocomplete="off" required>
          </div> 

		  <div class="form-group">
            <label for="consecutivo" class="col-form-label">Consecutivo:</label>
            <input type="number" class="form-control form-control-sm" id="consecutivo" name="consecutivo" step="1" min="0" autocomplete="off" required>
          </div>

		  <div class="form-group">
            <label for="longitud" class="col-form-label">Longitud:</label>
            <input type="number" class="form-control form-control-sm" id="longitud" name="longitud" step="1" min="1" autocomplete="off" >
          </div>

		  <div class="form-group">
            <label for="clave_proceso" class="col-form-label">Clave proceso:</label>
            <input type="text" class="form-control form-control-sm" id="clave_proceso" name="clave_proceso" maxlength="3" autocomplete="off" >
          </div>

		  <div class="form-group">
            <label for="descripcion" class="col-form-label">Descripción:</label>
            <input type="text" class="form-control form-control-sm" id="descripcion" name="descripcion" maxlength="200" autocomplete="off" >
          </div>

		  <div class="form-group">
            <label for="tipo" class="col-form-label">Tipo:</label>
            <input type="text" class="form-control form-control-sm" id="tipo" name="tipo" maxlength="50" autocomplete="off" >
          </div>

		  <div class="form-group">
            <label for="tipo_id" class="col-form-label">Tipo Id:</label>
            <input type="number" class="form-control form-control-sm" id="tipo_id" name="tipo_id" step="1" min="0" autocomplete="off" value="0" >
          </div>	  

		  <div class="form-group">
            <label for="activo" class="col-form-label">Activo:</label>
            <select class="form-control form-control-sm" id="activo" name="activo">
			<option value="1">SI</option>
			<option value="0">NO</option>
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


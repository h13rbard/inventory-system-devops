<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block table-responsive">
					<div class="title row">
						<div class="col-sm-12 col-md-6">
							Almacenes
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
									<th>Clave</th>
									<th>Nombre</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody></tbody>
							<tfoot>
								<tr class="bg-dark">
									<th>id</th>
									<th>Clave</th>
									<th>Nombre</th>
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
            <label for="clave" class="col-form-label">Clave:</label>
            <input type="text" class="form-control form-control-sm" id="clave" name="clave" maxlength="3" autocomplete="off" required>
          </div> 

		  <div class="form-group">
            <label for="nombre" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" maxlength="25" autocomplete="off" required>
          </div>

		  <div class="form-group">
            <label for="tipo" class="col-form-label">Tipo:</label>
            <input type="text" class="form-control form-control-sm" id="tipo" name="tipo" maxlength="25" autocomplete="off" >
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


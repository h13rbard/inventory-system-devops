<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block table-responsive">
					<div class="title row">
						<div class="col-sm-12 col-md-6">
						Clientes
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
            <input type="text" class="form-control form-control-sm" id="clave" name="clave" maxlength="5" autocomplete="off" readonly>
          </div> 

		  <div class="form-group">
            <label for="nombre" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" maxlength="50" autocomplete="off" required>
          </div>

		  <div class="form-group">
            <label for="direccion" class="col-form-label">Dirección:</label>
            <input type="text" class="form-control form-control-sm" id="direccion" name="direccion" maxlength="100" autocomplete="off" >
          </div>

		  <div class="form-group">
            <label for="telefono" class="col-form-label">Telefono:</label>
            <input type="text" class="form-control form-control-sm" id="telefono" name="telefono" maxlength="20" autocomplete="off" >
          </div>

		  <div class="form-group">
            <label for="correo" class="col-form-label">Correo:</label>
            <input type="email" class="form-control form-control-sm" id="correo" name="correo" maxlength="50" autocomplete="off" >
          </div>	  
        
		  <div class="form-group">
			<button type="button" class="btn btn-sm btn-secondary" id="btn-ventas" onclick="ventas()">Ventas</button>
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


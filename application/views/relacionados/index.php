<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					<div class="title">
					
						Productos relacionados 
					</div>
					<form action="" id="form-agregar">
					<table class="table table-sm">
						<tbody>
							<tr>
								<td>Clave</td>
								<td>
								<input type="text" name="clave1" id="clave1" maxlength="50" class="form-control form-control-sm" required autocomplete="off">
								</td>
							</tr>
							<tr>
								<td>Clave</td>
								<td>
								<input type="text" name="clave2" id="clave2" maxlength="50" class="form-control form-control-sm" required autocomplete="off">
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
								<button class="btn btn-primary" type="submit">Agregar</button>
								</td>
							</tr>
						</tbody>
					</table>
					</form>
					
						<div class="table-responsive">
						<table id="dtRegistros" class="table table-sm datatable">
							<thead>
								<tr class="bg-dark">
									<th>id</th>
									<th>Clave</th>
									<th>Descripción</th>
									<th>Existencias</th>
									<th>Clave</th>
									<th>Descripción</th>
									<th>Existencias</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody></tbody>
							<tfoot>
								<tr class="bg-dark">
									<th>id</th>
									<th>Clave</th>
									<th>Descripción</th>
									<th>Existencias</th>
									<th>Clave</th>
									<th>Descripción</th>
									<th>Existencias</th>
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
            <label for="prod1" class="col-form-label">Producto 1:</label>
            <input type="text" class="form-control form-control-sm" id="prod1" name="prod1"  autocomplete="off" readonly>
          </div> 

		  <div class="form-group">
            <label for="prod2" class="col-form-label">Producto 2:</label>
            <input type="text" class="form-control form-control-sm" id="prod2" name="prod2" autocomplete="off" readonly>
          </div>

		  <div class="form-group">
            <label for="comentario" class="col-form-label">Comentario:</label>
            <input type="text" class="form-control form-control-sm" id="comentario" name="comentario" maxlength="250" autocomplete="off" >
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


<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block table-responsive">
					<div class="title row">
						<div class="col-sm-12 col-md-6">
						Resultados semanales
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
									<th>Semana</th>
									<th>Fecha</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody></tbody>
							<tfoot>
								<tr class="bg-dark">
									<th>id</th>
									<th>Semana</th>
									<th>Fecha</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Semana</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
	  </div>

	  <form method="post" id="form">
      <div class="modal-body">
	  <input type="hidden" value="" name="id"/>
	  
	  	<div class="row">
		<div class="col">
	  	  <div class="form-group">
            <label for="fecha" class="col-form-label">Fecha:</label>
            <input type="date" class="form-control form-control-sm" id="fecha" name="fecha" autocomplete="off" required>
          </div> 
		</div>

		<div class="col">
		  <div class="form-group">
            <label for="semana" class="col-form-label">Semana:</label>
            <input type="text" class="form-control form-control-sm" id="semana" name="semana" autocomplete="off" required>
          </div> 
		</div>
		</div>

		<div class="row">
		<div class="col">
		  <div class="form-group">
            <label for="costo" class="col-form-label">Costo:</label>
            <input type="number" step="0.01" class="form-control form-control-sm" id="costo" name="costo" autocomplete="off" required>
          </div> 
		</div>

		<div class="col">
		  <div class="form-group">
            <label for="venta_total" class="col-form-label">Venta total:</label>
            <input type="number" step="0.01" class="form-control form-control-sm" id="venta_total" name="venta_total" autocomplete="off" required>
          </div> 
		</div>
		</div>

		<div class="row">
		<div class="col">
		  <div class="form-group">
            <label for="venta_cre" class="col-form-label">Venta credito:</label>
            <input type="number" step="0.01" class="form-control form-control-sm" id="venta_cre" name="venta_cre" autocomplete="off" required>
          </div> 
		</div>

		<div class="col">
		  <div class="form-group">
            <label for="venta_con" class="col-form-label">Venta contado:</label>
            <input type="number" step="0.01" class="form-control form-control-sm" id="venta_con" name="venta_con" autocomplete="off" required>
          </div>
		</div>
		</div>

		<div class="row">
		<div class="col">
		  <div class="form-group">
            <label for="sueldo" class="col-form-label">Sueldo:</label>
            <input type="number" step="0.01" class="form-control form-control-sm" id="sueldo" name="sueldo" autocomplete="off" required>
          </div> 
		</div>

		<div class="col">
		  <div class="form-group">
            <label for="cobranza" class="col-form-label">Cobranza:</label>
            <input type="number" step="0.01" class="form-control form-control-sm" id="cobranza" name="cobranza" autocomplete="off" required>
          </div> 
		</div>
		</div>

		<div class="row">
		<div class="col">
		  <div class="form-group">
            <label for="compras" class="col-form-label">Compras:</label>
            <input type="number" step="0.01" class="form-control form-control-sm" id="compras" name="compras" autocomplete="off" required>
          </div> 
		</div>

		<div class="col">
		  <div class="form-group">
            <label for="gastos" class="col-form-label">Gastos:</label>
            <input type="number" step="0.01" class="form-control form-control-sm" id="gastos" name="gastos" autocomplete="off" required>
          </div> 
		</div>

		<div class="col">
		  <div class="form-group">
            <label for="desecho" class="col-form-label">Desecho:</label>
            <input type="number" step="0.01" class="form-control form-control-sm" id="desecho" name="desecho" autocomplete="off" required>
          </div>
		</div>
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


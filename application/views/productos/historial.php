<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de productos -->
				<div class="block">
					<div class="title">
						Historial Productos
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
				<!-- table de productos -->

			</div>
		</div>
	</div>
</section>


<!-- Modal -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
	  
	  <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Historial</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
	  </div>

      <div class="modal-body">
	<div id="resultado" class="table-reponsive"></div>
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	  </div>

    </div>
  </div>
</div>

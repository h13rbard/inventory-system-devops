<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-11 col-lg-11 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					<div class="title">
						<button class="btn btn-primary" onclick="add()">Agregar</button>
						Conceptos
					</div>
					
						<div class="table-responsive">
						<table id="dtRegistros" class="table table-striped table-sm">
							<thead>
								<tr>
									<th>id</th>
									<th>Nombre</th>
									<th>Categoria</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Concepto</h5>
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
			<label class="control-label">Categoria:</label>
			<select class="form-control" name="categoria_id" id="categoria_id">
			<?php foreach ($categorias->result() as $item):?>
				<option value="<?= $item->id?>" ><?= $item->nombre?></option>
			<?php endforeach;?>
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

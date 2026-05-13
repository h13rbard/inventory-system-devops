<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<div class="block">
				<div class="table-responsive">
					<table class="table table-sm datatable" id="encabezado">
						<tbody>
							<tr>
								<td></td>
								<td></td>
								<td><input type="text" name="no_referencia" id="no_referencia" class="form-control form-control-sm" placeholder="No. Nota/Factura" maxlength="50" value="<?=$pedido->no_referencia?>"></td>
								<td><input type="date" name="fecha_compra" id="fecha_compra" class="form-control form-control-sm" placeholder="Fecha compra" value="<?=$pedido->fecha_compra?>"></td>
							</tr>
							<tr>
								<td>Folio</td>
								<td><?=$pedido->folio?> <?=$pedido->estado=='P' ? 'PENDIENTE' : 'CERRADO'?></td>
								<td><input type="text" name="proveedor" id="proveedor" class="form-control form-control-sm" placeholder="Proveedor" maxlength="50" value="<?=$pedido->proveedor?>" disabled></td>
								<td>
								<select name="pago" class="form-control form-control-sm" id="pago" disabled>
								<option value="CON" <?= ($pedido->pago =="CON") ? 'selected' : ''?>>CONTADO</option>
								<option value="CRE" <?= ($pedido->pago =="CRE") ? 'selected' : ''?>>CREDITO</option>
								</select>
								</td>
							</tr>
							<tr>
								<td>Fecha</td>
								<td><?=$pedido->fecha.' '.$pedido->hora?></td>
								<td colspan="2"><h3 class="text-center" id="total_compra">$ <?=number_format($pedido->total,2)?></h3></td>
							</tr>
							<tr>								
								<td colspan="2"><input type="text" name="barcode" id="barcode" class="form-control form-control-sm" placeholder="Codigo de barras" ></td>
								<td colspan="2" class="text-center"><button type="button" class="btn btn-info" onclick="confirmar()">CONFIRMAR</button></td>
							</tr>
						</tbody>
					</table>

					<table class="table table-sm datatable" id="partidas">
						<thead>
							<tr class="bg-dark">
								<th>Clave</th>
								<th>Descripción</th>
								<th>Precio Compra</th>
								<th>Cantidad</th>
								<th>Importe</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							foreach ($partidas->result() as $row)
							{ ?>
							<tr>
								<td><?=$row->clave_art?></td>
								<td><?=$row->descrip?></td>
								<td class="fila-precio">
								<input type="number" name="precio_<?=$row->id?>" id="precio_<?=$row->id?>" min="0" lang="en" step="0.0001" required class="form-control form-control-sm precio-compra" value="<?=number_format($row->precio, 4,'.','')?>" data-partida2="<?=$row->id?>" data-cantidad2="<?=$row->cantidad?>" data-precio2="<?=$row->precio?>">
								</td>
								<td class="fila-cantidad">
								<input type="number" name="cantidad_<?=$row->id?>" id="cantidad_<?=$row->id?>" min="0" lang="en" step="0.0001" required class="form-control form-control-sm cantidad" value="<?=number_format($row->cantidad, 4,'.','')?>" data-partida="<?=$row->id?>" data-cantidad="<?=$row->cantidad?>" data-precio="<?=$row->precio?>">
								</td>
								<td id="importe_<?=$row->id?>"><?=number_format($row->cantidad * $row->precio, 4)?></td>
								<td><a href="<?=base_url().'compra/del_partida/'.$pedido->id.'/'.$row->id?>" class="btn btn-sm btn-danger">Eliminar</a></td>
							</tr>
							<?php }
							?>						
						</tbody>
					</table>

					
				</div>
				</div>

				<!-- table de categorias -->
				<div class="block table-responsive">
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
						<table id="dtRegistros" class="table table-sm datatable">
							<thead>
								<tr class="bg-dark">
									<th>id</th>
									<th>Clave Art.</th>
									<th>Codigo Prov.</th>
									<th>Codigo Barras</th>
									<th>Descripción</th>
									<th>Precio</th>
									<th>Localización</th>
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
									<th>Localización</th>
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
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	  
	  <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Concepto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
	  </div>

	  <form id="form_confirmar">
      <div class="modal-body">
	  <input type="hidden" value="" name="id"/>
          
	  	  <div class="form-group">
            <label for="total_doc" class="col-form-label">Total a pagar:</label>
            <input type="text" class="form-control" id="total_doc" name="total_doc" autocomplete="off" readonly>
          </div>

		  <div class="form-group">
            <label for="total_pago" class="col-form-label">Pago:</label>
            <input type="text" class="form-control" id="total_pago" value="0" name="total_pago" autocomplete="off" required>
          </div>

		  <div class="form-group">
            <label for="cambio_doc" class="col-form-label">Cambio:</label>
            <input type="text" class="form-control" id="cambio_doc" name="cambio_doc" autocomplete="off" readonly>
          </div>
		  
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-info" >Confirmar</button>
	  </div>
	  </form>

    </div>
  </div>
</div>

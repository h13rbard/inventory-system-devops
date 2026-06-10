<div class="table-responsive">
<table id="dtRegistros" class="table table-sm table-hover datatable">
	<thead>
		<tr class="bg-dark">
			<th>Clave</th>
			<th>Cod. Prov.</th>
			<th>Cod. Barras</th>
			<th>Descripción</th>
			<th>Existencia</th>
			<th>Compra</th>
			<th>Venta</th>
			<th>Porcentaje</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$i = 0;
	foreach($productos->result() as $item): 
		$i++;
		?>
	<tr>
		<td><?=$item->clave_art?></td>
		<td><?=$item->clave_prov?></td>
		<td><?=$item->codigo_b?></td>
		<td><?=$item->descrip?></td>
		<td class="text-right"><?= number_format($item->existencias,2) ?></td>
		<td class="text-right"><?= number_format($item->precio_compra,2) ?></td>
		<td class="text-right"><?= number_format($item->precio_venta,2) ?></td>
		<td class="text-right"><?= number_format(($item->utilidad - 1) * 100, 0) ?></td>
	</tr>
	<?php endforeach; ?>	
	</tbody>
	<tfoot>
		<tr class="bg-dark">
			<th>Clave</th>
			<th>Cod. Prov.</th>
			<th>Cod. Barras</th>
			<th>Descripción</th>
			<th>Existencia</th>
			<th>Compra</th>
			<th>Venta</th>
			<th>Porcentaje</th>
		</tr>
	</tfoot>
</table>
</div>

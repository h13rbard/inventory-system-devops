<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

			<div class="block">
			<div class="table-responsive">
			<table class="table table-sm datatable table-hover" id="example">	
			<thead>
			<tr class="bg-dark">
			<th>Grupo</th>
			<th>Productos</th>
			<th>Importe</th>
			</tr>
			</thead>
			<tbody>	
<?php 
foreach($grupos->result() as $item) {
	echo '<tr>';
	echo '<td>'.$item->nombre.'</td>';
	echo '<td class="text-right">'.number_format($item->no_productos,2).'</td>';
	echo '<td class="text-right">'.number_format($item->importe,2).'</td>';
	echo '</tr>';
}
?>
</tbody>
</table>
			</div>
			</div>

		</div>
	</div>
</section>

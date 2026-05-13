<section class="no-padding-bottom">
	<div class="container-fluid">

	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-header"><h5>Productos con Claves parecidas</h5></div>
				<div class="card-body">

		<table class="table table-striped table-sm datatable" id="example">
		<thead><tr class="bg-dark"><th>Clave</th><th>Descripción</th><th>Clave</th><th>Descripción</th><th>Relacionados</th></tr></thead>
		<tbody>
		<?php 
		$anterior = '';
		$descrip = '';
		$i = 0;
		$id_anterior = 0;
		foreach($data->result() as $item) 
		{
			if ($i == 0) {
				$anterior = $item->clave_art;
				$descrip = $item->descrip;
				$id_anterior = $item->id;
				$i++;
				continue;
			}
			$i++;
			if(strpos($item->clave_art, $anterior) !== false) {
				echo '<tr>';
				echo '<td>'.$anterior.'</td>';
				echo '<td>'.$descrip.'</td>';
				echo '<td>'.$item->clave_art.'</td>';
				echo '<td>'.$item->descrip.'</td>';
				echo '<td>';
				echo ($id_anterior == $item->producto1_id || $id_anterior == $item->producto2_id) ? '<span class="badge badge-success"><i class="fa fa-check"></i> Si</span>' : '<span class="badge badge-danger"><i class="fa fa-close"></i> No</span>';
				echo '</td>';
				echo '</tr>';
			} else {
				$anterior = $item->clave_art;
				$descrip = $item->descrip;
				$id_anterior = $item->id;
			}
		}
		?>
		</tbody>
		</table>

		</div>
		</div>
		</div>
	</div>
	</div>
</section>

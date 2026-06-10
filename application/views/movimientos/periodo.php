<section class="no-padding-bottom">
	<div class="container-fluid">
		
		<div class="block">
		<form action="" method="post">
		<div class="row">
			<div class="col">
				<Label>Periodo:</Label>
			</div>
			<div class="col">
				<input class="form-control" type="date" name="inicio" id="inicio">
			</div>
			<div class="col">
				<input class="form-control" type="date" name="fin" id="fin">
			</div>
			<div class="col">
				<button type="submit" class="btn btn-primary">Buscar</button>
			</div>
		</div>
		</form>
		</div>

		<div class="row">
	
			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="card">
					<div class="card-header">Movimientos <?=!is_null($movimientos) ? 'del '.$inicio.' al '.$fin : '' ?></div>
					<div class="card-body">
					<div class="table-responsive">
					<table class="table table-sm table-striped table-hover">
					<thead>
						<tr>
							<th class="col-2">Categoria</th>
							<th class="col-3">Concepto</th>
							<th class="col-1">Ingreso</th>
							<th class="col-1">Egreso</th>
						</tr>
					</thead>
					<tbody id="registros">
					<?php
					$ingresos = 0;
					$egresos = 0; 
					if (!is_null($movimientos)) :
					foreach($movimientos->result() as $item) : ?>
						<tr>
							<td><?=$item->categoria?></td>
							<td><?=$item->concepto?></td>
							<td class="text-right"><?=$item->tipo=='I' ? number_format($item->total, 2) : '0' ?></td>
							<td class="text-right"><?=$item->tipo=='E' ? number_format($item->total, 2) : '0' ?></td>
						</tr>
					<?php 
					$ingresos += ($item->tipo=='I') ? $item->total : 0;
					$egresos += ($item->tipo=='E') ? $item->total : 0;

					endforeach; 
					endif;
					?>
					</tbody>
					<tfoot>
					<tr>
						<th></th>
						<th></th>
						<th class="text-right"><?=number_format($ingresos, 2)?></th>
						<th class="text-right"><?=number_format($egresos, 2)?></th>
					</tr>
					</tfoot>
					</table>
					<br>
					<h4 class="text-center text-success">Saldo: <b class="" id="resultado"><?=number_format($ingresos-$egresos, 2)?></b></h4>

					</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

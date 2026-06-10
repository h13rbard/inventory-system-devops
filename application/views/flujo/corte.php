<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					<h3>Corte - <?=$corte->folio?> - <?=$corte->fecha?></h3>
						
					<?php 
					
					echo '<table class="table table-sm datatable table-hover">';
		echo '<tr class="bg-dark"><th>Fecha</th><th>Concepto</th><th>Ingreso</th><th>Egreso</th></tr>';
		$total_ingreso = 0;
		$total_egreso = 0;
		foreach($movimientos->result() as $item)
		{
			echo '<tr>';
			echo '<td>'.$item->fecha.'</td>';
			echo '<td>'.$item->concepto.'</td>';
			echo '<td class="text-right">'.($item->tipo == 'I' ? number_format($item->importe, 2) : '0.00').'</td>';
			echo '<td class="text-right">'.($item->tipo == 'E' ? number_format($item->importe, 2) : '0.00').'</td>';
			echo '</tr>';
			if ($item->tipo == 'E')
			$total_egreso += $item->importe;
			if ($item->tipo == 'I')
			$total_ingreso += $item->importe;
		}
		echo '<tr><td></td><td></td><td class="text-right">'.number_format($total_ingreso,2).'</td><td class="text-right">'.number_format($total_egreso,2).'</td></tr>';
		echo '<tr><td></td><td class="text-center">SALDO</td><td class="text-center" colspan="2">'.number_format($total_ingreso-$total_egreso,2).'</td>';
		echo '</tr>';
		echo '</table>';
		echo '<br>';

					?>
				</div>
				<!-- table de categorias -->

			</div>
		</div>
	</div>
</section>

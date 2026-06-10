<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					<h3>Cobranza</h3>
						<div class="table-responsive">
						<p><?=$cliente->clave?> <?=$cliente->nombre?></p>
						<form id="form" method="post" action="<?=base_url()?>cobranza/guardar_abono">
						<input type="hidden" name="cliente" value="<?=$cliente->nombre?>">
						<input type="hidden" name="cliente_id" value="<?=$cliente->id?>">
						<table class="table table-sm table-bordered">
						<tbody>
						<tr class="thead-dark">
						<th class="col-2">Fecha</th>
						<th class="col-2">Concepto</th>
						<th class="col-2">No. Referencia</th>
						<th class="col-2">Cliente</th>
						<th class="col-2">Cargo</th>
						<th class="col-2">Abono</th>
						</tr>
						<?php 
						$venta_id = 0; $total_resta =0;
						$cargos = 0; $abonos = 0;
						foreach($partidas->result() as $partida): ?>
							<?php if($venta_id!=0 && $venta_id!=$partida->venta_id && $partida->movimiento=='C'): ?>
							<tr class="table-active">
							<td></td>
							<td></td>
							<td>RESTA</td>
							<td><?=number_format($cargos-$abonos, 2)?></td>
							<td>ABONAR</td>
							<td>
							<input type="hidden" name="cargo[]" value="<?=$venta_id?>">
							<input type="number" name="abono[]" id="" class="form-control form-control-sm abono" min="0" value="0" step="0.01" lang="en" max="<?=number_format($cargos-$abonos, 2)?>" required></td>
							</tr>
							<?php endif; ?>
							<?php if($partida->movimiento=='C'):?>
							<tr>
							<td><?=$partida->fecha?></td>
							<td><?=$partida->concepto?></td>
							<td><?=$partida->no_referencia?></td>
							<td><?=$partida->cliente?></td>
							<td><?=$partida->movimiento=='C'? number_format($partida->importe, 2) : '-'?></td>
							<td><?=$partida->movimiento=='A'? number_format($partida->importe, 2) : '-'?></td>
							</tr>
							<?php endif; ?>
							<?php 
							$venta_id = $partida->venta_id;
							if ($partida->movimiento=='C') {
							$cargos = $partida->importe;
							$abonos = 0;
							}
							if ($partida->movimiento=='A')
								$abonos += $partida->importe;
							$total_resta += ($partida->movimiento=='C') ? $partida->importe : $partida->importe*-1;
							?>
						<?php endforeach; ?>
						<?php if($venta_id!=0): ?>
							<tr class="table-active">
							<td></td>
							<td></td>
							<td>RESTA</td>
							<td><?=number_format($cargos-$abonos, 2)?></td>
							<td>ABONAR</td>
							<td>
							<input type="hidden" name="cargo[]" value="<?=$venta_id?>">
							<input type="number" name="abono[]" id="" class="form-control form-control-sm abono" min="0" value="0" step="0.01" lang="en" max="<?=number_format($cargos-$abonos, 2)?>" required></td>
							</tr>
						<?php endif; ?>
						</tbody>
						<tfoot>
						<tr>
						<th></th>
						<th>Total Abono</th>
						<th><span id="total_abonos" class="text-success"> 0.00</span></th>
						<th>Resta Total</th>
						<th><span id="total_resta" class="text-danger"><?=number_format($total_resta, 2);?></span></th>
						<th><button type="submit" class="btn btn-success">Guardar</button></th>
						</tr>
						</tfoot>
						</table>
						</form>
						</div>					
				</div>
				<!-- table de categorias -->
			</div>
		</div>
	</div>
</section>
<script>
var total_resta=<?=number_format($total_resta, 2);?>;
</script>

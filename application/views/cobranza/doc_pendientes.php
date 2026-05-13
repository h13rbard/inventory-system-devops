<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<div class="block">
					<h5>DOC. PENDIENTES CON MAS DE 30 DIAS</h5>
					<div class="table-responsive">
					<table class="table table-sm datatable">
						<tr class="bg-dark">
						<th>NO. REFERENCIA</th>
						<th>CLIENTE</th>
						<th>FECHA</th>
						<th>IMPORTE</th>
						<th>RESTA</th>
						</tr>
						<?php 
						$sum_pend = 0;
						foreach($pendientes->result() as $item) { ?>
							<tr>
							<td><?=$item->no_referencia?></td>
							<td><?=$item->cliente?></td>
							<td><?=$item->fecha?></td>
							<td align="right"><?=$item->importe?></td>
							<td align="right"><?=$item->saldo?></td>
							</tr>
						<?php $sum_pend += $item->saldo; } ?>
						<tr>
						<th></th>
						<th></th>
						<th></th>
						<th>Total</th>
						<td align="right"><?=number_format($sum_pend, 2)?></td>
						</tr>
					</table>
					</div>					
				</div>

				<div class="block">
					<h5>DOC. PENDIENTES</h5>
					<div class="table-responsive">
					<table class="table table-sm datatable">
					<tr class="bg-dark">
						<th>NO. REFERENCIA</th>
						<th>CLIENTE</th>
						<th>FECHA</th>
						<th>IMPORTE</th>
						<th>RESTA</th>
						</tr>
						<?php 
						$sum_ant = 0;
						foreach($antiguos->result() as $item) { ?>
							<tr>
							<td><?=$item->no_referencia?></td>
							<td><?=$item->cliente?></td>
							<td><?=$item->fecha?></td>
							<td align="right"><?=$item->importe?></td>
							<td align="right"><?=$item->saldo?></td>
							</tr>
						<?php $sum_ant += $item->saldo; } ?>
						<tr>
						<th></th>
						<th></th>
						<th></th>
						<th>Total</th>
						<td align="right"><?=number_format($sum_ant, 2)?></td>
						</tr>
					</table>
					</div>					
				</div>

			</div>
		</div>
	</div>
</section>

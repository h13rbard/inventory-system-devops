<section class="no-padding-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">

				<!-- table de categorias -->
				<div class="block">
					
						<div class="table-responsive">
						<table id="dtRegistros" class="table table-sm table-hover datatable">
							<thead>
								<tr class="bg-dark">
									<th>#</th>
									<th>Clas</th>
									<th>Clave</th>
									<th>Cod. Prov.</th>
									<th>Descripción</th>
									<th>Compra</th>
									<th>Venta</th>
									<th>Existencias</th>
									<th>Actualización</th>
									<th>URL</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$i = 0;
							$total_importe = 0;
							$j =0;
							$marca = '';
							$marcas = [];
							$a = 0; $bmas =0; $bmenos=0; $b=0; $c=0; $d=0;
							foreach($productos->result() as $item): 
								
								
								if ($marca != $item->marca) {
									array_push($marcas, [
										'marca' => $marca, 
										'no' => $j,
										'a' => $a,
										'bmas' => $bmas,
										'bmenos' => $bmenos,
										'b' => $b,
										'c' => $c,
										'd' => $d, 
										'total_importe' => number_format($total_importe, 2)
									]);
									$j =0;
									$a = 0; $bmas =0; $bmenos=0; $b=0; $c=0;
									echo '<tr><td class="bg-secondary text-center text-white" colspan="10">Marca '.$item->marca.'</td></tr>';
									$i++;
									$total_importe = 0;
								}
								$j++;
								$total_importe += $item->existencias * $item->precio_compra;
								$marca = $item->marca;
								if($item->clasif == 'A') $a++; 
								if($item->clasif == 'B+') $bmas++; 
								if($item->clasif == 'B-') $bmenos++; 
								if($item->clasif == 'B') $b++; 
								if($item->clasif == 'C') $c++; 
								if($item->clasif == 'D') $d++; 
								?>
							<tr>
								<td><?=$j?></td>
								<td><?=$item->clasif?></td>
								<td><?=$item->clave_art?></td>
								<td><?=$item->clave_prov?></td>
								<td><?=$item->descrip?></td>
								<td class="text-right"><?=number_format($item->precio_compra, 2)?></td>
								<td class="text-right"><?=number_format($item->precio_venta, 2)?></td>
								<td class="text-right"><?=number_format($item->existencias, 2)?></td>
								<td><?=$item->act_pre?></td>
								<td><?= (empty($item->url)) ? '' : '<a class="btn btn-sm btn-primary" target="_blank" href="'.$item->url.'">Ver</a>'?></td>
							</tr>
							<?php endforeach; ?>	
							</tbody>
							<tfoot>
								<tr>
									<th colspan="10">No. Marcas: <?=$i?></th>
								</tr>
							</tfoot>
						</table>
						</div>

<div class="table-responsive">
<table clasS="table table-sm table-hovered" id="example">
<thead>
<tr>
<th>PROV</th>
<th>MARCA</th>
<th>A</th>
<th>B+</th>
<th>B-</th>
<th>B</th>
<th>C</th>
<th>D</th>
<th>TOTAL</th>
<th>IMPORTE</th>
</tr>
</thead>
<tbody>
<?php foreach($marcas as $item) : ?>
<tr>
	<td></td>
	<td><?=$item['marca']?></td>
	<td><?=$item['a']?></td>
	<td><?=$item['bmas']?></td>
	<td><?=$item['bmenos']?></td>
	<td><?=$item['b']?></td>
	<td><?=$item['c']?></td>
	<td><?=$item['d']?></td>
	<td><?=$item['no']?></td>
	<td><?=$item['total_importe']?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

					
				</div>
				<!-- table de categorias -->

			</div>
		</div>
	</div>
</section>


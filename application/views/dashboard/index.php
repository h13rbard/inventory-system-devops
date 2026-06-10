<section class="no-padding-bottom">
	<div class="container-fluid">

		<div class="row">

			<div class="col">
				<div class="block">
					<!-- <h5>Periodo</h5>						 -->
						<form id="form">
						<div class="row">
									<div class="col-md-6 col-lg-4 col-sm-12">
										Inicio:
										<input type="date" name="inicio" id="" class="form-control" required value="<?=date('Y-m-d')?>">
									</div>
									<div class="col-md-6 col-lg-4 col-sm-12">
										Fin:
										<input type="date" name="fin" id="" class="form-control" required value="<?=date('Y-m-d')?>">
									</div>
									<div class="col-md-6 col-lg-4 col-sm-12">
										<br>
									<button type="submit" class="btn btn-success btn-sm">Consultar</button>
									</div>
						</div>
						</form>
										
				</div>
			</div>
		</div>

		<div class="row">

			<div class="col-md-6 col-lg-4 col-sm-12">
				<div class="statistic-block block">
					<div class="row">
						<div class="col-2">
							<div class="dropdown">
								<button class="btn btn-outline-secondary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-ellipsis-v"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									<a class="dropdown-item" href="<?=base_url()?>dashinv/index" target="_blank"><i class="fa fa-archive"> </i> Inventario</a>
									<a class="dropdown-item" href="<?=base_url()?>dashinv/dashboard" target="_blank"><i class="fa fa-pie-chart"> </i> Inventario</a>
								</div>
							</div>
						</div>
						<div class="col-10">
							<h5>Valor del Inventario</h5>
						</div>
					</div>
					<div id="res-valinv"><div class="number dashtext-1 text-center">$ </div></div>
				</div>
			</div>

			<div class="col-md-6 col-lg-4 col-sm-12">
				<div class="statistic-block block">
					<div class="row">
						<div class="col-2">
							<div class="dropdown">
								<button class="btn btn-outline-secondary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-ellipsis-v"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									<a class="dropdown-item" href="<?=base_url()?>dashvta/index" target="_blank"><i class="fa fa-calculator"> </i> Ventas</a>
									<a class="dropdown-item" href="<?=base_url()?>dashvta/dashboard" target="_blank"><i class="fa fa-line-chart"> </i> Ventas</a>
									<a class="dropdown-item" href="<?=base_url()?>reportes/ventas_vs_compras" target="_blank"><i class="fa fa-balance-scale"> </i> Ventas/Compras</a>
									<a class="dropdown-item" href="<?=base_url()?>dashvta/horas" target="_blank"><i class="fa fa-history"> </i> Horario</a>
								</div>
							</div>
						</div>
						<div class="col-10">
							<h5>Ventas</h5>
						</div>
					</div>
					<div id="res-ventas"><div class="number dashtext-2 text-center">$ </div></div>
				</div>
			</div>

			<div class="col-md-6 col-lg-4 col-sm-12">
				<div class="statistic-block block">
					<div class="row">
						<div class="col-2">
							<div class="dropdown">
								<button class="btn btn-outline-secondary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-ellipsis-v"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									<a class="dropdown-item" href="<?=base_url()?>reportes/ventas_vs_compras" target="_blank"><i class="fa fa-balance-scale"> </i> Ventas/Compras</a>
								</div>
							</div>
						</div>
						<div class="col-10">
							<h5>Compras</h5>
						</div>
					</div>
					<div class="number dashtext-3 text-center" id="res-compras">$ </div>
				</div>
			</div>

		</div>

		<div class="row">

			<div class="col-md-6 col-lg-4 col-sm-12">
				<div class="statistic-block block">
					<div class="row">
						<div class="col-2">
							<div class="dropdown">
								<button class="btn btn-outline-secondary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-ellipsis-v"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								</div>
							</div>
						</div>
						<div class="col-10">
							<h5>Cobranza</h5>
						</div>
					</div>
					<div class="number dashtext-1 text-center" id="res-cobranza">$ </div>
				</div>
			</div>

			<div class="col-md-6 col-lg-4 col-sm-12">
				<div class="statistic-block block">
					<div class="row">
						<div class="col-2">
							<div class="dropdown">
								<button class="btn btn-outline-secondary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-ellipsis-v"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								</div>
							</div>
						</div>
						<div class="col-10">
							<h5>Doc X Cobrar</h5>
						</div>
					</div>
					<div class="number dashtext-2 text-center" id="res-doccob">$ </div>
				</div>
			</div>

			<div class="col-md-6 col-lg-4 col-sm-12">
				<div class="statistic-block block">
					<div class="row">
						<div class="col-2">
							<div class="dropdown">
								<button class="btn btn-outline-secondary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-ellipsis-v"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								</div>
							</div>
						</div>
						<div class="col-10">
							<h5>Caja</h5>
						</div>
					</div>
					<div class="number dashtext-3 text-center" id="res-caja">$ </div>
					<div id="res-flujo"></div>
				</div>
			</div>

		</div>

	</div>
</section>

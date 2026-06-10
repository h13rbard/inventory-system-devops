<!DOCTYPE html>
<html>
  <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?=base_url()?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?=base_url()?>assets/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/font.css">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/style.violet.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?=base_url()?>assets/img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <header class="header">   
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid d-flex align-items-center justify-content-between">
          <div class="navbar-header">
            <!-- Navbar Header--><a href="index.html" class="navbar-brand">
              <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">Bash</strong><strong>Admin</strong></div>
              <div class="brand-text brand-sm"><strong class="text-primary">B</strong><strong>A</strong></div></a>
            <!-- Sidebar Toggle Btn-->
            <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
          </div>
          <div class="right-menu list-inline no-margin-bottom">    
            <!-- Log out               -->
            <div class="list-inline-item logout"> <a id="logout" href="login.html" class="nav-link"> <span class="d-none d-sm-inline">Salir </span><i class="icon-logout"></i></a></div>
          </div>
        </div>
      </nav>
    </header>
    <div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
      <nav id="sidebar" class="shrinked">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar"><img src="<?=base_url()?>assets/img/avatar-6.jpg" alt="..." class="img-fluid rounded-circle"></div>
          <div class="title">
            <h1 class="h5">Mark Stephen</h1>
            <p>Dirección</p>
          </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled">
          <li class="active"><a href="index.html"> <i class="icon-home"></i>Home </a></li>
          <li><a href="forms.html"> <i class="icon-padnote"></i>Inventario </a></li>
          <li><a href="#"> <i class="icon-logout"></i>Salir </a></li>
      </nav>
      <!-- Sidebar Navigation end-->
      <div class="page-content active">
        <br>
        <section class="no-padding-bottom">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-4">
				  <!-- Totales -->
				  <div class="stats-2-block block d-flex">  
                  <div class="stats-1 d-flex">
                    <div class="stats-2-arrow height"><i class="fa fa-caret-up"></i></div>
                    <div class="stats-2-content"><strong class="d-block">$ <?=number_format($ventasDic, 2)?></strong><span class="d-block">Diciembre</span>
                      <div class="progress progress-template progress-small">
                        <div role="progressbar" style="width: 100%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template progress-bar-small dashbg-3"></div>
                      </div>
                    </div>
                  </div>
                  </div>
				  <!-- fin totales -->
				  <!-- Venta promedio -->
				  <div class="stats-2-block block d-flex">
					<div class="stats-1 d-flex">
						<div class="stats-2-content"><strong class="d-block">$ <?=number_format($ventaMensualPromedio, 2)?></strong><span class="d-block">Promedio</span>
						<div class="progress progress-template progress-small">
							<div role="progressbar" style="width: 100%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template progress-bar-small dashbg-2"></div>
						</div>
						</div>
					</div>
				  </div>
				  <!-- Fin venta promedio -->
				  <!-- Vendedores -->
				  <div class="stats-2-block block d-flex">
                  
                  <div class="stats-2 d-flex">
                    <div class="stats-2-content"><strong class="d-block">8</strong><span class="d-block">Vendedores</span>
                    </div>
				  </div>
				  <div class="stats-2 d-flex">
                    <div class="stats-2-content"><h5 class="d-block">$ <?=number_format($metaVendedor, 2)?></h5><span class="d-block">Objetivo venta</span>
                    </div>
                  </div>
                </div>
				  <!-- Fin vendedores -->
              </div>
              <div class="col-lg-8">
				  <div class="block">
					  <div id="container"></div>
				  </div>
              </div>
            </div>
          </div>
		</section>
		<section class="no-padding-bottom">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-6">
				  <!-- Vendedores -->
				  <div class="block">
                  <div class="title"><strong>Ventas Diciembre</strong></div>
                  <div class="table-responsive"> 
                    <table class="table table-striped table-sm">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nombre</th>
						  <th>Importe</th>
						  <th></th>
                        </tr>
                      </thead>
                      <tbody>
						<?php
						$n = 0;
						$vchrPie = '';
						foreach($ventasPorVendedor->result() as $row) : 
						$n++;
						$vchrPie .= "{name: '$row->nombre', y: $row->total},";
						?>
						<tr>
                          <th scope="row"><?=$n?></th>
                          <td><?=$row->nombre?></td>
						  <td><?=number_format($row->total, 2)?></td>
						  <td>
							  <?= ($row->total > $metaVendedor) ?
							  '<span class="text-success"><i class="fa fa-caret-up"></i></span>' :
							  '<span class="text-danger"><i class="fa fa-caret-down"></i></span>' ?>
						  </td>
                        </tr>
						<?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
				  <!-- Fin vendedores -->
			  </div>
			  <div class="col-lg-6">
				  <div id="chrPie"></div>
			  </div>
			</div>
		  </div>
		</section>
        <footer class="footer">
          <div class="footer__block block no-margin-bottom">
            <div class="container-fluid text-center">
              <!-- Please do not remove the backlink to us unless you support us at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
              <p class="no-margin-bottom">2019 &copy; BASH-TI.</p>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="<?=base_url()?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/vendor/popper.js/umd/popper.min.js"> </script>
    <script src="<?=base_url()?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>assets/vendor/jquery.cookie/jquery.cookie.js"> </script>
	<script src="<?=base_url()?>assets/code/highcharts.js"></script>
	<script src="<?=base_url()?>assets/code/themes/dark-unica.js"></script>
	<script src="<?=base_url()?>assets/js/front.js"></script>
	<script>
	Highcharts.chart('container', {

		chart: {
			type: 'column'
		},

		title: {
			text: 'Ventas 2018',
		},

		xAxis: {
			categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
				'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
		},

		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},

		series: [{
			name: 'Ventas',
			data: [<?=$ventasMes?>]
		}, {
			name: 'Promedio',
			data: [<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>,<?=$ventaMensualPromedio?>]
		}
	],

		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						layout: 'horizontal',
						align: 'center',
						verticalAlign: 'bottom'
					}
				}
			}]
		}

		});

		// Chart Vendedores
		Highcharts.chart('chrPie', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Diciembre 2018'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [<?=$vchrPie?>]
    }]
});
	</script>
  </body>
</html>

<!DOCTYPE html>
<html lang="es">
  <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
	<meta name="theme-color" content="#2d3035">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?=base_url()?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?=base_url()?>assets/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/font.css">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/style.red.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
		<link rel="stylesheet" href="<?=base_url()?>assets/css/custom.css">
		<link rel="stylesheet" href="<?=base_url()?>assets/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="<?=base_url()?>assets/vendor/toastr/toastr.min.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?=base_url()?>assets/img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
				<style>
					body
					{
						background-color: #22252a;
					}
				</style>
  </head>
  <body>

		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a href="<?=base_url()?>" class="navbar-brand">
				<strong>SysC</strong><strong class="text-primary">LA</strong>
			</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
		<?php if ($group_id == 1) { ?>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>productos">Productos </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>proveedor">Proveedores </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>clientes">Clientes </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>venta">Venta </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>compra">Compra </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>devolucion">Dev. </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>cobranza/clientes">Cobranza </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>reportes/inventario">Inventario </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>reportes">Reportes </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>reportes/config">Config </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>dashboard">Control </a></li>   
		<?php } else if ($group_id == 3) { ?>   
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>productos">Productos </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>proveedor">Proveedores </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>clientes">Clientes </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>venta">Venta </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>compra">Compra </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>devolucion">Dev. </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>cobranza/clientes">Cobranza </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>reportes/inventario">Inventario </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>reportes">Reportes </a></li>
		<?php } else if ($group_id == 4) { ?>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>productos">Productos </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>clientes">Clientes </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>venta">Venta </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>devolucion">Dev. </a></li>
			<li class="nav-item"><a class="nav-link" href="<?=base_url()?>cobranza/clientes">Cobranza </a></li>
		<?php } ?>
    </ul>
		<a class="nav-link btn btn-outline-secondary" href="<?=base_url()?>auth/logout"><i class="icon-logout"></i> Salir</a>
  </div>
</nav>

    <main>
      <!-- <div class=""> -->
        <br>

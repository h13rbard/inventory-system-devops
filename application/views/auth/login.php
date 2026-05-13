<!DOCTYPE html>
<html>
  <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema</title>
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
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?=base_url()?>assets/img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>

<div class="login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info d-flex align-items-center">
                <div class="content">
                  <div class="logo">
                    <h1>SysC-LA</h1>
                  </div>
                  <p>Sistema de control</p>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6">
              <div class="form d-flex align-items-center">
                <div class="content">
								<?php if (!is_null($message)) : ?>
								<div class="text-danger">
									<?=$message?>
								</div>
								<?php endif; ?>
									<?php echo form_open("auth/login", array('class' => "form-validate mb-4"));?>
                    <div class="form-group">
                      <input id="identity" type="text" name="identity" required data-msg="Por favor ingresa tu usuario." class="input-material" autocomplete="off">
                      <label for="identity" class="label-material">Usuario / Email</label>
                    </div>
                    <div class="form-group">
                      <input id="login-password" type="password" name="password" required data-msg="Por favor ingresa tu contraseña." class="input-material" autocomplete="off">
                      <label for="login-password" class="label-material">Contraseña</label>
										</div>
										<div class="form-group">
										<p>
											<?php echo lang('login_remember_label', 'remember');?>
											<?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
										</p>
										</div>
                    <button type="submit" class="btn btn-primary">Ingresar</button>
									<?php echo form_close();?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- JavaScript files-->
    <script src="<?=base_url()?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/vendor/popper.js/umd/popper.min.js"> </script>
    <script src="<?=base_url()?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?=base_url()?>assets/js/front.js"></script>
		<script src="<?=base_url()?>assets/js/jquery.dataTables.min.js"></script>
		<script src="<?=base_url()?>assets/js/dataTables.bootstrap4.min.js"></script>
		
    <script src="<?=base_url()?>assets/vendor/jquery-validation/jquery.validate.min.js"></script>

		</body>
</html>

<?PHP session_start();
if(!empty($_SESSION['SESSION_USER']) && !empty($_SESSION['SESSION_ID'])){
            header('location:../');
 exit;}
 else{
     require_once'../../sw-library/sw-config.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login Administrator</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Login">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- Icons -->
    <link rel="shortcut icon" href="../../sw-content/favicon.png">
    <link rel="apple-touch-icon" href="../../sw-content/favicon.png">

  <link rel="stylesheet" href="../sw-assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../sw-assets/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../sw-assets/css/skin-blue-light.css">
  <link rel="stylesheet" href="../sw-assets/css/font-awesome.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<?php echo'
<body class="hold-transition login-page">
<div class="login-box">
  <!-- <div class="login-logo">
    <a href="./"><img src="../../sw-content/'.$site_logo.'"  oncontextmenu="return false;" height="50"></a>
  </div> -->
  <div class="login-logo">
    <p>Kuliner Jogja La Rise Pannel
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Silahkan masukkan username dan password :</p>

      <div class="form-group has-feedback">
        <input type="text" id="username" name="username" class="form-control" placeholder="Username">
        <span class="fa fa-user form-control-feedback"></span>
      </div>
     
      <div class="form-group has-feedback">
        <input type="password" id="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
     <hr>
      <div class="row">
      <div class="col-md-12" style="min-height:40px;"><span id="stat"></span></div>
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat" id="login">Login to Admin</button>
           <!-- <a href="https://timkoding.com/downloads/source-code-absensi-online-absen-selfie-deteksi-lokasi-berbasis-web-bonus-source-code-e-book-v3-lock-lokasi/" class="btn btn-warning  btn-block">Beli Aplikasi</a> -->
        </div>
        <!-- /.col -->
      </div>


  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->';?>


<footer class="text-muted text-center">
    <small></span><span id="credits"><a class="credits" href='https://timkoding.com' target="_blank">Tim Koding Indonesia</a> - All Rights Reserveds</span>
    <em>Version 3.0 Update 2030</em></small>
</footer>

        <script src="../sw-assets/js/jquery.min.js"></script>
        <script src="../sw-assets/js/bootstrap.min.js"></script>
        <script src="../sw-assets/js/adminlte.js"></script>
        <script src="../sw-assets/js/demo.js"></script>
        <script src="./jquery-login.js"></script>
    </body>
</html>
<?php }?>
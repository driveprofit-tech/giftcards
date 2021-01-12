<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?=$pgtitle?></title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="../code/bootstrap/dist/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="../code/font-awesome/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="../code/Ionicons/css/ionicons.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="../code/css/AdminLTE.min.css">
		<!-- iCheck -->
		<link rel="stylesheet" href="../code/plugins/iCheck/square/blue.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- Google Font -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	</head>

	<body class="hold-transition login-page">
		<div class="login-box">

			<div class="login-logo"></div>

			<div class="login-box-body">

				<p class="login-box-msg"></p>

				<form method="post">
					<div class="form-group has-feedback">
						<input type="email" class="form-control" name="user" id="user" placeholder="Email">
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password" class="form-control" name="password" id="password" placeholder="Password">
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="row">
						<div class="col-xs-8">
							<div class="checkbox icheck">
								<label><input type="checkbox" name="remember_login" id="remember_login"> Remember Me</label>
							</div>
						</div>
						<div class="col-xs-4">
							<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
						</div>
					</div>
				</form>

				<!--<a href="#">I forgot my password</a><br>-->

			</div>

		</div>

		<!-- jQuery 3 -->
		<script src="../code/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="../code/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- iCheck -->
		<script src="../code/plugins/iCheck/icheck.min.js"></script>

		<script>
			$(function () {
				$('input').iCheck({
					checkboxClass: 'icheckbox_square-blue',
					radioClass: 'iradio_square-blue',
					increaseArea: '20%' /* optional */
				});
			});
		</script>

	</body>
</html>

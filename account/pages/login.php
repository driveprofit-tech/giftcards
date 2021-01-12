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
		<link rel="stylesheet" href="../code/fontawesome-5/css/all.min.css">
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
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

		<!-- Dashboard CSS -->
		<link rel="stylesheet" href="../code/css/dashboard.min.css">
	</head>

	<body>

		<div class="split hmin-100vh d-flex">

			<div class="flex-50 align-self-center px-5">
				<div class="whitebox m-auto p-4">
					<div class="whitebox-header text-center">
						<svg viewBox="0 0 512 512"><path d="M184 83.5l164.5 164c4.7 4.7 4.7 12.3 0 17L184 428.5c-4.7 4.7-12.3 4.7-17 0l-7.1-7.1c-4.7-4.7-4.7-12.3 0-17l132-131.4H12c-6.6 0-12-5.4-12-12v-10c0-6.6 5.4-12 12-12h279.9L160 107.6c-4.7-4.7-4.7-12.3 0-17l7.1-7.1c4.6-4.7 12.2-4.7 16.9 0zM512 400V112c0-26.5-21.5-48-48-48H332c-6.6 0-12 5.4-12 12v8c0 6.6 5.4 12 12 12h132c8.8 0 16 7.2 16 16v288c0 8.8-7.2 16-16 16H332c-6.6 0-12 5.4-12 12v8c0 6.6 5.4 12 12 12h132c26.5 0 48-21.5 48-48z"/></svg>
						<p class="lead">Member Login</p>
					</div>
					<div class="whitebox-body">
						<p class="login-box-msg"></p>
						<form method="post">
							<div class="form-group has-icon has-placeholder-label">
								<input type="email" class="form-control" name="user" id="user" placeholder="Email">
								<i class="far fa-fw fa-envelope"></i>
							</div>
							<div class="form-group has-icon has-placeholder-label">
								<input type="password" class="form-control" name="password" id="password" placeholder="Password">
								<i class="fas fa-fw fa-key"></i>
							</div>
							<div class="form-group mt-5">
								<div class="t360-checkbox">
									<input type="checkbox" name="remember_login" id="remember_login">
									<label for="remember_login">Remember Me</label>
								</div>
							</div>
							<div class="form-group my-5">
								<button type="submit" class="btn btn-primary d-block w-100">Sign In</button>
							</div>
						</form>
					</div>
					<div class="whitebox-footer text-center">
						<p class="text-small mt-5 mb-4 text-semibold text-gray-70">Copyright &copy; <?= date( 'Y' ) ?> <a href="https://www.tech360group.com/" target="_blank">Tech360 Group</a>.</p>
					</div>
				</div>
			</div>

			<div class="flex-50 d-none d-lg-block">
				<img class="w-100 h-100 fit-contain" src="../graphics/elements/giftcard.jpg" alt="Giftcards System">
			</div>

		</div>

		<!-- jQuery 3 -->
		<script src="../code/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="../code/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- iCheck -->
		<script src="../code/plugins/iCheck/icheck.min.js"></script>

		<script>
			(function($) {

				function t360_checkbox() {
					$(this).find('label').prepend('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22"><path class="checkmark" d="M17.774 7.869l-7.453 7.745a1.134 1.134 0 01-1.635 0l-4.461-4.636A1.08 1.08 0 115.78 9.481l3.723 3.869 6.711-6.981a1.081 1.081 0 111.56 1.5z"></path><path d="M19.25 2a.75.75 0 01.75.75v16.5a.75.75 0 01-.75.75H2.75a.75.75 0 01-.75-.75V2.75A.75.75 0 012.75 2h16.5m0-2H2.75A2.75 2.75 0 000 2.75v16.5A2.75 2.75 0 002.75 22h16.5A2.75 2.75 0 0022 19.25V2.75A2.75 2.75 0 0019.25 0z"></path></svg>');
				};

				$('.t360-checkbox').each(t360_checkbox);

				function t360_label() {
					var _this = this,
						the_input = $(this).find('input'),
						label = the_input.attr('placeholder');
					the_input.removeAttr('placeholder');
					the_input.after('<label class="placeholder-label" for="' + the_input.attr('id') + '">' + label + '</label>');
					the_input.on('click enter focus', function() {
						$(_this).addClass('touched');
					});
					the_input.on('change', function() {
						if(the_input.val().length > 0) {
							$(_this).addClass('touched');
						};
					});
				};

				$('.has-placeholder-label').each(t360_label);

			})(jQuery);
		</script>

	</body>
</html>

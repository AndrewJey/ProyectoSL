<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PWSR</title>
	<link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="/bower_components/bootstrap-material-design/dist/css/material.min.css" rel="stylesheet">
	<link href="/bower_components/bootstrap-material-design/dist/css/material-fullpalette.min.css" rel="stylesheet">

	<!-- Fonts -->
	<!--<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>-->

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					@if (!Auth::guest())
						<li><a href="/songs">Songs</a></li>
					@endif
					@yield('singers')
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="/login">Login</a></li>
						<li><a href="/register">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ action('Auth\AuthController@getLogout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
		@yield('content')
	</div>

	<!-- Scripts -->

	<script src="/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="/bower_components/bootstrap-material-design/dist/js/ripples.min.js"></script>
	<script src="/bower_components/bootstrap-material-design/dist/js/material.min.js"></script>
	@yield('scripts')
	<script type="text/javascript">
	$(document).on('ready', function(){
		$.material.init();
	});
	</script>
</body>
</html>

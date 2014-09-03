<html>
<head>
	<title>Application Web</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>
	<div id="wrap">
		<div id="header">
			<h1 id="logo-text">Mon super site</h1>
			<p id="slogan">Ici mettre le slogan</p>
		</div>
	</div>

	<div id="menu">
		<ul>
			<li>Accueil</li>
			<?php if($user->isAuthenticated()){ ?>
			<li><a href="/admin/">Admin</a></li>
			<li><a href="/admin/news-insert.html">Ajouter news</a></li>
			<?php } ?>
		</ul>
	</div>

	<div id="content-wrap">
		<div id="main">
		<?php if($user->hasFlash()) echo '<p style="text-align:center;">', $user->getFlash(), '</p>'; ?>
		</div>
	</div>

	<?php echo $content; ?>

	<div id="footer">
	</div>

</body>
</html>
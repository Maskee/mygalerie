<!doctype html>
<html lang="de">
	<head>
		<base href="/mygalerie/" /> 
	    <meta charset="UTF-8">
	    <meta name="description" content="Bilder Archiv mit Bildern aus allen Bereichen, Natur, Modern, Kunst...">
	    <meta name="keywords" content="Bilder, Images, Archiv, Galerie, Collection">
	    <meta name="robots" content="noindex, nofollow" />
	    <meta name="author" content="Henrik Erhart">
		<link href="img/icons/icon2.png" rel="shortcut icon" >
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!-- <link href="public/css/styles.css" rel="stylesheet" type="text/css" > -->
		<link href="public/css/img.styles.less" rel="stylesheet/less" type="text/css" >
		<link href="public/css/img.desktop.less" media="(min-width: 1201px)" rel="stylesheet/less" type="text/css" >
		<link href="public/css/img.tablet.less" media="(max-width: 1200px) and (min-width: 421px)" rel="stylesheet/less" type="text/css" >
		<link href="public/css/img.mobile.less" media="(max-width: 420px)" rel="stylesheet/less" type="text/css" >
		<script src="public/js/less.js" type="text/javascript"></script>
		<script src="public/js/jquery.min.js" type="text/javascript"></script>
	    <title>Bilder Archiv Galerie, Erhart-IT</title>
	</head>
	<body>
	    <div id="page">
			<header>
				<a href="">
					<img id="logo" src="public/img/Logos/black_logo4.png" width="190" alt="Erhart-IT Logo, Programmierung / Webdesign">
				</a>
				<div id="options">
					<div class="lines"></div>
				</div>
				<div id="options_menu">
					<ul>
						<?php echo $this->elements->getOptions(); ?>
					</ul>
				</div>
				<div id="inner_header">
					<h1><a href="images">Bilder Archiv Galerie</a></h1>
				</div>
				<div id="user_data"><?php echo $this->elements->getLoggedInAs(); ?></div>
				<div id="drop">
					<div>
						<img src="public/img/icons/appbar.chevron.down.png">
					</div>
				</div>
			</header>
			<div id="main">
				<?php echo $this->getContent(); ?>
			</div>			
	    	<footer>
	    	</footer>
	    </div>
	    <script src="public/js/custom.js" type="text/javascript"></script>
	</body>
</html>
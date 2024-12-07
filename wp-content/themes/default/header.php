<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Everfit test</title>
	<?php wp_head(); ?>
	<link rel="stylesheet" href="/src/Presentation/assets/css/pages/home.css" />
</head>
<body>
	<header>
		<div class="inner">
			<a href="/" class="logo">
				<img class="logo-white" src="/src/Presentation/assets/images/logo-white.svg" data-src="/src/Presentation/assets/images/logo-white.svg" alt="Everfit">
			</a>
			<?php \Presentation\Helpers\ViewHelper::render( 'Views/Common/Menu.php' ); ?>
		</div>
	</header>
	<main>
		<section class="sec-background"></section>
	</main>

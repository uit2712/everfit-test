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
				<img class="logo-white" src="/src/Presentation/assets/images/logo-white.svg" data-src="/src/Presentation/assets/images/logo-white.svg" alt="Everfit" width="auto" height="34px"/>
			</a>
			<?php \Presentation\Helpers\ViewHelper::render( 'Views/Common/Menu.php' ); ?>
			<section class="sec-auth">
				<a class="btn-sign-in" href="/sign-in">Sign In</a>
				<a class="btn-try-for-free" href="/try-for-free" title="Try For Free">
					<span>Try For Free</span>
					<img src="/src/Presentation/assets/images/homepage/icon-arrow-right.svg" alt="Try For Free" width="16px" height="16px"/>
				</a>
			</section>
		</div>
	</header>
	<main>
		<section class="sec-background"></section>
		<section class="sec-introduction">
			<div class="summary">
				<h1>
					We’ll Do the Heavy Lifting to Grow<br/>
					Your Personal Training Business
				</h1>
				<p>Keep your clients easily on track with their fitness goals<br/>anytime and from anywhere</p>
			</div>
			<form class="newsletter">
				<input type="email" class="email" placeholder="Enter your email" />
				<a href="javascript:void(0)" class="btn-free-trial">
					<span>Start 30-day Free Trial</span>
					<img src="/src/Presentation/assets/images/homepage/icon-arrow-right.svg" alt="Try For Free" width="16px" height="16px"/>
				</a>
			</form>
			<ul class="extra-info">
				<li>
					<i class="fa fa-check-circle"></i>
					<span>Train 5 clients for free</span>
				</li>
				<li>
					<i class="fa fa-check-circle"></i>
					<span>No credit card required</span>
				</li>
				<li>
					<i class="fa fa-check-circle"></i>
					<span>Available on iOS, Android, and Web</span>
				</li>
			</ul>
		</section>
	</main>

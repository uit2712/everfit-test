<header>
	<div class="inner">
		<a href="/" class="logo">
			<img class="logo-white" src="/src/Presentation/assets/images/logo-white.svg" data-src="/src/Presentation/assets/images/logo-white.svg" alt="Everfit" width="auto" height="34px"/>
			<img class="logo-dark" src="/src/Presentation/assets/images/logo-dark.svg" data-src="/src/Presentation/assets/images/logo-dark.svg" alt="Everfit" width="auto" height="34px"/>
		</a>
		<?php \Presentation\Helpers\ViewHelper::render( 'Views/Common/Menu.php' ); ?>
		<section class="sec-auth">
			<a class="btn-sign-in" href="/sign-in">Sign In</a>
			<a class="btn-try-for-free" href="/try-for-free" title="Try For Free">
				<span>Try For Free</span>
				<img src="/src/Presentation/assets/pages/home/images/icon-arrow-right.svg" alt="Try For Free" width="16px" height="16px"/>
			</a>
		</section>
	</div>
</header>

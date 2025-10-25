<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="entry-header">
      <div class="container nav-inner">
        <div class="brand">TIMELESS</div>
        <nav>
            <?php
            wp_nav_menu( array(
                'theme_location' => 'navigation-menu', // The slug you registered in functions.php
            ) );
            ?>
        </nav>
        <div style="display: flex; align-items: center; gap: 18px">
          <button class="mobile-toggle" aria-label="open menu">☰</button>
          <div class="cart">👜</div>
        </div>
      </div>
    </header>
<main id="primary" class="site-main">



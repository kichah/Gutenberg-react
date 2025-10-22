<?php get_header(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php soltani_post_thumbnail(); ?>

<div class="entry-content">

		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'soltani' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->
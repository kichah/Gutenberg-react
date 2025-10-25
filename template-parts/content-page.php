<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package soltani
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content container">
		<div class="page-header">
    	<h1 class="entry-title"><?php the_title() ?></h1>
  	</div>

		<section class="about my-10">
       <?php the_content(); ?>
    </section>

	</div><!-- .entry-content -->

</article>

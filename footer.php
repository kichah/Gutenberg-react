<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package soltani
 */

?>

</main>
	 <footer id="colophon" class="site-footer entry-footer" role="contentinfo">
      <div class="footer-inner">
        <div class="footer-top">
          <div class="brand">JEWELRY</div>
          <nav class="quick-nav flex flex-wrap" aria-label="Footer quick links">
						<?php
						// Define category slugs
						$categories = array('rings', 'necklaces', 'bracelets','earrings');
						
						foreach ($categories as $slug) {
								$term = get_term_by('slug', $slug, 'product_cat');
								
								if ($term && !is_wp_error($term)) {
										?>
										<a href="<?php echo esc_url(get_term_link($term)); ?>">
												<?php echo esc_html($term->name); ?>
										</a>
										<?php
								}
						}
						?>
				</nav>

        </div>

        <div class="footer-sections">
          <div class="section customer-care" aria-labelledby="customer-care">
            <h4 id="customer-care">Customer Care</h4>
             <?php
            wp_nav_menu( array(
                'theme_location' => 'footer-menu-contacts', // The slug you registered in functions.php
            ) );
            ?>
          </div>

          <div class="section about" aria-labelledby="about">
            <h4 id="about">About</h4>
            <p>
              Our story, sustainability commitments, and the craftsmanship
              behind every piece.
            </p>
           <?php
            wp_nav_menu( array(
                'theme_location' => 'footer-menu-about', // The slug you registered in functions.php
            ) );
            ?>
          </div>

          <div class="section social-section" aria-labelledby="connect">
            <h4 id="connect">Connect</h4>
            <p style="margin-top: 0; color: var(--muted)">
              Follow us for styling inspiration, care tips, and new arrivals.
            </p>
            <div class="social" role="list">
              <a href="#facebook" aria-label="Facebook" role="listitem">
                <!-- Facebook SVG -->
                <svg viewBox="0 0 24 24" aria-hidden="true">
                  <path
                    d="M22 12.07C22 6.48 17.52 2 11.93 2S2 6.48 2 12.07C2 17.09 5.66 21.18 10.44 21.95v-6.96H7.9v-2.9h2.54V9.41c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.62.77-1.62 1.56v1.88h2.77l-.44 2.9h-2.33V21.95C18.34 21.18 22 17.09 22 12.07z"
                  />
                </svg>
              </a>

              <a href="#instagram" aria-label="Instagram" role="listitem">
                <!-- Instagram SVG -->
                <svg viewBox="0 0 24 24" aria-hidden="true">
                  <path
                    d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm5 6.2A3.8 3.8 0 1 0 15.8 12 3.8 3.8 0 0 0 12 8.2zm6.4-2.6a1.12 1.12 0 1 1-1.12-1.12 1.12 1.12 0 0 1 1.12 1.12zM12 9.4A2.6 2.6 0 1 1 9.4 12 2.6 2.6 0 0 1 12 9.4z"
                  />
                </svg>
              </a>

              <a href="#twitter" aria-label="Twitter" role="listitem">
                <!-- Twitter SVG -->
                <svg viewBox="0 0 24 24" aria-hidden="true">
                  <path
                    d="M22 5.92c-.64.28-1.32.46-2.04.54.73-.44 1.3-1.13 1.57-1.96-.68.4-1.43.68-2.23.83A3.47 3.47 0 0 0 12.1 8.1c0 .27.03.54.09.8-2.88-.14-5.44-1.52-7.15-3.63-.3.52-.47 1.13-.47 1.78 0 1.23.62 2.32 1.57 2.96-.57-.02-1.1-.17-1.56-.43v.04c0 1.72 1.22 3.15 2.83 3.48-.3.08-.62.12-.95.12-.23 0-.45-.02-.67-.06.45 1.4 1.76 2.42 3.31 2.45A6.99 6.99 0 0 1 4 19.54 9.86 9.86 0 0 0 9.29 21c6.24 0 9.66-5.17 9.66-9.66v-.44c.66-.48 1.22-1.08 1.67-1.76-.6.26-1.24.44-1.9.52z"
                  />
                </svg>
              </a>
            </div>
          </div>
        </div>

        <div class="footer-bottom">
          <div>© 2025 JEWELRY. All rights reserved.</div>
        </div>
      </div>
    </footer>
	</footer><!-- #colophon -->
<?php wp_footer(); ?>

</body>
</html>

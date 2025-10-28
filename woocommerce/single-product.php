<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		//do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
      
			<?php
      //defined( 'ABSPATH' ) || exit;
      global $product;
      ?>
      <div class="container">
      <section class="product-grid">
          <div class="product-info">
              <h1><?php the_title(); ?></h1>
              <p class="price"><?php echo $product->get_price_html(); ?></p>
              <div class="short-desc"><?php echo $product->get_short_description(); ?></div>

              <!-- Custom Order Form -->
              <form class="product-form" id="custom-cod-order-form">
                  <label for="name">Full Name
                      <input name="customer_name" id="name" type="text" placeholder="Your Full Name" required>
                  </label>
                  <label for="phone">Phone Number
                      <input name="customer_phone" id="phone" placeholder="Your Phone Number" type="tel" required>
                  </label>

                  <!-- Province and City will be injected from your API via JS -->
                   <label>Location</label>
                  <div class="location-group">
                    <select id="province" required>
                      <option value="">Select Province</option>
                      <option value="algiers">Algiers</option>
                      <option value="oran">Oran</option>
                      <option value="constantine">Constantine</option>
                    </select>
                    <select id="city" required>
                      <option value="">Select City</option>
                      <option value="hydra">Hydra</option>
                      <option value="bir-mourad-rais">Bir Mourad Raïs</option>
                      <option value="ben-aknoun">Ben Aknoun</option>
                    </select>
                  </div>

                  <!-- Dynamic Carat Dropdown (with PHP) -->
                  <?php if ( $product->is_type( 'variable' ) ) : 
                      $attribute = 'pa_carat'; // Adjust to your attribute name
                      $available_variations = $product->get_available_variations();
                      ?>
                      <label for="js-variation-id">Carat</label>
                      <select name="variation_id" id="js-variation-id" required>
                          <option value="">Choose Carat</option>
                          <?php foreach ( $available_variations as $variation ) : 
                              $carat = $variation['attributes']['attribute_' . $attribute];
                              ?>
                              <option value="<?php echo esc_attr( $variation['variation_id'] ); ?>">
                                  <?php echo esc_html( $carat ); ?>
                              </option>
                          <?php endforeach; ?>
                      </select>
                      <?php endif; ?>
                      <p class="price-below"><?php echo $product->get_price_html(); ?></p>
                      <button type="submit">Order Now</button>

                  <input type="hidden" name="product_id" value="<?php echo esc_attr( $product->get_id() ); ?>">
              </form>

              <div id="order-result"></div>
          </div>

          <div class="product-images">
            <div class="main-image" id="mainImage"><?php the_post_thumbnail( 'large' ); ?></div>
              <!-- Add custom gallery markup if you want; use $product->get_gallery_image_ids() -->
               <div class="gallery">
            <img
              src="https://images.unsplash.com/photo-1603561591411-07134e71a2a9?ixlib=rb-4.1.0&auto=format&fit=crop&q=60&w=500"
              data-image="https://images.unsplash.com/photo-1603561591411-07134e71a2a9?ixlib=rb-4.1.0&auto=format&fit=crop&q=60&w=500"
              alt="Product image 1"
            />
            <img
              src="https://images.unsplash.com/photo-1627293509201-cd0c780043e6?ixlib=rb-4.1.0&auto=format&fit=crop&q=60&w=500"
              data-image="https://images.unsplash.com/photo-1627293509201-cd0c780043e6?ixlib=rb-4.1.0&auto=format&fit=crop&q=60&w=500"
              alt="Product image 2"
            />
            <img
              src="https://images.unsplash.com/photo-1627293530222-0df384f8a419?ixlib=rb-4.1.0&auto=format&fit=crop&q=60&w=500"
              data-image="https://images.unsplash.com/photo-1627293530222-0df384f8a419?ixlib=rb-4.1.0&auto=format&fit=crop&q=60&w=500"
              alt="Product image 3"
            />
          </div>
          </div>
      </section>
      <section class="tab-section">
        <div class="tabs">
          <div class="tab active" data-target="description">
            Full Description
          </div>
          <div class="tab" data-target="reviews">Reviews</div>
        </div>

        <div class="tab-content active" id="description">
          <?php echo $product->get_description(); ?>
        </div>

        <div class="tab-content" id="reviews">
          <p>
            <strong>Amira K.</strong>: “Absolutely stunning! The craftsmanship
            is top-tier.”
          </p>
          <p>
            <strong>Layla B.</strong>: “Elegant and classy. Worth every penny.”
          </p>
        </div>
      </section>
      </div>

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<script>
      const galleryImages = document.querySelectorAll('.gallery img');
    const mainImgTag = document.querySelector('#mainImage img');

    galleryImages.forEach(img => {
      img.addEventListener('click', () => {
        mainImgTag.srcset = img.dataset.image;
      });
    });

    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        contents.forEach(c => c.classList.remove('active'));
        tab.classList.add('active');
        document.getElementById(tab.dataset.target).classList.add('active');
      });
    });
    </script>
<?php

get_footer();

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */

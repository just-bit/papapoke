<?php
	get_header();
?>

<!-- Banner -->

<section class="home-banner">

	<div class="container flex home-banner-cont">

		<div class="home-banner-cont-left">
			<h1><?php the_field('heading_h1'); ?></h1>
				<div class="home-banner-cont-left-text">
            <?php the_field('heading_text'); ?>
				</div>
			<a href="#menu" class="action-button" data-target="extras"><span class="btn-star"></span> TRY IT <span class="btn-star"></span> TRY IT <span class="btn-star"></span> TRY IT <span class="btn-star"></span></a>

		</div>

		<div class="home-banner-cont-right">
			<img src="<?php the_field('heading_bowl_photo'); ?>" alt="adress" class="hp-bowl">
		</div>

	</div>

</section>

<!-- Menu -->
<section class="menu-sec" id="menu">

	<div class="container">
<?php if (!empty(get_field('menu_heading'))): ?>
	<h2><?php the_field('menu_heading'); ?></h2>
<?php endif; ?>

		<div class="menu-sec-tabs">

			  <div class="menu-sec-bar m-black">
				    <button class="menu-sec-item menu-sec-button-bowl tabbtn active-red" onclick="openCity(event,'bowls')">Bowls</button>
				    <button class="menu-sec-item menu-sec-button-rolls tabbtn" onclick="openCity(event,'rolls')">Rolls</button>
				    <button class="menu-sec-item menu-sec-button-extras tabbtn" onclick="openCity(event,'extras')">Extras</button>
				    <button class="menu-sec-item menu-sec-button-drinks tabbtn" onclick="openCity(event,'drinks')">Drinks</button>
				  </div>

				  <div id="bowls" class="menu-sec-container menu-sec-border papabowls">

				  	<div class="woocommerce columns-3">
        				<ul class="products columns-3">
				    	<?php
		                	$ids_raw = get_field('menu_tabs_and_item_bowls');
                            $ids_instock = array_filter( (array) $ids_raw, function($pid){
                                return get_post_meta($pid,'_stock_status',true)==='instock';
                            } );
                            if(!empty($ids_instock)){
                                $args = array(
                                    'post_type' => 'product',
                                    'post__in'  => $ids_instock,
                                    'posts_per_page' => 3,
                                    'orderby' => 'post__in',
                                    'meta_query' => array(
                                        array(
                                            'key' => '_stock_status',
                                            'value' => 'instock',
                                            'compare' => '='
                                        )
                                    )
                                );
                            } else {
                                $args = array(
                                    'post_type' => 'product',
                                    'posts_per_page' => 3,
                                    'orderby' => 'date',
                                    'order'   => 'DESC',
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'product_cat',
                                            'field'    => 'slug',
                                            'terms'    => 'bowls',
                                        )
                                    ),
                                    'meta_query' => array(
                                        array(
                                            'key' => '_stock_status',
                                            'value' => 'instock',
                                            'compare' => '='
                                        )
                                    )
                                );
                            }
		                    $loop = new WP_Query( $args );

		                    if ( $loop->have_posts() ) {

		                        while ( $loop->have_posts() ) : $loop->the_post();

		                            wc_get_template_part( 'content', 'product' );

		                        endwhile;
		                    }

		                    wp_reset_postdata();
		                ?>
		                </ul><!--/.products-->
        			</div>

				  </div>

				  <div id="rolls" class="menu-sec-container menu-sec-border papabowls" style="display:none">
				    <div class="woocommerce columns-3 ">
        				<ul class="products columns-3">
				    	<?php
		                	$ids_raw = get_field('menu_tabs_and_item_rolls');
                            $ids_instock = array_filter( (array) $ids_raw, function($pid){
                                return get_post_meta($pid,'_stock_status',true)==='instock';
                            } );
                            if(!empty($ids_instock)){
                                $args = array(
                                    'post_type' => 'product',
                                    'post__in'  => $ids_instock,
                                    'posts_per_page' => 3,
                                    'orderby' => 'post__in',
                                    'meta_query' => array(
                                        array(
                                            'key' => '_stock_status',
                                            'value' => 'instock',
                                            'compare' => '='
                                        )
                                    )
                                );
                            } else {
                                $args = array(
                                    'post_type' => 'product',
                                    'posts_per_page' => 3,
                                    'orderby' => 'date',
                                    'order'   => 'DESC',
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'product_cat',
                                            'field'    => 'slug',
                                            'terms'    => 'rolls',
                                        )
                                    ),
                                    'meta_query' => array(
                                        array(
                                            'key' => '_stock_status',
                                            'value' => 'instock',
                                            'compare' => '='
                                        )
                                    )
                                );
                            }
		                    $loop = new WP_Query( $args );

		                    if ( $loop->have_posts() ) {

		                        while ( $loop->have_posts() ) : $loop->the_post();

		                            wc_get_template_part( 'content', 'product' );

		                        endwhile;
		                    }

		                    wp_reset_postdata();
		                ?>
		                </ul><!--/.products-->
        			</div>

				  </div>

				  <div id="extras" class="menu-sec-container menu-sec-border papabowls" style="display:none">
				    <div class="woocommerce columns-3">
        				<ul class="products columns-3">
				    	<?php
		                	$ids_raw = get_field('menu_tabs_and_item_extras');
                            $ids_instock = array_filter( (array) $ids_raw, function($pid){
                                return get_post_meta($pid,'_stock_status',true)==='instock';
                            } );
                            if(!empty($ids_instock)){
                                $args = array(
                                    'post_type' => 'product',
                                    'post__in'  => $ids_instock,
                                    'posts_per_page' => 3,
                                    'orderby' => 'post__in',
                                    'meta_query' => array(
                                        array(
                                            'key' => '_stock_status',
                                            'value' => 'instock',
                                            'compare' => '='
                                        )
                                    )
                                );
                            } else {
                                $args = array(
                                    'post_type' => 'product',
                                    'posts_per_page' => 3,
                                    'orderby' => 'date',
                                    'order'   => 'DESC',
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'product_cat',
                                            'field'    => 'slug',
                                            'terms'    => 'extras',
                                        )
                                    ),
                                    'meta_query' => array(
                                        array(
                                            'key' => '_stock_status',
                                            'value' => 'instock',
                                            'compare' => '='
                                        )
                                    )
                                );
                            }
		                    $loop = new WP_Query( $args );

		                    if ( $loop->have_posts() ) {

		                        while ( $loop->have_posts() ) : $loop->the_post();

		                            wc_get_template_part( 'content', 'product' );

		                        endwhile;
		                    }

		                    wp_reset_postdata();
		                ?>
		                </ul><!--/.products-->
        			</div>
				  </div>

				  <div id="drinks" class="menu-sec-container menu-sec-border papabowls" style="display:none">
				    <div class="woocommerce columns-3">
        				<ul class="products columns-3">
				    	<?php
		                	$ids_raw = get_field('menu_tabs_and_item_drinks');
                            $ids_instock = array_filter( (array) $ids_raw, function($pid){
                                return get_post_meta($pid,'_stock_status',true)==='instock';
                            } );
                            if(!empty($ids_instock)){
                                $args = array(
                                    'post_type' => 'product',
                                    'post__in'  => $ids_instock,
                                    'posts_per_page' => 3,
                                    'orderby' => 'post__in',
                                    'meta_query' => array(
                                        array(
                                            'key' => '_stock_status',
                                            'value' => 'instock',
                                            'compare' => '='
                                        )
                                    )
                                );
                            } else {
                                $args = array(
                                    'post_type' => 'product',
                                    'posts_per_page' => 3,
                                    'orderby' => 'date',
                                    'order'   => 'DESC',
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'product_cat',
                                            'field'    => 'slug',
                                            'terms'    => 'drinks',
                                        )
                                    ),
                                    'meta_query' => array(
                                        array(
                                            'key' => '_stock_status',
                                            'value' => 'instock',
                                            'compare' => '='
                                        )
                                    )
                                );
                            }
		                    $loop = new WP_Query( $args );

		                    if ( $loop->have_posts() ) {

		                        while ( $loop->have_posts() ) : $loop->the_post();

		                            wc_get_template_part( 'content', 'product' );

		                        endwhile;
		                    }

		                    wp_reset_postdata();
		                ?>
		                </ul><!--/.products-->
        			</div>
				   </div>
				 </div>

				</div>

		</div>

	</div>

</section>

<!-- Contacts -->

<section class="contact-sec" id="contacts">

	<div class="container">
		<h2 class="contact-sec-h2">CONTACT US</h2>

		<div class="flex contact-info">

			<div class="contact-info-item">
				<img src="<?php the_field('contacts_icon1'); ?>" alt="adress">
				<div><?php the_field('contact_info_1'); ?></div>
			</div>

			<div class="contact-info-item">
				<img src="<?php the_field('contacts_icon2'); ?>" alt="e-mail">
				<div><?php the_field('contact_info_2'); ?></div>
			</div>

			<div class="contact-info-item">
				<img src="<?php the_field('contacts_icon3'); ?>" alt="phone">
				<div><?php the_field('contact_info_3'); ?></div>
			</div>

		</div>

		<div class="flex contacts-check-map" id="postcheck">

			<!--<div class="contacts-check-map-left">
		<img src="--><?php /*//the_field('contact_img'); */?><!--" alt="map">
				<?php /*echo do_shortcode('[szbd ids="154" color="#c87f93"]'); */?>
			</div>-->

		<!--	<div class="contacts-check-map-right">
				<h2><?php /*the_field('contact_heading_right'); */?></h2>
				<p><?php /*the_field('contact_check_area'); */?></p>

				<div class="contacts-check-map-find-me">
					<?php /*echo do_shortcode('[wpc_pincode_checker]'); */?>
				</div>

			</div>-->

		</div>
		</div>

		<div class="container">
			<div class="flex contacts-delivery-method">

				<div class="contacts-delivery-method-left">
					<h2><?php the_field('contact_heading_left'); ?></h2>
					<p><?php the_field('contact_text_left'); ?></p>
				</div>

				<div class="flex contacts-delivery-method-right">

					<?php if( have_rows('contact_delivery_methods') ): ?>

					    <?php while( have_rows('contact_delivery_methods') ): the_row();
					        $deliv_image = get_sub_field('delivery_logo');
					        $deliv_text = get_sub_field('delivery_text_button');
					        $deliv_link = get_sub_field('delivery_link_button');
					    ?>
					        <div class="contacts-delivery-method-right-item">
					            <img src="<?php echo $deliv_image; ?>" alt="logo">
					            <a href="<?php echo $deliv_link; ?>" target="_blank"><?php echo $deliv_text; ?></a>
					        </div>
					    <?php endwhile; ?>

					<?php endif; ?>

				</div>
			</div>

		</div>
	</div>

</section>

<!-- About us -->
<section class="team-sec" id="story">

	<div class="container team-sec-up">

		<div class="team-sec-up-wrap">

			<h2><?php the_field('about_us_heading'); ?></h2>

			<div class="flex team-sec-up-text">

				<p><?php the_field('about_us_left_text'); ?></p>
				<p><?php the_field('about_us_right_text'); ?></p>

			</div>

		</div>

	</div>

	<div class="container flex team-sec-down">

		<img src="<?php the_field('about_us_photo'); ?>" alt="team" width="897" height="588">

		<div class="team-sec-down-right">
			<h2><?php the_field('about_us_heading2'); ?></h2>
			<p><?php the_field('about_us_text'); ?></p>
		</div>

	</div>

</section>

<?php get_footer(); ?>

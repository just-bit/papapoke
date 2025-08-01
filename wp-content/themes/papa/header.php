<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <meta name="viewport" content="width=device-width, user-scalable=no">

  <meta name="format-detection" content="telephone=no">

  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

  <?php wp_head(); ?>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">


</head>

<body <?php body_class(); ?> >
  <!-- header content begin -->
  <header id="header">

    <div class="main-header-bar-wrap">

      <?php 
                  $hdr_left_txt = get_field('info_dock_left', 'option');
                  $hdr_right_txt = get_field('info_dock_right', 'option');
                  if( $hdr_left_txt ) { ?>
                  
                  <div class="header-banner-wrap">

                    <div class="container flex">

                      <marquee direction="left" loop="-1" behavior="scroll" class="header-line">

                        <?php echo $hdr_left_txt; ?>

                        <img src="/wp-content/themes/papa/assets/img/star_header.svg" alt="star" height="28" width="28"> 

                        <?php echo $hdr_right_txt; ?>

                      </marquee>

                    </div>
                  
                  </div>
                  
                  <?php }
      ?>
      

      <div class="container flex main-menu-container">
        
          <div class="header-logo">
              <?php if ( is_front_page() ) : ?>

              <?php else: ?>

                  <a href="<?php bloginfo('url'); ?>" class="logo">

              <?php endif; ?>

                  <?php 
                    $image = get_field('header_logo', 'option');
                    $size = 'full'; // (thumbnail, medium, large, full or custom size)
                    if( $image ) {
                        echo wp_get_attachment_image( $image, $size );
                    }
                  ?>
                  
              <?php if ( is_front_page() ) : ?>

            <?php else: ?>

                  </a>

            <?php endif; ?>
          </div>




          <nav class="pc__menu">
            <?php
              wp_nav_menu( array( 
                  'theme_location' => 'main_menu', 
                  'container_class' => 'main-menu',
                  'container' => 'nav'
                  ) ); 
             ?>
          </nav>

        

        <div class="main-account-cont">
          
<!--           <div class="main-header-profile">
            <a href="/my-account/"><img src="/wp-content/themes/safe/assets/img/profile.svg" alt="profile"  class="header-profile-img" width="30" height="30"></a>
          </div> -->

          <div class="main-header-cart">
            <?php echo do_shortcode("[woo_cart_but]"); ?>
          </div>

           <div class="mob__menu">
            <div class="mobile__button">
              <button id="trigger-overlay" type="button" class="open-menu-button">
                <img src="/wp-content/themes/papa/assets/img/burger-menu.svg" alt="burger" width="30" height="20">
              </button>
            </div>
          </div>

        </div>

      </div>

    </div>

    <div class="main-header-bar-wrap scroll-header show">
      <div class="container flex">
        <div class="header-logo">
            <?php if ( is_front_page() ) : ?>

              <?php else: ?>

                  <a href="<?php bloginfo('url'); ?>" class="logo">

              <?php endif; ?>

                  <?php 
                    $image = get_field('header_logo', 'option');
                    $size = 'full'; // (thumbnail, medium, large, full or custom size)
                    if( $image ) {
                        echo wp_get_attachment_image( $image, $size );
                    }
                  ?>
              <?php if ( is_front_page() ) : ?>

              <?php else: ?>

                  </a>

            <?php endif; ?>
        </div>


        <nav class="pc__menu">
          <?php
            wp_nav_menu( array( 
                'theme_location' => 'main_menu', 
                'container_class' => 'main-menu',
                'container' => 'nav'
                ) ); 
           ?>
        </nav>

        <div class="mob__menu">

          <div class="main-header-cart">
            <?php echo do_shortcode("[woo_cart_but]"); ?>
          </div>

          <div class="mobile__button">
            <button id="trigger-overlay2" type="button" class="open-menu-button"><img src="/wp-content/themes/papa/assets/img/burger-menu.svg" alt="burger" width="30" height="20"></button>
          </div>
        </div>

        <div class="main-account-cont">
          
<!--           <div class="main-header-profile">
            <a href="/my-account/"><img src="/wp-content/themes/safe/assets/img/profile.svg" alt="profile" width="30" height="30"></a>
          </div> -->

          
        </div>

      </div>

      


    </div>

    <div class="mob-show">
      <div class="overlay overlay-slidedown">

        <div class="container flex submenu-info">
          
          <div class="header-logo">
            
          </div>

          <button type="button" class="overlay-close"><span class="overlay-close-ico"></span></button>

        </div>
        
        <div class="container mob-menu-menulist">
          <nav class="mobile__menu">
              <?php
                wp_nav_menu( array( 
                    'theme_location' => 'main_menu', 
                    'container_class' => 'main-menu',
                    'container' => 'nav'
                    ) ); 
               ?>
            </nav>
        </div>

        <div class="container mob-menu-buttons">

          <?php

            $mobile_contact_logo_1 = get_field('mobile_contact_logo_1', 'option');
            $size_ico = 'full';
            
            if ($mobile_contact_logo_1) { ?>
            <!-- tg link 1 -->
            <div class="mob-menu-tg">
              
              <img src="<?php the_field('mobile_contact_logo_1', 'option'); ?>" alt="<?php the_field('mobile_contact_text_1', 'option'); ?>" width="34" height="36">

              <p><?php the_field('mobile_contact_text_1', 'option'); ?></p>

              <a href="<?php the_field('mobile_contact_link_1', 'option'); ?>" target="_blank"><?php the_field('mobile_contact_link_text_1', 'option'); ?></a>

            </div>

          <?php } ?>

          <?php

            $mobile_contact_logo_2 = get_field('mobile_contact_logo_2', 'option');

            if ($mobile_contact_logo_2) { ?>

          <!-- tg link 2 -->
          <div class="mob-menu-tg">
            
            <img src="<?php the_field('mobile_contact_logo_2', 'option'); ?>" alt="<?php the_field('mobile_contact_text_2', 'option'); ?>" width="34" height="36">

            <p><?php the_field('mobile_contact_text_2', 'option'); ?></p>

            <a href="<?php the_field('mobile_contact_link_2', 'option'); ?>" target="_blank"><?php the_field('mobile_contact_link_text_2', 'option'); ?></a>

          </div>

          <?php } ?>

          <?php

            $mobile_contact_logo_3 = get_field('mobile_contact_logo_3', 'option');

            if ($mobile_contact_logo_3) { ?>

          <!-- tg link 3 -->
          <div class="mob-menu-tg">
            
            <img src="<?php the_field('mobile_contact_logo_3', 'option'); ?>" alt="<?php the_field('mobile_contact_text_3', 'option'); ?>" width="34" height="36">

            <p><?php the_field('mobile_contact_text_3', 'option'); ?></p>

            <a href="<?php the_field('mobile_contact_link_3', 'option'); ?>" target="_blank"><?php the_field('mobile_contact_link_text_3', 'option'); ?></a>

          </div>

          <?php } ?>

        </div>

      </div>
    </div>

  </header>

<!-- header content end -->
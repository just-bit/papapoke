<?php
//Styles and scrypts
function add_theme_scripts() {
  wp_enqueue_style( 'main-style', get_stylesheet_uri(), 11 );
  wp_enqueue_script( 'main-js',  get_stylesheet_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );

// Main menu
function wpb_custom_new_menu() {
  register_nav_menu('main_menu',__( 'Header Menu' ));
}
add_action( 'init', 'wpb_custom_new_menu' );

// Title teme support
add_theme_support( 'title-tag' );

//Add thumbnail support
add_theme_support( 'post-thumbnails' );

//add logo support
add_theme_support( 'custom-logo' );

//disable gutenberg
add_filter('use_block_editor_for_post', '__return_false', 10);

//add navigation menu placement
add_filter('navigation_markup_template', 'my_navigation_template', 10, 2 );
function my_navigation_template( $template, $class ){

    return '
    <nav class="navigation %1$s" role="navigation">
        <div class="nav-links">%3$s</div>
    </nav>    
    ';
}

//add special classes for navigation menu
add_filter( 'nav_menu_css_class', 'special_nav_class', 10, 2 );
function special_nav_class($classes, $item){
    if( is_single() && $item->title == "Blog" ){
        $classes[] = "special-class";
    }

    return $classes;
}

// ACF THEME OPTIONS
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

}

// Woocommerce setup
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
   add_theme_support( 'woocommerce' );
}

if (class_exists('Woocommerce')){
    add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
}

function mytheme_add_woocommerce_support() {
add_theme_support( 'woocommerce', array(
/*'thumbnail_image_width' => 150,
'single_image_width'    => 300,*/
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 3,
            'min_columns'     => 2,
            'max_columns'     => 3,
        ),
) );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

//
add_action( 'after_setup_theme', 'yourtheme_setup' );
function yourtheme_setup() {
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}

// Add additionals menu in footer
function wpb_custom_footer_menu() {
  register_nav_menus(
    array(
      'footer-categories' => __( 'Footer categories' ),
      'footer-information' => __( 'Footer info menu' )
    )
  );
}
add_action( 'init', 'wpb_custom_footer_menu' );

// WOOCOMMERCE SALE BADGE
add_action( 'woocommerce_sale_flash', 'pancode_echo_sale_percent' );

// CART MENU Shortcode
add_shortcode ('woo_cart_but', 'woo_cart_but' );
function woo_cart_but() {
    ob_start();

        $cart_count = WC()->cart->cart_contents_count; // Set variable for cart item count
        $cart_url = wc_get_checkout_url();  // Set Cart URL

        ?>
            <a class="menu-item cart-contents" href="<?php echo $cart_url; ?>" title="My Basket">
                <?php
                    if ( $cart_count > 0 ) {
                ?>
                    <span class="cart-contents-count"><?php echo $cart_count; ?></span>
                <?php

}                ?>
            </a>
        <?php

    return ob_get_clean();

}

// Add AJAX Shortcode when cart contents update
add_filter( 'woocommerce_add_to_cart_fragments', 'woo_cart_but_count' );
function woo_cart_but_count( $fragments ) {

    ob_start();

    $cart_count = WC()->cart->cart_contents_count;
    // $cart_url = wc_get_cart_url();
    $cart_url = wc_get_checkout_url();

    ?>
    <a class="cart-contents<?= $cart_count == 0 ? ' cart-contents-empty' : '' ?> menu-item" href="<?php echo $cart_url; ?>" title="<?php _e( 'View your shopping cart' ); ?>">
    <?php
    if ( $cart_count > 0 ) {
        ?>
        <span class="cart-contents-count"><?php echo $cart_count; ?></span>
        <?php
    }
        ?></a>
    <?php

    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}

// Remove woocommerce archive page title
add_filter( 'woocommerce_show_page_title', '__return_false' );

/**
 * Echo discount percent badge html.
 *
 * @param string $html Default sale html.
 *
 * @return string
 */
function pancode_echo_sale_percent( $html ) {
  global $product;

  /**
   * @var WC_Product $product
   */

  $regular_max = 0;
  $sale_min    = 0;
  $discount    = 0;

  if ( 'variable' === $product->get_type() ) {
    $prices      = $product->get_variation_prices();
    $regular_max = max( $prices['regular_price'] );
    $sale_min    = min( $prices['sale_price'] );
  } else {
    $regular_max = $product->get_regular_price();
    $sale_min    = $product->get_sale_price();
  }

  if ( ! $regular_max && $product instanceof WC_Product_Bundle ) {
    $bndl_price_data = $product->get_bundle_price_data();
    $regular_max     = max( $bndl_price_data['regular_prices'] );
    $sale_min        = max( $bndl_price_data['prices'] );
  }

  if ( floatval( $regular_max ) ) {
    $discount = round( 100 * ( $regular_max - $sale_min ) / $regular_max );
  }

  return '<span class="onsale">-&nbsp;' . esc_html( $discount ) . '%</span>';
}


// disable src set for google
function meks_disable_srcset( $sources ) {
    return false;
}
add_filter( 'wp_calculate_image_srcset', 'meks_disable_srcset' );

// change h2 to p - product title
function woocommerce_template_loop_product_title() {
   echo '<p class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . get_the_title() . '</p>';
}

// Removes sku
function sv_remove_product_page_skus( $enabled ) {
    if ( ! is_admin() && is_product() ) {
        return false;
    }

    return $enabled;
}
add_filter( 'wc_product_sku_enabled', 'sv_remove_product_page_skus' );

//  REGISTER SIDEBARS
function filter_widgets_sidebar(){
    register_sidebar( array(
        'name' => "Filter sidebar",
        'id' => 'filer-sidebar',
        'description' => 'Shop sidebar',
        'before_title' => '<button class="single__accordion widget-title">',
        'after_title' => '</button><div class="single__panel">',
        'before_widget' => '<div class="catalog-widget-block">',
        'after_widget' => '</div></div>',
    ) );

    register_sidebar(
        array(
            'name'          => 'Footer area 1',
            'id'            => 'sidebar-footer-area-1',
            'description'   => '',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<p class="widget-title">',
            'after_title'   => '</p>',
        )
    );

    register_sidebar(
        array(
            'name'          => 'Footer area 2',
            'id'            => 'sidebar-footer-area-2',
            'description'   => '',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<p class="widget-title">',
            'after_title'   => '</p>',
        )
    );

    register_sidebar(
        array(
            'name'          => 'Footer area 3',
            'id'            => 'sidebar-footer-area-3',
            'description'   => '',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<p class="widget-title">',
            'after_title'   => '</p>',
        )
    );


}
add_action( 'widgets_init', 'filter_widgets_sidebar' );

//Configure woocommerce profile page
add_filter ( 'woocommerce_account_menu_items', 'wc_remove_my_account_links' );
function wc_remove_my_account_links( $menu_links ){

    //unset( $menu_links['edit-address'] ); // Addresses
    //unset( $menu_links['dashboard'] ); // Remove Dashboard
    //unset( $menu_links['payment-methods'] ); // Remove Payment Methods
    //unset( $menu_links['orders'] ); // Remove Orders
    unset( $menu_links['downloads'] ); // Disable Downloads
    //unset( $menu_links['edit-account'] ); // Remove Account details tab
    //unset( $menu_links['customer-logout'] ); // Remove Logout link

    return $menu_links;

}

//Excerp max symbols
function get_excerpt($limit, $source = null){
    $excerpt = $source == "content" ? get_the_content() : get_the_excerpt();
    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    $excerpt = $excerpt.'...';
    return $excerpt;
}

//Blog Pagination
/*add_filter( 'navigation_markup_template', 'my_navigation_template', 10, 2 );
function my_navigation_template( $template, $class ) {
    return '<div class="b-pagination wow fadeIn" data-wow-delay=".05s" style="visibility: hidden;">%3$s</div>';
}*/


//Global blocks - activate if needed
/*add_action('init', function(){
    register_post_type( 'global_block', [
        'label'  => null,
        'labels' => [
            'name'               => 'Global blocks', // основное название для типа записи
            'singular_name'      => 'Global block', // название для одной записи этого типа
            'add_new'            => 'Add Global block', // для добавления новой записи
            'add_new_item'       => 'Adding Global block', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Editing Global block', // для редактирования типа записи
            'new_item'           => 'New Global block', // текст новой записи
            'view_item'          => 'Look Global block', // для просмотра записи этого типа.
            'search_items'       => 'Search Global block', // для поиска по этим типам записи
            'not_found'          => 'Not found', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Not found in trash', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'Global blocks', // название меню
        ],
        'description'         => '',
        'public'              => true,
        'show_in_menu'        => true, // показывать ли в меню адмнки
        'show_in_rest'        => null, // добавить в REST API. C WP 4.7
        'rest_base'           => null, // $post_type. C WP 4.7
        'menu_position'       => null,
        'menu_icon'           => null,
        'hierarchical'        => false,
        'supports'            => [ 'title'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => [],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ] );
});*/

// Templates for global blocks
require get_template_directory() . '/inc/html-parts.php';


//move short description after product meta
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 45 );

// Remove the product description Title
add_filter( 'woocommerce_product_description_heading', '__return_null' );

//disable product image zoom
function remove_image_zoom_support() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}
add_action( 'wp', 'remove_image_zoom_support', 100 );


// Our hooked in function - $fields is passed via the filter!
// Action: remove label from $fields
function custom_wc_checkout_fields_no_label($fields) {
    // loop by category
    foreach ($fields as $category => $value) {
        // loop by fields
        foreach ($fields[$category] as $field => $property) {
            // remove label property
            unset($fields[$category][$field]['label']);
        }
    }
     return $fields;
}

// Out of stock at end of list
add_action( 'pre_get_posts', function( $query ) {
    if ( $query->is_main_query() && function_exists('is_woocommerce') && is_woocommerce() && ( is_shop() || is_product_category() || is_product_tag() ) ) {
        if( $query->get( 'orderby' ) == 'menu_order title' ) {  // only change default sorting
            $query->set( 'orderby', 'meta_value' );
            $query->set( 'order', 'ASC' );
            $query->set( 'meta_key', '_stock_status' );
        }
    }
});

//hide out of stock on related products
function hide_out_of_stock_option( $option ){
    return 'yes';
}

add_action( 'woocommerce_before_template_part', function( $template_name ) {
if( $template_name !== "single-product/related.php" ) {
return;
}
add_filter( 'pre_option_woocommerce_hide_out_of_stock_items', 'hide_out_of_stock_option' );
} );


add_filter( 'woocommerce_product_query_tax_query', 'filter_product_query_tax_query', 10, 2 );
function filter_product_query_tax_query( $tax_query, $query ) {
    // On woocommerce home page only
    if( is_front_page() ){
        // Exclude products "out of stock"
        $tax_query[] = array(
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => array('outofstock'),
            'operator' => 'NOT IN'
        );
    }
    return $tax_query;
}

// Widgets container

// if no title then add widget content wrapper to before widget
add_filter( 'dynamic_sidebar_params', 'check_sidebar_params' );
function check_sidebar_params( $params ) {
    global $wp_registered_widgets;

    $settings_getter = $wp_registered_widgets[ $params[0]['widget_id'] ]['callback'][0];
    $settings = $settings_getter->get_settings();
    $settings = $settings[ $params[1]['number'] ];

    if ( $params[0][ 'after_widget' ] == '</div></div>' && isset( $settings[ 'title' ] ) && empty( $settings[ 'title' ] ) )
        $params[0][ 'before_widget' ] .= '<div class="content">';

    return $params;
}

/**
 * Allow HTML in term (category, tag) descriptions
 */
foreach ( array( 'pre_term_description' ) as $filter ) {
    remove_filter( $filter, 'wp_filter_kses' );
    if ( ! current_user_can( 'unfiltered_html' ) ) {
        add_filter( $filter, 'wp_filter_post_kses' );
    }
}

foreach ( array( 'term_description' ) as $filter ) {
    remove_filter( $filter, 'wp_kses_data' );
}

/**
 *  Hide additional information on product page
 */
add_filter( 'woocommerce_product_tabs', 'njengah_remove_product_tabs', 9999 );

  function njengah_remove_product_tabs( $tabs ) {

    unset( $tabs['additional_information'] );

    return $tabs;

}

/**
 * Add title and alt to product images
 */

add_filter('wp_get_attachment_image_attributes', 'change_attachement_image_attributes', 20, 2);

function change_attachement_image_attributes( $attr, $attachment ){

    // Get post parent
    $parent = get_post_field( 'post_parent', $attachment);

    // Get post type to check if it's product
    $type = get_post_field( 'post_type', $parent);
    if( $type != 'product' ){
        return $attr;
    }

    /// Get title
    $title = get_post_field( 'post_title', $parent);

    $attr['alt'] = $title;
    $attr['title'] = $title;

    return $attr;
}

/**
 * Remove setting from woocommerce menu
 */

add_action( 'admin_menu', 'remove_wc_settings', 999);
function remove_wc_settings() {

    global $current_user;

    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);

    if($user_role == "shop_manager") {
        $remove_submenu = remove_submenu_page('woocommerce', 'wc-settings');
        $remove_submenu = remove_submenu_page('woocommerce', 'wc-addons');
        $remove_submenu = remove_submenu_page('woocommerce', 'agy_settings');
        $remove_submenu = remove_submenu_page('woocommerce', 'marketing');
        $remove_submenu = remove_submenu_page('popup', 'popup');
        $remove_submenu = remove_menu_page('popup', 'popup');
        $remove_submenu = remove_menu_page('wpcf7', 'wpcf7');
        $remove_submenu = remove_menu_page('popup_theme', 'popup_theme');
        $remove_submenu = remove_menu_page('theme-general-settings', 'theme-general-settings');
        $remove_submenu = remove_menu_page('tools.php');
        $remove_submenu = remove_menu_page('edit.php');
        $remove_submenu = remove_menu_page( 'edit.php?post_type=popup' );
    }

}


/**
 * Out of stock at the end of list
*/

add_filter('posts_clauses', 'order_by_stock_status', 999 );
function order_by_stock_status($posts_clauses) {
    global $wpdb;
    // only change query on WooCommerce loops
    if (is_woocommerce() && (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy())) {
        $posts_clauses['join'] .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
        $posts_clauses['orderby'] = " istockstatus.meta_value ASC, " . $posts_clauses['orderby'];
        $posts_clauses['where'] = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];
    }
    return $posts_clauses;
}

/**
 * Move category desciprtion under pagination
 */
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_taxonomy_archive_description', 100 );

/**
 * Change echo of category description
 */
function woocommerce_taxonomy_archive_description() {
  if ( is_tax( array( 'product_cat', 'product_tag' ) ) && get_query_var( 'paged' ) == 0 ) {
    $description = wpautop( do_shortcode( term_description() ) );
    if ( $description ) {
      echo '<div class="term-description">' . $description . '</div>';
    }
  }
}

/*
* Delete shortlink
*/
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

/*
* delete some input fields on order page
*/
add_filter( 'woocommerce_checkout_fields', 'dw_remove_fields', 9999 );

function dw_remove_fields( $woo_checkout_fields_array ) {

    // she wanted me to leave these fields in checkout
    // unset( $woo_checkout_fields_array['billing']['billing_first_name'] );
    // unset( $woo_checkout_fields_array['billing']['billing_last_name'] );
    // unset( $woo_checkout_fields_array['billing']['billing_phone'] );
    // unset( $woo_checkout_fields_array['billing']['billing_email'] );
    // unset( $woo_checkout_fields_array['order']['order_comments'] ); // remove order notes

    // and to remove the billing fields below
    unset( $woo_checkout_fields_array['billing']['billing_company'] ); // remove company field
    // unset( $woo_checkout_fields_array['billing']['billing_country'] );
    // unset( $woo_checkout_fields_array['billing']['billing_address_1'] );
    unset( $woo_checkout_fields_array['billing']['billing_address_2'] );
    unset( $woo_checkout_fields_array['billing']['billing_city'] );
    unset( $woo_checkout_fields_array['billing']['billing_state'] ); // remove state field
    // unset( $woo_checkout_fields_array['billing']['billing_postcode'] ); // remove zip code field

    return $woo_checkout_fields_array;
}

add_filter( 'woocommerce_checkout_fields' , 'dw_not_required_fields', 9999 );

function dw_not_required_fields( $f ) {

    unset( $f['billing']['billing_company']['required'] ); // that's it
    // unset( $f['billing']['billing_phone']['required'] );

    // the same way you can make any field required, example:
    // $f['billing']['billing_company']['required'] = true;

    return $f;
}

/**
 * Show product weight on archive pages
 */
add_action( 'woocommerce_after_shop_loop_item', 'rs_show_weights', 4 );

function rs_show_weights() {

    global $product;
    $weight = $product->get_weight();

    if ( $product->has_weight() ) {
        echo '<div class="product-meta-weight">' . $weight . get_option('woocommerce_weight_unit') . '</div>';
    }
}

// Product quantity on catalog page
/**
 * Display QTY Input before add to cart link.
 */
function custom_wc_template_loop_quantity_input() {
    // Global Product.
    global $product;

    // Check if the product is not null, is purchasable, is a simple product, is in stock, and not sold individually.
    if ( $product && $product->is_purchasable() && $product->is_type( 'simple' ) && $product->is_in_stock() && ! $product->is_sold_individually() ) {
        woocommerce_quantity_input(
            array(
                'min_value' => 1,
                'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity(),
            )
        );
    }
}
add_action( 'woocommerce_after_shop_loop_item', 'custom_wc_template_loop_quantity_input', 9 );

/*
* Short description on product page
*/
function tutsplus_excerpt_in_product_archives() {

    echo '<div class="short-catalog">';
    the_excerpt();
    echo '</div>';

}

add_action( 'woocommerce_after_shop_loop_item_title', 'tutsplus_excerpt_in_product_archives', 9 );


/**
* Add type of product before image in loop
*/
// add_action( 'woocommerce_after_shop_loop_item_title', 'badge_new_acf', 2 );
// function badge_new_acf(){
//     global $product;

//     $product_new_type = get_field_object('product_type');
//     $product_new_type_value = $product_new_type['value'];

//     if( $product_new_type && in_array('showblock', $product_new_type) ) {
//        echo '<div class="product-type-img"><img src=';
//        echo $product_new_type['value'];
//        echo ' alt="product type image">';
//        echo '</div>';
//      }

// }

add_action( 'woocommerce_after_shop_loop_item_title', 'badge_new_acf', 2 );
function badge_new_acf(){
    global $product;

    $product_new_type = get_field_object('product_type');
    
    if( $product_new_type && is_array($product_new_type) ) {
        $product_new_type_value = $product_new_type['value'];

        if( $product_new_type_value && in_array('showblock', $product_new_type) ) {
           echo '<div class="product-type-img"><img src=';
           echo $product_new_type_value;
           echo ' alt="product type image">';
           echo '</div>';
         }
    }
}

/**
* Onepage checkout
*/

add_action( 'woocommerce_before_checkout_form', 'bbloomer_cart_on_checkout_page', 11 );

function bbloomer_cart_on_checkout_page() {
   echo do_shortcode( '[woocommerce_cart]' );
}

// On checkout page
/*add_action( 'woocommerce_checkout_order_review', 'remove_checkout_totals', 1 );
function remove_checkout_totals(){
    $cart_total = WC()->cart->get_cart_total();
    if ( $cart_total == 0 ) {
            // Remove cart totals block
            remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
    }
}*/

//Change the 'Billing details' checkout label to 'Contact Information'
function wc_billing_field_strings( $translated_text, $text, $domain ) {
switch ( $translated_text ) {
case 'Billing &amp; Shipping' :
$translated_text = __( 'DELIVERY', 'woocommerce' );
break;
}
return $translated_text;
}
add_filter( 'gettext', 'wc_billing_field_strings', 20, 3 );


/**
* Close information popup on btn click (check your postcode popup)
*/
add_action( 'wp_footer', 'my_custom_popup_scripts', 500 );
function my_custom_popup_scripts() { ?>
    <script type="text/javascript">
        (function ($, document, undefined) {

            $('#pum-183') // Change 123 to your popup ID number.
                .on('pumAfterOpen', function () {
                    var $popup = $(this);
                        $( "#popclose" ).click(function() {
                        $popup.popmake('close');
                    });
                });

        }(jQuery, document))
    </script><?php
}

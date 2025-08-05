<?php
// AJAX handler for loading more products on scroll
add_action( 'wp_ajax_papa_load_more_products', 'papa_load_more_products' );
add_action( 'wp_ajax_nopriv_papa_load_more_products', 'papa_load_more_products' );

function papa_load_more_products() {
    // Verify nonce for security.
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'papa_load_more_nonce' ) ) {
        wp_die();
    }

    $tab    = isset( $_POST['tab'] ) ? sanitize_text_field( wp_unslash( $_POST['tab'] ) ) : '';
    $offset = isset( $_POST['offset'] ) ? intval( $_POST['offset'] ) : 0;

    if ( ! $tab ) {
        wp_die();
    }

    // Map tab IDs to ACF field names.
    $field_map = array(
        'bowls'  => 'menu_tabs_and_item_bowls',
        'rolls'  => 'menu_tabs_and_item_rolls',
        'extras' => 'menu_tabs_and_item_extras',
        'drinks' => 'menu_tabs_and_item_drinks',
    );

    if ( ! isset( $field_map[ $tab ] ) ) {
        wp_die();
    }

    // Get front page ID to read ACF fields from it.
    $page_id = get_option( 'page_on_front' );

    $ids_raw = get_field( $field_map[ $tab ], $page_id );
    // оставляем только товары "в наличии"
    $ids = array_filter( (array) $ids_raw, function ( $pid ) {
        return get_post_meta( $pid, '_stock_status', true ) === 'instock';
    } );

    if ( empty( $ids ) || ! is_array( $ids ) ) {
        wp_die();
    }

    // Slice next 3 in-stock IDs based on the current offset.
    $batch = 3;

    if ( ! empty( $ids ) ) {
        // Список товаров задан в ACF – работаем по ID
        $next_ids = array_slice( $ids, $offset, $batch );
        if ( empty( $next_ids ) ) {
            wp_die(); // больше нечего грузить
        }
        $args = array(
            'post_type'      => 'product',
            'post__in'       => $next_ids,
            'posts_per_page' => $batch,
            'orderby'        => 'post__in',
        );
    } else {
        // Fallback: берем товары конкретной категории
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => $batch,
            'offset'         => $offset,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $tab,
                )
            ),
        );
    }

    // в любом случае фильтруем только instock
    $args['meta_query'] = array(
        array(
            'key'     => '_stock_status',
            'value'   => 'instock',
            'compare' => '=',
        ),
    );

    $loop = new WP_Query( $args );

    if ( $loop->have_posts() ) {
        ob_start();

        while ( $loop->have_posts() ) {
            $loop->the_post();
            wc_get_template_part( 'content', 'product' );
        }

        wp_reset_postdata();

        echo ob_get_clean();
    }

    wp_die();
}

<?php

function dd( $data ) {
    highlight_string("<?php\n " . var_export($data, true) . "?>");
    echo '<script>document.getElementsByTagName("code")[0].getElementsByTagName("span")[1].remove() ;document.getElementsByTagName("code")[0].getElementsByTagName("span")[document.getElementsByTagName("code")[0].getElementsByTagName("span").length - 1].remove() ; </script>';
    die();
}

if ( ! function_exists( 'is_woocommerce_activated' ) ) {
    /**
     * Check is woocommerce installed and activated
     *
     * @return boolean
     */
	function is_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}
}

/**
 * Insert/Update a row of relationship of gumroad and woocommerce products
 *
 * @param  array  $args
 *
 * @return int|WP_Error
 */
function ul_update_gumroad_relationship( $args = [] ) {
    global $wpdb;

    if (empty($args['product_id']) || empty($args['gumroad_product_id'])) {
        return new \WP_Error('no-id', __('Invalid product id', 'uilib-gumpress'));
    }

    $defaults = [
        'product_id'         => '',
        'gumroad_product_id' => '',
        'created_by'         => get_current_user_id(),
        'created_at'         => current_time('mysql'),
    ];

    $data = wp_parse_args($args, $defaults);

    if (isset($data['id'])) {

        $id = $data['id'];
        unset($data['id']);

        $inserted = $wpdb->update(
            $wpdb->prefix . 'gumroad_product_relationships',
            $data,
            ['id' => $id],
            [
                '%s',
                '%s',
                '%s',
                '%d',
                '%s'
            ],
            ['%d']
        );
    } else {

        $inserted = $wpdb->insert(
            $wpdb->prefix . 'gumroad_product_relationships',
            $data,
            [
                '%s',
                '%s',
                '%s',
                '%d',
                '%s'
            ]
        );
    }

    if (!$inserted) {
        return new \WP_Error('failed-to-insert', __('Failed to insert data', 'uilib-gumpress'));
    }

    return $wpdb->insert_id;
}

/**
 * Returns a row of relationship of gumroad and woocommerce products.
 *
 * @param int $id | gumroad product id.
 */
function get_gumroad_relationship( $id ) {
    global $wpdb;
    $gum_product = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}gumroad_product_relationships WHERE gumroad_product_id = %s", $id ) );
    return $gum_product;
}


/**
 * Trim spaces from name property of gumroad data.
 *
 * @param array $variants | The data to insert in the product.
 */
function ul_sanitize_variants( $variants ) {
    foreach ( $variants as $key => $variant ) {
        $variant['name'] = trim($variant['name']);
        $variants[$key]  = $variant;
    }
    return $variants;
}


/**
 * Create _product_attributes post meta with serialized array of attributes
 * for a defined variable product ID.
 *
 * @param int   $product_id | Post ID of the product parent variable product.
 * @param string $attribute_name | Post meta key.
 * @param array $variants | an formated array will be generated from this.
 * @return int|boolean
 */
function ul_create_product_attributes( $product_id, $attribute_name, $variants ) {
    $attribute_value = "";

    foreach ( $variants as $key => $variant ) {
        if ( $key === array_key_last( $variants ) ) {
            $attribute_value .= $variant['name'];
        } else {
            $attribute_value .= $variant['name'] . ' | ';
        }
    }

    $attribute_data = array( $attribute_name => array(
        "name" => $attribute_name,
        'value' => $attribute_value,
        'position' => 0,
        'is_visible' => 1,
        'is_variation' => 1,
        'is_taxonomy' => 0,
    ) );

    return update_post_meta( $product_id, '_product_attributes', $attribute_data );
}

/**
 * Create a product variation for a defined variable product ID.
 *
 * @param int   $product_id | Post ID of the product parent variable product.
 * @param array $variation_data | The data to insert in the product.
 */
function ul_create_product_variation( $product_id, $variation_data, $update = false ) {
    $variants       = ul_sanitize_variants( $variation_data['variants'] );
    $base_price     = $variation_data['base_price'];
    $attribute_name = "versions";

    ul_create_product_attributes( $product_id, $attribute_name, $variants );

    // make product variable product type
    wp_set_post_terms( $product_id, 'variable', 'product_type', false );

    // Get an instance of the Wc_Product
    $product = wc_get_product( $product_id );

    // If update, delete existing variations
    if( $update ) {
        $variable_products = get_children(array(
            'post_type'   => 'product_variation',
            'post_parent' => $product_id,
        ));

        foreach ( $variable_products as $variable_id => $variable ) {
            wp_delete_post( $variable_id );
        }
    }

    // Create new variations
    foreach ( $variants as $key => $variant ) {

        $variation_post = array(
            'post_title'  => $product->get_name(),
            'post_name'   => 'product-' . $product_id . '-variation',
            'post_status' => 'publish',
            'post_parent' => $product_id,
            'post_type'   => 'product_variation',
            'guid'        => $product->get_permalink()
        );

        // Create the product variation
        $variation_id = wp_insert_post( $variation_post );

        // update post meta for each variation
        update_post_meta($variation_id, 'attribute_' . $attribute_name, $variant['name']);

        // Get an instance of the WC_Product_Variation
        $variation = new WC_Product_Variation( $variation_id );

        $variation->set_regular_price( ( $variant['price_difference'] / 100 ) + ( $base_price / 100 ) );

        // Save the data
        $variation->save();
    }
}



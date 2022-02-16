<?php

namespace UIlib\Gumpress\Admin;

/**
 * The Menu handler class
 */
class Product {

	/**
	 * Initialize the class
	 */
	public function __construct() {
	}

    /**
     * Create woocommerce product
     *
     * @param array $args
     * @return int|WP_Error
     */
	public function create_product( $args ) {
		$product_id = wp_insert_post(
			array(
				'post_title'   => $args['name'],
				'post_type'    => 'product',
				'post_status'  => 'publish',
				'post_content' => $args['description'],
			)
		);

        $this->set_base_price( $product_id, ( $args['price'] / 100 ) );
		$this->set_gumroad_short_url( $product_id, $args['short_url'] );
        $product_image_url = $args['thumbnail_url'] ? $args['thumbnail_url'] : $args['preview_url'];
		$this->set_product_featured_image( $product_id, $args['name'], $product_image_url );

        return $product_id;
	}

    /**
     * Update Woocommerce product
     *
     * @param int $product_id
     * @param array $args
     * @return int|WP_Error
     */
    public function update_product( $product_id, $args ) {

        $post_data = array(
            'ID'           => $product_id,
            'post_type'    => 'product',
            'post_status'  => 'publish'
        );

        // IF TITLE RESET IS TRUE
        if(get_option('gp_reset_title')) {
            $post_data['post_title'] = $args['name'];
        }
        // IF DESCRIPTION RESET IS TRUE
        if(get_option('gp_reset_description')) {
            $post_data['post_content'] = $args['description'];
        }

        $product_id = wp_update_post( $post_data );

        $this->set_base_price( $product_id, ( $args['price'] / 100 ) );
		$this->set_gumroad_short_url( $product_id, $args['short_url'] );
        $product_image_url = $args['thumbnail_url'] ? $args['thumbnail_url'] : $args['preview_url'];
		$this->set_product_featured_image(
            $product_id,
            $args['name'],
            $product_image_url,
            true
        );

        return $product_id;
    }

    /**
     * Set base price for variable product
     *
     * @param int $product_id
     * @param int $price
     * @return int|boolean
     */
	public function set_base_price( $product_id, $price ) {
		return update_post_meta( $product_id, '_price', $price );
	}

    /**
     * Save gumroad product url to post meta
     *
     * @param int $product_id
     * @param string $url
     * @return int|boolean
     */
	public function set_gumroad_short_url( $product_id, $url ) {
		return update_post_meta( $product_id, 'gumroad_product_url', $url );
	}

    /**
     * Set featured image for product
     *
     * @param int $post_id
     * @param string $image_name
     * @param string $image_url
     * @return int|boolean
     */
	public function set_product_featured_image( $post_id, $image_name, $image_url, $update = false ) {
        $image_name      .= '.jpg';
		$upload_dir       = wp_upload_dir();
		$image_data       = file_get_contents( $image_url );
		$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name );
		$filename         = basename( $unique_file_name );
		$wp_filetype      = wp_check_filetype( $filename, null );

		// Check folder permission and define file location
		if ( wp_mkdir_p( $upload_dir['path'] ) ) {
			$file = $upload_dir['path'] . '/' . $filename;
		} else {
			$file = $upload_dir['basedir'] . '/' . $filename;
		}

		// Create the image file on the server
		file_put_contents( $file, $image_data );

		// Set attachment data
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_file_name($filename),
			'post_content'   => '',
			'post_status'    => 'inherit',
		);

        // Delete attachment if already exists
        if ( $update ) {
            $attachment_id = get_post_thumbnail_id( $post_id );
            wp_delete_attachment( $attachment_id );
        }

		// Create the attachment
		$attach_id = wp_insert_attachment( $attachment, $file, $post_id );

		// Include image.php
		require_once ABSPATH . 'wp-admin/includes/image.php';

		// Define attachment metadata
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

		// Assign metadata to attachment
		wp_update_attachment_metadata( $attach_id, $attach_data );

		// And finally assign featured image to post
		return set_post_thumbnail( $post_id, $attach_id );
	}
}

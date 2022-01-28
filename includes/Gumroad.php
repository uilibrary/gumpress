<?php

namespace UIlib\Gumpress;

class Gumroad {

    /**
     * Initialize the class
	**/
	public function __construct() {
    }

    /**
     * Add authentication token to api endpoint
     *
     * @param string $resource_url
     * @return string
     */
    public function get_tokenized_url( $resource_url ) {
        $api_url = "https://api.gumroad.com/v2";
        $token = get_option('gumroad_http_token');
        return $api_url . $resource_url . '?access_token=' . $token;
    }

    /**
     * Filter published product
     *
     * @param mixed $product
     * @return boolean
     */
    public function filter_published_products( $product ) {
        return $product['published'];
    }

    /**
     * Get data from Gumroad api endpoint
     *
     * @param string $resource_url
     * @return array|WP_Error
     */
    public function get_resource($resource_url) {

        $response = wp_remote_get($this->get_tokenized_url($resource_url));
        $status_code = wp_remote_retrieve_response_code($response);

        $body = wp_remote_retrieve_body($response);

        if (!is_wp_error($response) && $status_code === 200) {
            return json_decode($body, true);

        } elseif ( $status_code === 401 ) {
            return new \WP_Error('gumroad-unathorized', __('Invalid token!', 'uilib-gumpress'));
        } else {
            return new \WP_Error('gumroad-error', __('Error while getting data from Gumroad!!', 'uilib-gumpress'));
        }
    }

    /**
     * Get Gumroad product list
     *
     * @return array|WP_Error
     */
    public function get_product_list() {
        $data = $this->get_resource('/products');

        if ( !is_wp_error( $data ) ) {
            return $data['products'];
        } else {
            return $data;
        }
    }

    /**
     * Get Gumroad product list
     *
     * @return array|WP_Error
     */
    public function get_published_product_list() {
        $products = $this->get_product_list();

        if ( is_wp_error( $products ) ) {
            return $products;
        }

        return array_filter( $products, [$this, 'filter_published_products'] );
    }

    /**
     * Get Gumroad product
     *
     * @return array|WP_Error
     */
    public function get_product( $id ) {
        $data = $this->get_resource('/products/' . $id);

        if ( !is_wp_error( $data ) ) {
            return $data['product'];
        } else {
            return $data;
        }
    }
}

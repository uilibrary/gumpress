<?php

namespace UIlib\Gumpress;

class Gumroad
{

    /**
     * Initialize the class
     */
    public function __construct()
    {
    }

    public function get_tokenized_url($resource_url)
    {
        $api_url = "https://api.gumroad.com/v2";
        $token = get_option('gumroad_http_token');
        return $api_url . $resource_url . '?access_token=' . $token;
    }

    public function get_resource($resource_url)
    {
        $response = wp_remote_get($this->get_tokenized_url($resource_url));
        $status_code = wp_remote_retrieve_response_code($response);

        // var_dump($status_code);

        $body = wp_remote_retrieve_body($response);

        if (!is_wp_error($response) && $status_code === 200) {
            return json_decode($body, true);
        } elseif($status_code === 401) {
            return wp_die('<div class="notice notice-error">
                <p>Invalid token!</p>
            </div>');
        } else {
            return wp_die('<div class="notice notice-error">
                <p>Error while getting data from Gumroad!</p>
            </div>');
        }
    }

    public function get_product_list()
    {
        return $this->get_resource('/products')['products'];
    }

    public function get_product($id)
    {
        return $this->get_resource('/products/' . $id)['product'];
    }
}

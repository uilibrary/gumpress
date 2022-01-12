<?php

namespace UIlib\Gumpress;

class Gumroad
{

    /**
     * Initialize the class
     */
    function __construct()
    {
    }

    public function getTokenizedurl($resource_url)
    {
        $api_url = "https://api.gumroad.com/v2";
        $token = 'kqkBGQ_Tr3gJiupfgLoBgAJcMmfrR-npSl700ngzJNA';
        return $api_url . $resource_url . '?access_token=' . $token;
    }

    public function get_resource($resource_url)
    {
        $response = wp_remote_get($this->getTokenizedurl($resource_url));
        $body     = wp_remote_retrieve_body($response);
        // wp_die(json_decode($body, true));

        if (!is_wp_error($response)) { //decode and return
            return json_decode($body, true);
        } else {
            return wp_die('Can not get gumroad product');
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

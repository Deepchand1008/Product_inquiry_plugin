<?php
/*
Plugin Name: Product Enquiry
Description: A plugin to add a product enquiry form on WooCommerce product pages.
Version: 1.0
Author: ITM
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Include the main class
require_once plugin_dir_path(__FILE__) . 'includes/class-product-enquiry.php';

// Initialize the plugin
function product_enquiry_init() {
    $product_enquiry = new Product_Enquiry();
}
add_action('plugins_loaded', 'product_enquiry_init');

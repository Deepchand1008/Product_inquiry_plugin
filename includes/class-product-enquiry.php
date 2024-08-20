<?php

class Product_Enquiry {
    public function __construct() {
        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        
        // Add the enquiry button on the product page
        add_action('woocommerce_after_add_to_cart_button', [$this, 'add_enquiry_button']);
        
        // Handle enquiry form submission
        add_action('admin_post_nopriv_product_enquiry', [$this, 'handle_enquiry_submission']);
        add_action('admin_post_product_enquiry', [$this, 'handle_enquiry_submission']);
    }

    public function enqueue_scripts() {
        wp_enqueue_style('product-enquiry-style', plugins_url('../assets/css/style.css', __FILE__));
        wp_enqueue_script('product-enquiry-script', plugins_url('../assets/js/script.js', __FILE__), ['jquery'], null, true);
    }

    public function add_enquiry_button() {
        echo '<button id="product-enquiry-btn">Enquire about this product</button>';
        $this->render_enquiry_form();
    }

    public function render_enquiry_form() {
        echo '<div id="product-enquiry-form" style="display:none;">';
        echo '<form action="' . esc_url(admin_url('admin-post.php')) . '" method="POST">';
        echo '<input type="hidden" name="action" value="product_enquiry">';
        echo '<input type="text" name="enquiry_name" placeholder="Your Name" required>';
        echo '<input type="email" name="enquiry_email" placeholder="Your Email" required>';
        echo '<textarea name="enquiry_message" placeholder="Your Message" required></textarea>';
        echo '<input type="hidden" name="product_id" value="' . get_the_ID() . '">';
        echo '<button type="submit">Submit Enquiry</button>';
        echo '</form>';
        echo '</div>';
    }

    public function handle_enquiry_submission() {
        if (!isset($_POST['enquiry_name'], $_POST['enquiry_email'], $_POST['enquiry_message'], $_POST['product_id'])) {
            wp_redirect(wp_get_referer());
            exit;
        }

        // Process the enquiry data
        $product_id = intval($_POST['product_id']);
        $name = sanitize_text_field($_POST['enquiry_name']);
        $email = sanitize_email($_POST['enquiry_email']);
        $message = sanitize_textarea_field($_POST['enquiry_message']);

        // Send the email
        $product = wc_get_product($product_id);
        $subject = "Product Enquiry: " . $product->get_name();
        $admin_email = get_option('admin_email');
        $headers = ['Content-Type: text/html; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>'];

        wp_mail($admin_email, $subject, $message, $headers);

        // Redirect after submission
        wp_redirect(wp_get_referer());
        exit;
    }
}

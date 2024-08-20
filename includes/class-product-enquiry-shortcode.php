<?php

class Product_Enquiry_Shortcode {
    public function __construct() {
        add_shortcode('product_enquiry', [$this, 'render_shortcode']);
    }

    public function render_shortcode($atts) {
        ob_start();
        ?>
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
            <input type="hidden" name="action" value="product_enquiry">
            <input type="text" name="enquiry_name" placeholder="Your Name" required>
            <input type="email" name="enquiry_email" placeholder="Your Email" required>
            <textarea name="enquiry_message" placeholder="Your Message" required></textarea>
            <button type="submit">Submit Enquiry</button>
        </form>
        <?php
        return ob_get_clean();
    }
}

// Initialize the shortcode
new Product_Enquiry_Shortcode();

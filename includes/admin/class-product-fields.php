<?php

namespace WooProductField\Admin;

defined( 'ABSPATH' ) || exit;

class ProductFields extends \WooProductField\BaseProductFields {
    public function __construct() {
		parent::__construct();
        $this->hooks();
    }

    private function hooks() {
        add_action('woocommerce_product_options_inventory_product_data', array($this, 'add_field'));
        add_action('woocommerce_process_product_meta', array($this, 'save_field'), 10, 2);

        add_action('woocommerce_variation_options_inventory', array($this, 'add_variation_field'), 10, 3);
        add_action('woocommerce_save_product_variation', array($this, 'save_variation_field'), 10, 2);
    }

    public function add_field() {
        global $product_object;

        echo '<div class="options_group">';

        foreach ($this->fields as $field) {
            woocommerce_wp_text_input(
                array(
                    'id' => $field['id'],
                    'label' => $field['label'],
                    'description' => $field['description'],
                    'desc_tip' => true,
                    'value' => $product_object->get_meta($field['id']),
                )
            );
        }

        echo '</div>';
    }

    public function save_field($post_id, $post) {
        $product = wc_get_product($post_id);

        foreach ($this->fields as $field) {
            if (isset($_POST[$field['id']])) {
                $product->update_meta_data($field['id'], sanitize_text_field($_POST[$field['id']]));
            }
        }

        $product->save_meta_data();
    }

    // Assuming you have the methods for variations already implemented
    public function add_variation_field() {
        // Your code for adding variation fields
    }

    public function save_variation_field() {
        // Your code for saving variation fields
    }
}
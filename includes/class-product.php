<?php

namespace WooProductField;

defined( 'ABSPATH' ) || exit;

class BaseProductFields {

	protected $fields = [];

	public function __construct() {
        $this->fields = [
			[
				'id' => '_material',
				'label' => __('Material', 'woo_product_field'),
				'description' => __('Material', 'woo_product_field'),
			],
			[
				'id' => '_n_of_teeth',
				'label' => __('Hammaste arv', 'woo_product_field'),
				'description' => __('Hammaste arv', 'woo_product_field'),
			],
			[
				'id' => '_size',
				'label' => __('Suurus', 'woo_product_field'),
				'description' => __('Suurus', 'woo_product_field'),
			],
			[
				'id' => '_color',
				'label' => __('Värv', 'woo_product_field'),
				'description' => __('Värv', 'woo_product_field'),
			],
			[
				'id' => '_brand',
				'label' => __('Bränd', 'woo_product_field'),
				'description' => __('Bränd', 'woo_product_field'),
			],
        ];
	}
}
class Product extends BaseProductFields {
    public function __construct() {
		parent::__construct();
        $this->hooks();
    }

    private function hooks() {
        add_action('woocommerce_single_product_summary', array($this, 'add_stock_info'), 21);
    }

    public function add_stock_info() {
        global $product;

        foreach ($this->fields as $field) {
            $field_value = $product->get_meta($field['id']);
            if ($field_value) {
                echo '<p>' . esc_html($field['label']) . ': ' . esc_html($field_value) . '</p>';
            }
        }
    }
}

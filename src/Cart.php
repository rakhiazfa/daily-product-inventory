<?php

namespace GreatWebsiteStudio;

use DateTime;

/**
 * Cart Class
 * 
 * @author Great Website Studio
 */

class Cart
{
    /**
     * Create a new Cart instance.
     * 
     */
    public function __construct()
    {

        $this->registerCartScripts();
    }

    /**
     * Register cart scripts.
     * 
     * @return void
     */
    public function registerCartScripts()
    {
        add_action(
            'woocommerce_add_to_cart',
            array($this, 'addToCart'),
            10,
            6
        );
    }

    /**
     * Add to cart.
     * 
     * @param mixed $cart_item_key
     * @param mixed $product_id
     * @param mixed $quantity
     * @param mixed $variation_id
     * @param mixed $variation
     * @param mixed $cart_item_data
     * 
     * @return void
     */
    public function addToCart($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data)
    {
        /**
         * Convert day to post meta.
         * 
         */

        $days = [
            'monday' => 'dpi_monday_stock_quantity',
            'tuesday' => 'dpi_tuesday_stock_quantity',
            'wednesday' => 'dpi_wednesday_stock_quantity',
            'thursday' => 'dpi_thursday_stock_quantity',
            'friday' => 'dpi_friday_stock_quantity',
            'saturday' => 'dpi_saturday_stock_quantity',
            'sunday' => 'dpi_sunday_stock_quantity'
        ];

        /**
         * Get pickup date.
         * 
         */

        $date = $_COOKIE['dpi_pickup_date'];

        if ($date) {

            $date = DateTime::createFromFormat('Y-m-d', $date);

            $day = strtolower($date->format('l'));
        }

        $product_quatity = (int) get_post_meta($product_id, $days[$day], true);
        $selected_quantity = (int) $_POST['quantity'];

        if ($selected_quantity > $product_quatity) {

            foreach (WC()->cart->get_cart() as $item => $values) {

                if ($values['product_id'] = $product_id) {

                    WC()->cart->set_quantity($cart_item_key, (int) ($values['quantity']) - (int) $_POST['quantity']);

                    wc_clear_notices();
                    wc_add_notice(__('You exceeded the product limit.'), 'error');

                    add_filter('wc_add_to_cart_message', '__return_false');
                }
            }
        }
    }
}

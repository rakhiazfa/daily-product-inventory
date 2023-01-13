<?php

namespace GreatWebsiteStudio;

use DateTime;

/**
 * Checkout Class
 * 
 * @author Great Website Studio
 */

class CheckoutOrder
{
    /**
     * Create a new CheckoutOrder instance.
     * 
     */
    public function __construct()
    {

        $this->registerCheckoutOrderScripts();
    }

    /**
     * Register checkout order scripts.
     * 
     * @return void
     */
    public function registerCheckoutOrderScripts()
    {
        add_action(
            'woocommerce_order_status_changed',
            array($this, 'orderStatusChanged'),
            10,
            3
        );
    }

    public function orderStatusChanged($order_id, $old_status, $new_status)
    {
        /**
         * Days
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
         * Check new status
         * 
         */

        if ($new_status == 'processing') {

            $order = wc_get_order($order_id);

            /**
             * Get pickup date.
             * 
             */

            $date = DateTime::createFromFormat('d/m/Y', get_post_meta($order_id, 'jckwds_date', true));

            $day = strtolower($date->format('l'));

            /**
             * Get order items.
             * 
             */

            $orderItems = $order->get_items();

            foreach ($orderItems as $item) {

                $productId = $item['product_id'];
                $itemQuantity = (int) $item->get_quantity();

                $oldQuantity = (int) get_post_meta($productId, $days[$day], true);

                update_post_meta($productId, $days[$day], $oldQuantity - $itemQuantity);
            }
        }
    }
}

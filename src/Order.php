<?php

namespace GreatWebsiteStudio;

use DateTime;

/**
 * Order Class
 * 
 * @author Great Website Studio
 */

class Order
{
    /**
     * Create a new Order instance.
     * 
     */
    public function __construct()
    {

        $this->registerOrderScripts();
    }

    /**
     * Register checkout order scripts.
     * 
     * @return void
     */
    public function registerOrderScripts()
    {
        add_action(
            'woocommerce_order_status_changed',
            array($this, 'orderStatusChanged'),
            10,
            3,
        );

        add_action(
            'woocommerce_thankyou',
            array($this, 'thankyou')
        );
    }

    /**
     * Handle order status changed.
     * 
     * @param mixed $order_id
     * @param mixed $old_status
     * @param mixed $new_status
     * 
     * @return void
     */
    public function orderStatusChanged($order_id, $old_status, $new_status)
    {
        add_post_meta($order_id, 'dpi_pickup_date', $_COOKIE['dpi_pickup_date'] ?? "");
        add_post_meta($order_id, 'dpi_pickup_time', $_COOKIE['dpi_pickup_time'] ?? "");

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
         * Check new status
         * 
         */

        if ($new_status == 'processing' || $new_status == 'on-hold') {

            $order = wc_get_order($order_id);

            /**
             * Get pickup date.
             * 
             */

            $date = get_post_meta($order_id, 'dpi_pickup_date', true) ?? false;
            $day = null;

            if ($date) {

                $date = DateTime::createFromFormat('Y-m-d', get_post_meta($order_id, 'dpi_pickup_date', true));

                $day = strtolower($date->format('l'));
            }

            /**
             * Get order items.
             * 
             */

            $orderItems = $order->get_items();

            foreach ($orderItems as $item) {

                $productId = $item['product_id'];
                $itemQuantity = (int) $item->get_quantity();

                $oldQuantity = (int) get_post_meta($productId, $days[$day], true);

                if (isset($days[$day])) {

                    update_post_meta($productId, $days[$day], $oldQuantity - $itemQuantity);
                }
            }
        }
    }

    /**
     * @return void
     */
    public function thankyou()
    {
        echo "<p>Pickup Date : " . $_COOKIE['dpi_pickup_date'] ?? "" . "</p>";
        echo "<br>";
        echo "<p>Pickup Time : " . $_COOKIE['dpi_pickup_time'] ?? "" . "</p>";
    }
}

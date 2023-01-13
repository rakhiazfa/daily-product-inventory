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
            'wp_footer',
            array($this, 'loadCheckoutAssets'),
        );

        add_action(
            'woocommerce_review_order_before_payment',
            array($this, 'reviewOrderBeforePayment'),
        );

        add_action(
            'woocommerce_checkout_process',
            array($this, 'checkoutProcess'),
        );

        add_action(
            'woocommerce_order_status_changed',
            array($this, 'orderStatusChanged'),
            10,
            3,
        );
    }

    /**
     * Load checkout assets.
     * 
     * @return void
     */
    public function loadCheckoutAssets()
    {
        wp_enqueue_script(
            'dpi_script',
            plugins_url('/assets/js/dpi-app.js', DPI_FILE),
        );
    }

    /**
     * Handle review order before payment.
     * 
     * @return void
     */
    public function reviewOrderBeforePayment()
    {
        woocommerce_form_field('dpi_pickup_date', [
            'label' => 'Pickup Date',
            'required' => true,
            'type' => 'date',
            'class' => 'dpi-pickup-date',
        ], date('Y-m-d'));
    }

    /**
     * Checkout process.
     * 
     * @return void
     */
    public function checkoutProcess()
    {
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
        add_post_meta($order_id, 'dpi_pickup_date', $_POST['dpi_pickup_date']);

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

        if ($new_status == 'processing' || $new_status == 'on-hold') {

            $order = wc_get_order($order_id);

            /**
             * Get pickup date.
             * 
             */

            $date = DateTime::createFromFormat('Y-m-d', get_post_meta($order_id, 'dpi_pickup_date', true));

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

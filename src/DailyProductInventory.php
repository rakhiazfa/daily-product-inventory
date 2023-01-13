<?php

namespace GreatWebsiteStudio;

/**
 * DailyProductInventory Class
 * 
 * @author Great Website Studio
 */

class DailyProductInventory
{
    /**
     * @var Admin
     */
    public Admin $admin;

    /**
     * @var CheckoutOrder
     */
    public CheckoutOrder $checkout;

    /**
     * Create a new DailyProductInventory instance.
     * 
     */
    public function __construct()
    {

        $this->admin = new Admin();

        $this->checkout = new CheckoutOrder();

        /**
         * Inherit default timezone.
         * 
         */

        date_default_timezone_set(wp_timezone_string());
    }

    /**
     * WooCommerce Schedule Stock Manager Activation Script
     * 
     * @return void
     */
    private static function activationScript()
    {

        $error = 'Required <b>WooCommerce</b> plugin activate.';

        if (!class_exists('WooCommerce')) {

            die($error);
        }
    }

    /**
     * Activate the plugin.
     * 
     * @return void
     */
    public static function activate()
    {

        self::activationScript();
    }

    /**
     * Deactivate the plugin.
     * 
     * @return void
     */
    public static function deactivate()
    {

        //  
    }
}

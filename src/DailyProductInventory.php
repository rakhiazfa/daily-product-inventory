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
     * Create a new DailyProductInventory instance.
     * 
     */
    public function __construct()
    {

        $this->admin = new Admin();
    }

    /**
     * WooCommerce Schedule Stock Manager Activation Script
     * 
     * @return void
     */
    private static function script_activation()
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

        self::script_activation();
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

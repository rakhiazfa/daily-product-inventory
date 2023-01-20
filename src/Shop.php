<?php

namespace GreatWebsiteStudio;

/**
 * Shop Class
 * 
 * @author Great Website Studio
 */

class Shop
{
    /**
     * Create a new Shop instance.
     * 
     */
    public function __construct()
    {

        $this->registerShopScripts();
    }

    /**
     * Register shop scripts.
     * 
     * @return void
     */
    public function registerShopScripts()
    {
        add_action(
            'woocommerce_before_shop_loop',
            array(
                $this, 'beforeShopLoop'
            )
        );

        add_action(
            'woocommerce_after_shop_loop_item',
            array($this, 'afterShopLoopItem')
        );

        add_action(
            'woocommerce_before_add_to_cart_form',
            array($this, 'beforeAddToCartForm')
        );

        add_action(
            'wp_footer',
            array($this, 'addCustomScripts')
        );
    }

    /**
     * Add custom scripts.
     * 
     * @return void
     */
    public function addCustomScripts()
    {
        wp_enqueue_style(
            'dpi_shop_style',
            plugins_url('/assets/css/dpi-shop-app.css', DPI_FILE),
        );

        wp_enqueue_script(
            'dpi_shop_script',
            plugins_url('/assets/js/dpi-shop-app.js', DPI_FILE),
        );
    }

    /**
     * Before shop loop.
     * 
     * @return void
     */
    public function beforeShopLoop()
    {
        woocommerce_form_field('dpi_pickup_date', array(
            'type' => 'date',
            'id' => 'dpi_pickup_date',
            'class' => 'dpi_pickup_date',
        ));

        woocommerce_form_field('dpi_pickup_time', array(
            'type' => 'select',
            'id' => 'dpi_pickup_time',
            'class' => 'dpi_pickup_time',
            'options'     => array(
                '10:00|11:00' => __('10:00 - 11:00'),
                '01:00:02:00' => __('01:00 - 02:00')
            ),
        ));
    }

    /**
     * After shop loop item.
     * 
     * @return void
     */
    public function afterShopLoopItem()
    {
        global $product;

        $manage_inventory = get_post_meta($product->id, 'dpi_manage_inventory', true);

        $monday = (int) get_post_meta($product->id, 'dpi_monday_stock_quantity', true);
        $tuesday = (int) get_post_meta($product->id, 'dpi_tuesday_stock_quantity', true);
        $wednesday = (int) get_post_meta($product->id, 'dpi_wednesday_stock_quantity', true);
        $thursday = (int) get_post_meta($product->id, 'dpi_thursday_stock_quantity', true);
        $friday = (int) get_post_meta($product->id, 'dpi_friday_stock_quantity', true);
        $saturday = (int) get_post_meta($product->id, 'dpi_saturday_stock_quantity', true);
        $sunday = (int) get_post_meta($product->id, 'dpi_sunday_stock_quantity', true);

        $days = [
            'monday' => $monday,
            'tuesday' => $tuesday,
            'wednesday' => $wednesday,
            'thursday' => $thursday,
            'friday' => $friday,
            'saturday' => $saturday,
            'sunday' => $sunday,
        ];

        $now = strtolower(date('l'));

        echo "
        <div
            id='dpi_daily_stock_quantity' 
            class='dpi_daily_stock_quantity' 
            data-product_id='$product->id' 
            data-manage-inventory='$manage_inventory' 
            data-monday='$monday' 
            data-tuesday='$tuesday' 
            data-wednesday='$wednesday' 
            data-thursday='$thursday' 
            data-friday='$friday' 
            data-saturday='$saturday' 
            data-sunday='$sunday' 
        >
            Stock $days[$now]
        </div>
        ";
    }

    /**
     * Before add to cart form.
     * 
     * @return void
     */
    public function beforeAddToCartForm()
    {
        global $product;

        $manage_inventory = get_post_meta($product->id, 'dpi_manage_inventory', true);

        $monday = (int) get_post_meta($product->id, 'dpi_monday_stock_quantity', true);
        $tuesday = (int) get_post_meta($product->id, 'dpi_tuesday_stock_quantity', true);
        $wednesday = (int) get_post_meta($product->id, 'dpi_wednesday_stock_quantity', true);
        $thursday = (int) get_post_meta($product->id, 'dpi_thursday_stock_quantity', true);
        $friday = (int) get_post_meta($product->id, 'dpi_friday_stock_quantity', true);
        $saturday = (int) get_post_meta($product->id, 'dpi_saturday_stock_quantity', true);
        $sunday = (int) get_post_meta($product->id, 'dpi_sunday_stock_quantity', true);

        $days = [
            'monday' => $monday,
            'tuesday' => $tuesday,
            'wednesday' => $wednesday,
            'thursday' => $thursday,
            'friday' => $friday,
            'saturday' => $saturday,
            'sunday' => $sunday,
        ];

        $now = strtolower(date('l'));

        echo "
        <div
            id='dpi_daily_stock_quantity' 
            class='dpi_daily_stock_quantity' 
            data-product_id='$product->id' 
            data-manage-inventory='$manage_inventory' 
            data-monday='$monday' 
            data-tuesday='$tuesday' 
            data-wednesday='$wednesday' 
            data-thursday='$thursday' 
            data-friday='$friday' 
            data-saturday='$saturday' 
            data-sunday='$sunday' 
        >
            Stock $days[$now]
        </div>
        ";
    }
}

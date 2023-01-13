<?php

namespace GreatWebsiteStudio;

/**
 * Admin Class
 * 
 * @author Great Website Studio
 */

class Admin
{
    /**
     * Create a new Admin instance.
     * 
     */
    public function __construct()
    {

        $this->registerAdminScripts();
    }

    /**
     * Register admin scripts.
     * 
     * @return void
     */
    public function registerAdminScripts()
    {
        add_action(
            'admin_enqueue_scripts',
            array($this, 'loadAdminAssets')
        );

        add_action(
            'woocommerce_product_options_stock_status',
            array($this, 'productOptions')
        );

        add_action(
            'woocommerce_process_product_meta',
            array($this, 'saveProductOptions')
        );
    }

    /**
     * Load admin assets.
     * 
     * @return void
     */
    public function loadAdminAssets()
    {
        wp_enqueue_style(
            'dpi_admin_style',
            plugins_url('/assets/css/dpi-admin-app.css', DPI_FILE),
        );

        wp_enqueue_script(
            'dpi_admin_script',
            plugins_url('/assets/js/dpi-admin-app.js', DPI_FILE),
        );
    }

    /**
     * Product options.
     * 
     * @return void
     */
    public function productOptions()
    {
        $dpi_manage_inventory = get_post_meta(get_the_ID(), 'dpi_manage_inventory', true);

        $display = "style='display: none'";

        if ($dpi_manage_inventory == 'yes') {

            $display = "style='display:block'";
        }

        woocommerce_wp_checkbox(array(
            'id'      => 'dpi_manage_inventory',
            'value'   => get_post_meta(get_the_ID(), 'dpi_manage_inventory', true),
            'label'   => 'Manage daily inventory.',
            'description' => 'Enable to manage daily inventory.',
        ));

        echo "<div class='dpi_additional_options' $display>";

        woocommerce_wp_text_input(array(
            'id'      => 'dpi_monday_stock_quantity',
            'value'   => get_post_meta(get_the_ID(), 'dpi_monday_stock_quantity', true),
            'label'   => 'Monday',
            'type'    => 'number',
            'class'   => 'dpi_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'dpi_tuesday_stock_quantity',
            'value'   => get_post_meta(get_the_ID(), 'dpi_tuesday_stock_quantity', true),
            'label'   => 'Tuesday',
            'type'    => 'number',
            'class'   => 'dpi_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'dpi_wednesday_stock_quantity',
            'value'   => get_post_meta(get_the_ID(), 'dpi_wednesday_stock_quantity', true),
            'label'   => 'Wednesday',
            'type'    => 'number',
            'class'   => 'dpi_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'dpi_thursday_stock_quantity',
            'value'   => get_post_meta(get_the_ID(), 'dpi_thursday_stock_quantity', true),
            'label'   => 'Thursday',
            'type'    => 'number',
            'class'   => 'dpi_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'dpi_friday_stock_quantity',
            'value'   => get_post_meta(get_the_ID(), 'dpi_friday_stock_quantity', true),
            'label'   => 'Friday',
            'type'    => 'number',
            'class'   => 'dpi_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'dpi_saturday_stock_quantity',
            'value'   => get_post_meta(get_the_ID(), 'dpi_saturday_stock_quantity', true),
            'label'   => 'Saturday',
            'type'    => 'number',
            'class'   => 'dpi_number_field',
        ));

        woocommerce_wp_text_input(array(
            'id'      => 'dpi_sunday_stock_quantity',
            'value'   => get_post_meta(get_the_ID(), 'dpi_sunday_stock_quantity', true),
            'label'   => 'Sunday',
            'type'    => 'number',
            'class'   => 'dpi_number_field',
        ));

        echo "</div>";
    }

    /**
     * Save product options.
     * 
     * @param mixed $post_id
     * 
     * @return void
     */
    public function saveProductOptions($post_id)
    {
        $manage_inventory = 'no';

        /**
         * Count of products per daily.
         * 
         */

        $monday_stock_quantity = 0;
        $tuesday_stock_quantity = 0;
        $wednesday_stock_quantity = 0;
        $thursday_stock_quantity = 0;
        $friday_stock_quantity = 0;
        $saturday_stock_quantity = 0;
        $sunday_stock_quantity = 0;

        if (isset($_POST['dpi_manage_inventory'])) {

            $manage_inventory = sanitize_text_field($_POST['dpi_manage_inventory']);

            $monday_stock_quantity = (int) sanitize_text_field($_POST['dpi_monday_stock_quantity']);
            $tuesday_stock_quantity = (int) sanitize_text_field($_POST['dpi_tuesday_stock_quantity']);
            $wednesday_stock_quantity = (int) sanitize_text_field($_POST['dpi_wednesday_stock_quantity']);
            $thursday_stock_quantity = (int) sanitize_text_field($_POST['dpi_thursday_stock_quantity']);
            $friday_stock_quantity = (int) sanitize_text_field($_POST['dpi_friday_stock_quantity']);
            $saturday_stock_quantity = (int) sanitize_text_field($_POST['dpi_saturday_stock_quantity']);
            $sunday_stock_quantity = (int) sanitize_text_field($_POST['dpi_sunday_stock_quantity']);
        }

        /**
         * Save post meta.
         * 
         */

        update_post_meta($post_id, 'dpi_manage_inventory', $manage_inventory);

        update_post_meta($post_id, 'dpi_monday_stock_quantity', $monday_stock_quantity);
        update_post_meta($post_id, 'dpi_tuesday_stock_quantity', $tuesday_stock_quantity);
        update_post_meta($post_id, 'dpi_wednesday_stock_quantity', $wednesday_stock_quantity);
        update_post_meta($post_id, 'dpi_thursday_stock_quantity', $thursday_stock_quantity);
        update_post_meta($post_id, 'dpi_friday_stock_quantity', $friday_stock_quantity);
        update_post_meta($post_id, 'dpi_saturday_stock_quantity', $saturday_stock_quantity);
        update_post_meta($post_id, 'dpi_sunday_stock_quantity', $sunday_stock_quantity);
    }
}

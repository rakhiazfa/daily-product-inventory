<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Uninstall not called from WordPress exit.
 * 
 */

defined('WP_UNINSTALL_PLUGIN') or die();


global $wpdb;

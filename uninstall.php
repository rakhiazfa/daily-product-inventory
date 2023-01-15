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

// Delete All Post Meta

$wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key LIKE 'dpi\_%'");

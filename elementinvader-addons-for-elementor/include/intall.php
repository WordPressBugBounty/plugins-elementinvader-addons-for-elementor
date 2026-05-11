<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php

global $wpdb;
$eli_db_version = '1.0.0';
$charset_collate = $wpdb->get_charset_collate();
/* first db install */
if ( get_site_option( 'eli_db_version' ) === false ||
     get_site_option( 'eli_db_version' ) < '1.0.0' ) {
        
    $eli_table_name = $wpdb->prefix . "eli_newsletters";
    $eli_sql = "CREATE TABLE IF NOT EXISTS `$eli_table_name` (
                `id` MEDIUMINT NOT NULL AUTO_INCREMENT ,
                `form_id` VARCHAR(64) NULL DEFAULT NULL ,
                `email` VARCHAR(64) NULL DEFAULT NULL ,
                `json_object` TEXT NULL DEFAULT NULL , 
                `date` datetime DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) $charset_collate COMMENT='ElementInvader Addons for Elementor';";
   if ( ! function_exists( 'dbDelta' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
}
    dbDelta($eli_sql);

    /* set next version */
    $eli_db_version = '1.0.4';
    update_option('eli_db_version', $eli_db_version);
}

/* version 1.1.0 db install */
if ( get_site_option( 'eli_db_version' ) < '1.1.0' ) {
    $eli_table_name = $wpdb->prefix . "eli_newsletters";
    $eli_cache_key = 'eli_newsletters_table_altered_v110';

    if ( false === wp_cache_get( $eli_cache_key, 'db' ) ) 
    {
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.SchemaChange,WordPress.DB.DirectDatabaseQuery.DirectQuery
        // Using dbDelta for schema changes is preferred in WordPress.
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $eli_sql_v110 = "CREATE TABLE {$eli_table_name} (
                id MEDIUMINT NOT NULL AUTO_INCREMENT,
                form_id VARCHAR(64) NULL DEFAULT NULL,
                email VARCHAR(64) NULL DEFAULT NULL,
                json_object TEXT NULL DEFAULT NULL,
                date datetime DEFAULT NULL,
                website VARCHAR(128) NULL DEFAULT NULL,
                PRIMARY KEY (id)
            ) {$charset_collate} COMMENT='ElementInvader Addons for Elementor';";
        dbDelta($eli_sql_v110);

        wp_cache_set( $eli_cache_key, true, 'db' );
    }
    
    /* set next version */
    $eli_db_version = '1.1.0';
    /* udpate option with db version */
    update_option('eli_db_version', $eli_db_version);
}

<?php

/**
 * Plugin Name:         WA Widget Icon - OSWP
 * Description:         Add whatsapp icon / button to your site without writing code thanks to the WA Widget Icon OSWP plugin. Upload an icon of your choice. Select the icon. Enter phone number. Position your icon.
 * Version:             1.0.0
 * Requires PHP:        7.4.1
 * Tested up to:        7.4.1
 * Author:              Osman Onat
 * Author URI:          https://github.com/OsmanOnat
 * Text Domain:         oswp_wp
 * Tags:                custom-icon, wp-icon, theme-options, wp-widget, widget-customize, theme-customize, add-icon, add-widget
 */


defined( 'ABSPATH' ) or die('No Script');

final class OSWP_Whatsapp
{
    /**
     * @var array $option_arr   wp_option Keys
     */
    private $option_arr = [
        "whatsapp_phone_number", 
        "plugin_whatsapp_icon",
        "bottom_icon_location", "right_icon_location",
    ];

    public function __construct()
    {
    }

    public function init()
    {
        $this->createConstant()->createOptions()
                ->loadTextDomain()
                    ->setup( "inc/loader.php" );
    }

    /**
     * @param string ...$arg    Return Require File Url 
     */
    private function setup( string ...$arg )
    {            
        $temp_file = [];

        foreach( $arg as $v )
        {
            if( file_exists( WHATSAPP_PLUGIN_PATH . $v ) )
            {
                array_push( $temp_file, WHATSAPP_PLUGIN_PATH . $v );
            }
            else
            {
                wp_die( "( OSWP-WHATSAPP-PLUGIN-ERROR - [Setup Function] ) There Is No File - " . $v );
            }
        }

        if( count( $temp_file ) <= 0 )
        {
            wp_die( "NOT A TEMP FILE!" );
        }
        else
        {
            foreach( $temp_file as $v )
            {
                require $v;
            }
        }

        return $this;
    }

    /**
     * Create Custom Defines
     */
    private function createConstant()
    {
        defined( "WHATSAPP_PLUGIN_PREFIX") || define( "WHATSAPP_PLUGIN_PREFIX", "oswp_" );
        defined( "WHATSAPP_PLUGIN_PATH" ) || define( "WHATSAPP_PLUGIN_PATH", plugin_dir_path( __FILE__ ) );
        defined( "WHATSAPP_PLUGIN_TEXT_DOMAIN" ) || define( "WHATSAPP_PLUGIN_TEXT_DOMAIN", "oswp_wp" );
        defined( "WHATSAPP_PLUGIN_IMAGE_PATH" ) || define( "WHATSAPP_PLUGIN_IMAGE_PATH", plugin_dir_path( __FILE__ ) . "inc/admin/images/" );
        defined( "WHATSAPP_PLUGINS_URL_IMAGE" ) || define( "WHATSAPP_PLUGINS_URL_IMAGE", plugins_url( '/wa-widget-icon-oswp/inc/admin/images/' ) );
        defined( "WHATSAPP_PLUGINS_URL_INC" ) || define( "WHATSAPP_PLUGINS_URL_INC", plugins_url( '/wa-widget-icon-oswp/inc/' ) );
        
        // ...app\public\wp-content\plugins\wa-widget-icon-oswp/inc/admin/images/
        defined( "WHATSAPP_PLUGINS_ADMIN_IMAGE_UPLOAD" ) || define( "WHATSAPP_PLUGINS_ADMIN_IMAGE_UPLOAD", WHATSAPP_PLUGIN_PATH . 'inc/admin/images/' );

        return $this;
    }

    private function createOptions()
    {
        foreach( $this->option_arr as $k => $v )
        {
            if( !get_option( $v ) )
            {
                add_option( $v, "" );
            }
        }
        
        return $this;
    }

    private function loadTextDomain()
    {
        load_plugin_textdomain( "oswp_wp", false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
        
        return $this;
    }

    public function deactive()
    {
        foreach( $this->option_arr as $k => $v )
        {
            delete_option( $v );
        }
    }
    
}

if( class_exists( "OSWP_Whatsapp" ) )
{
    /**
     * @var object $oswp_whatsapp   OSWP_Whatsapp Class Instance
     */
    $oswp_whatsapp = new OSWP_Whatsapp();
    
    // Execute Init Function
    add_action( "init", [ $oswp_whatsapp , "init" ] );

    // Deactive Plugin
    register_deactivation_hook( __FILE__ , [ $oswp_whatsapp , "deactive" ] );
}
?>

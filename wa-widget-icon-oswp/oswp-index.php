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
        "bottom_icon_location", "right_icon_location"
    ];

    private $role_status = false;

    public function __construct()
    {
    }

    public function init()
    {
        $this->createConstant()->createOptions()
                ->setup( "plugin/admin.php", "plugin/client.php" );
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

    private function roleControl( array $allow_role = ["administrator"] )
    {
        global $wp_roles;

        /**
         * @var array $get_user_role_arr  Hold Current User Roles
         */
        $get_user_role_arr = [];

        /**
         * @var array get_current_role   Get Current User Roles
         */
        $get_current_role = wp_get_current_user()->roles;

        foreach( $get_current_role as $k => $v )
        {
            array_push( $get_user_role_arr , mb_strtolower( $v ) );
        }

        if(
           !array_intersect( $allow_role , $get_user_role_arr )
        ){
            $this->role_status = false;
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
        defined( "WHATSAPP_PLUGIN_IMAGE_PATH" ) || define( "WHATSAPP_PLUGIN_IMAGE_PATH", plugin_dir_path( __FILE__ ) . "plugin/images/" );
        defined( "WHATSAPP_PLUGINS_URL_IMAGE" ) || define( "WHATSAPP_PLUGINS_URL_IMAGE", plugins_url( '/whatsapp-icon/plugin/images/' ) );

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

    public function loadTextDomain()
    {
        load_plugin_textdomain( "oswp_wp", false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
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
    $oswp_whatsapp = new OSWP_Whatsapp();

    add_action( "plugins_loaded", [ $oswp_whatsapp , "init" ] );

    // For too early do init hook
    add_action( "init", [ $oswp_whatsapp , "loadTextDomain" ] );

    // Deactive Plugin
    register_deactivation_hook( __FILE__ , [ $oswp_whatsapp , "deactive" ] );
}
?>
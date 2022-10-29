<?php

/**
 * @param array $allow_role     Allow WordPress Roles
 * @param string $require_file  File To Include For Role
 */
function roleControl( array $allow_role = ["administrator"] , string ...$require_file )
{
    /**
     * @var object $wp_roles    Get Site Roles
     */
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
        array_intersect( $allow_role , $get_user_role_arr )
    ){
        foreach( $require_file as $r )
        {
            require $r;
        }
    }
}

/**
 * @param {string}  $message          Message Box Text
 * @param {string}  $html_class_type  Write Message Box Type 
 * @param {boolean} $is_dismissible   Get Close Icon
 * 
 * @return void
 */
function echoMessage( string $message, string $html_class_type, bool $is_dismissible = true ): void
{
    $class_types = [ "success", "warning", "info", "error" ];

    foreach( $class_types as $v)
    {
        if( $v == mb_strtolower( trim( $html_class_type ) ) )
        {
            if( $is_dismissible == true )
            {
                $message_box  = '<div class="notice notice-'.esc_html( $v ).' is-dismissible">';
                $message_box .= '<p>'.__( esc_html( $message ) , "oswp_wp" ).'</p>';
                $message_box .= '</div>';

                echo $message_box;
                break;
            }
            else
            {
                $message_box  = '<div class="notice notice-'.esc_html( $v ).'">';
                $message_box .= '<p>'.__( esc_html( $message ) , "oswp_wp" ).'</p>';
                $message_box .= '</div>';

                echo $message_box;
                break;
            }
        }
    } 
}


?>
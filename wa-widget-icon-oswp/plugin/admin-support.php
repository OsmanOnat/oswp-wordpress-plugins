<?php

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
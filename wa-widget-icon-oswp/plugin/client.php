<?php
/**
 * Whatsapp Icon FrontEnd
 * with get_footer hook Add Code Before Footer Tag
 */
function viewWhatsappIcon(){

    if( get_option( 'plugin_whatsapp_icon' ) ): ?>
        
        <style>
        .whatsapp_icon_plugin{
            position: fixed;
            bottom: <?= get_option( "bottom_icon_location" ) != "" ? get_option( "bottom_icon_location" ) . "px" : "20px" ?>;
            right: <?= get_option( "right_icon_location" ) != "" ? get_option( "right_icon_location" ) . "px" : "20px" ?>;
            z-index: 999;
            width: 50px;
            height: 50px;
        }

        .whatsapp_icon_plugin , .oswp-whatsapp-client{
            width: 50px;
            height: 50px;
        }

        @media only screen and (max-width: 1200px) {
            .oswp-whatsapp-client{
                max-width: 90%;
            }
        }
        </style>

        <!---- Create WA Widget Icon - OSWP | <?= date("Y-m-d h:i:sa"); ?> ---->

        <a class="whatsapp_icon_plugin" href="<?= get_option( 'whatsapp_phone_number' ) ? "https://wa.me/" . get_option( 'whatsapp_phone_number' ) : "" ?>">
            <img 
                class="oswp-whatsapp-client" src="<?= esc_html( WHATSAPP_PLUGINS_URL_IMAGE . get_option( 'plugin_whatsapp_icon' ) ) ?>" 
                alt="<?= esc_html( explode( "." , get_option( 'plugin_whatsapp_icon' ) )[0] ) ?>"
            />
        </a>

<?php endif;     
} // FUNCTION END


if( 
    function_exists( "viewWhatsappIcon" ) && 
    is_callable( "viewWhatsappIcon" ) 
){
    add_action( 'get_footer' , 'viewWhatsappIcon');
}
?>
<?php
/**
 * Require Custom Admin Css
 */
function addCustomCss()
{ ?>

<!-- OSWP-ADMIN-CUSTOM-CSS-START -->
<style>
    <?= require WHATSAPP_PLUGIN_PATH . "plugin/css/custom-admin.css"; ?>
</style>
<!-- OSWP-ADMIN-CUSTOM-CSS-END -->

<?php } // addCustomCss End

/**
 * Require Custom Admin Js
 */
function addCustomJs()
{ ?>

<!-- OSWP-ADMIN-CUSTOM-JS-START -->
<script src="<?= plugins_url('whatsapp-icon/plugin/js/admin.js') ?>"></script>
<!-- OSWP-ADMIN-CUSTOM-JS-END -->

<?php } // addCustomJs End


function oswp_whatsapp_menu(){

    add_options_page(
        "WA Widget Icon - OSWP",
        '<span class="dashicons dashicons-whatsapp" style="margin-left:-3px;"></span>&nbsp;WA Widget Icon',   
        "manage_options",
        "oswpwhatsapp",
        "oswp_whatsapp_cb",
    );
    
}

function oswp_whatsapp_cb(){
    
    /**
     * @var string $plugin_url  Return Site And Request
     */
    $plugin_url = site_url() . $_SERVER['REQUEST_URI']; 

    /**
     * @var array $file_type    File Type (There Is Not Dot)
     */
    $file_type = [
        0 => 'jpg',
        1 => 'jpeg',
        2 => 'png',
        3 => 'PNG',
        4 => 'svg',
    ];
    
    /**
     * FILE UPLOAD
     */
    if( isset( $_POST[ "file_submit" ] ) )
    {
        
        /**
         * @var int $upload_size    For File Size
         */
        $upload_size = 50 * 10000; //1kb ->  1 * 10000byte, 500.000kb -> 5mb 

        /**
         * @var array $temp_file_check  For File Check Listener
         */
        $temp_file_check = [
            "type_check" => false,
        ];

        $file_name_ex = explode( ".", $_FILES["icon"]["name"] );
        foreach( $file_type as $k => $v )
        {
            if( $v == end( $file_name_ex ) )
            {
                $temp_file_check[ "type_check" ] = true;
                break;
            }
        }

        if($_FILES["icon"]["size"] > $upload_size)
        {
            echoMessage( "File Size Excess! Upload Small Files!", "warning" );
        }
        else
        {
            if( $temp_file_check[ "type_check" ] == true )
            {
                move_uploaded_file(
                    $_FILES["icon"]["tmp_name"], 
                    WHATSAPP_PLUGIN_PATH . 'plugin/images/'.$_FILES["icon"]['name']
                );
                
                echoMessage( "File Uploaded", "success" );
            }
            else
            {
                echoMessage( "File Type Doesn't Match! Be ( .jpg , .jpeg , .svg , .png , .PNG )", "error" );
            }
        }
    }

    /**
     * ICON && FILE REMOVE
     */
    if( isset( $_POST[ WHATSAPP_PLUGIN_PREFIX . "icon_remove" ] ) )
    {
        if( empty( isset( $_POST[ WHATSAPP_PLUGIN_PREFIX . "icon_name" ] ) ) )
        {
            echoMessage( "Remove File Not Working. Because There Is Not File!", "error" );
        }
        else if( file_exists( WHATSAPP_PLUGIN_IMAGE_PATH . $_POST[ WHATSAPP_PLUGIN_PREFIX . "icon_name" ] ) )
        {
            unlink( WHATSAPP_PLUGIN_IMAGE_PATH . $_POST[ WHATSAPP_PLUGIN_PREFIX . "icon_name" ] );
            echoMessage( "File Removed (". $_POST[ WHATSAPP_PLUGIN_PREFIX . "icon_name" ] . ")", "success" );
        }
        else
        {
            echoMessage( "Oppss! There Is Not File! (". WHATSAPP_PLUGIN_IMAGE_PATH . $_POST[ WHATSAPP_PLUGIN_PREFIX . "icon_name" ] . ")", "error" );
        }
    }

/**
 * PHONE NUMBER SAVE
 */
if(isset($_POST[ WHATSAPP_PLUGIN_PREFIX . 'phone_number_input' ])){
    
    $phone_number = trim( $_POST[ WHATSAPP_PLUGIN_PREFIX . 'phone_number' ] );

    if( !is_numeric( $phone_number ) )
    {
         
        echoMessage( "Only Numeric", "error" );

    }
    elseif( is_numeric( $phone_number ) )
    {

        if( !get_option( 'whatsapp_phone_number' ) )
        {
            add_option( 'whatsapp_phone_number' , '');
            update_option( 'whatsapp_phone_number' , $phone_number );

            echoMessage( "Phone Number Change", "success" );
        }
        else
        {
            update_option( 'whatsapp_phone_number' , $phone_number );

            echoMessage( "Telefon Numarası Güncellendi!", "success" );
        }

    }
    else
    {
        echoMessage( "Bir Hata Oluştu! (phone_number)", "error" );
    }
}

/**
 * PHONE NUMBER DELETE
 */
if( isset( $_POST[ WHATSAPP_PLUGIN_PREFIX . 'phone_number_delete' ]) )
{

    if( !get_option( 'whatsapp_phone_number' ) )
    {
        add_option( 'whatsapp_phone_number' , '');
        update_option( 'whatsapp_phone_number' , '' );

        echoMessage( "Remove Phone Number!", "warning" );
    }
    else
    {
        update_option( 'whatsapp_phone_number' , '' );
        echoMessage( "Remove Phone Number!", "warning" );
    }

}
?>

<?php
    /**
     * For Get Image File URL
     */
    define('IMAGE_FILE_URL' , __DIR__.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR);

    /**
     * @var array $file_list  For Get Image Files
     */
    $file_list = glob(IMAGE_FILE_URL.'*'); 

    /**
     * @var array $get_file_name    Get Image File Url Explode only Get Name
     */
    $get_file_name = array();

    foreach( $file_list as $file_list_name )
    {
        /**
         * @var array $temp_reverse_slash_arr  Temp Reverse Slash Exploade Array
         */
        $temp_reverse_slash_arr = [];

        $explode_reverse_slash = explode( DIRECTORY_SEPARATOR , $file_list_name );

        array_push( $temp_reverse_slash_arr , end( $explode_reverse_slash ) );

        foreach( $file_type as $type_check )
        {
            foreach( $temp_reverse_slash_arr as $temp_file_type_check )
            {
                if( empty( strstr( $temp_file_type_check , $type_check ) ) )
                {
                    continue;
                }
                else
                {
                    array_push( $get_file_name , $temp_file_type_check );
                }
            }
        }
    }

    
   
    /**
     * GET RADION BUTTON SELECTED IMAGE VARIABLE
     */
    if( isset( $_POST[ WHATSAPP_PLUGIN_PREFIX . "icon_change" ] ) )
    {
        $icon_name = $_POST[ WHATSAPP_PLUGIN_PREFIX . 'icon_name'];

        if( isset( $icon_name ) )
        {
            if( file_exists( IMAGE_FILE_URL . $icon_name ) )
            {
                update_option( 'plugin_whatsapp_icon' , $icon_name);
                echoMessage( "Whatsapp Icon Update!" , "success" );
            }
            else
            {
                echoMessage( "Whatsapp Icon Update Error!" , "error" );
            }
        }
    }

    /**
     * Icon Location Change
     */
    if( isset( $_POST[ "oswp_icon_location_submit" ] ) )
    {
        if( 
            empty( $_POST[ "bottom_icon_location" ] ) && 
            empty( $_POST[ "right_icon_location" ] )
        ){
            echoMessage( "Entering a null value!", "error" );
        }
        else
        {
            if( isset( $_POST[ "bottom_icon_location" ] ) && is_numeric( $_POST[ "bottom_icon_location" ] ) )
            {
                update_option( "bottom_icon_location", $_POST[ "bottom_icon_location" ] );
            }

            if( isset( $_POST[ "right_icon_location" ] ) && is_numeric( $_POST[ "right_icon_location" ] ) )
            {
                update_option( "right_icon_location", $_POST[ "right_icon_location" ] );
            }
            
            echoMessage( "Icon value(s) changed!", "success" );
        }
    }

    /**
     * Icon Location Remove
     */
    if( isset( $_POST[ "oswp_icon_location_remove_submit" ] ) )
    {
        if( isset( $_POST[ "bottom_icon_location" ] ) )
        {
            update_option( "bottom_icon_location", "" );
        }

        if( isset( $_POST[ "right_icon_location" ] ) )
        {
            update_option( "right_icon_location", "" );
        }

        echoMessage( "Icon position values ​​have been deleted and changed to default!", "warning" );
    }

    
    ?>

    <table class="form-table" id="form-table">
    <tbody>

        <tr>
            <th scope="row">
                <?= __( "Select File", wp_get_theme()->get( "TextDomain" ) ) ?>
            </th>
            <td>
                <form action="<?= $plugin_url ?>" method="post" enctype="multipart/form-data" id="<?= WHATSAPP_PLUGIN_PREFIX ?>file_upload_form_class">
                    <div class="flex">
                        <div class="oswp-file-border">
                            <input type="file" name="icon" class="upload_file_icon"> 
                        </div>
                        <input 
                            type="submit" class="button button-primary" style="margin-left:7px;"
                            value="<?= __( "Send File", "oswp_wp" )?>" name="file_submit"
                        />
                        <span class="spinner is-active spinner-file-upload"></span>
                    </div>
                </form>
            </td>
        </tr>

        <tr>
            <th scope="row"> <?= __( "Add Phone Number", wp_get_theme()->get( "TextDomain" ) ) ?> </th>
            <td>
                <form action="<?= $plugin_url ?>" method="post" id="<?= WHATSAPP_PLUGIN_PREFIX ?>phone_number_form">
                    <input 
                        type="text" class="regular-text"
                        name="<?= WHATSAPP_PLUGIN_PREFIX ?>phone_number" 
                        placeholder="<?= __( 'Phone Number' , "oswp_wp" );?>"
                        value="<?= get_option( 'whatsapp_phone_number' ) ? get_option( 'whatsapp_phone_number' ) : "" ?>"
                    /> 

                    <input 
                        type="submit" class="button button-primary phone_button_save" 
                        value="<?= __( "Save", "oswp_wp" )?>" name="<?= WHATSAPP_PLUGIN_PREFIX?>phone_number_input"
                        id="phone_button_save"
                    />
                    
                    <input 
                        type="submit" class="button button-primary phone_button_remove" 
                        style="background: #d63638;border-color: #d63638;" value="<?= __( "Delete", "oswp_wp" )?>" 
                        name="<?= WHATSAPP_PLUGIN_PREFIX?>phone_number_delete"
                        id="phone_button_remove"
                    />
                </form>
            </td>
        </tr>

        <tr>
            <th scope="row">Image</th>
            <td>
                <fieldset class="metabox-prefs">
                    <form action="<?= $plugin_url ?>" method="post" id="<?= WHATSAPP_PLUGIN_PREFIX ?>icon_change_form">
                        <?php 
                        if( empty( $get_file_name ) ) echo __( "Please Upload File" , WHATSAPP_PLUGIN_TEXT_DOMAIN );
                        foreach( $get_file_name as $i => $v ): 
                        ?>
                            <label for="<?= $i ?>"> 
                            <?= $i; ?> 
                            <input 
                                type="radio" name="<?= WHATSAPP_PLUGIN_PREFIX ?>icon_name" id="<?= $i ?>" value="<?= $v ?>"
                                <?php
                                    if(get_option( 'plugin_whatsapp_icon' ) == $v){
                                        echo esc_html( "checked" );
                                    }
                                ?>
                                />
                                <img 
                                    src="<?= esc_html( WHATSAPP_PLUGINS_URL_IMAGE . $v )?>" 
                                    alt="<?= esc_html( explode( ".", $v )[0] )?>" 
                                    style="width:20px;"
                                />
                            
                                <p>
                                    <?= 
                                        __( $v , "oswp_wp"); 
                                        //__( substr( $v , 0 , 5 ) , "oswp_wp"); 
                                    ?>
                                </p>
                            </label>            
                        <?php endforeach; ?>
                        <span class="image_select_listener_message"></span>
                            <div class="flex" style="display:flex;">
                                    <?= 
                                        submit_button( 
                                            __( 'Change' , "oswp_wp" ),
                                            'primary',
                                            WHATSAPP_PLUGIN_PREFIX . 'icon_change'
                                        );

                                        submit_button( 
                                            __( 'Remove' , "oswp_wp" ),
                                            'primary',
                                            WHATSAPP_PLUGIN_PREFIX . 'icon_remove',
                                            true,
                                            'style="background: #d63638;border-color: #d63638;margin-left:4px;"',
                                        );
                                    ?>
                                    <span class="spinner is-active spinner-icon-change" style="margin-right:500px"></span>
                            </div>
                    </form>
                </fieldset>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <?= __( "Icon Location", wp_get_theme()->get( "TextDomain" ) ) ?>
            </th>
            <form action="<?= $plugin_url ?>" method="post">
                <td>

                    <div class="flex">
                        <input 
                            type="number" name="bottom_icon_location" 
                            placeholder="Bottom = <?= get_option( "bottom_icon_location" ) != "" ? get_option( "bottom_icon_location" ) : "20" ?>px"
                        />
                        &nbsp;&nbsp;
                        <input 
                            type="number" name="right_icon_location" 
                            placeholder="Right = <?= get_option( "right_icon_location" ) != "" ? get_option( "right_icon_location" ) : "20" ?>px"
                        />

                        <input 
                            type="submit" class="button button-primary" style="margin-left:7px;"
                            value="Change Location" name="<?= WHATSAPP_PLUGIN_PREFIX ?>icon_location_submit"
                        />
                        <input 
                            type="submit" class="button button-primary"
                            style="background: #d63638;border-color: #d63638;margin-left:4px;"
                            value="Remove Location" name="<?= WHATSAPP_PLUGIN_PREFIX ?>icon_location_remove_submit"
                        />
                        <span class="spinner is-active icon_localtion_spinner"></span>
                    </div>

                </td>
            </form>
        </tr>

        <!-- Plugin Usage Field Start -->
        <?php require "html/admin_plugin_usage_description.php"?>
        <!-- Plugin Usage Field End -->


    </tbody>
</table>
<?php } //callback and

add_action( "admin_head" , "addCustomCss" );
add_action( "admin_footer" , "addCustomJs" );
add_action( "admin_menu" , "oswp_whatsapp_menu" );

/**
 * Check Target Hook Function.
 * 
 * Usage:
 *  [ "<hook-name>" , "<hook-callback>" ],
 * 
 * @var array $function_name  Check Function And Execute Hook, Hook Callback
 */
/*$function_name = [ 
    [ "admin_head" , "addCustomCss" ],
    [ "admin_menu" , "oswp_whatsapp_menu" ],
    [ "admin_footer" , "addCustomJs" ],
];

foreach( $function_name as $f )
{
    if( function_exists( $f[ 1 ] ) && is_callable( $f[ 1 ] ) )
    {
        add_action( $f[ 0 ], $f[ 1 ]);
    }
}*/


?>

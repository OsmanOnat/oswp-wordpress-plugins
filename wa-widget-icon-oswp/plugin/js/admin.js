/**
 * @var {string} WHATSAPP_PLUGIN_PREFIX     Global Plugin Custom Prefix
 */
const WHATSAPP_PLUGIN_PREFIX = "oswp_";

const returnMessage = ( type_arr = "success" , message = "Success Message") => {
    var box_type = [ "success", "warning", "error", "info" ];

    box_type.forEach( (element , index) => {
        if( element == type_arr )
        {
            var message_box  = '<div class="notice notice-'+ String( element ) +' is-dismissible">';
            message_box += '<p>'+ String( message ) +'</p>';
            message_box += '</div>';

            return message_box;
        }
    });
    
};

returnMessage("error", "fafsadsad");

/**
 * @var {object} check_spinner    Only Use Spinner Name And Submit Form Id
 * 
 * key   -> index    => Be Only Class Name. Use querySelector() --> Spinner Name 
 * value -> element  => Be Only ID Tag. Use getElementById()    --> Submit Form Id
 * 
 * Usage:
 * [ "<spinner-class-name>" , "<submit-form-id>" ]
 */
const check_spinner = new Map(
    [
        [ ".spinner-file-upload" , "oswp_file_upload_form_class" ],
        [ ".spinner-icon-change" , "oswp_icon_change_form" ],
    ]
);

check_spinner.forEach( (element , index) => {
    var spinner_name = document.querySelector( index );
    var spinner_form_name = document.getElementById( element );
    
    spinner_form_name.addEventListener( "submit", () => {
        spinner_name.style.display = "block";
    });
});

/*const ImageCheckedAttr = document.getElementsByName( String( WHATSAPP_PLUGIN_PREFIX + "icon_name" ) );

const ImageSelectListener = document.getElementsByClassName( "image_select_listener_message" );

const ImageChangeRemoveButton = document.getElementById( WHATSAPP_PLUGIN_PREFIX + "icon_remove" );

const ImageChangeSubmitButton = document.getElementById( WHATSAPP_PLUGIN_PREFIX + "icon_change" );

if( ImageCheckedAttr.length >= 0 )
{
    ImageCheckedAttr.forEach( ( index , key ) => {
        if( index.checked == false )
        {
            ImageChangeRemoveButton.disabled = true;
            ImageSelectListener[ 0 ].style.display = "block";
            ImageSelectListener[ 0 ].style.color = "red";
            ImageSelectListener[ 0 ].style.fontSize = "18px";
            ImageSelectListener[ 0 ].textContent = "Please Select Icon!";

            console.log( "Checked yok" );
        }
    });
}*/

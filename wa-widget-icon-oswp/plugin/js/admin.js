/**
 * @var {string} WHATSAPP_PLUGIN_PREFIX     Global Plugin Custom Prefix
 */
const WHATSAPP_PLUGIN_PREFIX = "oswp_";

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

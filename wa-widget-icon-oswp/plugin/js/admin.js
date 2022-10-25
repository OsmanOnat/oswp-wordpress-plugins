/**
 * @var {string} WHATSAPP_PLUGIN_PREFIX     Global Plugin Custom Prefix
 */
const WHATSAPP_PLUGIN_PREFIX = "oswp_";

/**
 * key   -> index    => Be Only Class Name. Use querySelector() --> Spinner Name 
 * value -> element  => Be Only ID Tag. Use getElementById()    --> Submit Form Id
 * 
 * Usage:
 * [ "<spinner-class-name>" , "<submit-form-id>" ]
 * 
 * @var {object} check_spinner    Only Use Spinner Name And Submit Form Id
 */
const check_spinner = new Map(
    [
        [ ".spinner-file-upload" , "oswp_file_upload_form_class" ],
        [ ".spinner-icon-change" , "oswp_icon_change_form" ],
    ]
);

check_spinner.forEach( (element , index) => {
    /**
     * @var {object} spinner_name   Spinner Class Name
     */
    var spinner_name = document.querySelector( index );

    /**
     * @var {object} spinner_form_name  Spinner Form Element ID
     */
    var spinner_form_name = document.getElementById( element );
    
    spinner_form_name.addEventListener( "submit", () => {
        spinner_name.style.display = "block";
    });
});
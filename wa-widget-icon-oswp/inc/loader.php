<?php
/**
 * Require Support Class
 */
require "support.php";

/**
 * Require Client
 */
require "frontend.php";

/**
 * Check Role Control For Admin
 */
roleControl( ["administrator"] , ( WHATSAPP_PLUGINS_ADMIN_URL . "admin.php" ) );



?>
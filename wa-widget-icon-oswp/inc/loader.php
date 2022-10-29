<?php
/**
 * Require Support Class
 */
require "support.php";

/**
 * Require Client
 */
require "client.php";

/**
 * Check Role Control For Admin
 */
roleControl( ["administrator"] , "admin/admin.php" );



?>
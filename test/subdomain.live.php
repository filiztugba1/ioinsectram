<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "/usr/local/cpanel/php/cpanel.php";

$cpanel = new CPANEL(); // Connect to cPanel - only do this once.
  
exit;
// Create a subdomain.
$addsubdomain = $cpanel->api2(
    'SubDomain', 'addsubdomain',
        array(
        'domain'                => 'subdomaintest',
        'rootdomain'            => 'insectram.io',
        'dir'                   => '/public_html',
        'disallowdot'           => '1',
    )
);


?>
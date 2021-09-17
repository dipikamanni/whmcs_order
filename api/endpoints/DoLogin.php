<?php
/**
 * AutoAuth Api 
 * 
 * PHP version 7
 *
 * @category Api
 * @package  WHMCS
 * @author   Kuroit <hello@kuroit.com>
 * @license  https://portal.hostworld.uk/ License
 * @link     https://portal.hostworld.uk/
 */

if (!defined('ORDER_API_CALL')) {
    printError(['status' =>'error','data' => 'Invalid Operation.']); 
} 

// Define WHMCS URL & AutoAuth Key
$whmcsurl = "https://portal.hostworld.uk/dologin.php";
$autoauthkey = "kuroit1995HW";
 
$timestamp = time(); // Get current timestamp
$email = 'dipika@kuroit.in'; // Clients Email Address to Login
$goto = 'clientarea.php?action=products';
 
$hash = sha1($email . $timestamp . $autoauthkey); // Generate Hash
 
// Generate AutoAuth URL & Redirect
$url = $whmcsurl . "?email=$email&timestamp=$timestamp&hash=$hash&goto=" . urlencode($goto);
header("Location: $url");
exit;
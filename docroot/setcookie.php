<?php
/* Set Cookie Program
 * © 2022 YRGLM Inc.
 * @author YRGLM Inc.
 * @version 1.0.0
 **/

$allowedCookies = array('_ebtd', '_ebcv', 'tracking_reject');
$allowedOriginForTest = 'https://bishamon.ebis.ne.jp';
$maxAge = 63072000;

validateParameters($allowedCookies);

$domain = '.' . $_GET['domain'];
$name = $_GET['name'];

if (isset($_GET['value'])) {
    $value = $_GET['value'];
} elseif (isset($_COOKIE[$name])) {
    $value = $_COOKIE[$name];
} else {
    exitWithMessage('Cookie not found');
}

if (isset($_GET['test']) && isset($_GET['value'])) {
    $name .= '_test';
    header("Access-Control-Allow-Origin: {$allowedOriginForTest}");
    header('Access-Control-Expose-Headers: X-Ebis-Set-Cookie-Test');
    header("X-Ebis-Set-Cookie-Test: {$name}={$value}; Domain={$domain}; Max-Age={$maxAge}; Path=/;");
}

header("Set-Cookie: {$name}={$value}; Domain={$domain}; Max-Age={$maxAge}; Path=/;");

function validateParameters($allowedCookies)
{
    if (!isset($_GET['domain']) || !$_GET['domain'] || containsInvalidChars($_GET['domain'])) {
        exitWithMessage('Missing or invalid domain parameter');
    }
    if (!isset($_GET['name']) || !in_array($_GET['name'], $allowedCookies)) {
        exitWithMessage('Missing or invalid name parameter');
    }
    if (isset($_GET['value']) && containsInvalidChars($_GET['value'])) {
        exitWithMessage('Invalid value parameter');
    }
}

function containsInvalidChars($str)
{
    return preg_match('/[\n\r;]/', $str) === 1;
}

function exitWithMessage($message)
{
    header('X-Ebis-Set-Cookie-Message: ' . $message, false, 400);
    exit;
}

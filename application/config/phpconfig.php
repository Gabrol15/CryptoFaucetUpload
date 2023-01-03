<?php
// base url
$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$base_url .= "://".$_SERVER['HTTP_HOST'];
$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
$baseUrl = $base_url;
// database credential
$hostname = 'localhost';
$database = 'CryptoCoins';
$username = 'CryptoCoins';
$password = 'CryptoCoins';
// random string
$encryptionKey = 'CgdtIiGBaOdPG7ChK5An0ht80pT9QO';
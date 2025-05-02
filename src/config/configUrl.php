<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$basePath = '/Web_Advanced'; // hoặc tự động detect nếu cần

define('BASE_URL', $protocol . $host . $basePath);
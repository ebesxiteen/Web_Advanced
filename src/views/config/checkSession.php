<?php
session_start();
$response = [];

if (isset($_SESSION['userId'])) {
    $response['isLoggedIn'] = true;
    $response['userId'] = $_SESSION['userId'];

    if (isset($_SESSION['user']['username'])) {
        $response['username'] = $_SESSION['user']['username'];
    } elseif (isset($_SESSION['username'])) {
        $response['username'] = $_SESSION['username'];
    }
} else {
    $response['isLoggedIn'] = false;
}

echo json_encode($response);
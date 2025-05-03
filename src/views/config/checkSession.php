<?php
session_start();
$response = [];

if (isset($_SESSION['username'])) {
    $response['isLoggedIn'] = true;
    $response['username'] = $_SESSION['username'];
    $response['userId'] = $_SESSION['userId'];
} else {
    $response['isLoggedIn'] = false;
}

echo json_encode($response);
?>

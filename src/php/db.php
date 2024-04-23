<?php
    $conn = mysqli_connect('localhost', 'root', '', 'vue-php');
    if (!$conn) {
        echo 'Connection error: ' . mysqli_connect_error();
    }
?>
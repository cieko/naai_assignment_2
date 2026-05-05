<?php

$conn = new mysqli('localhost', 'root', '', 'curd_app');

// if ($conn) {
//     echo "DB Connected";
// }

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
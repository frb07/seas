<?php
$conn = mysqli_connect("localhost", "root", "", "seas2");

if (!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
}

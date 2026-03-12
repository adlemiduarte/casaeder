<?php
$conn = mysqli_connect("localhost", "root", "", "casa_eder_db");

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>


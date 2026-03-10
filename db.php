<?php
// El nombre del archivo sigue siendo db.php
// Pero el CUARTO parámetro es el nombre real de tu base de datos
$conn = mysqli_connect("localhost", "root", "", "casa_eder_db");

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
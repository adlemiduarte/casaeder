<?php
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre_huesped']);
    $estrellas = $_POST['estrellas'];
    $comentario = mysqli_real_escape_string($conn, $_POST['comentario']);
    $fecha = $_POST['fecha_estancia'];

    $sql = "INSERT INTO resenas (nombre_huesped, estrellas, comentario, fecha_estancia) 
            VALUES ('$nombre', '$estrellas', '$comentario', '$fecha')";

    if (mysqli_query($conn, $sql)) {
        // Esto te saca de la página blanca y te regresa al inicio
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
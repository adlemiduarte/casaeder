<?php
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Recibimos los datos básicos (con seguridad para el texto)
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre_huesped']);
    $comentario = mysqli_real_escape_string($conn, $_POST['comentario']);
    $fecha = $_POST['fecha_estancia'];
    $estrellas = $_POST['estrellas'];

    // 2. Recibimos las NUEVAS categorías (Limpieza, Veracidad, etc.)
    // Usamos (int) para asegurarnos de que sean números
    $limpieza = (int)$_POST['limpieza'];
    $veracidad = (int)$_POST['veracidad'];
    $llegada = (int)$_POST['llegada'];
    $comunicacion = (int)$_POST['comunicacion'];
    $ubicacion = (int)$_POST['ubicacion'];
    $precio = (int)$_POST['precio'];

    // 3. El INSERT actualizado con TODAS las columnas
    $sql = "INSERT INTO resenas (nombre_huesped, estrellas, comentario, fecha_estancia, limpieza, veracidad, llegada, comunicacion, ubicacion, precio) 
            VALUES ('$nombre', '$estrellas', '$comentario', '$fecha', $limpieza, $veracidad, $llegada, $comunicacion, $ubicacion, $precio)";

    if (mysqli_query($conn, $sql)) {
        // Regresamos al inicio
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
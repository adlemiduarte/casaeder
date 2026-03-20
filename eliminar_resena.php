<?php
include 'db.php';

$conexion = $conn;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Por seguridad convertimos a número
    
    $borrar = "DELETE FROM resenas WHERE id = $id";
    
    if (mysqli_query($conexion, $borrar)) {
        // Redirige de vuelta con un mensaje de éxito
        header("Location: admin_reservas.php?status=deleted");
    } else {
        echo "Error al borrar: " . mysqli_error($conexion);
    }
}
?>
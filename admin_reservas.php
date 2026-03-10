<?php
// 1. SEGURIDAD
$usuario_admin = "admin";
$password_admin = "eder2026";

if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_PW'] != $password_admin || $_SERVER['PHP_AUTH_USER'] != $usuario_admin) {
    header('WWW-Authenticate: Basic realm="Acceso Privado Casa Eder"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Acceso denegado.';
    exit;
}

include 'db.php';

// 2. LÓGICA: GUARDAR RANGO DE FECHAS
if (isset($_POST['bloquear_rango'])) {
    $inicio = $_POST['fecha_inicio'];
    $fin = $_POST['fecha_fin'];
    $motivo = mysqli_real_escape_string($conn, $_POST['motivo']);

    $actual = strtotime($inicio);
    $final = strtotime($fin);

    while ($actual <= $final) {
        $fecha_insert = date("Y-m-d", $actual);
        // Verificamos si ya existe para no repetir
        $check = mysqli_query($conn, "SELECT id FROM fechas_bloqueadas WHERE fecha = '$fecha_insert'");
        if(mysqli_num_rows($check) == 0) {
            mysqli_query($conn, "INSERT INTO fechas_bloqueadas (fecha, motivo) VALUES ('$fecha_insert', '$motivo')");
        }
        $actual = strtotime("+1 day", $actual);
    }
    header("Location: admin_reservas.php");
    exit;
}

// 3. LÓGICA: ELIMINAR FECHA INDIVIDUAL
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    mysqli_query($conn, "DELETE FROM fechas_bloqueadas WHERE id = $id");
    header("Location: admin_reservas.php");
    exit;
}

// 4. CONSULTA PARA LA TABLA (Aquí es donde daba el error)
// Definimos $resultado SIEMPRE para que la tabla no falle
$resultado = mysqli_query($conn, "SELECT * FROM fechas_bloqueadas WHERE fecha >= CURDATE() ORDER BY fecha ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - Casa Eder</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-5">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-cyan-600 p-6 text-white text-center">
            <h1 class="text-2xl font-bold uppercase">Administrador de Disponibilidad</h1>
        </div>

        <div class="p-8">
            <form method="POST" class="mb-10 p-6 bg-gray-50 rounded-xl border border-gray-200">
                <h2 class="font-bold text-gray-700 mb-4">Bloquear un Rango de Días</h2>
                <div class="grid grid-cols-2 gap-4">
                    <input type="date" name="fecha_inicio" required class="p-2 border rounded">
                    <input type="date" name="fecha_fin" required class="p-2 border rounded">
                </div>
                <input type="text" name="motivo" placeholder="Motivo (ej: Reserva Juan)" class="w-full mt-3 p-2 border rounded">
                <button name="bloquear_rango" class="w-full mt-4 bg-cyan-600 text-white py-2 rounded font-bold hover:bg-cyan-700">
                    BLOQUEAR DIAS SELECCIONADOS
                </button>
            </form>

            <h2 class="font-bold text-gray-700 mb-4">Próximos días bloqueados</h2>
            <div class="bg-white border rounded-lg overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-100 text-sm">
                        <tr>
                            <th class="p-3">Fecha</th>
                            <th class="p-3">Motivo</th>
                            <th class="p-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if(mysqli_num_rows($resultado) > 0): ?>
                            <?php while($f = mysqli_fetch_assoc($resultado)): ?>
                            <tr>
                                <td class="p-3 text-sm font-bold"><?php echo date('d/m/Y', strtotime($f['fecha'])); ?></td>
                                <td class="p-3 text-sm text-gray-500"><?php echo $f['motivo']; ?></td>
                                <td class="p-3 text-right">
                                    <a href="?eliminar=<?php echo $f['id']; ?>" class="text-red-500 font-bold hover:underline">Eliminar</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="p-5 text-center text-gray-400">No hay bloqueos activos</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="p-4 text-center border-t">
            <a href="index.php" class="text-cyan-600 underline text-sm">Regresar a la Web</a>
        </div>
    </div>
</body>
</html>
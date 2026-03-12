<!DOCTYPE html>
<html lang="es">
<head>
    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renta de Casa Vacacional | Tu Descanso Ideal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        html { scroll-behavior: smooth; }
        .hero-bg {
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('img/pationoche1.jpeg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

<?php
include 'db.php';

$sql_promedios = "SELECT 
    AVG(estrellas) as total,  
    AVG(limpieza) as lim, 
    AVG(veracidad) as ver, 
    AVG(llegada) as lleg, 
    AVG(comunicacion) as com, 
    AVG(ubicacion) as ubi, 
    AVG(precio) as pre,
    COUNT(*) as conteo
    FROM resenas";

$res_prom = mysqli_query($conn, $sql_promedios);
$p = mysqli_fetch_assoc($res_prom);

// Calculamos cuántas estrellas hay de cada una para las barritas
$distribucion = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
if ($p['conteo'] > 0) {
    for ($i = 1; $i <= 5; $i++) {
        $check_cant = mysqli_query($conn, "SELECT COUNT(*) as c FROM resenas WHERE estrellas = $i");
        $cant_data = mysqli_fetch_assoc($check_cant);
        $distribucion[$i] = ($cant_data['c'] / $p['conteo']) * 100;
    }
} 
// Si no hay reseñas aún, evitamos que salga error de división por cero
$promedio_final = ($p['conteo'] > 0) ? number_format($p['total'], 2) : "0.00";

$fechas_prohibidas = [];

// Esta consulta une las fechas de las dos tablas: reseñas y bloqueos manuales
$sql = "SELECT fecha_estancia AS fecha FROM resenas 
        UNION 
        SELECT fecha FROM fechas_bloqueadas";

$res = mysqli_query($conn, $sql);

if ($res) {
    while($f = mysqli_fetch_assoc($res)){
        // Guardamos la fecha tal cual viene de la base de datos (2024-03-25)
        $fechas_prohibidas[] = $f['fecha'];
    }
}

// Eliminamos duplicados por si acaso
$fechas_prohibidas = array_unique($fechas_prohibidas);
?>
    <nav class="fixed w-full z-50 bg-white shadow-md py-4 px-6 flex justify-between items-center">
        <div class="text-2xl font-bold text-[#0097B2]"> Casa Eder <i class="fas fa-sun text-4xl text-[#f2ce54]"></i></div>
        <div class="hidden md:flex space-x-8 font-semibold">
            <a href="#inicio" class="hover:text-blue-500">Inicio</a>
            <a href="#galeria" class="hover:text-blue-500">Galería</a>
            <a href="#calendario" class="hover:text-blue-500">Disponibilidad</a>
            <a href="#contacto" class="hover:text-blue-500">Contacto</a>
        </div>
    <a href="https://wa.me/5216228555566?text=Hola!%20Buenas%20tardes.%20Vi%20el%20anuncio%20de%20Casa%20Eder%20y%20me%20interesa%20consultar%20disponibilidad%20para%20reservar.%20%C2%BFPodr%C3%ADan%20darme%20m%C3%A1s%20informaci%C3%B3n%3F%20Gracias." 
   target="_blank" 
   class="inline-block bg-green-500 text-white px-6 py-3 rounded-full font-bold hover:bg-green-600 transition shadow-md">
   Reservar Ya
</a>
    </nav>

    <section id="inicio" class="hero-bg h-screen flex items-center justify-center text-center text-white px-4">
        <div>
            <h1 class="text-5xl md:text-7xl font-extrabold mb-4">Tu hogar lejos de casa</h1>
            <p class="text-xl md:text-2xl mb-8">Disfruta de la mejor ubicación y comodidad total.</p>
            <a href="#galeria" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-bold transition">Ver la casa</a>
        </div>
    </section>

    <section id="servicios" class="py-16 container mx-auto px-6">
    <h2 class="text-3xl font-bold text-center mb-10 text-gray-800">Lo que te ofrece Casa Eder</h2>
    
    <div class="grid grid-cols-2 md:grid-cols-3 gap-8 text-center">
        
        <div class="bg-white p-6 rounded-xl shadow-md border-b-4 border-[#f2ce54] hover:scale-105 transition">
            <i class="fas fa-swimming-pool text-4xl text-[#0097b2] mb-4"></i>
            <span class="block font-bold text-gray-700">Alberca Privada</span>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-b-4 border-[#f2ce54] hover:scale-105 transition">
            <i class="fas fa-wifi text-4xl text-[#0097b2] mb-4"></i>
            <span class="block font-bold text-gray-700">Internet y TV</span>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-b-4 border-[#f2ce54] hover:scale-105 transition">
            <i class="fas fa-snowflake text-4xl text-[#0097b2] mb-4"></i>
            <span class="block font-bold text-gray-700">Aire Acondicionado</span>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-b-4 border-[#f2ce54] hover:scale-105 transition">
            <i class="fas fa-fire-alt text-4xl text-[#0097b2] mb-4"></i>
            <span class="block font-bold text-gray-700">Asador Equipado</span>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-b-4 border-[#f2ce54] hover:scale-105 transition">
            <i class="fas fa-tree text-4xl text-[#0097b2] mb-4"></i>
            <span class="block font-bold text-gray-700">Patio Amplio</span>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-b-4 border-[#f2ce54] hover:scale-105 transition">
            <i class="fas fa-utensils text-4xl text-[#0097b2] mb-4"></i>
            <span class="block font-bold text-gray-700">Utensilios de Cocina</span>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-b-4 border-[#f2ce54] hover:scale-105 transition">
            <i class="fas fa-blender text-4xl text-[#0097b2] mb-4"></i>
            <span class="block font-bold text-gray-700">Electrodomésticos</span>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-b-4 border-[#f2ce54] hover:scale-105 transition">
            <i class="fas fa-broom text-4xl text-[#0097b2] mb-4"></i>
            <span class="block font-bold text-gray-700">Servicio de Limpieza</span>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-b-4 border-[#f2ce54] hover:scale-105 transition">
            <i class="fas fa-chair text-4xl text-[#0097b2] mb-4"></i>
            <span class="block font-bold text-gray-700">Mobiliario para Eventos</span>
        </div>

         <div class="bg-white p-6 rounded-xl shadow-md border-b-4 border-[#f2ce54] hover:scale-105 transition">
            <i class="fas fa-chair text-4xl text-[#0097b2] mb-4"></i>
            <span class="block font-bold text-gray-700">Manteleria para Eventos</span>
        </div>

    </div>
</section>


    <section id="galeria" class="py-16 container mx-auto px-6">
    <h2 class="text-4xl font-extrabold mb-10 text-center text-gray-800">Conoce Casa Eder</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="overflow-hidden rounded-xl shadow-lg group">
            <img src="img/patio1.jpeg" alt="Patio Casa Eder" class="h-72 w-full object-cover group-hover:scale-110 transition duration-500">
        </div>
        
        <div class="overflow-hidden rounded-xl shadow-lg group">
            <img src="img/habitacion1.jpeg" alt="Habitación" class="h-72 w-full object-cover group-hover:scale-110 transition duration-500">
        </div>
        
        <div class="overflow-hidden rounded-xl shadow-lg group">
            <img src="img/sala1.jpeg" alt="Sala" class="h-72 w-full object-cover group-hover:scale-110 transition duration-500">
        </div>

        <div class="overflow-hidden rounded-xl shadow-lg group">
            <img src="img/cocina.jpeg" alt="Cocina" class="h-72 w-full object-cover group-hover:scale-110 transition duration-500">
        </div>

        <div class="overflow-hidden rounded-xl shadow-lg group">
            <img src="img/patio2.jpeg" alt="Patio de día" class="h-72 w-full object-cover group-hover:scale-110 transition duration-500">
        </div>

        <div class="overflow-hidden rounded-xl shadow-lg group">
            <img src="img/patio3.jpeg" alt="Patio de noche" class="h-72 w-full object-cover group-hover:scale-110 transition duration-500">
        </div>
         
        <video controls class="w-full max-w-2xl mx-auto rounded-lg shadow-xl mt-10">
            <source src="img/evento.mp4" type="video/mp4">
    
</video>

    </div>
</section>
            
<section id="disponibilidad" class="py-16 bg-gray-100">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8 items-start">
                
                <div class="flex-1 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-2">Selecciona tus fechas</h2>
    <p id="rango-fechas" class="text-gray-500 mb-6 text-sm">Selecciona el día de llegada y salida</p>
                    
                    <div class="calendario-contenedor">
    <input type="text" id="fecha_reserva" readonly>
</div>
                    <button onclick="borrarFechas()" class="mt-4 text-sm font-bold underline text-gray-800 float-right">Borrar fechas</button>
                </div>

                <div class="w-full lg:w-[380px] bg-white p-6 rounded-2xl shadow-xl border border-gray-100 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-800 mb-1">Consulta disponibilidad</h3>
                    <p class="text-gray-500 text-sm mb-6">Selecciona tus fechas para cotizar</p>

                    <div class="border rounded-t-xl flex overflow-hidden">
                        <div class="w-1/2 p-3 border-r border-b">
                            <label class="block text-[10px] font-bold uppercase text-gray-500">Llegada</label>
                            <div id="fecha-llegada" class="text-sm text-gray-400">Agrega fecha</div>
                        </div>
                        <div class="w-1/2 p-3 border-b">
                            <label class="block text-[10px] font-bold uppercase text-gray-500">Salida</label>
                            <div id="fecha-salida" class="text-sm text-gray-400">Agrega fecha</div>
                        </div>
                    </div>

                    <div class="relative border border-t-0 rounded-b-xl mb-6">
                        <div class="p-3 cursor-pointer hover:bg-gray-50 transition-colors" onclick="toggleHuespedes()">
                            <label class="block text-[10px] font-bold uppercase text-gray-500">Huéspedes</label>
                            <div id="resumenHuespedes" class="text-sm text-black font-medium">1 huésped</div>
                        </div>

                        <div id="listaHuespedes" class="hidden absolute left-0 right-0 top-full bg-white border border-gray-200 shadow-2xl rounded-xl p-4 z-50 mt-1">
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <div><p class="text-sm font-bold">Adultos</p><p class="text-xs text-gray-500">Más de 13 años</p></div>
                                <div class="flex items-center gap-3">
                                    <button type="button" onclick="cambiarCantidad('adultos', -1)" class="w-8 h-8 rounded-full border border-gray-300">-</button>
                                    <span id="cnt-adultos" class="text-sm w-4 text-center">1</span>
                                    <button type="button" onclick="cambiarCantidad('adultos', 1)" class="w-8 h-8 rounded-full border border-gray-300">+</button>
                                </div>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <div><p class="text-sm font-bold">Niños</p><p class="text-xs text-gray-500">2 a 12 años</p></div>
                                <div class="flex items-center gap-3">
                                    <button type="button" onclick="cambiarCantidad('ninos', -1)" class="w-8 h-8 rounded-full border border-gray-300">-</button>
                                    <span id="cnt-ninos" class="text-sm w-4 text-center">0</span>
                                    <button type="button" onclick="cambiarCantidad('ninos', 1)" class="w-8 h-8 rounded-full border border-gray-300">+</button>
                                </div>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <div><p class="text-sm font-bold">Mascotas</p><p class="text-xs text-[#0097b2] underline cursor-pointer">¿Traes animal de servicio?</p></div>
                                <div class="flex items-center gap-3">
                                    <button type="button" onclick="cambiarCantidad('mascotas', -1)" class="w-8 h-8 rounded-full border border-gray-300">-</button>
                                    <span id="cnt-mascotas" class="text-sm w-4 text-center">0</span>
                                    <button type="button" onclick="cambiarCantidad('mascotas', 1)" class="w-8 h-8 rounded-full border border-gray-300">+</button>
                                </div>
                            </div>
                            <button type="button" onclick="toggleHuespedes()" class="w-full text-right text-sm font-bold mt-2 underline">Cerrar</button>
                        </div>
                    </div>

                    <button id="btnReservar" onclick="enviarWhatsApp()" class="w-full bg-[#0097b2] text-white font-bold py-4 rounded-xl hover:bg-[#007a8f] transition-all shadow-md">
                        Consultar disponibilidad
                            </button>
                    <p class="text-center text-[11px] text-gray-400 mt-4 italic">Te responderemos por WhatsApp</p>
                </div>

            </div>
        </div>
    </section>

    
</div> 

<div class="max-w-6xl mx-auto my-12 p-6 bg-white">
    
    <div class="flex items-center gap-2 text-3xl font-bold mb-10">
        <span class="text-black">★ <?php echo $promedio_final; ?></span>
        <span class="text-gray-400">·</span>
        <span><?php echo $p['conteo']; ?> evaluaciones</span>
    </div>

    <div class="flex flex-col lg:flex-row gap-16 items-start">
        
        <div class="w-full lg:w-1/3 border-r border-gray-100 pr-8">
            <h3 class="text-lg font-bold mb-6">Calificación general</h3>
            
            <?php for($i=5; $i>=1; $i--): ?>
            <div class="flex items-center gap-4 mb-3">
                <span class="text-sm font-medium w-4"><?php echo $i; ?></span>
                <div class="flex-1 bg-gray-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-black h-full rounded-full" 
                         style="width: <?php echo $distribucion[$i]; ?>%">
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>

        <div class="flex-1 grid grid-cols-2 sm:grid-cols-3 gap-y-10 gap-x-8">
            
            <div class="flex flex-col gap-1 border-l-2 border-gray-50 pl-4">
                <span class="text-sm font-semibold text-gray-800">Limpieza</span>
                <span class="text-xl font-bold"><?php echo number_format($p['lim'], 1); ?></span>
                <span class="text-2xl mt-1">✨</span>
            </div>

            <div class="flex flex-col gap-1 border-l-2 border-gray-50 pl-4">
                <span class="text-sm font-semibold text-gray-800">Veracidad</span>
                <span class="text-xl font-bold"><?php echo number_format($p['ver'], 1); ?></span>
                <span class="text-2xl mt-1">✅</span>
            </div>

            <div class="flex flex-col gap-1 border-l-2 border-gray-50 pl-4">
                <span class="text-sm font-semibold text-gray-800">Llegada</span>
                <span class="text-xl font-bold"><?php echo number_format($p['lleg'], 1); ?></span>
                <span class="text-2xl mt-1">🔑</span>
            </div>

            <div class="flex flex-col gap-1 border-l-2 border-gray-50 pl-4">
                <span class="text-sm font-semibold text-gray-800">Comunicación</span>
                <span class="text-xl font-bold"><?php echo number_format($p['com'], 1); ?></span>
                <span class="text-2xl mt-1">💬</span>
            </div>

            <div class="flex flex-col gap-1 border-l-2 border-gray-50 pl-4">
                <span class="text-sm font-semibold text-gray-800">Ubicación</span>
                <span class="text-xl font-bold"><?php echo number_format($p['ubi'], 1); ?></span>
                <span class="text-2xl mt-1">📍</span>
            </div>

            <div class="flex flex-col gap-1 border-l-2 border-gray-50 pl-4">
                <span class="text-sm font-semibold text-gray-800">Precio</span>
                <span class="text-xl font-bold"><?php echo number_format($p['pre'], 1); ?></span>
                <span class="text-2xl mt-1">💰</span>
            </div>

        </div>
    </div>
</div>

<section class="py-12 bg-white">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-gray-50 p-8 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Cuéntanos tu experiencia</h2>
            
            <form action="guardar_resena.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tu Nombre</label>
                    <input type="text" name="nombre_huesped" required class="w-full p-3 rounded-lg border-gray-200 border focus:ring-2 focus:ring-cyan-500 focus:outline-none transition-all">
                </div>

                <div class="space-y-6">
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Calificación General</label>
            <select name="estrellas" class="w-full p-3 border border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-cyan-500 outline-none">
                <option value="5">⭐⭐⭐⭐⭐ (Excelente)</option>
                <option value="4">⭐⭐⭐⭐ (Muy bueno)</option>
                <option value="3">⭐⭐⭐ (Bueno)</option>
                <option value="2">⭐⭐ (Regular)</option>
                <option value="1">⭐ (Malo)</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Fecha de estancia</label>
            <input type="date" name="fecha_estancia" required class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-cyan-500 outline-none">
        </div>
    </div>

    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
        <h3 class="text-sm font-bold text-gray-700 mb-4 border-b pb-2">Detalles de tu estancia</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Limpieza ✨</label>
                <select name="limpieza" class="w-full p-2 border border-gray-200 rounded-lg text-sm bg-white">
                    <option value="5">5 - Excelente</option>
                    <option value="4">4 - Muy bueno</option>
                    <option value="3">3 - Bueno</option>
                    <option value="2">2 - Regular</option>
                    <option value="1">1 - Malo</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Veracidad ✅</label>
                <select name="veracidad" class="w-full p-2 border border-gray-200 rounded-lg text-sm bg-white">
                    <option value="5">5 - Excelente</option>
                    <option value="4">4 - Muy bueno</option>
                    <option value="3">3 - Bueno</option>
                    <option value="2">2 - Regular</option>
                    <option value="1">1 - Malo</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Llegada 🔑</label>
                <select name="llegada" class="w-full p-2 border border-gray-200 rounded-lg text-sm bg-white">
                    <option value="5">5 - Excelente</option>
                    <option value="4">4 - Muy bueno</option>
                    <option value="3">3 - Bueno</option>
                    <option value="2">2 - Regular</option>
                    <option value="1">1 - Malo</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Comunicación 💬</label>
                <select name="comunicacion" class="w-full p-2 border border-gray-200 rounded-lg text-sm bg-white">
                    <option value="5">5 - Excelente</option>
                    <option value="4">4 - Muy bueno</option>
                    <option value="3">3 - Bueno</option>
                    <option value="2">2 - Regular</option>
                    <option value="1">1 - Malo</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Ubicación 📍</label>
                <select name="ubicacion" class="w-full p-2 border border-gray-200 rounded-lg text-sm bg-white">
                    <option value="5">5 - Excelente</option>
                    <option value="4">4 - Muy bueno</option>
                    <option value="3">3 - Bueno</option>
                    <option value="2">2 - Regular</option>
                    <option value="1">1 - Malo</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Calidad-Precio 💰</label>
                <select name="precio" class="w-full p-2 border border-gray-200 rounded-lg text-sm bg-white">
                    <option value="5">5 - Excelente</option>
                    <option value="4">4 - Muy bueno</option>
                    <option value="3">3 - Bueno</option>
                    <option value="2">2 - Regular</option>
                    <option value="1">1 - Malo</option>
                </select>
            </div>
        </div>
    </div>

    <div>
        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Tu Comentario</label>
        <textarea name="comentario" rows="3" placeholder="Cuéntanos más detalles..." class="w-full p-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-cyan-500 outline-none"></textarea>
    </div>
</div>
                <button type="submit" class="w-full bg-[#0097b2] hover:bg-[#007a8f] text-white font-bold py-4 rounded-lg shadow-lg transform active:scale-95 transition-all uppercase tracking-wider">
                    Publicar Reseña
                </button>
            </form>
        </div>
    </div>
</section>
        
 

<div class="mt-10 max-w-2xl mx-auto">
    <h3 class="text-xl font-bold mb-5 text-center">Reseñas de nuestros huéspedes</h3>
    
    <?php
    include 'db.php'; // Nos conectamos
    
    // Pedimos las reseñas a la base de datos
    $resultado = mysqli_query($conn, "SELECT * FROM resenas ORDER BY id DESC");

    if (mysqli_num_rows($resultado) > 0) {
        while($fila = mysqli_fetch_assoc($resultado)) {
            ?>
            <div class="bg-white p-4 rounded-lg shadow-md mb-4 border-l-4 border-cyan-500">
                <div class="flex justify-between items-center mb-2">
                    <strong class="text-gray-800"><?php echo $fila['nombre_huesped']; ?></strong>
                    <span class="text-yellow-500">
                        <?php echo str_repeat('⭐', $fila['estrellas']); ?>
                    </span>
                </div>
                <p class="text-gray-600 italic">"<?php echo $fila['comentario']; ?>"</p>
                <small class="text-gray-400 block mt-2 text-right">
                    Estancia: <?php echo date('d/m/Y', strtotime($fila['fecha_estancia'])); ?>
                </small>
            </div>
            <?php
        }
    } else {
        echo "<p class='text-center text-gray-500'>Aún no hay reseñas. ¡Sé el primero en comentar!</p>";
    }
    ?>
</div>


    <section id="ubicacion" class="py-16 container mx-auto px-6">
    <h2 class="text-3xl font-bold text-center mb-8">Nuestra Ubicación</h2>
    <div class="overflow-hidden rounded-2xl shadow-lg border-4 border-white h-[450px]">


        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3523.6118706273437!2d-111.0369482!3d27.9751706!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86c963002dc557ef%3A0x3dfb16241a34cefc!2sCasa%20EDER%20San%20Carlos!5e0!3m2!1ses-419!2smx!4v1772570866199!5m2!1ses-419!2smx"
         width="100%" 
         height="100%" 
         style="border:0;" 
         allowfullscreen="" 
         loading="lazy" 
         referrerpolicy="no-referrer-when-downgrade">
        </iframe>


    </div>
</section>

    <footer id="contacto" class="py-12 bg-gray-900 text-white mt-16 text-center">
        <h2 class="text-2xl font-bold mb-4">Contáctanos</h2>
        <div class="flex justify-center space-x-6 mb-8 text-3xl">
            <a href="https://facebook.com" class="hover:text-blue-500"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://instagram.com" class="hover:text-pink-500"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://wa.me/5216228555566" class="hover:text-green-500"><i class="fa-brands fa-whatsapp"></i></a>
        </div>
        <p>&copy; 2024 CasaEder - Todos los derechos reservados.</p>
    </footer>

   <a href="https://wa.me/5216228555566?text=Hola!%20Buenas%20tardes.%20Vi%20el%20anuncio%20de%20Casa%20Eder%20y%20me%20interesa%20consultar%20disponibilidad%20para%20reservar.%20%C2%BFPodr%C3%ADan%20darme%20m%C3%A1s%20informaci%C3%B3n%3F%20Gracias." 
   target="_blank" 
   class="fixed bottom-10 right-10 bg-green-500 text-white p-4 rounded-full shadow-2xl z-50 hover:bg-green-600 transition-all hover:scale-110 flex items-center justify-center w-16 h-16">
   <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" class="w-8 h-8">
</a>

<script>
let conteos = { adultos: 1, ninos: 0, mascotas: 0 };

function toggleHuespedes() {
    document.getElementById('listaHuespedes').classList.toggle('hidden');
}

function cambiarCantidad(tipo, cambio) {
    // No permitir menos de 1 adulto
    if (tipo === 'adultos' && conteos[tipo] + cambio < 1) return;
    // No permitir menos de 0 en lo demás
    if (conteos[tipo] + cambio < 0) return;

    conteos[tipo] += cambio;
    
    // Actualizar el número en la lista
    document.getElementById(`cnt-${tipo}`).innerText = conteos[tipo];
    
    // Actualizar el resumen del botón principal
    const totalHuespedes = conteos.adultos + conteos.ninos;
    let texto = `${totalHuespedes} huésped${totalHuespedes > 1 ? 'es' : ''}`;
    if (conteos.mascotas > 0) {
        texto += `, ${conteos.mascotas} mascota${conteos.mascotas > 1 ? 's' : ''}`;
    }
    document.getElementById('resumenHuespedes').innerText = texto;
}

// Cerrar al hacer clic fuera
window.onclick = function(event) {
    if (!event.target.closest('.relative')) {
        document.getElementById('listaHuespedes').classList.add('hidden');
    }
}
</script>
<script>
    const fp = flatpickr("#calendario-inline", {
    inline: true,
    mode: "range",
    showMonths: 2,
    locale: "es",
    static: true,
    dateFormat: "d/m/Y",
    minDate: "today",
    onChange: function(selectedDates, dateStr, instance) {
        // 1. Actualizar el texto general (el que ya tenías)
        if (selectedDates.length === 2) {
            document.getElementById('rango-fechas').innerText = dateStr;
            
            // 2. ACTUALIZAR LOS CUADRITOS INDIVIDUALES
            // Formateamos las fechas para que se vean bonitas
            const opciones = { day: 'numeric', month: 'short' }; // Ej: 4 mar.
            
            document.getElementById('fecha-llegada').innerText = selectedDates[0].toLocaleDateString('es-ES', opciones);
            document.getElementById('fecha-salida').innerText = selectedDates[1].toLocaleDateString('es-ES', opciones);
            
            // Cambiar el color de gris a negro para que se note que ya hay fecha
            document.getElementById('fecha-llegada').classList.replace('text-gray-400', 'text-black');
            document.getElementById('fecha-salida').classList.replace('text-gray-400', 'text-black');
        }
    }
});

    function borrarFechas() {
    fp.clear();
    document.getElementById('rango-fechas').innerText = "Selecciona el día de llegada y salida";
    document.getElementById('fecha-llegada').innerText = "Agrega fecha";
    document.getElementById('fecha-salida').innerText = "Agrega fecha";
    document.getElementById('fecha-llegada').classList.replace('text-black', 'text-gray-400');
    document.getElementById('fecha-salida').classList.replace('text-black', 'text-gray-400');
}
</script>

<style>
    /* Estilo para que se parezca a tu foto */
    #calendario-inline .flatpickr-calendar {
    margin: 0 auto !important;
    box-shadow: none !important;
    border: none !important;
    width: 100% !important;
    max-width: 650px !important; /* Ajusta esto al ancho de tus 2 meses */
}
    .flatpickr-day.inRange { box-shadow: -5px 0 0 #f3f4f6, 5px 0 0 #f3f4f6 !important; background: #f3f4f6 !important; }


    
</style>

<script src="script.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

    <script>
    const fechasOcupadas = <?php echo json_encode(array_values($fechas_prohibidas)); ?>;

    flatpickr("#fecha_reserva", {
        locale: "es",
        minDate: "today",
        mode: "range",
        disable: fechasOcupadas,
        dateFormat: "Y-m-d",
        inline: true,      // Se queda abierto
        showMonths: 2,     // Muestra Marzo y Abril al mismo tiempo (como en tu foto)
        
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                const start = selectedDates[0];
                const end = selectedDates[1];
                
                const hayBloqueo = fechasOcupadas.some(fecha => {
                    const d = new Date(fecha + "T00:00:00");
                    return d >= start && d <= end;
                });

                if (hayBloqueo) {
                    alert("¡Ups! Algunas fechas en ese rango ya están reservadas.");
                    instance.clear();
                }
            }
        }
    });
</script>
</body>
</html>
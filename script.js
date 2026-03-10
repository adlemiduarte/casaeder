<<<<<<< HEAD
// 1. VARIABLES GLOBALES
var conteosHuespedes = { adultos: 1, ninos: 0, mascotas: 0 };
var miCalendario; 


document.addEventListener('DOMContentLoaded', function() {
    // 2. INICIALIZAR EL CALENDARIO (Con 2 meses y en español)
    miCalendario = flatpickr("#calendario-inline", {
        inline: true,
        mode: "range",
        showMonths: 2, // <--- Esto arregla la vista de Marzo y Abril
        locale: "es",
        minDate: "today",
        dateFormat: "d/m/Y",
        onChange: function(selectedDates) {
            if (selectedDates.length === 2) {
                const opciones = { day: 'numeric', month: 'short' };
                // Actualiza los textos de llegada y salida
                document.getElementById('fecha-llegada').innerText = selectedDates[0].toLocaleDateString('es-ES', opciones);
                document.getElementById('fecha-salida').innerText = selectedDates[1].toLocaleDateString('es-ES', opciones);
                
                // Cambia el color a negro para resaltar
                document.getElementById('fecha-llegada').classList.add('text-black');
                document.getElementById('fecha-salida').classList.add('text-black');
            }
        }
    });
});

// 3. FUNCIÓN PARA WHATSAPP
window.enviarWhatsApp = function() {
    if (!miCalendario || miCalendario.selectedDates.length < 2) {
        alert("Por favor, selecciona primero tus fechas en el calendario.");
        return;
    }

    const fechas = miCalendario.selectedDates;
    const llegada = fechas[0].toLocaleDateString('es-ES', { day: 'numeric', month: 'long' });
    const salida = fechas[1].toLocaleDateString('es-ES', { day: 'numeric', month: 'long' });
    const total = conteosHuespedes.adultos + conteosHuespedes.ninos;
    const mascotasTexto = conteosHuespedes.mascotas > 0 ? ` e incluimos ${conteosHuespedes.mascotas} mascota(s)` : "";

    const mensaje = `¡Hola Casa Eder! 👋 Me gustaría consultar disponibilidad:
    
📅 Entrada: ${llegada}
📅 Salida: ${salida}
👥 Huéspedes: ${total} personas${mascotasTexto}.`;

    const url = `https://wa.me/5216228555566?text=${encodeURIComponent(mensaje)}`;
    window.open(url, '_blank');
};

// 4. FUNCIÓN PARA BORRAR FECHAS (Arreglada)
window.borrarFechas = function() {
    if (miCalendario) {
        miCalendario.clear(); // Limpia el calendario
        document.getElementById('fecha-llegada').innerText = "Agrega fecha";
        document.getElementById('fecha-salida').innerText = "Agrega fecha";
        document.getElementById('fecha-llegada').classList.remove('text-black');
        document.getElementById('fecha-salida').classList.remove('text-black');
    }
};

// 5. FUNCIONES DE HUÉSPEDES
window.toggleHuespedes = function() {
    document.getElementById('listaHuespedes').classList.toggle('hidden');
};

window.cambiarCantidad = function(tipo, cambio) {
    if (tipo === 'adultos' && conteosHuespedes[tipo] + cambio < 1) return;
    if (conteosHuespedes[tipo] + cambio < 0) return;
    
    conteosHuespedes[tipo] += cambio;
    document.getElementById(`cnt-${tipo}`).innerText = conteosHuespedes[tipo];
    
    const total = conteosHuespedes.adultos + conteosHuespedes.ninos;
    let texto = `${total} huésped${total > 1 ? 'es' : ''}`;
    if (conteosHuespedes.mascotas > 0) texto += `, ${conteosHuespedes.mascotas} mascota${conteosHuespedes.mascotas > 1 ? 's' : ''}`;
    
    document.getElementById('resumenHuespedes').innerText = texto;
};

// Funciones vacías para que el HTML no marque error si aún tienen los onclick
function toggleIdioma() { console.log("Función desactivada"); }
=======
// 1. VARIABLES GLOBALES
var conteosHuespedes = { adultos: 1, ninos: 0, mascotas: 0 };
var miCalendario; 

document.addEventListener('DOMContentLoaded', function() {
    // 2. INICIALIZAR EL CALENDARIO (Con 2 meses y en español)
    miCalendario = flatpickr("#calendario-inline", {
        inline: true,
        mode: "range",
        showMonths: 2, // <--- Esto arregla la vista de Marzo y Abril
        locale: "es",
        minDate: "today",
        dateFormat: "d/m/Y",
        onChange: function(selectedDates) {
            if (selectedDates.length === 2) {
                const opciones = { day: 'numeric', month: 'short' };
                // Actualiza los textos de llegada y salida
                document.getElementById('fecha-llegada').innerText = selectedDates[0].toLocaleDateString('es-ES', opciones);
                document.getElementById('fecha-salida').innerText = selectedDates[1].toLocaleDateString('es-ES', opciones);
                
                // Cambia el color a negro para resaltar
                document.getElementById('fecha-llegada').classList.add('text-black');
                document.getElementById('fecha-salida').classList.add('text-black');
            }
        }
    });
});

// 3. FUNCIÓN PARA WHATSAPP
window.enviarWhatsApp = function() {
    if (!miCalendario || miCalendario.selectedDates.length < 2) {
        alert("Por favor, selecciona primero tus fechas en el calendario.");
        return;
    }

    const fechas = miCalendario.selectedDates;
    const llegada = fechas[0].toLocaleDateString('es-ES', { day: 'numeric', month: 'long' });
    const salida = fechas[1].toLocaleDateString('es-ES', { day: 'numeric', month: 'long' });
    const total = conteosHuespedes.adultos + conteosHuespedes.ninos;
    const mascotasTexto = conteosHuespedes.mascotas > 0 ? ` e incluimos ${conteosHuespedes.mascotas} mascota(s)` : "";

    const mensaje = `¡Hola Casa Eder! 👋 Me gustaría consultar disponibilidad:
    
📅 Entrada: ${llegada}
📅 Salida: ${salida}
👥 Huéspedes: ${total} personas${mascotasTexto}.`;

    const url = `https://wa.me/5216228555566?text=${encodeURIComponent(mensaje)}`;
    window.open(url, '_blank');
};

// 4. FUNCIÓN PARA BORRAR FECHAS (Arreglada)
window.borrarFechas = function() {
    if (miCalendario) {
        miCalendario.clear(); // Limpia el calendario
        document.getElementById('fecha-llegada').innerText = "Agrega fecha";
        document.getElementById('fecha-salida').innerText = "Agrega fecha";
        document.getElementById('fecha-llegada').classList.remove('text-black');
        document.getElementById('fecha-salida').classList.remove('text-black');
    }
};

// 5. FUNCIONES DE HUÉSPEDES
window.toggleHuespedes = function() {
    document.getElementById('listaHuespedes').classList.toggle('hidden');
};

window.cambiarCantidad = function(tipo, cambio) {
    if (tipo === 'adultos' && conteosHuespedes[tipo] + cambio < 1) return;
    if (conteosHuespedes[tipo] + cambio < 0) return;
    
    conteosHuespedes[tipo] += cambio;
    document.getElementById(`cnt-${tipo}`).innerText = conteosHuespedes[tipo];
    
    const total = conteosHuespedes.adultos + conteosHuespedes.ninos;
    let texto = `${total} huésped${total > 1 ? 'es' : ''}`;
    if (conteosHuespedes.mascotas > 0) texto += `, ${conteosHuespedes.mascotas} mascota${conteosHuespedes.mascotas > 1 ? 's' : ''}`;
    
    document.getElementById('resumenHuespedes').innerText = texto;
};

// Funciones vacías para que el HTML no marque error si aún tienen los onclick
function toggleIdioma() { console.log("Función desactivada"); }
>>>>>>> 7098397bbaf98697ed68adb0bfd11b27d16ab3ce
function toggleMoneda() { console.log("Función desactivada"); }
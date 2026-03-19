// 1. VARIABLES GLOBALES
var conteosHuespedes = { adultos: 1, ninos: 0, mascotas: 0 };
 
// 1. Variable global
var miCalendario;

document.addEventListener('DOMContentLoaded', function() {
    console.log("Página cargada, iniciando calendario...");

    // 2. Inicialización
    miCalendario = flatpickr("#calendario-inline", {
        inline: true,
        mode: "range",
        showMonths: 2,
        locale: "es",
        minDate: "today",
        dateFormat: "d/m/Y",
        onChange: function(selectedDates) {
            console.log("Fechas seleccionadas:", selectedDates);

            if (selectedDates.length === 2) {
                const opciones = { day: 'numeric', month: 'short' };
                
                // Buscamos los elementos por ID
                const llegada = document.getElementById('fecha-llegada');
                const salida = document.getElementById('fecha-salida');

                if (llegada && salida) {
                    llegada.innerText = selectedDates[0].toLocaleDateString('es-ES', opciones);
                    salida.innerText = selectedDates[1].toLocaleDateString('es-ES', opciones);
                    llegada.style.color = "black";
                    salida.style.color = "black";
                    console.log("¡Textos actualizados en la tarjeta!");
                } else {
                    console.error("No encontré los IDs fecha-llegada o fecha-salida");
                }
            }
        }
    });

    // 3. Ocultar el input que sale arriba (Punto 1)
    const inputFeo = document.querySelector('.flatpickr-input');
    if (inputFeo) inputFeo.style.display = 'none';
});

// 4. Función Borrar (Punto 3)
window.borrarFechas = function() {
    console.log("Borrando fechas...");
    if (miCalendario) {
        // Si miCalendario es un array, limpiamos el primero
        if (Array.isArray(miCalendario)) {
            miCalendario[0].clear();
        } else {
            miCalendario.clear();
        }
        
        document.getElementById('fecha-llegada').innerText = "Agrega fecha";
        document.getElementById('fecha-salida').innerText = "Agrega fecha";
        document.getElementById('fecha-llegada').style.color = "#9ca3af";
        document.getElementById('fecha-salida').style.color = "#9ca3af";
    }
};

    // CORRECCIÓN PARA EL ERROR DE CONSOLA:
    // Flatpickr devuelve un array cuando se usa un selector, tomamos el primer elemento
    miCalendario = Array.isArray(fpInstance) ? fpInstance[0] : fpInstance;

    // PUNTO 1: Borrar el cuadro de texto que sale arriba
    const inputFeo = document.querySelector('.flatpickr-input');
    if (inputFeo) inputFeo.style.display = 'none';


// PUNTO 3: Función de borrar corregida
window.borrarFechas = function() {
    console.log("¡Botón de borrar clickeado!");
    
    if (miCalendario && typeof miCalendario.clear === "function") {
        miCalendario.clear(); // Ahora sí funcionará .clear()
        
        const llegada = document.getElementById('fecha-llegada');
        const salida = document.getElementById('fecha-salida');

        if (llegada && salida) {
            llegada.innerText = "Agrega fecha";
            salida.innerText = "Agrega fecha";
            llegada.style.color = "#9ca3af"; // Gris original
            salida.style.color = "#9ca3af";
        }
    } else {
        console.error("No se pudo acceder a la función .clear() de miCalendario");
    }
};

    setTimeout(() => {
        const inputFeo = document.querySelector('.flatpickr-input');
        if (inputFeo) inputFeo.remove(); 
    }, 100);



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
// window.borrarFechas = function() {
   /* if (miCalendario) {
        miCalendario.clear();
        document.getElementById('fecha-llegada').innerText = "Agrega fecha";
        document.getElementById('fecha-salida').innerText = "Agrega fecha";
        document.getElementById('fecha-llegada').className = "text-sm text-gray-400";
        document.getElementById('fecha-salida').className = "text-sm text-gray-400";
    }
};*/

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
function toggleMoneda() { console.log("Función desactivada"); }
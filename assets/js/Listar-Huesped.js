
const buscar = document.getElementById("boton-buscar");
buscar.addEventListener("click", () => {
    const searchTerm = document.getElementById("buscar").value.toLowerCase();
    const filteredHuespedes = L_Huespedes.filter(huesped => {
        return huesped.Nombre.toLowerCase().includes(searchTerm) ||
            huesped.Apellido.toLowerCase().includes(searchTerm) ||
            huesped.N_Documento.toString().includes(searchTerm);
    });
    tabla(filteredHuespedes);
});

const barraBusqueda = document.getElementById("buscar");
barraBusqueda.addEventListener("search", () => {
    if (barraBusqueda.value === "") {
        tabla(L_Huespedes); // Reset to show all guests
    }
});

const estadoSelect = document.getElementById("estado");
estadoSelect.addEventListener("change", () => {
    const selectedState = estadoSelect.value;
    const filteredHuespedes = L_Huespedes.filter(huesped => {
        return (selectedState === "Activo" && huesped.Estado === "Activo") || (selectedState === "Inactivo" && huesped.Estado === "Inactivo");
    });
    tabla(filteredHuespedes);
});

const generoSelect = document.getElementById("genero");
generoSelect.addEventListener("change", () => {
    const selectedGenero = generoSelect.value;
    const filteredHuespedes = L_Huespedes.filter(huesped => {
        return selectedGenero === "todos" || (selectedGenero === "Masculino" && huesped.Genero === "Masculino") || (selectedGenero === "Femenino" && huesped.Genero === "Femenino") || (selectedGenero === "Otro" && huesped.Genero === "Otro");
    });
    tabla(filteredHuespedes);
});

const desdeFecha = document.getElementById("desde-fecha");
const hastaFecha = document.getElementById("hasta-fecha");

function filtroPorFecha() {
    if (desdeFecha.value && hastaFecha.value) {
        const desde = new Date(desdeFecha.value);
        const hasta = new Date(hastaFecha.value);
        const filteredHuespedes = L_Huespedes.filter(huesped => {
            const checkInDate = new Date(huesped.Fecha_Nacimiento);
            return checkInDate >= desde && checkInDate <= hasta;
        });
        tabla(filteredHuespedes);
    }
}

desdeFecha.addEventListener("change", filtroPorFecha);
hastaFecha.addEventListener("change", filtroPorFecha);


function tabla(filteredHuespedes){
    const tableBody = document.querySelector("table tbody");
    tableBody.innerHTML = ""; // Clear existing rows
    const fragment = document.createDocumentFragment();
    let counter = 1;
    filteredHuespedes.forEach(huesped => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${counter}</td>
            <td>${huesped.Nombre} ${huesped.Apellido}</td>
            <td>${huesped.Tipo_Documento}</td>
            <td>${huesped.N_Documento}</td>
            <td>${huesped.Correo}</td>
            <td><kbd style="background-color: ${huesped.Estado === "Activo" ? "green" : "red"};">${huesped.Estado}</kbd></td>
            <td>
                <a onclick="AbrirInfor(${huesped.ID});"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><g fill="none" stroke="#0b8d00" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0-4 0"/><path d="M12 18q-5.4 0-9-6q3.6-6 9-6t9 6m-5 7h6m-3-3v6"/></g></svg></a>
                <a onclick="Abrir(${huesped.ID});"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="currentColor" d="m21.7 13.35l-1 1l-2.05-2.05l1-1a.55.55 0 0 1 .77 0l1.28 1.28c.21.21.21.56 0 .77M12 18.94l6.06-6.06l2.05 2.05L14.06 21H12zM12 14c-4.42 0-8 1.79-8 4v2h6v-1.89l4-4c-.66-.08-1.33-.11-2-.11m0-10a4 4 0 0 0-4 4a4 4 0 0 0 4 4a4 4 0 0 0 4-4a4 4 0 0 0-4-4" stroke-width="0.5" stroke="currentColor"/></svg></a>
                <a id="confirmar" href="index.php?accion=eliminar-huesped&id=${huesped.ID}"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#f00" d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6zm2.46-7.12l1.41-1.41L12 12.59l2.12-2.12l1.41 1.41L13.41 14l2.12 2.12l-1.41 1.41L12 15.41l-2.12 2.12l-1.41-1.41L10.59 14zM15.5 4l-1-1h-5l-1 1H5v2h14V4z"/></svg></a>
            </td>
        `;
        fragment.appendChild(row);
        counter++;
    });
    tableBody.appendChild(fragment);
}

function Abrir(id) {
    const modal = document.getElementById("Dialog_Editar");
    modal.showModal();

    const idInput = document.getElementById("ID");
    const nombre = document.getElementById("nombre");
    const apellido = document.getElementById("apellido");
    const generoRadios = document.querySelectorAll('input[name="genero"]');
    const documento = document.getElementById("documento");
    const N_documento = document.getElementById("N_documento");
    const fechaNacimiento = document.getElementById("fecha-nacimiento");
    const correo = document.getElementById("correo");

    const huesped = L_Huespedes.find(h => h.ID === id);
    if (huesped) {
        idInput.value = huesped.ID;
        nombre.value = huesped.Nombre;
        apellido.value = huesped.Apellido;
        
        generoRadios.forEach(radio => {
            if (radio.value === huesped.Genero) {
                radio.checked = true;
            }
        });
        
        const options = documento.options;
        for (let i = 0; i < options.length; i++) {
            if (options[i].textContent == huesped.Tipo_Documento) {
                documento.selectedIndex = i;
                break;
            }
        }
        
        N_documento.value = huesped.N_Documento;
        
        if (huesped.Fecha_Nacimiento) {
            const date = new Date(huesped.Fecha_Nacimiento);
            if (!isNaN(date.getTime())) {
                const formattedDate = date.toISOString().split('T')[0];
                fechaNacimiento.value = formattedDate;
            }
        }
        
        correo.value = huesped.Correo;
    }

}

function AbrirInfor(id){
    const dialogVer = document.getElementById("Ver-Informacion");
    const parrafo = document.getElementById("Informacion-huesped");
    dialogVer.showModal();
    const huesped = L_Huespedes.find(h => h.ID === id);
    if (huesped) {
        const date = new Date(huesped.Fecha_Nacimiento);
        const formattedDate = date.toISOString().split('T')[0];
        
        parrafo.innerHTML = `
            <strong>Nombre:</strong> ${huesped.Nombre} ${huesped.Apellido}<br>
            <strong>Fecha de Nacimiento:</strong> ${formattedDate}<br>
            <strong>Género:</strong> ${huesped.Genero}<br>
            <strong>Tipo de Documento:</strong> ${huesped.Tipo_Documento}<br>
            <strong>Número de Documento:</strong> ${huesped.N_Documento}<br>
            <strong>Correo Electrónico:</strong> ${huesped.Correo}
        `;
    }

}

document.addEventListener("click", function(event) {
    if (event.target.closest('a[href*="eliminar-huesped"]')) {
        event.preventDefault();
        const Link = event.target.closest('a[href*="eliminar-huesped"]');
        const href = Link.getAttribute("href");
        
        if (confirm("¿Estás seguro de que deseas eliminar este huésped?")) {
            window.location.href = href;
        }
    }
});
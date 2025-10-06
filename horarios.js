const materiasPorAnio = {
  "1°": ["Lengua", "Matemática", "Ciencias Naturales"],
  "2°": ["Física", "Lengua", "Historia"],
  "3°": ["Matemática", "Biología", "Química"],
  "4°": ["Geografía", "Educación Física", "Filosofía"]
};

function abrirModal() {
  new bootstrap.Modal(document.getElementById("modalHorario")).show();
}

function verificarCedula() {
  const cedula = document.getElementById("cedulaInput").value.trim();
  if (!cedula) {
    document.getElementById("mensaje").innerHTML = `<div class="alert alert-danger">Ingrese una cédula válida.</div>`;
    return;
  }
  document.getElementById("cedulaOculta").value = cedula;
  document.getElementById("datosProfesor").innerHTML = `<div class="alert alert-success">Profesor verificado: ${cedula}</div>`;
  document.getElementById("formularioHorario").style.display = "block";
  if (document.getElementById("tablaHorarios").rows.length === 0) agregarFila();
}

document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("tipoHorarioSelect").addEventListener("change", function () {
    const tipo = this.value;
    const contenedor = document.getElementById("contenedorHoras");
    contenedor.innerHTML = "";
    if (tipo === "parcial") {
      contenedor.innerHTML = `
        <label>Total de Horas a Trabajar:</label>
        <input type="number" name="total_horas" class="form-control mb-2" required>
      `;
    }
  });
});

function agregarFila() {
  const tbody = document.getElementById("tablaHorarios");
  const fila = document.createElement("tr");
  const dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
  const anios = Object.keys(materiasPorAnio);

  const anioSel = document.createElement("select");
  anioSel.name = "anio[]";
  anioSel.className = "form-select";
  anioSel.innerHTML = `<option value="">--</option>` + anios.map(a => `<option value="${a}">${a}</option>`).join("");

  const seccion = `<input name="seccion[]" class="form-control" required />`;

  const materiaSel = document.createElement("select");
  materiaSel.name = "materia[]";
  materiaSel.className = "form-select";

  anioSel.addEventListener("change", function () {
    const m = materiasPorAnio[this.value] || [];
    materiaSel.innerHTML = m.map(op => `<option>${op}</option>`).join("") +
      `<option value="nueva">➕ Añadir nueva...</option>`;
  });

  materiaSel.addEventListener("change", function () {
    if (this.value === "nueva") {
      fila.dataset.pendienteMateria = "1";
      new bootstrap.Modal(document.getElementById("modalMateria")).show();
    }
  });

  const diaSel = `<select name="dia[]" class="form-select">${dias.map(d => `<option>${d}</option>`).join("")}</select>`;
  const horaIni = `<input type="time" name="hora_inicio[]" class="form-control" value="07:00" required />`;
  const horaFin = `<input type="time" name="hora_fin[]" class="form-control" value="07:45" required />`;
  const borrarBtn = `<button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">🗑️</button>`;

  fila.innerHTML = "<td></td><td>" + seccion + "</td><td></td><td>" + diaSel + "</td><td>" + horaIni + "</td><td>" + horaFin + "</td><td>" + borrarBtn + "</td>";
  fila.children[0].appendChild(anioSel);
  fila.children[2].appendChild(materiaSel);
  tbody.appendChild(fila);
}

function agregarMateriaDesdeModal() {
  const input = document.getElementById("nuevaMateriaInput");
  const nueva = input.value.trim();
  if (!nueva) return alert("Escribe el nombre de la materia.");
  input.value = "";
  document.querySelectorAll("tr[data-pendiente-materia='1'] select[name='materia[]']").forEach(sel => {
    const opt = new Option(nueva, nueva);
    sel.insertBefore(opt, sel.querySelector("option[value='nueva']"));
    sel.value = nueva;
    delete sel.closest("tr").dataset.pendienteMateria;
  });
  bootstrap.Modal.getInstance(document.getElementById("modalMateria")).hide();
}

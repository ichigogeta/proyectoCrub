function validarUsuario() {
    var esValido = false;
    var expregnonum = /[a-zA-Z]*[^0-9]/;
    var usuario = document.getElementById('user');
    var validar = new RegExp(expregnonum);
    if (usuario.value === "") {
        alert("No debe dejar vacio el campo usuario");
    } else {
        if (validar.test(usuario.value)) {
            esValido = true;
        } else {
            alert("El campo usuario no es válido");
        }
    }

    return esValido;
}

function iniciar() {

    var formulario = document.getElementById("validarFormulario");
    formulario.addEventListener("submit", function(event) {
        if (!validarUsuario()) {
            event.preventDefault();
        }
    });
}

window.onload = iniciar;
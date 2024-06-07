document.addEventListener('DOMContentLoaded', function () {
    var acordeonTitulos = document.querySelectorAll('.acordeon-titulo');

    acordeonTitulos.forEach(function (titulo) {
        titulo.addEventListener('click', function () {
            var contenido = this.nextElementSibling;

            if (contenido.classList.contains('abierto')) {
                contenido.classList.remove('abierto');
            } else {
                document.querySelectorAll('.acordeon-contenido').forEach(function (c) {
                    c.classList.remove('abierto');
                });
                contenido.classList.add('abierto');
            }
        });
    });

    // Inicializar Tagify en el campo de entrada de pasatiempos
    var input = document.querySelector('input[name=tags-pasatiempos]');
    new Tagify(input);
});
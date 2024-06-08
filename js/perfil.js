document.addEventListener('DOMContentLoaded', function () {
    // Inicializar Tagify en el campo de entrada de pasatiempos
    var input = document.querySelector('input[name=tags-pasatiempos]');
    new Tagify(input);
});

function toggle(titulo) {
    var acordeon = titulo.nextElementSibling;
    if (acordeon.classList.contains('close')) {
        acordeon.classList.remove('close');
        acordeon.classList.remove('max-h-0');
        acordeon.classList.add('open');
        acordeon.classList.add('max-h-[200px]');
    } else if (acordeon.classList.contains('open')) {
        acordeon.classList.remove('open');
        acordeon.classList.remove('max-h-[200px]');
        acordeon.classList.add('close');
        acordeon.classList.add('max-h-0');
    }
};
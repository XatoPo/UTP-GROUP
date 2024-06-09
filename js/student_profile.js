document.addEventListener('DOMContentLoaded', function () {
    var input = document.querySelector('input[readonly]');
    new Tagify(input);
});

function toggle(titulo) {
    var acordeon = titulo.nextElementSibling;
    var icono = titulo.querySelector('i');
    if (acordeon.classList.contains('close')) {
        acordeon.classList.remove('close');
        acordeon.classList.remove('max-h-0');
        icono.classList.remove('fa-caret-down');
        acordeon.classList.add('open');
        acordeon.classList.add('max-h-full');
        acordeon.classList.add('mt-2');
        icono.classList.add('fa-caret-up');
    } else if (acordeon.classList.contains('open')) {
        acordeon.classList.remove('open');
        acordeon.classList.remove('max-h-full');
        acordeon.classList.remove('mt-2');
        icono.classList.remove('fa-caret-up');
        acordeon.classList.add('close');
        acordeon.classList.add('max-h-0');
        icono.classList.add('fa-caret-down');
    }
};
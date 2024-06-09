src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js";


document.addEventListener('DOMContentLoaded', (event) => {
    var closeModalBtn = document.getElementById('closeModalBtn');
    var modal = document.getElementById('myModal'+idg);

    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    window.addEventListener('click', (event) => {
        if (event.target == modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });
});

function openModal(number) {
    const modal = document.getElementById('myModal');
    const modalTitle = document.getElementById('modal-title');
    const modalContent = document.getElementById('modal-content');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    modalTitle.innerHTML = 'Confirmación de entrada al grupo ' + number;
    modalContent.innerHTML = '¿Deseas entrar al grupo ' + number + '?';
}

function openProfile(id) {
    const modal = document.getElementById('myModal'+id);
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    var closeModalBtn = document.getElementById('closeModalBtn');

    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    window.addEventListener('click', (event) => {
        if (event.target == modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });
}

var idg;

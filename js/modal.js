document.addEventListener('DOMContentLoaded', (event) => {
    const closeModalBtn = document.getElementById('closeModalBtn');
    const modal = document.getElementById('myModal');

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
    const modal = document.getElementById('myModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
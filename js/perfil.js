document.addEventListener('DOMContentLoaded', function() {
    new Tagify(document.querySelector('#hobbies'));

    const toggleSection = (showId, hideId) => {
        document.getElementById(showId).classList.toggle('close');
        document.getElementById(showId).classList.toggle('open');
        document.getElementById(hideId).classList.add('close');
        document.getElementById(hideId).classList.remove('open');
    };

    document.querySelectorAll('h4.cursor-pointer').forEach(header => {
        header.addEventListener('click', () => {
            const sectionId = header.nextElementSibling.id;
            const otherSectionId = sectionId === 'skillsBlandas' ? 'skillsTecnicas' : 'skillsBlandas';
            toggleSection(sectionId, otherSectionId);
        });
    });
});
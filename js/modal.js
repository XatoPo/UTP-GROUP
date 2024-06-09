src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js";

function openModal(number) {
    const modal = document.getElementById('myModal');
    const modalTitle = document.getElementById('modal-title');
    const modalContent = document.getElementById('modal-content');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    modalTitle.innerHTML = 'Confirmación de entrada al grupo ' + number;
    modalContent.innerHTML = '¿Deseas entrar al grupo ' + number + '?';

    const closeModalBtn = document.getElementById('closeModalBtn');

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

function openProfile(id) {
    fetch("/controller/student.php?action=get_data&estudiante_id=" + id)
        .then(response => response.json())
        .then(data => {
            document.getElementById('descripcion_estudiante').innerText  = data.informacion.description;
            document.getElementById('NombreCodigoEstudiante').innerText  = data.informacion.name + ' - ' + data.informacion.student_id;
            document.getElementById('CarreraEstudiante').innerText  = data.informacion.career;


            let skills_blandas = data.skills.filter(skill => skill.skill_topic == 'Skills Blandas');
            let skills_tecnicas = data.skills.filter(skill => skill.skill_topic == 'Skills Técnicas');

            let html_skills_blandas = "";

            skills_blandas.forEach((skill, index) => {
                html_skills_blandas += `<input 
                                            name="skills_blandas['${skill['skill_id']}]" 
                                            class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" 
                                            type="text" 
                                            value="${skill['skill_name']} 
                                            placeholder="Skill ${index + 1}" readonly />
                                        `;
            });
            document.getElementById('skillsBlandasInfo').innerHTML = html_skills_blandas;

            let html_skills_tecnicas = "";

            skills_tecnicas.forEach((skill, index) => {
                html_skills_tecnicas += `<input 
                                            name="skills_blandas['${skill['skill_id']}]" 
                                            class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" 
                                            type="text" 
                                            value="${skill['skill_name']} 
                                            placeholder="Skill ${index + 1}" readonly />
                                        `;
            });
            document.getElementById('skillsTecnicasInfo').innerHTML = html_skills_tecnicas;

            document.getElementById("imagePerfil").src = base_url +"/images/perfil/" + data.informacion.profile_picture;

            document.getElementById('hobbies_text').innerText = data.hobbies.map(hobby => hobby.hobby_name).join( ', ');


            // $('#descripcion_estudiante').text(data.informacion.description);
        });
    

    const modal = document.getElementById('myModalEstudiante');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    const closeModalBtn = document.getElementById('closeModalBtn');

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

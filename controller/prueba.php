<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Estudiante</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div>
        <label for="student-id">Código del Estudiante:</label>
        <input type="text" id="student-id" name="student-id">
        <button onclick="mostrarDatosEstudiante()">Mostrar Datos</button>
    </div>

    <div id="profile-container">
        <!-- Aquí se mostrarán los datos del estudiante -->
    </div>

    <script>
        // Función para obtener y mostrar los datos del estudiante
        function mostrarDatosEstudiante() {
            var studentId = $('#student-id').val(); // Obtener el valor del campo de entrada

            $.ajax({
                url: 'controlador.php',
                type: 'GET',
                data: { opc: 2, id: studentId },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        $('#profile-container').html('<p>' + response.error + '</p>');
                    } else {
                        var studentData = response.student_data;
                        var hobbiesData = response.hobbies_data;
                        var softSkillsData = response.softskills_data;
                        var hardSkillsData = response.hardskills_data;

                        var html = '<h2>Datos del Estudiante</h2>';
                        html += '<p><strong>ID:</strong> ' + studentData.student_id + '</p>';
                        html += '<p><strong>Nombre:</strong> ' + studentData.name + '</p>';
                        html += '<h3>Hobbies</h3>';
                        html += '<ul>';
                        hobbiesData.forEach(function(hobby) {
                            html += '<li>' + hobby.hobby_name + '</li>';
                        });
                        html += '</ul>';
                        html += '<h3>Skills Blandas</h3>';
                        html += '<ul>';
                        softSkillsData.forEach(function(skill) {
                            html += '<li>' + skill.skill_name + '</li>';
                        });
                        html += '</ul>';
                        html += '<h3>Skills Técnicas</h3>';
                        html += '<ul>';
                        hardSkillsData.forEach(function(skill) {
                            html += '<li>' + skill.skill_name + '</li>';
                        });
                        html += '</ul>';

                        $('#profile-container').html(html);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
</body>
</html>

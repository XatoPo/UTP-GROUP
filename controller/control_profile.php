<?php
// control_profile.php

// Incluir el archivo DAO
include 'dao/student_dao.php';

function getProfileDataByID($student_id) {
    // Obtener los datos del estudiante llamando a la función en el DAO
    $student_data = getStudentDataById($student_id);
    $hobbies_data = getStudentHobbiesById($student_id);
    $softskills_data = getStudentSkillsById($student_id,'Skills Blandas');
    $hardskills_data = getStudentSkillsById($student_id,'Skills Técnicas');
    
    if ($student_data) {
        $profile_data = [
            'student_data' => $student_data,
            'hobbies_data' => $hobbies_data,
            'softskills_data' => $softskills_data,
            'hardskills_data' => $hardskills_data
        ];
        return json_encode($profile_data);
    } else {
        return json_encode(['error' => 'No se encontraron datos para el estudiante con ID: ' . $student_id]);
    }
}

// Verificar si se ha proporcionado una ID de estudiante a través de la URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    echo getProfileDataByID($student_id);
} else {
    echo json_encode(['error' => 'No se proporcionó una ID de estudiante']);
}
?>

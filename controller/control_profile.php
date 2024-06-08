<?php
// control_profile.php

// Incluir el archivo DAO
include 'dao/student_dao.php';

function getDataProfileByID($student_id) {
    // Obtener los datos del estudiante llamando a la función en el DAO
    $student_data = getStudentDataById($student_id);

    // Verificar si se encontraron datos del estudiante
    if ($student_data) {
        return json_encode($student_data);
    } else {
        return json_encode(['error' => 'No se encontraron datos para el estudiante con ID: ' . $student_id]);
    }
}

// Verificar si se ha proporcionado una ID de estudiante a través de la URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    echo getDataProfileByID($student_id);
} else {
    echo json_encode(['error' => 'No se proporcionó una ID de estudiante']);
}
?>

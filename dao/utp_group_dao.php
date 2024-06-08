<?php
// dao/studentDAO.php

include "../util/connection.php";

// Función para obtener los datos del estudiante según su ID
function getStudentDataById($id) {
    // Crear una conexión a la base de datos
    $conexion = new Conexion();
    $conn = $conexion->conecta();

    // Verificar si la conexión es exitosa
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Preparar la consulta SQL
    $sql = "SELECT s.* FROM students s WHERE s.student_id = ?";
    $stmt = $conn->prepare($sql);

    // Verificar si la preparación fue exitosa
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    // Vincular parámetros y ejecutar la consulta
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();
    $student_data = $result->fetch_assoc();

    // Cerrar la conexión y retornar los datos del estudiante
    $stmt->close();
    $conexion->desconecta();

    return $student_data;
}

function getStudentHobbiesById($id) {
    // Crear una conexión a la base de datos
    $conexion = new Conexion();
    $conn = $conexion->conecta();

    // Verificar si la conexión es exitosa
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Preparar la consulta SQL
    $sql = "SELECT h.hobby_id, h.hobby_name FROM students s INNER JOIN hobbies h ON s.student_id = h.student_id WHERE s.student_id = ?";
    $stmt = $conn->prepare($sql);

    // Verificar si la preparación fue exitosa
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    // Vincular parámetros y ejecutar la consulta
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();
    $hobbies_data = $result->fetch_assoc();

    // Cerrar la conexión y retornar los datos del estudiante
    $stmt->close();
    $conexion->desconecta();

    return $hobbies_data;
}

function getStudentSkillsById($id, $skill_topic) {
    // Crear una conexión a la base de datos
    $conexion = new Conexion();
    $conn = $conexion->conecta();

    // Verificar si la conexión es exitosa
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Preparar la consulta SQL
    $sql = "SELECT sk.skill_id, sk.skill_name, sk.skill_topic FROM students s INNER JOIN skills sk ON s.student_id = sk.student_id WHERE s.student_id = ? AND sk.skill_topic = ?";
    $stmt = $conn->prepare($sql);

    // Verificar si la preparación fue exitosa
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    // Vincular parámetros y ejecutar la consulta
    $stmt->bind_param("is", $id, $skill_topic);
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();
    $skills_data = $result->fetch_assoc();

    // Cerrar la conexión y retornar los datos del estudiante
    $stmt->close();
    $conexion->desconecta();

    return $skills_data;
}

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

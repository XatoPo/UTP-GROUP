<?php
// dao/studentDAO.php

include "../util/connection.php";

// Función para obtener los datos del estudiante según su ID
function getStudentDataById($id) {
    // Crear una conexión a la base de datos
    $conn = getConnection();

    // Verificar si la conexión es exitosa
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Preparar la consulta SQL
    $sql = "SELECT s.*
            FROM students s
            WHERE s.student_id = '$id';";
            
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
    $conn->close();

    return $student_data;
}

function getStudentHobbiesById($id) {
    // Crear una conexión a la base de datos
    $conn = getConnection();

    // Verificar si la conexión es exitosa
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Preparar la consulta SQL
    $sql = "SELECT h.hobby_id ,h.hobby_name 
            FROM students s
            INNER JOIN hobbies h ON s.student_id = h.student_id
            WHERE s.student_id = '$id';";
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
    $conn->close();

    return $hobbies_data;
}

function getStudentSkillsById($id,$skill_topic) {
    // Crear una conexión a la base de datos
    $conn = getConnection();

    // Verificar si la conexión es exitosa
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Preparar la consulta SQL
    $sql = "SELECT sk.skill_id, sk.skill_name, sk.skill_topic 
            FROM students s
            INNER JOIN skills sk ON s.student_id = sk.student_id
            WHERE s.student_id = '$id'
            AND sk.skill_topic = '$skill_topic';";
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
    $skills_data = $result->fetch_assoc();

    // Cerrar la conexión y retornar los datos del estudiante
    $stmt->close();
    $conn->close();

    return $skills_data;
}


?>

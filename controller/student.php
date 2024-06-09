<?php
// index.php
require_once '../dao/utp_group_dao.php';
// Función para manejar peticiones GET
function handleGetRequest() {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'get_data':
                getData();
                break;
            // Puedes añadir más casos aquí
            default:
                echo json_encode(['error' => 'Acción no reconocida']);
        }
    } else {
        echo json_encode(['error' => 'No se especificó ninguna acción']);
    }
}

// Función para manejar peticiones POST
function handlePostRequest() {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'save_data':
                saveData();
                break;
            // Puedes añadir más casos aquí
            default:
                echo json_encode(['error' => 'Acción no reconocida']);
        }
    } else {
        echo json_encode(['error' => 'No se especificó ninguna acción']);
    }
}

// Función para manejar peticiones PUT
function handlePutRequest() {
    parse_str(file_get_contents("php://input"), $_PUT);
    if (isset($_PUT['action'])) {
        switch ($_PUT['action']) {
            case 'update_data':
                updateData();
                break;
            // Puedes añadir más casos aquí
            default:
                echo json_encode(['error' => 'Acción no reconocida']);
        }
    } else {
        echo json_encode(['error' => 'No se especificó ninguna acción']);
    }
}

// Función para manejar peticiones DELETE
function handleDeleteRequest() {
    parse_str(file_get_contents("php://input"), $_DELETE);
    if (isset($_DELETE['action'])) {
        switch ($_DELETE['action']) {
            case 'delete_data':
                deleteData();
                break;
            // Puedes añadir más casos aquí
            default:
                echo json_encode(['error' => 'Acción no reconocida']);
        }
    } else {
        echo json_encode(['error' => 'No se especificó ninguna acción']);
    }
}

// Función principal para enrutar las peticiones
function routeRequest() {
    $method = $_SERVER['REQUEST_METHOD'];
    switch ($method) {
        case 'GET':
            handleGetRequest();
            break;
        case 'POST':
            handlePostRequest();
            break;
        case 'PUT':
            handlePutRequest();
            break;
        case 'DELETE':
            handleDeleteRequest();
            break;
        default:
            echo json_encode(['error' => 'Método HTTP no soportado']);
    }
}

// Función para manejar la acción 'get_data'
function getData() {
    $utp_group_dao = new utp_group_dao();
    $estudiante_id = $_GET['estudiante_id'];
    $response = [];
    $response['informacion'] = $utp_group_dao->ObtenerEstudiantePorId($estudiante_id);
    $response['skills'] = $utp_group_dao->ObtenerSkillsPorEstudiante($estudiante_id);
    $response['hobbies'] = $utp_group_dao->ObtenerHobbiesPorEstudiante($estudiante_id);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
}

// Función para manejar la acción 'save_data'
function saveData() {
    // Lógica para guardar datos
    echo json_encode(['message' => 'Datos guardados correctamente']);
}

// Función para manejar la acción 'update_data'
function updateData() {
    // Lógica para actualizar datos
    echo json_encode(['message' => 'Datos actualizados correctamente']);
}

// Función para manejar la acción 'delete_data'
function deleteData() {
    // Lógica para eliminar datos
    echo json_encode(['message' => 'Datos eliminados correctamente']);
}

// Ejecutar la función de enrutamiento
routeRequest();
?>
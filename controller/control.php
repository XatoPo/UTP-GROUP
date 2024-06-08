<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include "../dao/utp_group_dao.php";

$action = isset($_GET["opc"]) ? $_GET["opc"] : "";

switch ($action) {
    case 1:
        iniciarSesion($conn);
        break;

    case 2:
        getProfileDataByID($id);
    

    default:
        echo "This is the default case";
        break;
}

function iniciarSesion($conn) {
    session_start();
    
    if (isset($_POST['iniciar_sesion'])) {
        if (!empty($_POST['id']) && !empty($_POST['password'])) {
            $id = $_POST['id'];
            $contraseña = $_POST['password'];

            // Prepare the SQL statement
            $stmt = mysqli_prepare($conn, "SELECT student_id, password, career, name FROM students WHERE student_id = ?");
            if ($stmt === false) {
                die('Prepare failed: ' . mysqli_error($conn));
            }

            // Bind parameters
            mysqli_stmt_bind_param($stmt, "s", $id);

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                // Bind the result variables
                mysqli_stmt_bind_result($stmt, $student_id, $contraseña_db, $carrera, $nombre);
                
                // Fetch the result
                if (mysqli_stmt_fetch($stmt)) {
                    // Verify the password
                    if ($contraseña == $contraseña_db) {
                        $_SESSION['nombre'] = $nombre;
                        $_SESSION['cod_estudiante'] = $student_id;
                        $_SESSION['carrera'] = $carrera;
                        
                        header("Location: ../courses.php");
                        exit();
                    } else {
                        header("Location: ../error.php?error=contraseña");
                        exit();
                    }
                } else {
                    header("Location: ../error.php?error=usuario");
                    exit();
                }
            } else {
                die('Execute failed: ' . mysqli_error($conn));
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        }
    }
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

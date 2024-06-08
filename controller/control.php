<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include "../util/connection.php";
$action = isset($_GET["opc"]) ? $_GET["opc"] : "";

switch ($action) {
    case 1:
        iniciarSesion($conn);
        break;

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
            $stmt = mysqli_prepare($conn, "SELECT student_id, password, name FROM students WHERE student_id = ?");
            if ($stmt === false) {
                die('Prepare failed: ' . mysqli_error($conn));
            }

            // Bind parameters
            mysqli_stmt_bind_param($stmt, "s", $id);

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                // Bind the result variables
                mysqli_stmt_bind_result($stmt, $student_id, $contraseña_db, $nombre);
                
                // Fetch the result
                if (mysqli_stmt_fetch($stmt)) {
                    // Verify the password
                    if ($contraseña == $contraseña_db) {
                        $_SESSION['nombre'] = $nombre;
                        $_SESSION['cod_estudiante'] = $student_id;
                        
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

?>

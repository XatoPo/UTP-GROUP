
<?php
include_once 'dao/utp_group_dao.php';

// Comprueba si se ha recibido una solicitud y si la acción es válida
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['accion'])) {
    $utp_group_dao = new utp_group_dao();
    $accion = $_GET['accion'];
    $student_id = $_GET['student_id']; // Recoge el ID del estudiante

    // Dependiendo de la acción, llama a la función correspondiente
    switch ($accion) {
        case 'obtenerEstudiante':
            $resultado = $utp_group_dao->ObtenerEstudiantePorId($student_id);
            break;
        case 'obtenerSkills':
            $resultado = $utp_group_dao->ObtenerSkillsPorEstudiante($student_id);
            break;
        case 'obtenerHobbies':
            $resultado = $utp_group_dao->ObtenerHobbiesPorEstudiante($student_id);
            break;
        default:
            // Si la acción no es válida, devuelve un error
            $resultado = array('error' => 'Acción no válida');
            break;
    }

    // Devuelve los resultados como JSON
    echo json_encode($resultado);
    exit;
}

?>
<?php
include_once 'dao/utp_group_dao.php';
include_once 'util/connection.php';

session_start();

if (!isset($_SESSION['student_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$student_id = $_SESSION['student_id'];
$action = $_POST['action'];
$group_id = $_POST['group_id'];

$obj = new utp_group_dao();

if ($action === 'unirse') {
    $students_in_group = $obj->ObtenerAlumnosPorGrupoId($group_id);
    if (count($students_in_group) < $group_info['number_of_students']) {
        $obj->AgregarAlumnoEnGrupo($group_id, $student_id);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Group is full']);
    }
} elseif ($action === 'salir') {
    $obj->EliminarAlumnoDelGrupo($group_id, $student_id);
    echo json_encode(['success' => true]);
}
?>
